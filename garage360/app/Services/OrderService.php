<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderService
{
    public function __construct(private BalanceService $balanceService) {}

    /**
     * Sepetten sipariş oluştur.
     * $useBalance true ise mevcut bakiye önce kullanılır; false ise bakiyeye dokunulmaz.
     */
    public function createFromCart(Cart $cart, array $shippingAddress, bool $useBalance = false): Order
    {
        $cart->load('items.product');

        if ($cart->items->isEmpty()) {
            throw new \RuntimeException('Sepet boş.');
        }

        $user = auth()->user();
        $subtotal = (float) $cart->items->sum(fn($i) => $i->price * $i->quantity);

        return DB::transaction(function () use ($cart, $shippingAddress, $user, $subtotal, $useBalance) {
            // Bakiyeden düşülecek miktar (kullanıcı seçmediyse sıfır)
            $balanceAvailable = $useBalance ? $this->balanceService->getBalance($user) : 0;
            $balanceUsed      = min($balanceAvailable, $subtotal);
            $creditCardAmount = round($subtotal - $balanceUsed, 2);

            $order = Order::create([
                'order_number'     => 'ORD-' . strtoupper(Str::random(8)),
                'user_id'          => $user->id,
                'status'           => OrderStatus::Pending,
                'subtotal'         => $subtotal,
                'discount'         => 0,
                'total'            => $subtotal,
                'balance_used'     => $balanceUsed > 0,
                'balance_amount'   => $balanceUsed,
                'shipping_address' => $shippingAddress,
                'notes'            => $creditCardAmount > 0
                    ? "Kredi kartından: ₺" . number_format($creditCardAmount, 2)
                    : 'Tamamı bakiyeden ödendi.',
            ]);

            // Bakiye düşümü
            if ($balanceUsed > 0) {
                $this->balanceService->debit(
                    $user,
                    $balanceUsed,
                    "Sipariş ödemesi: {$order->order_number}",
                    $order
                );
            }

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product?->name ?? 'Ürün',
                    'product_sku'  => $item->product?->sku ?? '',
                    'quantity'     => $item->quantity,
                    'price'        => $item->price,
                    'total'        => $item->price * $item->quantity,
                ]);

                if ($item->product) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            return $order;
        });
    }

    /**
     * Sipariş iptali.
     * Kural: Sadece "pending" durumundaki siparişler iptal edilebilir.
     * İptal edilince ödenen tutar (bakiyeden düşülen kısım) bakiyeye iade edilir.
     * Kredi kartı tutarı da bakiyeye HEDİYE olarak yatırılır.
     */
    public function cancel(Order $order, User $user): void
    {
        if ($order->user_id !== $user->id) {
            throw new \RuntimeException('Bu siparişi iptal etme yetkiniz yok.');
        }

        if ($order->status !== OrderStatus::Pending) {
            throw new \RuntimeException('Sadece beklemedeki siparişler iptal edilebilir.');
        }

        DB::transaction(function () use ($order, $user) {
            // Stokları geri yükle
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }

            // Tüm sipariş tutarını bakiyeye iade et (kredi kartı dahil)
            // Kural: "ücret kredi kartına değil hesaba hediye olarak yatacak"
            $this->balanceService->credit(
                $user,
                (float) $order->total,
                "Sipariş iadesi: {$order->order_number}",
                $order
            );

            $order->update(['status' => OrderStatus::Cancelled]);
        });
    }
}
