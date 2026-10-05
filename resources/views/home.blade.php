@extends('layouts.app')

@section('title', 'Vợt Cầu Lông 2Hand - Chuyên Vợt Cũ Chính Hãng Tuyển Chọn Giá Tốt Nhất')

@section('content')

    <!-- 1. HERO BANNER SLIDER (Alpine.js) -->
    <div class="bg-slate-950 overflow-hidden" 
         x-data="{
            current: 0,
            banners: {{ json_encode($heroBanners->map(fn($b) => [
                'title' => $b->title,
                'image' => $b->image_path,
                'link'  => $b->link_url ?? route('products.index'),
            ])) }},
            timer: null,
            start() {
                this.timer = setInterval(() => {
                    this.current = (this.current + 1) % this.banners.length;
                }, 5000);
            },
            stop() {
                clearInterval(this.timer);
            }
         }" 
         x-init="start()" 
         @mouseenter="stop()" 
         @mouseleave="start()">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
            <div class="relative rounded-2xl sm:rounded-3xl overflow-hidden aspect-[21/9] sm:aspect-[24/9] bg-slate-900 shadow-2xl border border-slate-800">
                
                <template x-for="(banner, index) in banners" :key="index">
                    <div x-show="current === index" 
                         x-transition:enter="transition ease-out duration-700"
                         x-transition:enter-start="opacity-0 scale-105"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute inset-0">
                        <img :src="banner.image" 
                             :alt="banner.title" 
                             class="w-full h-full object-cover object-center opacity-70">
                        
                        <!-- Overlay gradient & Content -->
                        <div class="absolute inset-0 bg-gradient-to-t sm:bg-gradient-to-r from-slate-950 via-slate-950/70 to-transparent flex items-center">
                            <div class="p-6 sm:p-12 max-w-xl">
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-600/90 text-white text-[11px] font-black uppercase tracking-wider mb-3">
                                    <span>⚡ KHO HÀNG ĐỘC BẢN 2HAND</span>
                                </div>
                                <h2 class="text-xl sm:text-3xl md:text-4xl font-extrabold text-white leading-tight mb-4" x-text="banner.title"></h2>
                                <p class="hidden sm:block text-slate-300 text-sm mb-6 leading-relaxed">
                                    Thẩm định chất lượng phôi carbon 100%, chụp ảnh chi tiết từng góc xước, cam kết không hàn nhiệt, bao test 7 ngày sân cầu.
                                </p>
                                <a :href="banner.link" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-bold text-sm shadow-lg shadow-brand-600/40 hover:scale-105 transition-all">
                                    <span>Xem Ngay Bộ Sưu Tập</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Navigation Arrows -->
                <button @click="current = (current - 1 + banners.length) % banners.length" 
                        class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/40 hover:bg-black/80 text-white flex items-center justify-center backdrop-blur-sm transition-colors" aria-label="Previous">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button @click="current = (current + 1) % banners.length" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/40 hover:bg-black/80 text-white flex items-center justify-center backdrop-blur-sm transition-colors" aria-label="Next">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </button>

                <!-- Slider Dots -->
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-2">
                    <template x-for="(b, i) in banners" :key="i">
                        <button @click="current = i" 
                                class="h-2 rounded-full transition-all"
                                :class="current === i ? 'w-6 bg-brand-500' : 'w-2 bg-white/40'"></button>
                    </template>
                </div>

            </div>
        </div>
    </div>

    <!-- 2. DẢI 4 CHÍNH SÁCH CAM KẾT VÀNG -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-2 sm:-mt-6 relative z-10">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            
            <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center gap-3.5 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-900">Vợt Tuyển Chọn 100%</h4>
                    <p class="text-[11px] text-slate-500">Cam kết không nứt hàn nhiệt</p>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center gap-3.5 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-900">Bao Test Sân 7 Ngày</h4>
                    <p class="text-[11px] text-slate-500">1 đổi 1 nếu lỗi cấu trúc phôi</p>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center gap-3.5 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-900">Ảnh Thật Từng Cây</h4>
                    <p class="text-[11px] text-slate-500">Giao đúng cây vợt trên ảnh</p>
                </div>
            </div>

            <div class="bg-white p-4 sm:p-5 rounded-2xl shadow-sm border border-slate-200/80 flex items-center gap-3.5 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                </div>
                <div>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-900">Ship COD Toàn Quốc</h4>
                    <p class="text-[11px] text-slate-500">Được mở hộp kiểm tra vợt</p>
                </div>
            </div>

        </div>
    </section>

    <!-- 3. HÀNG MỚI VỀ (NEW ARRIVALS) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4 pb-4 border-b border-slate-200">
            <div>
                <div class="inline-flex items-center gap-2 text-xs font-bold text-brand-600 uppercase tracking-wider mb-1">
                    <span class="w-2 h-2 rounded-full bg-brand-600"></span>
                    Mới Cập Bến Hôm Nay
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                    HÀNG MỚI VỀ (CÒN HÀNG)
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Mỗi cây vợt là một món duy nhất - Xem thật, chọn đúng cây ưng ý</p>
            </div>
            <a href="{{ route('products.index', ['status' => 'available']) }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-brand-600 hover:text-brand-700 group">
                <span>Xem tất cả kho vợt</span>
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @forelse($newArrivals as $product)
                <x-product-card :product="$product" />
            @empty
                <div class="col-span-full py-12 text-center text-slate-500">
                    Hiện chưa có sản phẩm mới nào.
                </div>
            @endforelse
        </div>
    </section>

    <!-- 4. BANNER NGANG QUẢNG CÁO GIỮA TRANG -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-red-900 via-slate-900 to-black p-8 sm:p-12 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
            <div class="max-w-xl">
                <span class="px-3 py-1 rounded-full bg-amber-400 text-slate-900 text-xs font-black uppercase tracking-wider">
                    DỊCH VỤ ĐỘC QUYỀN
                </span>
                <h3 class="text-2xl sm:text-3xl font-extrabold mt-3 mb-2">
                    THU CŨ ĐỔI MỚI - LÊN ĐỜI VỢT GIÁ HỜI
                </h3>
                <p class="text-slate-300 text-sm leading-relaxed">
                    Bạn đang muốn nâng cấp từ dòng vợt trung cấp lên cây vợt Yonex Astrox hay Victor đỉnh cao? Shop nhận thu mua và hỗ trợ bù trừ giá cực tốt!
                </p>
            </div>
            <a href="https://zalo.me/0901234567" target="_blank" class="px-6 py-3.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-sm uppercase tracking-wider shadow-lg hover:scale-105 transition-all whitespace-nowrap">
                Định Giá Vợt Cũ Qua Zalo &rarr;
            </a>
        </div>
    </section>

    <!-- 5. SALE OFF / XẢ KHO THANH LÝ -->
    @if($clearanceRackets->isNotEmpty())
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-gradient-to-br from-red-50 to-amber-50 rounded-3xl p-6 sm:p-8 border border-red-100 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4 pb-4 border-b border-red-200/60">
                    <div>
                        <div class="inline-flex items-center gap-1.5 text-xs font-black text-red-600 uppercase tracking-wider mb-1">
                            <span class="animate-ping w-2 h-2 rounded-full bg-red-600"></span>
                            CƠ HỘI SĂN VỢT GIÁ RẺ
                        </div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 flex items-center gap-2">
                            <span>XẢ KHO THANH LÝ (SALE OFF)</span>
                            <span class="text-red-600">🔥</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 mt-1">Các cây vợt có vết tróc sơn viền đầu nhưng kết cấu đũa và phôi carbon bao zin, giá sinh viên</p>
                    </div>
                    <a href="{{ route('products.index', ['is_clearance' => 1]) }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-red-600 hover:text-red-700">
                        <span>Xem toàn bộ hàng xả kho &rarr;</span>
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($clearanceRackets as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- 6. THƯƠNG HIỆU NỔI BẬT -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center max-w-xl mx-auto mb-8">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                THƯƠNG HIỆU VỢT CŨ SẴN HÀNG
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Bấm vào thương hiệu để lọc nhanh những cây vợt 2hand đang có sẵn</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($brands as $brand)
                <a href="{{ route('products.brand', ['brand_slug' => $brand->slug]) }}" 
                   class="bg-white p-5 rounded-2xl border border-slate-200/80 hover:border-brand-500 text-center shadow-sm hover:shadow-lg transition-all group flex flex-col items-center justify-center">
                    <div class="w-14 h-14 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <span class="font-extrabold text-lg text-slate-800 group-hover:text-brand-600">
                            {{ substr($brand->name, 0, 2) }}
                        </span>
                    </div>
                    <h3 class="font-bold text-slate-900 group-hover:text-brand-600 text-sm mb-1 transition-colors">{{ $brand->name }}</h3>
                    <span class="text-[11px] text-slate-400 font-medium">{{ $brand->products_count }} cây còn hàng</span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- 7. TIN TỨC & KINH NGHIỆM CHỌN VỢT 2HAND -->
    @if($latestPosts->isNotEmpty())
        <section id="kinh-nghiem" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 border-t border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                        CẨM NANG & MẸO CHỌN VỢT CŨ
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Trang bị kiến thức kiểm tra vợt thật - giả, vợt hàn nhiệt để không bị lừa</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($latestPosts as $post)
                    <article class="bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col">
                        <a href="{{ route('posts.show', ['slug' => $post->slug]) }}" class="aspect-[16/9] block bg-slate-100 overflow-hidden group">
                            <img src="{{ $post->thumbnail }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </a>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-brand-600 uppercase tracking-wider block mb-2">
                                    {{ $post->published_at?->format('d/m/Y') }}
                                </span>
                                <h3 class="font-bold text-slate-900 text-base leading-snug line-clamp-2 hover:text-brand-600 transition-colors mb-2">
                                    <a href="{{ route('posts.show', ['slug' => $post->slug]) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-slate-500 text-xs line-clamp-3 leading-relaxed mb-4">
                                    {{ $post->summary }}
                                </p>
                            </div>
                            <a href="{{ route('posts.show', ['slug' => $post->slug]) }}" class="text-xs font-bold text-slate-900 hover:text-brand-600 inline-flex items-center gap-1">
                                Đọc bài viết &rarr;
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

@endsection
