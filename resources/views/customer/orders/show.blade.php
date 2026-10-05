@extends('layouts.app')

@section('title', 'Chi Tiết Đơn Hàng ' . $order->order_code . ' - Vợt Cầu Lông 2Hand')

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li><a href="{{ route('customer.orders.index') }}" class="hover:text-brand-600">Đơn hàng của tôi</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-900 font-bold font-mono">{{ $order->order_code }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm space-y-8">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
                <div>
                    <span class="text-xs text-slate-400 font-mono">Chi tiết đơn hàng:</span>
                    <h1 class="text-2xl font-black text-brand-600 font-mono">{{ $order->order_code }}</h1>
                    <span class="text-xs text-slate-400">Thời gian tạo: {{ $order->created_at->format('d/m/Y H:i:s') }}</span>
                </div>

                <div class="flex items-center gap-2">
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ match($order->status) {
                        'pending'   => 'bg-amber-100 text-amber-800',
                        'confirmed' => 'bg-sky-100 text-sky-800',
                        'shipping'  => 'bg-blue-100 text-blue-800',
                        'completed' => 'bg-emerald-100 text-emerald-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                        default     => 'bg-slate-100 text-slate-800',
                    } }}">
                        {{ $order->status_label }}
                    </span>
                    <span class="px-3 py-1.5 rounded-full text-xs font-bold {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                        {{ $order->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                    </span>
                </div>
            </div>

            <!-- DANH SÁCH VỢT ĐÃ ĐẶT SNAPSHOT -->
            <div>
                <h3 class="font-extrabold text-sm text-slate-900 uppercase tracking-wider mb-4">
                    Danh Sách Vợt 2Hand Trong Đơn
                </h3>

                <div class="rounded-2xl border border-slate-200 overflow-hidden divide-y divide-slate-100 text-xs">
                    @foreach($order->items as $it)
                        <div class="p-4 flex items-center justify-between">
                            <div>
                                <strong class="text-slate-900 text-sm block">{{ $it->product_name }}</strong>
                                <span class="text-slate-400 font-mono">Mã SKU độc bản: {{ $it->product_sku }}</span>
                            </div>
                            <span class="font-black text-red-600 text-sm">{{ $it->formatted_price }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- THÔNG TIN GIAO HÀNG & THANH TOÁN -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-slate-100 text-xs">
                <div class="space-y-1.5 text-slate-600">
                    <span class="font-bold text-slate-900 block mb-2 text-sm">Địa chỉ giao hàng:</span>
                    <p>Người nhận: <strong class="text-slate-900">{{ $order->customer_name }}</strong></p>
                    <p>Số điện thoại: <strong class="text-slate-900">{{ $order->customer_phone }}</strong></p>
                    <p>Địa chỉ: <strong class="text-slate-900">{{ $order->shipping_address }}</strong></p>
                    @if($order->note)
                        <p class="italic text-slate-500">Ghi chú: {{ $order->note }}</p>
                    @endif
                </div>

                <div class="space-y-2 text-slate-600 sm:text-right">
                    <span class="font-bold text-slate-900 block mb-2 text-sm">Thanh toán:</span>
                    <p>Hình thức: <strong>{{ $order->payment_method === 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản VietQR' }}</strong></p>
                    <p>Phí vận chuyển: <strong>{{ number_format($order->shipping_fee, 0, ',', '.') }}đ</strong></p>
                    <p class="text-sm">Tổng cộng: <strong class="text-red-600 font-black text-base">{{ $order->formatted_total }}</strong></p>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between text-xs">
                <a href="{{ route('customer.orders.index') }}" class="font-bold text-slate-600 hover:text-brand-600">
                    &larr; Quay lại danh sách đơn hàng
                </a>
                <a href="https://zalo.me/0901234567" target="_blank" class="font-bold text-blue-600 hover:underline">
                    Cần hỗ trợ về đơn hàng này? Chat Zalo ngay
                </a>
            </div>

        </div>
    </div>

@endsection
