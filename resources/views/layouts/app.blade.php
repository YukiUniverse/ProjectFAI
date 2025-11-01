<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Portal Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #198754;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 8px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .content {
            padding: 30px;
        }

        .navbar {
            background-color: white;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid" style="display:flex; justify-content: space-between;">
            <span class="navbar-brand fw-bold " style="color:#198754;">Portal Siswa</span>
            <div class="profile-pic-container larger">
                <a href="{{ route('siswa.profile') }}">
                    <img src="https://avatar.iran.liara.run/public" width="50" height="50" alt="Foto Profil Lain"
                        class="profile-pic">
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar p-3">
                <h5 class="fw-bold mb-3">Menu</h5>
                <a href="{{ route('siswa.dashboard') }}">🏠 Dashboard</a>
                <a href="{{ route('siswa.daftar-acara') }}">📅 Daftar Acara</a>
                <a href="{{ route('siswa.status-pendaftaran') }}">📋 Status Pendaftaran</a>
                <a href="{{ route('siswa.status-proposal') }}">📋 Status Proposal</a>
                <a href="{{ route('siswa.proposal-ajukan') }}">📝 Ajukan Proposal</a>
                <a href="{{ route('siswa.panitia-dashboard') }}">👥 Panitia</a>
                <a href="{{ route('siswa.riwayat-acara') }}">🕒 Riwayat</a>
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