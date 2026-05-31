@extends('layouts.app')
@section('title', 'Sepetim')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4"><i class="bi bi-cart3 me-2"></i>Sepetim</h4>

    @if($cart->items->isEmpty())
        <div class="text-center py-5 text-muted">
            <i class="bi bi-cart-x fs-1 d-block mb-3"></i>
            <h5>Sepetiniz boş</h5>
            <a href="{{ route('products.index') }}" class="btn btn-danger mt-3">Ürünlere Git</a>
        </div>
    @else
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ürün</th>
                                <th>Birim Fiyat</th>
                                <th style="width:130px">Adet</th>
                                <th>Toplam</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($item->product?->image)
                                            <img src="{{ Storage::url($item->product->image) }}" alt=""
                                                 style="width:50px;height:50px;object-fit:cover;border-radius:6px">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                 style="width:50px;height:50px"><i class="bi bi-box text-muted"></i></div>
                                        @endif
                                        <div>
                                            <a href="{{ $item->product ? route('products.show', $item->product) : '#' }}"
                                               class="text-decoration-none text-dark fw-medium">
                                                {{ $item->product?->name ?? 'Ürün bulunamadı' }}
                                            </a>
                                            @if($item->product?->brand)
                                                <div class="text-muted small">{{ $item->product->brand }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($item->price, 2, ',', '.') }} ₺</td>
                                <td>
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="d-flex gap-1">
                                        @csrf @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}"
                                               min="1" max="99" class="form-control form-control-sm text-center"
                                               style="width:65px"
                                               onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td class="fw-semibold">{{ number_format($item->subtotal, 2, ',', '.') }} ₺</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-semibold">Sipariş Özeti</div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Ara Toplam</span>
                        <span>{{ number_format($cart->total, 2, ',', '.') }} ₺</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Kargo</span>
                        <span class="text-success fw-semibold">Ücretsiz</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                        <span>Toplam</span>
                        <span class="text-danger">{{ number_format($cart->total, 2, ',', '.') }} ₺</span>
                    </div>

                    @auth
                    @php
                        $balance      = auth()->user()->balance_amount;
                        $cartTotal    = $cart->total;
                        $balanceUsed  = min($balance, $cartTotal);
                        $remaining    = max(0, $cartTotal - $balanceUsed);
                    @endphp

                    <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                        @csrf

                        {{-- Bakiye seçeneği --}}
                        @if($balance > 0)
                        <div class="border rounded-3 p-3 mb-3 bg-light">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-wallet2 text-success fs-5"></i>
                                <span class="fw-semibold small">Hesap Bakiyesi</span>
                                <span class="badge bg-success ms-auto">{{ number_format($balance, 2, ',', '.') }} ₺</span>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <label class="d-flex align-items-center gap-2 p-2 rounded-2 cursor-pointer"
                                       style="cursor:pointer;border:2px solid transparent;"
                                       id="labelUseBalance">
                                    <input class="form-check-input m-0 flex-shrink-0" type="radio"
                                           name="use_balance" value="1" id="useBalanceYes"
                                           data-balance="{{ $balanceUsed }}"
                                           data-remaining="{{ $remaining }}"
                                           data-total="{{ $cartTotal }}">
                                    <div class="small lh-sm">
                                        <div class="fw-semibold text-success">Bakiyemi kullan</div>
                                        <div class="text-muted">
                                            {{ number_format($balanceUsed, 2, ',', '.') }} ₺ düşülür
                                            @if($remaining > 0)
                                                · Kalan <strong>{{ number_format($remaining, 2, ',', '.') }} ₺</strong> ödenir
                                            @else
                                                · <strong>Ek ödeme gerekmez</strong>
                                            @endif
                                        </div>
                                    </div>
                                </label>
                                <label class="d-flex align-items-center gap-2 p-2 rounded-2"
                                       style="cursor:pointer;border:2px solid transparent;"
                                       id="labelNoBalance">
                                    <input class="form-check-input m-0 flex-shrink-0" type="radio"
                                           name="use_balance" value="0" id="useBalanceNo" checked>
                                    <div class="small">
                                        <div class="fw-semibold">Bakiyemi kullanma</div>
                                        <div class="text-muted">Tüm tutar ödenir</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @else
                        <input type="hidden" name="use_balance" value="0">
                        @endif

                        {{-- Ödenecek tutar satırı --}}
                        <div class="d-flex justify-content-between fw-bold fs-5 mb-1" id="payableRow">
                            <span>Ödenecek Tutar</span>
                            <span class="text-danger" id="payableAmount">{{ number_format($cartTotal, 2, ',', '.') }} ₺</span>
                        </div>
                        @if($balance > 0)
                        <div class="text-muted small mb-3" id="balanceDeductRow" style="display:none;">
                            <i class="bi bi-wallet2 me-1 text-success"></i>
                            <span id="balanceDeductText"></span>
                        </div>
                        @endif

                        <hr class="my-3">

                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Teslimat Adresi</label>
                            <textarea name="address" class="form-control form-control-sm" rows="3"
                                      placeholder="Mahalle, Sokak, No, Daire..." required>{{ old('address', auth()->user()->address) }}</textarea>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <input type="text" name="city" class="form-control form-control-sm"
                                       placeholder="Şehir" required value="{{ old('city', auth()->user()->city) }}">
                            </div>
                            <div class="col-6">
                                <input type="text" name="phone" class="form-control form-control-sm"
                                       placeholder="Telefon" required value="{{ old('phone', auth()->user()->phone) }}">
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger w-100 fw-semibold"
                                data-bs-toggle="modal" data-bs-target="#paymentModal">
                            <i class="bi bi-credit-card me-1"></i>Ödemeye Geç
                        </button>
                    </form>

                    {{-- Kredi Kartı Ödeme Modalı --}}
                    <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">
                                        <i class="bi bi-credit-card me-2 text-danger"></i>Kredi Kartı ile Ödeme
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    {{-- Kart Önizleme --}}
                                    <div class="rounded-3 p-3 mb-4 text-white position-relative"
                                         style="background:linear-gradient(135deg,#1a1a2e,#e63946);min-height:120px;">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <i class="bi bi-credit-card-2-front fs-3 opacity-75"></i>
                                            <span class="fw-bold opacity-75" id="cardBrandPreview">VISA</span>
                                        </div>
                                        <div class="fw-bold fs-5 letter-spacing-1 mb-2" id="cardNumberPreview">
                                            **** **** **** ****
                                        </div>
                                        <div class="d-flex justify-content-between small opacity-75">
                                            <span id="cardNamePreview">AD SOYAD</span>
                                            <span id="cardExpPreview">AA/YY</span>
                                        </div>
                                    </div>

                                    <div id="paymentFormFields">
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Kart Numarası</label>
                                            <input type="text" id="cardNumber" class="form-control"
                                                   placeholder="0000 0000 0000 0000" maxlength="19" autocomplete="off">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label small fw-semibold">Kart Sahibinin Adı</label>
                                            <input type="text" id="cardName" class="form-control"
                                                   placeholder="AD SOYAD" autocomplete="off">
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-7">
                                                <label class="form-label small fw-semibold">Son Kullanma Tarihi</label>
                                                <input type="text" id="cardExp" class="form-control"
                                                       placeholder="AA/YY" maxlength="5" autocomplete="off">
                                            </div>
                                            <div class="col-5">
                                                <label class="form-label small fw-semibold">CVV</label>
                                                <input type="text" id="cardCvv" class="form-control"
                                                       placeholder="***" maxlength="4" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 text-muted small mb-3">
                                            <i class="bi bi-shield-lock-fill text-success"></i>
                                            256-bit SSL ile korunan güvenli ödeme
                                        </div>
                                    </div>

                                    {{-- Simüle: sadece doğrulama amaçlı, gerçek ödeme değil --}}
                                    <div id="paymentProcessing" class="text-center py-3 d-none">
                                        <div class="spinner-border text-danger mb-2" role="status"></div>
                                        <div class="fw-semibold">Ödeme işleniyor...</div>
                                        <div class="text-muted small">Lütfen bekleyin</div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">İptal</button>
                                    <button type="button" class="btn btn-danger fw-semibold" id="confirmPaymentBtn">
                                        <i class="bi bi-lock me-1"></i>Ödemeyi Onayla
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @else
                    <a href="{{ route('login') }}" class="btn btn-danger w-100">
                        Giriş Yaparak Sipariş Ver
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
(function () {
    const radYes   = document.getElementById('useBalanceYes');
    const radNo    = document.getElementById('useBalanceNo');
    if (!radYes || !radNo) return;

    const payable      = document.getElementById('payableAmount');
    const deductRow    = document.getElementById('balanceDeductRow');
    const deductText   = document.getElementById('balanceDeductText');
    const labelYes     = document.getElementById('labelUseBalance');
    const labelNo      = document.getElementById('labelNoBalance');

    const total      = parseFloat(radYes.dataset.total);
    const balUsed    = parseFloat(radYes.dataset.balance);
    const remaining  = parseFloat(radYes.dataset.remaining);

    function fmt(n) {
        return n.toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ₺';
    }

    function update() {
        const useBalance = radYes.checked;

        labelYes.style.border = useBalance ? '2px solid #198754' : '2px solid transparent';
        labelYes.style.background = useBalance ? '#f0fff4' : '';
        labelNo.style.border  = !useBalance ? '2px solid #dee2e6' : '2px solid transparent';

        if (useBalance) {
            payable.textContent = fmt(remaining);
            if (deductRow) {
                deductRow.style.display = 'block';
                deductText.textContent  = fmt(balUsed) + ' bakiyenizden düşüldü';
            }
        } else {
            payable.textContent = fmt(total);
            if (deductRow) deductRow.style.display = 'none';
        }
    }

    radYes.addEventListener('change', update);
    radNo.addEventListener('change', update);
    update();
})();
</script>

