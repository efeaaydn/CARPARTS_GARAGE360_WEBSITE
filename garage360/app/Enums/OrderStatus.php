<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending         = 'pending';
    case Confirmed       = 'confirmed';
    case Preparing       = 'preparing';
    case Shipped         = 'shipped';
    case OutForDelivery  = 'out_for_delivery';
    case Delivered       = 'delivered';
    case Cancelled       = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::Pending        => 'Beklemede',
            self::Confirmed      => 'Tedarik Ediliyor',
            self::Preparing      => 'Kutulanıyor',
            self::Shipped        => 'Kargoya Verildi',
            self::OutForDelivery => 'Yola Çıktı',
            self::Delivered      => 'Teslim Edildi',
            self::Cancelled      => 'İptal Edildi',
        };
    }

    public function badgeClass(): string
    {
        return match($this) {
            self::Pending        => 'status-pending',
            self::Confirmed      => 'status-confirmed',
            self::Preparing      => 'status-preparing',
            self::Shipped        => 'status-shipped',
            self::OutForDelivery => 'status-out',
            self::Delivered      => 'status-delivered',
            self::Cancelled      => 'bg-danger text-white',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::Pending        => 'bi-clock',
            self::Confirmed      => 'bi-search',
            self::Preparing      => 'bi-box-seam',
            self::Shipped        => 'bi-truck',
            self::OutForDelivery => 'bi-geo-alt-fill',
            self::Delivered      => 'bi-house-check-fill',
            self::Cancelled      => 'bi-x-circle',
        };
    }

    /** Admin'in tek tıkla geçirebileceği bir sonraki durum. null = admin adımı yok. */
    public function nextAdminStep(): ?self
    {
        return match($this) {
            self::Pending        => self::Confirmed,
            self::Confirmed      => self::Preparing,
            self::Preparing      => self::Shipped,
            self::Shipped        => self::OutForDelivery,
            default              => null,
        };
    }

    public function canAdminAdvance(): bool
    {
        return $this->nextAdminStep() !== null;
    }

    /** Kullanıcı "Teslim Aldım" diyebilir mi? */
    public function canUserConfirm(): bool
    {
        return $this === self::OutForDelivery;
    }

    public function isCancellable(): bool
    {
        return $this === self::Pending;
    }

    /** Durum çubuğu için sıralı adımlar (Cancelled hariç). */
    public static function steps(): array
    {
        return [
            self::Pending,
            self::Confirmed,
            self::Preparing,
            self::Shipped,
            self::OutForDelivery,
            self::Delivered,
        ];
    }
}
