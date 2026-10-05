<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tài khoản Quản trị viên (Admin)
        User::updateOrCreate(
            ['email' => 'admin@racket2hand.vn'],
            [
                'name'              => 'Quản Trị Viên',
                'password'          => Hash::make('Admin@123456'),
                'phone'             => '0901234567',
                'address'           => '123 Đường Cầu Lông, Quận 10, TP. Hồ Chí Minh',
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Tài khoản Khách hàng mẫu
        User::updateOrCreate(
            ['email' => 'khachhang@gmail.com'],
            [
                'name'              => 'Nguyễn Văn Cường',
                'password'          => Hash::make('Password@123'),
                'phone'             => '0988776655',
                'address'           => '456 Lê Văn Sỹ, Phường 14, Quận 3, TP. Hồ Chí Minh',
                'role'              => 'customer',
                'email_verified_at' => now(),
            ]
        );
    }
}
