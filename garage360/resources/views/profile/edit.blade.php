@extends('layouts.app')
@section('title', 'Profilim')

@section('content')
<div class="container py-4" style="max-width: 760px">
    <h4 class="fw-bold mb-4"><i class="bi bi-person-circle me-2"></i>Profil Ayarları</h4>

    {{-- Profil Bilgileri --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">Hesap Bilgileri</div>
        <div class="card-body">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Şifre --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-semibold">Şifre Güncelle</div>
        <div class="card-body">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Üyeliği Pasife Al --}}
    <div class="card shadow-sm border-warning mb-4">
        <div class="card-header bg-white fw-semibold text-warning">
            <i class="bi bi-pause-circle me-1"></i>Üyeliği Pasife Al
        </div>
        <div class="card-body">
            <p class="text-muted small mb-3">
                Hesabınızı pasife aldığınızda giriş yapamazsınız. Yeniden aktifleştirmek için destek ile iletişime geçebilirsiniz.
            </p>
            <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#deactivateAccountModal">
                <i class="bi bi-pause-circle me-1"></i>Hesabımı Pasife Al
            </button>

            <div class="modal fade" id="deactivateAccountModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="{{ route('profile.deactivate') }}">
                            @csrf
                            <div class="modal-header border-0">
                                <h5 class="modal-title text-warning fw-bold">
                                    <i class="bi bi-pause-circle me-2"></i>Hesabı Pasife Al
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted small">Onaylamak için şifrenizi girin.</p>
                                <div>
                                    <label for="deactivate_password" class="form-label">Şifre</label>
                                    <input id="deactivate_password" name="password" type="password"
                                           class="form-control @if($errors->userDeactivation->has('password')) is-invalid @endif"
                                           placeholder="Şifrenizi girin">
                                    @if($errors->userDeactivation->has('password'))
                                        <div class="invalid-feedback">{{ $errors->userDeactivation->first('password') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="modal-footer border-0">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">İptal</button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-pause-circle me-1"></i>Pasife Al
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if($errors->userDeactivation->isNotEmpty())
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    new bootstrap.Modal(document.getElementById('deactivateAccountModal')).show();
                });
            </script>
            @endif
        </div>
    </div>

    {{-- Hesap Sil --}}
    <div class="card shadow-sm border-danger">
        <div class="card-header bg-white fw-semibold text-danger">Hesabı Sil</div>
        <div class="card-body">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
