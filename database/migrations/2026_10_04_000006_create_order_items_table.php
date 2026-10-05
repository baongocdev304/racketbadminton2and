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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            
            // Không cascade delete product để giữ lịch sử đơn hàng
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            
            // Lưu snapshot thông tin sản phẩm tại thời điểm chốt đơn
            $table->string('product_name');
            $table->string('product_sku');
            $table->unsignedBigInteger('price')->comment('Giá bán tại thời điểm đặt hàng');
            
            $table->timestamps();
            
            $table->index(['order_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
