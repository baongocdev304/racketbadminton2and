<!DOCTYPE html>
<html lang="vi" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Dynamic SEO Tags -->
    <title>@yield('title', 'Vợt Cầu Lông 2Hand PRO - Chuyên Vợt Cũ Chính Hãng Tuyển Chọn')</title>
    <meta name="description" content="@yield('meta_description', 'Hệ thống chuyên phân phối vợt cầu lông cũ (2hand) chính hãng Yonex, Victor, Lining tuyển chọn nghiêm ngặt. Cam kết nguyên bản 100%, bao test sân 7 ngày, bảo hành uy tín.')">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph (Facebook / Zalo sharing) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Vợt Cầu Lông 2Hand PRO - Chuyên Vợt Cũ Chính Hãng Tuyển Chọn')">
    <meta property="og:description" content="@yield('meta_description', 'Hệ thống chuyên phân phối vợt cầu lông cũ (2hand) chính hãng Yonex, Victor, Lining tuyển chọn nghiêm ngặt. Cam kết nguyên bản 100%, bao test sân 7 ngày, bảo hành uy tín.')">
    <meta property="og:image" content="@yield('og_image', url('/images/og-badminton-2hand.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="Vợt Cầu Lông 2Hand PRO">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Vợt Cầu Lông 2Hand PRO')">
    <meta name="twitter:description" content="@yield('meta_description', 'Chuyên cung cấp vợt cầu lông cũ tuyển chọn chính hãng.')">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Play CDN + Tailwind base for instant preview) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#fef2f2',
                            100: '#fee2e2',
                            500: '#ef4444',
                            600: '#dc2626',
                            700: '#b91c1c',
                            800: '#991b1b',
                            900: '#7f1d1d',
                        },
                        badminton: {
                            dark: '#0f172a',
                            navy: '#1e293b',
                            accent: '#f59e0b',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        .text-gradient {
            background: linear-gradient(135deg, #dc2626 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen text-slate-800 antialiased selection:bg-brand-500 selection:text-white" 
      x-data="{ 
          mobileMenuOpen: false,
          cartPopupOpen: false,
          cartItemCount: {{ $cartCount ?? 0 }},
          lastAddedProduct: { name: '', sku: '', price: '', image: '', grade: '', percent: '' },
          showCartPopup(product, newCount) {
              this.lastAddedProduct = product;
              this.cartItemCount = newCount;
              this.cartPopupOpen = true;
          }
      }"
      @added-to-cart.window="showCartPopup($event.detail.product, $event.detail.cart_count)">

    <!-- 1. TOP ANNOUNCEMENT BAR -->
    <div class="bg-badminton-dark text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-4">
                <span class="flex items-center gap-1.5 text-emerald-400 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Mỗi cây vợt là 1 món duy nhất - Xem thật mua đúng cây!
                </span>
                <span class="hidden md:inline text-slate-500">|</span>
                <span class="hidden md:inline">Cam kết 100% phôi carbon nguyên zin - Bao test 7 ngày</span>
            </div>
            
            <div class="flex items-center gap-4">
                <a href="{{ route('orders.tracking') }}" class="hover:text-amber-400 transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Tra cứu đơn hàng
                </a>
                <span class="text-slate-600">|</span>
                
                <!-- Auth status -->
                @auth
                    <div class="relative" x-data="{ userMenu: false }" @click.away="userMenu = false">
                        <button @click="userMenu = !userMenu" class="hover:text-white flex items-center gap-1 font-semibold text-slate-200">
                            <span>Chào, {{ Str::words(Auth::user()->name, 2, '') }}</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="userMenu" x-cloak class="absolute right-0 mt-2 w-48 bg-white text-slate-800 rounded-xl shadow-xl border border-slate-100 py-1.5 z-50 text-xs">
                            <a href="{{ route('customer.orders.index') }}" class="block px-4 py-2 hover:bg-slate-50 font-medium">Lịch sử đơn hàng</a>
                            @if(Auth::user()->isAdmin())
                                <a href="/admin" class="block px-4 py-2 hover:bg-slate-50 font-bold text-brand-600">Trang quản trị (Admin)</a>
                            @endif
                            <form action="{{ route('logout') }}" method="POST" class="border-t border-slate-100">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 font-medium">Đăng xuất</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hover:text-white transition-colors">Đăng nhập</a>
                    <span class="text-slate-600">/</span>
                    <a href="{{ route('register') }}" class="hover:text-white transition-colors">Đăng ký</a>
                @endauth

                <span class="text-slate-600">|</span>
                <a href="tel:0901234567" class="hover:text-amber-400 transition-colors flex items-center gap-1">
                    Hotline: <strong class="text-white">0901.234.567</strong>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. MAIN HEADER -->
    <header class="bg-white sticky top-0 z-40 shadow-sm border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5">
            <div class="flex items-center justify-between gap-4">
                
                <!-- Mobile Menu Button -->
                <button type="button" @click="mobileMenuOpen = true" class="lg:hidden p-2 text-slate-600 hover:text-brand-600 focus:outline-none" aria-label="Mở menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>

                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 to-amber-500 flex items-center justify-center text-white shadow-md shadow-brand-500/20 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
                    </div>
                    <div>
                        <div class="font-extrabold text-xl tracking-tight text-slate-900 group-hover:text-brand-600 transition-colors">
                            VỢT 2HAND <span class="text-brand-600">PRO</span>
                        </div>
                        <p class="text-[10px] uppercase font-semibold tracking-wider text-slate-400">Vợt Cầu Lông Cũ Tuyển Chọn</p>
                    </div>
                </a>

                <!-- Search Form -->
                <div class="hidden sm:flex flex-1 max-w-xl mx-4">
                    <form action="{{ route('products.search') }}" method="GET" class="w-full relative">
                        <input type="text" 
                               name="q" 
                               value="{{ request('q') }}"
                               placeholder="Tìm kiếm theo tên vợt, mã SKU, hãng Yonex, Victor..." 
                               class="w-full pl-4 pr-12 py-2.5 bg-slate-50 border border-slate-200 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition-all shadow-inner">
                        <button type="submit" class="absolute right-1.5 top-1.5 p-2 bg-brand-600 text-white rounded-full hover:bg-brand-700 transition-colors" aria-label="Tìm kiếm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </form>
                </div>

                <!-- Right Header Actions (Support & Cart) -->
                <div class="flex items-center gap-3 sm:gap-5">
                    <div class="hidden md:flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div class="text-xs">
                            <div class="text-slate-400 font-medium">Bảo hành 2Hand</div>
                            <div class="font-bold text-slate-900">Bao Test 7 Ngày</div>
                        </div>
                    </div>

                    <!-- Cart Button with Dynamic Badge Count -->
                    <a href="{{ route('cart.index') }}" class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-brand-50 text-slate-800 hover:text-brand-600 transition-colors relative group">
                        <div class="relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            <span x-text="cartItemCount" class="absolute -top-2 -right-2.5 bg-brand-600 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                {{ $cartCount ?? 0 }}
                            </span>
                        </div>
                        <span class="hidden sm:inline text-xs font-semibold">Giỏ Hàng</span>
                    </a>
                </div>

            </div>

            <!-- Mobile Search Bar (only below sm) -->
            <div class="mt-3 sm:hidden">
                <form action="{{ route('products.search') }}" method="GET" class="w-full relative">
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}"
                           placeholder="Tìm kiếm vợt cầu lông cũ..." 
                           class="w-full pl-4 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <button type="submit" class="absolute right-1 top-1 p-2 text-slate-500" aria-label="Tìm kiếm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- 3. NAVIGATION BAR & MEGA MENU -->
        <nav class="hidden lg:block bg-badminton-navy text-white text-sm border-t border-slate-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-1">
                        
                        <a href="{{ route('home') }}" class="px-4 py-3 font-semibold hover:bg-slate-800 transition-colors {{ request()->routeIs('home') ? 'bg-brand-600 text-white' : '' }}">
                            Trang Chủ
                        </a>

                        <!-- MEGA MENU: VỢT CẦU LÔNG CŨ -->
                        <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                            <a href="{{ route('products.index') }}" class="px-4 py-3 font-semibold hover:bg-slate-800 transition-colors flex items-center gap-1.5 {{ request()->routeIs('products.*') ? 'text-amber-400' : '' }}">
                                Vợt Cầu Lông Cũ (2Hand)
                                <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </a>

                            <!-- Mega Menu Dropdown -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-150" 
                                 x-transition:enter-start="opacity-0 translate-y-2" 
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100" 
                                 x-transition:leave-start="opacity-100 translate-y-0" 
                                 x-transition:leave-end="opacity-0 translate-y-2"
                                 class="absolute left-0 w-[640px] bg-white text-slate-800 shadow-2xl rounded-b-2xl border-t-2 border-brand-600 p-6 z-50">
                                
                                <div class="text-xs uppercase font-bold tracking-wider text-slate-400 mb-4 pb-2 border-b border-slate-100 flex justify-between items-center">
                                    <span>Chọn Vợt Theo Thương Hiệu</span>
                                    <a href="{{ route('products.index') }}" class="text-brand-600 hover:underline capitalize">Xem tất cả kho vợt &rarr;</a>
                                </div>

                                <div class="grid grid-cols-3 gap-4">
                                    @foreach($globalBrands ?? [] as $b)
                                        <a href="{{ route('products.brand', ['brand_slug' => $b->slug]) }}" 
                                           class="flex items-center justify-between p-3 rounded-xl bg-slate-50 hover:bg-brand-50 border border-slate-100 hover:border-brand-200 transition-all group/item">
                                            <span class="font-bold text-slate-800 group-hover/item:text-brand-600 transition-colors">{{ $b->name }}</span>
                                            <span class="text-xs px-2 py-0.5 rounded-full bg-white text-slate-500 border border-slate-200 group-hover/item:bg-brand-600 group-hover/item:text-white transition-colors">
                                                {{ $b->products_count }} cây
                                            </span>
                                        </a>
                                    @endforeach
                                </div>

                                <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between bg-slate-50 p-3 rounded-xl">
                                    <div class="text-xs text-slate-600">
                                        💡 <strong>Mẹo chọn vợt:</strong> Mỗi cây vợt có 1 mã SKU riêng kèm ảnh chụp thực tế từng góc.
                                    </div>
                                    <a href="{{ route('products.index', ['condition_grade' => 'A']) }}" class="text-xs font-bold text-emerald-600 hover:underline">
                                        Lọc Vợt Siêu Lướt Hạng A (95-99%) &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- VỢT HẠNG A (SIÊU LƯỚT) -->
                        <a href="{{ route('products.index', ['condition_grade' => 'A']) }}" class="px-4 py-3 font-semibold hover:bg-slate-800 transition-colors text-emerald-400 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            Hàng Siêu Lướt (95-99%)
                        </a>

                        <!-- XẢ KHO GIÁ SỐC -->
                        <a href="{{ route('products.index', ['is_clearance' => 1]) }}" class="px-4 py-3 font-semibold hover:bg-slate-800 transition-colors text-amber-400 flex items-center gap-1.5">
                            <span class="animate-bounce">🔥</span>
                            Xả Kho Thanh Lý
                        </a>

                        <!-- TIN TỨC & CẨM NANG -->
                        <a href="{{ route('posts.index') }}" class="px-4 py-3 font-semibold hover:bg-slate-800 transition-colors {{ request()->routeIs('posts.*') ? 'text-amber-400' : '' }}">
                            Tin Tức & Cẩm Nang
                        </a>

                        <!-- GIỚI THIỆU & CHÍNH SÁCH -->
                        <a href="{{ route('pages.about') }}" class="px-4 py-3 font-semibold hover:bg-slate-800 transition-colors {{ request()->routeIs('pages.about') ? 'text-amber-400' : '' }}">
                            Về Chúng Tôi
                        </a>
                    </div>

                    <div class="text-xs font-medium text-slate-400">
                        ⚡ Miễn phí ship đơn từ 2.000.000đ
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- 4. MOBILE DRAWER MENU -->
    <div x-show="mobileMenuOpen" 
         x-cloak 
         class="relative z-50 lg:hidden" 
         role="dialog" 
         aria-modal="true">
        
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-linear duration-200" 
             x-transition:enter-start="opacity-0" 
             x-transition:enter-end="opacity-100" 
             x-transition:leave="transition-opacity ease-linear duration-200" 
             x-transition:leave-start="opacity-100" 
             x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" 
             @click="mobileMenuOpen = false"></div>

        <div class="fixed inset-0 flex z-50">
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-in-out duration-300 transform" 
                 x-transition:enter-start="-translate-x-full" 
                 x-transition:enter-end="translate-x-0" 
                 x-transition:leave="transition ease-in-out duration-300 transform" 
                 x-transition:leave-start="translate-x-0" 
                 x-transition:leave-end="-translate-x-full" 
                 class="relative max-w-xs w-full bg-white h-full shadow-2xl p-6 overflow-y-auto flex flex-col justify-between">
                
                <div>
                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div class="font-extrabold text-lg tracking-tight text-slate-900">
                            VỢT 2HAND <span class="text-brand-600">PRO</span>
                        </div>
                        <button type="button" @click="mobileMenuOpen = false" class="p-2 text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="mt-6 space-y-2">
                        <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg font-semibold text-slate-800 hover:bg-slate-100">Trang Chủ</a>
                        
                        <div x-data="{ expanded: true }">
                            <button @click="expanded = !expanded" class="w-full flex items-center justify-between px-3 py-2 rounded-lg font-semibold text-slate-800 hover:bg-slate-100">
                                <span>Vợt Cầu Lông Theo Hãng</span>
                                <svg class="w-4 h-4 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="expanded" class="pl-4 py-2 space-y-1">
                                <a href="{{ route('products.index') }}" class="block px-3 py-1.5 text-sm text-brand-600 font-medium">Tất cả vợt cũ</a>
                                @foreach($globalBrands ?? [] as $b)
                                    <a href="{{ route('products.brand', ['brand_slug' => $b->slug]) }}" class="block px-3 py-1.5 text-sm text-slate-600 hover:text-brand-600">
                                        Vợt {{ $b->name }} ({{ $b->products_count }})
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <a href="{{ route('products.index', ['condition_grade' => 'A']) }}" class="block px-3 py-2 rounded-lg font-semibold text-emerald-600 hover:bg-emerald-50">
                            ✨ Hàng Siêu Lướt (Hạng A)
                        </a>
                        <a href="{{ route('products.index', ['is_clearance' => 1]) }}" class="block px-3 py-2 rounded-lg font-semibold text-amber-600 hover:bg-amber-50">
                            🔥 Xả Kho Thanh Lý
                        </a>
                        <a href="{{ route('posts.index') }}" class="block px-3 py-2 rounded-lg font-semibold text-slate-700 hover:bg-slate-50">
                            📰 Tin Tức & Cẩm Nang
                        </a>
                        <a href="{{ route('orders.tracking') }}" class="block px-3 py-2 rounded-lg font-semibold text-slate-700 hover:bg-slate-50">
                            🔍 Tra Cứu Đơn Hàng
                        </a>
                        <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-lg font-semibold text-slate-700 hover:bg-slate-50">
                            🛒 Xem Giỏ Hàng (<span x-text="cartItemCount">{{ $cartCount ?? 0 }}</span>)
                        </a>

                        @auth
                            <div class="pt-4 border-t border-slate-100">
                                <a href="{{ route('customer.orders.index') }}" class="block px-3 py-2 text-sm font-bold text-slate-800">Lịch sử đơn hàng của tôi</a>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 font-bold">Đăng xuất</button>
                                </form>
                            </div>
                        @else
                            <div class="pt-4 border-t border-slate-100 flex gap-2">
                                <a href="{{ route('login') }}" class="flex-1 py-2 rounded-lg bg-slate-100 text-center font-bold text-xs text-slate-800">Đăng Nhập</a>
                                <a href="{{ route('register') }}" class="flex-1 py-2 rounded-lg bg-brand-600 text-center font-bold text-xs text-white">Đăng Ký</a>
                            </div>
                        @endauth
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 text-xs text-slate-500">
                    <p class="font-bold text-slate-800 mb-1">Cửa hàng Vợt Cầu Lông 2Hand</p>
                    <p>Showroom: 123 Đường Cầu Lông, Quận 10, TP.HCM</p>
                    <p class="mt-2 text-brand-600 font-bold">Hotline: 0901.234.567</p>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN BODY CONTENT -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- 5. POPUP "ĐÃ THÊM VÀO GIỎ HÀNG" (ALPINE.JS MODAL) -->
    <div x-show="cartPopupOpen" 
         x-cloak 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200 text-center relative"
             @click.away="cartPopupOpen = false">
            
            <button @click="cartPopupOpen = false" class="absolute top-4 right-4 p-2 text-slate-400 hover:text-slate-600 rounded-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>

            <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-3 shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>

            <h3 class="font-extrabold text-lg text-slate-900 mb-1">ĐÃ THÊM VÀO GIỎ HÀNG!</h3>
            <p class="text-xs text-slate-500 mb-5">Cây vợt độc bản đã được đưa vào giỏ hàng của bạn.</p>

            <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center gap-3 text-left mb-6">
                <img :src="lastAddedProduct.image" class="w-14 h-14 rounded-xl object-cover bg-white border border-slate-200 flex-shrink-0">
                <div class="overflow-hidden">
                    <h4 class="font-bold text-xs text-slate-900 truncate" x-text="lastAddedProduct.name"></h4>
                    <div class="text-[11px] text-slate-500 font-mono mt-0.5">
                        Mã: <span x-text="lastAddedProduct.sku"></span> • Hạng <span x-text="lastAddedProduct.grade"></span> (<span x-text="lastAddedProduct.percent"></span>%)
                    </div>
                    <div class="font-extrabold text-red-600 text-xs mt-1" x-text="lastAddedProduct.price"></div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <button type="button" 
                        @click="cartPopupOpen = false" 
                        class="py-3 px-4 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-100 font-bold text-xs transition-colors">
                    Xem Thêm Vợt Khác
                </button>
                <a href="{{ route('cart.index') }}" 
                   class="py-3 px-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-600/30 transition-all flex items-center justify-center gap-1">
                    <span>Xem Giỏ Hàng</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 6. FLOATING ZALO CONTACT BUTTON -->
    <div class="fixed bottom-6 right-6 z-40 flex flex-col items-end gap-3">
        <a href="https://zalo.me/0901234567" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="group flex items-center gap-2.5 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-full shadow-xl shadow-blue-600/30 hover:shadow-blue-600/50 hover:scale-105 transition-all">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-white"></span>
            </span>
            <div class="w-6 h-6 rounded-full bg-white text-blue-600 font-black text-xs flex items-center justify-center">Z</div>
            <span class="text-xs font-bold tracking-wide">Tư vấn Zalo (Ảnh thật)</span>
        </a>
    </div>

    <!-- 7. FOOTER -->
    <footer id="chinh-sach" class="bg-badminton-dark text-slate-300 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-slate-800 text-sm">
                
                <!-- Col 1: Giới thiệu shop -->
                <div>
                    <div class="flex items-center gap-2 text-white font-extrabold text-xl mb-4">
                        <div class="w-8 h-8 rounded-lg bg-brand-600 flex items-center justify-center text-white text-sm">2H</div>
                        VỢT 2HAND PRO
                    </div>
                    <p class="text-slate-400 text-xs leading-relaxed mb-4">
                        Hệ thống phân phối vợt cầu lông cũ (2hand) chính hãng uy tín số 1 Việt Nam. Mỗi cây vợt là độc bản được thẩm định khung nghiêm ngặt, bao check mã Sunrise/code phân phối trọn đời.
                    </p>
                    <div class="text-xs text-slate-400 space-y-1">
                        <p><strong class="text-slate-200">Địa chỉ:</strong> 123 Đường Cầu Lông, Quận 10, TP.HCM</p>
                        <p><strong class="text-slate-200">Hotline/Zalo:</strong> 0901.234.567</p>
                        <p><strong class="text-slate-200">Giờ mở cửa:</strong> 8:30 - 21:30 hàng ngày</p>
                    </div>
                </div>

                <!-- Col 2: Thương hiệu -->
                <div>
                    <h4 class="text-white font-bold uppercase text-xs tracking-wider mb-4 border-l-2 border-brand-500 pl-2.5">
                        Thương Hiệu Tuyển Chọn
                    </h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        @foreach($globalBrands ?? [] as $b)
                            <li>
                                <a href="{{ route('products.brand', ['brand_slug' => $b->slug]) }}" class="hover:text-amber-400 transition-colors flex items-center justify-between">
                                    <span>Vợt Cầu Lông {{ $b->name }} Cũ</span>
                                    <span class="text-slate-600">({{ $b->products_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Col 3: Chính sách & Hướng dẫn -->
                <div>
                    <h4 class="text-white font-bold uppercase text-xs tracking-wider mb-4 border-l-2 border-brand-500 pl-2.5">
                        Chính Sách & Hướng Dẫn
                    </h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ route('pages.about') }}" class="hover:text-amber-400 transition-colors">Về chúng tôi & Quy trình kiểm định</a></li>
                        <li><a href="{{ route('pages.return-policy') }}" class="hover:text-amber-400 transition-colors">Chính sách bao test sân 7 ngày (1 đổi 1)</a></li>
                        <li><a href="{{ route('pages.buying-guide') }}" class="hover:text-amber-400 transition-colors">Hướng dẫn mua hàng & Đồng kiểm COD</a></li>
                        <li><a href="{{ route('pages.racket-guide') }}" class="hover:text-amber-400 transition-colors">Hướng dẫn chọn vợt theo thông số 3U/4U</a></li>
                        <li><a href="{{ route('orders.tracking') }}" class="text-amber-400 font-semibold hover:underline">&rarr; Tra cứu tiến độ đơn hàng</a></li>
                        <li><a href="{{ route('sitemap') }}" class="hover:text-white transition-colors">Sơ đồ trang web (Sitemap XML)</a></li>
                    </ul>
                </div>

                <!-- Col 4: Hướng dẫn phân hạng 2hand -->
                <div>
                    <h4 class="text-white font-bold uppercase text-xs tracking-wider mb-4 border-l-2 border-brand-500 pl-2.5">
                        Quy Chuẩn Phân Hạng 2Hand
                    </h4>
                    <div class="space-y-3 text-xs">
                        <div class="p-2.5 rounded-lg bg-slate-900 border border-slate-800">
                            <div class="font-bold text-emerald-400 mb-0.5">Hạng A: Siêu Lướt (95-99%)</div>
                            <p class="text-slate-400 text-[11px]">Đánh lướt vài set, sơn bóng loáng không tì vết, gen zin nguyên bản.</p>
                        </div>
                        <div class="p-2.5 rounded-lg bg-slate-900 border border-slate-800">
                            <div class="font-bold text-sky-400 mb-0.5">Hạng B: Đẹp Keng (88-94%)</div>
                            <p class="text-slate-400 text-[11px]">Xước dăm nhẹ góc vành do cọ thảm, phôi carbon nguyên khối đan 11kg tốt.</p>
                        </div>
                        <div class="p-2.5 rounded-lg bg-slate-900 border border-slate-800">
                            <div class="font-bold text-amber-400 mb-0.5">Hạng C: Chiến Binh (80-87%)</div>
                            <p class="text-slate-400 text-[11px]">Tróc sơn viền đầu nhưng kết cấu hoàn hảo, giá rẻ bất ngờ cho học sinh sinh viên.</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Vợt Cầu Lông 2Hand PRO. Tất cả các quyền được bảo lưu.</p>
                <div class="flex items-center gap-4">
                    <span>Thanh toán: Tiền mặt, Chuyển khoản VietQR, COD toàn quốc</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
