<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    /**
     * Xem giỏ hàng
     */
    public function index(): View
    {
        $products = $this->cartService->getCartProducts();
        $subtotal = $this->cartService->total();
        // Miễn phí ship cho đơn từ 2 triệu, dưới 2 triệu phí 30.000đ
        $shippingFee = ($subtotal >= 2000000 || $subtotal === 0) ? 0 : 30000;
        $total = $subtotal + $shippingFee;

        return view('cart.index', compact('products', 'subtotal', 'shippingFee', 'total'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng (Hỗ trợ cả AJAX Popup và Form thông thường)
     */
    public function add(AddToCartRequest $request): JsonResponse|RedirectResponse
    {
        try {
            $product = $this->cartService->add((int) $request->validated('product_id'));

            $message = "Đã thêm cây vợt \"{$product->name}\" vào giỏ hàng!";

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success'    => true,
                    'message'    => $message,
                    'cart_count' => $this->cartService->count(),
                    'product'    => [
                        'id'         => $product->id,
                        'name'       => $product->name,
                        'sku'        => $product->sku,
                        'price'      => $product->formatted_price,
                        'grade'      => $product->condition_grade,
                        'percent'    => $product->condition_percent,
                        'image'      => $product->primaryImage?->image_path ?? '/images/placeholder-racket.png',
                    ],
                ]);
            }

            // Nếu người dùng bấm "Mua ngay"
            if ($request->boolean('buy_now')) {
                return redirect()->route('checkout.index');
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 422);
            }

            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function remove(int $productId, Request $request): JsonResponse|RedirectResponse
    {
        $this->cartService->remove($productId);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success'    => true,
                'message'    => 'Đã xóa sản phẩm khỏi giỏ hàng.',
                'cart_count' => $this->cartService->count(),
            ]);
        }

        return back()->with('success', 'Đã xóa cây vợt khỏi giỏ hàng.');
    }

    /**
     * Xóa sạch toàn bộ giỏ hàng
     */
    public function clear(): RedirectResponse
    {
        $this->cartService->clear();

        return redirect()->route('cart.index')->with('success', 'Đã làm trống giỏ hàng.');
    }
}
