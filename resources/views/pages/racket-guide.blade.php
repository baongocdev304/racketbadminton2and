@extends('layouts.app')

@section('title', 'Hướng Dẫn Chọn Vợt Cầu Lông Chuẩn Thông Số - Vợt Cầu Lông 2Hand')
@section('meta_description', 'Bí quyết chọn vợt cầu lông phù hợp với lực cổ tay và lối chơi: hiểu rõ thông số 3U, 4U, G5, điểm cân bằng nặng đầu và độ dẻo đũa vợt.')

@section('content')

    <!-- BREADCRUMB -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <nav class="flex text-xs font-medium text-slate-500" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 sm:space-x-2">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-600">Trang chủ</a></li>
                    <li><span class="text-slate-300">/</span></li>
                    <li class="text-slate-900 font-bold">Hướng dẫn chọn vợt cầu lông</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <article class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-sm space-y-6">
            <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-800 font-extrabold text-xs uppercase tracking-wider inline-block">
                Cẩm Nang Chuyên Sâu
            </span>
            <h1 class="text-3xl font-black text-slate-900 leading-tight">
                Bí Quyết Chọn Vợt Cầu Lông Phù Hợp Cho Người Mới & Phong Trào
            </h1>

            <div class="prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-5">
                <p>
                    Chọn một cây vợt quá nặng hoặc quá cứng so với lực cổ tay là nguyên nhân hàng đầu gây chấn thương viêm khớp vai và khuỷu tay (tennis elbow). Hãy đọc kỹ các nguyên tắc sau:
                </p>

                <h3 class="text-lg font-bold text-slate-900 pt-2">1. Chọn Trọng Lượng (U)</h3>
                <ul class="list-disc list-inside space-y-1.5 text-slate-600">
                    <li><strong>4U (80 - 84g):</strong> Trọng lượng vàng phù hợp với 80% người chơi phong trào tại Việt Nam. Vợt nhẹ vừa phải, xoay chuyển linh hoạt giữa công và thủ.</li>
                    <li><strong>3U (85 - 89g):</strong> Dành cho anh em có thể lực tốt, cổ tay khỏe, thường xuyên chơi ở vị trí tấn công đập cầu cuối sân.</li>
                    <li><strong>5U (75 - 79g):</strong> Rất nhẹ, trợ lực cao, phù hợp cho nữ giới hoặc người mới tập chơi cần tốc độ phản tạt nhanh trên lưới.</li>
                </ul>

                <h3 class="text-lg font-bold text-slate-900 pt-2">2. Điểm Cân Bằng (Balance Point)</h3>
                <ul class="list-disc list-inside space-y-1.5 text-slate-600">
                    <li><strong>Nặng đầu (> 300mm):</strong> Dòng thiên công (VD: Yonex Astrox, Lining Axforce, Victor Thruster). Cầu cắm sâu và uy lực nhưng thủ cầu sẽ tốn sức hơn.</li>
                    <li><strong>Cân bằng (290 - 298mm):</strong> Công thủ toàn diện (VD: Yonex Arcsaber, Lining Halbertec). Đánh đầm tay, kiểm soát trận đấu dễ dàng.</li>
                    <li><strong>Nhẹ đầu (< 288mm):</strong> Dòng tốc độ và thủ cầu phản tạt nhanh (VD: Yonex Nanoflare, Victor Auraspeed).</li>
                </ul>

                <h3 class="text-lg font-bold text-slate-900 pt-2">3. Độ Cứng Thân Đũa (Flex)</h3>
                <p>
                    Người mới chơi hoặc lực tay trung bình nên chọn thân đũa <strong>Dẻo (Flexible)</strong> hoặc <strong>Trung bình (Medium)</strong> để có độ nhún đàn hồi trợ lực cho quả cầu bay sâu cuối sân. Thân <strong>Cứng (Stiff)</strong> chỉ nên dùng khi bạn đã thuần thục kỹ thuật vung vợt và có lực phát lực nhanh.
                </p>
            </div>
        </article>
    </div>

@endsection
