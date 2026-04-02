<?php
session_start();
if (!isset($_SESSION['status']) || $_SESSION['status'] != "login") {
    header("location:index.php?pesan=belum_login");
    exit;
}

include "../koneksi.php";

/* ==========================================
   1. LOGIKA PROSES SIMPAN (INSERT)
   ========================================== */
if (isset($_POST['simpan_sekolah'])) {
    $nama_sekolah   = $_POST['nama_sekolah'];
    $npsn           = $_POST['npsn'];
    $alamat         = $_POST['alamat'];
    $desa           = $_POST['desa'];
    $kecamatan      = $_POST['kecamatan'];
    $kabupaten      = $_POST['kabupaten'];
    $provinsi       = $_POST['provinsi'];
    $email          = $_POST['email'];
    $telepon        = $_POST['telepon'];
    $website        = $_POST['website'];
    $kepala_sekolah = $_POST['kepala_sekolah'];
    $visi           = $_POST['visi'];
    $misi           = $_POST['misi'];
    $deskripsi      = $_POST['deskripsi'];

    $logo = 'default.png';
    if (!empty($_FILES['logo']['name'])) {
        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array(strtolower($ext), $allowed)) {
            $logo = time() . '_' . $_FILES['logo']['name'];
            move_uploaded_file($_FILES['logo']['tmp_name'], 'upload/' . $logo);
        }
    }

    $stmt = $koneksi->prepare("INSERT INTO profil_sekolah (nama_sekolah, npsn, alamat, desa, kecamatan, kabupaten, provinsi, email, telepon, website, kepala_sekolah, logo, visi, misi, deskripsi) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssssssss", $nama_sekolah, $npsn, $alamat, $desa, $kecamatan, $kabupaten, $provinsi, $email, $telepon, $website, $kepala_sekolah, $logo, $visi, $misi, $deskripsi);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil disimpan'); window.location='data_sekolah.php';</script>";
    }
}

/* ==========================================
   2. LOGIKA PROSES UPDATE
   ========================================== */
if (isset($_POST['update_sekolah'])) {
    $id             = $_POST['id'];
    $logo_lama      = $_POST['logo_lama'];
    $nama_sekolah   = $_POST['nama_sekolah'];
    $npsn           = $_POST['npsn'];
    $alamat         = $_POST['alamat'];
    $desa           = $_POST['desa'];
    $kecamatan      = $_POST['kecamatan'];
    $kabupaten      = $_POST['kabupaten'];
    $provinsi       = $_POST['provinsi'];
    $email          = $_POST['email'];
    $telepon        = $_POST['telepon'];
    $website        = $_POST['website'];
    $kepala_sekolah = $_POST['kepala_sekolah'];
    $visi           = $_POST['visi'];
    $misi           = $_POST['misi'];
    $deskripsi      = $_POST['deskripsi'];

    if (!empty($_FILES['logo']['name'])) {
        $logo_baru = time() . '_' . $_FILES['logo']['name'];
        move_uploaded_file($_FILES['logo']['tmp_name'], "upload/" . $logo_baru);
        if ($logo_lama != 'default.png' && file_exists("upload/" . $logo_lama)) {
            unlink("upload/" . $logo_lama);
        }
    } else {
        $logo_baru = $logo_lama;
    }

    $stmt = $koneksi->prepare("UPDATE profil_sekolah SET nama_sekolah=?, npsn=?, alamat=?, desa=?, kecamatan=?, kabupaten=?, provinsi=?, email=?, telepon=?, website=?, kepala_sekolah=?, logo=?, visi=?, misi=?, deskripsi=? WHERE id=?");
    $stmt->bind_param("sssssssssssssssi", $nama_sekolah, $npsn, $alamat, $desa, $kecamatan, $kabupaten, $provinsi, $email, $telepon, $website, $kepala_sekolah, $logo_baru, $visi, $misi, $deskripsi, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil diperbarui'); window.location='data_sekolah.php';</script>";
    }
}

/* ==========================================
   3. LOGIKA PROSES HAPUS
   ========================================== */
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $res = mysqli_query($koneksi, "SELECT logo FROM profil_sekolah WHERE id='$id'");
    $d = mysqli_fetch_assoc($res);
    if ($d && $d['logo'] != 'default.png' && file_exists("upload/" . $d['logo'])) {
        unlink("upload/" . $d['logo']);
    }
    mysqli_query($koneksi, "DELETE FROM profil_sekolah WHERE id='$id'");
    echo "<script>alert('Data dihapus'); window.location='data_sekolah.php';</script>";
}

