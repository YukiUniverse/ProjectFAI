<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | Portal</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(180deg, #eef8f1 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: "Segoe UI", Roboto, system-ui, -apple-system, "Helvetica Neue", Arial;
        }
        .card-login {
            width: 100%;
            max-width: 480px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        }
        .brand {
            font-weight: 700;
            color: #198754;
        }
        .form-note { font-size: .9rem; color: #6b7280; }
        .star { color: #ffc107; }
    </style>
</head>
<body>

<div class="card card-login shadow-sm">
    <div class="card-body p-4">
        <div class="text-center mb-3">
            <div class="mb-2">
                <span class="brand fs-4">Portal Registrasi Panitia</span>
            </div>
            <div class="form-note">Silakan login sebagai <strong>siswa</strong>, <strong>admin</strong>, atau <strong>dosen</strong>.</div>
        </div>

        <form id="loginForm" autocomplete="off" novalidate>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input id="username" name="username" type="text" class="form-control" placeholder="masukkan username" required>
            </div>

            <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input id="password" name="password" type="password" class="form-control" placeholder="masukkan password" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePwd" title="Tampilkan / Sembunyikan">
                        👁
                    </button>
                </div>
            </div>

            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div>
                    <input id="remember" type="checkbox" class="form-check-input me-1">
                    <label for="remember" class="form-check-label small">Ingat saya</label>
                </div>
                <div>
                    <button type="button" class="btn btn-sm btn-link p-0" id="demoCred">Lihat contoh kredensial</button>
                </div>
            </div>

            <div id="alertBox" class="alert alert-danger d-none" role="alert"></div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-success">Masuk</button>
            </div>

            <div class="text-center">
                <small class="text-muted">Tidak punya akun? Hubungi admin kampus.</small>
            </div>
        </form>
    </div>

    <div class="card-footer bg-transparent border-top px-4 py-3">
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">Demo kredensial: <span class="star">★</span> siswa/siswa — admin/admin — dosen/dosen</small>
            <small class="text-muted">© Kampus</small>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function () {
    const validCredentials = {
        siswa: 'siswa',
        admin: 'admin',
        dosen: 'dosen'
    };

    const loginForm = document.getElementById('loginForm');
    const alertBox = document.getElementById('alertBox');
    const togglePwd = document.getElementById('togglePwd');
    const passwordField = document.getElementById('password');
    const demoBtn = document.getElementById('demoCred');

    // Toggle password visibility
    togglePwd.addEventListener('click', () => {
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        togglePwd.textContent = type === 'password' ? '👁' : '🙈';
    });

    // Show demo credentials in a small toast/alert
    demoBtn.addEventListener('click', (e) => {
        e.preventDefault();
        alertBox.classList.remove('d-none', 'alert-danger');
        alertBox.classList.add('alert-info');
        alertBox.innerHTML = `<strong>Contoh:</strong> siswa / siswa &nbsp; | &nbsp; admin / admin &nbsp; | &nbsp; dosen / dosen`;
        setTimeout(() => {
            alertBox.classList.add('d-none');
            alertBox.classList.remove('alert-info');
        }, 6000);
    });

    // Form submit
    loginForm.addEventListener('submit', function (e) {
        e.preventDefault();
        alertBox.classList.add('d-none');
        alertBox.classList.remove('alert-info');

        const username = (document.getElementById('username').value || '').trim().toLowerCase();
        const password = (document.getElementById('password').value || '').trim();

        if (!username || !password) {
            showError('Isi username dan password terlebih dahulu.');
            return;
        }

        // Check credentials
        if (validCredentials[username] && validCredentials[username] === password) {
            // Simulate login: redirect based on role
            let target = '/';
            if (username === 'siswa') target = '/siswa/dashboard';
            if (username === 'admin')  target = '/admin/dashboard';
            if (username === 'dosen')  target = '/dosen/dashboard';

            // Optional: simpan role di localStorage jika "remember" dicentang
            const remember = document.getElementById('remember').checked;
            if (remember) {
                try {
                    localStorage.setItem('portal_role', username);
                } catch (err) {
                    // ignore
                }
            }

            // small success message then redirect
            alertBox.classList.remove('d-none', 'alert-danger');
            alertBox.classList.add('alert-success');
            alertBox.textContent = 'Login berhasil. Mengarahkan ke dashboard...';

            setTimeout(() => {
                window.location.href = target;
            }, 600);
            return;
        }

        // invalid
        showError('Username atau password salah. Cek kembali kredensial.');
    });

    function showError(msg) {
        alertBox.classList.remove('d-none');
        alertBox.classList.add('alert-danger');
        alertBox.textContent = msg;
    }
})();
</script>

</body>
</html>
