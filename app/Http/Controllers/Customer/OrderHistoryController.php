<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderHistoryController extends Controller
{
    /**
     * Danh sách lịch sử đơn hàng của tài khoản đang đăng nhập
     */
    public function index(): View
    {
        $orders = Auth::user()
            ->orders()
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Chi tiết một đơn hàng cụ thể của tài khoản
     */
    public function show(string $order_code): View
    {
        $order = Auth::user()
            ->orders()
            ->with('items')
            ->where('order_code', $order_code)
            ->firstOrFail();

        return view('customer.orders.show', compact('order'));
    }
}
