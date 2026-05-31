<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Str;

class CartService
{
    public function getCart(): Cart
    {
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

            $sessionId = session('cart_session_id');
            if ($sessionId) {
                $sessionCart = Cart::where('session_id', $sessionId)->where('user_id', null)->first();
                if ($sessionCart) {
                    foreach ($sessionCart->items as $item) {
                        $this->mergeItem($cart, $item->product_id, $item->quantity, $item->price);
                    }
                    $sessionCart->delete();
                }
                session()->forget('cart_session_id');
            }

            return $cart->load('items.product');
        }

        $sessionId = session('cart_session_id');
        if (!$sessionId) {
            $sessionId = Str::uuid()->toString();
            session(['cart_session_id' => $sessionId]);
        }

        return Cart::firstOrCreate(['session_id' => $sessionId, 'user_id' => null])->load('items.product');
    }

    /**
     * Sepete ürün ekle.
     * Fiyat her zaman TRY cinsinden calculated_try_price ile hesaplanır.
     */
    public function add(Product $product, int $quantity = 1): void
    {
        $cart     = $this->getCart();
        $tryPrice = $product->calculated_try_price; // EUR ise çevrilmiş, TRY ise doğrudan
        $existing = $cart->items()->where('product_id', $product->id)->first();

        if ($existing) {
            // Fiyat güncellenmiş olabilir (kur değişimi), price'ı güncelle
            $existing->update([
                'quantity' => $existing->quantity + $quantity,
                'price'    => $tryPrice,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'price'      => $tryPrice,
            ]);
        }
    }

    public function update(CartItem $item, int $quantity): void
    {
        if ($quantity <= 0) {
            $item->delete();
        } else {
            $item->update(['quantity' => $quantity]);
        }
    }

    public function remove(CartItem $item): void
    {
        $item->delete();
    }

    public function clear(Cart $cart): void
    {
        $cart->items()->delete();
    }

    public function itemCount(): int
    {
        try {
            return $this->getCart()->items->sum('quantity');
        } catch (\Throwable) {
            return 0;
        }
    }

    private function mergeItem(Cart $cart, int $productId, int $qty, float $price): void
    {
        $existing = $cart->items()->where('product_id', $productId)->first();
        if ($existing) {
            $existing->increment('quantity', $qty);
        } else {
            $cart->items()->create(['product_id' => $productId, 'quantity' => $qty, 'price' => $price]);
        }
    }
}
