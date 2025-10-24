<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Portal Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .sidebar { min-height: 100vh; background-color: #198754; color: white; }
        .sidebar a { color: white; text-decoration: none; display: block; padding: 10px 15px; border-radius: 8px; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.2); }
        .content { padding: 30px; }
        .navbar { background-color: white; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold " style="color:#198754;">Portal Siswa</span>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-3">
            <h5 class="fw-bold mb-3">Admin Panel</h5>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
            <a href="{{ route('admin.acara-list') }}" class="{{ request()->is('admin/acara') ? 'active' : '' }}">📅 Daftar Acara</a>
            <a href="{{ route('admin.proposal-list') }}" class="{{ request()->is('admin/proposal') ? 'active' : '' }}">📄 Proposal Acara</a>
            <a href="{{ route('admin.laporan') }}" class="{{ request()->is('admin/laporan') ? 'active' : '' }}">📊 Laporan</a>
            <a href="{{ route('login') }}">🚪 Logout</a>
        </div>
        <div class="col-md-10 content">
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>















{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background-color: #198754;
            color: white;
            padding-top: 1rem;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 8px;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255,255,255,0.2);
        }
        .content {
            padding: 2rem;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 sidebar">
           
        </nav>

        <!-- Content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 content">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html> --}}
