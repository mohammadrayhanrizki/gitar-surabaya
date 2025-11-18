<?php
session_start();
include 'koneksi.php';

// Cek Login (Nanti diaktifkan setelah buat login.php)
// Cek Login (SUDAH AKTIF)
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
  echo '<script>window.location="login.php"</script>';
  exit;
}
// if (!isset($_SESSION['login'])) { header("Location: login.php"); exit; }

// --- LOGIC 1: Ambil Data Statistik ---
$jumlah_produk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM produk"));
$jumlah_merk = mysqli_num_rows(mysqli_query($conn, "SELECT DISTINCT kategori FROM produk"));

// --- LOGIC 2: Ambil Data Riwayat Aktivitas ---
$log_query = mysqli_query($conn, "SELECT * FROM riwayat_aktivitas ORDER BY tanggal DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Gitar Surabaya</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/admin.css">
</head>

<body>

  <div class="sidebar-overlay" id="sidebarOverlay"></div>

  <div class="mobile-header">
    <h2>Dashboard</h2>
    <button class="menu-toggle" id="menuToggle">
      <i class="fas fa-bars"></i>
    </button>
  </div>

  <div class="sidebar">
    <h2>Dashboard.</h2>
    <div class="menu">
      <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
      <a href="produk.php"><i class="fas fa-box"></i> Manajemen Produk</a>
      <a href="pesanan.php"><i class="fas fa-shopping-cart"></i> Pesanan</a>
      <a href="galeri_admin.php"><i class="fas fa-images"></i> Galeri</a>
      <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>
  </div>

  <div class="main-content">
    <div class="header-title">Dashboard Overview</div>

    <div class="stats-grid">
      <div class="card">
        <h3>Total Produk</h3>
        <div class="number"><?= $jumlah_produk; ?></div>
      </div>
      <div class="card">
        <h3>Total Merk</h3>
        <div class="number"><?= $jumlah_merk; ?></div>
      </div>
    </div>

    <div class="history-section">
      <h3>Riwayat Aktivitas</h3>

      <?php if (mysqli_num_rows($log_query) > 0): ?>
        <?php while ($log = mysqli_fetch_assoc($log_query)): ?>
          <div class="log-item">
            <span><?= htmlspecialchars($log['isi_aktivitas']); ?></span>
            <span class="log-time"><?= date('d/m/y H.i', strtotime($log['tanggal'])); ?></span>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p style="text-align:center; color:#999;">Belum ada aktivitas.</p>
      <?php endif; ?>

    </div>
  </div>

</body>
<script src="includes/admin_script.js"></script>

</html>