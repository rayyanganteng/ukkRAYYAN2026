<?php include "template/header.php"; ?>
<?php include __DIR__ . "/../koneksi.php"; ?>

<style>
    .contact-header {
        background: linear-gradient(rgba(30, 58, 138, 0.9), rgba(30, 58, 138, 0.9)), url('https://images.unsplash.com/photo-1523050335392-9bef867a4975?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 80px 0;
        margin-bottom: -50px;
    }
    .contact-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .info-icon {
        width: 50px;
        height: 50px;
        background: #e0e7ff;
        color: #1e3a8a;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.5rem;
        margin-right: 15px;
    }
    .map-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        height: 100%;
        min-height: 300px;
    }
</style>

<div class="contact-header text-center">
    <div class="container">
        <h1 class="fw-bold display-4">Hubungi Kami</h1>
        <p class="lead opacity-75">Kami siap membantu menjawab pertanyaan Anda mengenai SMK Ganesha Tama Boyolali.</p>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card contact-card p-4 mb-4">
                <h4 class="fw-bold mb-4">Informasi Kontak</h4>
                
                <div class="d-flex align-items-start mb-4">
                    <div class="info-icon"><i class="bi bi-geo-alt"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Alamat Sekolah</h6>
                        <p class="text-muted small mb-0">Jl. Perintis Kemerdekaan, Bangunharjo, Pulisen, Kec. Boyolali, Kab. Boyolali, Jawa Tengah 57316.</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-4">
                    <div class="info-icon"><i class="bi bi-telephone"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Telepon / WhatsApp</h6>
                        <p class="text-muted small mb-0">(0276) 321579<br>+62 8XX-XXXX-XXXX (Humas)</p>
                    </div>
                </div>

                <div class="d-flex align-items-start">
                    <div class="info-icon"><i class="bi bi-envelope"></i></div>
                    <div>
                        <h6 class="fw-bold mb-1">Email Resmi</h6>
                        <p class="text-muted small mb-0">info@ganeshatama-byi.sch.id<br>smkgtbi@yahoo.co.id</p>
                    </div>
                </div>
            </div>

           
        </div>

        <div class="col-lg-7">
            <div class="card contact-card p-4 p-md-5">
                <h4 class="fw-bold mb-2">Kirim Pesan</h4>
                <p class="text-muted mb-4">Punya pertanyaan seputar pendaftaran atau kerjasama? Isi formulir di bawah ini.</p>

                <?php
                if ($_POST) {
                    $nama  = mysqli_real_escape_string($koneksi, $_POST['nama']);
                    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
                    $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan']);

                    $query = "INSERT INTO kontak (id, nama, email, pesan, tanggal_kirim) 
                              VALUES (NULL, '$nama', '$email', '$pesan', NOW())";

                    if (mysqli_query($koneksi, $query)) {
                        echo "
                        <div class='alert alert-success border-0 shadow-sm d-flex align-items-center' role='alert'>
                            <i class='bi bi-check-circle-fill me-2 fs-4'></i>
                            <div>Pesan Anda berhasil terkirim! Tim kami akan segera menghubungi Anda.</div>
                        </div>";
                    } else {
                        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . mysqli_error($koneksi) . "</div>";
                    }
                }
                ?>

                <form method="post" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                                <input type="text" name="nama" class="form-control bg-light border-start-0" placeholder="Masukkan nama" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Alamat Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                                <input type="email" name="email" class="form-control bg-light border-start-0" placeholder="nama@email.com" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Pesan Anda</label>
                        <textarea name="pesan" class="form-control bg-light" rows="5" placeholder="Tuliskan pertanyaan atau aspirasi Anda..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 shadow-sm">
                        <i class="bi bi-send-fill me-2"></i> Kirim Pesan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "template/footer.php"; ?>