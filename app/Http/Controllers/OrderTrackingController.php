<?php

namespace App\Http\Controllers;

use App\Http\Requests\LookupOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderTrackingController extends Controller
{
    /**
     * Giao diện tra cứu đơn hàng
     */
    public function index(Request $request): View
    {
        $order = null;

        if ($request->filled('order_code') && $request->filled('customer_phone')) {
            $order = Order::with('items')
                ->where('order_code', trim($request->query('order_code')))
                ->where('customer_phone', trim($request->query('customer_phone')))
                ->first();

            if (!$order) {
                session()->now('error', 'Không tìm thấy đơn hàng nào khớp với mã đơn và số điện thoại đã nhập. Vui lòng kiểm tra lại.');
            }
        }

        return view('orders.tracking', compact('order'));
    }

    /**
     * Xử lý gửi Form tra cứu đơn hàng
     */
    public function lookup(LookupOrderRequest $request): View
    {
        $order = Order::with('items')
            ->where('order_code', trim($request->validated('order_code')))
            ->where('customer_phone', trim($request->validated('customer_phone')))
            ->first();

        if (!$order) {
            return view('orders.tracking', [
                'order' => null,
            ])->with('error', 'Không tìm thấy đơn hàng nào khớp với thông tin đã nhập.');
        }

        return view('orders.tracking', compact('order'));
    }
}
