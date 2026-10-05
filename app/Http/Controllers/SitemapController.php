<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Sinh sitemap.xml động phục vụ tối ưu hóa công cụ tìm kiếm (Google SEO)
     */
    public function index(): Response
    {
        $products = Product::where('status', 'available')->latest()->get();
        $brands = Brand::where('is_active', true)->get();
        $posts = Post::published()->latest('published_at')->get();

        $content = view('sitemap', compact('products', 'brands', 'posts'))->render();

        return response($content, 200)
            ->header('Content-Type', 'application/xml');
    }
}
