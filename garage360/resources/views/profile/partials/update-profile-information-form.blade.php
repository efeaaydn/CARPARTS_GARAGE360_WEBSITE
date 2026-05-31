<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="mb-3">
        <label for="name" class="form-label">Ad Soyad</label>
        <input id="name" name="name" type="text"
               class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $user->name) }}" required autofocus>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">E-posta</label>
        <input id="email" name="email" type="email"
               class="form-control @error('email') is-invalid @enderror"
               value="{{ old('email', $user->email) }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="alert alert-warning py-2 mt-2 small">
                E-posta adresiniz doğrulanmamış.
                <button form="send-verification" class="btn btn-link btn-sm p-0 ms-1">Doğrulama e-postası gönder.</button>
            </div>
            @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success py-2 mt-2 small">Doğrulama bağlantısı gönderildi.</div>
            @endif
        @endif
    </div>

    <div class="mb-3">
        <label for="phone" class="form-label">Telefon</label>
        <input id="phone" name="phone" type="text"
               class="form-control @error('phone') is-invalid @enderror"
               value="{{ old('phone', $user->phone) }}" placeholder="05xx xxx xx xx">
        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="address" class="form-label">Adres</label>
        <textarea id="address" name="address" rows="2"
                  class="form-control @error('address') is-invalid @enderror"
                  placeholder="Mahalle, sokak, bina no...">{{ old('address', $user->address) }}</textarea>
        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label for="city" class="form-label">Şehir</label>
        <input id="city" name="city" type="text"
               class="form-control @error('city') is-invalid @enderror"
               value="{{ old('city', $user->city) }}" placeholder="İstanbul">
        @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-danger">Kaydet</button>
        @if (session('status') === 'profile-updated')
            <span class="text-success small"><i class="bi bi-check-circle me-1"></i>Kaydedildi.</span>
        @endif
    </div>
</form>
