@extends('layouts.app')

@section('title', 'Hướng Dẫn Mua Hàng & Đồng Kiểm - Vợt Cầu Lông 2Hand')
@section('meta_description', 'Hướng dẫn đặt mua vợt cầu lông cũ online và quy trình mở hộp kiểm tra đúng cây vợt theo mã SKU trước khi thanh toán tiền.')

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-900 font-bold">Hướng dẫn mua hàng</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <article class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-sm space-y-6">
            <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-extrabold text-xs uppercase tracking-wider inline-block">
                Mua Sắm Dễ Dàng
            </span>
            <h1 class="text-3xl font-black text-slate-900 leading-tight">
                Hướng Dẫn Mua Hàng & Quy Trình Đồng Kiểm Khi Nhận Vợt
            </h1>

            <div class="prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-5">
                <p>
                    Để đảm bảo quyền lợi tối đa cho khách hàng trên toàn quốc khi mua vợt cũ (2hand) online, dưới đây là quy trình 4 bước đơn giản:
                </p>

                <div class="space-y-4 not-prose">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex gap-4 items-start">
                        <div class="w-8 h-8 rounded-full bg-brand-600 text-white font-extrabold flex items-center justify-center flex-shrink-0 text-sm">1</div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm mb-1">Chọn cây vợt và soi kỹ ảnh thật</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Mỗi sản phẩm có mã SKU và bộ ảnh chụp thực tế từng góc cạnh. Hãy xem kỹ các vết xước sơn (nếu có) được ghi chú chi tiết.</p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex gap-4 items-start">
                        <div class="w-8 h-8 rounded-full bg-brand-600 text-white font-extrabold flex items-center justify-center flex-shrink-0 text-sm">2</div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm mb-1">Bấm "Mua Ngay" hoặc "Thêm vào giỏ"</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Điền họ tên, số điện thoại và địa chỉ giao hàng. Chọn hình thức COD (trả tiền khi nhận) hoặc chuyển khoản VietQR.</p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex gap-4 items-start">
                        <div class="w-8 h-8 rounded-full bg-brand-600 text-white font-extrabold flex items-center justify-center flex-shrink-0 text-sm">3</div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm mb-1">Hệ thống khóa giữ cây vợt độc bản</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Ngay sau khi bấm đặt hàng, cây vợt đó sẽ được khóa ngay trên hệ thống (không ai khác có thể mua trùng cây của bạn).</p>
                        </div>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex gap-4 items-start">
                        <div class="w-8 h-8 rounded-full bg-brand-600 text-white font-extrabold flex items-center justify-center flex-shrink-0 text-sm">4</div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm mb-1">Mở hộp kiểm tra đúng cây trước khi thanh toán</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Khi shipper giao hàng, bạn được quyền mở hộp đồng kiểm: Soi đúng mã SKU và vết sơn thực tế trùng khớp với ảnh web thì mới nhận và thanh toán.</p>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>

@endsection
