@extends('layouts.app')

@section('title', 'Thanh Toán Đơn Hàng - Vợt Cầu Lông 2Hand')

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-brand-600">Giỏ hàng</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-900 font-bold">Thanh toán đơn hàng</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12" x-data="{ paymentMethod: 'cod' }">
        
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">XÁC NHẬN & ĐẶT HÀNG</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Vui lòng điền thông tin người nhận để shop đóng gói gửi cây vợt độc bản của bạn.
            </p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs">
                <strong class="font-bold text-sm block mb-1">Vui lòng kiểm tra lại thông tin:</strong>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- CỘT TRÁI: FORM ĐIỀN THÔNG TIN KHÁCH & PHƯƠNG THỨC THANH TOÁN (7 COLS) -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- 1. THÔNG TIN NGƯỜI NHẬN -->
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                        <h2 class="font-extrabold text-base text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-3 border-b border-slate-100">
                            <span class="w-6 h-6 rounded-full bg-brand-600 text-white text-xs flex items-center justify-center">1</span>
                            <span>Thông Tin Người Nhận</span>
                        </h2>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="customer_name" class="block text-xs font-bold text-slate-700 mb-1">Họ và tên người nhận <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       id="customer_name" 
                                       name="customer_name" 
                                       value="{{ old('customer_name', $user?->name) }}" 
                                       placeholder="VD: Nguyễn Văn Cường" 
                                       required
                                       class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                            </div>

                            <div>
                                <label for="customer_phone" class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại liên hệ <span class="text-red-500">*</span></label>
                                <input type="tel" 
                                       id="customer_phone" 
                                       name="customer_phone" 
                                       value="{{ old('customer_phone', $user?->phone) }}" 
                                       placeholder="VD: 0901234567" 
                                       required
                                       class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                            </div>
                        </div>

                        <div>
                            <label for="customer_email" class="block text-xs font-bold text-slate-700 mb-1">Địa chỉ Email (Nhận mã tra cứu đơn hàng)</label>
                            <input type="email" 
                                   id="customer_email" 
                                   name="customer_email" 
                                   value="{{ old('customer_email', $user?->email) }}" 
                                   placeholder="VD: cuong.nguyen@gmail.com" 
                                   class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>

                        <div>
                            <label for="shipping_address" class="block text-xs font-bold text-slate-700 mb-1">Địa chỉ nhận hàng cụ thể <span class="text-red-500">*</span></label>
                            <input type="text" 
                                   id="shipping_address" 
                                   name="shipping_address" 
                                   value="{{ old('shipping_address', $user?->address) }}" 
                                   placeholder="Số nhà, tên đường, khu phố..." 
                                   required
                                   class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div>
                                <label for="shipping_city" class="block text-xs font-bold text-slate-700 mb-1">Tỉnh / Thành phố</label>
                                <input type="text" id="shipping_city" name="shipping_city" value="{{ old('shipping_city') }}" placeholder="TP.HCM" class="w-full text-xs p-2.5 rounded-lg border border-slate-200">
                            </div>
                            <div>
                                <label for="shipping_district" class="block text-xs font-bold text-slate-700 mb-1">Quận / Huyện</label>
                                <input type="text" id="shipping_district" name="shipping_district" value="{{ old('shipping_district') }}" placeholder="Quận 10" class="w-full text-xs p-2.5 rounded-lg border border-slate-200">
                            </div>
                            <div>
                                <label for="shipping_ward" class="block text-xs font-bold text-slate-700 mb-1">Phường / Xã</label>
                                <input type="text" id="shipping_ward" name="shipping_ward" value="{{ old('shipping_ward') }}" placeholder="Phường 12" class="w-full text-xs p-2.5 rounded-lg border border-slate-200">
                            </div>
                        </div>

                        <div>
                            <label for="note" class="block text-xs font-bold text-slate-700 mb-1">Ghi chú cho shipper hoặc yêu cầu thêm về vợt</label>
                            <textarea id="note" name="note" rows="2" placeholder="VD: Giao giờ hành chính, gọi trước 15 phút, nhờ đan sẵn cước BG65..." class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">{{ old('note') }}</textarea>
                        </div>
                    </div>

                    <!-- 2. PHƯƠNG THỨC THANH TOÁN -->
                    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                        <h2 class="font-extrabold text-base text-slate-900 uppercase tracking-wider flex items-center gap-2 pb-3 border-b border-slate-100">
                            <span class="w-6 h-6 rounded-full bg-brand-600 text-white text-xs flex items-center justify-center">2</span>
                            <span>Chọn Phương Thức Thanh Toán</span>
                        </h2>

                        <div class="space-y-3">
                            <!-- COD Option -->
                            <label class="flex items-start p-4 rounded-2xl border cursor-pointer transition-all"
                                   :class="paymentMethod === 'cod' ? 'border-brand-600 bg-brand-50/40 ring-2 ring-brand-500/20' : 'border-slate-200 hover:border-slate-300'">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="cod" 
                                       x-model="paymentMethod" 
                                       class="text-brand-600 focus:ring-brand-500 mt-1">
                                <div class="ml-3">
                                    <span class="font-extrabold text-sm text-slate-900 block">Thanh toán khi nhận hàng (COD)</span>
                                    <span class="text-xs text-slate-500 leading-relaxed block mt-0.5">
                                        Nhận hàng, mở hộp kiểm tra đúng cây vợt theo ảnh đã chọn rồi mới thanh toán tiền cho shipper.
                                    </span>
                                </div>
                            </label>

                            <!-- BANKING Option -->
                            <label class="flex items-start p-4 rounded-2xl border cursor-pointer transition-all"
                                   :class="paymentMethod === 'banking' ? 'border-brand-600 bg-brand-50/40 ring-2 ring-brand-500/20' : 'border-slate-200 hover:border-slate-300'">
                                <input type="radio" 
                                       name="payment_method" 
                                       value="banking" 
                                       x-model="paymentMethod" 
                                       class="text-brand-600 focus:ring-brand-500 mt-1">
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-extrabold text-sm text-slate-900">Chuyển khoản ngân hàng (Ưu tiên giữ cây vợt ngay)</span>
                                        <span class="px-2 py-0.5 rounded bg-amber-100 text-amber-800 text-[10px] font-bold">Khuyên dùng</span>
                                    </div>
                                    <span class="text-xs text-slate-500 leading-relaxed block mt-0.5">
                                        Chuyển khoản qua mã VietQR tự động. Sau khi đặt hàng, hệ thống sẽ hiện thông tin tài khoản và mã QR để bạn quét.
                                    </span>

                                    <!-- Bank Info Details Box -->
                                    <div x-show="paymentMethod === 'banking'" x-cloak class="mt-4 p-4 rounded-xl bg-white border border-brand-200 text-xs text-slate-700 space-y-1.5">
                                        <p class="font-bold text-slate-900 text-xs">Thông tin thụ hưởng chính thức của Shop:</p>
                                        <div class="grid grid-cols-2 gap-2 pt-1 font-mono text-[11px]">
                                            <div>Ngân hàng: <strong>{{ $bankInfo['bank_name'] }}</strong></div>
                                            <div>Số tài khoản: <strong class="text-brand-600 text-sm font-bold">{{ $bankInfo['account_number'] }}</strong></div>
                                            <div class="col-span-2">Chủ tài khoản: <strong>{{ $bankInfo['account_name'] }}</strong></div>
                                        </div>
                                        <p class="text-[10px] text-slate-400 italic pt-1">Nội dung chuyển khoản sẽ được tự động tạo kèm mã đơn hàng ở bước tiếp theo.</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- CỘT PHẢI: TÓM TẮT ĐƠN HÀNG & NÚT CHỐT ĐƠN (5 COLS) -->
                <div class="lg:col-span-5 bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-6">
                    <h2 class="font-extrabold text-base text-slate-900 uppercase tracking-wider pb-3 border-b border-slate-100 flex items-center justify-between">
                        <span>Đơn Hàng ({{ $products->count() }} cây)</span>
                        <a href="{{ route('cart.index') }}" class="text-xs text-brand-600 font-bold hover:underline lowercase">Sửa</a>
                    </h2>

                    <!-- Danh sách các cây vợt độc bản -->
                    <div class="divide-y divide-slate-100 max-h-80 overflow-y-auto pr-1">
                        @foreach($products as $item)
                            @php
                                $img = $item->primaryImage?->image_path ?? '/images/placeholder-racket.png';
                                if (!str_starts_with($img, 'http') && !str_starts_with($img, '/images/')) {
                                    $img = asset('storage/' . $img);
                                }
                            @endphp
                            <div class="py-3 flex items-center justify-between gap-3 text-xs">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $img }}" alt="{{ $item->name }}" class="w-12 h-12 rounded-xl object-cover bg-slate-100 flex-shrink-0">
                                    <div>
                                        <h4 class="font-bold text-slate-900 line-clamp-1">{{ $item->name }}</h4>
                                        <div class="text-[11px] text-slate-500 font-mono">Mã: {{ $item->sku }} • Hạng {{ $item->condition_grade }}</div>
                                    </div>
                                </div>
                                <span class="font-black text-red-600 whitespace-nowrap">{{ $item->formatted_price }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Tính toán tài chính -->
                    <div class="pt-4 border-t border-slate-100 space-y-2.5 text-xs text-slate-600">
                        <div class="flex justify-between">
                            <span>Tạm tính tiền vợt:</span>
                            <span class="font-bold text-slate-900">{{ number_format($subtotal, 0, ',', '.') }}đ</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span>Phí giao hàng:</span>
                            @if($shippingFee === 0)
                                <span class="font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">MIỄN PHÍ</span>
                            @else
                                <span class="font-bold text-slate-900">{{ number_format($shippingFee, 0, ',', '.') }}đ</span>
                            @endif
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex justify-between items-baseline">
                            <span class="font-bold text-sm text-slate-900">Tổng thanh toán:</span>
                            <span class="text-2xl font-black text-red-600">
                                {{ number_format($total, 0, ',', '.') }}đ
                            </span>
                        </div>
                    </div>

                    <!-- NÚT BẤM HOÀN TẤT ĐẶT HÀNG -->
                    <button type="submit" 
                            class="w-full py-4 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm uppercase tracking-wider shadow-lg shadow-brand-600/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Xác Nhận Đặt Hàng Ngay</span>
                    </button>

                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 text-[11px] text-slate-500 leading-relaxed space-y-1">
                        <p>🔒 <strong>Cơ chế khóa giữ hàng (lockForUpdate):</strong> Hệ thống sẽ tự động khóa và giữ cây vợt độc bản cho bạn ngay khi bấm nút trên, tránh trường hợp người khác mua trùng.</p>
                    </div>

                </div>

            </div>
        </form>

    </div>

@endsection
