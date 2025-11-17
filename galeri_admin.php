<?php
session_start();
include 'koneksi.php';

// --- LOGIKA 1: TAMBAH FOTO GALERI ---
if (isset($_POST['upload'])) {
  $judul = mysqli_real_escape_string($conn, $_POST['judul']);

  // Upload Gambar
  $foto = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];
  $fotobaru = date('dmYHis') . $foto; // Rename unik
  $path = "images/gallery/" . $fotobaru;

  if (move_uploaded_file($tmp, $path)) {
    $query = mysqli_query($conn, "INSERT INTO galeri (judul, gambar) VALUES ('$judul', '$fotobaru')");

    if ($query) {
      // Log Aktivitas
      $log = "Admin mengupload foto galeri: $judul";
      mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log')");

      echo "<script>alert('Foto Berhasil Diupload!'); window.location='galeri_admin.php';</script>";
    }
  }
}

// --- LOGIKA 2: HAPUS FOTO ---
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];

  // Ambil nama file dulu
  $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM galeri WHERE id='$id'"));

  // Hapus file fisik
  unlink("images/gallery/" . $data['gambar']);

  // Hapus data database
  $hapus = mysqli_query($conn, "DELETE FROM galeri WHERE id='$id'");

  if ($hapus) {
    echo "<script>alert('Foto Dihapus!'); window.location='galeri_admin.php';</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Galeri</title>
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

    /* Form Upload (Sesuai Desain Kotak Besar) */
    .upload-box {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      text-align: center;
      border: 2px dashed #ccc;
      margin-bottom: 40px;
      position: relative;
      cursor: pointer;
      transition: 0.3s;
    }

    .upload-box:hover {
      background: #f9f9f9;
      border-color: #aaa;
    }

    .upload-box input[type="file"] {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
    }

    .upload-label {
      font-size: 18px;
      font-weight: 600;
      color: #555;
    }

    .input-judul {
      width: 100%;
      padding: 12px;
      margin-top: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      display: none;
      /* Muncul setelah file dipilih (Nanti di JS) */
    }

    .btn-upload {
      background: #000;
      color: #fff;
      padding: 10px 25px;
      border: none;
      border-radius: 8px;
      margin-top: 15px;
      cursor: pointer;
      font-weight: 600;
      display: none;
      /* Muncul setelah file dipilih */
    }

    /* Grid Galeri */
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 20px;
    }

    .gallery-card {
      background: #fff;
      padding: 10px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
      position: relative;
    }

    .gallery-img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
    }

    .gallery-caption {
      font-size: 14px;
      margin-top: 10px;
      font-weight: 500;
    }

    .btn-delete {
      position: absolute;
      top: 15px;
      right: 15px;
      background: rgba(255, 0, 0, 0.8);
      color: #fff;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      text-align: center;
      line-height: 30px;
      text-decoration: none;
      font-size: 12px;
    }
  </style>
</head>

<body>

  <div class="sidebar">
    <h2>Dashboard.</h2>
    <div class="menu">
      <a href="dashboard.php">Dashboard</a>
      <a href="produk.php">Manajemen Produk</a>
      <a href="pesanan.php">Pesanan</a>
      <a href="galeri_admin.php" class="active">Galeri</a>
      <a href="logout.php" class="logout">Keluar</a>
    </div>
  </div>

  <div class="main-content">
    <div class="header-title">Galeri</div>

    <form method="POST" enctype="multipart/form-data">
      <div class="upload-box" id="dropZone">
        <div class="upload-label">+ Klik untuk Upload Image</div>
        <input type="file" name="gambar" id="fileInput" required>
      </div>

      <div id="extraFields" style="display:block; margin-bottom:40px;">
        <input type="text" name="judul" class="input-judul" style="display:inline-block; width:70%;"
          placeholder="Masukkan Judul/Caption Foto..." required>
        <button type="submit" name="upload" class="btn-upload" style="display:inline-block;">Upload Sekarang</button>
      </div>
    </form>

    <div class="header-title" style="font-size: 18px;">Foto Terupload</div>
    <div class="gallery-grid">
      <?php
      $result = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
      while ($row = mysqli_fetch_assoc($result)):
        ?>
        <div class="gallery-card">
          <img src="images/gallery/<?= $row['gambar']; ?>" class="gallery-img">
          <div class="gallery-caption"><?= $row['judul']; ?></div>
          <a href="galeri_admin.php?hapus=<?= $row['id']; ?>" class="btn-delete"
            onclick="return confirm('Hapus foto ini?')">X</a>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <script>
    // Script sederhana buat ganti teks saat file dipilih
    const fileInput = document.getElementById('fileInput');
    const label = document.querySelector('.upload-label');

    fileInput.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        label.textContent = "File terpilih: " + this.files[0].name;
        label.style.color = "#4CAF50";
      }
    });
  </script>

</body>

</html>