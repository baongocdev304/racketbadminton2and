@extends('layouts.app')

@section('title', 'Kiểm Tra Đơn Hàng - Tra Cứu Tiến Độ Giao Vợt')

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-900 font-bold">Tra cứu tiến độ đơn hàng</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        
        <!-- HEADER & FORM TRA CỨU -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm mb-10">
            <div class="max-w-xl mx-auto text-center mb-8">
                <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900">TRA CỨU TIẾN ĐỘ ĐƠN HÀNG</h1>
                <p class="text-xs text-slate-500 mt-1">
                    Nhập mã đơn hàng và số điện thoại bạn đã dùng khi đặt vợt để theo dõi tình trạng xử lý và vận chuyển.
                </p>
            </div>

            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('orders.lookup') }}" method="POST" class="max-w-xl mx-auto space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="order_code" class="block text-xs font-bold text-slate-700 mb-1">Mã đơn hàng <span class="text-red-500">*</span></label>
                        <input type="text" 
                               id="order_code" 
                               name="order_code" 
                               value="{{ old('order_code', request('order_code')) }}" 
                               placeholder="VD: ORD-20261004-XXXX" 
                               required
                               class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none uppercase font-mono">
                    </div>

                    <div>
                        <label for="customer_phone" class="block text-xs font-bold text-slate-700 mb-1">Số điện thoại đặt hàng <span class="text-red-500">*</span></label>
                        <input type="tel" 
                               id="customer_phone" 
                               name="customer_phone" 
                               value="{{ old('customer_phone', request('customer_phone')) }}" 
                               placeholder="VD: 0901234567" 
                               required
                               class="w-full text-xs p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-brand-500 focus:outline-none">
                    </div>
                </div>

                <button type="submit" 
                        class="w-full py-3.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs uppercase tracking-wider shadow-md transition-all">
                    Tra Cứu Đơn Hàng
                </button>
            </form>
        </div>

        <!-- KẾT QUẢ TRA CỨU ĐƠN HÀNG (NẾU TÌM THẤY) -->
        @if($order)
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm space-y-8 animate-fade-in">
                
                <!-- Order Header -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
                    <div>
                        <span class="text-xs text-slate-400 font-mono">Mã đơn hàng:</span>
                        <h2 class="text-xl sm:text-2xl font-black text-brand-600 font-mono">{{ $order->order_code }}</h2>
                        <span class="text-xs text-slate-400">Thời gian đặt: {{ $order->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold
                            {{ match($order->status) {
                                'pending'   => 'bg-amber-100 text-amber-800',
                                'confirmed' => 'bg-sky-100 text-sky-800',
                                'shipping'  => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-emerald-100 text-emerald-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                default     => 'bg-slate-100 text-slate-800',
                            } }}">
                            Trạng thái: {{ $order->status_label }}
                        </span>

                        <span class="px-3 py-1.5 rounded-full text-xs font-bold
                            {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-800' }}">
                            {{ $order->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                        </span>
                    </div>
                </div>

                <!-- PROGRESS STEPPER (TIẾN ĐỘ) -->
                @if($order->status !== 'cancelled')
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-6 text-center sm:text-left">
                            Tiến Độ Xử Lý & Giao Hàng
                        </h3>

                        @php
                            $stepIndex = match($order->status) {
                                'pending'   => 1,
                                'confirmed' => 2,
                                'shipping'  => 3,
                                'completed' => 4,
                                default     => 1,
                            };
                        @endphp

                        <div class="grid grid-cols-4 gap-2 text-center text-xs relative">
                            <!-- Step 1 -->
                            <div class="space-y-2">
                                <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center font-bold {{ $stepIndex >= 1 ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-400' }}">1</div>
                                <span class="block font-bold text-slate-800">Chờ xử lý</span>
                            </div>
                            <!-- Step 2 -->
                            <div class="space-y-2">
                                <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center font-bold {{ $stepIndex >= 2 ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-400' }}">2</div>
                                <span class="block font-bold text-slate-800">Đã xác nhận</span>
                            </div>
                            <!-- Step 3 -->
                            <div class="space-y-2">
                                <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center font-bold {{ $stepIndex >= 3 ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-400' }}">3</div>
                                <span class="block font-bold text-slate-800">Đang giao</span>
                            </div>
                            <!-- Step 4 -->
                            <div class="space-y-2">
                                <div class="w-8 h-8 rounded-full mx-auto flex items-center justify-center font-bold {{ $stepIndex >= 4 ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-400' }}">4</div>
                                <span class="block font-bold text-slate-800">Hoàn tất</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-red-50 text-red-700 text-xs font-bold text-center">
                        ⚠️ Đơn hàng này đã bị hủy. Cây vợt đã được đưa trở lại danh sách bán sẵn cho khách hàng khác.
                    </div>
                @endif

                <!-- CHI TIẾT SẢN PHẨM SNAPSHOT -->
                <div>
                    <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider mb-3">
                        Sản Phẩm Trong Đơn Hàng (Snapshot độc bản)
                    </h3>

                    <div class="rounded-2xl border border-slate-200 overflow-hidden divide-y divide-slate-100 text-xs">
                        @foreach($order->items as $it)
                            <div class="p-4 flex items-center justify-between">
                                <div>
                                    <strong class="text-slate-900 text-sm block">{{ $it->product_name }}</strong>
                                    <span class="text-slate-400 font-mono">Mã SKU: {{ $it->product_sku }}</span>
                                </div>
                                <span class="font-black text-red-600 text-sm">{{ $it->formatted_price }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- THÔNG TIN GIAO HÀNG & THANH TOÁN -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-slate-100 text-xs">
                    <div class="space-y-1.5 text-slate-600">
                        <span class="font-bold text-slate-900 block mb-2">Thông tin người nhận:</span>
                        <p>Họ tên: <strong class="text-slate-900">{{ $order->customer_name }}</strong></p>
                        <p>Điện thoại: <strong class="text-slate-900">{{ $order->customer_phone }}</strong></p>
                        <p>Địa chỉ: <strong class="text-slate-900">{{ $order->shipping_address }}</strong></p>
                        @if($order->note)
                            <p>Ghi chú: <span class="italic text-slate-500">{{ $order->note }}</span></p>
                        @endif
                    </div>

                    <div class="space-y-2 text-slate-600 sm:text-right">
                        <span class="font-bold text-slate-900 block mb-2">Thanh toán:</span>
                        <p>Hình thức: <strong>{{ $order->payment_method === 'cod' ? 'COD (Tiền mặt)' : 'Chuyển khoản VietQR' }}</strong></p>
                        <p>Phí vận chuyển: <strong>{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</strong></p>
                        <p class="text-sm">Tổng cộng: <strong class="text-red-600 font-black text-base">{{ $order->formatted_total }}</strong></p>
                    </div>
                </div>

            </div>
        @endif

    </div>

@endsection
