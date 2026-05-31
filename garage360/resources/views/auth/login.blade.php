<x-guest-layout>
    <h5 class="fw-bold mb-4 text-center">Giriş Yap</h5>

    @if(session('status'))
        <div class="alert alert-success mb-3">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">E-posta</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Şifre</label>
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label">Beni Hatırla</label>
        </div>

        <button type="submit" class="btn btn-danger w-100 fw-semibold">Giriş Yap</button>

        <div class="d-flex justify-content-between mt-3 small">
            @if(Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-muted">Şifremi unuttum</a>
            @endif
            <a href="{{ route('register') }}" class="text-muted">Hesap oluştur</a>
        </div>
    </form>
</x-guest-layout>
