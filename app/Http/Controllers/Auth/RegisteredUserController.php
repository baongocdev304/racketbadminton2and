<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Hiển thị giao diện đăng ký tài khoản khách hàng
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Xử lý đăng ký tài khoản mới
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone'    => ['nullable', 'string', 'regex:/^(0[3|5|7|8|9])[0-9]{8}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required'      => 'Vui lòng nhập họ và tên của bạn.',
            'email.required'     => 'Vui lòng nhập địa chỉ email.',
            'email.email'        => 'Địa chỉ email không hợp lệ.',
            'email.unique'       => 'Địa chỉ email này đã được đăng ký tài khoản trước đó.',
            'phone.regex'        => 'Số điện thoại không đúng định dạng (VD: 0901234567).',
            'password.required'  => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp.',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer', // Mặc định khách hàng
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Đăng ký tài khoản thành công! Bạn có thể lưu trữ lịch sử đơn hàng và theo dõi vợt yêu thích.');
    }
}
