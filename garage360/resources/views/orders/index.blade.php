@extends('layouts.app')
@section('title', 'Siparişlerim')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4"><i class="bi bi-box-seam me-2"></i>Siparişlerim</h4>

    @if($orders->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-bag-x fs-1 d-block mb-3"></i>
            <h5>Henüz siparişiniz yok</h5>
            <a href="{{ route('products.index') }}" class="btn btn-danger mt-3">Alışverişe Başla</a>
        </div>
    @else
        <div class="d-flex flex-column gap-3">
            @foreach($orders as $order)
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <span class="fw-semibold">{{ $order->order_number }}</span>
                        <span class="text-muted ms-3 small">{{ $order->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-secondary">Detay</a>
                    </div>
                </div>
                <div class="card-body py-2">
                    <div class="d-flex flex-wrap gap-3 align-items-center">
                        <div class="text-muted small">{{ $order->items->count() }} ürün</div>
                        <div class="fw-semibold">{{ number_format($order->total, 2, ',', '.') }} ₺</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-3">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
