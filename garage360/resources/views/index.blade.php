@extends('layouts.app')
@section('title', 'Anasayfa')

@section('content')

{{-- ── SLIDER / HERO ── --}}
@if($sliders->count() > 0)
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-indicators">
        @foreach($sliders as $i => $slide)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $i }}"
                    class="{{ $i === 0 ? 'active' : '' }}"></button>
        @endforeach
    </div>
    <div class="carousel-inner">
        @foreach($sliders as $i => $slide)
        <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
            <div class="hero-slide" style="background:{{ $slide->bg_color }};
                @if($slide->image) background-image:url('{{ asset('storage/'.$slide->image) }}'); background-size:cover; background-position:center; @endif">
                @if($slide->title || $slide->subtitle || ($slide->button_text && $slide->button_url))
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            @if($slide->title)
                                <h1 class="mb-3">{!! nl2br(e($slide->title)) !!}</h1>
                            @endif
                            @if($slide->subtitle)
                                <p class="lead mb-4">{{ $slide->subtitle }}</p>
                            @endif
                            @if($slide->button_text && $slide->button_url)
                                <a href="{{ $slide->button_url }}" class="btn btn-danger btn-lg px-5 fw-semibold">
                                    {{ $slide->button_text }} <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @if($sliders->count() > 1)
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
    @endif
</div>

{{-- Stats Strip (slider varsa) --}}
<div class="hero-static stats-strip">
    <div class="container">
        <div class="row text-center g-3">
            <div class="col-4">
                <div class="stat-num">10K+</div>
                <div class="stat-lbl">Ürün</div>
            </div>
            <div class="col-4">
                <div class="stat-num">50K+</div>
                <div class="stat-lbl">Müşteri</div>
            </div>
            <div class="col-4">
                <div class="stat-num">24S</div>
                <div class="stat-lbl">Teslimat</div>
            </div>
        </div>
    </div>
</div>

@else
{{-- Statik Hero (slider yoksa) --}}
<section class="hero-static">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1>Arabanız İçin <span>Her Parça</span>,<br>Tek Adreste.</h1>
                <p class="lead mt-3" style="color:rgba(255,255,255,.75)">10.000+ orijinal ve muadil yedek parça. Hızlı teslimat, uygun fiyat, güvenli alışveriş.</p>
                <div class="d-flex gap-3 mt-4 flex-wrap">
                    <a href="{{ route('products.index') }}" class="btn btn-danger btn-lg px-5 fw-semibold">
                        <i class="bi bi-grid me-2"></i>Tüm Ürünler
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">
                            <i class="bi bi-person-plus me-2"></i>Ücretsiz Üye Ol
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <i class="bi bi-car-front" style="font-size:14rem;opacity:.08;color:#fff;"></i>
            </div>
        </div>
        <div class="row mt-5 pt-2 g-3 text-center" style="border-top:1px solid rgba(255,255,255,.1)">
            <div class="col-4">
                <div class="stat-num">10K+</div>
                <div class="stat-lbl">Ürün</div>
            </div>
            <div class="col-4">
                <div class="stat-num">50K+</div>
                <div class="stat-lbl">Müşteri</div>
            </div>
            <div class="col-4">
                <div class="stat-num">24S</div>
                <div class="stat-lbl">Teslimat</div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ── KATEGORİLER ── --}}
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Kategoriler</h2>
            <p class="section-subtitle">İhtiyacınız olan parçayı kategoriden bulun</p>
        </div>
        <div class="row g-3">
            @forelse($categories as $cat)
                <div class="col-6 col-md-3 col-lg-2">
                    <a href="{{ route('products.index', ['category' => $cat->id]) }}" class="category-pill">
                        <i class="bi bi-gear"></i>
                        <div class="fw-semibold small">{{ $cat->name }}</div>
                        <div class="text-muted" style="font-size:.75rem;">{{ $cat->products_count }} ürün</div>
                    </a>
                </div>
            @empty
                @foreach([['bi-droplet','Motor Yağları'],['bi-battery-charging','Akü'],['bi-disc','Fren Sistemi'],['bi-lightbulb','Aydınlatma'],['bi-fan','Soğutma'],['bi-wrench','Direksiyon']] as [$icon,$name])
                    <div class="col-6 col-md-3 col-lg-2">
                        <div class="category-pill">
                            <i class="bi {{ $icon }}"></i>
                            <div class="fw-semibold small">{{ $name }}</div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ── ÖNE ÇIKAN ÜRÜNLER ── --}}
<section class="py-5 bg-white">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="section-title mb-1">Öne Çıkan Ürünler</h2>
                <p class="section-subtitle mb-0">En çok tercih edilen parçalar</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-danger fw-semibold">
                Tümünü Gör <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="row g-3">
            @forelse($featuredProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card product-card h-100 shadow-sm">
                        @if($product->sale_price)
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2" style="z-index:1;">İNDİRİM</span>
                        @endif
                        <div class="product-img-wrap">
                            @if($product->image)
                                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                            @else
                                <i class="bi bi-gear no-img"></i>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column p-3">
                            <div class="text-muted small mb-1">{{ $product->brand }}</div>
                            <h6 class="card-title fw-semibold mb-1" style="font-size:.9rem;line-height:1.3;">{{ $product->name }}</h6>
                            <div class="mt-auto pt-2">
                                <x-product-price :product="$product" />
                                <a href="{{ route('products.show', $product) }}" class="btn btn-danger btn-sm w-100 mt-2 fw-semibold">
                                    <i class="bi bi-eye me-1"></i>İncele
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    <i class="bi bi-box-seam fs-1 d-block mb-3"></i>
                    Henüz öne çıkan ürün eklenmemiş.
                </div>
            @endforelse
        </div>
    </div>
</section>

{{-- ── NASIL ÇALIŞIR ── --}}
<section class="py-5" style="background:#f9fafb;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Nasıl Çalışır?</h2>
            <p class="section-subtitle">4 adımda sipariş verin</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-3">
                <div class="step-icon"><i class="bi bi-search"></i></div>
                <h6 class="fw-bold mt-2">1. Ara</h6>
                <p class="text-muted small">Araç marka/model veya OEM numarasıyla parçanı bul</p>
            </div>
            <div class="col-md-3">
                <div class="step-icon"><i class="bi bi-cart-plus"></i></div>
                <h6 class="fw-bold mt-2">2. Sepete Ekle</h6>
                <p class="text-muted small">İstediğin ürünleri sepetine ekle</p>
            </div>
            <div class="col-md-3">
                <div class="step-icon"><i class="bi bi-credit-card"></i></div>
                <h6 class="fw-bold mt-2">3. Öde</h6>
                <p class="text-muted small">Bakiyenle veya kapıda ödeme ile güvenle öde</p>
            </div>
            <div class="col-md-3">
                <div class="step-icon"><i class="bi bi-truck"></i></div>
                <h6 class="fw-bold mt-2">4. Teslim Al</h6>
                <p class="text-muted small">Siparişini 5 aşamada takip et, kapına gelsin</p>
            </div>
        </div>
    </div>
</section>

{{-- ── HAKKIMIZDA ── --}}
<section class="about-section py-5" id="hakkimizda">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-5">
                <div class="position-relative">
                    <div class="rounded-4 overflow-hidden" style="background:linear-gradient(135deg,#1f2937,#374151);height:360px;display:flex;align-items:center;justify-content:center;">
                        <i class="bi bi-car-front" style="font-size:10rem;opacity:.15;color:#fff;"></i>
                    </div>
                    <div class="position-absolute bottom-0 start-0 m-3 bg-white rounded-3 shadow p-3 d-flex align-items-center gap-3" style="min-width:180px;">
                        <div class="rounded-circle d-flex align-items-center justify-content-center bg-danger text-white" style="width:48px;height:48px;font-size:1.3rem;flex-shrink:0;">
                            <i class="bi bi-trophy-fill"></i>
                        </div>
                        <div>
                            <div class="fw-bold" style="font-size:1.1rem;">10+ Yıl</div>
                            <div class="text-muted small">Sektör Deneyimi</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <p class="text-danger fw-semibold mb-2 small text-uppercase letter-spacing-1">
                    <i class="bi bi-gear-fill me-1"></i>Hakkımızda
                </p>
                <h2 class="section-title mb-3">Türkiye'nin Güvenilir<br>Yedek Parça Adresi</h2>
                <p class="text-muted mb-4" style="line-height:1.8;">
                    Garage360 olarak 2015 yılından bu yana otomotiv sektöründe hizmet veriyoruz. Yurt içi ve yurt dışı tedarikçilerden sağladığımız 10.000'i aşkın orijinal ve muadil yedek parça ile araç sahiplerine ve tamirhanelere kesintisiz destek sunuyoruz.
                </p>
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="about-icon-box bg-danger bg-opacity-10">
                                <i class="bi bi-shield-check text-danger"></i>
                            </div>
                            <div>
                                <div class="fw-bold mb-1">Orijinal Ürünler</div>
                                <div class="text-muted small">Tüm ürünlerimiz garantili ve sertifikalıdır.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="about-icon-box bg-success bg-opacity-10">
                                <i class="bi bi-truck text-success"></i>
                            </div>
                            <div>
                                <div class="fw-bold mb-1">Hızlı Teslimat</div>
                                <div class="text-muted small">Siparişleriniz aynı gün kargoya verilir.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="about-icon-box bg-warning bg-opacity-10">
                                <i class="bi bi-headset text-warning"></i>
                            </div>
                            <div>
                                <div class="fw-bold mb-1">7/24 Destek</div>
                                <div class="text-muted small">Uzman ekibimiz her zaman yanınızda.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-start gap-3">
                            <div class="about-icon-box bg-info bg-opacity-10">
                                <i class="bi bi-arrow-return-left text-info"></i>
                            </div>
                            <div>
                                <div class="fw-bold mb-1">Kolay İade</div>
                                <div class="text-muted small">14 gün içinde ücretsiz iade garantisi.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-3">
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

{{-- ── REFERANS / GÜVEN ÇUBUĞU ── --}}
<section class="py-4 bg-white border-top border-bottom">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-6 col-md-3">
                <div class="fw-bold fs-4" style="color:var(--g360-primary)">10.000+</div>
                <div class="text-muted small">Yedek Parça Çeşidi</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="fw-bold fs-4" style="color:var(--g360-primary)">50.000+</div>
                <div class="text-muted small">Mutlu Müşteri</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="fw-bold fs-4" style="color:var(--g360-primary)">%98</div>
                <div class="text-muted small">Memnuniyet Oranı</div>
            </div>
            <div class="col-6 col-md-3">
                <div class="fw-bold fs-4" style="color:var(--g360-primary)">10+ Yıl</div>
                <div class="text-muted small">Sektör Deneyimi</div>
            </div>
        </div>
    </div>
</section>

@endsection
