<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:index.php?pesan=belum_login");
    exit;
}

include "template/header.php";
include "template/menu.php";
include "../koneksi.php";
?>

<main class="app-main">

    <!-- Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Data Kontak</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="hal_admin.php">Home</a></li>
                        <li class="breadcrumb-item active">Data Kontak</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pesan Kontak</h3>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Pesan</th>
                                        <th>Tanggal Kirim</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $data = mysqli_query($koneksi, "SELECT * FROM kontak ORDER BY id DESC");
                                    while ($d = mysqli_fetch_array($data)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($d['nama']); ?></td>
                                        <td><?= htmlspecialchars($d['email']); ?></td>
                                        <td><?= htmlspecialchars($d['pesan']); ?></td>
                                        <td><?= $d['tanggal_kirim']; ?></td>
                                        <td class="text-center">

                                            <a href="edit_kontak.php?id=<?= $d['id']; ?>>" class="btn btn-sm btn-warning me-1" title="edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <!-- <a href="edit_kontak.php?id=<?= $d['id']; ?>" 
                                                class="btn btn-sm btn-warning me-1" 
                                                title="Edit">
                                                  <i class="bi bi-pencil-square"></i>
                                            </a> -->
   


                                            
                                            <a href="hapus_kontak.php?id=<?= $d['id']; ?>"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer text-muted">
                            Total Data: <?= mysqli_num_rows($data); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</main>

<?php include "template/footer.php"; ?>