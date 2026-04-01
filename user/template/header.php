<?php
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
$base_url = "/ahmad_xii/";
$current = trim($_SERVER['REQUEST_URI'], '/');
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Website Sekolah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #F1F5F9;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #1E3A8A, #2563EB);
            padding: 12px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Logo */
        .navbar-brand {
            font-weight: 600;
            font-size: 17px;
            color: white !important;
        }

        .navbar-brand img {
            border-radius: 50%;
            border: 2px solid white;
        }

        /* Menu */
        .nav-link {
            color: #E5E7EB !important;
            margin-right: 15px;
            position: relative;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-link::after {
            content: "";
            position: absolute;
            width: 0%;
            height: 2px;
            bottom: -5px;
            left: 0;
            background: #38BDF8;
            transition: 0.3s;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            color: #FFFFFF !important;
        }

        /* Active */
        .active-link {
            color: #FFFFFF !important;
        }

        .active-link::after {
            width: 100%;
        }

        /* Mobile */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: #1E3A8A;
                margin-top: 10px;
                padding: 10px;
                border-radius: 10px;
            }

            .nav-link {
                margin: 8px 0;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= $base_url ?>">
                <img src="<?= $base_url ?>user/img/logo.png" width="60" height="60" class="me-2">
                SMK GANESHA TAMA BOYOLALI
            </a>

            <button class="navbar-toggler bg-light" data-bs-toggle="collapse" data-bs-target="#menu">
                ☰
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link <?= ($current == 'ahmad_xii' || $current == '') ? 'active-link' : '' ?>"
                            href="<?= $base_url ?>">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($current, 'guru') !== false) ? 'active-link' : '' ?>"
                            href="<?= $base_url ?>guru">Guru</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($current, 'berita') !== false) ? 'active-link' : '' ?>"
                            href="<?= $base_url ?>berita">Berita</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($current, 'galeri') !== false) ? 'active-link' : '' ?>"
                            href="<?= $base_url ?>galeri">Galeri</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($current, 'profil') !== false) ? 'active-link' : '' ?>"
                            href="<?= $base_url ?>profil">Profil</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?= (strpos($current, 'kontak') !== false) ? 'active-link' : '' ?>"
                            href="<?= $base_url ?>kontak">Kontak</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-light ms-2 px-3" href="<?= $base_url ?>admin/login.php">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">