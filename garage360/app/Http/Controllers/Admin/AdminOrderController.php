<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items']);
        return view('admin.orders.show', compact('order'));
    }

    /** Siparişi bir sonraki admin adımına ilerletir. */
    public function advance(Order $order)
    {
        $next = $order->status->nextAdminStep();

        if ($next === null) {
            return back()->with('error', 'Bu sipariş daha fazla ilerletilemez.');
        }

        $order->update(['status' => $next]);

        return back()->with('success', "Sipariş durumu \"{$next->label()}\" olarak güncellendi.");
    }
}
