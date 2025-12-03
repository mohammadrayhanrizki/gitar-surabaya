<?php
session_start();
include 'koneksi.php';

// Cek Login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
  header("Location: login.php");
  exit;
}

// LOAD LIBRARY PUSHER (DENGAN ERROR HANDLING AMAN)
require __DIR__ . '/vendor/autoload.php';
$options = array('cluster' => 'ap1', 'useTLS' => true);

// --- PERBAIKAN DI SINI (Pakai Pusher\Pusher) ---
try {
  $pusher = new Pusher\Pusher(
    '122fe5dc53b428646f8b',
    '0be57d1316e4c58ef72c',
    '2079485',
    $options
  );
} catch (Exception $e) {
  // Kalau error koneksi ke pusher, biarkan jalan terus (jangan die)
  $pusher = null;
}

if (!isset($_GET['id'])) {
  header("Location: produk.php");
  exit;
}
$id = $_GET['id'];
$query_ambil = mysqli_query($conn, "SELECT * FROM produk WHERE id = '$id'");
$data = mysqli_fetch_assoc($query_ambil);

// LOGIKA UPDATE
if (isset($_POST['update'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
  $harga = preg_replace('/[^0-9]/', '', $_POST['harga']);
  $stok = $_POST['stok'];
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $foto_lama = $_POST['foto_lama'];

  if ($_FILES['gambar']['name'] != "") {
    $foto = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $fotobaru = date('dmYHis') . $foto;
    $path = "images/products/" . $fotobaru;

    if (move_uploaded_file($tmp, $path)) {
      if (file_exists("images/products/" . $foto_lama)) {
        unlink("images/products/" . $foto_lama);
      }
      $query = "UPDATE produk SET nama_produk='$nama', kategori='$kategori', harga='$harga', stok='$stok', deskripsi='$deskripsi', gambar='$fotobaru' WHERE id='$id'";
    }
  } else {
    $query = "UPDATE produk SET nama_produk='$nama', kategori='$kategori', harga='$harga', stok='$stok', deskripsi='$deskripsi' WHERE id='$id'";
  }

  if (mysqli_query($conn, $query)) {
    // Trigger Pusher (Hanya jika object $pusher berhasil dibuat)
    if ($pusher) {
      $pusher->trigger('marketplace-channel', 'update-produk', ['message' => 'Produk diupdate']);
    }

    $log = "Admin mengedit produk $nama";
    mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log')");

    $_SESSION['notif_type'] = 'success';
    $_SESSION['notif_msg'] = 'Produk berhasil diperbarui!';
    header("Location: produk.php");
    exit;
  } else {
    echo "<script>alert('Gagal Update!');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk</title>
  <link rel="icon" type="image/png" href="./images/logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
      <a href="pesanan.php"><i class="fas fa-shopping-cart"></i> Pesanan</a>
      <a href="galeri_admin.php"><i class="fas fa-images"></i> Galeri</a>
      <a href="banner_admin.php"><i class="fas fa-bullhorn"></i> Banner Promo</a>
      <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>
  </div>

  <div class="main-content">
    <div class="header-title">Edit Produk</div>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-container">
        <div class="image-upload">
          <img id="imgPreview" src="images/products/<?= $data['gambar']; ?>" alt="Preview" style="display:block;">
          <input type="file" name="gambar" id="fileInput" onchange="previewImage()">
          <input type="hidden" name="foto_lama" value="<?= $data['gambar']; ?>">
        </div>

        <div class="form-inputs">
          <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" value="<?= $data['nama_produk']; ?>" required>
          </div>

          <div class="form-group">
            <label>Kategori / Merk</label>
            <select name="kategori" class="form-control" required>
              <option value="Cowboy" <?= ($data['kategori'] == 'Cowboy') ? 'selected' : ''; ?>>Cowboy</option>
              <option value="Yamaha" <?= ($data['kategori'] == 'Yamaha') ? 'selected' : ''; ?>>Yamaha</option>
              <option value="Karafuru" <?= ($data['kategori'] == 'Karafuru') ? 'selected' : ''; ?>>Karafuru</option>
              <option value="Bromo" <?= ($data['kategori'] == 'Bromo') ? 'selected' : ''; ?>>Bromo</option>
              <option value="Odlair" <?= ($data['kategori'] == 'Odlair') ? 'selected' : ''; ?>>Odlair</option>
            </select>
          </div>

          <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" value="<?= $data['harga']; ?>" required>
          </div>
          <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" value="<?= $data['stok']; ?>" required>
          </div>

          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"><?= $data['deskripsi']; ?></textarea>
          </div>

          <button type="submit" name="update" class="btn-submit"><i class="fas fa-save"></i> Simpan Perubahan</button>
          <a href="produk.php" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
        </div>
      </div>
    </form>
  </div>

  <script src="includes/admin_script.js"></script>
  <script>
    function previewImage() {
      const fileInput = document.getElementById('fileInput');
      const imgPreview = document.getElementById('imgPreview');

      const file = fileInput.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imgPreview.src = e.target.result;
        }
        reader.readAsDataURL(file);
      }
    }
  </script>

</body>

</html>