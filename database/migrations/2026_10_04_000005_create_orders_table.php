<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('order_code')->unique()->index()->comment('Mã đơn hàng, VD: ORD-20261004-9842');
            
            // Thông tin người nhận
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->string('shipping_address');
            $table->string('shipping_city')->nullable();
            $table->string('shipping_district')->nullable();
            $table->string('shipping_ward')->nullable();
            
            // Tài chính & Thanh toán
            $table->unsignedBigInteger('total_amount')->comment('Tổng tiền đơn hàng (VND)');
            $table->unsignedBigInteger('shipping_fee')->default(0)->comment('Phí vận chuyển (VND)');
            $table->string('payment_method')->default('cod')->comment('cod, banking, vnpay...');
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid');
            
            // Trạng thái đơn hàng
            $table->enum('status', ['pending', 'confirmed', 'shipping', 'completed', 'cancelled'])->default('pending');
            $table->text('note')->nullable()->comment('Ghi chú của khách hàng khi đặt hàng');
            
            $table->timestamps();
            
            $table->index('status');
            $table->index('payment_status');
            $table->index('customer_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
