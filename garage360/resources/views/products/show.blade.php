@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-danger text-decoration-none">Anasayfa</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-danger text-decoration-none">Ürünler</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm p-4 text-center" style="min-height:350px;display:flex;align-items:center;justify-content:center;">
                @if($product->image)
                    <img id="mainProductImg" src="{{ asset('storage/'.$product->image) }}" class="img-fluid" style="max-height:320px;object-fit:contain;" alt="{{ $product->name }}">
                @else
                    <i class="bi bi-gear" style="font-size:8rem;color:#ddd;"></i>
                @endif
            </div>
            {{-- Galeri küçük resimler --}}
            @if($product->gallery && count($product->gallery) > 0)
            <div class="d-flex gap-2 mt-2 flex-wrap justify-content-center">
                @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}"
                     class="rounded border gallery-thumb"
                     style="width:60px;height:60px;object-fit:cover;cursor:pointer;border-width:2px !important;"
                     onclick="document.getElementById('mainProductImg').src=this.src">
                @endif
                @foreach($product->gallery as $img)
                <img src="{{ asset('storage/'.$img) }}"
                     class="rounded border gallery-thumb"
                     style="width:60px;height:60px;object-fit:cover;cursor:pointer;"
                     onclick="document.getElementById('mainProductImg').src=this.src">
                @endforeach
            </div>
            @endif
        </div>

        <div class="col-md-7">
            <span class="badge bg-danger-subtle text-danger border border-danger-subtle mb-2">{{ $product->category->name }}</span>
            <h1 class="fw-bold fs-3 mb-2">{{ $product->name }}</h1>

            <div class="d-flex gap-3 text-muted small mb-3 flex-wrap">
                @if($product->part_brand ?? $product->brand)
                    <span><i class="bi bi-tag me-1"></i>{{ $product->part_brand ?? $product->brand }}</span>
                @endif
                @if($product->sku) <span><i class="bi bi-upc me-1"></i>SKU: {{ $product->sku }}</span> @endif
                @if($product->oem_number) <span><i class="bi bi-hash me-1"></i>OEM: {{ $product->oem_number }}</span> @endif
                @if($product->condition)
                    <span>
                        <i class="bi bi-{{ $product->condition === 'Sıfır' ? 'star-fill text-warning' : 'arrow-repeat text-secondary' }} me-1"></i>
                        {{ $product->condition }}
                    </span>
                @endif
            </div>

            {{-- Araç Uyum Bilgisi --}}
            @if($product->vehicle_make || $product->vehicle_model)
            <div class="d-flex align-items-center gap-2 bg-light border rounded-2 px-3 py-2 mb-3" style="font-size:.9rem;">
                <i class="bi bi-car-front-fill text-danger fs-5"></i>
                <div>
                    <span class="text-muted small">Uyumlu Araç:</span>
                    <strong class="ms-1">
                        {{ implode(' ', array_filter([$product->vehicle_make, $product->vehicle_model])) }}
                    </strong>
                </div>
            </div>
            @endif

            <div class="mb-3">
                @if($product->currency === 'EUR')
                    {{-- EUR ürün: orijinal € fiyat + güncel TRY karşılığı --}}
                    @if($product->sale_price)
                        <div>
                            <span class="text-muted text-decoration-line-through fs-6">€{{ number_format($product->price, 2, ',', '.') }}</span>
                            <span class="badge bg-danger ms-1">%{{ round((1 - $product->sale_price/$product->price)*100) }} İndirim</span>
                        </div>
                        <span class="fs-2 fw-bold text-danger">€{{ number_format($product->sale_price, 2, ',', '.') }}</span>
                    @else
                        <span class="fs-2 fw-bold text-danger">€{{ number_format($product->price, 2, ',', '.') }}</span>
                    @endif
                    <div class="text-muted mt-1">
                        <i class="bi bi-currency-exchange me-1"></i>
                        Güncel kur ile yaklaşık
                        <strong>{{ number_format($product->calculated_try_price, 0, ',', '.') }} ₺</strong>
                    </div>
                @else
                    {{-- TRY ürün: sadece TRY --}}
                    @if($product->sale_price)
                        <span class="text-muted text-decoration-line-through fs-5">{{ number_format($product->price, 0, ',', '.') }} ₺</span>
                        <span class="fs-2 fw-bold text-danger ms-2">{{ number_format($product->sale_price, 0, ',', '.') }} ₺</span>
                        <span class="badge bg-danger ms-2">%{{ round((1 - $product->sale_price/$product->price)*100) }} İndirim</span>
                    @else
                        <span class="fs-2 fw-bold text-danger">{{ number_format($product->price, 0, ',', '.') }} ₺</span>
                    @endif
                @endif
            </div>

            @if($product->stock > 0)
                <div class="alert alert-success py-2"><i class="bi bi-check-circle-fill me-2"></i><strong>Stokta Var</strong> — {{ $product->stock }} adet</div>
            @else
                <div class="alert alert-secondary py-2"><i class="bi bi-x-circle me-2"></i>Stokta Yok</div>
            @endif

            @if($product->short_description)
                <p class="text-muted">{{ $product->short_description }}</p>
            @endif

            @auth
                @if($product->stock > 0)
                    <form action="{{ route('cart.add') }}" method="POST" class="d-flex gap-2 align-items-center mt-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="input-group" style="width:130px">
                            <button class="btn btn-outline-secondary" type="button" onclick="let q=this.nextElementSibling;if(q.value>1)q.value--">-</button>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control text-center">
                            <button class="btn btn-outline-secondary" type="button" onclick="let q=this.previousElementSibling;if(+q.value<{{ $product->stock }})q.value++">+</button>
                        </div>
                        <button type="submit" class="btn btn-danger btn-lg flex-grow-1">
                            <i class="bi bi-cart-plus me-2"></i>Sepete Ekle
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn btn-danger btn-lg mt-3 w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sepete Eklemek İçin Giriş Yap
                </a>
            @endauth

        </div>
    </div>

    {{-- Teknik Özellikler + Aracıma Uyar Mı? yan yana --}}
    @php
        $specs = array_filter([
            'Kategori'       => $product->category->name ?? null,
            'Parça Markası'  => $product->part_brand ?? $product->brand,
            'OEM Numarası'   => $product->oem_number,
            'Ürün Durumu'    => $product->condition,
            'Uyumlu Marka'   => $product->vehicle_make,
            'Araç Serisi'    => $product->vehicle_model,
            'SKU'            => $product->sku,
        ]);
    @endphp

    <div class="row g-4 mt-0">
        @if(count($specs))
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white fw-semibold py-3">
                    <i class="bi bi-list-check me-2 text-danger"></i>Teknik Özellikler
                </div>
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle">
                        <tbody>
                            @foreach($specs as $label => $value)
                            <tr>
                                <th class="text-muted fw-normal ps-4" style="width:160px;">{{ $label }}</th>
                                <td class="fw-semibold">{{ $value }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <div class="{{ count($specs) ? 'col-lg-6' : 'col-12' }}">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="fw-bold mb-0">
                        <i class="bi bi-car-front me-2 text-danger"></i>Aracıma Uyar Mı?
                    </h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Araç modelinizi öğrenmek için şasi numaranızı girin.</p>
                    <div class="input-group mb-2">
                        <input
                            type="text"
                            id="vinInput"
                            class="form-control text-uppercase"
                            placeholder="Şasi No (17 karakter)"
                            maxlength="17"
                            style="letter-spacing:.05em;"
                        >
                        <button id="vinBtn" class="btn btn-danger" type="button">
                            <span id="vinBtnText"><i class="bi bi-search me-1"></i>Sorgula</span>
                            <span id="vinBtnSpinner" class="d-none">
                                <span class="spinner-border spinner-border-sm me-1" role="status"></span>Sorgulanıyor…
                            </span>
                        </button>
                    </div>
                    <div id="vinResult"></div>
                </div>
            </div>
        </div>
    </div>

    @if($product->description)
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Ürün Açıklaması</h5>
                <p class="text-muted">{{ $product->description }}</p>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
(function () {
    const input   = document.getElementById('vinInput');
    const btn     = document.getElementById('vinBtn');
    const btnText = document.getElementById('vinBtnText');
    const spinner = document.getElementById('vinBtnSpinner');
    const result  = document.getElementById('vinResult');

    function setLoading(on) {
        btn.disabled = on;
        btnText.classList.toggle('d-none', on);
        spinner.classList.toggle('d-none', !on);
    }

    function showAlert(type, html) {
        result.innerHTML = `<div class="alert alert-${type} py-2 mb-0 mt-2">${html}</div>`;
    }

    btn.addEventListener('click', async function () {
        const vin = input.value.trim().toUpperCase();

        if (vin.length !== 17) {
            showAlert('warning', '<i class="bi bi-exclamation-triangle me-2"></i>Şasi numarası tam olarak <strong>17 karakter</strong> olmalıdır.');
            return;
        }

        result.innerHTML = '';
        setLoading(true);

        try {
            const res = await fetch('{{ route('vin.decode') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ vin }),
            });

            const data = await res.json();

            if (res.ok && data.success) {
                showAlert(
                    'success',
                    `<i class="bi bi-check-circle-fill me-2"></i>` +
                    `<strong>Aracınız:</strong> ${data.year} ${data.make} ${data.model}`
                );
            } else {
                showAlert('danger', `<i class="bi bi-x-circle me-2"></i>${data.message ?? 'Araç bilgisi alınamadı.'}`);
            }
        } catch {
            showAlert('danger', '<i class="bi bi-wifi-off me-2"></i>Bağlantı hatası. Lütfen tekrar deneyin.');
        } finally {
            setLoading(false);
        }
    });

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') btn.click();
    });
})();
</script>
@endpush

@endsection
