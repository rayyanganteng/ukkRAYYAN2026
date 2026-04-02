<?php

/**
 * LOGIKA NAVIGASI AKTIF
 * Mendapatkan nama file saat ini untuk menentukan menu mana yang harus "active" atau "open"
 */
$page = basename($_SERVER['PHP_SELF']);

/**
 * Fungsi pembantu untuk efisiensi kode CSS Class
 * @param string $current_page Variabel $page saat ini
 * @param array $target_pages Daftar file yang memicu status aktif
 * @param string $class Jenis class yang dikembalikan ('active' atau 'menu-open')
 */
function nav_state($current_page, $target_pages, $class = 'active')
{
    return in_array($current_page, $target_pages) ? $class : '';
}
?>

<aside class="app-sidebar bg-dark shadow-lg" data-bs-theme="dark">
    <div class="sidebar-brand border-bottom border-secondary">
        <a href="hal_admin.php" class="brand-link">
            <i class="bi bi-shield-lock-fill text-primary me-2 ms-3"></i>
            <span class="brand-text fw-bold text-uppercase">Admin<span class="fw-light">Panel</span></span>
        </a>
    </div>

    <div class="sidebar-wrapper">
        <nav class="mt-3">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="hal_admin.php" class="nav-link <?= nav_state($page, ['hal_admin.php']); ?>">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header text-uppercase small opacity-50 ps-3 mt-3 mb-1">Manajemen Konten</li>

                <li class="nav-item <?= nav_state($page, ['input_berita.php', 'data_berita.php'], 'menu-open'); ?>">
                    <a href="#" class="nav-link <?= nav_state($page, ['input_berita.php', 'data_berita.php']); ?>">
                        <i class="nav-icon bi bi-newspaper text-info"></i>
                        <p>
                            Berita
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="data_berita.php" class="nav-link <?= nav_state($page, ['data_berita.php']); ?>">
                                <i class="bi bi-circle nav-icon" style="font-size: 0.7rem;"></i>
                                <p>Data Berita</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item <?= nav_state($page, ['input_galeri.php', 'data_galeri.php'], 'menu-open'); ?>">
                    <a href="#" class="nav-link <?= nav_state($page, ['input_galeri.php', 'data_galeri.php']); ?>">
                        <i class="nav-icon bi bi-images text-warning"></i>
                        <p>
                            Galeri
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="data_galeri.php" class="nav-link <?= nav_state($page, ['data_galeri.php']); ?>">
                                <i class="bi bi-circle nav-icon" style="font-size: 0.7rem;"></i>
                                <p>Data Galeri</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header text-uppercase small opacity-50 ps-3 mt-3 mb-1">Data Master</li>

                <li class="nav-item <?= nav_state($page, ['input_guru.php', 'data_guru.php'], 'menu-open'); ?>">
                    <a href="#" class="nav-link <?= nav_state($page, ['input_guru.php', 'data_guru.php']); ?>">
                        <i class="nav-icon bi bi-people-fill text-success"></i>
                        <p>
                            Guru & Staff
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="data_guru.php" class="nav-link <?= nav_state($page, ['data_guru.php']); ?>">
                                <i class="bi bi-circle nav-icon" style="font-size: 0.7rem;"></i>
                                <p>Daftar Guru</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="data_kontak.php" class="nav-link <?= nav_state($page, ['data_kontak.php', 'input_kontak.php']); ?>">
                        <i class="nav-icon bi bi-envelope-check"></i>
                        <p>Pesan & Kontak</p>
                    </a>
                </li>

                <li class="nav-header text-uppercase small opacity-50 ps-3 mt-3 mb-1">Sistem</li>

                <li class="nav-item">
                    <a href="data_sekolah.php" class="nav-link <?= nav_state($page, ['data_sekolah.php', 'input_sekolah.php']); ?>">
                        <i class="nav-icon bi bi-building-gear"></i>
                        <p>Profil Sekolah</p>
                    </a>
                </li>

                <li class="nav-item mt-4 pt-2 border-top border-secondary">
                    <a href="logout.php" class="nav-link" style="color: #fcfcfc; transition: 0.3s;" onmouseover="this.style.backgroundColor='rgba(255,107,107,0.1)'" onmouseout="this.style.backgroundColor='transparent'">
                        <i class="nav-icon bi bi-power"></i>
                        <p class="fw-bold">Logout Sistem</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>