<x-guest-layout>
    <h5 class="fw-bold mb-3 text-center">Şifremi Unuttum</h5>

    <p class="text-muted small text-center mb-4">
        E-posta adresinizi girin, size şifre sıfırlama bağlantısı gönderelim.
    </p>

    @if(session('status'))
        <div class="alert alert-success mb-3">
            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">E-posta Adresi</label>
            <input id="email" type="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn btn-danger w-100 fw-semibold">
            <i class="bi bi-envelope me-1"></i>Sıfırlama Bağlantısı Gönder
        </button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-muted small">
                <i class="bi bi-arrow-left me-1"></i>Giriş sayfasına dön
            </a>
        </div>
    </form>
</x-guest-layout>
