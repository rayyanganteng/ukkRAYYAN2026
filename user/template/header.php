<?php
session_start();

/* Base URL */
$base_url = "/ahmad_xii/";

/* Ambil URL aktif - Menghapus base_url dari path agar deteksi active link akurat */
$current = trim(str_replace($base_url, '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/');

/* CSRF Token */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Website Sekolah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* RESET GLOBAL */
        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100%;
            overflow-x: hidden;
            background: #F1F5F9;
            font-family: 'Poppins', sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, #1E3A8A, #2563EB);
            padding: 10px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            /* Menghapus margin bawah agar banner menempel */
            margin-bottom: 0 !important;
            border: none !important;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 24px;
            /* Dikecilkan sedikit agar proporsional di layar sedang */
            color: white !important;
        }

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

        .nav-link:hover::after,
        .active-link::after {
            width: 100%;
        }

        .nav-link:hover,
        .active-link {
            color: #FFFFFF !important;
        }

        .btn-light:hover {
            background: #38BDF8;
            color: white;
        }

        @media (max-width: 991px) {
            .navbar-brand {
                font-size: 18px;
            }

            .navbar-collapse {
                background: #1E3A8A;
                margin-top: 10px;
                padding: 15px;
                border-radius: 10px;
            }

            .nav-link {
                margin: 8px 0;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">

            <a class="navbar-brand d-flex align-items-center" href="<?= $base_url ?>">
                <img src="<?= $base_url ?>user/img/logo.png" height="80" class="me-2"> <span class="d-none d-sm-inline">SMK GANESHA TAMA BOYOLALI</span>
            </a>

            <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto align-items-center">

                    <li class="nav-item">
                        <a class="nav-link <?= ($current == '' || $current == 'index.php') ? 'active-link' : '' ?>"
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

                    <li class="nav-item mt-2 mt-lg-0">
                        <a class="btn btn-light btn-sm ms-lg-2 px-3 rounded-pill fw-bold" href="<?= $base_url ?>admin/index.php">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="main-wrapper">