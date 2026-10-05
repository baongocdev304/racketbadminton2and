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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Khóa ngoại đến Brand và Category
            $table->foreignId('brand_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            
            // Thông tin định danh sản phẩm
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique()->comment('Mã định danh riêng cho từng cây vợt duy nhất');
            
            // Đặc thù tình trạng vợt cũ (2hand)
            $table->enum('condition_grade', ['A', 'B', 'C'])->comment('Hạng chất lượng: A (95-99%), B (88-94%), C (80-87%)');
            $table->unsignedSmallInteger('condition_percent')->comment('Độ mới thực tế tính theo % (VD: 95, 98)');
            $table->text('condition_note')->comment('Mô tả chi tiết vết xước, nứt sơn, tình trạng gen, cước...');
            
            // Thông số kỹ thuật chuyên sâu của vợt
            $table->string('weight_class')->comment('Trọng lượng: 2U, 3U, 4U, 5U');
            $table->string('grip_size')->comment('Chu vi cán cầm: G3, G4, G5, G6');
            $table->string('balance')->comment('Điểm cân bằng: Nặng đầu (Head Heavy), Cân bằng (Even Balance), Nhẹ đầu (Head Light)');
            $table->string('flex')->comment('Độ cứng đũa: Cứng (Stiff), Trung bình (Medium), Dẻo (Flexible)');
            $table->unsignedSmallInteger('max_tension_lbs')->comment('Mức căng dây tối đa khuyến nghị (lbs), VD: 28, 30');
            $table->unsignedSmallInteger('year')->nullable()->comment('Năm sản xuất / ra mắt');
            
            // Giá bán (VND) - Không dùng số lượng vì mỗi cây là độc bản (unique 1 món)
            $table->unsignedBigInteger('price')->comment('Giá bán thực tế (VND)');
            $table->unsignedBigInteger('original_price')->nullable()->comment('Giá niêm yết vợt mới hoặc giá tham chiếu');
            $table->boolean('is_clearance')->default(false)->comment('Đánh dấu hàng xả kho giá sốc');
            
            // Trạng thái độc bản: available (còn hàng), reserved (đang giữ hàng trong giỏ/chờ thanh toán), sold (đã bán)
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available')->comment('Trạng thái sản phẩm 2hand');
            
            // Nội dung bài viết chi tiết
            $table->longText('description')->nullable();
            $table->json('specifications')->nullable()->comment('JSON lưu thêm thông số kỹ thuật phụ nếu cần');
            
            $table->timestamps();
            
            // Các index tăng tốc độ truy vấn tìm kiếm, lọc và phân trang
            $table->index('slug');
            $table->index('status');
            $table->index('brand_id');
            $table->index('category_id');
            $table->index(['status', 'brand_id']);
            $table->index(['status', 'category_id']);
            $table->index('is_clearance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
