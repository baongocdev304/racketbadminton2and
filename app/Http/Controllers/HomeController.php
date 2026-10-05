<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Trang chủ website bán vợt cầu lông 2hand
     */
    public function index(): View
    {
        // 1. Banner slider trang chủ
        $heroBanners = Banner::active('home_hero')->get();

        // 2. Hàng mới về: Các cây vợt 2hand vừa cập bến, đang sẵn sàng bán
        $newArrivals = Product::with(['brand', 'primaryImage'])
            ->where('status', 'available')
            ->latest()
            ->limit(8)
            ->get();

        // 3. Vợt xả kho thanh lý giá sốc (Clearance Sale)
        $clearanceRackets = Product::with(['brand', 'primaryImage'])
            ->where('is_clearance', true)
            ->latest()
            ->limit(8)
            ->get();

        // 4. Danh mục nổi bật & Thương hiệu
        $featuredCategories = Category::where('is_active', true)
            ->withCount('products')
            ->take(3)
            ->get();

        $brands = Brand::where('is_active', true)
            ->withCount(['products' => function ($q) {
                $q->where('status', 'available');
            }])
            ->get();

        // 5. Tin tức, kiến thức & kinh nghiệm chọn vợt cũ
        $latestPosts = Post::published()
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('home', compact(
            'heroBanners',
            'newArrivals',
            'clearanceRackets',
            'featuredCategories',
            'brands',
            'latestPosts'
        ));
    }
}
