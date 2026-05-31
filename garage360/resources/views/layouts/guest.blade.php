<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Garage360') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --g360-primary: #e63946; }
        body { background: #f5f5f5; font-family: 'Segoe UI', sans-serif; }
        .auth-card { max-width: 420px; margin: 80px auto; }
        .brand-icon { color: var(--g360-primary); }
        .btn-danger { background: var(--g360-primary); border-color: var(--g360-primary); }
        .btn-danger:hover { background: #c1121f; border-color: #c1121f; }
        .form-control:focus { border-color: var(--g360-primary); box-shadow: 0 0 0 .25rem rgba(230,57,70,.25); }
    </style>
</head>
<body>
<div class="auth-card px-3">
    <div class="text-center mb-4">
        <a href="{{ route('home') }}" class="text-decoration-none text-dark fw-bold fs-3">
            <i class="bi bi-gear-fill brand-icon"></i> Garage<span style="color:var(--g360-primary)">360</span>
        </a>
    </div>
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            {{ $slot }}
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
