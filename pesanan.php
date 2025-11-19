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

  if (in_array($status_baru, ['Pending', 'Selesai'])) {
    $update = mysqli_query($conn, "UPDATE pesanan SET status='$status_baru' WHERE id='$id'");

    if ($update) {
      $log = "Admin mengubah status pesanan ID $id menjadi $status_baru";
      mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log')");

      $_SESSION['notif_type'] = 'success';
      $_SESSION['notif_msg'] = 'Status pesanan berhasil diperbarui!';
    } else {
      $_SESSION['notif_type'] = 'error';
      $_SESSION['notif_msg'] = 'Gagal mengubah status.';
    }
  }
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
  <link rel="icon" type="image/png" href="./images/logo.png">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" href="css/admin.css">
</head>

<body>

  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  <div class="mobile-header">
    <h2>Dashboard</h2>
    <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
  </div>

  <div class="sidebar">
    <h2>Dashboard</h2>
    <div class="menu">
      <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
      <a href="produk.php"><i class="fas fa-box"></i> Manajemen Produk</a>
      <a href="pesanan.php" class="active"><i class="fas fa-shopping-cart"></i> Pesanan</a>
      <a href="galeri_admin.php"><i class="fas fa-images"></i> Galeri</a>
      <a href="banner_admin.php"><i class="fas fa-bullhorn"></i> Banner Promo</a>
      <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>
  </div>

  <div class="main-content">
    <div class="header-title">Pesanan Masuk</div>

    <div class="table-container">
      <div class="table-responsive">
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

                    <a href="#" onclick="confirmDelete(<?= $row['id']; ?>)" class="btn-icon btn-delete"
                      title="Hapus Pesanan">
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
  </div>

  <script src="includes/admin_script.js"></script>

  <script>
    function confirmStatus(id, statusBaru) {
      let textInfo = statusBaru === 'Selesai'
        ? "Pesanan akan ditandai sudah dibayar/dikirim."
        : "Pesanan akan dikembalikan ke status Pending.";

      Swal.fire({
        title: 'Ubah Status?', text: textInfo, icon: 'question',
        showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Ubah!', cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `pesanan.php?id=${id}&status_baru=${statusBaru}`;
        }
      })
    }

    function confirmDelete(id) {
      Swal.fire({
        title: 'Yakin Hapus?', text: "Data yang dihapus tidak bisa dikembalikan!", icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#d33', cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `pesanan.php?hapus=${id}`;
        }
      })
    }

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