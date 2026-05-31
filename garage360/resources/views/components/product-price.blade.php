@props(['product', 'size' => 'normal'])

@php
    $tryPrice     = $product->calculated_try_price;
    $isEur        = $product->currency === 'EUR';
    $hasSale      = $product->sale_price !== null;
    $origEurPrice = (float) ($hasSale ? $product->sale_price : $product->price);
    $origEurFull  = $hasSale ? (float) $product->price : null;
    $largeClass   = $size === 'large' ? 'fs-4' : '';
@endphp

@if($isEur)
    {{-- Hem EUR hem TRY göster --}}
    @if($hasSale && $origEurFull)
        <span class="text-muted text-decoration-line-through small">€{{ number_format($origEurFull, 2, ',', '.') }}</span>
    @endif
    <span class="fw-bold text-danger {{ $largeClass }}">€{{ number_format($origEurPrice, 2, ',', '.') }}</span>
    <span class="text-muted small d-block">(~{{ number_format($tryPrice, 0, ',', '.') }} ₺)</span>
@else
    {{-- Sadece TRY --}}
    @if($hasSale)
        @php $fullTry = (float) $product->price; @endphp
        <span class="text-muted text-decoration-line-through small">{{ number_format($fullTry, 0, ',', '.') }} ₺</span>
    @endif
    <span class="fw-bold text-danger {{ $largeClass }}">{{ number_format($tryPrice, 0, ',', '.') }} ₺</span>
@endif
