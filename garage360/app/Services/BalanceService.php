<?php

namespace App\Services;

use App\Models\BalanceTransaction;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BalanceService
{
    public function getBalance(User $user): float
    {
        return (float) ($user->balance?->amount ?? 0);
    }

    /**
     * Kullanıcı bakiyesine para ekle (iade, hediye, admin ekleme).
     */
    public function credit(User $user, float $amount, string $description, ?Model $reference = null): void
    {
        DB::transaction(function () use ($user, $amount, $description, $reference) {
            $balance = UserBalance::firstOrCreate(['user_id' => $user->id], ['amount' => 0]);
            $balance->increment('amount', $amount);
            $balance->refresh();

            BalanceTransaction::create([
                'user_id'        => $user->id,
                'type'           => 'credit',
                'amount'         => $amount,
                'balance_after'  => $balance->amount,
                'description'    => $description,
                'reference_type' => $reference ? get_class($reference) : null,
                'reference_id'   => $reference?->id,
            ]);
        });
    }

    /**
     * Kullanıcı bakiyesinden para düş (sipariş ödemesi).
     * Yetersiz bakiye varsa exception fırlatır.
     */
    public function debit(User $user, float $amount, string $description, ?Model $reference = null): void
    {
        DB::transaction(function () use ($user, $amount, $description, $reference) {
            $balance = UserBalance::lockForUpdate()->firstOrCreate(['user_id' => $user->id], ['amount' => 0]);

            if ($balance->amount < $amount) {
                throw new \RuntimeException('Yetersiz bakiye.');
            }

            $balance->decrement('amount', $amount);
            $balance->refresh();

            BalanceTransaction::create([
                'user_id'        => $user->id,
                'type'           => 'debit',
                'amount'         => $amount,
                'balance_after'  => $balance->amount,
                'description'    => $description,
                'reference_type' => $reference ? get_class($reference) : null,
                'reference_id'   => $reference?->id,
            ]);
        });
    }

    /**
     * Bakiyeden mümkün olduğunca düş, kalan tutarı döndür.
     * Yetersizse tüm bakiyeyi kullan ve 0'a indir.
     */
    public function debitUpTo(User $user, float $requested, string $description, ?Model $reference = null): float
    {
        $available = $this->getBalance($user);

        if ($available <= 0) {
            return $requested;
        }

        $used      = min($available, $requested);
        $remaining = round($requested - $used, 2);

        $this->debit($user, $used, $description, $reference);

        return $remaining;
    }
}
