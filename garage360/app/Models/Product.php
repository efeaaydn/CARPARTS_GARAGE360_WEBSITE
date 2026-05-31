<?php

namespace App\Models;

use App\Services\CurrencyService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'description', 'short_description',
        'price', 'sale_price', 'currency', 'stock', 'brand', 'oem_number',
        'compatible_vehicles', 'image', 'gallery', 'is_active', 'is_featured',
        'vehicle_make', 'vehicle_model', 'part_brand', 'condition',
    ];

    protected $casts = [
        'price'               => 'decimal:2',
        'sale_price'          => 'decimal:2',
        'compatible_vehicles' => 'array',
        'gallery'             => 'array',
        'is_active'           => 'boolean',
        'is_featured'         => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Ürünün TRY cinsinden güncel fiyatı.
     * EUR ise CurrencyService ile çevirir, TRY ise doğrudan döner.
     * İndirimli fiyat varsa onu kullanır.
     */
    public function getCalculatedTryPriceAttribute(): float
    {
        $base = (float) ($this->sale_price ?? $this->price);

        if ($this->currency === 'EUR') {
            return app(CurrencyService::class)->eurToTry($base);
        }

        return $base;
    }

    /**
     * Geriye dönük uyumluluk: current_price artık TRY hesaplı fiyat.
     */
    public function getCurrentPriceAttribute(): float
    {
        return $this->calculated_try_price;
    }

    public function getIsInStockAttribute(): bool
    {
        return $this->stock > 0;
    }
}
