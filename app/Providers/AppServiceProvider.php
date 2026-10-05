<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Category;
use App\Services\CartService;
use Illuminate\Auth\Events\Login;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CartService::class, function () {
            return new CartService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(CartService $cartService): void
    {
        Paginator::useTailwind();

        // Tự động gộp giỏ hàng từ Session vào Database khi người dùng đăng nhập
        Event::listen(Login::class, function (Login $event) use ($cartService) {
            $cartService->mergeSessionToDatabase($event->user);
        });

        // Chia sẻ dữ liệu thương hiệu & danh mục và số lượng giỏ hàng cho toàn bộ Views
        if (!app()->runningInConsole()) {
            View::composer('*', function ($view) use ($cartService) {
                if (Schema::hasTable('brands') && Schema::hasTable('categories')) {
                    $globalBrands = Brand::where('is_active', true)
                        ->withCount(['products' => function ($query) {
                            $query->where('status', 'available');
                        }])
                        ->orderBy('name')
                        ->get();

                    $globalCategories = Category::where('is_active', true)
                        ->whereNull('parent_id')
                        ->orderBy('name')
                        ->get();

                    $cartCount = $cartService->count();

                    $view->with([
                        'globalBrands'     => $globalBrands,
                        'globalCategories' => $globalCategories,
                        'cartCount'        => $cartCount,
                    ]);
                }
            });
        }
    }
}
