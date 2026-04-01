<?php include "template/header.php"; ?>
<?php include __DIR__ . "/../koneksi.php"; ?>

<style>
/* CARD */
.card {
    border-radius: 12px;
    overflow: hidden;
    transition: 0.3s;
}

.card:hover {
    transform: translateY(-5px);
}

/* IMAGE */
.card img {
    height: 200px;
    object-fit: cover;
}

/* SEARCH */
.search-box {
    max-width: 400px;
    margin: auto;
}

/* PAGINATION */
.pagination .page-link {
    border-radius: 8px;
}
</style>

<div class="container py-4">

    <h3 class="text-center mb-4">Berita Sekolah</h3>

    <!-- 🔍 SEARCH -->
    <form method="GET" class="search-box mb-4">
        <div class="input-group">
            <input type="text" name="cari" class="form-control" placeholder="Cari berita..."
                   value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
            <button class="btn btn-primary">Cari</button>
        </div>
    </form>

    <div class="row">
        <?php
        // PAGINATION
        $limit = 4;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page - 1) * $limit;

        // SEARCH
        $cari = isset($_GET['cari']) ? $_GET['cari'] : '';

        if ($cari != '') {
            $query = "SELECT * FROM berita 
                      WHERE judul LIKE '%$cari%' 
                      ORDER BY id DESC 
                      LIMIT $start, $limit";

            $total_query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM berita WHERE judul LIKE '%$cari%'");
        } else {
            $query = "SELECT * FROM berita ORDER BY id DESC LIMIT $start, $limit";
            $total_query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM berita");
        }

        $data = mysqli_query($koneksi, $query);
        $total_data = mysqli_fetch_assoc($total_query)['total'];
        $total_page = ceil($total_data / $limit);

        while ($b = mysqli_fetch_assoc($data)) {
        ?>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">

                <!-- Gambar -->
                <?php if (!empty($b['gambar'])) { ?>
                    <img src="admin/upload/<?= $b['gambar']; ?>">
                <?php } ?>

                <div class="card-body">
                    <h5><?= htmlspecialchars($b['judul']); ?></h5>

                    <small class="text-muted">
                        <?= date('d M Y', strtotime($b['tanggal'])); ?> | 
                        <?= htmlspecialchars($b['penulis']); ?>
                    </small>

                    <p class="mt-2">
                        <?= substr(strip_tags($b['isi']), 0, 120); ?>...
                    </p>
                </div>

                <div class="card-footer bg-white border-0">
                    <button class="btn btn-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modal<?= $b['id']; ?>">
                        Baca Selengkapnya
                    </button>
                </div>

            </div>
        </div>

        <!-- 🔥 MODAL DETAIL -->
        <div class="modal fade" id="modal<?= $b['id']; ?>" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5><?= htmlspecialchars($b['judul']); ?></h5>
                        <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <?php if (!empty($b['gambar'])) { ?>
                            <img src="admin/upload/<?= $b['gambar']; ?>" 
                                 class="img-fluid mb-3">
                        <?php } ?>

                        <p class="text-muted">
                            <?= date('d M Y', strtotime($b['tanggal'])); ?> | 
                            <?= htmlspecialchars($b['penulis']); ?>
                        </p>

                        <div><?= $b['isi']; ?></div>

                    </div>

                </div>
            </div>
        </div>

        <?php } ?>
    </div>

    <!-- 📄 PAGINATION -->
    <nav>
        <ul class="pagination justify-content-center">

            <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>&cari=<?= $cari ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php } ?>

        </ul>
    </nav>

</div>

<?php include "template/footer.php"; ?>