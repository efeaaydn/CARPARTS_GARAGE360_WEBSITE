<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'orders'   => Order::count(),
            'products' => Product::count(),
            'users'    => User::role('user')->count(),
            'revenue'  => Order::where('status', 'delivered')->sum('total'),
        ];

        $latestOrders      = Order::with('user')->latest()->take(8)->get();
        $lowStockProducts  = Product::where('stock', '<=', 10)->orderBy('stock')->take(8)->get();

        return view('admin.dashboard', compact('stats', 'latestOrders', 'lowStockProducts'));
    }
}
