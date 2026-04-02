<?php
session_start();
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Akses tidak valid!");
}

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = $_POST['password'];

// Query mencari user (Case Insensitive)
$query  = "SELECT * FROM admin WHERE LOWER(username) = LOWER('$username')";
$result = mysqli_query($koneksi, $query);

if ($user = mysqli_fetch_assoc($result)) {
    // Verifikasi Password Hash
    if (password_verify($password, $user['password'])) {
        
        session_regenerate_id(true);
        $_SESSION['username'] = $user['username'];
        $_SESSION['status']   = "login";
        
        unset($_SESSION['csrf_token']);
        header("Location: hal_admin.php");
        exit;
    }
}

// Jika gagal, arahkan kembali ke index.php
header("Location: index.php?pesan=gagal");
exit;