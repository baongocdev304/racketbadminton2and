@extends('layouts.app')

@section('title', $product->name . ' (Mã: ' . $product->sku . ') - Vợt Cầu Lông 2Hand')
@section('meta_description', $product->name . ' hàng 2hand chính hãng độ mới ' . $product->condition_percent . '%, phân hạng ' . $product->condition_grade . '. ' . $product->condition_note)

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2 truncate">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-brand-600">Vợt cầu lông cũ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li>
                        <a href="{{ route('products.brand', ['brand_slug' => $product->brand->slug]) }}" class="hover:text-brand-600">
                            {{ $product->brand->name }}
                        </a>
                    </li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-900 font-bold truncate max-w-[200px] sm:max-w-none">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    @php
        $gradeColor = match($product->condition_grade) {
            'A' => 'bg-emerald-600 text-white',
            'B' => 'bg-sky-600 text-white',
            'C' => 'bg-amber-600 text-white',
            default => 'bg-slate-600 text-white',
        };

        // Danh sách ảnh
        $allImages = $product->images->pluck('image_path')->toArray();
        if (empty($allImages)) {
            $allImages = ['https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=800&auto=format&fit=crop'];
        }
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
         x-data="{
            images: {{ json_encode($allImages) }},
            activeImageIndex: 0,
            activeImage: '{{ $allImages[0] }}',
            isAdding: false,
            setImage(index) {
                this.activeImageIndex = index;
                this.activeImage = this.images[index];
            },
            addToCartAjax(productId) {
                this.isAdding = true;
                fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(res => res.json())
                .then(data => {
                    this.isAdding = false;
                    if (data.success) {
                        window.dispatchEvent(new CustomEvent('added-to-cart', { detail: data }));
                    } else {
                        alert(data.message || 'Không thể thêm sản phẩm.');
                    }
                })
                .catch(err => {
                    this.isAdding = false;
                    alert('Đã xảy ra lỗi, vui lòng thử lại.');
                });
            }
         }">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- LEFT COLUMN: IMAGE GALLERY (6 COLS) -->
            <div class="lg:col-span-6 space-y-4">
                
                <!-- Main Image Preview -->
                <div class="relative aspect-square rounded-3xl bg-slate-100 overflow-hidden border border-slate-200/80 shadow-md">
                    <img :src="activeImage" 
                         alt="{{ $product->name }}" 
                         class="w-full h-full object-cover object-center transition-all duration-300">

                    <!-- Badges on image -->
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wider shadow-lg {{ $gradeColor }}">
                            <span>Hạng {{ $product->condition_grade }}</span>
                            <span>•</span>
                            <span>{{ $product->condition_percent }}%</span>
                        </span>

                        @if($product->is_clearance)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-black uppercase tracking-wider bg-red-600 text-white shadow-lg animate-pulse">
                                🔥 Xả Kho Thanh Lý
                            </span>
                        @endif
                    </div>

                    <!-- Watermark Cam kết ảnh thật -->
                    <div class="absolute bottom-4 right-4 bg-slate-950/80 backdrop-blur-sm text-slate-200 px-3 py-1 rounded-full text-[11px] font-medium border border-slate-700">
                        📸 Ảnh chụp thật cây này
                    </div>

                    <!-- Sold Overlay nếu đã bán -->
                    @if($product->status === 'sold')
                        <div class="absolute inset-0 bg-slate-950/75 backdrop-blur-[2px] flex items-center justify-center">
                            <span class="px-6 py-2 rounded-xl bg-red-600 text-white font-black text-lg tracking-widest uppercase shadow-2xl transform -rotate-12 border-2 border-white">
                                CÂY NÀY ĐÃ BÁN (SOLD)
                            </span>
                        </div>
                    @elseif($product->status === 'reserved')
                        <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-[1px] flex items-center justify-center">
                            <span class="px-5 py-2 rounded-xl bg-amber-500 text-white font-black text-sm tracking-widest uppercase shadow-xl">
                                ĐANG ĐƯỢC GIỮ HÀNG
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Carousel -->
                <div class="grid grid-cols-4 sm:grid-cols-5 gap-3">
                    <template x-for="(img, idx) in images" :key="idx">
                        <button type="button" 
                                @click="setImage(idx)"
                                class="relative aspect-square rounded-xl bg-slate-100 overflow-hidden border-2 transition-all"
                                :class="activeImageIndex === idx ? 'border-brand-600 ring-2 ring-brand-500/20' : 'border-slate-200 hover:border-slate-400 opacity-70 hover:opacity-100'">
                            <img :src="img" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>

                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200/80 text-xs text-amber-900 leading-relaxed">
                    <strong>Lưu ý quan trọng của hàng 2Hand:</strong> Mỗi hình ảnh trên đây được chụp cận cảnh trên chính cây vợt có mã SKU <code>{{ $product->sku }}</code>. Khi đặt hàng, bạn sẽ nhận đúng chính xác cây vợt này.
                </div>

            </div>

            <!-- RIGHT COLUMN: PRODUCT INFO & PURCHASE (6 COLS) -->
            <div class="lg:col-span-6 space-y-6">
                
                <div>
                    <!-- Brand & SKU -->
                    <div class="flex items-center gap-3 text-xs mb-2">
                        <a href="{{ route('products.brand', ['brand_slug' => $product->brand->slug]) }}" 
                           class="px-2.5 py-1 rounded-md bg-brand-50 text-brand-600 font-extrabold uppercase tracking-wider hover:bg-brand-100 transition-colors">
                            Hãng {{ $product->brand->name }}
                        </a>
                        <span class="text-slate-400">•</span>
                        <span class="text-slate-500 font-mono">Mã cây vợt: <strong class="text-slate-900 font-bold">{{ $product->sku }}</strong></span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                        {{ $product->name }}
                    </h1>
                </div>

                <!-- TÌNH TRẠNG 2HAND BOX (ĐẶC THÙ HÀNG CŨ) -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Đánh giá tình trạng</span>
                        <span class="text-xs font-extrabold {{ $product->condition_grade === 'A' ? 'text-emerald-600' : ($product->condition_grade === 'B' ? 'text-sky-600' : 'text-amber-600') }}">
                            {{ $product->condition_grade_label }}
                        </span>
                    </div>

                    <!-- Progress bar độ mới -->
                    <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500 {{ $product->condition_grade === 'A' ? 'bg-emerald-500' : ($product->condition_grade === 'B' ? 'bg-sky-500' : 'bg-amber-500') }}"
                             style="width: {{ $product->condition_percent }}%"></div>
                    </div>

                    <div class="pt-2 text-xs text-slate-700 bg-white p-3.5 rounded-xl border border-slate-100">
                        <strong class="text-slate-900 block mb-1">Ghi chú tình trạng thực tế:</strong>
                        <p class="italic text-slate-600 leading-relaxed">{{ $product->condition_note }}</p>
                    </div>
                </div>

                <!-- PRICE BOX -->
                <div class="p-6 rounded-2xl bg-gradient-to-r from-red-50 to-amber-50 border border-red-100">
                    <div class="flex items-baseline gap-3">
                        <span class="text-3xl sm:text-4xl font-black text-red-600">
                            {{ $product->formatted_price }}
                        </span>
                        @if($product->original_price && $product->original_price > $product->price)
                            <span class="text-base text-slate-400 line-through">
                                {{ $product->formatted_original_price }}
                            </span>
                            <span class="px-2.5 py-1 rounded-full bg-red-600 text-white text-xs font-bold">
                                Tiết kiệm {{ $product->discount_percent }}%
                            </span>
                        @endif
                    </div>
                    <p class="text-[11px] text-slate-500 mt-2">
                        * Giá đã bao gồm kiểm định khung và tặng kèm quấn cán mới khi giao hàng.
                    </p>
                </div>

                <!-- BUTTONS ACTION (THÊM VÀO GIỎ / MUA NGAY) -->
                <div class="space-y-3 pt-2">
                    @if($product->status === 'available')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <!-- Nút Mua ngay: Submit form trực tiếp đến trang checkout -->
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="buy_now" value="1">
                                <button type="submit" 
                                        class="w-full py-4 px-6 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm text-center uppercase tracking-wider shadow-lg shadow-brand-600/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    <span>Mua Ngay Cây Này</span>
                                </button>
                            </form>

                            <!-- Nút Thêm vào giỏ (AJAX Popup Modal) -->
                            <button type="button" 
                                    @click="addToCartAjax({{ $product->id }})"
                                    :disabled="isAdding"
                                    class="w-full py-4 px-6 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-extrabold text-sm text-center uppercase tracking-wider shadow-md hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <span x-text="isAdding ? 'Đang thêm...' : 'Thêm Vào Giỏ Hàng'">Thêm Vào Giỏ Hàng</span>
                            </button>
                        </div>
                    @elseif($product->status === 'reserved')
                        <div class="p-4 rounded-xl bg-amber-100 text-amber-900 font-bold text-sm text-center">
                            ⏳ Cây vợt này đang được giữ trong đơn hàng của khách khác. Bạn có thể liên hệ Zalo để xếp hàng chờ nếu đơn bị hủy!
                        </div>
                    @else
                        <div class="p-4 rounded-xl bg-slate-200 text-slate-600 font-bold text-sm text-center">
                            ❌ Cây vợt độc bản này đã bán. Xin mời bạn xem các mẫu vợt tương đương bên dưới!
                        </div>
                    @endif

                    <div class="flex items-center justify-center gap-4 text-xs text-slate-500 pt-2">
                        <span class="flex items-center gap-1">🔒 Giao dịch an toàn</span>
                        <span>•</span>
                        <span class="flex items-center gap-1">📦 Mở hộp đồng kiểm</span>
                        <span>•</span>
                        <span class="flex items-center gap-1">🚀 Giao nhanh 2h tại TP.HCM</span>
                    </div>
                </div>

                <!-- BẢNG THÔNG SỐ KỸ THUẬT CHI TIẾT -->
                <div class="pt-4 border-t border-slate-200">
                    <h3 class="font-extrabold text-base text-slate-900 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        <span>Thông Số Kỹ Thuật Chi Tiết</span>
                    </h3>

                    <div class="rounded-2xl border border-slate-200 overflow-hidden text-xs">
                        <table class="w-full text-left">
                            <tbody class="divide-y divide-slate-100">
                                <tr class="bg-slate-50/60">
                                    <td class="py-3 px-4 font-semibold text-slate-500 w-1/3">Trọng lượng thân vợt</td>
                                    <td class="py-3 px-4 font-bold text-slate-900">{{ $product->weight_class }} (Khoảng 80-89g)</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-semibold text-slate-500">Chu vi cán cầm</td>
                                    <td class="py-3 px-4 font-bold text-slate-900">{{ $product->grip_size }}</td>
                                </tr>
                                <tr class="bg-slate-50/60">
                                    <td class="py-3 px-4 font-semibold text-slate-500">Điểm cân bằng</td>
                                    <td class="py-3 px-4 font-bold text-slate-900">{{ $product->balance }}</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4 font-semibold text-slate-500">Độ cứng thân đũa</td>
                                    <td class="py-3 px-4 font-bold text-slate-900">{{ $product->flex }}</td>
                                </tr>
                                <tr class="bg-slate-50/60">
                                    <td class="py-3 px-4 font-semibold text-slate-500">Sức căng tối đa khuyến nghị</td>
                                    <td class="py-3 px-4 font-bold text-slate-900">{{ $product->max_tension_lbs }} LBS (~{{ round($product->max_tension_lbs * 0.453592, 1) }} kg)</td>
                                </tr>
                                @if($product->year)
                                    <tr>
                                        <td class="py-3 px-4 font-semibold text-slate-500">Năm sản xuất / Ra mắt</td>
                                        <td class="py-3 px-4 font-bold text-slate-900">{{ $product->year }}</td>
                                    </tr>
                                @endif
                                <tr class="bg-slate-50/60">
                                    <td class="py-3 px-4 font-semibold text-slate-500">Mã SKU độc bản</td>
                                    <td class="py-3 px-4 font-bold text-brand-600 font-mono">{{ $product->sku }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

        <!-- MÔ TẢ CHI TIẾT BÀI VIẾT -->
        <div class="mt-16 pt-10 border-t border-slate-200">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-xl font-extrabold text-slate-900 mb-6">
                    ĐÁNH GIÁ THỰC TẾ & BÀI VIẾT MÔ TẢ
                </h3>
                <div class="prose prose-slate max-w-none text-sm text-slate-700 leading-relaxed bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
                    {!! $product->description !!}
                </div>
            </div>
        </div>

        <!-- SẢN PHẨM LIÊN QUAN -->
        @if($relatedProducts->isNotEmpty())
            <div class="mt-16 pt-12 border-t border-slate-200">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">
                            CÁC CÂY VỢT CÙNG PHÂN KHÚC
                        </h3>
                        <p class="text-xs text-slate-500 mt-1">Các cây vợt khác cùng hãng hoặc cùng tầm giá bạn có thể tham khảo</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="text-xs font-bold text-brand-600 hover:underline">
                        Xem tất cả &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($relatedProducts as $rel)
                        <x-product-card :product="$rel" />
                    @endforeach
                </div>
            </div>
        @endif

    </div>

@endsection
