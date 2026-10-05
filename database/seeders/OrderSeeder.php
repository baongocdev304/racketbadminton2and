<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::where('role', 'customer')->first();

        // Lấy danh sách 5 cây vợt khác nhau để tạo 5 đơn hàng mẫu với các trạng thái khác nhau
        $products = Product::inRandomOrder()->limit(5)->get();

        if ($products->count() < 5) {
            return;
        }

        $sampleOrders = [
            [
                'status'         => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => 'cod',
                'customer_name'  => 'Trần Quốc Bảo',
                'customer_phone' => '0912345678',
                'customer_email' => 'bao.tran@gmail.com',
                'address'        => 'Số 15 Lê Duẩn, Quận 1',
                'city'           => 'TP. Hồ Chí Minh',
                'district'       => 'Quận 1',
                'ward'           => 'Bến Nghé',
                'note'           => 'Giao giờ hành chính giúp em ạ',
            ],
            [
                'status'         => 'confirmed',
                'payment_status' => 'unpaid',
                'payment_method' => 'cod',
                'customer_name'  => 'Lê Hoàng Nam',
                'customer_phone' => '0933445566',
                'customer_email' => 'nam.le@yahoo.com',
                'address'        => 'Tòa nhà Landmark 81, 720A Điện Biên Phủ',
                'city'           => 'TP. Hồ Chí Minh',
                'district'       => 'Bình Thạnh',
                'ward'           => 'Phường 22',
                'note'           => 'Gọi trước khi giao 15 phút',
            ],
            [
                'status'         => 'shipping',
                'payment_status' => 'paid',
                'payment_method' => 'banking',
                'customer_name'  => 'Phạm Minh Đức',
                'customer_phone' => '0977889900',
                'customer_email' => 'duc.pham@outlook.com',
                'address'        => '280 Nguyễn Đình Chiểu',
                'city'           => 'TP. Hồ Chí Minh',
                'district'       => 'Quận 3',
                'ward'           => 'Phường 6',
                'note'           => 'Đã chuyển khoản Vietcombank',
            ],
            [
                'status'         => 'completed',
                'payment_status' => 'paid',
                'payment_method' => 'banking',
                'customer_name'  => 'Nguyễn Văn Cường',
                'customer_phone' => '0988776655',
                'customer_email' => 'khachhang@gmail.com',
                'address'        => '456 Lê Văn Sỹ',
                'city'           => 'TP. Hồ Chí Minh',
                'district'       => 'Quận 3',
                'ward'           => 'Phường 14',
                'note'           => 'Vợt đánh rất đầm tay, cảm ơn shop!',
            ],
            [
                'status'         => 'cancelled',
                'payment_status' => 'unpaid',
                'payment_method' => 'cod',
                'customer_name'  => 'Võ Đình Trí',
                'customer_phone' => '0944556677',
                'customer_email' => 'tri.vo@gmail.com',
                'address'        => '12 Nguyễn Thị Minh Khai',
                'city'           => 'TP. Hồ Chí Minh',
                'district'       => 'Quận 1',
                'ward'           => 'Đa Kao',
                'note'           => 'Khách đổi ý muốn mua dòng khác',
            ],
        ];

        foreach ($sampleOrders as $index => $data) {
            $product = $products[$index];
            $shippingFee = 30000;
            $totalAmount = $product->price + $shippingFee;

            $orderCode = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(4));

            $order = Order::create([
                'user_id'           => $customer?->id,
                'order_code'        => $orderCode,
                'customer_name'     => $data['customer_name'],
                'customer_phone'    => $data['customer_phone'],
                'customer_email'    => $data['customer_email'],
                'shipping_address'  => $data['address'],
                'shipping_city'     => $data['city'],
                'shipping_district' => $data['district'],
                'shipping_ward'     => $data['ward'],
                'total_amount'      => $totalAmount,
                'shipping_fee'      => $shippingFee,
                'payment_method'    => $data['payment_method'],
                'payment_status'    => $data['payment_status'],
                'status'            => $data['status'],
                'note'              => $data['note'],
            ]);

            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $product->id,
                'product_name' => $product->name,
                'product_sku'  => $product->sku,
                'price'        => $product->price,
            ]);

            // Cập nhật trạng thái sản phẩm 2hand tương ứng
            if ($data['status'] === 'completed') {
                $product->update(['status' => 'sold']);
            } elseif (in_array($data['status'], ['pending', 'confirmed', 'shipping'])) {
                $product->update(['status' => 'reserved']);
            }
        }
    }
}
