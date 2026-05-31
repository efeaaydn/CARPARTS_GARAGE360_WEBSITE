@extends('admin.layout.base')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box bg-primary bg-opacity-10 text-primary"><i class="bi bi-box-seam"></i></div>
                <div>
                    <div class="text-muted small">Toplam Ürün</div>
                    <div class="fw-bold fs-4">{{ $stats['products'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box bg-warning bg-opacity-10 text-warning"><i class="bi bi-receipt"></i></div>
                <div>
                    <div class="text-muted small">Toplam Sipariş</div>
                    <div class="fw-bold fs-4">{{ $stats['orders'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box bg-success bg-opacity-10 text-success"><i class="bi bi-people"></i></div>
                <div>
                    <div class="text-muted small">Kullanıcılar</div>
                    <div class="fw-bold fs-4">{{ $stats['users'] }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon-box bg-danger bg-opacity-10 text-danger"><i class="bi bi-currency-dollar"></i></div>
                <div>
                    <div class="text-muted small">Toplam Gelir</div>
                    <div class="fw-bold fs-4">{{ number_format($stats['revenue'], 0, ',', '.') }} ₺</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-7">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Son Siparişler</span>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">Tümü</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Müşteri</th>
                            <th>Tutar</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestOrders as $order)
                        <tr>
                            <td><a href="#">#{{ $order->id }}</a></td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ number_format($order->total, 2, ',', '.') }} ₺</td>
                            <td>
                                <span class="badge {{ $order->status->badgeClass() }}">
                                    {{ $order->status->label() }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $order->created_at->format('d.m.Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">Henüz sipariş yok</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Düşük Stok</span>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">Ürünler</a>
            </div>
            <ul class="list-group list-group-flush">
                @forelse($lowStockProducts as $product)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span class="small">{{ Str::limit($product->name, 35) }}</span>
                    <span class="badge bg-{{ $product->stock <= 3 ? 'danger' : 'warning' }} text-dark">
                        {{ $product->stock }} adet
                    </span>
                </li>
                @empty
                <li class="list-group-item text-muted text-center py-3 small">Tüm ürünler yeterli stokta</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
