<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_sku',
        'price',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'integer',
    ];

    /**
     * Thuộc về đơn hàng.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Cây vợt liên kết (có thể đã sold).
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor: Định dạng giá thời điểm mua.
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.') . 'đ';
    }
}
