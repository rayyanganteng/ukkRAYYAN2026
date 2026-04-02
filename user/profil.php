<?php 
include "template/header.php"; 
include_once __DIR__ . "/../koneksi.php"; 

$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]/ahmad_xii/";
$upload_url = $base_url . "admin/upload/";

$query = mysqli_query($koneksi, "SELECT * FROM profil_sekolah LIMIT 1");
$p = mysqli_fetch_assoc($query);

if (!$p) {
    echo "<div class='container my-5 text-center'><p class='text-muted'>Data profil belum tersedia.</p></div>";
    include "template/footer.php";
    exit;
}
?>

<style>
:root {
    --primary: #1E3A8A;
    --secondary: #3B82F6;
    --bg: #F8FAFC;
    --text: #1E293B;
    --muted: #64748B;
}

body {
    background: var(--bg);
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* HERO */
.hero {
    background: linear-gradient(135deg, #1E3A8A, #3B82F6);
    color: white;
    text-align: center;
    padding: 120px 20px 80px;
}

.logo-box {
    width: 130px;
    height: 130px;
    margin: auto;
    background: white;
    border-radius: 30px;
    padding: 15px;
    margin-bottom: 20px;
}

.hero h1 {
    font-size: 3rem;
    font-weight: 800;
}

.btn-scroll {
    margin-top: 20px;
    background: white;
    color: var(--primary);
    border-radius: 50px;
    padding: 10px 25px;
    font-weight: 600;
}

/* QUICK INFO */
.quick-info {
    margin-top: -50px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
    gap: 20px;
    padding: 0 20px;
}

.quick-card {
    background: white;
    border-radius: 20px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    transition: .3s;
}

.quick-card:hover {
    transform: translateY(-5px);
}

/* CONTENT */
.container-main {
    max-width: 1100px;
    margin: auto;
    padding: 60px 20px;
}

.card-main {
    background: white;
    border-radius: 30px;
    padding: 50px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.section-title {
    font-size: 0.8rem;
    font-weight: 800;
    letter-spacing: 2px;
    color: var(--secondary);
    margin-bottom: 20px;
    display: block;
}

/* DESKRIPSI */
.deskripsi {
    line-height: 1.8;
    font-size: 1.1rem;
}

.deskripsi p {
    margin-bottom: 15px;
}

/* VISI MISI */
.vimi {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px,1fr));
    gap: 30px;
    margin-top: 40px;
}

.vimi-card {
    background: #F1F5F9;
    border-radius: 25px;
    padding: 30px;
    transition: .3s;
}

.vimi-card:hover {
    transform: translateY(-5px);
}

.vimi-card.visi {
    background: linear-gradient(135deg, #1E3A8A, #3B82F6);
    color: white;
}

/* VISI TEXT */
.visi-text {
    font-size: 1.2rem;
    font-weight: 600;
    line-height: 1.7;
}

/* MISI LIST */
.misi-list ol {
    padding-left: 20px;
    margin: 0;
}

.misi-list li {
    margin-bottom: 10px;
    line-height: 1.7;
}

/* FOOTER */
.footer-profil {
    margin-top: 50px;
    padding-top: 30px;
    border-top: 1px solid #eee;
    text-align: center;
    color: var(--muted);
}

/* ANIMASI */
.fade {
    opacity: 0;
    transform: translateY(20px);
    transition: .6s;
}

.fade.show {
    opacity: 1;
    transform: translateY(0);
}

@media(max-width:768px){
    .hero h1 { font-size: 2.2rem; }
    .card-main { padding: 30px; }
}
</style>

<!-- HERO -->
<section class="hero">
    <div class="logo-box">
        <img src="<?= $upload_url . ($p['logo'] ?: 'default.png') ?>" 
             style="width:100%;height:100%;object-fit:contain;">
    </div>

    <h1><?= htmlspecialchars($p['nama_sekolah']); ?></h1>
    <p>Boyolali, Jawa Tengah</p>

    <a href="#profil" class="btn btn-scroll">Lihat Profil ↓</a>
</section>

<!-- QUICK INFO -->
<div class="quick-info">
    <div class="quick-card">
        <strong>Kepala Sekolah</strong>
        <p><?= htmlspecialchars($p['kepala_sekolah']); ?></p>
    </div>
    <div class="quick-card">
        <strong>NPSN</strong>
        <p><?= htmlspecialchars($p['npsn']); ?></p>
    </div>
    <div class="quick-card">
        <strong>Email</strong>
        <p><?= htmlspecialchars($p['email']); ?></p>
    </div>
    <div class="quick-card">
        <strong>Website</strong>
        <p><?= htmlspecialchars($p['website']); ?></p>
    </div>
</div>

<!-- MAIN -->
<div class="container-main" id="profil">
    <div class="card-main fade">

        <!-- DESKRIPSI -->
        <span class="section-title">Tentang Sekolah</span>
        <div class="deskripsi">
            <?= $p['deskripsi']; ?>
        </div>

        <!-- VISI MISI -->
        <div class="vimi">

            <!-- VISI -->
            <div class="vimi-card visi fade">
                <span class="section-title text-white">Visi</span>
                <div class="visi-text">
                    <?php
                    $visi = strip_tags($p['visi']);
                    echo nl2br(htmlspecialchars($visi));
                    ?>
                </div>
            </div>

            <!-- MISI -->
            <div class="vimi-card fade">
                <span class="section-title">Misi</span>
                <div class="misi-list">
                    <?php
                    $misi = $p['misi'];
                    $misi = preg_replace('/<br\s*\/?>/i', "\n", $misi);
                    $misi = strip_tags($misi);
                    $list = preg_split('/\r\n|\r|\n/', $misi);

                    echo "<ol>";
                    foreach ($list as $item) {
                        $item = trim($item);
                        if (!empty($item)) {
                            echo "<li>" . htmlspecialchars($item) . "</li>";
                        }
                    }
                    echo "</ol>";
                    ?>
                </div>
            </div>

        </div>

        <!-- ALAMAT -->
        <div class="footer-profil">
            <p><strong>Alamat Sekolah</strong></p>
            <?= htmlspecialchars($p['alamat']); ?>, Desa <?= htmlspecialchars($p['desa']); ?>, 
            Kec. <?= htmlspecialchars($p['kecamatan']); ?>, 
            <?= htmlspecialchars($p['kabupaten']); ?>, 
            <?= htmlspecialchars($p['provinsi']); ?>
        </div>

    </div>
</div>

<!-- ANIMASI -->
<script>
const fades = document.querySelectorAll('.fade');

window.addEventListener('scroll', () => {
    fades.forEach(el => {
        let top = el.getBoundingClientRect().top;
        let screen = window.innerHeight;

        if (top < screen - 100) {
            el.classList.add('show');
        }
    });
});
</script>

<?php include "template/footer.php"; ?>