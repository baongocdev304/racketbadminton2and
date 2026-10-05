@extends('layouts.app')

@section('title', 'Đăng Ký Tài Khoản - Vợt Cầu Lông 2Hand')

@section('content')
<div class="max-w-md mx-auto px-4 py-12 sm:py-16">
    <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm">
        
        <div class="text-center mb-6">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900">Đăng Ký Tài Khoản</h1>
            <p class="text-xs text-slate-500 mt-1">Trở thành thành viên để nhận thông báo vợt mới về sớm nhất</p>
        </div>

        @if($errors->any())
            <div class="mb-5 p-3.5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 mb-1">Họ và tên <span class="text-red-500">*</span></label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       required 
                       placeholder="VD: Nguyễn Văn Cường"
                       class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Địa chỉ Email <span class="text-red-500">*</span></label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}" 
                       required 
                       placeholder="VD: cuong.nguyen@gmail.com"
                       class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">
            </div>

            <div>
                <label for="phone" class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại liên hệ</label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       value="{{ old('phone') }}" 
                       placeholder="VD: 0901234567"
                       class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Mật khẩu (Tối thiểu 8 ký tự) <span class="text-red-500">*</span></label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required 
                       placeholder="••••••••"
                       class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1">Xác nhận mật khẩu <span class="text-red-500">*</span></label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required 
                       placeholder="••••••••"
                       class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">
            </div>

            <button type="submit" 
                    class="w-full py-3.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-md shadow-brand-600/30 transition-all">
                Tạo Tài Khoản
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-100 text-center text-xs text-slate-500">
            Đã có tài khoản? 
            <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:underline">
                Đăng nhập ngay
            </a>
        </div>

    </div>
</div>
@endsection
