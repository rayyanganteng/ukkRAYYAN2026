<?php include "template/header.php"; ?>
<?php include_once __DIR__ . "/../koneksi.php"; ?>

<?php
// Membersihkan base_url agar path tidak double slash
$base_url = rtrim($base_url, '/') . '/';

// Path untuk mengambil gambar dari folder admin
$upload_path = __DIR__ . "/../admin/upload/";
$upload_url  = $base_url . "admin/upload/";
?>

<style>
    /* 1. RESET BODY & NAVBAR */
    body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .navbar, header {
        margin-bottom: 0 !important;
        border-bottom: none !important;
    }

    /* 2. HERO SECTION */
    .hero {
        position: relative;
        background: url('<?= $base_url ?>user/img/gerbang.jpeg') center/cover no-repeat;
        height: 90vh;
        min-height: 500px;
        width: 100vw;
        left: 50%;
        right: 50%;
        margin-left: -50vw;
        margin-right: -50vw;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        margin-top: 0;
        margin-bottom: 60px;
    }

    .hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.75));
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        padding: 0 20px;
    }

    .hero-content h1 {
        font-size: clamp(2rem, 5vw, 4rem);
        font-weight: 800;
        text-shadow: 2px 4px 10px rgba(0, 0, 0, 0.5);
        margin-bottom: 15px;
    }

    /* 3. KOMPONEN KONTEN */
    .section-title {
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 40px;
        font-weight: 700;
        color: #1E3A8A;
    }

    .section-title::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 60px;
        height: 5px;
        background: #1E3A8A;
        border-radius: 10px;
    }

    .card-custom {
        border: none;
        border-radius: 20px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: #fff;
    }

    .card-custom:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .galeri-container {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        height: 280px;
        cursor: pointer;
    }

    .galeri-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
    }

    .galeri-container:hover .galeri-img {
        transform: scale(1.15);
    }

    .btn-custom {
        background: #1E3A8A;
        color: white;
        border-radius: 50px;
        padding: 15px 35px;
        font-weight: 600;
        transition: 0.3s;
        border: none;
        text-decoration: none;
        display: inline-block;
    }

    .btn-custom:hover {
        background: #111827;
        color: white;
        box-shadow: 0 10px 20px rgba(30, 58, 138, 0.3);
    }
</style>

<div class="hero">
    <div class="hero-content">
        <img src="<?= $base_url ?>user/img/logo.png" width="200" class="mb-4">
        <h1 class="display-3 text-white">Selamat Datang di SMK Ganesha Tama Boyolali</h1>
        <p class="lead">Pusat Informasi Resmi, Prestasi, dan Kegiatan Terkini</p>
    </div>
</div>

