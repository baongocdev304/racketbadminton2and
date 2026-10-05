<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    /**
     * Hiển thị trang thanh toán (Checkout)
     */
    public function index(): View|RedirectResponse
    {
        $products = $this->cartService->getCartProducts();

        if ($products->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Giỏ hàng của bạn đang trống. Vui lòng chọn cây vợt ưng ý trước khi thanh toán.');
        }

        // Kiểm tra xem có cây vợt nào trong giỏ đã bị người khác mua không
        $unavailableProducts = $products->filter(fn ($p) => $p->status !== 'available');
        if ($unavailableProducts->isNotEmpty()) {
            $names = $unavailableProducts->pluck('name')->join(', ');
            return redirect()->route('cart.index')->with('error', "Rất tiếc! Cây vợt [{$names}] vừa có khách đặt trước. Vui lòng bỏ khỏi giỏ hàng.");
        }

        $subtotal = $this->cartService->total();
        $shippingFee = ($subtotal >= 2000000) ? 0 : 30000;
        $total = $subtotal + $shippingFee;

        // Thông tin tài khoản ngân hàng để chuyển khoản (kèm VietQR mẫu)
        $bankInfo = [
            'bank_name'      => 'MB Bank (Ngân Hàng Quân Đội)',
            'account_number' => '0901234567',
            'account_name'   => 'NGUYEN BAO NGOC',
            'branch'         => 'Chi nhánh Quận 10, TP.HCM',
        ];

        $user = Auth::user();

        return view('checkout.index', compact('products', 'subtotal', 'shippingFee', 'total', 'bankInfo', 'user'));
    }

    /**
     * Xử lý đặt hàng: DÙNG DB TRANSACTION + lockForUpdate ĐỂ CHỐNG BÁN TRÙNG VỢT 2HAND
     */
    public function process(CheckoutRequest $request): RedirectResponse
    {
        $productIds = $this->cartService->getProductIds();

        if (empty($productIds)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng đang trống.');
        }

        try {
            $order = DB::transaction(function () use ($request, $productIds) {
                
                // 1. KHÓA TẤT CẢ SẢN PHẨM TRONG GIỎ ĐỂ KIỂM TRA ĐỘC BẢN CONCURRENCY
                // Lệnh lockForUpdate() của PostgreSQL ngăn chặn việc 2 khách hàng cùng chốt 1 cây vợt độc bản
                $lockedProducts = Product::whereIn('id', $productIds)
                    ->lockForUpdate()
                    ->get();

                // 2. Kiểm tra tính khả dụng: Nếu cây vợt không còn 'available', lập tức rollback và thông báo
                foreach ($productIds as $id) {
                    $item = $lockedProducts->firstWhere('id', $id);

                    if (!$item || $item->status !== 'available') {
                        $name = $item ? $item->name : "Mã #{$id}";
                        throw new \Exception("Rất tiếc! Cây vợt \"{$name}\" vừa được một khách hàng khác hoàn tất thanh toán trước bạn vài giây. Vì là hàng 2hand độc bản, đơn hàng không thể tạo trùng.");
                    }
                }

                // 3. Tính toán tài chính
                $subtotal = $lockedProducts->sum('price');
                $shippingFee = ($subtotal >= 2000000) ? 0 : 30000;
                $totalAmount = $subtotal + $shippingFee;

                // 4. Sinh mã đơn hàng chuẩn định dạng: ORD-YYYYMMDD-XXXX
                $orderCode = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

                // 5. Tạo đơn hàng mới trong cơ sở dữ liệu
                $order = Order::create([
                    'user_id'           => Auth::id(),
                    'order_code'        => $orderCode,
                    'customer_name'     => $request->validated('customer_name'),
                    'customer_phone'    => $request->validated('customer_phone'),
                    'customer_email'    => $request->validated('customer_email'),
                    'shipping_address'  => $request->validated('shipping_address'),
                    'shipping_city'     => $request->validated('shipping_city'),
                    'shipping_district' => $request->validated('shipping_district'),
                    'shipping_ward'     => $request->validated('shipping_ward'),
                    'total_amount'      => $totalAmount,
                    'shipping_fee'      => $shippingFee,
                    'payment_method'    => $request->validated('payment_method'),
                    'payment_status'    => 'unpaid',
                    'status'            => 'pending',
                    'note'              => $request->validated('note'),
                ]);

                // 6. Lưu snapshot thông tin sản phẩm tại thời điểm mua & Cập nhật trạng thái sản phẩm 2hand
                $newProductStatus = ($request->validated('payment_method') === 'banking') ? 'reserved' : 'sold';

                foreach ($lockedProducts as $product) {
                    OrderItem::create([
                        'order_id'     => $order->id,
                        'product_id'   => $product->id,
                        'product_name' => $product->name, // Snapshot tên sản phẩm
                        'product_sku'  => $product->sku,  // Snapshot SKU
                        'price'        => $product->price,// Snapshot giá chốt bán
                    ]);

                    // Cập nhật trạng thái cây vợt (không còn available nữa)
                    $product->update([
                        'status' => $newProductStatus,
                    ]);
                }

                return $order;
            });

            // 7. Xóa sạch giỏ hàng sau khi chốt đơn thành công
            $this->cartService->clear();

            return redirect()->route('checkout.success', ['order_code' => $order->order_code])
                ->with('success', 'Chúc mừng bạn đã đặt hàng thành công!');

        } catch (\Exception $e) {
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Trang Cảm ơn sau khi đặt hàng thành công
     */
    public function success(string $order_code): View
    {
        $order = Order::with('items')->where('order_code', $order_code)->firstOrFail();

        // Tạo mã QR VietQR tự động nếu khách chọn chuyển khoản
        $vietQrUrl = null;
        if ($order->payment_method === 'banking') {
            $accountNumber = '0901234567';
            $bankCode = 'MB'; // MB Bank
            $transferContent = urlencode($order->order_code . ' ' . $order->customer_phone);
            $vietQrUrl = "https://img.vietqr.io/image/{$bankCode}-{$accountNumber}-compact2.png?amount={$order->total_amount}&addInfo={$transferContent}&accountName=NGUYEN%20BAO%20NGOC";
        }

        return view('checkout.success', compact('order', 'vietQrUrl'));
    }
}
