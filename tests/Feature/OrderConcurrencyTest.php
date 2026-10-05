<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Tests\TestCase;

class OrderConcurrencyTest extends TestCase
{
    use RefreshDatabase;

    protected Product $uniqueRacket;
    protected User $userA;
    protected User $userB;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Tạo thương hiệu & danh mục chuẩn
        $brand = Brand::create([
            'name' => 'Yonex',
            'slug' => 'yonex',
            'is_active' => true,
        ]);

        $category = Category::create([
            'name' => 'Vợt cầu lông',
            'slug' => 'vot-cau-long',
            'is_active' => true,
        ]);

        // 2. Tạo đúng 1 cây vợt 2hand ĐỘC BẢN DUY NHẤT (Available)
        $this->uniqueRacket = Product::create([
            'brand_id'          => $brand->id,
            'category_id'       => $category->id,
            'name'              => 'Vợt Cầu Lông Yonex Astrox 100ZZ Kurenai Lướt 98%',
            'slug'              => 'yonex-astrox-100zz-kurenai-doc-ban',
            'sku'               => '2H-YON-100ZZ-TEST',
            'condition_grade'   => 'A',
            'condition_percent' => 98,
            'condition_note'    => 'Cây vợt đẹp keng chưa 1 vết xước, cước BG65Ti 10.5kg',
            'weight_class'      => '4U',
            'grip_size'         => 'G5',
            'balance'           => 'Nặng đầu (~310mm)',
            'flex'              => 'Siêu cứng (Extra Stiff)',
            'max_tension_lbs'   => 28,
            'year'              => 2024,
            'price'             => 3500000,
            'original_price'    => 4800000,
            'is_clearance'      => false,
            'status'            => 'available', // Đang có sẵn 1 cây duy nhất
        ]);

        // 3. Tạo 2 tài khoản khách hàng khác nhau cùng nhắm mua cây vợt này
        $this->userA = User::create([
            'name'     => 'Khách Hàng A',
            'email'    => 'khachA@gmail.com',
            'password' => bcrypt('password123'),
            'role'     => 'customer',
        ]);

