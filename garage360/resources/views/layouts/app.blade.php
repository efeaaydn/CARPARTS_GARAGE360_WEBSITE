<!DOCTYPE html>
<html lang="tr" data-bs-theme="light">
<head>
<script>
    (function(){
        try {
            var t = localStorage.getItem('g360-theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', t);
        } catch(e){}
    })();
</script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Garage360') - Otomotiv Yedek Parça</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --g360-primary:  #e63946;
            --g360-primary2: #c1121f;
            --g360-dark:     #111827;
            --g360-dark2:    #1f2937;
        }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background: #f3f4f6; }

        /* ── TOP BAR ── */
        .topbar {
            background: var(--g360-dark);
            color: rgba(255,255,255,.65);
            font-size: .78rem;
            padding: 6px 0;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }
        .topbar a { color: rgba(255,255,255,.65); text-decoration: none; }
        .topbar a:hover { color: #fff; }
        .topbar .badge-free {
            background: var(--g360-primary);
            color: #fff;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 600;
        }

        /* ── MEGA MENU ── */
        .mega-dropdown { position: static !important; }
        .mega-menu {
            position: absolute !important;
            left: 0; right: 0;
            top: 100%;
            width: 100%;
            border: none !important;
            border-radius: 0 0 16px 16px !important;
            box-shadow: 0 16px 48px rgba(0,0,0,.18) !important;
            padding: 0 !important;
            margin-top: 3px !important;
            background: #fff;
            border-top: 3px solid var(--g360-primary) !important;
        }
        .mega-menu-inner { padding: 28px 32px; }
        .mega-cat-title {
            font-size: .8rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .08em;
            color: #111; padding-bottom: 8px;
            margin-bottom: 10px;
            border-bottom: 2px solid var(--g360-primary);
            display: flex; align-items: center; gap: 6px;
            text-decoration: none;
        }
        .mega-cat-title:hover { color: var(--g360-primary); }
        .mega-sub-link {
            display: flex; align-items: center; gap-6px;
            font-size: .855rem; color: #374151;
            padding: 5px 0; text-decoration: none;
            transition: color .15s, padding-left .15s;
            line-height: 1.4;
        }
        .mega-sub-link::before {
            content: '›'; color: var(--g360-primary);
            font-size: 1rem; margin-right: 5px;
        }
        .mega-sub-link:hover { color: var(--g360-primary); padding-left: 4px; }
        .mega-footer {
            background: #f9fafb; border-top: 1px solid #f0f0f0;
            padding: 12px 32px;
            border-radius: 0 0 16px 16px;
        }

        /* ── NAVBAR ── */
        .main-navbar {
            background: var(--g360-dark2) !important;
            box-shadow: 0 2px 20px rgba(0,0,0,.35);
            border-bottom: 3px solid var(--g360-primary);
            padding: 0;
            position: relative;
        }
        .navbar-brand-wrap {
            padding: 12px 0;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .brand-icon {
            width: 42px; height: 42px;
            background: var(--g360-primary);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: #fff;
            flex-shrink: 0;
        }
        .brand-text { line-height: 1.1; }
        .brand-text .name { font-size: 1.25rem; font-weight: 800; color: #fff; letter-spacing: -.5px; }
        .brand-text .name span { color: var(--g360-primary); }
        .brand-text .tagline { font-size: .65rem; color: rgba(255,255,255,.45); letter-spacing: .08em; text-transform: uppercase; }

        /* search */
        .navbar-search { flex: 1; max-width: 480px; }
        .navbar-search .form-control {
            background: rgba(255,255,255,.08);
            border: 1.5px solid rgba(255,255,255,.12);
            color: #fff;
            border-right: none;
            border-radius: 8px 0 0 8px;
            padding: 9px 14px;
            font-size: .9rem;
        }
        .navbar-search .form-control::placeholder { color: rgba(255,255,255,.35); }
        .navbar-search .form-control:focus {
            background: rgba(255,255,255,.12);
            border-color: var(--g360-primary);
            box-shadow: none;
            color: #fff;
        }
        .navbar-search .btn-search {
            background: var(--g360-primary);
            border: none;
            color: #fff;
            border-radius: 0 8px 8px 0;
            padding: 9px 18px;
        }
        .navbar-search .btn-search:hover { background: var(--g360-primary2); }

        /* nav links */
        .main-navbar .nav-link {
            color: rgba(255,255,255,.7) !important;
            font-size: .88rem;
            font-weight: 500;
            padding: 18px 12px !important;
            transition: color .2s;
            border-bottom: 3px solid transparent;
            margin-bottom: -3px;
        }
        .main-navbar .nav-link:hover,
        .main-navbar .nav-link.active {
            color: #fff !important;
            border-bottom-color: var(--g360-primary);
        }

        /* cart icon */
        .btn-cart { position: relative; }
        .cart-badge {
            position: absolute; top: 8px; right: 4px;
            background: var(--g360-primary); color: #fff;
            font-size: 9px; border-radius: 50%;
            width: 16px; height: 16px;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
        }

        /* user avatar */
        .user-avatar {
            width: 32px; height: 32px;
            background: var(--g360-primary);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: .8rem; font-weight: 700; color: #fff;
            flex-shrink: 0;
        }
        .main-navbar .dropdown-menu {
            border: none;
            box-shadow: 0 8px 30px rgba(0,0,0,.15);
            border-radius: 10px;
            min-width: 220px;
        }
        .main-navbar .dropdown-item { font-size: .88rem; padding: 8px 16px; }
        .main-navbar .dropdown-item:hover { background: #f8f9fa; }

        /* toggler */
        .main-navbar .navbar-toggler { border-color: rgba(255,255,255,.2); padding: 6px 10px; }
        .main-navbar .navbar-toggler-icon { filter: invert(1); }

        /* ── HERO / SLIDER ── */
        .hero-slide {
            min-height: 480px;
            display: flex; align-items: center;
            position: relative; overflow: hidden;
        }
        .hero-slide::after {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(90deg, rgba(0,0,0,.65) 0%, rgba(0,0,0,.1) 100%);
        }
        .hero-slide .container { position: relative; z-index: 2; }
        .hero-slide h1 { font-size: clamp(1.8rem, 4vw, 3rem); font-weight: 800; color: #fff; }
        .hero-slide h1 span { color: var(--g360-primary); }
        .hero-slide .lead { color: rgba(255,255,255,.8); }

        .carousel-indicators [data-bs-target] {
            width: 10px; height: 10px; border-radius: 50%;
            background-color: rgba(255,255,255,.6);
            border: none;
        }
        .carousel-indicators .active { background-color: var(--g360-primary); }

        /* static hero (no slides) */
        .hero-static {
            background: linear-gradient(135deg, var(--g360-dark) 0%, var(--g360-dark2) 100%);
            color: #fff; padding: 80px 0;
        }
        .hero-static h1 { font-size: clamp(1.8rem, 4vw, 2.8rem); font-weight: 800; }
        .hero-static h1 span { color: var(--g360-primary); }

        /* stats strip */
        .stats-strip {
            background: rgba(255,255,255,.07);
            border-top: 1px solid rgba(255,255,255,.1);
            padding: 14px 0;
        }
        .stats-strip .stat-num { font-size: 1.4rem; font-weight: 800; color: var(--g360-primary); }
        .stats-strip .stat-lbl { font-size: .72rem; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: .05em; }

        /* ── SECTIONS ── */
        .section-title { font-size: 1.6rem; font-weight: 800; color: #111; }
        .section-subtitle { color: #6b7280; font-size: .95rem; }

        .btn-primary, .btn-danger { background: var(--g360-primary); border-color: var(--g360-primary); }
        .btn-primary:hover, .btn-danger:hover { background: var(--g360-primary2); border-color: var(--g360-primary2); }
        .btn-outline-danger { color: var(--g360-primary); border-color: var(--g360-primary); }
        .btn-outline-danger:hover { background: var(--g360-primary); border-color: var(--g360-primary); }

        /* product cards */
        .product-card { transition: transform .2s, box-shadow .2s; border: none; border-radius: 12px; overflow: hidden; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 12px 30px rgba(0,0,0,.12); }
        .product-img-wrap {
            height: 190px; overflow: hidden; background: #f9f9f9;
            display: flex; align-items: center; justify-content: center;
        }
        .product-img-wrap img { max-height: 100%; object-fit: contain; }
        .product-img-wrap .no-img { font-size: 3.5rem; color: #d1d5db; }

        /* category pills */
        .category-pill {
            background: #fff; border: 2px solid #e5e7eb; border-radius: 14px;
            padding: 18px 12px; text-align: center; transition: all .2s;
            text-decoration: none; color: inherit; display: block; height: 100%;
        }
        .category-pill:hover { border-color: var(--g360-primary); transform: translateY(-3px); box-shadow: 0 6px 20px rgba(230,57,70,.15); }
        .category-pill i { font-size: 2rem; display: block; margin-bottom: 8px; color: var(--g360-primary); }

        /* steps */
        .step-icon {
            width: 64px; height: 64px; background: var(--g360-primary);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; color: #fff; font-size: 1.5rem; margin: 0 auto 14px;
            box-shadow: 0 4px 16px rgba(230,57,70,.35);
        }

        /* about */
        .about-section { background: #fff; }
        .about-icon-box {
            width: 56px; height: 56px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem; flex-shrink: 0;
        }

        /* footer */
        footer { background: var(--g360-dark); color: #9ca3af; }
        footer .footer-brand { font-size: 1.2rem; font-weight: 800; color: #fff; }
        footer .footer-brand span { color: var(--g360-primary); }
        footer a { color: #9ca3af; text-decoration: none; transition: color .2s; }
        footer a:hover { color: #fff; }
        footer hr { border-color: rgba(255,255,255,.08); }

        /* order status badges */
        .status-pending   { background: #fbbf24 !important; color: #000 !important; }
        .status-confirmed { background: #3b82f6 !important; color: #fff !important; }
        .status-preparing { background: #f97316 !important; color: #fff !important; }
        .status-shipped   { background: #8b5cf6 !important; color: #fff !important; }
        .status-out       { background: #0ea5e9 !important; color: #fff !important; }
        .status-delivered { background: #10b981 !important; color: #fff !important; }

        /* ── DARK MODE TOGGLE BUTTON ── */
        #darkToggle {
            width: 34px; height: 34px;
            border-radius: 8px;
            border: 1.5px solid rgba(255,255,255,.2);
            background: rgba(255,255,255,.08);
            color: rgba(255,255,255,.8);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; font-size: 1rem;
            transition: background .2s, border-color .2s, color .2s;
            flex-shrink: 0;
        }
        #darkToggle:hover { background: rgba(255,255,255,.18); color: #fff; border-color: rgba(255,255,255,.4); }

        /* ── DARK MODE OVERRIDES ── */
        [data-bs-theme="dark"] body                     { background: #0f1117 !important; }
        [data-bs-theme="dark"] .topbar                  { background: #0a0d14; }
        [data-bs-theme="dark"] .main-navbar             { background: #161b27 !important; }
        [data-bs-theme="dark"] .mega-menu               { background: #1e2330; border-top-color: var(--g360-primary) !important; }
        [data-bs-theme="dark"] .mega-cat-title          { color: #e2e8f0; }
        [data-bs-theme="dark"] .mega-sub-link           { color: #94a3b8; }
        [data-bs-theme="dark"] .mega-sub-link:hover     { color: var(--g360-primary); }
        [data-bs-theme="dark"] .mega-footer             { background: #161b27; border-top-color: #2d3748; }
        [data-bs-theme="dark"] .card                    { background: #1e2330; border-color: #2d3748; }
        [data-bs-theme="dark"] .card-header             { background: #252b3b !important; color: #e2e8f0; border-color: #2d3748; }
        [data-bs-theme="dark"] .table                   { --bs-table-bg: transparent; color: #cbd5e1; }
        [data-bs-theme="dark"] .table-light             { --bs-table-bg: #252b3b; color: #cbd5e1; }
        [data-bs-theme="dark"] .table-striped           { --bs-table-striped-bg: rgba(255,255,255,.04); }
        [data-bs-theme="dark"] .table-hover             > tbody > tr:hover > * { --bs-table-bg-state: rgba(255,255,255,.06); }
        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select             { background: #252b3b; border-color: #374151; color: #e2e8f0; }
        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus       { background: #2d3447; border-color: var(--g360-primary); color: #fff; box-shadow: none; }
        [data-bs-theme="dark"] .form-control::placeholder { color: #6b7280; }
        [data-bs-theme="dark"] .bg-white                { background: #1e2330 !important; }
        [data-bs-theme="dark"] .bg-light                { background: #252b3b !important; }
        [data-bs-theme="dark"] .bg-light.d-flex         { background: #252b3b !important; }
        [data-bs-theme="dark"] .text-dark               { color: #e2e8f0 !important; }
        [data-bs-theme="dark"] .text-muted              { color: #94a3b8 !important; }
        [data-bs-theme="dark"] .border                  { border-color: #2d3748 !important; }
        [data-bs-theme="dark"] .border-bottom           { border-color: #2d3748 !important; }
        [data-bs-theme="dark"] .border-top              { border-color: #2d3748 !important; }
        [data-bs-theme="dark"] hr                       { border-color: #2d3748; }
        [data-bs-theme="dark"] .dropdown-menu           { background: #1e2330; border-color: #2d3748; }
        [data-bs-theme="dark"] .dropdown-item           { color: #cbd5e1; }
        [data-bs-theme="dark"] .dropdown-item:hover     { background: #252b3b; color: #fff; }
        [data-bs-theme="dark"] .dropdown-divider        { border-color: #2d3748; }
        [data-bs-theme="dark"] .category-pill           { background: #1e2330; border-color: #2d3748; color: #cbd5e1; }
        [data-bs-theme="dark"] .category-pill:hover     { border-color: var(--g360-primary); }
        [data-bs-theme="dark"] .product-img-wrap        { background: #252b3b; }
        [data-bs-theme="dark"] .alert-success           { background: #052e16; border-color: #166534; color: #bbf7d0; }
        [data-bs-theme="dark"] .alert-secondary         { background: #1e2330; border-color: #374151; color: #94a3b8; }
        [data-bs-theme="dark"] .alert-danger            { background: #450a0a; border-color: #7f1d1d; color: #fecaca; }
        [data-bs-theme="dark"] .breadcrumb-item a       { color: var(--g360-primary); }
        [data-bs-theme="dark"] .breadcrumb-item.active  { color: #94a3b8; }
        [data-bs-theme="dark"] .list-group-item         { background: #1e2330; border-color: #2d3748; color: #cbd5e1; }
        [data-bs-theme="dark"] .input-group-text        { background: #252b3b; border-color: #374151; color: #94a3b8; }
        [data-bs-theme="dark"] .navbar-search .form-control { background: rgba(255,255,255,.06); }
        [data-bs-theme="dark"] .about-section           { background: #161b27 !important; }
    </style>
    @stack('styles')
</head>
<body>

{{-- TOP BAR --}}
<div class="topbar d-none d-md-block">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <span><i class="bi bi-telephone me-1"></i>0850 000 0000</span>
                <span><i class="bi bi-envelope me-1"></i>info@garage360.com</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge-free"><i class="bi bi-truck me-1"></i>500₺ üzeri ÜCRETSİZ KARGO</span>
                <span><i class="bi bi-clock me-1"></i>Hft içi 09:00–18:00</span>
            </div>
        </div>
    </div>
</div>

{{-- MAIN NAVBAR --}}
<nav class="main-navbar navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand-wrap" href="{{ route('home') }}">
            <div class="brand-icon"><i class="bi bi-gear-fill"></i></div>
            <div class="brand-text">
                <div class="name">Garage<span>360</span></div>
                <div class="tagline">Otomotiv Yedek Parça</div>
            </div>
        </a>

        <button class="navbar-toggler ms-auto me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMain">
            {{-- SEARCH --}}
            <form class="navbar-search d-flex mx-lg-4 my-2 my-lg-0" action="{{ route('products.index') }}" method="GET">
                <input type="text" name="search" class="form-control"
                       placeholder="Parça ara... (marka, OEM no, isim)"
                       value="{{ request('search') }}">
                <button class="btn-search" type="submit"><i class="bi bi-search"></i></button>
            </form>

            <ul class="navbar-nav ms-auto align-items-center gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house me-1"></i>Anasayfa
                    </a>
                </li>

                {{-- ÜRÜNLER MEGA MENÜ --}}
                <li class="nav-item dropdown mega-dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('products.*') ? 'active' : '' }}"
                       href="{{ route('products.index') }}"
                       data-bs-toggle="dropdown" data-bs-auto-close="true"
                       aria-expanded="false">
                        <i class="bi bi-grid me-1"></i>Ürünler
                    </a>
                    <div class="dropdown-menu mega-menu">
                        <div class="mega-menu-inner">
                            <div class="row g-4">
                                @foreach($navCategories ?? [] as $navCat)
                                <div class="col-6 col-md-3">
                                    <a href="{{ route('products.index', ['category' => $navCat->id]) }}"
                                       class="mega-cat-title">
                                        <i class="bi bi-folder2-open text-danger"></i>
                                        {{ $navCat->name }}
                                    </a>
                                    @foreach($navCat->children as $child)
                                        <a href="{{ route('products.index', ['category' => $child->id]) }}"
                                           class="mega-sub-link d-block">
                                            {{ $child->name }}
                                        </a>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="mega-footer d-flex align-items-center justify-content-between">
                            <span class="text-muted small"><i class="bi bi-box-seam me-1"></i>10.000+ ürün stokta</span>
                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-danger px-3 fw-semibold">
                                Tüm Ürünleri Gör <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="bi bi-info-circle me-1"></i>Hakkımızda
                    </a>
                </li>

                {{-- DARK MODE TOGGLE --}}
                <li class="nav-item d-flex align-items-center">
                    <button id="darkToggle" title="Karanlık / Aydınlık Mod" aria-label="Tema değiştir">
                        <i class="bi bi-moon-stars-fill" id="darkIcon"></i>
                    </button>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link btn-cart" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 fs-5"></i>
                            @if(($cartCount ?? 0) > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" data-bs-toggle="dropdown">
                            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                            <span class="d-none d-lg-inline" style="font-size:.88rem;">{{ Str::limit(auth()->user()->name, 12) }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="px-3 py-2">
                                <div class="fw-semibold" style="font-size:.9rem;">{{ auth()->user()->name }}</div>
                                <div class="text-muted small">{{ auth()->user()->email }}</div>
                            </li>
                            <li>
                                <div class="mx-3 my-1 rounded-2 p-2 bg-light d-flex align-items-center gap-2">
                                    <i class="bi bi-wallet2 text-success"></i>
                                    <span class="small">Bakiye: <strong class="text-success">₺{{ number_format(auth()->user()->balance_amount, 2) }}</strong></span>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-box-seam me-2 text-muted"></i>Siparişlerim</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2 text-muted"></i>Profil Ayarları</a></li>
                            @if(auth()->user()->hasRole('admin'))
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item fw-semibold" href="{{ route('admin.dashboard') }}" style="color:var(--g360-primary)">
                                        <i class="bi bi-shield-check me-2"></i>Admin Panel
                                    </a>
                                </li>
                            @endif
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="bi bi-box-arrow-right me-2"></i>Çıkış Yap
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Giriş
                        </a>
                    </li>
                    <li class="nav-item ms-1">
                        <a class="btn btn-danger btn-sm px-3 fw-semibold" href="{{ route('register') }}">
                            <i class="bi bi-person-plus me-1"></i>Kayıt Ol
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mx-3 mt-2 mb-0 rounded-3 border-0 shadow-sm">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mx-3 mt-2 mb-0 rounded-3 border-0 shadow-sm">
        <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@yield('content')

{{-- FOOTER --}}
<footer class="py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-brand mb-2"><i class="bi bi-gear-fill me-1" style="color:var(--g360-primary)"></i>Garage<span>360</span></div>
                <p class="small mb-3">Türkiye'nin güvenilir otomotiv yedek parça tedarikçisi. 10.000+ orijinal ve muadil ürün, hızlı teslimat, uygun fiyat.</p>
                <div class="d-flex gap-2">
                    <a href="#" class="rounded-2 bg-white bg-opacity-10 d-flex align-items-center justify-content-center" style="width:36px;height:36px;"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="rounded-2 bg-white bg-opacity-10 d-flex align-items-center justify-content-center" style="width:36px;height:36px;"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="rounded-2 bg-white bg-opacity-10 d-flex align-items-center justify-content-center" style="width:36px;height:36px;"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-6">
                <h6 class="text-white fw-semibold mb-3">Hızlı Linkler</h6>
                <ul class="list-unstyled small">
                    <li class="mb-1"><a href="{{ route('home') }}">Anasayfa</a></li>
                    <li class="mb-1"><a href="{{ route('products.index') }}">Tüm Ürünler</a></li>
                    <li class="mb-1"><a href="{{ route('about') }}">Hakkımızda</a></li>
                    <li class="mb-1"><a href="{{ route('login') }}">Giriş Yap</a></li>
                    <li class="mb-1"><a href="{{ route('register') }}">Kayıt Ol</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-6">
                <h6 class="text-white fw-semibold mb-3">İletişim</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><i class="bi bi-telephone me-2" style="color:var(--g360-primary)"></i>0850 000 0000</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2" style="color:var(--g360-primary)"></i>info@garage360.com</li>
                    <li class="mb-2"><i class="bi bi-geo-alt me-2" style="color:var(--g360-primary)"></i>İstanbul, Türkiye</li>
                    <li><i class="bi bi-clock me-2" style="color:var(--g360-primary)"></i>Hft içi 09:00–18:00</li>
                </ul>
            </div>
            <div class="col-lg-3">
                <h6 class="text-white fw-semibold mb-3">Güvencelerimiz</h6>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex align-items-center gap-2 small">
                        <div class="rounded-2 bg-white bg-opacity-10 p-1 px-2"><i class="bi bi-shield-check text-success"></i></div>
                        <span>SSL ile güvenli ödeme</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 small">
                        <div class="rounded-2 bg-white bg-opacity-10 p-1 px-2"><i class="bi bi-truck" style="color:var(--g360-primary)"></i></div>
                        <span>Hızlı ve ücretsiz kargo</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 small">
                        <div class="rounded-2 bg-white bg-opacity-10 p-1 px-2"><i class="bi bi-arrow-return-left text-info"></i></div>
                        <span>14 gün kolay iade</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 small">
                        <div class="rounded-2 bg-white bg-opacity-10 p-1 px-2"><i class="bi bi-headset text-warning"></i></div>
                        <span>7/24 müşteri desteği</span>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mt-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small">
            <p class="mb-0">© {{ date('Y') }} Garage360. Tüm hakları saklıdır.</p>
            <div class="d-flex gap-3">
                <a href="#">Gizlilik Politikası</a>
                <a href="#">Kullanım Koşulları</a>
                <a href="#">KVKK</a>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
<script>
(function () {
    const html = document.documentElement;
    const btn  = document.getElementById('darkToggle');
    const icon = document.getElementById('darkIcon');
    if (!btn) return;

    function apply(theme) {
        html.setAttribute('data-bs-theme', theme);
        icon.className = theme === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
        try { localStorage.setItem('g360-theme', theme); } catch(e){}
    }

    // İlk yüklemede icon'u ayarla
    apply(html.getAttribute('data-bs-theme') || 'light');

    btn.addEventListener('click', function () {
        apply(html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark');
    });
})();
</script>
</body>
</html>
