@extends('admin.layout.base')
@section('title', 'Sipariş #' . $order->id)
@section('page-title', 'Sipariş #' . $order->id)

@section('content')
<div class="row g-3">
    <div class="col-lg-8">
        {{-- Ürünler --}}
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold">Sipariş Kalemleri</div>
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr><th>Ürün</th><th>SKU</th><th>Adet</th><th>Birim</th><th>Toplam</th></tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td><code class="small">{{ $item->product_sku }}</code></td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2, ',', '.') }} ₺</td>
                        <td>{{ number_format($item->total, 2, ',', '.') }} ₺</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="4" class="text-end">Genel Toplam:</td>
                        <td>{{ number_format($order->total, 2, ',', '.') }} ₺</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Durum zinciri --}}
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-semibold">Sipariş Süreci</div>
            <div class="card-body py-3">
                <div class="d-flex justify-content-between">
                    @foreach(\App\Enums\OrderStatus::steps() as $step)
                    @php
                        $cases      = \App\Enums\OrderStatus::cases();
                        $currentIdx = array_search($order->status, $cases);
                        $stepIdx    = array_search($step, $cases);
                        $done       = $currentIdx !== false && $stepIdx <= $currentIdx;
                    @endphp
                    <div class="text-center flex-fill {{ !$loop->last ? 'border-end' : '' }} px-1">
                        <div class="mb-1">
                            <span class="rounded-circle d-inline-flex align-items-center justify-content-center
                                  {{ $done ? 'bg-danger text-white' : 'bg-light text-muted' }}"
                                  style="width:36px;height:36px;font-size:.9rem">
                                <i class="bi {{ $step->icon() }}"></i>
                            </span>
                        </div>
                        <div class="small {{ $done ? 'fw-semibold' : 'text-muted' }}">{{ $step->label() }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Admin ilerleme butonu --}}
        @if($order->status->canAdminAdvance())
        <div class="card shadow-sm mt-3 border-danger">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="flex-grow-1">
                    <div class="fw-semibold">Sonraki adım:</div>
                    <div class="text-muted small">{{ $order->status->nextAdminStep()->label() }}</div>
                </div>
                <form action="{{ route('admin.orders.advance', $order) }}" method="POST">
                    @csrf
                    <button class="btn btn-danger px-4">
                        <i class="bi bi-arrow-right-circle me-1"></i>İlerlet
                    </button>
                </form>
            </div>
        </div>
        @elseif($order->status === \App\Enums\OrderStatus::OutForDelivery)
        <div class="alert alert-info mt-3 mb-0">
            <i class="bi bi-clock me-2"></i>Sipariş yolda — müşteri teslim onayı bekleniyor.
        </div>
        @elseif($order->status === \App\Enums\OrderStatus::Delivered)
        <div class="alert alert-success mt-3 mb-0">
            <i class="bi bi-check-circle me-2"></i>Sipariş tamamlandı.
        </div>
        @elseif($order->status === \App\Enums\OrderStatus::Cancelled)
        <div class="alert alert-danger mt-3 mb-0">
            <i class="bi bi-x-circle me-2"></i>Sipariş iptal edildi.
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold">Müşteri</div>
            <div class="card-body">
                <div class="fw-semibold">{{ $order->user->name }}</div>
                <div class="text-muted small">{{ $order->user->email }}</div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold">Mevcut Durum</div>
            <div class="card-body">
                <span class="badge fs-6 {{ $order->status->badgeClass() }}">
                    {{ $order->status->label() }}
                </span>
            </div>
        </div>

        @if($order->shipping_address)
        <div class="card shadow-sm mb-3">
            <div class="card-header bg-white fw-semibold">Teslimat Adresi</div>
            <div class="card-body small">
                <div>{{ $order->shipping_address['name'] ?? '' }}</div>
                <div>{{ $order->shipping_address['address'] ?? '' }}</div>
                <div>{{ $order->shipping_address['city'] ?? '' }} {{ $order->shipping_address['postal_code'] ?? '' }}</div>
                <div>{{ $order->shipping_address['phone'] ?? '' }}</div>
            </div>
        </div>
        @endif

        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary w-100">
            <i class="bi bi-arrow-left me-1"></i>Geri
        </a>
    </div>
</div>
@endsection
