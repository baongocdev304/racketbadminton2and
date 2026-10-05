@props(['product'])

@php
    $gradeColor = match($product->condition_grade) {
        'A' => 'bg-emerald-500 text-white',
        'B' => 'bg-sky-500 text-white',
        'C' => 'bg-amber-500 text-white',
        default => 'bg-slate-500 text-white',
    };

    $imageUrl = $product->primaryImage?->image_path ?? '/images/placeholder-racket.png';
    // Nếu là URL tĩnh trên mạng hoặc placeholder
    if (!str_starts_with($imageUrl, 'http') && !str_starts_with($imageUrl, '/images/')) {
        $imageUrl = asset('storage/' . $imageUrl);
    }
@endphp

<div class="group bg-white rounded-2xl border border-slate-200/80 hover:border-brand-500/50 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden relative">
    
    <!-- Top Image Container -->
    <a href="{{ route('products.show', ['slug' => $product->slug]) }}" class="relative block aspect-[4/3] bg-slate-100 overflow-hidden">
        <img src="{{ $imageUrl }}" 
             alt="{{ $product->name }}" 
             loading="lazy"
             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-500"
             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=600&auto=format&fit=crop';">

        <!-- Top Badges -->
        <div class="absolute top-2.5 left-2.5 flex flex-col gap-1.5 z-10">
            <!-- Badge Hạng & Độ mới -->
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-extrabold tracking-wide shadow-md {{ $gradeColor }}">
                <span>Hạng {{ $product->condition_grade }}</span>
                <span>•</span>
                <span>{{ $product->condition_percent }}%</span>
            </span>

            @if($product->is_clearance)
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black uppercase bg-red-600 text-white tracking-wider shadow-md animate-pulse">
                    Xả Kho
                </span>
            @endif
        </div>

        <!-- Trạng thái sản phẩm nếu không phải available -->
        @if($product->status === 'sold')
            <div class="absolute inset-0 bg-slate-950/70 backdrop-blur-[2px] flex items-center justify-center z-20">
                <span class="px-4 py-1.5 rounded-lg bg-red-600 text-white font-black text-sm tracking-wider uppercase shadow-xl transform -rotate-6">
                    ĐÃ BÁN (SOLD)
                </span>
            </div>
        @elseif($product->status === 'reserved')
            <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-[1px] flex items-center justify-center z-20">
                <span class="px-3 py-1 rounded-lg bg-amber-500 text-white font-bold text-xs tracking-wider uppercase shadow-md">
                    ĐANG GIỮ HÀNG
                </span>
            </div>
        @endif

        <!-- Mã SKU độc bản gắn nổi ở góc dưới ảnh -->
        <div class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-slate-900/80 text-slate-200 text-[10px] font-mono tracking-wider backdrop-blur-sm">
            Mã: {{ $product->sku }}
        </div>
    </a>

    <!-- Card Body -->
    <div class="p-4 flex-1 flex flex-col justify-between">
        <div>
            <!-- Brand & Năm -->
            <div class="flex items-center justify-between text-xs text-slate-400 mb-1.5 font-medium">
                <span class="text-brand-600 font-bold uppercase tracking-wider">{{ $product->brand->name ?? 'Yonex' }}</span>
                @if($product->year)
                    <span>Đời {{ $product->year }}</span>
                @endif
            </div>

            <!-- Tên cây vợt -->
            <h3 class="font-bold text-slate-900 text-sm leading-snug line-clamp-2 group-hover:text-brand-600 transition-colors mb-2.5">
                <a href="{{ route('products.show', ['slug' => $product->slug]) }}">
                    {{ $product->name }}
                </a>
            </h3>

            <!-- Thông số ngắn gọn -->
            <div class="flex flex-wrap items-center gap-1.5 mb-3 text-[11px] text-slate-500">
                <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-700 font-semibold">{{ $product->weight_class }}</span>
                <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-700 font-semibold">{{ $product->grip_size }}</span>
                <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-700 truncate max-w-[130px]" title="{{ $product->balance }}">{{ $product->balance }}</span>
            </div>
        </div>

        <!-- Price & Action -->
        <div class="pt-3 border-t border-slate-100">
            <div class="flex items-baseline justify-between gap-1 mb-2">
                <div>
                    <span class="text-base font-extrabold text-red-600">
                        {{ $product->formatted_price }}
                    </span>
                    @if($product->original_price && $product->original_price > $product->price)
                        <span class="block text-[11px] text-slate-400 line-through">
                            {{ $product->formatted_original_price }}
                        </span>
                    @endif
                </div>

                @if($product->discount_percent > 0)
                    <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                        -{{ $product->discount_percent }}%
                    </span>
                @endif
            </div>

            <a href="{{ route('products.show', ['slug' => $product->slug]) }}" 
               class="w-full flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-slate-100 group-hover:bg-brand-600 text-slate-700 group-hover:text-white font-bold text-xs transition-colors duration-200">
                <span>Xem Cây Này</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>

</div>
