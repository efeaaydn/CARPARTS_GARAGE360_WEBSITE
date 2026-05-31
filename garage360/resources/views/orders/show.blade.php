@extends('layouts.app')
@section('title', 'Sipariş ' . $order->order_number)

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Sipariş #{{ $order->order_number }}</h4>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" onclick="window.print()" title="Fatura Yazdır">
                <i class="bi bi-printer me-1"></i>Fatura Yazdır
            </button>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Siparişlerim
            </a>
        </div>
    </div>

    {{-- İptal uyarısı --}}
    @if($order->status->isCancellable())
    <div class="alert alert-warning d-flex align-items-center gap-3 mb-4">
        <i class="bi bi-info-circle fs-5"></i>
        <div>
            Siparişiniz henüz onaylanmadı. İptal ederseniz <strong>sipariş tutarı bakiyenize yatırılır.</strong>
            <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline ms-3"
                  onsubmit="return confirm('Siparişi iptal etmek istediğinizden emin misiniz?')">
                @csrf
                <button class="btn btn-sm btn-danger">
                    <i class="bi bi-x-circle me-1"></i>Siparişi İptal Et
                </button>
            </form>
        </div>
    </div>
    @endif

    @if($order->status === \App\Enums\OrderStatus::Cancelled)
    <div class="alert alert-danger mb-4">
        <i class="bi bi-x-circle me-2"></i>
        Bu sipariş iptal edildi. Tutar bakiyenize iade edilmiştir.
    </div>
    @else
    {{-- Durum adımları --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="d-flex justify-content-between">
                @foreach(\App\Enums\OrderStatus::steps() as $step)
                @php
                    $cases = \App\Enums\OrderStatus::cases();
                    $currentIdx = array_search($order->status, $cases);
                    $stepIdx    = array_search($step, $cases);
                    $done = $currentIdx !== false && $stepIdx <= $currentIdx;
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
    @endif

    <div class="row g-3">
        <div class="col-lg-8">
            {{-- Ürünler --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white fw-semibold">Sipariş Kalemleri</div>
                <table class="table mb-0 align-middle">
                    <thead class="table-light">
                        <tr><th>Ürün</th><th>Adet</th><th>Birim</th><th>Toplam</th></tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="fw-medium">{{ $item->product_name }}</div>
                                <div class="text-muted small">{{ $item->product_sku }}</div>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->price, 2, ',', '.') }} ₺</td>
                            <td>{{ number_format($item->total, 2, ',', '.') }} ₺</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @if($order->balance_used && $order->balance_amount > 0)
                        <tr class="text-muted small">
                            <td colspan="3" class="text-end">Bakiyeden kullanıldı:</td>
                            <td class="text-success">-{{ number_format($order->balance_amount, 2, ',', '.') }} ₺</td>
                        </tr>
                        @endif
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Toplam</td>
                            <td class="text-danger">{{ number_format($order->total, 2, ',', '.') }} ₺</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm mb-3">
                <div class="card-header bg-white fw-semibold">Durum</div>
                <div class="card-body">
                    <span class="badge fs-6 {{ $order->status->badgeClass() }}">{{ $order->status->label() }}</span>
                    <div class="text-muted small mt-2">{{ $order->created_at->format('d.m.Y H:i') }}</div>
                    @if($order->notes)
                        <div class="mt-2 small text-muted border-top pt-2">{{ $order->notes }}</div>
                    @endif
                    @if($order->status->canUserConfirm())
                    <div class="border-top pt-3 mt-3">
                        <p class="small text-muted mb-2">Paketiniz teslim edildiyse onaylayın.</p>
                        <form action="{{ route('orders.confirmReceived', $order) }}" method="POST"
                              onsubmit="return confirm('Siparişi teslim aldığınızı onaylıyor musunuz?')">
                            @csrf
                            <button class="btn btn-success w-100">
                                <i class="bi bi-house-check-fill me-1"></i>Teslim Aldım
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            @if($order->shipping_address)
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">Teslimat Adresi</div>
                <div class="card-body small">
                    <div class="fw-semibold">{{ $order->shipping_address['name'] ?? '' }}</div>
                    <div>{{ $order->shipping_address['address'] ?? '' }}</div>
                    <div>{{ $order->shipping_address['city'] ?? '' }}</div>
                    <div>{{ $order->shipping_address['phone'] ?? '' }}</div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Yazdırılabilir Fatura Bölümü --}}
    <div id="invoicePrintArea" class="d-none d-print-block mt-4 border rounded-3 p-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
                <h3 class="fw-bold mb-0" style="color:#e63946;">GARAGE360</h3>
                <div class="text-muted small">Otomotiv Yedek Parça</div>
                <div class="small">info@garage360.com</div>
            </div>
            <div class="text-end">
                <h5 class="fw-bold mb-0">FATURA</h5>
                <div class="text-muted small">No: {{ $order->order_number }}</div>
                <div class="text-muted small">Tarih: {{ $order->created_at->format('d.m.Y') }}</div>
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-6">
                <div class="fw-semibold small mb-1">FATURA KESİLEN</div>
                <div>{{ auth()->user()->name }}</div>
                <div class="small text-muted">{{ auth()->user()->email }}</div>
                @if($order->shipping_address)
                <div class="small">{{ $order->shipping_address['address'] ?? '' }}, {{ $order->shipping_address['city'] ?? '' }}</div>
                <div class="small">{{ $order->shipping_address['phone'] ?? '' }}</div>
                @endif
            </div>
            <div class="col-6 text-end">
                <div class="fw-semibold small mb-1">SİPARİŞ DURUMU</div>
                <div>{{ $order->status->label() }}</div>
            </div>
        </div>
        <table class="table table-sm table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Ürün</th>
                    <th class="text-center">Adet</th>
                    <th class="text-end">Birim Fiyat</th>
                    <th class="text-end">Toplam</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->product_name }} <span class="text-muted small">({{ $item->product_sku }})</span></td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">{{ number_format($item->price, 2, ',', '.') }} ₺</td>
                    <td class="text-end">{{ number_format($item->total, 2, ',', '.') }} ₺</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                @if($order->balance_used && $order->balance_amount > 0)
                <tr>
                    <td colspan="4" class="text-end text-muted">Bakiyeden Kullanılan:</td>
                    <td class="text-end text-success">- {{ number_format($order->balance_amount, 2, ',', '.') }} ₺</td>
                </tr>
                @endif
                <tr class="fw-bold">
                    <td colspan="4" class="text-end">GENEL TOPLAM:</td>
                    <td class="text-end">{{ number_format($order->total, 2, ',', '.') }} ₺</td>
                </tr>
            </tfoot>
        </table>
        <div class="text-muted small mt-3 text-center">
            Bizi tercih ettiğiniz için teşekkür ederiz. — www.garage360.com
        </div>
    </div>
</div>

@push('styles')
<style>
@media print {
    .btn, nav, footer, .topbar, .alert, #heroCarousel { display: none !important; }
    #invoicePrintArea { display: block !important; }
    body { background: #fff; }
}
</style>
@endpush
@endsection
