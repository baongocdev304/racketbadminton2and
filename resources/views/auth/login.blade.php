@extends('layouts.app')

@section('title', 'Đăng Nhập Tài Khoản - Vợt Cầu Lông 2Hand')

@section('content')
<div class="max-w-md mx-auto px-4 py-12 sm:py-16">
    <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
        
        <div class="text-center mb-6">
            <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900">Đăng Nhập</h1>
            <p class="text-xs text-slate-500 mt-1">Quản lý lịch sử đơn mua vợt và cập nhật vợt lướt mới về</p>
        </div>

        @if($errors->any())
            <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Địa chỉ Email</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus
                       placeholder="VD: cuong.nguyen@gmail.com"
                       class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Mật khẩu</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required 
                       placeholder="••••••••"
                       class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded text-brand-600 focus:ring-brand-500 mr-2">
                    <span>Ghi nhớ đăng nhập</span>
                </label>
            </div>

            <button type="submit" 
                    class="w-full py-3.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-brand-600/30 transition-all">
                Đăng Nhập
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-100 text-center text-xs text-slate-500">
            Chưa có tài khoản? 
            <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:underline">
                Đăng ký thành viên mới
            </a>
        </div>

    </div>
</div>
@endsection
