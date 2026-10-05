@extends('layouts.app')

@section('title', 'Tin Tức & Cẩm Nang Vợt Cầu Lông - Vợt Cầu Lông 2Hand')
@section('meta_description', 'Tổng hợp kinh nghiệm chọn mua vợt cầu lông cũ, phân biệt vợt Yonex thật giả, đánh giá các dòng vợt lướt hot nhất thị trường.')

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-900 font-bold">Tin tức & Cẩm nang</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="mb-8">
            <span class="px-3 py-1 rounded-full bg-brand-50 text-brand-600 font-extrabold text-xs uppercase tracking-wider inline-block mb-2">
                Kiến Thức Cầu Lông
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                TIN TỨC & KINH NGHIỆM CHỌN VỢT 2HAND
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Trang bị kiến thức kiểm tra vợt thật - giả, cách nhận biết vợt nứt phôi hàn nhiệt và kỹ thuật cầu lông.
            </p>
        </div>

        @if($posts->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm max-w-lg mx-auto">
                <p class="text-slate-500 text-sm">Chưa có bài viết nào được xuất bản.</p>
            </div>
        @else
            <!-- BÀI VIẾT NỔI BẬT ĐẦU TRANG -->
            @if($featuredPost)
                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow mb-10 group">
                    <div class="grid grid-cols-1 lg:grid-cols-12 items-center">
                        <div class="lg:col-span-7 aspect-[16/9] lg:aspect-auto h-full overflow-hidden bg-slate-100">
                            <img src="{{ $featuredPost->thumbnail }}" 
                                 alt="{{ $featuredPost->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="lg:col-span-5 p-6 sm:p-10 space-y-4">
                            <div class="flex items-center gap-3 text-xs text-slate-400">
                                <span class="font-bold text-brand-600 uppercase tracking-wider">Bài viết mới nhất</span>
                                <span>•</span>
                                <span>{{ $featuredPost->published_at?->format('d/m/Y') }}</span>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-black text-slate-900 group-hover:text-brand-600 transition-colors leading-snug">
                                <a href="{{ route('posts.show', ['slug' => $featuredPost->slug]) }}">
                                    {{ $featuredPost->title }}
                                </a>
                            </h2>
                            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed line-clamp-3">
                                {{ $featuredPost->summary }}
                            </p>
                            <a href="{{ route('posts.show', ['slug' => $featuredPost->slug]) }}" class="inline-flex items-center gap-1.5 font-bold text-xs text-brand-600 hover:text-brand-700">
                                <span>Đọc chi tiết bài viết</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- GRID DANH SÁCH BÀI VIẾT -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    <article class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow flex flex-col group">
                        <a href="{{ route('posts.show', ['slug' => $post->slug]) }}" class="aspect-[16/9] block bg-slate-100 overflow-hidden">
                            <img src="{{ $post->thumbnail }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </a>
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-slate-400 block mb-2">
                                    {{ $post->published_at?->format('d/m/Y') }}
                                </span>
                                <h3 class="font-bold text-slate-900 text-sm sm:text-base leading-snug line-clamp-2 group-hover:text-brand-600 transition-colors mb-2">
                                    <a href="{{ route('posts.show', ['slug' => $post->slug]) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-slate-500 text-xs line-clamp-3 leading-relaxed mb-4">
                                    {{ $post->summary }}
                                </p>
                            </div>
                            <a href="{{ route('posts.show', ['slug' => $post->slug]) }}" class="text-xs font-bold text-slate-900 group-hover:text-brand-600 inline-flex items-center gap-1">
                                Đọc bài viết &rarr;
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

@endsection
