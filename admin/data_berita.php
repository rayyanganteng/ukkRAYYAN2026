<?php
include "../koneksi.php";
include "template/header.php";
include "template/menu.php";

// Konfigurasi Folder Upload
$folder = "upload/";
if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

/* ==========================================
   1. PROSES SIMPAN DATA (DARI POPUP)
   ========================================== */
if (isset($_POST['simpan_berita'])) {
    $judul   = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi     = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $penulis = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $tanggal = $_POST['tanggal'];

    $nama_gambar = $_FILES['gambar']['name'];
    $tmp_gambar  = $_FILES['gambar']['tmp_name'];
    
    if (!empty($nama_gambar)) {
        $ext        = strtolower(pathinfo($nama_gambar, PATHINFO_EXTENSION));
        $nama_baru  = time() . "_" . rand(100, 999) . "." . $ext;
        $allowed    = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($ext, $allowed)) {
            if (move_uploaded_file($tmp_gambar, $folder . $nama_baru)) {
                $sql = "INSERT INTO berita (judul, isi, gambar, tanggal, penulis) 
                        VALUES ('$judul', '$isi', '$nama_baru', '$tanggal', '$penulis')";
                mysqli_query($koneksi, $sql);
                echo "<script>alert('Berita berhasil disimpan!'); window.location='data_berita.php';</script>";
            }
        }
    }
}

/* ==========================================
   2. PROSES UPDATE DATA (SIMPAN EDIT)
   ========================================== */
if (isset($_POST['update_berita'])) {
    $id = (int)$_POST['id'];
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $penulis = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $tanggal = $_POST['tanggal'];
    $gambar_lama = $_POST['gambar_lama'];

    if (!empty($_FILES['gambar']['name'])) {
        $nama_baru = time() . "_" . $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], $folder . $nama_baru);
        if (file_exists($folder . $gambar_lama)) unlink($folder . $gambar_lama);
        $gambar_final = $nama_baru;
    } else {
        $gambar_final = $gambar_lama;
    }

    $sql = "UPDATE berita SET judul='$judul', isi='$isi', gambar='$gambar_final', tanggal='$tanggal', penulis='$penulis' WHERE id='$id'";
    mysqli_query($koneksi, $sql);
    echo "<script>alert('Data diperbarui'); window.location='data_berita.php';</script>";
}

/* ==========================================
   3. PROSES HAPUS DATA
   ========================================== */
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $res = mysqli_query($koneksi, "SELECT gambar FROM berita WHERE id='$id'");
    $d = mysqli_fetch_assoc($res);
    if ($d) {
        if (file_exists($folder . $d['gambar'])) unlink($folder . $d['gambar']);
        mysqli_query($koneksi, "DELETE FROM berita WHERE id='$id'");
        echo "<script>alert('Data dihapus'); window.location='data_berita.php';</script>";
    }
}

/* ==========================================
   4. LOGIKA AMBIL DATA EDIT
   ========================================== */
$data_lama = null;
if (isset($_GET['edit'])) {
    $id_edit = (int)$_GET['edit'];
    $res_edit = mysqli_query($koneksi, "SELECT * FROM berita WHERE id='$id_edit'");
    $data_lama = mysqli_fetch_assoc($res_edit);
}
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <h3 class="mb-0">Manajemen Berita</h3>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <?php if ($data_lama) : ?>
            <div class="card shadow mb-4 border-warning">
                <div class="card-header bg-warning"><strong>Edit Berita: <?= $data_lama['judul'] ?></strong></div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" name="id" value="<?= $data_lama['id'] ?>">
                        <input type="hidden" name="gambar_lama" value="<?= $data_lama['gambar'] ?>">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Judul Berita</label>
                                <input type="text" name="judul" class="form-control" value="<?= $data_lama['judul'] ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Tanggal</label>
                                <input type="date" name="tanggal" class="form-control" value="<?= $data_lama['tanggal'] ?>" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Penulis</label>
                                <input type="text" name="penulis" class="form-control" value="<?= $data_lama['penulis'] ?>" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label>Isi Berita</label>
                                <textarea name="isi" class="form-control editor"><?= $data_lama['isi'] ?></textarea>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Ganti Gambar (Opsional)</label>
                                <input type="file" name="gambar" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="data_berita.php" class="btn btn-secondary">Batal</a>
                        <button type="submit" name="update_berita" class="btn btn-warning">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title m-0">Daftar Berita</h3>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus"></i> Tambah Berita
                    </button>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="50">No</th>
                                <th>Judul</th>
                                <th width="100">Gambar</th>
                                <th>Penulis</th>
                                <th width="120">Tanggal</th>
                                <th width="100" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $q = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC");
                            while ($d = mysqli_fetch_array($q)) { ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= $d['judul'] ?></strong></td>
                                <td><img src="<?= $folder . $d['gambar'] ?>" width="60" class="img-thumbnail"></td>
                                <td><?= $d['penulis'] ?></td>
                                <td><?= date('d/m/Y', strtotime($d['tanggal'])) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="?edit=<?= $d['id'] ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                                        <a href="?hapus=<?= $d['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></a>
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

<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTambahLabel">Form Input Berita Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Berita</label>
                                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul berita..." required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Isi Berita</label>
                                <textarea name="isi" class="form-control editor" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Gambar Utama</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*" required>
                                <div class="form-text">Format: JPG, PNG, GIF.</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-