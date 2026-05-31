<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_number', 'user_id', 'status', 'subtotal', 'discount',
        'total', 'balance_used', 'balance_amount', 'shipping_address', 'notes',
    ];

    protected $casts = [
        'status'           => OrderStatus::class,
        'subtotal'         => 'decimal:2',
        'discount'         => 'decimal:2',
        'total'            => 'decimal:2',
        'balance_amount'   => 'decimal:2',
        'balance_used'     => 'boolean',
        'shipping_address' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(OrderStatusLog::class);
    }
}
