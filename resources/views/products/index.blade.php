@extends('layouts.app')

@section('title', $pageTitle . ' - Vợt Cầu Lông 2Hand Tuyển Chọn')

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-brand-600">Vợt cầu lông cũ</a></li>
                    @if($selectedBrand)
                        <li><span class="text-slate-300">/</span></li>
                        <li class="text-slate-900 font-bold">{{ $selectedBrand->name }}</li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ filterMobileOpen: false }">
        
        <!-- Header Title & Sort Bar -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $pageTitle }}</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Tìm thấy <strong class="text-slate-900">{{ $products->total() }}</strong> cây vợt độc bản phù hợp
                </p>
            </div>

            <!-- Sort & Mobile Filter Button -->
            <div class="flex items-center justify-between sm:justify-end gap-3">
                
                <!-- Nút bật filter trên mobile -->
                <button type="button" 
                        @click="filterMobileOpen = true"
                        class="lg:hidden flex items-center gap-1.5 px-4 py-2 rounded-xl bg-white border border-slate-200 text-xs font-bold text-slate-700 shadow-sm">
                    <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Bộ Lọc</span>
                </button>

                <!-- Dropdown sắp xếp -->
                <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-2">
                    @foreach(request()->except(['sort', 'page']) as $key => $val)
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endforeach

                    <label for="sortSelect" class="text-xs text-slate-500 whitespace-nowrap hidden sm:inline">Sắp xếp:</label>
                    <select id="sortSelect" 
                            name="sort" 
                            onchange="this.form.submit()" 
                            class="text-xs font-semibold bg-white border border-slate-200 rounded-xl px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-brand-500 shadow-sm cursor-pointer">
                        <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Ưu tiên còn hàng & Mới nhất</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến cao</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến thấp</option>
                        <option value="percent_desc" {{ request('sort') == 'percent_desc' ? 'selected' : '' }}>Độ mới cao nhất (Like New)</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- SIDEBAR FILTERS (DESKTOP) -->
            <aside class="hidden lg:block lg:col-span-1 space-y-6">
                
                <form action="{{ route('products.index') }}" method="GET" id="desktopFilterForm">
                    @if(request('q'))
                        <input type="hidden" name="q" value="{{ request('q') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif

                    <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-6">
                        
                        <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                            <span class="font-extrabold text-sm text-slate-900 uppercase tracking-wider">Bộ Lọc Tìm Kiếm</span>
                            @if(request()->hasAny(['brand', 'price_range', 'weight', 'condition_grade', 'status', 'is_clearance']))
                                <a href="{{ route('products.index') }}" class="text-xs text-brand-600 font-bold hover:underline">
                                    Xóa bộ lọc
                                </a>
                            @endif
                        </div>

                        <!-- 1. Lọc theo Thương hiệu -->
                        <div>
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 mb-3">Thương Hiệu</h4>
                            <div class="space-y-2">
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer hover:text-brand-600">
                                    <input type="radio" name="brand" value="" onchange="this.form.submit()" {{ !request('brand') ? 'checked' : '' }} class="text-brand-600 focus:ring-brand-500 mr-2">
                                    <span>Tất cả thương hiệu</span>
                                </label>
                                @foreach($globalBrands ?? [] as $b)
                                    <label class="flex items-center justify-between text-xs text-slate-700 cursor-pointer hover:text-brand-600">
                                        <div class="flex items-center">
                                            <input type="radio" name="brand" value="{{ $b->slug }}" onchange="this.form.submit()" {{ request('brand') == $b->slug ? 'checked' : '' }} class="text-brand-600 focus:ring-brand-500 mr-2">
                                            <span>{{ $b->name }}</span>
                                        </div>
                                        <span class="text-[11px] text-slate-400">({{ $b->products_count }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- 2. Lọc theo Phân hạng tình trạng -->
                        <div class="pt-4 border-t border-slate-100">
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 mb-3">Tình Trạng (Độ Mới)</h4>
                            <div class="space-y-2">
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="condition_grade" value="" onchange="this.form.submit()" {{ !request('condition_grade') ? 'checked' : '' }} class="text-brand-600 mr-2">
                                    <span>Tất cả các hạng</span>
                                </label>
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="condition_grade" value="A" onchange="this.form.submit()" {{ request('condition_grade') == 'A' ? 'checked' : '' }} class="text-brand-600 mr-2">
                                    <span class="text-emerald-600 font-bold">Hạng A: Siêu lướt (95-99%)</span>
                                </label>
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="condition_grade" value="B" onchange="this.form.submit()" {{ request('condition_grade') == 'B' ? 'checked' : '' }} class="text-brand-600 mr-2">
                                    <span class="text-sky-600 font-bold">Hạng B: Đẹp keng (88-94%)</span>
                                </label>
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="condition_grade" value="C" onchange="this.form.submit()" {{ request('condition_grade') == 'C' ? 'checked' : '' }} class="text-brand-600 mr-2">
                                    <span class="text-amber-600 font-bold">Hạng C: Vết xước (80-87%)</span>
                                </label>
                            </div>
                        </div>

                        <!-- 3. Lọc theo Khoảng giá -->
                        <div class="pt-4 border-t border-slate-100">
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 mb-3">Khoảng Giá (VND)</h4>
                            <div class="space-y-2">
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="price_range" value="" onchange="this.form.submit()" {{ !request('price_range') ? 'checked' : '' }} class="text-brand-600 mr-2">
                                    <span>Tất cả mức giá</span>
                                </label>
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="price_range" value="under_1m" onchange="this.form.submit()" {{ request('price_range') == 'under_1m' ? 'checked' : '' }} class="text-brand-600 mr-2">
                                    <span>Dưới 1.000.000đ</span>
                                </label>
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="price_range" value="1m_2m" onchange="this.form.submit()" {{ request('price_range') == '1m_2m' ? 'checked' : '' }} class="text-brand-600 mr-2">
                                    <span>1.000.000đ - 2.000.000đ</span>
                                </label>
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="price_range" value="2m_3m" onchange="this.form.submit()" {{ request('price_range') == '2m_3m' ? 'checked' : '' }} class="text-brand-600 mr-2">
                                    <span>2.000.000đ - 3.000.000đ</span>
                                </label>
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="price_range" value="over_3m" onchange="this.form.submit()" {{ request('price_range') == 'over_3m' ? 'checked' : '' }} class="text-brand-600 mr-2">
                                    <span>Trên 3.000.000đ</span>
                                </label>
                            </div>
                        </div>

                        <!-- 4. Lọc theo Trọng lượng (2U, 3U, 4U, 5U) -->
                        <div class="pt-4 border-t border-slate-100">
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 mb-3">Trọng Lượng (Weight)</h4>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach(['2U', '3U', '4U', '5U'] as $w)
                                    <label class="flex items-center justify-center p-2 rounded-lg border text-xs font-bold cursor-pointer transition-colors {{ request('weight') == $w ? 'bg-brand-600 text-white border-brand-600' : 'bg-slate-50 text-slate-700 border-slate-200 hover:border-brand-300' }}">
                                        <input type="radio" name="weight" value="{{ $w }}" onchange="this.form.submit()" class="sr-only">
                                        {{ $w }}
                                    </label>
                                @endforeach
                            </div>
                            @if(request('weight'))
                                <a href="{{ request()->fullUrlWithoutQuery('weight') }}" class="block text-center text-[11px] text-slate-400 hover:text-brand-600 mt-2">Bỏ chọn trọng lượng</a>
                            @endif
                        </div>

                        <!-- 5. Trạng thái kho -->
                        <div class="pt-4 border-t border-slate-100">
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 mb-3">Tình Trạng Kho</h4>
                            <div class="space-y-2">
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="status" value="" onchange="this.form.submit()" {{ !request('status') ? 'checked' : '' }} class="text-brand-600 mr-2">
                                    <span>Tất cả</span>
                                </label>
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="status" value="available" onchange="this.form.submit()" {{ request('status') == 'available' ? 'checked' : '' }} class="text-brand-600 mr-2">
                                    <span class="text-emerald-600 font-bold">Chỉ cây còn hàng</span>
                                </label>
                                <label class="flex items-center text-xs text-slate-700 cursor-pointer">
                                    <input type="radio" name="status" value="sold" onchange="this.form.submit()" {{ request('status') == 'sold' ? 'checked' : '' }} class="text-brand-600 mr-2">
                                    <span class="text-slate-500">Cây đã bán</span>
                                </label>
                            </div>
                        </div>

                    </div>
                </form>

            </aside>

            <!-- PRODUCT GRID (MAIN) -->
            <div class="lg:col-span-3">
                
                @if($products->isEmpty())
                    <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm">
                        <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">Không tìm thấy cây vợt phù hợp</h3>
                        <p class="text-xs text-slate-500 mb-6">Hãy thử nới lỏng bộ lọc thương hiệu hoặc khoảng giá để xem thêm các mẫu khác.</p>
                        <a href="{{ route('products.index') }}" class="px-5 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-xs hover:bg-brand-700 transition-colors">
                            Xem tất cả vợt cầu lông cũ
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    <!-- PAGINATION -->
                    <div class="mt-10">
                        {{ $products->links() }}
                    </div>
                @endif

            </div>

        </div>

        <!-- MOBILE FILTER DRAWER -->
        <div x-show="filterMobileOpen" 
             x-cloak 
             class="relative z-50 lg:hidden" 
             role="dialog" 
             aria-modal="true">
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="filterMobileOpen = false"></div>

            <div class="fixed inset-y-0 right-0 max-w-xs w-full bg-white h-full shadow-2xl p-6 overflow-y-auto">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                    <span class="font-extrabold text-base text-slate-900">Bộ Lọc Vợt 2Hand</span>
                    <button type="button" @click="filterMobileOpen = false" class="p-2 text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Form lọc mobile -->
                <form action="{{ route('products.index') }}" method="GET">
                    @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif

                    <div class="space-y-6 text-sm">
                        <!-- Hãng -->
                        <div>
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 mb-2">Hãng</h4>
                            <select name="brand" class="w-full text-xs p-2.5 rounded-lg border border-slate-200">
                                <option value="">Tất cả hãng</option>
                                @foreach($globalBrands ?? [] as $b)
                                    <option value="{{ $b->slug }}" {{ request('brand') == $b->slug ? 'selected' : '' }}>{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Hạng -->
                        <div>
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 mb-2">Hạng vợt</h4>
                            <select name="condition_grade" class="w-full text-xs p-2.5 rounded-lg border border-slate-200">
                                <option value="">Tất cả các hạng</option>
                                <option value="A" {{ request('condition_grade') == 'A' ? 'selected' : '' }}>Hạng A (95-99%)</option>
                                <option value="B" {{ request('condition_grade') == 'B' ? 'selected' : '' }}>Hạng B (88-94%)</option>
                                <option value="C" {{ request('condition_grade') == 'C' ? 'selected' : '' }}>Hạng C (80-87%)</option>
                            </select>
                        </div>

                        <!-- Giá -->
                        <div>
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 mb-2">Khoảng giá</h4>
                            <select name="price_range" class="w-full text-xs p-2.5 rounded-lg border border-slate-200">
                                <option value="">Tất cả mức giá</option>
                                <option value="under_1m" {{ request('price_range') == 'under_1m' ? 'selected' : '' }}>Dưới 1 triệu</option>
                                <option value="1m_2m" {{ request('price_range') == '1m_2m' ? 'selected' : '' }}>1 - 2 triệu</option>
                                <option value="2m_3m" {{ request('price_range') == '2m_3m' ? 'selected' : '' }}>2 - 3 triệu</option>
                                <option value="over_3m" {{ request('price_range') == 'over_3m' ? 'selected' : '' }}>Trên 3 triệu</option>
                            </select>
                        </div>

                        <!-- Trọng lượng -->
                        <div>
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 mb-2">Trọng lượng</h4>
                            <select name="weight" class="w-full text-xs p-2.5 rounded-lg border border-slate-200">
                                <option value="">Tất cả trọng lượng</option>
                                <option value="2U" {{ request('weight') == '2U' ? 'selected' : '' }}>2U</option>
                                <option value="3U" {{ request('weight') == '3U' ? 'selected' : '' }}>3U</option>
                                <option value="4U" {{ request('weight') == '4U' ? 'selected' : '' }}>4U</option>
                                <option value="5U" {{ request('weight') == '5U' ? 'selected' : '' }}>5U</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full py-3 rounded-xl bg-brand-600 text-white font-bold text-xs shadow-md">
                            Áp Dụng Bộ Lọc
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection
