<?php
session_start();

// kalau sudah login
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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
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
            width: 400px;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 10px;
            padding: 12px;
            width: 100%;
        }

        .toggle-password {
            position: absolute;
            top: 70%;
            right: 15px;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <h4 class="text-center mb-3">Login Admin</h4>

        <!-- ALERT -->
        <?php if (isset($_GET['pesan']) && $_GET['pesan'] == "gagal") { ?>
            <div class="alert alert-danger text-center">Username atau Password salah!</div>
        <?php } ?>

        <form action="admin/proses_login.php" method="post" id="loginForm">

            <!-- USERNAME -->
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>

            <!-- PASSWORD -->
            <div class="mb-3 position-relative">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control pe-5" required>

                <button type="button" class="toggle-password" onclick="togglePassword()">
                    <i class="bi bi-eye" id="icon"></i>
                </button>
            </div>

            <!-- REMEMBER -->
            <div class="mb-3">
                <input type="checkbox" name="remember"> Ingat saya
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn-login" id="btnLogin">
                <span id="textBtn">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </span>
            </button>

        </form>

    </div>

    <script>
        function togglePassword() {
            let pass = document.getElementById("password");
            let icon = document.getElementById("icon");

            if (pass.type === "password") {
                pass.type = "text";
                icon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                pass.type = "password";
                icon.classList.replace("bi-eye-slash", "bi-eye");
            }
        }

        // loading button
        document.getElementById("loginForm").addEventListener("submit", function() {
            document.getElementById("textBtn").innerHTML = "Loading...";
        });
    </script>

</body>

</html>