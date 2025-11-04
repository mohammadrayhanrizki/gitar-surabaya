<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

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
        <li><a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">Tentang Kami</a></li>
        <li><a href="layanan.php" class="<?= $current_page == 'layanan.php' ? 'active' : '' ?>">Layanan</a></li>
        <li><a href="galeri.php" class="<?= $current_page == 'galeri.php' ? 'active' : '' ?>">Galeri</a></li>
      </ul>

      <!-- Tombol BELANJA versi mobile -->
      <a href="marketplace.php" class="btn-belanja mobile <?= $current_page == 'marketplace.php' ? '' : '' ?>">BELANJA</a>
    </nav>

    <!-- Tombol BELANJA versi desktop -->
    <a href="marketplace.php" class="btn-belanja desktop <?= $current_page == 'marketplace.php' ? '' : '' ?>">BELANJA</a>
  </div>
</header>
