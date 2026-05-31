<p class="text-muted small mb-3">
    Hesabınız silindiğinde tüm verileriniz kalıcı olarak kaldırılır. Bu işlem geri alınamaz.
</p>

<button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
    <i class="bi bi-trash me-1"></i>Hesabımı Sil
</button>

{{-- Modal --}}
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger fw-bold">
                        <i class="bi bi-exclamation-triangle me-2"></i>Hesabı Sil
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted small">
                        Hesabınızı silmek istediğinizden emin misiniz? Onaylamak için şifrenizi girin.
                    </p>
                    <div>
                        <label for="delete_password" class="form-label">Şifre</label>
                        <input id="delete_password" name="password" type="password"
                               class="form-control @if($errors->userDeletion->has('password')) is-invalid @endif"
                               placeholder="Şifrenizi girin">
                        @if($errors->userDeletion->has('password'))
                            <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Evet, Sil
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new bootstrap.Modal(document.getElementById('deleteAccountModal')).show();
    });
</script>
@endif
