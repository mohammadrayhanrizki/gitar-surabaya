<?php
session_start();
include 'koneksi.php';

// --- LOGIKA 1: UBAH STATUS JADI SELESAI ---
if (isset($_GET['selesai'])) {
  $id = $_GET['selesai'];

  // Update status
  $update = mysqli_query($conn, "UPDATE pesanan SET status='Selesai' WHERE id='$id'");

  if ($update) {
    // Ambil nama pemesan buat log
    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_pemesan FROM pesanan WHERE id='$id'"));
    $nama = $data['nama_pemesan'];

    // Catat Log
    $log = "Admin menyelesaikan pesanan atas nama $nama";
    mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log')");

    echo "<script>window.location='pesanan.php';</script>";
  }
}

// --- LOGIKA 2: HAPUS PESANAN (Opsional, misal pesanan iseng) ---
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $hapus = mysqli_query($conn, "DELETE FROM pesanan WHERE id='$id'");

  if ($hapus) {
    echo "<script>alert('Data Pesanan Dihapus'); window.location='pesanan.php';</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pesanan</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <style>
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

    /* Sidebar (Tetap Sama) */
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

    /* Content */
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

    /* Tabel Pesanan */
    .table-container {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      font-weight: 600;
      color: #555;
    }

    /* Status Badges */
    .badge {
      padding: 5px 10px;
      border-radius: 5px;
      font-size: 12px;
      font-weight: 600;
    }

    .badge-pending {
      background: #FFF3E0;
      color: #FF9800;
    }

    .badge-selesai {
      background: #E8F5E9;
      color: #4CAF50;
    }

    /* Tombol Aksi */
    .btn-cek {
      background: #000;
      color: #fff;
      text-decoration: none;
      padding: 6px 12px;
      border-radius: 5px;
      font-size: 12px;
    }

    .btn-hapus {
      color: red;
      text-decoration: none;
      font-size: 12px;
      margin-left: 10px;
    }
  </style>
</head>

<body>

  <div class="sidebar">
    <h2>Dashboard.</h2>
    <div class="menu">
      <a href="dashboard.php">Dashboard</a>
      <a href="produk.php">Manajemen Produk</a>
      <a href="pesanan.php" class="active">Pesanan</a>
      <a href="galeri_admin.php">Galeri</a>
      <a href="logout.php" class="logout">Keluar</a>
    </div>
  </div>

  <div class="main-content">
    <div class="header-title">Pesanan Masuk</div>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Nama Pemesan</th>
            <th>Detail Barang</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = mysqli_query($conn, "SELECT * FROM pesanan ORDER BY tanggal DESC");
          if (mysqli_num_rows($query) > 0):
            while ($row = mysqli_fetch_assoc($query)):
              ?>
              <tr>
                <td><?= date('d/m/y H.i', strtotime($row['tanggal'])); ?></td>
                <td>
                  <strong><?= $row['nama_pemesan']; ?></strong><br>
                  <small><?= $row['whatsapp']; ?></small>
                </td>
                <td><?= $row['list_pesanan']; ?></td>
                <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                <td>
                  <?php if ($row['status'] == 'Pending'): ?>
                    <span class="badge badge-pending">Pending</span>
                  <?php else: ?>
                    <span class="badge badge-selesai">Selesai</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($row['status'] == 'Pending'): ?>
                    <a href="pesanan.php?selesai=<?= $row['id']; ?>" class="btn-cek"
                      onclick="return confirm('Tandai pesanan ini sudah selesai/dibayar?')">✅ Selesai</a>
                  <?php endif; ?>
                  <a href="pesanan.php?hapus=<?= $row['id']; ?>" class="btn-hapus"
                    onclick="return confirm('Hapus histori ini?')">Hapus</a>
                </td>
              </tr>
            <?php endwhile; else: ?>
            <tr>
              <td colspan="6" style="text-align:center; padding: 30px; color:#999;">Belum ada pesanan masuk.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

</body>

</html>