<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Garage360</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root { --g360-primary: #e63946; --g360-dark: #1d1d1d; }
        body { background: #f4f5f7; }
        .sidebar { width: 240px; min-height: 100vh; background: var(--g360-dark); position: fixed; top: 0; left: 0; z-index: 100; }
        .sidebar-brand { padding: 1rem 1.25rem; border-bottom: 1px solid rgba(255,255,255,.1); }
        .sidebar-brand a { color: #fff; font-weight: 700; font-size: 1.1rem; text-decoration: none; }
        .sidebar-brand span { color: var(--g360-primary); }
        .nav-sidebar .nav-link { color: rgba(255,255,255,.7); padding: .6rem 1.25rem; border-radius: 6px; margin: 2px 8px; font-size: .88rem; }
        .nav-sidebar .nav-link:hover, .nav-sidebar .nav-link.active { background: rgba(230,57,70,.15); color: #fff; }
        .nav-sidebar .nav-link i { width: 20px; }
        .nav-sidebar .nav-section { padding: .5rem 1.25rem .25rem; font-size: .7rem; text-transform: uppercase; letter-spacing: .08em; color: rgba(255,255,255,.35); }
        .main-content { margin-left: 240px; }
        .top-bar { background: #fff; border-bottom: 1px solid #e9ecef; padding: .75rem 1.5rem; }
        .page-content { padding: 1.5rem; }
        .stat-card { border: none; border-radius: 12px; }
        .stat-card .icon-box { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
    </style>
</head>
<body>
<div class="sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}">GARAGE<span>360</span> <small class="opacity-50">Admin</small></a>
    </div>
    <nav class="nav-sidebar mt-2">
        <div class="nav-section">Genel</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <div class="nav-section mt-2">Katalog</div>
        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Ürünler
        </a>
        <a href="{{ route('admin.sliders.index') }}" class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
            <i class="bi bi-images"></i> Slider
        </a>
        <div class="nav-section mt-2">Satış</div>
        <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> Siparişler
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Kullanıcılar
        </a>
        <div class="nav-section mt-2">Hesap</div>
        <a href="{{ route('home') }}" class="nav-link"><i class="bi bi-house"></i> Siteye Git</a>
        <form action="{{ route('logout') }}" method="POST" class="mx-2 mt-1">
            @csrf
            <button class="nav-link btn btn-link p-0 w-100 text-start" style="color:rgba(255,255,255,.7)">
                <i class="bi bi-box-arrow-left"></i> Çıkış
            </button>
        </form>
    </nav>
</div>

<div class="main-content">
    <div class="top-bar d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h6>
        <div class="d-flex align-items-center gap-2">
            <span class="text-muted small">{{ auth()->user()->name }}</span>
            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:.8rem">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </div>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
