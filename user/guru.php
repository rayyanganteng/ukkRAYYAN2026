<?php include "template/header.php"; ?>
<?php include __DIR__ . "/../koneksi.php"; ?>

<style>
/* HEADER */
.section-title {
    text-align: center;
    margin-bottom: 40px;
}

/* SEARCH */
.search-box {
    max-width: 400px;
    margin: auto;
}

/* CARD */
.guru-card {
    border-radius: 16px;
    background: white;
    padding: 20px;
    text-align: center;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: 0.3s;
    cursor: pointer;
}

.guru-card:hover {
    transform: translateY(-6px);
}

/* FOTO */
.guru-img {
    width: 90px;
    height: 90px;
    margin: auto;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid #2563EB;
    margin-bottom: 10px;
}

.guru-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* NAMA */
.guru-name {
    font-weight: 600;
}

/* BADGE */
.badge-mapel {
    background: #2563EB;
    color: white;
    font-size: 12px;
    padding: 5px 10px;
    border-radius: 20px;
    display: inline-block;
    margin-top: 5px;
}
</style>

<div class="container py-5">

    <!-- HEADER -->
    <div class="section-title">
        <h2>Data Guru</h2>
        <p>Daftar tenaga pengajar profesional</p>
    </div>

    <!-- 🔍 SEARCH -->
    <form method="GET" class="search-box mb-4">
        <div class="input-group">
            <input type="text" name="cari" class="form-control" placeholder="Cari guru..."
                   value="<?= $_GET['cari'] ?? '' ?>">
            <button class="btn btn-primary">Cari</button>
        </div>
    </form>

    <div class="row g-4">

        <?php
        $cari = $_GET['cari'] ?? '';

        if ($cari != '') {
            $query = "SELECT * FROM guru 
                      WHERE nama_guru LIKE '%$cari%' 
                      OR mapel LIKE '%$cari%'";
        } else {
            $query = "SELECT * FROM guru";
        }

        $data = mysqli_query($koneksi, $query);

        while ($g = mysqli_fetch_assoc($data)) {
            $foto = !empty($g['foto']) ? "admin/upload/" . $g['foto'] : "https://via.placeholder.com/150";
        ?>

        <div class="col-6 col-md-4 col-lg-3">

            <!-- CARD -->
            <div class="guru-card"
                 data-bs-toggle="modal"
                 data-bs-target="#modalGuru<?= $g['id']; ?>">

                <div class="guru-img">
                    <img src="<?= $foto; ?>">
                </div>

                <div class="guru-name">
                    <?= htmlspecialchars($g['nama_guru']); ?>
                </div>

                <div class="badge-mapel">
                    <?= htmlspecialchars($g['mapel']); ?>
                </div>

            </div>

        </div>

        <!-- 🔥 MODAL DETAIL -->
        <div class="modal fade" id="modalGuru<?= $g['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content text-center p-3">

                    <div class="modal-header border-0">
                        <h5 class="modal-title w-100">
                            <?= htmlspecialchars($g['nama_guru']); ?>
                        </h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <img src="<?= $foto; ?>" 
                             class="rounded-circle mb-3"
                             style="width:120px; height:120px; object-fit:cover; border:3px solid #2563EB;">

                        <h6 class="text-muted">
                            <?= htmlspecialchars($g['mapel']); ?>
                        </h6>

                        <?php if (!empty($g['deskripsi'])) { ?>
                            <p class="mt-3"><?= $g['deskripsi']; ?></p>
                        <?php } ?>

                    </div>

                </div>
            </div>
        </div>

        <?php } ?>

    </div>

</div>

<?php include "template/footer.php"; ?>