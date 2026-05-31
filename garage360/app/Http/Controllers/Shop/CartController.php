<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function index()
    {
        $cart = $this->cartService->getCart();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active || $product->stock < 1) {
            return back()->with('error', 'Bu ürün stokta yok.');
        }

        $this->cartService->add($product, $request->integer('quantity', 1));

        return back()->with('success', '"' . $product->name . '" sepete eklendi.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate(['quantity' => 'required|integer|min:0|max:99']);
        $this->cartService->update($cartItem, $request->quantity);
        return back()->with('success', 'Sepet güncellendi.');
    }

    public function remove(CartItem $cartItem)
    {
        $this->cartService->remove($cartItem);
        return back()->with('success', 'Ürün sepetten çıkarıldı.');
    }
}
