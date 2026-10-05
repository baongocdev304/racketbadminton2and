@extends('layouts.app')

@section('title', 'Lịch Sử Đơn Hàng Của Tôi - Vợt Cầu Lông 2Hand')

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-900 font-bold">Lịch sử đơn hàng của tôi</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 pb-4 border-b border-slate-200">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">LỊCH SỬ ĐƠN HÀNG CỦA TÔI</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Xin chào <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})</p>
            </div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-xs shadow hover:bg-brand-700 transition-all">
                <span>Khám Phá Thêm Vợt Cũ</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-slate-50 text-slate-400 flex items-center justify-center mx-auto mb-4 border border-slate-100">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h2 class="text-lg font-bold text-slate-900 mb-2">Bạn chưa có đơn đặt vợt nào</h2>
                <p class="text-xs text-slate-500 mb-6">Mỗi cây vợt chỉ có 1 món duy nhất, hãy nhanh tay chọn cây vợt yêu thích nhé!</p>
                <a href="{{ route('products.index') }}" class="px-5 py-2.5 rounded-xl bg-brand-600 text-white font-bold text-xs hover:bg-brand-700 transition-colors">
                    Xem Kho Vợt 2Hand Ngay
                </a>
            </div>
        @else
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-500 uppercase tracking-wider font-bold border-b border-slate-200">
                            <tr>
                                <th class="p-4">Mã Đơn Hàng</th>
                                <th class="p-4">Ngày Đặt</th>
                                <th class="p-4">Sản Phẩm Đã Mua</th>
                                <th class="p-4 text-right">Tổng Tiền</th>
                                <th class="p-4 text-center">Thanh Toán</th>
                                <th class="p-4 text-center">Trạng Thái Đơn</th>
                                <th class="p-4 text-center">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($orders as $order)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="p-4 font-mono font-bold text-brand-600">
                                        <a href="{{ route('customer.orders.show', ['order_code' => $order->order_code]) }}" class="hover:underline">
                                            {{ $order->order_code }}
                                        </a>
                                    </td>
                                    <td class="p-4 text-slate-500">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="p-4">
                                        <ul class="space-y-1">
                                            @foreach($order->items as $it)
                                                <li class="font-medium text-slate-800">
                                                    {{ $it->product_name }} <span class="text-slate-400 font-mono">({{ $it->product_sku }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="p-4 text-right font-black text-red-600 text-sm">
                                        {{ $order->formatted_total }}
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                            {{ $order->payment_status === 'paid' ? 'Đã thanh toán' : 'Chưa thanh toán' }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ match($order->status) {
                                            'pending'   => 'bg-amber-100 text-amber-800',
                                            'confirmed' => 'bg-sky-100 text-sky-800',
                                            'shipping'  => 'bg-blue-100 text-blue-800',
                                            'completed' => 'bg-emerald-100 text-emerald-800',
                                            'cancelled' => 'bg-red-100 text-red-800',
                                            default     => 'bg-slate-100 text-slate-800',
                                        } }}">
                                            {{ $order->status_label }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center">
                                        <a href="{{ route('customer.orders.show', ['order_code' => $order->order_code]) }}" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-brand-50 text-slate-700 hover:text-brand-600 font-bold transition-colors">
                                            Chi tiết &rarr;
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100">
                    {{ $orders->links() }}
                </div>
            </div>
        @endif
    </div>

@endsection
