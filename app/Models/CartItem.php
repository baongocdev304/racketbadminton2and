<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * Người dùng sở hữu mục trong giỏ.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Cây vợt liên kết.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
