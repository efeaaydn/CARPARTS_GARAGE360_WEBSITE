<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="mb-3">
        <label for="current_password" class="form-label">Mevcut Şifre</label>
        <input id="current_password" name="current_password" type="password"
               class="form-control @if($errors->updatePassword->get('current_password')) is-invalid @endif"
               autocomplete="current-password">
        @if($errors->updatePassword->has('current_password'))
            <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>
        @endif
    </div>

    <div class="mb-3">
        <label for="new_password" class="form-label">Yeni Şifre</label>
        <input id="new_password" name="password" type="password"
               class="form-control @if($errors->updatePassword->get('password')) is-invalid @endif"
               autocomplete="new-password">
        @if($errors->updatePassword->has('password'))
            <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>
        @endif
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Şifre Tekrar</label>
        <input id="password_confirmation" name="password_confirmation" type="password"
               class="form-control" autocomplete="new-password">
    </div>

    <div class="d-flex align-items-center gap-3">
        <button type="submit" class="btn btn-danger">Şifremi Güncelle</button>
        @if (session('status') === 'password-updated')
            <span class="text-success small"><i class="bi bi-check-circle me-1"></i>Şifre güncellendi.</span>
        @endif
    </div>
</form>
