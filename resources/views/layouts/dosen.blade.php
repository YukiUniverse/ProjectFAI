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
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar p-3">
            <h5 class="fw-bold mb-4 text-white">🎓 Dosen Panel</h5>
            
            <a href="{{ route('dosen.dashboard') }}" class="{{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
            
            <hr class="text-white-50">
            <small class="text-uppercase text-white-50 ms-2 fw-bold" style="font-size: 0.75rem;">Laporan & Monitoring</small>
            
            <a href="{{ route('dosen.laporan-acara') }}" class="{{ request()->routeIs('dosen.laporan-acara*') ? 'active' : '' }}">📅 Laporan Acara</a>
            <a href="{{ route('dosen.laporan-mahasiswa') }}" class="{{ request()->routeIs('dosen.laporan-mahasiswa*') ? 'active' : '' }}">🎓 Laporan Mahasiswa</a>
            <a href="{{ route('dosen.laporan-kpi') }}" class="{{ request()->routeIs('dosen.laporan-kpi') ? 'active' : '' }}">📊 Laporan KPI</a>
            
            <hr class="text-white-50">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link w-100 text-start text-white text-decoration-none ps-3">🚪 Logout</button>
            </form>
        </div>
        <div class="col-md-10 content">
            @yield('content')
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>







