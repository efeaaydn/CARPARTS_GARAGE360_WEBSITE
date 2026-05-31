@extends('admin.layout.base')
@section('title', 'Ürünler')
@section('page-title', 'Ürün Yönetimi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="text-muted small">Toplam {{ $products->total() }} ürün</div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-danger btn-sm">
        <i class="bi bi-plus-lg me-1"></i>Yeni Ürün
    </a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Ürün</th>
                    <th>SKU</th>
                    <th>Kategori</th>
                    <th>Fiyat</th>
                    <th>Stok</th>
                    <th>Durum</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:6px">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:40px;height:40px">
                                    <i class="bi bi-box text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <div class="fw-medium small">{{ $product->name }}</div>
                                <div class="text-muted" style="font-size:.75rem">{{ $product->brand }}</div>
                            </div>
                        </div>
                    </td>
                    <td><code class="small">{{ $product->sku }}</code></td>
                    <td><span class="badge bg-secondary">{{ $product->category->name ?? '—' }}</span></td>
                    <td>
                        @php $sym = $product->currency === 'EUR' ? '€' : '₺'; @endphp
                        @if($product->sale_price)
                            <span class="text-danger fw-semibold">{{ number_format($product->sale_price, 2, ',', '.') }} {{ $sym }}</span>
                            <br><small class="text-muted text-decoration-line-through">{{ number_format($product->price, 2, ',', '.') }} {{ $sym }}</small>
                        @else
                            {{ number_format($product->price, 2, ',', '.') }} {{ $sym }}
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning text-dark' : 'danger') }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        @if($product->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Pasif</span>
                        @endif
                        @if($product->is_featured)
                            <span class="badge bg-warning text-dark ms-1">Öne Çıkan</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                  onsubmit="return confirm('Bu ürünü silmek istediğinize emin misiniz?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-box-seam fs-2 d-block mb-2"></i>
                        Henüz ürün eklenmemiş.
                        <a href="{{ route('admin.products.create') }}">İlk ürünü ekle</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="card-footer bg-white">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
