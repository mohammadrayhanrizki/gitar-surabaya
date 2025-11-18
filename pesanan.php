<?php
session_start();
include 'koneksi.php';

// Cek Login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
  header("Location: login.php");
  exit;
}

// --- LOGIKA 1: UBAH STATUS (TOGGLE) ---
if (isset($_GET['id']) && isset($_GET['status_baru'])) {
  $id = $_GET['id'];
  $status_baru = $_GET['status_baru']; // 'Selesai' atau 'Pending'

  // Validasi input status biar aman
  if (in_array($status_baru, ['Pending', 'Selesai'])) {
    $update = mysqli_query($conn, "UPDATE pesanan SET status='$status_baru' WHERE id='$id'");

    if ($update) {
      // Catat Log
      $log = "Admin mengubah status pesanan ID $id menjadi $status_baru";
      mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log')");

      // Set Session Notifikasi untuk SweetAlert
      $_SESSION['notif_type'] = 'success';
      $_SESSION['notif_msg'] = 'Status pesanan berhasil diperbarui!';
    } else {
      $_SESSION['notif_type'] = 'error';
      $_SESSION['notif_msg'] = 'Gagal mengubah status.';
    }
  }
  // Refresh halaman agar URL bersih
  header("Location: pesanan.php");
  exit;
}

