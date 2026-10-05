@extends('layouts.app')

@section('title', $post->title . ' - Kiến Thức Vợt Cầu Lông 2Hand')
@section('meta_description', $post->summary)

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2 truncate">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li><span class="text-slate-400">Kiến thức cầu lông</span></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-900 font-bold truncate max-w-xs">{{ $post->title }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <article class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header bài viết -->
        <div class="mb-8">
            <span class="px-3 py-1 rounded-full bg-brand-50 text-brand-600 font-extrabold text-xs uppercase tracking-wider inline-block mb-3">
                Cẩm Nang Vợt 2Hand
            </span>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 leading-tight mb-4">
                {{ $post->title }}
            </h1>
            <div class="flex items-center gap-3 text-xs text-slate-400">
                <span>Xuất bản: {{ $post->published_at?->format('d/m/Y') }}</span>
                <span>•</span>
                <span>Tác giả: {{ $post->author->name ?? 'Ban Biên Tập Vợt 2Hand' }}</span>
            </div>
        </div>

        @if($post->thumbnail)
            <div class="rounded-3xl overflow-hidden aspect-[16/9] mb-8 shadow-md">
                <img src="{{ $post->thumbnail }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        @if($post->summary)
            <div class="p-5 rounded-2xl bg-slate-100 border-l-4 border-brand-600 text-sm font-medium text-slate-700 leading-relaxed mb-8 italic">
                {{ $post->summary }}
            </div>
        @endif

        <!-- Nội dung bài viết -->
        <div class="prose prose-slate max-w-none text-slate-800 leading-relaxed space-y-4 text-sm sm:text-base">
            {!! $post->content !!}
        </div>

        <!-- Tin bài liên quan -->
        @if($relatedPosts->isNotEmpty())
            <div class="mt-16 pt-10 border-t border-slate-200">
                <h3 class="text-xl font-extrabold text-slate-900 mb-6">Bài Viết Khác Cùng Chuyên Mục</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $rPost)
                        <div class="space-y-2">
                            <a href="{{ route('posts.show', ['slug' => $rPost->slug]) }}" class="font-bold text-sm text-slate-900 hover:text-brand-600 line-clamp-2">
                                {{ $rPost->title }}
                            </a>
                            <p class="text-xs text-slate-500 line-clamp-2">{{ $rPost->summary }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </article>

@endsection
