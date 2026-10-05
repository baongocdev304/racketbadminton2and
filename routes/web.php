<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Customer\OrderHistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Hệ thống Web Bán Vợt Cầu Lông 2Hand
|--------------------------------------------------------------------------
*/

// 1. Trang chủ & Sitemap SEO
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// 2. Tìm kiếm sản phẩm
Route::get('/tim-kiem', [ProductController::class, 'search'])->name('products.search');

// 3. Danh mục & SEO Friendly URLs cho thương hiệu
Route::get('/vot-cau-long.html', [ProductController::class, 'index'])->name('products.index');
Route::get('/vot-cau-long-{brand_slug}.html', [ProductController::class, 'brandRackets'])->name('products.brand');

// 4. Chi tiết cây vợt độc bản: /vot/{slug}.html
Route::get('/vot/{slug}.html', [ProductController::class, 'show'])->name('products.show');

// 5. Quản lý Giỏ hàng (Cart)
Route::prefix('gio-hang')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/them', [CartController::class, 'add'])->name('add');
    Route::post('/xoa/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('/lam-trong', [CartController::class, 'clear'])->name('clear');
});

// 6. Thanh toán & Chốt đơn hàng (Checkout)
Route::get('/thanh-toan', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/thanh-toan/xu-ly', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/cam-on/{order_code}', [CheckoutController::class, 'success'])->name('checkout.success');

// 7. Tra cứu & Kiểm tra tiến độ đơn hàng
Route::get('/kiem-tra-don-hang', [OrderTrackingController::class, 'index'])->name('orders.tracking');
Route::post('/kiem-tra-don-hang', [OrderTrackingController::class, 'lookup'])->name('orders.lookup');

// 8. Tin tức & Cẩm nang kiến thức
Route::get('/tin-tuc', [PostController::class, 'index'])->name('posts.index');
Route::get('/bai-viet/{slug}.html', [PostController::class, 'show'])->name('posts.show');

// 9. Các trang tĩnh (Giới thiệu, Chính sách, Hướng dẫn)
Route::get('/gioi-thieu', [PageController::class, 'about'])->name('pages.about');
Route::get('/chinh-sach-doi-tra', [PageController::class, 'returnPolicy'])->name('pages.return-policy');
Route::get('/huong-dan-mua-hang', [PageController::class, 'buyingGuide'])->name('pages.buying-guide');
Route::get('/huong-dan-chon-vot', [PageController::class, 'racketGuide'])->name('pages.racket-guide');

// 10. Xác thực khách hàng (Authentication: Đăng ký & Đăng nhập)
Route::middleware('guest')->group(function () {
    Route::get('/dang-nhap', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/dang-nhap', [AuthenticatedSessionController::class, 'store']);

    Route::get('/dang-ky', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/dang-ky', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/dang-xuat', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // Lịch sử đơn hàng của tài khoản khách
    Route::prefix('tai-khoan')->name('customer.')->group(function () {
        Route::get('/don-hang', [OrderHistoryController::class, 'index'])->name('orders.index');
        Route::get('/don-hang/{order_code}', [OrderHistoryController::class, 'show'])->name('orders.show');
    });
});
