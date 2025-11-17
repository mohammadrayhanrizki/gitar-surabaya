<?php
session_start();
include 'koneksi.php';

// --- LOGIKA 1: TAMBAH PRODUK ---
if (isset($_POST['tambah'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
  $harga = $_POST['harga'];
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

  // Upload Gambar
  $foto = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];
  $fotobaru = date('dmYHis') . $foto; // Rename biar unik
  $path = "images/products/" . $fotobaru;

  if (move_uploaded_file($tmp, $path)) {
    // Masukkan ke Database Produk
    $query = mysqli_query($conn, "INSERT INTO produk (nama_produk, kategori, harga, deskripsi, gambar) VALUES ('$nama', '$kategori', '$harga', '$deskripsi', '$fotobaru')");

    if ($query) {
      // --- LOG AKTIVITAS OTOMATIS (Trigger) ---
      $log_text = "Admin menambahkan produk $nama";
      mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log_text')");

      echo "<script>alert('Produk Berhasil Ditambah!'); window.location='produk.php';</script>";
    }
  } else {
    echo "<script>alert('Gagal Upload Gambar!');</script>";
  }
}

// --- LOGIKA 2: HAPUS PRODUK ---
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];

  // Ambil nama produk dulu buat log
  $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'"));
  $nama_produk = $data['nama_produk'];

  // Hapus data
  $hapus = mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");

  if ($hapus) {
    // --- LOG AKTIVITAS OTOMATIS ---
    $log_text = "Admin menghapus produk $nama_produk";
    mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log_text')");

    // Hapus file gambar fisik (Optional tapi disarankan)
    unlink("images/products/" . $data['gambar']);

    echo "<script>alert('Produk Dihapus!'); window.location='produk.php';</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Produk</title>
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

    /* Sidebar (Sama dengan Dashboard) */
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

    /* Form Section */
    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
      display: flex;
      gap: 30px;
      margin-bottom: 40px;
    }

    .image-upload {
      flex: 1;
      background: #E0E0E0;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 250px;
      border: 2px dashed #ccc;
      position: relative;
      overflow: hidden;
    }

    .image-upload input {
      position: absolute;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
    }

    .form-inputs {
      flex: 2;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-size: 14px;
      font-weight: 600;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 8px;
      outline: none;
    }

    .btn-submit {
      background: #000;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      margin-top: 10px;
    }

    .btn-submit:hover {
      background: #333;
    }

    /* Product Grid */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 20px;
    }

    .product-card {
      background: #fff;
      padding: 15px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
    }

    .product-img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
      background: #eee;
      margin-bottom: 10px;
    }

    .product-name {
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 5px;
    }

    .product-price {
      color: #E53935;
      font-weight: 700;
      font-size: 14px;
    }

    .action-links {
      margin-top: 10px;
      font-size: 12px;
    }

    .delete-btn {
      color: red;
      text-decoration: none;
    }
  </style>
</head>

<body>

  <div class="sidebar">
    <h2>Dashboard.</h2>
    <div class="menu">
      <a href="dashboard.php">Dashboard</a>
      <a href="produk.php" class="active">Manajemen Produk</a>
      <a href="pesanan.php">Pesanan</a>
      <a href="galeri_admin.php">Galeri</a>
      <a href="logout.php" class="logout">Keluar</a>
    </div>
  </div>

  <div class="main-content">
    <div class="header-title">Manajemen Produk</div>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-container">
        <div class="image-upload">
          <span>+ Klik Upload Image</span>
          <input type="file" name="gambar" required>
        </div>

        <div class="form-inputs">
          <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Kategori / Merk</label>
            <select name="kategori" class="form-control" required>
              <option value="">-- Pilih Merk --</option>
              <option value="Yamaha">Yamaha</option>
              <option value="Fender">Fender</option>
              <option value="Bromo">Bromo</option>
              <option value="Cort">Cort</option>
              <option value="Taylor">Taylor</option>
              <option value="Ibanez">Ibanez</option>
              <option value="Aksesoris">Aksesoris</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
          <div class="form-group">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
          </div>
          <button type="submit" name="tambah" class="btn-submit">Tambahkan Produk</button>
        </div>
      </div>
    </form>

    <div class="header-title">List Produk</div>
    <div class="product-grid">
      <?php
      $result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
      while ($row = mysqli_fetch_assoc($result)):
        ?>
        <div class="product-card">
          <img src="images/products/<?= $row['gambar']; ?>" class="product-img">
          <div class="product-name"><?= $row['nama_produk']; ?></div>
          <div class="product-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></div>
          <div class="action-links">
            Tersedia | <a href="produk.php?hapus=<?= $row['id']; ?>" class="delete-btn"
              onclick="return confirm('Yakin hapus?')">Hapus</a>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

</body>

</html>