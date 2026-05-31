@extends('layouts.app')
@section('title', 'Hakkımızda')

@section('content')

{{-- Hero --}}
<div style="background:linear-gradient(135deg,#111827 0%,#1f2937 100%);padding:70px 0;">
    <div class="container text-center text-white">
        <p class="text-danger fw-semibold small text-uppercase mb-2" style="letter-spacing:.12em;">
            <i class="bi bi-gear-fill me-1"></i>Biz Kimiz?
        </p>
        <h1 class="fw-800 mb-3" style="font-size:clamp(2rem,5vw,3rem);font-weight:800;">
            Türkiye'nin Güvenilir<br><span style="color:#e63946;">Yedek Parça Adresi</span>
        </h1>
        <p class="text-white-50 mb-0" style="max-width:560px;margin:0 auto;font-size:1.05rem;line-height:1.8;">
            2015'ten bu yana 50.000'den fazla araç sahibine ve tamirhanelere kesintisiz hizmet veriyoruz.
        </p>
    </div>
</div>

{{-- İstatistikler --}}
<div class="bg-white border-bottom py-4">
    <div class="container">
        <div class="row text-center g-3">
            @foreach([
                ['10K+',  'Ürün Çeşidi',     'bi-box-seam'],
                ['50K+',  'Mutlu Müşteri',    'bi-people-fill'],
                ['10+',   'Yıllık Deneyim',   'bi-award-fill'],
                ['%98',   'Memnuniyet Oranı', 'bi-hand-thumbs-up-fill'],
            ] as [$num,$lbl,$icon])
            <div class="col-6 col-md-3">
                <div class="d-flex flex-column align-items-center">
                    <i class="bi {{ $icon }} mb-2" style="font-size:1.8rem;color:#e63946;"></i>
                    <div class="fw-800 fs-3" style="font-weight:800;color:#111;">{{ $num }}</div>
                    <div class="text-muted small">{{ $lbl }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Hikayemiz --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="rounded-4 overflow-hidden position-relative"
                     style="background:linear-gradient(135deg,#1f2937,#374151);height:400px;
                            display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-car-front" style="font-size:12rem;opacity:.1;color:#fff;"></i>
                    <div class="position-absolute bottom-0 start-0 m-4 bg-white rounded-3 shadow p-3 d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center"
                             style="width:52px;height:52px;font-size:1.4rem;flex-shrink:0;">
                            <i class="bi bi-trophy-fill"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-5">2015'ten Beri</div>
                            <div class="text-muted small">Sektörde Güvenilir Hizmet</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <p class="text-danger fw-semibold small text-uppercase mb-2" style="letter-spacing:.1em;">
                    <i class="bi bi-clock-history me-1"></i>Hikayemiz
                </p>
                <h2 class="fw-bold mb-4" style="font-size:2rem;">
                    Küçük Bir Garajdan<br>Ulusal Platforma
                </h2>
                <p class="text-muted mb-3" style="line-height:1.9;">
                    Garage360, 2015 yılında İstanbul'da küçük bir ekip ile kuruldu. Amacımız tek bir hedefle şekillendi:
                    araç sahiplerine ve tamirhanelere <strong>güvenilir, hızlı ve uygun fiyatlı</strong> yedek parça erişimi sağlamak.
                </p>
                <p class="text-muted mb-4" style="line-height:1.9;">
                    Bugün yurt içi ve yurt dışındaki 200'ü aşkın tedarikçiyle çalışıyor; BMW'den Fiat'a, Bosch'tan Valeo'ya
                    10.000'i aşkın orijinal ve muadil ürünü müşterilerimize sunuyoruz. Her siparişte kalite, hız ve güveni
                    bir arada yaşatmak önceliğimizdir.
                </p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn btn-danger px-4 fw-semibold">
                        <i class="bi bi-grid me-1"></i>Ürünleri İncele
                    </a>
                    @guest
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-person-plus me-1"></i>Üye Ol
                    </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Değerlerimiz --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-danger fw-semibold small text-uppercase mb-2" style="letter-spacing:.1em;">Neden Biz?</p>
            <h2 class="fw-bold">Bizi Farklı Kılan Değerler</h2>
        </div>
        <div class="row g-4">
            @foreach([
                ['bi-shield-check',      'bg-danger bg-opacity-10',  'text-danger',   'Orijinal & Garantili', 'Tüm ürünlerimiz yetkili tedarikçilerden temin edilir. Her parça orijinallik ve kalite garantisi taşır.'],
                ['bi-truck',             'bg-success bg-opacity-10', 'text-success',  'Hızlı Teslimat',       'Siparişleriniz aynı gün kargoya verilir. 500 ₺ üzeri alışverişlerde kargo tamamen ücretsizdir.'],
                ['bi-headset',           'bg-warning bg-opacity-10', 'text-warning',  '7/24 Destek',          'Teknik ekibimiz 7 gün 24 saat hizmetinizdedir. Doğru parçayı bulmak için yanınızdayız.'],
                ['bi-arrow-return-left', 'bg-info bg-opacity-10',    'text-info',     'Kolay İade',           '14 gün içinde ücretsiz iade garantisi. Yanlış ürün geldiyse sorunsuzca değiştiriyoruz.'],
                ['bi-currency-exchange', 'bg-primary bg-opacity-10', 'text-primary',  'Uygun Fiyat',          'Doğrudan tedarikçi ilişkilerimiz sayesinde piyasanın en rekabetçi fiyatlarını sunuyoruz.'],
                ['bi-award',             'bg-danger bg-opacity-10',  'text-danger',   '10 Yıllık Deneyim',    'Otomotiv sektöründe 10 yılı aşkın deneyimimizle doğru parçayı, doğru fiyata getiriyoruz.'],
            ] as [$icon,$bg,$fg,$title,$desc])
            <div class="col-md-4">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded-3 {{ $bg }} d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:52px;height:52px;font-size:1.4rem;">
                        <i class="bi {{ $icon }} {{ $fg }}"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">{{ $title }}</h6>
                        <p class="text-muted small mb-0" style="line-height:1.7;">{{ $desc }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Ekip (opsiyonel yer tutucu) --}}
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <p class="text-danger fw-semibold small text-uppercase mb-2" style="letter-spacing:.1em;">Ekibimiz</p>
            <h2 class="fw-bold">Arkamızdaki İnsanlar</h2>
            <p class="text-muted">Deneyimli ve tutkulu ekibimizle size en iyi hizmeti sunmak için çalışıyoruz.</p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach([
                ['Murat Aydın',    'Kurucu & CEO',          'MA'],
                ['Selin Kara',     'Operasyon Direktörü',   'SK'],
                ['Emre Yılmaz',    'Teknik Danışman',       'EY'],
                ['Deniz Çelik',    'Müşteri İlişkileri',    'DÇ'],
            ] as [$name,$role,$initials])
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm text-center p-4">
                    <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width:72px;height:72px;font-size:1.4rem;font-weight:700;">
                        {{ $initials }}
                    </div>
                    <h6 class="fw-bold mb-1">{{ $name }}</h6>
                    <div class="text-muted small">{{ $role }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- İletişim CTA --}}
<section class="py-5" style="background:linear-gradient(135deg,#e63946,#c1121f);">
    <div class="container text-center text-white">
        <h2 class="fw-bold mb-2">Bir Sorunuz mu Var?</h2>
        <p class="mb-4 opacity-75">Uzman ekibimiz size yardımcı olmaktan memnuniyet duyar.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="tel:08500000000" class="btn btn-light text-danger fw-semibold px-4">
                <i class="bi bi-telephone-fill me-2"></i>0850 000 0000
            </a>
            <a href="mailto:info@garage360.com" class="btn btn-outline-light px-4">
                <i class="bi bi-envelope me-2"></i>info@garage360.com
            </a>
        </div>
    </div>
</section>

@endsection
