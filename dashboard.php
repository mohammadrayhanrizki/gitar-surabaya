<?php
session_start();
include 'koneksi.php';

// Cek Login (Nanti diaktifkan setelah buat login.php)
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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* CSS Sederhana Sesuai Layout Desain */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      display: flex;
      background-color: #F5F6FA;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      height: 100vh;
      background: #fff;
      padding: 30px;
      position: fixed;
      border-right: 1px solid #eee;
    }

    .sidebar h2 {
      margin-bottom: 40px;
      font-weight: 700;
    }

    .menu a {
      display: block;
      padding: 12px 15px;
      color: #333;
      text-decoration: none;
      margin-bottom: 10px;
      border-radius: 8px;
      font-weight: 500;
      transition: 0.3s;
    }

    .menu a:hover,
    .menu a.active {
      background-color: #eee;
      font-weight: 600;
    }

    .logout {
      margin-top: 50px;
      color: #E53935;
    }

    /* Main Content */
    .main-content {
      margin-left: 250px;
      padding: 40px;
      width: 100%;
    }

    .header-title {
      font-size: 24px;
      font-weight: 600;
      margin-bottom: 30px;
    }

    /* Cards Statistik */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 20px;
      margin-bottom: 30px;
    }

    .card {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    }

    .card h3 {
      color: #777;
      font-size: 16px;
      font-weight: 500;
    }

    .card .number {
      font-size: 48px;
      font-weight: 700;
      margin-top: 10px;
    }

    /* Tabel Riwayat */
    .history-section {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    }

    .history-section h3 {
      margin-bottom: 20px;
      font-size: 18px;
    }

    .log-item {
      display: flex;
      justify-content: space-between;
      padding: 12px 15px;
      background: #F4F4F4;
      margin-bottom: 10px;
      border-radius: 8px;
      font-size: 14px;
    }

    .log-time {
      color: #888;
    }
  </style>
</head>

<body>

  <div class="sidebar">
    <h2>Dashboard.</h2>
    <div class="menu">
      <a href="dashboard.php" class="active">Dashboard</a>
      <a href="produk.php">Manajemen Produk</a>
      <a href="pesanan.php">Pesanan</a>
      <a href="galeri_admin.php">Galeri</a>
      <a href="logout.php" class="logout">Keluar</a>
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

</html>