$edit = null;
if (isset($_GET['edit'])) {
    $id_edit = (int)$_GET['edit'];
    $q_edit = mysqli_query($koneksi, "SELECT * FROM profil_sekolah WHERE id='$id_edit'");
    $edit = mysqli_fetch_assoc($q_edit);
}

$data = mysqli_query($koneksi, "SELECT * FROM profil_sekolah ORDER BY id DESC");

include "template/header.php";
include "template/menu.php";
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0">Manajemen Profil Sekolah</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Profil Baru
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <?php if ($edit) : ?>
                <div class="card mb-4 shadow-sm border-warning">
                    <div class="card-header bg-warning">
                        <h3 class="card-title text-dark fw-bold">Edit Profil: <?= htmlspecialchars($edit['nama_sekolah']); ?></h3>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <input type="hidden" name="id" value="<?= $edit['id']; ?>">
                            <input type="hidden" name="logo_lama" value="<?= $edit['logo']; ?>">
                            <div class="row">
                                <div class="col-md-6 mb-3"><label class="fw-bold">Nama Sekolah</label><input type="text" name="nama_sekolah" class="form-control" value="<?= $edit['nama_sekolah']; ?>" required></div>
                                <div class="col-md-6 mb-3"><label class="fw-bold">NPSN</label><input type="text" name="npsn" class="form-control" value="<?= $edit['npsn']; ?>"></div>
                                <div class="col-md-12 mb-3"><label class="fw-bold">Alamat Lengkap</label><input type="text" name="alamat" class="form-control" value="<?= $edit['alamat']; ?>"></div>
                                <div class="col-md-3 mb-3"><label class="fw-bold">Desa</label><input type="text" name="desa" class="form-control" value="<?= $edit['desa']; ?>"></div>
                                <div class="col-md-3 mb-3"><label class="fw-bold">Kecamatan</label><input type="text" name="kecamatan" class="form-control" value="<?= $edit['kecamatan']; ?>"></div>
                                <div class="col-md-3 mb-3"><label class="fw-bold">Kabupaten</label><input type="text" name="kabupaten" class="form-control" value="<?= $edit['kabupaten']; ?>"></div>
                                <div class="col-md-3 mb-3"><label class="fw-bold">Provinsi</label><input type="text" name="provinsi" class="form-control" value="<?= $edit['provinsi']; ?>"></div>
                                <div class="col-md-4 mb-3"><label class="fw-bold">Email</label><input type="email" name="email" class="form-control" value="<?= $edit['email']; ?>"></div>
                                <div class="col-md-4 mb-3"><label class="fw-bold">Telepon</label><input type="text" name="telepon" class="form-control" value="<?= $edit['telepon']; ?>"></div>
                                <div class="col-md-4 mb-3"><label class="fw-bold">Website</label><input type="text" name="website" class="form-control" value="<?= $edit['website']; ?>"></div>
                                <div class="col-md-6 mb-3"><label class="fw-bold">Kepala Sekolah</label><input type="text" name="kepala_sekolah" class="form-control" value="<?= $edit['kepala_sekolah']; ?>"></div>
                                <div class="col-md-6 mb-3"><label class="fw-bold">Ganti Logo</label><input type="file" name="logo" class="form-control"></div>
                                <div class="col-md-6 mb-3"><label class="fw-bold">Visi</label><textarea name="visi" id="edit_visi" class="form-control"><?= $edit['visi']; ?></textarea></div>
                                <div class="col-md-6 mb-3"><label class="fw-bold">Misi</label><textarea name="misi" id="edit_misi" class="form-control"><?= $edit['misi']; ?></textarea></div>
                                <div class="col-12 mb-3"><label class="fw-bold">Deskripsi Sekolah</label><textarea name="deskripsi" id="edit_desk" class="form-control"><?= $edit['deskripsi']; ?></textarea></div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="data_sekolah.php" class="btn btn-secondary">Batal</a>
                            <button type="submit" name="update_sekolah" class="btn btn-success">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="ps-3">Logo</th>
                                <th>Informasi Dasar</th>
                                <th>Lokasi & Kontak</th>
                                <th>Visi, Misi & Deskripsi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($d = mysqli_fetch_assoc($data)) : ?>
                                <tr>
                                    <td class="ps-3" width="100px">
                                        <img src="upload/<?= $d['logo']; ?>" class="img-thumbnail rounded shadow-sm" style="height: 80px; width: 80px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <div class="fw-bold fs-6 text-primary"><?= $d['nama_sekolah']; ?></div>
                                        <div class="small text-muted mb-1">NPSN: <strong><?= $d['npsn']; ?></strong></div>
                                        <div class="small">Kepala Sekolah:<br><span class="fw-bold text-dark"><?= $d['kepala_sekolah']; ?></span></div>
                                    </td>
                                    <td>
                                        <div class="small mb-2">
                                            <i class="bi bi-geo-alt-fill text-danger"></i> <?= $d['alamat']; ?>, <?= $d['desa']; ?>, <?= $d['kecamatan']; ?>
                                        </div>
                                        <div class="small">
                                            <i class="bi bi-envelope-at me-1"></i> <?= $d['email']; ?><br>
                                            <i class="bi bi-telephone me-1"></i> <?= $d['telepon']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $d['id'] ?>">
                                            <i class="bi bi-eye me-1"></i> Lihat Detail Isi
                                        </button>

                                        <div class="modal fade" id="modalDetail<?= $d['id'] ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Detail Konten: <?= $d['nama_sekolah'] ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6 class="fw-bold text-primary">Visi:</h6>
                                                        <div class="border p-3 rounded bg-light mb-3"><?= $d['visi'] ?></div>

                                                        <h6 class="fw-bold text-primary">Misi:</h6>
                                                        <div class="border p-3 rounded bg-light mb-3"><?= $d['misi'] ?></div>

                                                        <h6 class="fw-bold text-primary">Deskripsi:</h6>
                                                        <div class="border p-3 rounded bg-light"><?= $d['deskripsi'] ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group shadow-sm">
                                            <a href="?edit=<?= $d['id']; ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                            <a href="?hapus=<?= $d['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini? Semua data terkait akan hilang.')" class="btn btn-sm btn-danger" title="Hapus"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                            <?php if (mysqli_num_rows($data) == 0): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted small">Belum ada data profil sekolah. Silakan klik tombol "Tambah Profil" di atas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Profil Sekolah Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="post" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3"><label class="fw-bold">Nama Sekolah</label><input type="text" name="nama_sekolah" class="form-control" placeholder="Contoh: SMK Ganesha Tama Boyolali" required></div>
                        <div class="col-md-6 mb-3"><label class="fw-bold">NPSN</label><input type="text" name="npsn" class="form-control" placeholder="Nomor Pokok Sekolah Nasional"></div>
                        <div class="col-md-12 mb-3"><label class="fw-bold">Alamat Lengkap</label><textarea name="alamat" class="form-control" rows="2" placeholder="Jl. Raya No..."></textarea></div>
                        <div class="col-md-3 mb-3"><label class="fw-bold">Desa</label><input type="text" name="desa" class="form-control"></div>
                        <div class="col-md-3 mb-3"><label class="fw-bold">Kecamatan</label><input type="text" name="kecamatan" class="form-control"></div>
                        <div class="col-md-3 mb-3"><label class="fw-bold">Kabupaten</label><input type="text" name="kabupaten" class="form-control"></div>
                        <div class="col-md-3 mb-3"><label class="fw-bold">Provinsi</label><input type="text" name="provinsi" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label class="fw-bold">Email</label><input type="email" name="email" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label class="fw-bold">Telepon</label><input type="text" name="telepon" class="form-control"></div>
                        <div class="col-md-4 mb-3"><label class="fw-bold">Website</label><input type="text" name="website" class="form-control" placeholder="www.sekolah.sch.id"></div>
                        <div class="col-md-6 mb-3"><label class="fw-bold">Kepala Sekolah</label><input type="text" name="kepala_sekolah" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label class="fw-bold">Logo Sekolah</label><input type="file" name="logo" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label class="fw-bold text-primary">Visi</label><textarea name="visi" id="add_visi" class="form-control"></textarea></div>
                        <div class="col-md-6 mb-3"><label class="fw-bold text-primary">Misi</label><textarea name="misi" id="add_misi" class="form-control"></textarea></div>
                        <div class="col-12 mb-3"><label class="fw-bold text-primary">Deskripsi Lengkap Sekolah</label><textarea name="deskripsi" id="add_desk" class="form-control"></textarea></div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" name="simpan_sekolah" class="btn btn-primary px-4">Simpan Profil Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "template/footer.php"; ?>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.config.versionCheck = false;

    // Inisialisasi CKEditor untuk Modal Tambah
    CKEDITOR.replace('add_visi');
    CKEDITOR.replace('add_misi');
    CKEDITOR.replace('add_desk');

    // Inisialisasi CKEditor untuk Section Edit
    if (document.getElementById('edit_visi')) {
        CKEDITOR.replace('edit_visi');
        CKEDITOR.replace('edit_misi');
        CKEDITOR.replace('edit_desk');
    }
</script>