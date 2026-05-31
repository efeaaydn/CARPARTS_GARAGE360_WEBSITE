@extends('admin.layout.base')
@section('title', 'Ürün Düzenle')
@section('page-title', 'Ürün Düzenle: ' . $product->name)

@section('content')
<div class="row justify-content-center">
<div class="col-xl-10">

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

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
                           value="{{ old('name', $product->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-4">
                        <label class="form-label fw-semibold">SKU <span class="text-danger">*</span></label>
                        <input type="text" name="sku" class="form-control @error('sku') is-invalid @enderror"
                               value="{{ old('sku', $product->sku) }}" required>
                        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label fw-semibold">OEM Numarası</label>
                        <input type="text" name="oem_number" class="form-control"
                               value="{{ old('oem_number', $product->oem_number) }}">
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label fw-semibold">Ürün Durumu</label>
                        <select name="condition" class="form-select">
                            <option value="Sıfır"    {{ old('condition', $product->condition) === 'Sıfır'     ? 'selected' : '' }}>Sıfır</option>
                            <option value="İkinci El" {{ old('condition', $product->condition) === 'İkinci El' ? 'selected' : '' }}>İkinci El</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kısa Açıklama</label>
                    <input type="text" name="short_description" class="form-control"
                           value="{{ old('short_description', $product->short_description) }}" maxlength="500">
                </div>
                <div class="mb-0">
                    <label class="form-label fw-semibold">Açıklama</label>
                    <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
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
                                <option value="{{ $b }}" {{ old('part_brand', $product->part_brand) === $b ? 'selected' : '' }}>{{ $b }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label fw-semibold">Parça Markası (Diğer)</label>
                        <input type="text" name="brand" class="form-control"
                               value="{{ old('brand', $product->brand) }}" placeholder="Listede yoksa buraya yazın">
                        <div class="form-text">Seçilirse Parça Markası alanı önceliklidir.</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label fw-semibold">Araç Markası</label>
                        <select name="vehicle_make" id="vehicleMake" class="form-select">
                            <option value="">— Seçiniz —</option>
                            @foreach(\App\Http\Controllers\Admin\AdminProductController::VEHICLE_MAKES as $make)
                                <option value="{{ $make }}" {{ old('vehicle_make', $product->vehicle_make) === $make ? 'selected' : '' }}>{{ $make }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label fw-semibold">Araç Serisi / Modeli</label>
                        <input type="text" name="vehicle_model" id="vehicleModel" class="form-control"
                               value="{{ old('vehicle_model', $product->vehicle_model) }}"
                               placeholder="Örn: 3 Serisi, Egea, Corolla">
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
                            <option value="TRY" {{ old('currency', $product->currency) === 'TRY' ? 'selected' : '' }}>₺ TRY</option>
                            <option value="EUR" {{ old('currency', $product->currency) === 'EUR' ? 'selected' : '' }}>€ EUR</option>
                        </select>
                        @error('currency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">EUR ise TRY'ye otomatik çevrilir</div>
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label fw-semibold">Normal Fiyat <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label fw-semibold">İndirimli Fiyat</label>
                        <input type="number" name="sale_price" class="form-control"
                               value="{{ old('sale_price', $product->sale_price) }}" min="0" step="0.01">
                    </div>
                    <div class="col-sm-3">
                        <label class="form-label fw-semibold">Stok <span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                               value="{{ old('stock', $product->stock) }}" min="0" required>
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
                    <select id="parentCat" class="form-select">
                        <option value="">— Seçiniz —</option>
                        @foreach($rootCategories as $cat)
                            <option value="{{ $cat->id }}" {{ $selectedParentId == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Alt Kategori --}}
                <div class="mb-3" id="subCatWrap" style="{{ $subCategories->count() ? '' : 'display:none;' }}">
                    <label class="form-label fw-semibold">Alt Kategori</label>
                    <select id="subCat" name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">— Seçiniz —</option>
                        @foreach($subCategories as $sub)
                            <option value="{{ $sub->id }}" {{ $selectedSubId == $sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>

                {{-- Eğer alt kategori yoksa category_id doğrudan parent'tan gelir --}}
                <input type="hidden" id="catIdFallback"
                    name="{{ $subCategories->count() ? '' : 'category_id' }}"
                    value="{{ $subCategories->count() ? '' : $selectedParentId }}">

                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                           {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Aktif</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1"
                           {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
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
                @if($product->image)
                    <img id="imgPreview" src="{{ Storage::url($product->image) }}" alt=""
                         class="img-fluid rounded mb-2" style="max-height:180px;">
                @else
                    <img id="imgPreview" src="" alt="" class="img-fluid rounded mb-2 d-none">
                @endif
                <input type="file" name="image" id="imgFile"
                       class="form-control @error('image') is-invalid @enderror" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">Yeni dosya seçmezseniz mevcut görsel korunur.</div>
            </div>
        </div>

        {{-- Galeri (çoklu fotoğraf) --}}
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold border-bottom">
                <i class="bi bi-images me-2 text-danger"></i>Ürün Galerisi
                <span class="text-muted fw-normal small ms-1">(en fazla 6 ek fotoğraf)</span>
            </div>
            <div class="card-body">
                {{-- Mevcut galeri fotoğrafları --}}
                @if($product->gallery && count($product->gallery) > 0)
                <div class="row g-2 mb-3" id="galleryExisting">
                    @foreach($product->gallery as $i => $img)
                    <div class="col-4 col-md-3 position-relative" id="galleryItem{{ $i }}">
                        <img src="{{ Storage::url($img) }}" class="img-fluid rounded" style="height:90px;object-fit:cover;width:100%;">
                        <button type="button" class="btn btn-danger btn-sm p-0 position-absolute"
                                style="top:4px;right:8px;width:22px;height:22px;line-height:1;"
                                onclick="deleteGalleryImage({{ $i }}, this)"
                                title="Sil">
                            <i class="bi bi-x" style="font-size:.8rem;"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                @endif

                {{-- Yeni galeri fotoğrafları yükle --}}
                <label class="form-label small fw-semibold">Yeni Fotoğraf Ekle</label>
                <input type="file" name="gallery[]" multiple accept="image/*"
                       class="form-control @error('gallery.*') is-invalid @enderror">
                @error('gallery.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">Birden fazla fotoğraf seçebilirsiniz (her biri max 2MB).</div>

                {{-- Önizleme --}}
                <div class="row g-2 mt-2" id="galleryPreview"></div>
            </div>
        </div>

        {{-- Butonlar --}}
        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-danger fw-semibold">
                <i class="bi bi-check-lg me-1"></i>Güncelle
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
                    fallback.value = pid;
                    return;
                }
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

    // Galeri fotoğraf silme (AJAX)
    window.deleteGalleryImage = function(index, btn) {
        if (!confirm('Bu fotoğrafı silmek istediğinize emin misiniz?')) return;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('{{ route("admin.products.deleteGalleryImage", [$product, "__IDX__"]) }}'.replace('__IDX__', index), {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': token, 'Accept': 'application/json' }
        }).then(r => {
            if (r.ok) btn.closest('[id^="galleryItem"]').remove();
            else alert('Silme işlemi başarısız.');
        });
    };

    // Ana görsel önizleme
    document.getElementById('imgFile').addEventListener('change', function () {
        const preview = document.getElementById('imgPreview');
        if (this.files[0]) {
            preview.src = URL.createObjectURL(this.files[0]);
            preview.classList.remove('d-none');
        }
    });

    // Galeri önizleme
    const galleryInput = document.querySelector('input[name="gallery[]"]');
    const galleryPreview = document.getElementById('galleryPreview');
    if (galleryInput && galleryPreview) {
        galleryInput.addEventListener('change', function() {
            galleryPreview.innerHTML = '';
            Array.from(this.files).forEach(function(file) {
                const col = document.createElement('div');
                col.className = 'col-4 col-md-3';
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'img-fluid rounded';
                img.style = 'height:90px;object-fit:cover;width:100%;';
                col.appendChild(img);
                galleryPreview.appendChild(col);
            });
        });
    }
})();
</script>
@endpush
