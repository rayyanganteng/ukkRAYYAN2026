<?php

include "template/header.php";
include "template/menu.php";
include "../koneksi.php"; // Pastikan path ke koneksi benar

// ================= PROSES SIMPAN =================
if (isset($_POST['simpan'])) {
    // 1. Ambil & Bersihkan Input
    $judul          = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi      = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $tanggal_upload = $_POST['tanggal_upload'];

    // 2. Persiapan Upload Gambar
    $filename = ""; 
    
    // Cek apakah user memilih gambar
    if (!empty($_FILES['gambar']['name'])) {
        $nama_file_asli = $_FILES['gambar']['name'];
        $tmp_file       = $_FILES['gambar']['tmp_name'];
        
        // Buat nama unik agar tidak bentrok (timestamp + angka random)
        $ext        = pathinfo($nama_file_asli, PATHINFO_EXTENSION);
        $filename   = time() . "_" . rand(100, 999) . "." . $ext;
        
        // Tentukan lokasi folder (NAIK satu folder dari 'admin' lalu masuk 'upload/galeri')
        $folder_tujuan = "../upload/galeri/";
        
        // Validasi folder: Jika belum ada, buat foldernya
        if (!is_dir($folder_tujuan)) {
            mkdir($folder_tujuan, 0777, true);
        }

        // 3. Proses Upload
        if (move_uploaded_file($tmp_file, $folder_tujuan . $filename)) {
            // Jika upload berhasil, simpan ke Database
            $query = "INSERT INTO galeri (judul, deskripsi, gambar, tanggal_upload) 
                      VALUES ('$judul', '$deskripsi', '$filename', '$tanggal_upload')";
            
            $simpan = mysqli_query($koneksi, $query);

            if ($simpan) {
                echo "<script>alert('Data Berhasil Disimpan!'); window.location='data_galeri.php';</script>";
            } else {
                echo "<script>alert('Gagal simpan ke database: " . mysqli_error($koneksi) . "');</script>";
            }
        } else {
            echo "<script>alert('Gagal upload gambar! Periksa permission folder upload.');</script>";
        }
    } else {
        echo "<script>alert('Harap pilih gambar terlebih dahulu!');</script>";
    }
}
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Input Galeri</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="hal_admin.php">Home</a></li>
                        <li class="breadcrumb-item active">Input Galeri</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Form Input Galeri</h3>
                </div>
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label class="form-label">Judul Galeri</label>
                            <input type="text" name="judul" class="form-control" placeholder="Masukkan Judul" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="editor" class="form-control" rows="5" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" required>
                            <small class="text-muted">Format: JPG, JPEG, PNG</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Upload</label>
                            <input type="date" name="tanggal_upload" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="data_galeri.php" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" name="simpan" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Data
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include "template/footer.php"; ?>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>