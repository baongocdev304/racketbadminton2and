@extends('layouts.app')

@section('title', 'Giỏ Hàng Của Bạn - Vợt Cầu Lông 2Hand')

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-900 font-bold">Giỏ hàng của bạn</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">GIỎ HÀNG CỦA BẠN</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Lưu ý: Hàng 2hand mỗi cây vợt là độc bản duy nhất, bạn nên tiến hành thanh toán sớm để không bị người khác chốt trước.
            </p>
        </div>

        @if(session('error'))
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-start gap-3">
                <svg class="w-5 h-5 flex-shrink-0 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <div>
                    <strong class="font-bold block">Thông báo giữ hàng:</strong>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($products->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm max-w-xl mx-auto">
                <div class="w-20 h-20 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <h2 class="text-xl font-extrabold text-slate-900 mb-2">Giỏ hàng của bạn đang trống</h2>
                <p class="text-xs text-slate-500 mb-6 leading-relaxed">
                    Bạn chưa chọn cây vợt nào. Hàng trăm cây vợt 2hand Yonex, Victor, Lining chính hãng đang chờ bạn khám phá!
                </p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs uppercase tracking-wider shadow-lg shadow-brand-600/30 transition-all">
                    <span>Xem Danh Sách Vợt Cũ</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- DANH SÁCH SẢN PHẨM TRONG GIỎ (8 COLS) -->
                <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                        <span class="font-extrabold text-sm text-slate-900">
                            Danh sách cây vợt bạn đã chọn ({{ $products->count() }})
                        </span>
                        
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn làm trống toàn bộ giỏ hàng?');">
                            @csrf
                            <button type="submit" class="text-xs text-slate-400 hover:text-red-600 font-medium transition-colors">
                                Xóa tất cả
                            </button>
                        </form>
                    </div>

                    <div class="divide-y divide-slate-100">
                        @foreach($products as $item)
                            @php
                                $img = $item->primaryImage?->image_path ?? '/images/placeholder-racket.png';
                                if (!str_starts_with($img, 'http') && !str_starts_with($img, '/images/')) {
                                    $img = asset('storage/' . $img);
                                }
                            @endphp

                            <div class="p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <a href="{{ route('products.show', ['slug' => $item->slug]) }}" class="w-20 h-20 rounded-2xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-100">
                                        <img src="{{ $img }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                    </a>

                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] font-bold uppercase tracking-wider text-brand-600 bg-brand-50 px-2 py-0.5 rounded">
                                                {{ $item->brand->name }}
                                            </span>
                                            <span class="text-xs font-mono text-slate-500">Mã: {{ $item->sku }}</span>
                                        </div>

                                        <h3 class="font-bold text-sm text-slate-900 hover:text-brand-600 transition-colors">
                                            <a href="{{ route('products.show', ['slug' => $item->slug]) }}">
                                                {{ $item->name }}
                                            </a>
                                        </h3>

                                        <div class="flex items-center gap-2 text-xs text-slate-500">
                                            <span class="font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">
                                                Hạng {{ $item->condition_grade }} ({{ $item->condition_percent }}%)
                                            </span>
                                            <span>•</span>
                                            <span>{{ $item->weight_class }} - {{ $item->grip_size }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto pt-2 sm:pt-0 border-t sm:border-0 border-slate-100">
                                    <div class="text-right">
                                        <span class="text-base font-black text-red-600">
                                            {{ $item->formatted_price }}
                                        </span>
                                        @if($item->original_price && $item->original_price > $item->price)
                                            <span class="block text-[11px] text-slate-400 line-through">
                                                {{ $item->formatted_original_price }}
                                            </span>
                                        @endif
                                    </div>

                                    <form action="{{ route('cart.remove', ['id' => $item->id]) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="text-xs text-slate-400 hover:text-red-600 flex items-center gap-1 font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            <span>Bỏ cây này</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs">
                        <a href="{{ route('products.index') }}" class="font-bold text-slate-600 hover:text-brand-600 flex items-center gap-1">
                            &larr; Chọn thêm cây vợt khác
                        </a>
                        <span class="text-slate-500">Mỗi sản phẩm là hàng 1 món duy nhất</span>
                    </div>
                </div>

                <!-- TÓM TẮT & TIẾN HÀNH THANH TOÁN (4 COLS) -->
                <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-6">
                    <h3 class="font-extrabold text-base text-slate-900 uppercase tracking-wider pb-3 border-b border-slate-100">
                        Tóm Tắt Đơn Hàng
                    </h3>

                    <div class="space-y-3 text-xs text-slate-600">
                        <div class="flex justify-between">
                            <span>Tạm tính tiền vợt:</span>
                            <span class="font-bold text-slate-900">{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span>Phí vận chuyển toàn quốc:</span>
                            @if($shippingFee === 0)
                                <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">MIỄN PHÍ</span>
                            @else
                                <span class="font-bold text-slate-900">{{ number_format($shippingFee, 0, ',', '.') }}đ</span>
                            @endif
                        </div>

                        @if($subtotal < 2000000 && $subtotal > 0)
                            <p class="text-[11px] text-amber-700 bg-amber-50 p-2 rounded-lg">
                                💡 Mua thêm <strong>{{ number_format(2000000 - $subtotal, 0, ',', '.') }}đ</strong> để được <strong>FREESHIP</strong> toàn quốc!
                            </p>
                        @endif
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-between items-baseline">
                        <span class="font-bold text-sm text-slate-900">Tổng thanh toán:</span>
                        <span class="text-2xl font-black text-red-600">
                            {{ number_format($total, 0, ',', '.') }}đ
                        </span>
                    </div>

                    <a href="{{ route('checkout.index') }}" 
                       class="w-full py-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm text-center uppercase tracking-wider shadow-lg shadow-brand-600/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        <span>Tiến Hành Đặt Hàng</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>

                    <div class="text-[11px] text-slate-400 space-y-1.5 pt-2">
                        <p class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Được mở hộp kiểm tra đúng cây vợt trước khi trả tiền</p>
                        <p class="flex items-center gap-1.5"><span class="text-emerald-500 font-bold">✓</span> Cam kết 100% phôi carbon nguyên zin - Bao test 7 ngày</p>
                    </div>
                </div>

            </div>
        @endif

    </div>

@endsection
