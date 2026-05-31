@extends('admin.layout.base')
@section('title', 'Kullanıcılar')
@section('page-title', 'Kullanıcı Yönetimi')

@section('content')
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kullanıcı</th>
                    <th>E-posta</th>
                    <th>Rol</th>
                    <th>Durum</th>
                    <th>Bakiye</th>
                    <th>Sipariş</th>
                    <th>Kayıt</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="{{ !$user->is_active ? 'table-secondary' : '' }}">
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                 style="width:36px;height:36px;font-size:.8rem;flex-shrink:0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="fw-medium">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-muted small">{{ $user->email }}</td>
                    <td>
                        @foreach($user->getRoleNames() as $role)
                            <span class="badge bg-{{ $role === 'admin' ? 'danger' : 'primary' }}">{{ $role }}</span>
                        @endforeach
                    </td>
                    <td>
                        @if($user->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-warning text-dark">Pasif</span>
                        @endif
                    </td>
                    <td>{{ number_format($user->balance_amount, 2, ',', '.') }} ₺</td>
                    <td>{{ $user->orders_count }}</td>
                    <td class="text-muted small">{{ $user->created_at->format('d.m.Y') }}</td>
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            {{-- Bakiye Ekle --}}
                            <form action="{{ route('admin.users.addBalance', $user) }}" method="POST" class="d-flex gap-1">
                                @csrf
                                <input type="number" name="amount" class="form-control form-control-sm" style="width:80px" placeholder="₺" min="1" step="0.01">
                                <button class="btn btn-sm btn-outline-success" title="Bakiye Ekle"><i class="bi bi-plus-circle"></i></button>
                            </form>

                            {{-- Düzenle --}}
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#editUserModal{{ $user->id }}" title="Düzenle">
                                <i class="bi bi-pencil"></i>
                            </button>

                            {{-- Dondur / Aktifleştir --}}
                            @if(!$user->hasRole('admin'))
                            <form action="{{ route('admin.users.toggleActive', $user) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-outline-{{ $user->is_active ? 'warning' : 'success' }}"
                                        title="{{ $user->is_active ? 'Hesabı Dondur' : 'Hesabı Aktifleştir' }}">
                                    <i class="bi bi-{{ $user->is_active ? 'pause-circle' : 'play-circle' }}"></i>
                                </button>
                            </form>

                            {{-- Sil --}}
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('{{ $user->name }} adlı kullanıcıyı silmek istiyor musunuz?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Sil">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>

                {{-- Kullanıcı Düzenleme Modal --}}
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Kullanıcı Düzenle</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Ad Soyad</label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">E-posta</label>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Telefon</label>
                                        <input type="text" name="phone" class="form-control" value="{{ $user->phone }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Yeni Şifre <small class="text-muted">(boş bırakılırsa değişmez)</small></label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">İptal</button>
                                    <button type="submit" class="btn btn-primary">Kaydet</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <i class="bi bi-people fs-2 d-block mb-2"></i>Kullanıcı bulunamadı
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white">{{ $users->links() }}</div>
    @endif
</div>
@endsection