// --- LOGIKA 2: HAPUS PESANAN ---
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $hapus = mysqli_query($conn, "DELETE FROM pesanan WHERE id='$id'");

  if ($hapus) {
    $_SESSION['notif_type'] = 'success';
    $_SESSION['notif_msg'] = 'Data pesanan berhasil dihapus.';
  } else {
    $_SESSION['notif_type'] = 'error';
    $_SESSION['notif_msg'] = 'Gagal menghapus data.';
  }
  header("Location: pesanan.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Pesanan</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    /* Sidebar Styling */
    .sidebar {
      width: 250px;
      height: 100vh;
      background: #fff;
      padding: 30px;
      position: fixed;
      border-right: 1px solid #eee;
      z-index: 100;
    }

    .sidebar h2 {
      margin-bottom: 40px;
      font-weight: 700;
      color: #333;
    }

    .menu a {
      display: block;
      padding: 12px 15px;
      color: #555;
      text-decoration: none;
      margin-bottom: 10px;
      border-radius: 10px;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .menu a:hover,
    .menu a.active {
      background-color: #F5F6FA;
      color: #000;
      font-weight: 600;
      transform: translateX(5px);
    }

    .logout {
      margin-top: 50px;
      color: #E53935 !important;
    }

    .logout:hover {
      background-color: #FFEBEE !important;
    }

    /* Content Styling */
    .main-content {
      margin-left: 250px;
      padding: 40px;
      width: calc(100% - 250px);
    }

    .header-title {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 30px;
      color: #222;
    }

    /* Modern Table */
    .table-container {
      background: #fff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0 10px;
    }

    th {
      text-align: left;
      padding: 15px 20px;
      color: #888;
      font-weight: 600;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      border-bottom: 2px solid #f0f0f0;
    }

    td {
      padding: 20px;
      background: #fff;
      border-top: 1px solid #f9f9f9;
      border-bottom: 1px solid #f9f9f9;
      font-size: 14px;
      color: #333;
      vertical-align: middle;
    }

    tr:hover td {
      background-color: #fafafa;
    }

    /* Badges */
    .badge {
      padding: 6px 14px;
      border-radius: 50px;
      font-size: 11px;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      text-transform: uppercase;
    }

    .badge-pending {
      background-color: #FFF8E1;
      color: #F57C00;
      border: 1px solid #FFE0B2;
    }

    .badge-pending::before {
      content: '●';
      color: #F57C00;
    }

    .badge-selesai {
      background-color: #E8F5E9;
      color: #2E7D32;
      border: 1px solid #C8E6C9;
    }

    .badge-selesai::before {
      content: '✓';
      font-weight: bold;
    }

    /* Action Buttons Icons Only */
    .btn-icon {
      width: 35px;
      height: 35px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s;
      font-size: 14px;
      margin-right: 5px;
      text-decoration: none;
    }

    /* Tombol Selesai (Check) */
    .btn-done {
      background: #E8F5E9;
      color: #2E7D32;
    }

    .btn-done:hover {
      background: #2E7D32;
      color: white;
      transform: scale(1.1);
    }

    /* Tombol Undo (Kembali ke Pending) */
    .btn-undo {
      background: #FFF3E0;
      color: #F57C00;
    }

    .btn-undo:hover {
      background: #F57C00;
      color: white;
      transform: scale(1.1);
    }

    /* Tombol Hapus (Sampah) */
    .btn-delete {
      background: #FFEBEE;
      color: #E53935;
    }

    .btn-delete:hover {
      background: #E53935;
      color: white;
      transform: scale(1.1);
    }

    /* Tooltip sederhana */
    .btn-icon[title]:hover::after {
      content: attr(title);
      position: absolute;
      bottom: 100%;
      left: 50%;
      transform: translateX(-50%);
      background: #333;
      color: #fff;
      padding: 4px 8px;
      font-size: 10px;
      border-radius: 4px;
      white-space: nowrap;
    }

    td strong {
      display: block;
      font-size: 15px;
      margin-bottom: 4px;
    }

    td small {
      color: #777;
      font-size: 13px;
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
      <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
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
                  <strong><?= $row['nama_pemesan']; ?></strong>
                  <small><i class="fab fa-whatsapp"></i> <?= $row['whatsapp']; ?></small>
                </td>
                <td><?= nl2br($row['list_pesanan']); ?></td>
                <td><strong>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></strong></td>
                <td>
                  <?php if ($row['status'] == 'Pending'): ?>
                    <span class="badge badge-pending">Pending</span>
                  <?php else: ?>
                    <span class="badge badge-selesai">Selesai</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if ($row['status'] == 'Pending'): ?>
                    <a href="#" onclick="confirmStatus(<?= $row['id']; ?>, 'Selesai')" class="btn-icon btn-done"
                      title="Tandai Selesai">
                      <i class="fas fa-check"></i>
                    </a>
                  <?php else: ?>
                    <a href="#" onclick="confirmStatus(<?= $row['id']; ?>, 'Pending')" class="btn-icon btn-undo"
                      title="Kembalikan ke Pending">
                      <i class="fas fa-rotate-left"></i>
                    </a>
                  <?php endif; ?>

                  <a href="#" onclick="confirmDelete(<?= $row['id']; ?>)" class="btn-icon btn-delete" title="Hapus Pesanan">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endwhile; else: ?>
            <tr>
              <td colspan="6" style="text-align:center; padding: 40px; color:#999;">
                <i class="fas fa-box-open" style="font-size: 40px; margin-bottom: 10px; display:block;"></i>
                Belum ada pesanan masuk.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    // 1. Konfirmasi Ganti Status
    function confirmStatus(id, statusBaru) {
      let textInfo = statusBaru === 'Selesai'
        ? "Pesanan akan ditandai sudah dibayar/dikirim."
        : "Pesanan akan dikembalikan ke status Pending.";

      Swal.fire({
        title: 'Ubah Status?',
        text: textInfo,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Ubah!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `pesanan.php?id=${id}&status_baru=${statusBaru}`;
        }
      })
    }

    // 2. Konfirmasi Hapus
    function confirmDelete(id) {
      Swal.fire({
        title: 'Yakin Hapus?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `pesanan.php?hapus=${id}`;
        }
      })
    }

    // 3. Cek Notifikasi Session dari PHP
    <?php if (isset($_SESSION['notif_type'])): ?>
      Swal.fire({
        icon: '<?= $_SESSION['notif_type']; ?>',
        title: '<?= $_SESSION['notif_type'] == 'success' ? 'Berhasil!' : 'Gagal!'; ?>',
        text: '<?= $_SESSION['notif_msg']; ?>',
        timer: 2000,
        showConfirmButton: false
      });
      <?php unset($_SESSION['notif_type']);
      unset($_SESSION['notif_msg']); ?>
    <?php endif; ?>
  </script>

</body>

</html>