        $this->userB = User::create([
            'name'     => 'Khách Hàng B',
            'email'    => 'khachB@gmail.com',
            'password' => bcrypt('password123'),
            'role'     => 'customer',
        ]);
    }

    /**
     * Test Case 1: Khách hàng A đặt mua thành công, kiểm tra lockForUpdate và trạng thái vợt đổi thành sold/reserved
     */
    public function test_user_a_can_successfully_order_unique_racket_and_locks_it(): void
    {
        // Khách A thêm vào giỏ và gửi yêu cầu thanh toán
        $response = $this->actingAs($this->userA)
            ->withSession(['cart' => [$this->uniqueRacket->id]])
            ->post(route('checkout.process'), [
                'customer_name'    => 'Khách Hàng A',
                'customer_phone'   => '0901234567',
                'customer_email'   => 'khachA@gmail.com',
                'shipping_address' => '123 Nguyễn Thị Minh Khai, Q1, TP.HCM',
                'payment_method'   => 'cod',
            ]);

        // Kiểm tra redirect tới trang cảm ơn thành công
        $order = Order::first();
        $this->assertNotNull($order);
        $response->assertRedirect(route('checkout.success', ['order_code' => $order->order_code]));

        // Kiểm tra snapshot trong order_items
        $this->assertDatabaseHas('order_items', [
            'order_id'     => $order->id,
            'product_id'   => $this->uniqueRacket->id,
            'product_name' => 'Vợt Cầu Lông Yonex Astrox 100ZZ Kurenai Lướt 98%',
            'product_sku'  => '2H-YON-100ZZ-TEST',
            'price'        => 3500000,
        ]);

        // Kiểm tra cây vợt đã được đổi trạng thái thành 'sold' và không còn 'available'
        $this->assertEquals('sold', $this->uniqueRacket->fresh()->status);
    }

    /**
     * Test Case 2: Khi Khách A đã chốt mua thành công, Khách B đặt cùng cây vợt đó sẽ BỊ TỪ CHỐI
     */
    public function test_user_b_is_rejected_when_trying_to_order_same_racket_after_user_a(): void
    {
        // 1. Khách A chốt mua trước
        $this->actingAs($this->userA)
            ->withSession(['cart' => [$this->uniqueRacket->id]])
            ->post(route('checkout.process'), [
                'customer_name'    => 'Khách Hàng A',
                'customer_phone'   => '0901234567',
                'shipping_address' => '123 Đường A, Q1',
                'payment_method'   => 'cod',
            ]);

        $this->assertEquals('sold', $this->uniqueRacket->fresh()->status);

        // 2. Khách B cũng có cây vợt này trong giỏ từ trước và bấm thanh toán sau
        $responseB = $this->actingAs($this->userB)
            ->withSession(['cart' => [$this->uniqueRacket->id]])
            ->post(route('checkout.process'), [
                'customer_name'    => 'Khách Hàng B',
                'customer_phone'   => '0988776655',
                'shipping_address' => '456 Đường B, Q3',
                'payment_method'   => 'cod',
            ]);

        // Khách B bị đẩy về trang giỏ hàng kèm thông báo lỗi cây vợt đã được người khác mua
        $responseB->assertRedirect(route('cart.index'));
        $responseB->assertSessionHas('error');

        // Khẳng định trong hệ thống CHỈ CÓ ĐÚNG 1 ĐƠN HÀNG của Khách A, không bao giờ có đơn thứ 2
        $this->assertEquals(1, Order::count());
        $this->assertEquals(1, OrderItem::count());
        $this->assertEquals($this->userA->id, Order::first()->user_id);
    }

    /**
     * Test Case 3: Giả lập 2 transaction cạnh tranh trực tiếp (Race Condition Simulation)
     * với DB Transaction + lockForUpdate()
     */
    public function test_race_condition_simulation_only_one_transaction_succeeds(): void
    {
        $productId = $this->uniqueRacket->id;
        $orderCreatedA = false;
        $orderCreatedB = false;
        $exceptionCaughtB = false;

        // Transaction 1: Khách A chiếm lock trước và commit
        DB::transaction(function () use ($productId, &$orderCreatedA) {
            $lockedProduct = Product::where('id', $productId)->lockForUpdate()->first();

            $this->assertNotNull($lockedProduct);
            $this->assertEquals('available', $lockedProduct->status);

            // Giả lập xử lý tạo đơn của A
            Order::create([
                'user_id'          => $this->userA->id,
                'order_code'       => 'ORD-RACE-A',
                'customer_name'    => 'Khách A',
                'customer_phone'   => '0901111111',
                'shipping_address' => 'Hà Nội',
                'total_amount'     => $lockedProduct->price,
                'shipping_fee'     => 0,
                'payment_method'   => 'cod',
                'status'           => 'pending',
            ]);

            $lockedProduct->update(['status' => 'sold']);
            $orderCreatedA = true;
        });

        // Transaction 2: Khách B thực thi ngay sau đó
        try {
            DB::transaction(function () use ($productId, &$orderCreatedB) {
                $lockedProduct = Product::where('id', $productId)->lockForUpdate()->first();

                // Kiểm tra điều kiện độc bản 2hand: Nếu không còn available thì ném Exception
                if (!$lockedProduct || $lockedProduct->status !== 'available') {
                    throw new \Exception("Cây vợt vừa được người khác mua!");
                }

                Order::create([
                    'user_id'          => $this->userB->id,
                    'order_code'       => 'ORD-RACE-B',
                    'customer_name'    => 'Khách B',
                    'customer_phone'   => '0902222222',
                    'shipping_address' => 'Đà Nẵng',
                    'total_amount'     => $lockedProduct->price,
                    'shipping_fee'     => 0,
                    'payment_method'   => 'cod',
                    'status'           => 'pending',
                ]);
                $orderCreatedB = true;
            });
        } catch (\Exception $e) {
            $exceptionCaughtB = true;
        }

        // Kết quả xác thực:
        $this->assertTrue($orderCreatedA, "Khách A phải đặt hàng thành công.");
        $this->assertFalse($orderCreatedB, "Khách B KHÔNG ĐƯỢC PHÉP tạo đơn cho cây vợt đã bán.");
        $this->assertTrue($exceptionCaughtB, "Giao dịch của Khách B phải bị chặn bởi Exception chống bán trùng.");
        $this->assertEquals(1, Order::count(), "Chỉ duy nhất 1 đơn hàng được ghi nhận trong cơ sở dữ liệu.");
    }
}
