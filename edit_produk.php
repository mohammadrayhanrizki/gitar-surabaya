<?php
session_start();
include 'koneksi.php';

// Cek Login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
  header("Location: login.php");
  exit;
}

// Cek ID Produk
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

  // Bersihkan Harga
  $harga_input = $_POST['harga'];
  $harga = preg_replace('/[^0-9]/', '', $harga_input);

  // Ambil Stok Baru
  $stok = $_POST['stok'];

  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $foto_lama = $_POST['foto_lama'];

  // Cek apakah admin ganti gambar?
  if ($_FILES['gambar']['name'] != "") {
    $foto = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $fotobaru = date('dmYHis') . $foto;
    $path = "images/products/" . $fotobaru;

    if (move_uploaded_file($tmp, $path)) {
      // Hapus foto lama
      if (file_exists("images/products/" . $foto_lama)) {
        unlink("images/products/" . $foto_lama);
      }
      // Update SEMUA termasuk gambar dan stok
      $query = "UPDATE produk SET nama_produk='$nama', kategori='$kategori', harga='$harga', stok='$stok', deskripsi='$deskripsi', gambar='$fotobaru' WHERE id='$id'";
    }
  } else {
    // Update TANPA ganti gambar, tapi update stok
    $query = "UPDATE produk SET nama_produk='$nama', kategori='$kategori', harga='$harga', stok='$stok', deskripsi='$deskripsi' WHERE id='$id'";
  }

  if (mysqli_query($conn, $query)) {
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
  <title>Edit Produk</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    /* SIDEBAR FIX (Z-Index Tinggi) */
    .sidebar {
      width: 250px;
      height: 100vh;
      background: #fff;
      padding: 30px;
      position: fixed;
      border-right: 1px solid #eee;
      z-index: 1000;
      /* Wajib agar bisa diklik */
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
      transition: 0.3s;
    }

    .menu a:hover,
    .menu a.active {
      background-color: #F5F6FA;
      color: #000;
      font-weight: 600;
    }

    .logout {
      margin-top: 50px;
      color: #E53935 !important;
    }

    .main-content {
      margin-left: 250px;
      padding: 40px;
      width: 100%;
    }

    .header-title {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 30px;
      color: #222;
    }

    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
      display: flex;
      gap: 30px;
    }

    .image-upload {
      flex: 1;
      background: #F5F6FA;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 280px;
      border: 2px dashed #ccc;
      position: relative;
      overflow: hidden;
      cursor: pointer;
    }

    .image-upload img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .image-upload input {
      position: absolute;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
      z-index: 2;
    }

    .form-inputs {
      flex: 2;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-size: 13px;
      font-weight: 600;
      color: #555;
    }

    .form-control {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 8px;
      outline: none;
      transition: 0.3s;
    }

    .form-control:focus {
      border-color: #000;
    }

    /* Layout Baris untuk Harga & Stok */
    .row-group {
      display: flex;
      gap: 15px;
    }

    .row-group .form-group {
      flex: 1;
    }

    .btn-submit {
      background: #000;
      color: #fff;
      padding: 12px 25px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      margin-top: 10px;
      margin-right: 10px;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-cancel {
      background: #F5F5F5;
      color: #333;
      padding: 12px 25px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }
  </style>
</head>

<body>

  <div class="sidebar">
    <h2>Dashboard</h2>
    <div class="menu">
      <a href="dashboard.php">Dashboard</a>
      <a href="produk.php">Manajemen Produk</a>
      <a href="pesanan.php">Pesanan</a>
      <a href="galeri_admin.php">Galeri</a>
      <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>
  </div>

  <div class="main-content">
    <div class="header-title">Edit Produk</div>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-container">
        <div class="image-upload">
          <img id="imgPreview" src="images/products/<?= $data['gambar']; ?>" alt="Preview">
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
              <option value="Yamaha" <?= ($data['kategori'] == 'Yamaha') ? 'selected' : '' ?>>Yamaha</option>
              <option value="Fender" <?= ($data['kategori'] == 'Fender') ? 'selected' : '' ?>>Fender</option>
              <option value="Bromo" <?= ($data['kategori'] == 'Bromo') ? 'selected' : '' ?>>Bromo</option>
              <option value="Cort" <?= ($data['kategori'] == 'Cort') ? 'selected' : '' ?>>Cort</option>
              <option value="Taylor" <?= ($data['kategori'] == 'Taylor') ? 'selected' : '' ?>>Taylor</option>
              <option value="Ibanez" <?= ($data['kategori'] == 'Ibanez') ? 'selected' : '' ?>>Ibanez</option>
              <option value="Aksesoris" <?= ($data['kategori'] == 'Aksesoris') ? 'selected' : '' ?>>Aksesoris</option>
              <option value="Lainnya" <?= ($data['kategori'] == 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
            </select>
          </div>

          <div class="row-group">
            <div class="form-group">
              <label>Harga (Rp)</label>
              <input type="number" name="harga" class="form-control" value="<?= $data['harga']; ?>" required>
            </div>
            <div class="form-group">
              <label>Stok</label>
              <input type="number" name="stok" class="form-control" value="<?= $data['stok']; ?>" required>
            </div>
          </div>

          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"><?= $data['deskripsi']; ?></textarea>
          </div>

          <button type="submit" name="update" class="btn-submit"><i class="fas fa-save"></i> Simpan</button>
          <a href="produk.php" class="btn-cancel"><i class="fas fa-times"></i> Batal</a>
        </div>
      </div>
    </form>
  </div>

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