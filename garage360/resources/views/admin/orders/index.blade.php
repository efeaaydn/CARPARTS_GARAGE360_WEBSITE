@extends('admin.layout.base')
@section('title', 'Siparişler')
@section('page-title', 'Sipariş Yönetimi')

@section('content')
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Müşteri</th>
                    <th>Ürünler</th>
                    <th>Toplam</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong>#{{ $order->id }}</strong></td>
                    <td>{{ $order->user->name }}</td>
                    <td><span class="badge bg-secondary">{{ $order->items->count() }} kalem</span></td>
                    <td>{{ number_format($order->total, 2, ',', '.') }} ₺</td>
                    <td>
                        <span class="badge {{ $order->status->badgeClass() }}">
                            {{ $order->status->label() }}
                        </span>
                    </td>
                    <td class="text-muted small">{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-receipt fs-2 d-block mb-2"></i>Henüz sipariş yok
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
