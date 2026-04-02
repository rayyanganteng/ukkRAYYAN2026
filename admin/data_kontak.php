<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:index.php?pesan=belum_login");
    exit;
}

include "../koneksi.php";

/* ==========================================
   1. LOGIKA PROSES SIMPAN (INPUT BARU)
   ========================================== */
if (isset($_POST['simpan_kontak'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan']);
    $tanggal = $_POST['tanggal_kirim'];

    $query = "INSERT INTO kontak (nama, email, pesan, tanggal_kirim) VALUES ('$nama', '$email', '$pesan', '$tanggal')";
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data berhasil disimpan'); window.location='data_kontak.php';</script>";
    }
}

/* ==========================================
   2. LOGIKA PROSES HAPUS
   ========================================== */
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM kontak WHERE id='$id'");
    echo "<script>alert('Data berhasil dihapus'); window.location='data_kontak.php';</script>";
}

/* ==========================================
   3. LOGIKA PROSES UPDATE (EDIT)
   ========================================== */
if (isset($_POST['update_kontak'])) {
    $id = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan']);
    $tanggal = $_POST['tanggal_kirim'];

    mysqli_query($koneksi, "UPDATE kontak SET nama='$nama', email='$email', pesan='$pesan', tanggal_kirim='$tanggal' WHERE id='$id'");
    echo "<script>alert('Data berhasil diperbarui'); window.location='data_kontak.php';</script>";
}

/* ==========================================
   4. CEK MODE EDIT
   ========================================== */
$edit_mode = false;
$data_lama = null;
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id_edit = (int)$_GET['edit'];
    $res_edit = mysqli_query($koneksi, "SELECT * FROM kontak WHERE id='$id_edit'");
    $data_lama = mysqli_fetch_assoc($res_edit);
}

include "template/header.php";
include "template/menu.php";
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Data Kontak</h3></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="hal_admin.php">Home</a></li>
                        <li class="breadcrumb-item active">Data Kontak</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            
            <?php if ($edit_mode && $data_lama) : ?>
            <div class="card card-warning shadow mb-4 border-warning">
                <div class="card-header"><h3 class="card-title">Edit Pesan</h3></div>
                <form action="" method="post">
                    <div class="card-body">
                        <input type="hidden" name="id" value="<?= $data_lama['id']; ?>">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data_lama['nama']); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($data_lama['email']); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Tanggal Kirim</label>
                                <input type="date" name="tanggal_kirim" class="form-control" value="<?= $data_lama['tanggal_kirim']; ?>" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label>Pesan</label>
                                <textarea name="pesan" class="form-control" rows="3" required><?= htmlspecialchars($data_lama['pesan']); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" name="update_kontak" class="btn btn-warning">Update</button>
                        <a href="data_kontak.php" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Daftar Pesan Kontak</h3>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-lg"></i> Tambah Kontak
                    </button>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Pesan</th>
                                <th>Tanggal Kirim</th>
                                <th width="12%" class="text-center">Aksi</th>
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
                                <td><?= nl2br(htmlspecialchars($d['pesan'])); ?></td>
                                <td><?= date('d/m/Y', strtotime($d['tanggal_kirim'])); ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="?edit=<?= $d['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                        <a href="?hapus=<?= $d['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kontak Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Input nama..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal_kirim" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pesan</label>
                        <textarea name="pesan" class="form-control" rows="3" placeholder="Tulis pesan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" name="simpan_kontak" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "template/footer.php"; ?>