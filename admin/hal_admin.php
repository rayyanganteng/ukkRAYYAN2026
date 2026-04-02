<?php
session_start();
if ($_SESSION['status'] != "login") {
  header("location:../index.php?pesan=belum_login");
  exit;
}

include "template/header.php";
include "template/menu.php";
include "../koneksi.php";

// ================= HITUNG DATA =================
$jml_guru    = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM guru"));
$jml_berita  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM berita"));
$jml_galeri  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM galeri"));
$jml_kontak  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kontak"));
$jml_profil  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM profil_sekolah"));

// ================= DATA TERBARU =================
$berita_terbaru = mysqli_query($koneksi, "SELECT * FROM berita ORDER BY id DESC LIMIT 5");
?>

<main class="app-main">

  <!-- HEADER -->
  <div class="app-content-header">
    <div class="container-fluid">
      <h3>Dashboard Admin</h3>
      <small>Halo <?= $_SESSION['username']; ?> 👋</small>
    </div>
  </div>

  <div class="container-fluid">

    <!-- INFO BOX -->
    <div class="row">

      <?php
      function box($color, $title, $value, $icon)
      {
      ?>
        <div class="col-lg-3 col-6 mb-3">
          <div class="p-3 rounded text-white bg-<?= $color ?>">
            <div class="d-flex justify-content-between">
              <div>
                <h3><?= $value ?></h3>
                <p><?= $title ?></p>
              </div>
              <i class="bi <?= $icon ?> fs-1"></i>
            </div>
          </div>
        </div>
      <?php } ?>

      <?php
      box("success", "Data Guru", $jml_guru, "bi-person-fill");
      box("info", "Data Berita", $jml_berita, "bi-newspaper");
      box("warning", "Galeri", $jml_galeri, "bi-image");
      box("danger", "Kontak", $jml_kontak, "bi-envelope");
      box("secondary", "Profil", $jml_profil, "bi-building");
      ?>

    </div>

    <!-- GRAFIK -->
    <div class="card shadow-sm mt-3">
      <div class="card-header">Statistik Data</div>
      <div class="card-body">
        <canvas id="chart"></canvas>
      </div>
    </div>

    <!-- JAM -->
    <div class="card mt-3">
      <div class="card-body text-center">
        <h5 id="clock"></h5>
      </div>
    </div>

    <!-- BERITA TERBARU -->
    <div class="card mt-3 shadow-sm">
      <div class="card-header">Berita Terbaru</div>
      <div class="card-body">
        <ul class="list-group">
          <?php while ($b = mysqli_fetch_assoc($berita_terbaru)) { ?>
            <li class="list-group-item">
              <?= $b['judul']; ?>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>

  </div>
</main>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // grafik
  new Chart(document.getElementById('chart'), {
    type: 'bar',
    data: {
      labels: ['Guru', 'Berita', 'Galeri', 'Kontak', 'Profil'],
      datasets: [{
        label: 'Jumlah Data',
        data: [
          <?= $jml_guru ?>,
          <?= $jml_berita ?>,
          <?= $jml_galeri ?>,
          <?= $jml_kontak ?>,
          <?= $jml_profil ?>
        ]
      }]
    }
  });

  // jam realtime
  function updateClock() {
    document.getElementById("clock").innerHTML = new Date().toLocaleString();
  }
  setInterval(updateClock, 1000);
  updateClock();
</script>

<?php include "template/footer.php"; ?>