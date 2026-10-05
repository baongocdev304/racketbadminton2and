@extends('layouts.app')

@section('title', 'Về Chúng Tôi - Showroom Vợt Cầu Lông 2Hand Uy Tín Số 1')
@section('meta_description', 'Hệ thống chuyên kinh doanh vợt cầu lông cũ (2hand) chính hãng Yonex, Victor, Lining tuyển chọn nghiêm ngặt. Cam kết nguyên bản 100%, tuyệt đối không bán vợt hàn nhiệt.')

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-900 font-bold">Giới thiệu về chúng tôi</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <article class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-sm space-y-8">
            <div>
                <span class="px-3 py-1 rounded-full bg-brand-50 text-brand-600 font-extrabold text-xs uppercase tracking-wider inline-block mb-3">
                    Thương Hiệu & Sứ Mệnh
                </span>
                <h1 class="text-3xl sm:text-4xl font-black text-slate-900 leading-tight">
                    Hệ Thống Phân Phối Vợt Cầu Lông 2Hand Tuyển Chọn
                </h1>
                <p class="text-slate-500 text-sm mt-2">Đồng hành cùng đam mê cầu lông với chi phí tối ưu nhất cho người chơi phong trào.</p>
            </div>

            <div class="prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-5">
                <p>
                    Được thành lập từ tình yêu mãnh liệt với bộ môn cầu lông, <strong>VỢT 2HAND PRO</strong> thấu hiểu rằng: một cây vợt cao cấp mang lại trải nghiệm thoát cầu, độ đầm và sự hưng phấn vượt trội trên sân. Tuy nhiên, mức giá từ 4 - 6 triệu đồng cho một cây vợt mới không phải người chơi nào cũng sẵn sàng chi trả.
                </p>
                <p>
                    Đó là lý do chúng tôi tiên phong xây dựng mô hình <strong>kinh doanh vợt cũ (2hand) minh bạch và uy tín tuyệt đối</strong>: Mỗi sản phẩm là một cây vợt độc bản duy nhất, được chụp ảnh chi tiết từng góc xước, kiểm định khung carbon chuyên sâu và công khai toàn bộ thông số trước khi mở bán.
                </p>

                <h3 class="text-xl font-extrabold text-slate-900 pt-4">Quy Trình Kiểm Định Vợt 2Hand 5 Bước Nghiêm Ngặt</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 not-prose my-6">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="w-7 h-7 rounded-lg bg-brand-600 text-white font-bold text-xs flex items-center justify-center mb-2">1</span>
                        <h4 class="font-bold text-slate-900 text-sm mb-1">Kiểm tra nguồn gốc & Code phân phối</h4>
                        <p class="text-xs text-slate-500">Soi mã khắc laser trên đũa và chụp mũ (JP, SP, CH, TW...) đảm bảo 100% chính hãng.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="w-7 h-7 rounded-lg bg-brand-600 text-white font-bold text-xs flex items-center justify-center mb-2">2</span>
                        <h4 class="font-bold text-slate-900 text-sm mb-1">Soi rạn nứt & Kiểm định phôi carbon</h4>
                        <p class="text-xs text-slate-500">Dùng kính phóng đại soi góc 12h, 2h, 10h. Cam kết đền tiền 200% nếu phát hiện vợt hàn nhiệt.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="w-7 h-7 rounded-lg bg-brand-600 text-white font-bold text-xs flex items-center justify-center mb-2">3</span>
                        <h4 class="font-bold text-slate-900 text-sm mb-1">Kiểm tra hệ thống gen vợt</h4>
                        <p class="text-xs text-slate-500">Thay mới các gen có dấu hiệu nứt lún để bảo vệ khung và cước khi đan số kg cao.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <span class="w-7 h-7 rounded-lg bg-brand-600 text-white font-bold text-xs flex items-center justify-center mb-2">4</span>
                        <h4 class="font-bold text-slate-900 text-sm mb-1">Phân hạng chất lượng (A / B / C)</h4>
                        <p class="text-xs text-slate-500">Đo lường độ mới thực tế tính theo % giúp khách hàng nắm rõ tình trạng ngoại hình.</p>
                    </div>
                </div>

                <h3 class="text-xl font-extrabold text-slate-900 pt-4">3 Cam Kết Vàng Từ Shop</h3>
                <ul class="list-disc list-inside space-y-2 text-slate-700">
                    <li><strong>Bao test sân 7 ngày:</strong> Được mang ra sân đánh thử thực tế, đổi cây khác ngay nếu phát hiện lỗi rung lắc bất thường.</li>
                    <li><strong>Chụp ảnh thật 100%:</strong> Giao đúng chính xác cây vợt có mã SKU trên website, mở hộp đồng kiểm trước thanh toán.</li>
                    <li><strong>Hỗ trợ thu cũ đổi mới:</strong> Sẵn sàng định giá cây vợt cũ của bạn để bù trừ lên đời dòng vợt cao hơn.</li>
                </ul>
            </div>
        </article>
    </div>

@endsection
