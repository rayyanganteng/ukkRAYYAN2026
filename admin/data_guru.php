<?php
include "template/header.php";
include "template/menu.php";
include "../koneksi.php";

/* ========================= 
   1. PROSES SIMPAN DATA (Pindahan dari input_guru.php)
   ========================= */
if (isset($_POST['simpan'])) {
    $nama_guru     = $_POST['nama_guru'];
    $nip           = $_POST['nip'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $mapel         = $_POST['mapel'];
    $email         = $_POST['email'];
    $no_hp         = $_POST['no_hp'];
    
    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . '_' . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], 'upload/' . $foto);
    }
    
    $query = "INSERT INTO guru (nama_guru, nip, jenis_kelamin, mapel, foto, email, no_hp) 
              VALUES ('$nama_guru','$nip','$jenis_kelamin','$mapel','$foto','$email','$no_hp')";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data guru berhasil disimpan');window.location='data_guru.php';</script>";
    }
    exit;
}

/* ========================= 
   2. PROSES HAPUS DATA 
   ========================= */
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $q = mysqli_query($koneksi, "SELECT foto FROM guru WHERE id='$id'");
    $d = mysqli_fetch_assoc($q);
    if ($d) {
        if (!empty($d['foto']) && file_exists("upload/" . $d['foto'])) {
            unlink("upload/" . $d['foto']);
        }
        mysqli_query($koneksi, "DELETE FROM guru WHERE id='$id'");
    }
    echo "<script>alert('Data guru berhasil dihapus');window.location='data_guru.php';</script>";
    exit;
}

/* ========================= 
   3. PROSES EDIT DATA 
   ========================= */
if (isset($_POST['edit'])) {
    $id            = $_POST['id'];
    $nama_guru     = $_POST['nama_guru'];
    $nip           = $_POST['nip'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $mapel         = $_POST['mapel'];
    $email         = $_POST['email'];
    $no_hp         = $_POST['no_hp'];
    $foto_lama     = $_POST['foto_lama'];

    if (!empty($_FILES['foto']['name'])) {
        $foto_baru = time() . '_' . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], 'upload/' . $foto_baru);
        if (!empty($foto_lama) && file_exists("upload/" . $foto_lama)) {
            unlink("upload/" . $foto_lama);
        }
    } else {
        $foto_baru = $foto_lama;
    }

    mysqli_query($koneksi, "UPDATE guru SET 
        nama_guru='$nama_guru', nip='$nip', jenis_kelamin='$jenis_kelamin', 
        mapel='$mapel', foto='$foto_baru', email='$email', no_hp='$no_hp' 
        WHERE id='$id'");
    
    echo "<script>alert('Data guru berhasil diupdate');window.location='data_guru.php';</script>";
    exit;
}

/* ========================= 
   4. PAGINATION & DATA FETCHING
   ========================= */
$limit = 5;
$halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$halaman = ($halaman < 1) ? 1 : $halaman;
$offset = ($halaman - 1) * $limit;
$totalData = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM guru"));
$totalHalaman = ceil($totalData / $limit);
$data = mysqli_query($koneksi, "SELECT * FROM guru ORDER BY id DESC LIMIT $limit OFFSET $offset");
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"><h3 class="mb-0">Data Guru</h3></div>
                <div class="col-sm-6 text-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle"></i> Tambah Guru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Guru</h3>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Guru</th>
                                <th>NIP</th>
                                <th>JK</th>
                                <th>Mapel</th>
                                <th>Foto</th>
                                <th>Email</th>
                                <th>No HP</th>
                                <th width="120" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = $offset + 1;
                            if (mysqli_num_rows($data) > 0) {
                                while ($d = mysqli_fetch_assoc($data)) {
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($d['nama_guru']); ?></td>
                                    <td><?= $d['nip']; ?></td>
                                    <td><?= $d['jenis_kelamin']; ?></td>
                                    <td><?= $d['mapel']; ?></td>
                                    <td>
                                        <?php if ($d['foto']) { ?>
                                            <img src="upload/<?= $d['foto']; ?>" width="60" class="img-thumbnail">
                                        <?php } else { echo "-"; } ?>
                                    </td>
                                    <td><?= $d['email']; ?></td>
                                    <td><?= $d['no_hp']; ?></td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $d['id']; ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <a href="?hapus=<?= $d['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="edit<?= $d['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="post" enctype="multipart/form-data">
                                                <div class="modal-header bg-warning">
                                                    <h5 class="modal-title">Edit Data Guru</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?= $d['id']; ?>">
                                                    <input type="hidden" name="foto_lama" value="<?= $d['foto']; ?>">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Nama Guru</label>
                                                            <input type="text" name="nama_guru" class="form-control" value="<?= $d['nama_guru']; ?>" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">NIP</label>
                                                            <input type="text" name="nip" class="form-control" value="<?= $d['nip']; ?>">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Jenis Kelamin</label>
                                                            <select name="jenis_kelamin" class="form-select">
                                                                <option <?= ($d['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                                                <option <?= ($d['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Mata Pelajaran</label>
                                                            <input type="text" name="mapel" class="form-control" value="<?= $d['mapel']; ?>">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" name="email" class="form-control" value="<?= $d['email']; ?>">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label class="form-label">No HP</label>
                                                            <input type="text" name="no_hp" class="form-control" value="<?= $d['no_hp']; ?>">
                                                        </div>
                                                        <div class="col-md-12 mb-3">
                                                            <label class="form-label">Ganti Foto</label><br>
                                                            <?php if($d['foto']) { ?>
                                                                <img src="upload/<?= $d['foto']; ?>" width="80" class="mb-2 border">
                                                            <?php } ?>
                                                            <input type="file" name="foto" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="edit" class="btn btn-warning">Update Data</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php 
                                } 
                            } else {
                                echo "<tr><td colspan='9' class='text-center'>Data kosong</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    <ul class="pagination pagination-sm m-0 float-end">
                        <?php for ($i = 1; $i <= $totalHalaman; $i++) { ?>
                            <li class="page-item <?= ($i == $halaman) ? 'active' : ''; ?>">
                                <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Tambah Guru Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Guru</label>
                            <input type="text" name="nama_guru" class="form-control" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control" placeholder="Nomor Induk Pegawai">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mata Pelajaran</label>
                            <input type="text" name="mapel" class="form-control" placeholder="Contoh: Matematika" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email@sekolah.com">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No HP</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="08xxxx">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Foto Guru</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "template/footer.php"; ?>