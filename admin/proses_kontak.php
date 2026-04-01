<?php

include "../koneksi.php";

// ambil data dari form
$nama = $_POST['nama'];
$email = $_POST['email'];
$pesan = $_POST['pesan'];
$tanggal_kirim = $_POST['tanggal_kirim'];

// query insert TANPA kolom id
$query = "INSERT INTO kontak (nama, email, pesan, tanggal_kirim)
          VALUES ('$nama', '$email', '$pesan', '$tanggal_kirim')";

mysqli_query($koneksi, $query);

// redirect
header("Location: data_kontak.php");
exit;
?>
