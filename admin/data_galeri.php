<?php
include "../koneksi.php";
include "template/header.php";
include "template/menu.php";

$folder_upload = "../upload/galeri/";
if (!is_dir($folder_upload)) {
    mkdir($folder_upload, 0777, true);
}

/* ========================================= 
   1. PROSES SIMPAN 
   ========================================= */
if (isset($_POST['simpan_galeri'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $tgl = $_POST['tanggal_upload'];
    
    if (!empty($_FILES['gambar']['name'])) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $filename = time() . "_" . rand(100, 999) . "." . $ext;
        
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $folder_upload . $filename)) {
            mysqli_query($koneksi, "INSERT INTO galeri (judul, deskripsi, gambar, tanggal_upload) VALUES ('$judul', '$deskripsi', '$filename', '$tgl')");
            echo "<script>alert('Data Berhasil Ditambahkan!'); window.location='data_galeri.php';</script>";
        }
    }
}

/* ========================================= 
   2. PROSES UPDATE
   ========================================= */
if (isset($_POST['update_galeri'])) {
    $id = (int)$_POST['id'];
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $tgl = $_POST['tanggal_upload'];
    $gambar_lama = $_POST['gambar_lama'];

    if (!empty($_FILES['gambar']['name'])) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $gambar_baru = time() . '_' . rand(100, 999) . '.' . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], $folder_upload . $gambar_baru);
        if ($gambar_lama && file_exists($folder_upload . $gambar_lama)) {
            unlink($folder_upload . $gambar_lama);
        }
    } else {
        $gambar_baru = $gambar_lama;
    }

    mysqli_query($koneksi, "UPDATE galeri SET judul='$judul', deskripsi='$deskripsi', gambar='$gambar_baru', tanggal_upload='$tgl' WHERE id='$id'");
    echo "<script>alert('Data berhasil diperbarui');window.location='data_galeri.php';</script>";
    exit;
}

/* ========================================= 
   3. PROSES HAPUS 
   ========================================= */
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $query_foto = mysqli_query($koneksi, "SELECT gambar FROM galeri WHERE id='$id'");
    $data_foto = mysqli_fetch_assoc($query_foto);

    if ($data_foto) {
        if (!empty($data_foto['gambar']) && file_exists($folder_upload . $data_foto['gambar'])) {
            unlink($folder_upload . $data_foto['gambar']);
        }
        mysqli_query($koneksi, "DELETE FROM galeri WHERE id='$id'");
        echo "<script>alert('Data dihapus');window.location='data_galeri.php';</script>";
    }
    exit;
}

$data_edit = null;
if (isset($_GET['edit'])) {
    $id_edit = (int)$_GET['edit'];
    $q_edit = mysqli_query($koneksi, "SELECT * FROM galeri WHERE id='$id_edit'");
    $data_edit = mysqli_fetch_assoc($q_edit);
}

$limit = 5;
$halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($halaman - 1) * $limit;
$resTotal = mysqli_query($koneksi, "SELECT id FROM galeri");
$totalData = mysqli_num_rows($resTotal);
$totalHalaman = ceil($totalData / $limit);
$data = mysqli_query($koneksi, "SELECT * FROM galeri ORDER BY id DESC LIMIT $limit OFFSET $offset");
?>

<main class="app-main">
    <div class="container-fluid pt-4">
        <?php if ($data_edit) : ?>
        <div class="card shadow mb-4 border-warning">
            <div class="card-header bg-warning text-white">
                <h3 class="card-title">Edit Galeri: <?= htmlspecialchars($data_edit['judul']); ?></h3>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <input type="hidden" name="id" value="<?= $data_edit['id']; ?>">
                    <input type="hidden" name="gambar_lama" value="<?= $data_edit['gambar']; ?>">
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Judul</label><input type="text" name="judul" class="form-control" value="<?= $data_edit['judul']; ?>" required></div>
                        <div class="col-md-6 mb-3"><label>Tanggal</label><input type="date" name="tanggal_upload" class="form-control" value="<?= $data_edit['tanggal_upload']; ?>" required></div>
                        <div class="col-md-12 mb-3"><label>Deskripsi</label><textarea name="deskripsi" class="form-control editor" rows="3"><?= $data_edit['deskripsi']; ?></textarea></div>
                        <div class="col-md-6 mb-3"><label>Ganti Gambar</label><input type="file" name="gambar" class="form-control" accept="image/*"></div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="update_galeri" class="btn btn-warning">Simpan Perubahan</button>
                    <a href="data_galeri.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h3 class="card-title m-0 text-bold">Daftar Galeri</h3>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-plus-lg"></i> Tambah Galeri
                </button>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th width="120">Gambar</th>
                            <th width="120">Tanggal</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = $offset + 1;
                        while ($d = mysqli_fetch_array($data)) :
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><strong><?= htmlspecialchars($d['judul']); ?></strong></td>
                            <td><?= substr(strip_tags($d['deskripsi']), 0, 80); ?>...</td>
                            <td class="text-center">
                                <?php if (!empty($d['gambar']) && file_exists($folder_upload . $d['gambar'])) : ?>
                                    <img src="<?= $folder_upload . $d['gambar']; ?>" width="80" class="rounded">
                                <?php else : ?>
                                    <span class="badge bg-secondary">No Image</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><?= date('d/m/Y', strtotime($d['tanggal_upload'])); ?></td>
                            <td class="text-center">
                                <a href="?edit=<?= $d['id']; ?>" class="btn btn-sm btn-warning mb-1"><i class="bi bi-pencil"></i></a>
                                <a href="?hapus=<?= $d['id']; ?>" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Hapus data?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Data Galeri</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Galeri</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control editor" rows="5"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Upload Gambar</label>
                                <input type="file" name="gambar" class="form-control" accept="image/*" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tanggal_upload" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="simpan_galeri" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php include "template/footer.php"; ?>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    // FIX: Hilangkan Bar Merah
    CKEDITOR.config.versionCheck = false;

    document.querySelectorAll('.editor').forEach(el => {
        CKEDITOR.replace(el);
    });
</script>