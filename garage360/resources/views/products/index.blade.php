@extends('layouts.app')
@section('title', 'Ürünler')

@section('content')
<div class="container py-4">
    <div class="row g-4">

        {{-- Sidebar Filtre --}}
        <div class="col-lg-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="bi bi-funnel me-2"></i>Filtrele</h6>
                    <form method="GET" action="{{ route('products.index') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Kategori</label>
                            <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Tüm Kategoriler</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }} ({{ $cat->products_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Marka</label>
                            <select name="brand" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Tüm Markalar</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Fiyat Aralığı</label>
                            <div class="d-flex gap-2">
                                <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min ₺" value="{{ request('min_price') }}">
                                <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max ₺" value="{{ request('max_price') }}">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger btn-sm">Uygula</button>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">Temizle</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Ürün Listesi --}}
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <span class="text-muted small">{{ $products->total() }} ürün bulundu</span>
                    @if(request('search'))
                        <span class="badge bg-secondary ms-2">Arama: "{{ request('search') }}"</span>
                    @endif
                </div>
                <select class="form-select form-select-sm w-auto" onchange="window.location=this.value">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" {{ request('sort','latest') == 'latest' ? 'selected' : '' }}>En Yeni</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Fiyat (Düşük→Yüksek)</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Fiyat (Yüksek→Düşük)</option>
                </select>
            </div>

            <div class="row g-3">
                @forelse($products as $product)
                    <div class="col-6 col-md-4">
                        <div class="card product-card h-100 shadow-sm border-0">
                            @if($product->sale_price)
                                <span class="badge bg-danger position-absolute top-0 end-0 m-2" style="z-index:1;">İNDİRİM</span>
                            @endif
                            <div class="product-img-wrap">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <i class="bi bi-gear no-img"></i>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column p-3">
                                <div class="text-muted small mb-1">{{ $product->brand }}</div>
                                <h6 class="card-title fw-semibold mb-1" style="font-size:.88rem;line-height:1.3;">{{ $product->name }}</h6>
                                @if($product->oem_number)
                                    <div class="text-muted" style="font-size:.75rem;">OEM: {{ $product->oem_number }}</div>
                                @endif
                                <div class="mt-auto pt-2">
                                    <x-product-price :product="$product" />
                                    @if($product->stock > 0)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle small mb-2">Stokta</span>
                                    @else
                                        <span class="badge bg-secondary small mb-2">Tükendi</span>
                                    @endif
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-danger btn-sm w-100">
                                        <i class="bi bi-eye me-1"></i>İncele
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="bi bi-search fs-1 d-block mb-3"></i>
                        <p>Arama kriterlerinize uygun ürün bulunamadı.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-danger">Tüm Ürünlere Dön</a>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
