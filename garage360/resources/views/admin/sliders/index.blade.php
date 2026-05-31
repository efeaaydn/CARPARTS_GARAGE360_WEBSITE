@extends('admin.layout.base')
@section('title', 'Slider Yönetimi')
@section('page-title', 'Slider Yönetimi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <p class="text-muted mb-0">Anasayfa slayt gösterisini buradan yönetin.</p>
    <a href="{{ route('admin.sliders.create') }}" class="btn btn-danger">
        <i class="bi bi-plus-lg me-1"></i> Yeni Slider
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th width="60">Sıra</th>
                    <th>Görsel</th>
                    <th>Başlık</th>
                    <th>Alt Başlık</th>
                    <th>Durum</th>
                    <th width="120">İşlem</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sliders as $slider)
                <tr>
                    <td class="text-muted">{{ $slider->sort_order }}</td>
                    <td>
                        @if($slider->image)
                            <img src="{{ asset('storage/'.$slider->image) }}" alt="" style="height:50px;width:90px;object-fit:cover;border-radius:6px;">
                        @else
                            <div class="rounded d-flex align-items-center justify-content-center text-muted bg-light" style="height:50px;width:90px;">
                                <i class="bi bi-image"></i>
                            </div>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $slider->title }}</td>
                    <td class="text-muted small">{{ Str::limit($slider->subtitle, 60) }}</td>
                    <td>
                        @if($slider->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Pasif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.sliders.edit', $slider) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Bu slider\'ı silmek istediğinize emin misiniz?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-5">
                        <i class="bi bi-images fs-2 d-block mb-2"></i>
                        Henüz slider eklenmemiş.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
