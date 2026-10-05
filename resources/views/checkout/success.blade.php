@extends('layouts.app')

@section('title', 'Đặt Hàng Thành Công - Mã Đơn ' . $order->order_code)

@section('content')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        
        <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-sm text-center">
            
            <!-- Success Icon -->
            <div class="w-20 h-20 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-6 shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>

            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider">
                ĐẶT HÀNG THÀNH CÔNG
            </span>

            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-3 mb-2">
                Cảm Ơn Bạn Đã Tin Tưởng Đặt Vợt!
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 max-w-lg mx-auto mb-6">
                Cây vợt độc bản của bạn đã được khóa giữ trong hệ thống. Shop sẽ liên hệ xác nhận và tiến hành đóng gói trong thời gian sớm nhất.
            </p>

            <!-- Mã đơn hàng nổi bật -->
            <div class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-slate-100 border border-slate-200 mb-8">
                <span class="text-xs text-slate-500">Mã đơn hàng của bạn:</span>
                <span class="font-mono font-black text-lg text-brand-600 tracking-wider">{{ $order->order_code }}</span>
            </div>

            <!-- NẾU CHỌN CHUYỂN KHOẢN: HIỆN THÔNG TIN TÀI KHOẢN VÀ MÃ QR VIETQR -->
            @if($order->payment_method === 'banking')
                <div class="my-8 p-6 sm:p-8 rounded-3xl bg-amber-50/60 border border-amber-200 text-left max-w-2xl mx-auto shadow-sm">
                    <div class="flex items-center gap-3 mb-4 pb-3 border-b border-amber-200">
                        <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold text-sm">QR</div>
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-base">Thông Tin Chuyển Khoản Giữ Vợt (VietQR)</h3>
                            <p class="text-xs text-slate-500">Quét mã QR bằng ứng dụng ngân hàng bất kỳ để thanh toán chính xác</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-center">
                        <!-- VietQR Image -->
                        <div class="text-center bg-white p-4 rounded-2xl border border-amber-200 shadow-inner">
                            <img src="{{ $vietQrUrl }}" alt="VietQR Thanh Toán" class="mx-auto rounded-lg max-h-56 object-contain">
                            <span class="text-[11px] text-slate-400 block mt-2">Mở app Ngân hàng &rarr; Chọn Quét QR</span>
                        </div>

                        <!-- Bank Details -->
                        <div class="space-y-3 text-xs text-slate-700">
                            <div>
                                <span class="text-slate-400 block">Ngân hàng:</span>
                                <strong class="text-slate-900 text-sm">MB Bank (Ngân Hàng Quân Đội)</strong>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Số tài khoản:</span>
                                <strong class="text-brand-600 text-base font-mono">0901234567</strong>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Chủ tài khoản:</span>
                                <strong class="text-slate-900 text-sm">NGUYEN BAO NGOC</strong>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Số tiền cần chuyển:</span>
                                <strong class="text-red-600 text-lg font-black">{{ $order->formatted_total }}</strong>
                            </div>
                            <div class="pt-2 border-t border-amber-200">
                                <span class="text-slate-400 block">Nội dung chuyển khoản (bắt buộc):</span>
                                <span class="inline-block mt-1 font-mono font-bold text-xs bg-white px-2.5 py-1 rounded border border-amber-300 text-slate-900">
                                    {{ $order->order_code }} {{ $order->customer_phone }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- CHI TIẾT ĐƠN HÀNG ĐÃ ĐẶT -->
            <div class="text-left max-w-2xl mx-auto rounded-2xl border border-slate-200 p-6 space-y-4 mb-8">
                <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider pb-2 border-b border-slate-100">
                    Chi Tiết Sản Phẩm Trong Đơn
                </h3>

                <div class="divide-y divide-slate-100 text-xs">
                    @foreach($order->items as $it)
                        <div class="py-2.5 flex items-center justify-between">
                            <div>
                                <strong class="text-slate-900 block">{{ $it->product_name }}</strong>
                                <span class="text-slate-400 font-mono text-[11px]">Mã SKU: {{ $it->product_sku }}</span>
                            </div>
                            <span class="font-bold text-slate-900">{{ $it->formatted_price }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="pt-3 border-t border-slate-100 text-xs space-y-1.5 text-slate-600">
                    <div class="flex justify-between">
                        <span>Hình thức thanh toán:</span>
                        <strong class="text-slate-900">{{ $order->payment_method === 'cod' ? 'COD (Tiền mặt khi nhận)' : 'Chuyển khoản VietQR' }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Người nhận hàng:</span>
                        <strong class="text-slate-900">{{ $order->customer_name }} ({{ $order->customer_phone }})</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Địa chỉ giao hàng:</span>
                        <strong class="text-slate-900 text-right">{{ $order->shipping_address }}</strong>
                    </div>
                </div>
            </div>

            <!-- ACTION BUTTONS -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('orders.tracking', ['order_code' => $order->order_code, 'customer_phone' => $order->customer_phone]) }}" 
                   class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs uppercase tracking-wider shadow-md transition-all">
                    <span>Tra Cứu Tiến Độ Đơn Hàng</span>
                </a>

                <a href="{{ route('home') }}" 
                   class="w-full sm:w-auto px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs uppercase tracking-wider transition-all">
                    <span>Tiếp Tục Mua Sắm</span>
                </a>
            </div>

        </div>

    </div>

@endsection
