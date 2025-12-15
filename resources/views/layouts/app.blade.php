<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Siswa</title>
    <!-- Ensure Bootstrap 5 CSS is loaded -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css">
    <style>
        /* Custom Sidebar Styling */
        .sidebar-link {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: all 0.3s;
            font-weight: 500;
        }

        .sidebar-link:hover {
            background-color: #e9ecef;
            color: #198754;
            transform: translateX(5px);
            /* Subtle animation */
        }

        .sidebar-link.active {
            background-color: #e8f5e9;
            /* Light green background */
            color: #198754;
            font-weight: bold;
            border-left: 4px solid #198754;
        }

        /* Profile Picture Hover */
        .profile-pic {
            border: 2px solid #198754;
            border-radius: 50%;
            transition: transform 0.2s;
        }

        .profile-pic:hover {
            transform: scale(1.1);
        }

        /* Container to allow scrolling on small screens */
        .timeline-container {
            overflow-x: auto;
            padding-bottom: 10px;
        }

        .stepper-wrapper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            min-width: 500px;
            /* Ensures it doesn't squish on mobile */
        }

        .stepper-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }

        .stepper-item::before {
            position: absolute;
            content: "";
            border-bottom: 2px solid #ccc;
            /* Default gray line */
            width: 100%;
            top: 15px;
            left: -50%;
            z-index: 2;
        }

        .stepper-item::after {
            position: absolute;
            content: "";
            border-bottom: 2px solid #ccc;
            width: 100%;
            top: 15px;
            left: 50%;
            z-index: 2;
        }

        .stepper-item .step-counter {
            position: relative;
            z-index: 5;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #ccc;
            margin-bottom: 6px;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }

        .stepper-item.active .step-counter {
            background-color: #0d6efd;
            /* Bootstrap Primary Blue */
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.2);
            /* Pulsing effect */
        }

        .stepper-item.completed .step-counter {
            background-color: #198754;
            /* Bootstrap Success Green */
        }

        .stepper-item.completed::after,
        .stepper-item.completed::before {
            border-bottom: 2px solid #198754;
            /* Green line for finished steps */
        }

        /* Remove line before first item and after last item */
        .stepper-item:first-child::before {
            content: none;
        }

        .stepper-item:last-child::after {
            content: none;
        }

        .step-name {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-align: center;
        }

        .stepper-item.active .step-name {
            color: #0d6efd;
        }

        .stepper-item.completed .step-name {
            color: #198754;
        }
    </style>
</head>

<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid">
            <!-- 1. Hamburger Button (Visible only on Mobile) -->
            <button class="navbar-toggler me-2 border-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Brand -->
            <a class="navbar-brand fw-bold me-auto" href="#" style="color:#198754;">
                <img src="{{ asset('storage/images/istts-1.png') }}" width="50" height="50" alt=""> Oprec
                ISTTS
            </a>

            <div class="d-flex align-items-center">

                <!-- A. Mail Icon -->
                {{-- Make sure the route matches what you defined in web.php --}}
                <a href="{{ route('siswa.invites.index') }}" class="me-3 text-secondary position-relative">
                    <i class="bi bi-envelope fs-4"></i>
                    {{-- Optional: Add a red dot if you want to show 'unread' status later --}}
                    <span
                        class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                </a>

                <!-- B. Profile Picture -->
                <div class="profile-pic-container">
                    <a href="{{ route('siswa.profile') }}">
                        <img src="https://i.pravatar.cc/150?img=51" width="40" height="40" alt="Profile"
                            class="profile-pic">
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR (Offcanvas on Mobile, Static Col on Desktop) -->
            <!-- 'offcanvas-lg' means it is offcanvas below Large screens, and normal div on Large screens -->
            <div class="col-lg-3 col-xl-2 sidebar offcanvas-lg offcanvas-start bg-white border-end vh-100-lg"
                tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">

                <!-- Header for Mobile Menu (Close Button) -->
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title fw-bold text-success" id="sidebarMenuLabel">Menu Portal</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        data-bs-target="#sidebarMenu" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body d-flex flex-column p-3 h-100">
                    <p class="text-uppercase text-muted small fw-bold mb-2">Utama</p>

                    <a class="sidebar-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"
                        href="{{ route('siswa.dashboard') }}">
                        📊 Dashboard
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('siswa.daftar-acara') ? 'active' : '' }}"
                        href="{{ route('siswa.daftar-acara') }}">
                        🔍 Cari Kepanitiaan
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('siswa.panitia-dashboard') ? 'active' : '' }}"
                        href="{{ route('siswa.panitia-dashboard') }}">
                        🗓️ Acara Saya
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('siswa.panitia-dashboard-interview') ? 'active' : '' }}"
                        href="{{ route('siswa.panitia-dashboard-interview') }}">
                        📝 Interview
                    </a>

                    <p class="text-uppercase text-muted small fw-bold mb-2 mt-3">Administrasi</p>

                    <a class="sidebar-link {{ request()->routeIs('siswa.status-pendaftaran') ? 'active' : '' }}"
                        href="{{ route('siswa.status-pendaftaran') }}">
                        📜 History Daftar
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('siswa.proposal-ajukan') ? 'active' : '' }}"
                        href="{{ route('siswa.proposal-ajukan') }}">
                        📤 Ajukan Proposal
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('siswa.status-proposal') ? 'active' : '' }}"
                        href="{{ route('siswa.status-proposal') }}">
                        🚥 Status Proposal
                    </a>
                    <a class="sidebar-link {{ request()->routeIs('siswa.riwayat-acara') ? 'active' : '' }}"
                        href="{{ route('siswa.riwayat-acara') }}">
                        🏅 History Selesai
                    </a>

                    <!-- Spacer to push logout to bottom on mobile -->
                    <div class="mt-auto pt-4">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-lg-9 col-xl-10 p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS (Required for the Mobile Sidebar Toggle) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $.fn.dataTable.ext.errMode = 'none';
            document.querySelectorAll('.data_table').forEach(function (table) {
                new DataTable(table);
            });
        });
    </script>
</body>

</html>