<?php

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
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=check_circle" />
  <link rel="stylesheet" href="css/style.css">
  <link rel="icon" type="image/png" href="./images/logo.png">
</head>

<body>
  <?php include './includes/navbar.php'; ?>

  <!--=====BAGIAN LAYANAN=====-->
  <main class="layanan">
    <div class="layanan-content">
      <div class="layanan-text">

        <h2>Layanan Kami</h2>
        <p class="subtitle">Di Gitar Surabaya kami melayani</p>

        <ul class="layanan-list">
          <li><span class="material-symbols-outlined">check_circle</span> Les Gitar Gratis</li>
          <li><span class="material-symbols-outlined">check_circle</span> Jual Beli Gitar</li>
          <li><span class="material-symbols-outlined">check_circle</span> Servis Gitar</li>
          <li><span class="material-symbols-outlined">check_circle</span> Gadai Gitar</li>
          <li><span class="material-symbols-outlined">check_circle</span> Sewa Gitar</li>
        </ul>

        <p class="note">*Syarat&Ketentuan Berlaku</p>
      </div>

      <div class="layanan-image">
        <img src="./images/layanan.jpg" alt="Layanan Gitar Surabaya">
      </div>
    </div>
  </main>

  <?php include './includes/footer.php'; ?>

  <script src="./includes/script.js"></script>
  </section>
</body>

</html>