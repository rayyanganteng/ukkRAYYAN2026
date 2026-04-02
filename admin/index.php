<?php
session_start();

// Buat token CSRF jika belum ada
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Jika sudah login, tendang ke halaman admin
if (isset($_SESSION['status']) && $_SESSION['status'] == "login") {
    header("Location: hal_admin.php");
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login Admin | Website Sekolah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(-45deg, #667eea, #764ba2, #6B8DD6, #8E37D7);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .login-card {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            /* Lebih responsif di HP */
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
            transition: 0.3s;
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .toggle-password {
            position: absolute;
            top: 38px;
            /* Disesuaikan agar pas di tengah input */
            right: 15px;
            border: none;
            background: none;
            cursor: pointer;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="login-card">
        <h4 class="text-center mb-4">Login Admin</h4>

        <?php
        if (isset($_GET['pesan'])) {
            if ($_GET['pesan'] == "gagal") {
                echo '<div class="alert alert-danger text-center">Username atau Password salah!</div>';
            } else if ($_GET['pesan'] == "kosong") {
                echo '<div class="alert alert-warning text-center">Username dan Password harus diisi!</div>';
            } else if ($_GET['pesan'] == "logout") {
                echo '<div class="alert alert-success text-center">Anda telah berhasil logout.</div>';
            }
        }
        ?>

        <form action="proses_login.php" method="post" id="loginForm">

            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
            </div>

            <div class="mb-3 position-relative">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control pe-5" placeholder="Masukkan password" required>
                <button type="button" class="toggle-password" onclick="togglePassword()">
                    <i class="bi bi-eye" id="icon"></i>
                </button>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label" for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">
                <span id="textBtn">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </span>
            </button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const pass = document.getElementById("password");
            const icon = document.getElementById("icon");
            if (pass.type === "password") {
                pass.type = "text";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                pass.type = "password";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            }
        }

        // Efek loading saat submit
        document.getElementById("loginForm").addEventListener("submit", function() {
            const btn = document.getElementById("btnLogin");
            const text = document.getElementById("textBtn");

            btn.disabled = true; // Mencegah klik ganda
            text.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
        });
    </script>

</body>

</html>