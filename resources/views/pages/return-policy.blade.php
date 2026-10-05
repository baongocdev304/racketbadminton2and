@extends('layouts.app')

@section('title', 'Chính Sách Đổi Trả 7 Ngày & Bảo Hành Vợt 2Hand')
@section('meta_description', 'Chính sách bảo hành và đổi trả vợt cầu lông cũ trong vòng 7 ngày tại Vợt 2Hand PRO. Bao test sân cầu, 1 đổi 1 nếu lỗi cấu trúc phôi.')

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-900 font-bold">Chính sách đổi trả 7 ngày</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <article class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-sm space-y-6">
            <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 font-extrabold text-xs uppercase tracking-wider inline-block">
                Cam Kết Uy Tín
            </span>
            <h1 class="text-3xl font-black text-slate-900 leading-tight">
                Chính Sách Đổi Trả & Bảo Hành Vợt 2Hand (7 Ngày Bao Test)
            </h1>

            <div class="prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
                <p>
                    Để khách hàng hoàn toàn yên tâm khi mua vợt cầu lông đã qua sử dụng, <strong>VỢT 2HAND PRO</strong> áp dụng chính sách <strong>BAO TEST SÂN CẦU 7 NGÀY</strong> độc quyền duy nhất trên thị trường.
                </p>

                <h3 class="text-lg font-bold text-slate-900 pt-3">1. Điều kiện áp dụng đổi trả trong 7 ngày</h3>
                <ul class="list-disc list-inside space-y-1 text-slate-600">
                    <li>Khách hàng được quyền mang vợt ra sân thi đấu thực tế trong 7 ngày kể từ ngày nhận hàng.</li>
                    <li>Nếu phát hiện vợt bị rung lắc bất thường do lỗi phôi ngầm hoặc không ưng ý cảm giác tay: được đổi sang cây vợt khác tương đương giá trị hoặc bù trừ chênh lệch.</li>
                    <li>Nếu phát hiện vợt hàn nhiệt hoặc hàng giả (fake): <strong>Hoàn tiền 200% ngay lập tức</strong>.</li>
                </ul>

                <h3 class="text-lg font-bold text-slate-900 pt-3">2. Các trường hợp KHÔNG áp dụng bảo hành</h3>
                <ul class="list-disc list-inside space-y-1 text-slate-600">
                    <li>Vợt bị gãy, nứt do va chạm trực tiếp trên sân (đấu kiếm với vợt đồng đội, đập vợt xuống sàn thảm hoặc đập vào lưới/cột).</li>
                    <li>Vợt tự ý đem đi đan cước tại các tiệm ngoài vượt quá mức căng (LBS) khuyến nghị ghi trên thân vợt dẫn đến méo khung sụt lún.</li>
                </ul>

                <h3 class="text-lg font-bold text-slate-900 pt-3">3. Quy trình gửi đổi trả</h3>
                <p>
                    Bước 1: Quý khách quay video ngắn hoặc chụp ảnh tình trạng gửi qua Zalo hotline: <strong>0901.234.567</strong>.<br>
                    Bước 2: Đóng gói cây vợt vào ống carton hoặc hộp xốp chống sốc ban đầu.<br>
                    Bước 3: Shipper đến tận nhà thu hồi vợt và giao cây vợt mới đổi trả đến tay bạn.
                </p>
            </div>
        </article>
    </div>

@endsection
