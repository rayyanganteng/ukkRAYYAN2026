<?php include "template/header.php"; ?>
<?php include __DIR__ . "/koneksi.php"; ?>

<style>
.hero {
    position: relative;
    background: url('/ahmad_xii/user/img/gerbang.jpeg') center/cover no-repeat;
    height: 400px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    overflow: hidden;
}

.hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
}

.hero-content {
    position: relative;
    z-index: 2;
    color: white;
}

.section {
    margin-top: 50px;
}

.card-custom {
    border-radius: 15px;
    transition: 0.3s;
}

.card-custom:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.stat-box {
    background: #1E3A8A;
    color: white;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
}

.btn-custom {
    background: #1E3A8A;
    color: white;
}

.btn-custom:hover {
    background: #1E40AF;
}
</style>

<!-- HERO -->
<div class="hero mb-4">
    <div class="hero-content">
        <img src="/ahmad_xii/user/img/logo.png" width="150" class="mb-3">
        <h1 class="fw-bold">Selamat Datang di Website SMK Ganesha Tama Boyolali</h1>
        <p>Informasi resmi & kegiatan terbaru sekolah</p>
    </div>
</div>

<!-- BERITA -->
<div class="section">
    <h4>📰 Berita Terbaru</h4>
    <div class="row">
        <?php
        $data = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC LIMIT 3");
        while ($d = mysqli_fetch_assoc($data)) {

            $img_url = "/ahmad_xii/admin/upload/" . $d['gambar'];
            $img_path = __DIR__ . "/admin/upload/" . $d['gambar'];
        ?>
            <div class="col-md-4">
                <div class="card card-custom mb-4">

                    <?php if (!empty($d['gambar']) && file_exists($img_path)) { ?>
                        <img src="<?= $img_url ?>" height="200" style="object-fit:cover;">
                    <?php } else { ?>
                        <img src="https://via.placeholder.com/400x200?text=No+Image">
                    <?php } ?>

                    <div class="card-body">
                        <h5><?= htmlspecialchars($d['judul']); ?></h5>
                        <p><?= substr(strip_tags($d['isi']), 0, 100); ?>...</p>
                        <a href="berita.php" class="btn btn-custom btn-sm">Lihat Semua</a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- GALERI -->
<div class="section">
    <h4>🖼️ Galeri</h4>
    <div class="row">
        <?php
        $galeri = mysqli_query($koneksi, "SELECT * FROM galeri LIMIT 4");
        while ($g = mysqli_fetch_assoc($galeri)) {

            $img_url = "/ahmad_xii/admin/upload/" . $g['gambar'];
            $img_path = __DIR__ . "/admin/upload/" . $g['gambar'];
        ?>
            <div class="col-md-3">
                <?php if (!empty($g['gambar']) && file_exists($img_path)) { ?>
                    <img src="<?= $img_url ?>" class="img-fluid rounded mb-3">
                <?php } else { ?>
                    <img src="https://via.placeholder.com/300x200" class="img-fluid rounded mb-3">
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

<!-- GURU -->
<div class="section">
    <h4>👨‍🏫 Guru Kami</h4>
    <div class="row">
        <?php
        $guru = mysqli_query($koneksi, "SELECT * FROM guru LIMIT 3");
        while ($gr = mysqli_fetch_assoc($guru)) {
        ?>
            <div class="col-md-4 text-center">
                <div class="card card-custom p-3">
                    <h5><?= htmlspecialchars($gr['nama_guru']); ?></h5>
                    <p><?= htmlspecialchars($gr['mapel']); ?></p>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- CTA -->
<div class="section text-center p-5 bg-light rounded">
    <h4>Hubungi Kami</h4>
    <p>Silakan hubungi sekolah untuk informasi lebih lanjut</p>
    <a href="kontak.php" class="btn btn-custom">Kontak</a>
</div>

<?php include "template/footer.php"; ?>