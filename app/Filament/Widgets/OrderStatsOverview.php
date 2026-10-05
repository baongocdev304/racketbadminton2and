<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // 1. Tổng doanh thu từ các đơn hàng đã thanh toán hoặc đã hoàn tất
        $totalRevenue = Order::where(function ($query) {
            $query->where('payment_status', 'paid')
                  ->orWhere('status', 'completed');
        })->sum('total_amount');

        // 2. Thống kê đơn hàng
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $shippingOrders = Order::where('status', 'shipping')->count();

        // 3. Thống kê kho vợt 2Hand (Đặc thù độc bản)
        $totalProducts = Product::count();
        $availableProducts = Product::where('status', 'available')->count();
        $reservedProducts = Product::where('status', 'reserved')->count();
        $soldProducts = Product::where('status', 'sold')->count();

        return [
            Stat::make('Tổng Doanh Thu', number_format($totalRevenue, 0, ',', '.') . 'đ')
                ->description('Doanh thu từ các đơn đã hoàn tất / thanh toán')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Đơn Hàng Chờ Xử Lý', "{$pendingOrders} / {$totalOrders} đơn")
                ->description("Đang giao: {$shippingOrders} đơn")
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingOrders > 0 ? 'warning' : 'gray'),

            Stat::make('Kho Vợt 2Hand Còn Hàng', "{$availableProducts} cây")
                ->description("Tổng kho: {$totalProducts} | Đang giữ: {$reservedProducts}")
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),

            Stat::make('Vợt 2Hand Đã Bán', "{$soldProducts} cây")
                ->description($totalProducts > 0 ? round(($soldProducts / $totalProducts) * 100, 1) . '% tổng số vợt' : '0%')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('danger'),
        ];
    }
}
