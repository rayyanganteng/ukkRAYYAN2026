<?php include "template/header.php"; ?>
<?php include __DIR__ . "/../koneksi.php"; ?>

<style>
.profil-card {
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    background: white;
}

.profil-header {
    text-align: center;
}

.profil-header img {
    max-height: 120px;
    margin-bottom: 15px;
}

.section-title {
    margin-top: 30px;
    border-left: 5px solid #1E3A8A;
    padding-left: 10px;
    font-weight: bold;
}
</style>

<?php
$data = mysqli_query($koneksi, "SELECT * FROM profil_sekolah LIMIT 1");
$p = mysqli_fetch_assoc($data);
?>

<div class="container mt-4">

    <div class="profil-card">

        <!-- HEADER -->
        <div class="profil-header">
            <img src="admin/upload/<?= $p['logo'] ?: 'default.png'; ?>">
            <h3 class="fw-bold"><?= $p['nama_sekolah']; ?></h3>
            <p class="text-muted">NPSN: <?= $p['npsn']; ?></p>
        </div>

        <hr>

        <!-- INFO -->
        <div class="row">
            <div class="col-md-6">
                <p><b>Email:</b> <?= $p['email']; ?></p>
                <p><b>Telepon:</b> <?= $p['telepon']; ?></p>
                <p><b>Website:</b> <?= $p['website']; ?></p>
            </div>

            <div class="col-md-6">
                <p><b>Kepala Sekolah:</b> <?= $p['kepala_sekolah']; ?></p>
                <p><b>Provinsi:</b> <?= $p['provinsi']; ?></p>
                <p><b>Kabupaten:</b> <?= $p['kabupaten']; ?></p>
            </div>
        </div>

        <!-- ALAMAT -->
        
        <!-- VISI -->
        <h5 class="section-title">Visi</h5>
        <p><?= $p['visi']; ?></p>
        
        <!-- MISI -->
        <h5 class="section-title">Misi</h5>
        <p><?= $p['misi']; ?></p>
        
        <!-- DESKRIPSI -->
        <h5 class="section-title">Deskripsi Sekolah</h5>
        <p><?= $p['deskripsi']; ?></p>
        
        <h5 class="section-title">Alamat</h5>
        <p>
            <?= $p['alamat']; ?>, <?= $p['desa']; ?>, 
            <?= $p['kecamatan']; ?>, <?= $p['kabupaten']; ?>, <?= $p['provinsi']; ?>
        </p>
    </div>

</div>

<?php include "template/footer.php"; ?>