<?php
// galeri.php
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gitar Surabaya</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <header class="site-header">
    <div class="container">
      <div class="logo">
        <a href="index.php"><img src="./images/logo-1.png" alt="Logo Gitar Surabaya"></a>
      </div>

      <button class="hamburger" aria-label="Toggle menu">
        <span></span><span></span><span></span>
      </button>

      <nav class="main-nav">
        <ul>
          <li><a href="index.php">Tentang Kami</a></li>
          <li><a href="layanan.php" class="active">Layanan</a></li>
          <li><a href="galeri.php">Galeri</a></li>
        </ul>
        <a href="#"class="btn-belanja">BELANJA</a>
      </nav>
    </div>
  </header>

  <!--=====BAGIAN LAYANAN=====-->
  <main class="layanan">
    <h2>Layanan Kami</h2>
    <p class="subtitle">Di Gitar Surabaya kami melayani</p>

    <ul class="layanan-list">
      <li><i class="fa-regular fa-circle-check"></i> Les Gitar Gratis</li>
      <li><i class="fa-regular fa-circle-check"></i> Jual Beli Gitar</li>
      <li><i class="fa-regular fa-circle-check"></i> Servis Gitar</li>
      <li><i class="fa-regular fa-circle-check"></i> Gadai Gitar</li>
      <li><i class="fa-regular fa-circle-check"></i> Sewa Gitar</li>
    </ul>

    <p class="note">*Syarat&Ketentuan Berlaku</p>
    <div class="layanan-image">
      <img src="./images/layanan.jpg" alt="Layanan Gitar Surabaya">

  <footer class="footer" data-animate="fade-up">
    <div class="container-footer">
      <div class="footer-logo" data-animate="fade-up" data-delay="100">
        <img src="./images/logofooter.png" alt="Gitar Surabaya">
      </div>

      <div class="footer-divider"></div>

      <div class="footer-socials" data-animate="fade-up" data-delay="200">
        <div class="social-item"><img src="./images/ig.png" alt="Instagram">
          <p>@gitarsurabaya</p>
        </div>
        <div class="social-item"><img src="./images/yt.png" alt="YouTube">
          <p>gitarsurabaya</p>
        </div>
        <div class="social-item"><img src="./images/wa.png" alt="WhatsApp">
          <p>+62 812 5997 0907</p>
        </div>
      </div>

      <div class="footer-divider"></div>

      <div class="footer-maps" data-animate="fade-up" data-delay="300">
        <div class="maps-title"><img src="./images/maps.png" alt="Map">
          <p>Maps</p>
        </div>
        <p>Jalan Nginden Semolo No.40<br>Surabaya Nginden, Semolowaru, Kec.<br>Sukolilo, Surabaya, Jawa Timur
          60119</p>
      </div>
    </div>
  </footer>

  <script src="./includes/script.js"></script>
  </section>
</body>

</html>