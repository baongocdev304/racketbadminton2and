<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'slug',
        'sku',
        'condition_grade',
        'condition_percent',
        'condition_note',
        'weight_class',
        'grip_size',
        'balance',
        'flex',
        'max_tension_lbs',
        'year',
        'price',
        'original_price',
        'is_clearance',
        'status',
        'description',
        'specifications',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'condition_percent' => 'integer',
        'max_tension_lbs'   => 'integer',
        'year'              => 'integer',
        'price'             => 'integer',
        'original_price'    => 'integer',
        'is_clearance'      => 'boolean',
        'specifications'    => 'array',
    ];

    /**
     * Thương hiệu của cây vợt.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Danh mục sản phẩm.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Danh sách tất cả ảnh thực tế của cây vợt.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order', 'asc');
    }

    /**
     * Ảnh đại diện chính của sản phẩm.
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Bản ghi chi tiết đơn hàng (nếu sản phẩm này đã được bán).
     */
    public function orderItem(): HasOne
    {
        return $this->hasOne(OrderItem::class);
    }

    /**
     * Scope lọc các cây vợt đang có sẵn sàng để bán.
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope lọc các cây vợt đang được xả kho giảm giá sốc.
     */
    public function scopeClearance(Builder $query): Builder
    {
        return $query->where('is_clearance', true);
    }

    /**
     * Accessor: Định dạng giá bán chuẩn VND (VD: 1.250.000đ).
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.') . 'đ';
    }

    /**
     * Accessor: Định dạng giá gốc tham chiếu (VD: 2.500.000đ).
     */
    public function getFormattedOriginalPriceAttribute(): ?string
    {
        return $this->original_price ? number_format($this->original_price, 0, ',', '.') . 'đ' : null;
    }

    /**
     * Accessor: Tính toán tỷ lệ tiết kiệm so với giá gốc.
     */
    public function getDiscountPercentAttribute(): int
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
        }

        return 0;
    }

    /**
     * Accessor: Nhãn tiếng Việt cho trạng thái sản phẩm 2hand.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'available' => 'Còn hàng',
            'reserved'  => 'Đang giữ hàng',
            'sold'      => 'Đã bán',
            default     => 'Không xác định',
        };
    }

    /**
     * Accessor: Tên mô tả phân hạng vợt.
     */
    public function getConditionGradeLabelAttribute(): string
    {
        return match ($this->condition_grade) {
            'A'     => 'Hạng A (Siêu lướt 95-99%)',
            'B'     => 'Hạng B (Đẹp 88-94%)',
            'C'     => 'Hạng C (Khá 80-87%)',
            default => 'Hạng ' . $this->condition_grade,
        };
    }
}
