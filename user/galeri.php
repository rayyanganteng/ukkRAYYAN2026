<?php include "template/header.php"; ?>
<?php include __DIR__ . "/../koneksi.php"; ?>

<style>
.section-title {
    text-align: center;
    margin-bottom: 40px;
}

.section-title h2 {
    font-weight: 700;
}

.section-title p {
    color: #6c757d;
}

.gallery-card {
    border-radius: 15px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: 0.3s;
}

.gallery-card:hover {
    transform: translateY(-5px);
}

.img-wrapper {
    position: relative;
    overflow: hidden;
}

.img-wrapper img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    transition: 0.5s;
    cursor: pointer;
}

.gallery-card:hover img {
    transform: scale(1.1);
}

.overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
    opacity: 0;
    transition: 0.3s;
    display: flex;
    align-items: flex-end;
}

.gallery-card:hover .overlay {
    opacity: 1;
}

.overlay-content {
    color: white;
    padding: 12px;
}

.overlay-content h6 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
}

.overlay-content small {
    font-size: 12px;
}

@media (max-width: 576px) {
    .img-wrapper img {
        height: 150px;
    }
}
</style>

<div class="container py-5">

    <!-- HEADER -->
    <div class="section-title">
        <h2>Galeri Sekolah</h2>
        <p>Dokumentasi kegiatan dan momen terbaik sekolah</p>
    </div>

    <div class="row g-4">

        <?php
        $data = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id DESC");

        while ($g = mysqli_fetch_assoc($data)) {

            // 🔥 FIX PATH
            $img_url  = "admin/upload/" . $g['gambar']; // untuk browser
            $img_path = __DIR__ . "/../admin/upload/" . $g['gambar']; // untuk server
        ?>

        <div class="col-6 col-md-4 col-lg-3">

            <div class="gallery-card">

                <?php if (!empty($g['gambar']) && file_exists($img_path)) { ?>

                    <div class="img-wrapper"
                         data-bs-toggle="modal"
                         data-bs-target="#modalGaleri<?= $g['id']; ?>">

                        <img src="<?= $img_url; ?>" alt="">

                        <!-- OVERLAY -->
                        <div class="overlay">
                            <div class="overlay-content">
                                <h6><?= htmlspecialchars($g['judul']); ?></h6>
                                <small><?= date('d M Y', strtotime($g['tanggal_upload'])); ?></small>
                            </div>
                        </div>

                    </div>

                <?php } else { ?>

                    <div class="img-wrapper">
                        <img src="https://via.placeholder.com/400x200?text=No+Image">
                    </div>

                <?php } ?>

            </div>

        </div>

        <!-- MODAL DETAIL -->
        <div class="modal fade" id="modalGaleri<?= $g['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">

                    <!-- HEADER -->
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <?= htmlspecialchars($g['judul']); ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- BODY -->
                    <div class="modal-body text-center">

                        <?php if (!empty($g['gambar']) && file_exists($img_path)) { ?>
                            <img src="<?= $img_url; ?>" 
                                 class="img-fluid rounded mb-3"
                                 style="max-height:400px; object-fit:cover;">
                        <?php } ?>

                        <p class="text-muted">
                            <?= date('d M Y', strtotime($g['tanggal_upload'])); ?>
                        </p>

                        <div style="text-align:left;">
                            <?= $g['deskripsi']; ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <?php } ?>

    </div>

</div>

<?php include "template/footer.php"; ?>