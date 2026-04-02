</div> <footer class="footer mt-5">
    <div class="container py-5">
        <div class="row g-4">

            <div class="col-lg-4 col-md-6">
                <div class="footer-info">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?= $base_url ?>user/img/logo.png" width="70" class="me-3">
                        <div>
                            <h6 class="fw-bold mb-0 text-white">SMK GANESHA TAMA</h6>
                            <small class="text-info">BOYOLALI</small>
                        </div>
                    </div>
                    <p class="text-secondary small">
                        Pusat pendidikan kejuruan yang berdedikasi untuk mencetak lulusan kompeten, berkarakter, dan siap kerja di dunia industri global.
                    </p>
                    <div class="social-links mt-3">
                        <a href="https://www.facebook.com/smkganeshatama" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/smkganeshatama" target="_blank"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.youtube.com/smkganeshatamaboyolali4459" target="_blank"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold text-white mb-3">Tautan Cepat</h6>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?= $base_url ?>index.php">Beranda</a></li>
                    <li><a href="<?= $base_url ?>profil">Profil</a></li>
                    <li><a href="<?= $base_url ?>guru">Guru</a></li>
                    <li><a href="<?= $base_url ?>berita">Berita</a></li>
                    <li><a href="<?= $base_url ?>galeri">Galeri</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-white mb-3">Hubungi Kami</h6>
                <ul class="list-unstyled contact-list small text-secondary">
                    <li class="d-flex mb-2">
                        <i class="bi bi-geo-alt text-info me-2"></i>
                        <span>Jl. Perintis Kemerdekaan, Bangunharjo, Pulisen, Boyolali, Jawa Tengah 57316</span>
                    </li>
                    <li class="d-flex mb-2">
                        <i class="bi bi-telephone text-info me-2"></i>
                        <span>(0276) 321579</span>
                    </li>
                    <li class="d-flex mb-2">
                        <i class="bi bi-envelope text-info me-2"></i>
                        <span>smkgtbi@yahoo.co.id</span>
                    </li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold text-white mb-3">Lokasi Kami</h6>
                <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d453.8159909465059!2d110.59235601096502!3d-7.541238584265679!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a694a5dee51e7%3A0x47bce9a6608707e0!2sSmk%20Ganesha%20Tama%20Boyolali!5e0!3m2!1sen!2sus!4v1775134382823!5m2!1sen!2sus" 
                        style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

        </div>

        <hr class="mt-5 mb-4 border-secondary opacity-25">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-secondary small">© <?= date("Y") ?> <span class="text-white">SMK Ganesha Tama Boyolali</span>. All Rights Reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="mb-0 text-secondary small">Dikembangkan untuk Pendidikan Indonesia</p>
            </div>
        </div>
    </div>
</footer>

<style>
    .footer {
        background-color: #0f172a; /* Warna biru navy gelap (lebih modern) */
        color: #94a3b8;
    }

    .footer h6 {
        letter-spacing: 1px;
        text-transform: uppercase;
        font-size: 0.9rem;
    }

    .footer-links li {
        margin-bottom: 10px;
    }

    .footer-links a {
        color: #94a3b8;
        text-decoration: none;
        font-size: 0.9rem;
        transition: 0.3s;
    }

    .footer-links a:hover {
        color: #38bdf8;
        padding-left: 5px;
    }

    .social-links a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        background: rgba(255, 255, 255, 0.05);
        color: white;
        border-radius: 50%;
        margin-right: 10px;
        transition: 0.3s;
        text-decoration: none;
    }

    .social-links a:hover {
        background: #2563eb;
        transform: translateY(-3px);
    }

    .contact-list li i {
        font-size: 1.1rem;
    }

    /* Menghilangkan garis bawah pada link footer secara global */
    .footer a {
        text-decoration: none;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
