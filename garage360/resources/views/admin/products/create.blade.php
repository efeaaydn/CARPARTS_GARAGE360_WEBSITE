@extends('admin.layout.base')
@section('title', 'Yeni Ürün')
@section('page-title', 'Yeni Ürün Ekle')

@section('content')
<div class="row justify-content-center">
<div class="col-xl-10">

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
@csrf

@if($errors->any())
    <div class="alert alert-danger mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="row g-3">

    {{-- ── Sol: Ürün Bilgileri ── --}}
    <div class="col-lg-8 d-flex flex-column gap-3">

        {{-- Temel Bilgiler --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold border-bottom">
                <i class="bi bi-box-seam me-2 text-danger"></i>Ürün Bilgileri
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ürün Adı <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-4">
                        <label class="form-label fw-semibold">SKU <span class="text-danger">*</span></label>
                        <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                               value="{{ old('sku') }}" required>
                        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label fw-semibold">OEM Numarası</label>
                        <input type="text" name="oem_number" class="form-control" value="{{ old('oem_number') }}">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label fw-semibold">Ürün Durumu</label>
                        <select name="condition" class="form-select">
                            <option value="Sıfır" {{ old('condition', 'Sıfır') === 'Sıfır' ? 'selected' : '' }}>Sıfır</option>
                            <option value="İkinci El" {{ old('condition') === 'İkinci El' ? 'selected' : '' }}>İkinci El</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kısa Açıklama</label>
                    <input type="text" name="short_description" class="form-control"
                           value="{{ old('short_description') }}" maxlength="500">
                </div>
                <div class="mb-0">
                    <label class="form-label fw-semibold">Açıklama</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Parça & Araç Bilgileri --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold border-bottom">
                <i class="bi bi-car-front me-2 text-danger"></i>Parça & Araç Uyumu
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label fw-semibold">Parça Markası</label>
                        <select name="part_brand" class="form-select">
                            <option value="">— Seçiniz —</option>
                            @foreach(\App\Http\Controllers\Admin\AdminProductController::PART_BRANDS as $b)
                                <option value="{{ $b }}" {{ old('part_brand') === $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label fw-semibold">Parça Markası (Diğer)</label>
                        <input type="text" name="brand" class="form-control"
                               value="{{ old('brand') }}" placeholder="Listede yoksa buraya yazın">
                        <div class="form-text">Seçilirse Parça Markası alanı önceliklidir.</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label fw-semibold">Araç Markası</label>
                        <select name="vehicle_make" id="vehicleMake" class="form-select">
                            <option value="">— Seçiniz —</option>
                            @foreach(\App\Http\Controllers\Admin\AdminProductController::VEHICLE_MAKES as $make)
                                <option value="{{ $make }}" {{ old('vehicle_make') === $make ? 'selected' : '' }}>{{ $make }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label fw-semibold">Araç Serisi / Modeli</label>
                        <input type="text" name="vehicle_model" id="vehicleModel" class="form-control"
                               value="{{ old('vehicle_model') }}" placeholder="Örn: 3 Serisi, Egea, Corolla">
                    </div>
                </div>
            </div>
        </div>

        {{-- Fiyat & Stok --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold border-bottom">
                <i class="bi bi-tag me-2 text-danger"></i>Fiyat & Stok
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-3">
                        <label class="form-label fw-semibold">Para Birimi <span class="text-danger">*</span></label>
                        <select name="currency" class="form-select @error('currency') is-invalid @enderror" required>
                            <option value="TRY" {{ old('currency', 'TRY') === 'TRY' ? 'selected' : '' }}>₺ TRY</option>
                            <option value="EUR" {{ old('currency') === 'EUR' ? 'selected' : '' }}>€ EUR</option>
                        </select>
                        @error('currency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">EUR ise TRY'ye otomatik çevrilir</div>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label fw-semibold">Normal Fiyat <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price') }}" min="0" step="0.01" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label fw-semibold">İndirimli Fiyat</label>
                        <input type="number" name="sale_price" class="form-control"
                               value="{{ old('sale_price') }}" min="0" step="0.01">
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                               value="{{ old('stock', 0) }}" min="0" required>
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Sağ: Ayarlar ── --}}
    <div class="col-lg-4 d-flex flex-column gap-3">

        {{-- Yayın & Kategori --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold border-bottom">
                <i class="bi bi-sliders me-2 text-danger"></i>Yayın Ayarları
            </div>
            <div class="card-body">

                {{-- Ana Kategori --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Ana Kategori <span class="text-danger">*</span></label>
                    <select id="parentCat" class="form-select" data-url="{{ url('/api/categories') }}">
                        <option value="">— Seçiniz —</option>
                        @foreach($rootCategories as $cat)
                            <option value="{{ $cat->id }}" {{ old('parent_cat') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Alt Kategori (AJAX ile dolar) --}}
                <div class="mb-3" id="subCatWrap" style="display:none;">
                    <label class="form-label fw-semibold">Alt Kategori</label>
                    <select id="subCat" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">— Seçiniz —</option>
                    </select>
                    @error('category_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                {{-- Eğer alt kategori yoksa category_id doğrudan parent'tan gelir --}}
                <input type="hidden" id="catIdFallback" name="category_id" value="{{ old('category_id') }}">

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1">
                    <label class="form-check-label" for="is_featured">Öne Çıkan</label>
                </div>
            </div>
        </div>

        {{-- Görsel --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold border-bottom">
                <i class="bi bi-image me-2 text-danger"></i>Ana Ürün Görseli
            </div>
            <div class="card-body">
                <input type="file" name="image" id="imgFile"
                       class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">Maks. 2MB · JPG / PNG</div>
                <img id="imgPreview" src="" alt="" class="img-fluid rounded mt-2 d-none">
            </div>
        </div>

        {{-- Galeri (çoklu fotoğraf) --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold border-bottom">
                <i class="bi bi-images me-2 text-danger"></i>Ürün Galerisi
                <span class="text-muted fw-normal small ms-1">(en fazla 6 ek fotoğraf)</span>
            </div>
            <div class="card-body">
                <input type="file" name="gallery[]" multiple accept="image/*"
                       class="form-control @error('gallery.*') is-invalid @enderror" id="galleryInput">
                @error('gallery.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">Birden fazla fotoğraf seçebilirsiniz (her biri max 2MB).</div>
                <div class="row g-2 mt-2" id="galleryPreview"></div>
            </div>
        </div>

        {{-- Butonlar --}}
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-danger fw-semibold">
                <i class="bi bi-check-lg me-1"></i>Kaydet
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">İptal</a>
        </div>

    </div>
</div>
</form>

</div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const parentSel = document.getElementById('parentCat');
    const subWrap   = document.getElementById('subCatWrap');
    const subSel    = document.getElementById('subCat');
    const fallback  = document.getElementById('catIdFallback');

    parentSel.addEventListener('change', function () {
        const pid = this.value;
        subWrap.style.display = 'none';
        subSel.innerHTML = '<option value="">— Seçiniz —</option>';
        subSel.removeAttribute('name');
        fallback.name  = 'category_id';
        fallback.value = pid;

        if (!pid) return;

        fetch(`/api/categories/${pid}/children`)
            .then(r => r.json())
            .then(data => {
                if (data.length === 0) {
                    // Kök kategori doğrudan ürüne bağlanıyor
                    fallback.value = pid;
                    return;
                }
                // Alt kategoriler var
                fallback.name  = '';
                fallback.value = '';
                subSel.name    = 'category_id';
                data.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value       = c.id;
                    opt.textContent = c.name;
                    subSel.appendChild(opt);
                });
                subWrap.style.display = 'block';
            });
    });

    // Görsel önizleme
    document.getElementById('imgFile').addEventListener('change', function () {
        const preview = document.getElementById('imgPreview');
        if (this.files[0]) {
            preview.src = URL.createObjectURL(this.files[0]);
            preview.classList.remove('d-none');
        }
    });
})();
</script>
@endpush