<script>
// Kredi kartı simülasyon JS
(function() {
    const cardNumber  = document.getElementById('cardNumber');
    const cardName    = document.getElementById('cardName');
    const cardExp     = document.getElementById('cardExp');
    const cardCvv     = document.getElementById('cardCvv');
    const numberPrev  = document.getElementById('cardNumberPreview');
    const namePrev    = document.getElementById('cardNamePreview');
    const expPrev     = document.getElementById('cardExpPreview');
    const brandPrev   = document.getElementById('cardBrandPreview');
    const confirmBtn  = document.getElementById('confirmPaymentBtn');
    const processing  = document.getElementById('paymentProcessing');
    const formFields  = document.getElementById('paymentFormFields');
    const checkoutForm = document.getElementById('orderForm');

    if (!cardNumber) return;

    cardNumber.addEventListener('input', function() {
        let v = this.value.replace(/\D/g, '').substring(0, 16);
        this.value = v.replace(/(.{4})/g, '$1 ').trim();
        numberPrev.textContent = this.value || '**** **** **** ****';
        // Kart marka tespiti
        const first = v[0];
        if (first === '4') brandPrev.textContent = 'VISA';
        else if (first === '5') brandPrev.textContent = 'MASTERCARD';
        else if (first === '3') brandPrev.textContent = 'AMEX';
        else brandPrev.textContent = 'KART';
    });

    cardName.addEventListener('input', function() {
        namePrev.textContent = this.value.toUpperCase() || 'AD SOYAD';
    });

    cardExp.addEventListener('input', function() {
        let v = this.value.replace(/\D/g, '').substring(0, 4);
        if (v.length >= 3) v = v.substring(0,2) + '/' + v.substring(2);
        this.value = v;
        expPrev.textContent = this.value || 'AA/YY';
    });

    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            const num = cardNumber.value.replace(/\s/g, '');
            if (num.length < 16) { cardNumber.classList.add('is-invalid'); return; }
            if (!cardName.value.trim()) { cardName.classList.add('is-invalid'); return; }
            if (cardExp.value.length < 5) { cardExp.classList.add('is-invalid'); return; }
            if (cardCvv.value.length < 3) { cardCvv.classList.add('is-invalid'); return; }

            // Simüle ödeme işleme
            formFields.classList.add('d-none');
            processing.classList.remove('d-none');
            confirmBtn.disabled = true;

            setTimeout(function() {
                if (checkoutForm) checkoutForm.submit();
            }, 1800);
        });
    }

    // is-invalid temizle
    [cardNumber, cardName, cardExp, cardCvv].forEach(function(el) {
        if (el) el.addEventListener('input', function() { this.classList.remove('is-invalid'); });
    });
})();
</script>
@endpush
