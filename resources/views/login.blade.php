<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | Portal Registrasi</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            overflow: hidden;
            /* Prevent scroll on desktop */
        }

        /* --- SPLIT SCREEN LAYOUT --- */
        .login-wrapper {
            height: 100vh;
            display: flex;
            width: 100%;
        }

        /* Left Side: Visuals */
        .left-panel {
            /* IMPORTANT: REPLACE THE URL BELOW WITH YOUR OWN IMAGE PATH
               Example for Laravel: url('{{ asset('images/login-bg.jpg') }}')
            */
            background:
                /* Top Layer: Green Gradient Overlay (for text readability) */
                linear-gradient(rgba(25, 135, 84, 0.5),
                    /* Primary green, 80% opacity */
                    rgba(15, 81, 50, 0.7)
                    /* Darker green, 90% opacity */
                ),
                /* Bottom Layer: The Image */
                url("{{ asset('storage/images/background-gedung-29.jpg') }}") no-repeat center center;

            background-size: cover;
            /* Ensures image covers the whole area */
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 4rem;
            position: relative;
        }

        /* Decorative Circle */
        .left-panel::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
        }

        /* Right Side: Form */
        .right-panel {
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
        }

        /* --- FORM STYLING --- */
        .form-control {
            padding: 12px 15px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            background-color: #f8f9fa;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #198754;
            box-shadow: 0 0 0 4px rgba(25, 135, 84, 0.1);
        }

        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: #6c757d;
        }

        /* Fix border radius for inputs in groups */
        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .btn-success {
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            background: #198754;
            border: none;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(25, 135, 84, 0.2);
        }

        .btn-success:hover {
            background: #146c43;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(25, 135, 84, 0.3);
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .left-panel {
                display: none;
                /* Hide visual side on mobile */
            }

            body {
                overflow-y: auto;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid p-0">
        <div class="row g-0 login-wrapper">

            <div class="col-md-7 left-panel d-none d-md-flex">
                <div style="z-index: 2;">
                    <div class="mb-4">
                        <i class="bi bi-mortarboard-fill display-3"></i>
                    </div>
                    <h1 class="fw-bold display-5 mb-3">Selamat Datang</h1>
                    <p class="fs-5 opacity-75 mb-4">Student recruitment, activities and histories all in one place</p>
                </div>
            </div>

            <div class="col-md-5 right-panel">
                <div class="login-card fade-in">

                    <div class="text-center mb-4 d-md-none">
                        <i class="bi bi-mortarboard-fill text-success fs-1"></i>
                        <h3 class="fw-bold mt-2">Portal Siswa</h3>
                    </div>

                    <div class="mb-5">
                        <h2 class="fw-bold text-dark">Login Akun</h2>
                    </div>

                    <form id="loginForm" autocomplete="off" action="{{ route('tryLogin') }}" method="post" novalidate>
                        @csrf

                        <div class="mb-4">
                            <label for="username"
                                class="form-label fw-medium small text-muted text-uppercase">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input id="username" name="username" type="text" class="form-control"
                                    placeholder="Masukkan username" required value="{{ old('username') }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password"
                                class="form-label fw-medium small text-muted text-uppercase">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input id="password" name="password" type="password" class="form-control"
                                    placeholder="Masukkan password" required>
                                <button class="btn btn-outline-light border text-muted" type="button" id="togglePwd"
                                    style="border-color: #e0e0e0 !important; border-left: none !important; border-radius: 0 10px 10px 0; font-size: 1.2rem;">
                                    👁
                                </button>
                            </div>
                        </div>

                        @if ($errors->has('username'))
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>{{ $errors->first('username') }}</div>
                            </div>
                        @endif

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-success btn-lg">Masuk Sekarang</button>
                        </div>

                        <div class="text-center">
                            <small class="text-muted">Ada kendala login? <a href="#"
                                    class="text-success text-decoration-none fw-bold">Hubungi Admin</a></small>
                            <div class="mt-4 border-top pt-3">
                                <a href="{{ route('dummy') }}" class="text-muted small text-decoration-none me-3">Data
                                    Dummy</a>
                                <span class="text-muted small">© {{ date('Y') }} Kampus</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function () {
            const togglePwd = document.getElementById('togglePwd');
            const passwordField = document.getElementById('password');

            togglePwd.addEventListener('click', () => {
                // Toggle the type attribute
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);

                // Toggle the Emoji: Eye (👁) vs Monkey (🙈)
                togglePwd.textContent = type === 'password' ? '👁' : '🙈';
            });
        })();
    </script>

</body>

</html>