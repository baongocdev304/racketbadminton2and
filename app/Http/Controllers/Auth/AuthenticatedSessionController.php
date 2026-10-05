<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Hiển thị giao diện đăng nhập
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Xử lý xác thực người dùng đăng nhập
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required'    => 'Vui lòng nhập địa chỉ email.',
            'email.email'       => 'Địa chỉ email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'Email hoặc mật khẩu không chính xác. Vui lòng thử lại.',
            ]);
        }

        $request->session()->regenerate();

        // Nếu là admin đăng nhập từ form khách, chuyển hướng đến admin
        if (Auth::user()->isAdmin()) {
            return redirect()->intended('/admin');
        }

        return redirect()->intended(route('home'))->with('success', 'Đăng nhập thành công! Chào mừng bạn quay trở lại.');
    }

    /**
     * Xử lý đăng xuất
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Đã đăng xuất tài khoản thành công.');
    }
}
