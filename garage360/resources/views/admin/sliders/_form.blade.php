@if($errors->any())
    <div class="alert alert-danger mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="mb-3">
    <label class="form-label fw-semibold">Başlık <span class="text-muted fw-normal small">(isteğe bağlı)</span></label>
    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
           value="{{ old('title', $slider->title ?? '') }}">
    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Alt Başlık</label>
    <input type="text" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror"
           value="{{ old('subtitle', $slider->subtitle ?? '') }}">
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Buton Metni</label>
        <input type="text" name="button_text" class="form-control"
               value="{{ old('button_text', $slider->button_text ?? '') }}" placeholder="Örn: Ürünleri İncele">
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Buton Linki</label>
        <input type="text" name="button_url" class="form-control"
               value="{{ old('button_url', $slider->button_url ?? '') }}" placeholder="/urunler">
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Arka Plan Rengi</label>
        <div class="input-group">
            <input type="color" name="bg_color" class="form-control form-control-color" style="max-width:60px"
                   value="{{ old('bg_color', $slider->bg_color ?? '#1d1d1d') }}">
            <input type="text" class="form-control" id="bgColorText"
                   value="{{ old('bg_color', $slider->bg_color ?? '#1d1d1d') }}" readonly>
        </div>
    </div>
    <div class="col-md-3">
        <label class="form-label fw-semibold">Sıralama</label>
        <input type="number" name="sort_order" class="form-control" min="0"
               value="{{ old('sort_order', $slider->sort_order ?? 0) }}">
    </div>
    <div class="col-md-3 d-flex align-items-end">
        <div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                   {{ old('is_active', $slider->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label fw-semibold" for="isActive">Aktif</label>
        </div>
    </div>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Görsel</label>
    @if(!empty($slider->image))
        <div class="mb-2">
            <img src="{{ asset('storage/'.$slider->image) }}" alt="" style="max-height:120px;border-radius:8px;">
            <div class="text-muted small mt-1">Yeni dosya seçerseniz mevcut görsel değiştirilir.</div>
        </div>
    @endif
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
    <div class="form-text">Önerilen boyut: 1400×500 px. Maks 3 MB.</div>
</div>

@push('scripts')
<script>
    document.querySelector('input[type=color]').addEventListener('input', function() {
        document.getElementById('bgColorText').value = this.value;
    });
</script>
@endpush
