<?php include "template/header.php"; ?>
<?php include __DIR__ . "/../koneksi.php"; ?>

<h3>Kontak Kami</h3>

<form method="post">
<input type="text" name="nama" class="form-control mb-2" placeholder="Nama" required>
<input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
<textarea name="pesan" class="form-control mb-2" placeholder="Pesan"></textarea>

<button class="btn btn-primary">Kirim</button>
</form>

<?php
if($_POST){
  mysqli_query($koneksi,"INSERT INTO kontak VALUES(NULL,'$_POST[nama]','$_POST[email]','$_POST[pesan]')");
  echo "<div class='alert alert-success mt-2'>Pesan terkirim</div>";
}
?>

<?php include "template/footer.php"; ?>