<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'order_code',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'shipping_city',
        'shipping_district',
        'shipping_ward',
        'total_amount',
        'shipping_fee',
        'payment_method',
        'payment_status',
        'status',
        'note',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'integer',
        'shipping_fee' => 'integer',
    ];

    /**
     * Tài khoản người dùng đã đặt đơn (nếu có đăng nhập).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Danh sách sản phẩm trong đơn hàng.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Accessor: Định dạng tổng tiền (VND).
     */
    public function getFormattedTotalAttribute(): string
    {
        return number_format($this->total_amount, 0, ',', '.') . 'đ';
    }

    /**
     * Accessor: Nhãn trạng thái đơn hàng tiếng Việt.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'   => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'shipping'  => 'Đang giao hàng',
            'completed' => 'Hoàn tất',
            'cancelled' => 'Đã hủy',
            default     => $this->status,
        };
    }
}
