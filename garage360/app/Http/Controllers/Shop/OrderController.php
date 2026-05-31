<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private CartService $cartService,
        private OrderService $orderService,
    ) {}

    public function index()
    {
        $orders = auth()->user()->orders()->with('items')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('items');
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:500',
            'city'    => 'required|string|max:100',
            'phone'   => 'required|string|max:20',
        ]);

        $cart = $this->cartService->getCart();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Sepetiniz boş.');
        }

        $shippingAddress = [
            'name'    => auth()->user()->name,
            'address' => $request->address,
            'city'    => $request->city,
            'phone'   => $request->phone,
        ];

        $useBalance = $request->boolean('use_balance');
        $order = $this->orderService->createFromCart($cart, $shippingAddress, $useBalance);
        $this->cartService->clear($cart);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Siparişiniz alındı! Sipariş No: ' . $order->order_number);
    }

    public function confirmReceived(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        if (! $order->status->canUserConfirm()) {
            return back()->with('error', 'Bu sipariş için teslim onayı yapılamaz.');
        }

        $order->update(['status' => \App\Enums\OrderStatus::Delivered]);

        return back()->with('success', 'Teslimat onaylandı, siparişiniz tamamlandı.');
    }

    public function cancel(Order $order)
    {
        try {
            $this->orderService->cancel($order, auth()->user());
            return redirect()->route('orders.show', $order)
                ->with('success', 'Sipariş iptal edildi. Tutar bakiyenize yatırıldı.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
