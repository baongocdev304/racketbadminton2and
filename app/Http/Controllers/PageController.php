<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Trang Giới thiệu showroom & Quy trình thẩm định vợt cũ
     */
    public function about(): View
    {
        return view('pages.about');
    }

    /**
     * Trang Chính sách đổi trả 7 ngày & Bảo hành
     */
    public function returnPolicy(): View
    {
        return view('pages.return-policy');
    }

    /**
     * Trang Hướng dẫn mua hàng & Đồng kiểm
     */
    public function buyingGuide(): View
    {
        return view('pages.buying-guide');
    }

    /**
     * Trang Cẩm nang & Hướng dẫn chọn vợt theo thông số
     */
    public function racketGuide(): View
    {
        return view('pages.racket-guide');
    }
}