<div class="container">

    <div class="section mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h4 class="section-title mb-0">Berita Terbaru</h4>
            <a href="<?= $base_url ?>berita" class="text-decoration-none fw-bold text-primary">Lihat Semua <i class="bi bi-arrow-right-short"></i></a>
        </div>

        <div class="row g-4">
            <?php
            $data = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC LIMIT 3");
            if ($data && mysqli_num_rows($data) > 0):
                while ($d = mysqli_fetch_assoc($data)):
                    $img_url  = $upload_url . $d['gambar'];
                    $img_path = $upload_path . $d['gambar'];
            ?>
                    <div class="col-md-4">
                        <div class="card card-custom h-100 shadow-sm">
                            <div class="position-relative overflow-hidden" style="border-radius: 20px 20px 0 0;">
                                <?php if (!empty($d['gambar']) && file_exists($img_path)): ?>
                                    <img src="<?= $img_url ?>" height="240" class="card-img-top" style="object-fit:cover;">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/400x250?text=No+Image" height="240" class="card-img-top" style="object-fit:cover;">
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-2"><?= htmlspecialchars($d['judul']); ?></h5>
                                <p class="text-muted small mb-3"><?= htmlspecialchars(substr(strip_tags($d['isi']), 0, 90)); ?>...</p>
                                <a href="<?= $base_url ?>berita/detail/<?= $d['id'] ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4">Baca Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
            else: ?>
                <div class="col-12 text-center py-5 text-muted">Belum ada berita yang diterbitkan.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="section mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h4 class="section-title mb-0">Galeri Sekolah</h4>
            <a href="<?= $base_url ?>galeri" class="text-decoration-none fw-bold text-primary">Lihat Galeri <i class="bi bi-arrow-right-short"></i></a>
        </div>

        <div class="row g-4">
            <?php
            $galeri = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id DESC LIMIT 4");
            if ($galeri && mysqli_num_rows($galeri) > 0):
                while ($g = mysqli_fetch_assoc($galeri)):
                    $img_url  = $upload_url . $g['gambar'];
                    $img_path = $upload_path . $g['gambar'];
            ?>
                    <div class="col-lg-3 col-md-6">
                        <div class="galeri-container shadow-sm">
                            <?php if (!empty($g['gambar']) && file_exists($img_path)): ?>
                                <img src="<?= $img_url ?>" class="galeri-img">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/400x300?text=Galeri" class="galeri-img">
                            <?php endif; ?>
                        </div>
                    </div>
            <?php endwhile; endif; ?>
        </div>
    </div>

    <div class="section mb-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h4 class="section-title mb-0">Tenaga Pendidik</h4>
            <a href="<?= $base_url ?>guru" class="text-decoration-none fw-bold text-primary">Lihat Semua Guru <i class="bi bi-arrow-right-short"></i></a>
        </div>

        <div class="row g-4 justify-content-center">
            <?php
            $guru = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY id DESC LIMIT 4");
            if ($guru && mysqli_num_rows($guru) > 0):
                while ($g = mysqli_fetch_assoc($guru)):
                    $img_guru_url  = $upload_url . $g['foto'];
                    $img_guru_path = $upload_path . $g['foto'];
            ?>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="card card-custom border-0 shadow-sm p-4 h-100">
                            <div class="mb-3 mx-auto overflow-hidden shadow-sm" style="width: 130px; height: 130px; border-radius: 50%; border: 4px solid #F1F5F9;">
                                <?php if (!empty($g['foto']) && file_exists($img_guru_path)): ?>
                                    <img src="<?= $img_guru_url ?>" class="w-100 h-100" style="object-fit: cover;">
                                <?php else: ?>
                                    <img src="https://via.placeholder.com/150?text=Guru" class="w-100 h-100" style="object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <h6 class="fw-bold mb-1"><?= htmlspecialchars($g['nama_guru']); ?></h6>
                            
                            <p class="text-primary small mb-0 fw-medium"><?= htmlspecialchars($g['mapel'] ?? '-'); ?></p>
                            
                            <hr class="mx-auto my-3" style="width: 30px; height: 2px; background: #1E3A8A; opacity: 1; border: none;">
                            <p class="text-muted x-small mb-0" style="font-size: 0.75rem;">Mengabdi untuk mencetak generasi unggul.</p>
                        </div>
                    </div>
            <?php endwhile; else: ?>
                <div class="col-12 text-center py-4 text-muted">Data guru belum tersedia.</div>
            <?php endif; ?>
        </div>
    </div>

    <div class="section text-center p-5 bg-light border-0 shadow-sm rounded-5 mb-5">
        <div class="mb-3"><i class="bi bi-envelope-paper-heart fs-1 text-primary"></i></div>
        <h3 class="fw-bold">Ada Pertanyaan Mengenai Sekolah?</h3>
        <p class="text-muted mb-4 mx-auto" style="max-width: 600px;">Tim admin kami siap membantu memberikan informasi seputar PPDB, Jurusan, atau kegiatan ekstrakurikuler lainnya.</p>
        <a href="<?= $base_url ?>kontak" class="btn btn-custom">Hubungi Kami Sekarang</a>
    </div>

</div>

<?php include "template/footer.php"; ?>