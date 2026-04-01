<?php include "template/header.php"; ?>
<?php include "../koneksi.php"; ?>

<?php
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM berita WHERE id='$id'");
$d = mysqli_fetch_assoc($data);
?>

<h3><?= $d['judul']; ?></h3>
<p><?= $d['isi']; ?></p>

<a href="berita.php" class="btn btn-secondary">Kembali</a>

<?php include "template/footer.php"; ?>