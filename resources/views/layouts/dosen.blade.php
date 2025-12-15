<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Portal Siswa</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #198754;
            --primary-dark: #0f5132;
            --sidebar-width: 280px;
            --bg-color: #f3f4f6;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: #333;
        }

        /* --- MODERN SIDEBAR --- */
        .sidebar {
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            min-height: 100vh;
            color: white;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1045;
            /* Higher than navbar */
            transition: all 0.3s ease;
        }

        /* Brand Logo Area */
        .sidebar-brand {
            font-size: 1.4rem;
            font-weight: 600;
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1rem;
            letter-spacing: 0.5px;
        }

        /* Navigation Links */
        .nav-link-custom {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin-bottom: 8px;
            border-radius: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .nav-link-custom i {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        /* Hover Effect */
        .nav-link-custom:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }

        /* Active State (Glassmorphism Pill) */
        .nav-link-custom.active {
            background-color: white;
            color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            font-weight: 600;
        }

        /* Section Headers */
        .nav-header {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: rgba(255, 255, 255, 0.5);
            margin: 20px 0 10px 15px;
            font-weight: 600;
        }

        /* Logout Button */
        .btn-logout {
            color: #ffcccc;
            transition: 0.3s;
        }

        .btn-logout:hover {
            color: #fff;
            background: rgba(220, 53, 69, 0.2);
            border-radius: 10px;
        }

        /* --- CONTENT AREA --- */
        .content {
            padding: 2rem;
            min-height: 100vh;
        }

        /* --- MOBILE TWEAKS --- */
        @media (max-width: 767.98px) {
            .sidebar {
                width: var(--sidebar-width);
                min-height: 100%;
            }

            .content {
                padding: 1rem;
                padding-top: 1.5rem;
            }

            /* Stylish Mobile Navbar */
            .mobile-nav {
                background: white;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
                padding: 10px 20px;
                border-radius: 0 0 15px 15px;
            }

            .mobile-brand {
                color: var(--primary-color);
                font-weight: 700;
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar mobile-nav d-md-none fixed-top">
        <div class="d-flex align-items-center w-100 justify-content-between">
            <span class="mobile-brand"><img src="{{ asset('storage/images/istts-1.png') }}" width="50" height="50"
                    alt=""> Oprec
                ISTTS</span>
            <button class="btn btn-light text-success border-0 shadow-sm" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <i class="bi bi-list fs-4"></i>
            </button>
        </div>
    </nav>

    <div class="d-md-none" style="height: 70px;"></div>

    <div class="container-fluid p-0">
        <div class="row g-0">

            <div class="col-md-2 sidebar offcanvas-md offcanvas-start" tabindex="-1" id="sidebarMenu"
                aria-labelledby="sidebarMenuLabel">

                <div class="d-md-none d-flex justify-content-end p-3">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        data-bs-target="#sidebarMenu" aria-label="Close"></button>
                </div>

                <div class="px-3">
                    <div class="sidebar-brand d-none d-md-flex align-items-center">
                        <img src="{{ asset('storage/images/istts-1.png') }}" width="50" height="50" alt=""> Oprec
                        ISTTS
                    </div>

                    <div class="mt-2">
                        <a href="{{ route('dosen.dashboard') }}"
                            class="nav-link-custom {{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-1x2-fill"></i> Dashboard
                        </a>

                        <div class="nav-header">Laporan & Monitoring</div>

                        <a href="{{ route('dosen.laporan-acara') }}"
                            class="nav-link-custom {{ request()->routeIs('dosen.laporan-acara*') ? 'active' : '' }}">
                            <i class="bi bi-calendar-event"></i> Laporan Acara
                        </a>
                        <a href="{{ route('dosen.laporan-mahasiswa') }}"
                            class="nav-link-custom {{ request()->routeIs('dosen.laporan-mahasiswa*') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i> Laporan Mahasiswa
                        </a>
                    </div>

                    <div class="mt-5 pt-3 border-top border-white-50">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link-custom btn-logout w-100 text-start ps-3">
                                <i class="bi bi-box-arrow-left"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-10 content">
                <div class="fade-in">
                    @yield('content')
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>