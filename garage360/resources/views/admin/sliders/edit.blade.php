@extends('admin.layout.base')
@section('title', 'Slider Düzenle')
@section('page-title', 'Slider Düzenle')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('admin.sliders.update', $slider) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    @include('admin.sliders._form')
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-danger px-4">Güncelle</button>
                        <a href="{{ route('admin.sliders.index') }}" class="btn btn-outline-secondary">İptal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
