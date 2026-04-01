<?php
// LOGIKA: Mendeteksi Nama Halaman Aktif
$page = basename($_SERVER['PHP_SELF']);
?>

<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="hal_admin.php" class="brand-link">
            <span class="brand-text fw-light">Admin Panel</span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="hal_admin.php" class="nav-link <?= ($page == 'hal_admin.php') ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item <?= ($page == 'input_berita.php' || $page == 'data_berita.php') ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= ($page == 'input_berita.php' || $page == 'data_berita.php') ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-newspaper"></i>
                        <p>
                            Berita
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="input_berita.php" class="nav-link <?= ($page == 'input_berita.php') ? 'active' : ''; ?>">
                                <i class="bi bi-circle nav-icon"></i>
                                <p>Input Berita</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="data_berita.php" class="nav-link <?= ($page == 'data_berita.php') ? 'active' : ''; ?>">
                                <i class="bi bi-circle nav-icon"></i>
                                <p>Data Berita</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item <?= ($page == 'input_galeri.php' || $page == 'data_galeri.php') ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= ($page == 'input_galeri.php' || $page == 'data_galeri.php') ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-images"></i>
                        <p>
                            Galeri
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="input_galeri.php" class="nav-link <?= ($page == 'input_galeri.php') ? 'active' : ''; ?>">
                                <i class="bi bi-circle nav-icon"></i>
                                <p>Input Galeri</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="data_galeri.php" class="nav-link <?= ($page == 'data_galeri.php') ? 'active' : ''; ?>">
                                <i class="bi bi-circle nav-icon"></i>
                                <p>Data Galeri</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item <?= ($page == 'input_guru.php' || $page == 'data_guru.php') ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= ($page == 'input_guru.php' || $page == 'data_guru.php') ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-people"></i>
                        <p>
                            Guru
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="input_guru.php" class="nav-link <?= ($page == 'input_guru.php') ? 'active' : ''; ?>">
                                <i class="bi bi-circle nav-icon"></i>
                                <p>Input Guru</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="data_guru.php" class="nav-link <?= ($page == 'data_guru.php') ? 'active' : ''; ?>">
                                <i class="bi bi-circle nav-icon"></i>
                                <p>Data Guru</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item <?= ($page == 'input_kontak.php' || $page == 'data_kontak.php') ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= ($page == 'input_kontak.php' || $page == 'data_kontak.php') ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-envelope"></i>
                        <p>
                            Kontak
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="input_kontak.php" class="nav-link <?= ($page == 'input_kontak.php') ? 'active' : ''; ?>">
                                <i class="bi bi-circle nav-icon"></i>
                                <p>Input Kontak</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="data_kontak.php" class="nav-link <?= ($page == 'data_kontak.php') ? 'active' : ''; ?>">
                                <i class="bi bi-circle nav-icon"></i>
                                <p>Data Kontak</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item <?= ($page == 'input_sekolah.php' || $page == 'data_sekolah.php') ? 'menu-open' : ''; ?>">
                    <a href="#" class="nav-link <?= ($page == 'input_sekolah.php' || $page == 'data_sekolah.php') ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-building"></i>
                        <p>
                            Profil Sekolah
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="input_sekolah.php" class="nav-link <?= ($page == 'input_sekolah.php') ? 'active' : ''; ?>">
                                <i class="bi bi-circle nav-icon"></i>
                                <p>Input Profil</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="data_sekolah.php" class="nav-link <?= ($page == 'data_sekolah.php') ? 'active' : ''; ?>">
                                <i class="bi bi-circle nav-icon"></i>
                                <p>Data Profil</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item mt-3">
                    <a href="logout.php" class="nav-link bg-danger text-white">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Logout</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>