<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Danh sách sản phẩm với bộ lọc chuyên sâu và sắp xếp
     */
    public function index(Request $request): View
    {
        $query = Product::with(['brand', 'primaryImage']);

        // 1. Lọc theo thương hiệu
        if ($request->filled('brand')) {
            $brandSlug = $request->query('brand');
            $query->whereHas('brand', function ($q) use ($brandSlug) {
                $q->where('slug', $brandSlug);
            });
        }

        // 2. Lọc theo khoảng giá
        if ($request->filled('price_range')) {
            match ($request->query('price_range')) {
                'under_1m' => $query->where('price', '<', 1000000),
                '1m_2m'    => $query->whereBetween('price', [1000000, 2000000]),
                '2m_3m'    => $query->whereBetween('price', [2000000, 3000000]),
                'over_3m'  => $query->where('price', '>', 3000000),
                default    => null,
            };
        }

        // 3. Lọc theo trọng lượng (2U, 3U, 4U, 5U)
        if ($request->filled('weight')) {
            $query->where('weight_class', $request->query('weight'));
        }

        // 4. Lọc theo phân hạng tình trạng (A, B, C)
        if ($request->filled('condition_grade')) {
            $query->where('condition_grade', $request->query('condition_grade'));
        }

        // 5. Lọc theo trạng thái (available / sold) - Mặc định ưu tiên còn hàng
        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        // 6. Lọc sản phẩm xả kho
        if ($request->boolean('is_clearance')) {
            $query->where('is_clearance', true);
        }

        // 7. Sắp xếp
        match ($request->query('sort')) {
            'price_asc'    => $query->orderBy('price', 'asc'),
            'price_desc'   => $query->orderBy('price', 'desc'),
            'percent_desc' => $query->orderBy('condition_percent', 'desc'),
            default        => $query->orderByRaw("CASE WHEN status = 'available' THEN 1 WHEN status = 'reserved' THEN 2 ELSE 3 END")->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $selectedBrand = $request->filled('brand') ? Brand::where('slug', $request->query('brand'))->first() : null;
        $pageTitle = $selectedBrand ? "Vợt Cầu Lông Cũ {$selectedBrand->name} Chính Hãng" : 'Tất Cả Vợt Cầu Lông Cũ (2Hand)';

        return view('products.index', compact('products', 'pageTitle', 'selectedBrand'));
    }

    /**
     * Đường dẫn SEO thân thiện theo từng thương hiệu: /vot-cau-long-yonex.html
     */
    public function brandRackets(string $brandSlug, Request $request): View
    {
        $brand = Brand::where('slug', $brandSlug)->firstOrFail();
        $request->merge(['brand' => $brandSlug]);

        return $this->index($request);
    }

    /**
     * Trang chi tiết cây vợt độc bản: /vot/{slug}.html
     */
    public function show(string $slug): View
    {
        $product = Product::with(['brand', 'category', 'images'])->where('slug', $slug)->firstOrFail();

        // Sản phẩm liên quan cùng thương hiệu hoặc cùng tầm giá
        $relatedProducts = Product::with(['brand', 'primaryImage'])
            ->where('id', '!=', $product->id)
            ->where(function ($q) use ($product) {
                $q->where('brand_id', $product->brand_id)
                  ->orWhereBetween('price', [$product->price * 0.75, $product->price * 1.25]);
            })
            ->where('status', 'available')
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Tìm kiếm sản phẩm theo từ khóa
     */
    public function search(Request $request): View
    {
        $keyword = trim((string) $request->query('q', ''));

        $query = Product::with(['brand', 'primaryImage']);

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'ilike', "%{$keyword}%")
                  ->orWhere('sku', 'ilike', "%{$keyword}%")
                  ->orWhere('condition_note', 'ilike', "%{$keyword}%")
                  ->orWhereHas('brand', function ($b) use ($keyword) {
                      $b->where('name', 'ilike', "%{$keyword}%");
                  });
            });
        }

        $products = $query->paginate(12)->withQueryString();
        $pageTitle = "Kết quả tìm kiếm: \"{$keyword}\"";

        return view('products.index', compact('products', 'pageTitle', 'keyword'));
    }
}
