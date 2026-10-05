<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    /**
     * Các trường được gán giá trị hàng loạt (Mass Assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role', // 'admin' hoặc 'customer'
    ];

    /**
     * Các trường ẩn khi serialize model.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Ép kiểu dữ liệu (Casts).
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Kiểm tra người dùng có phải là Quản trị viên (Admin) hay không.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Phân quyền truy cập Filament Admin Panel: Chỉ cho phép tài khoản role = 'admin'.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin();
    }

    /**
     * Danh sách đơn hàng mà người dùng này đã đặt.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Danh sách bài viết tin tức do người dùng đăng tải.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
