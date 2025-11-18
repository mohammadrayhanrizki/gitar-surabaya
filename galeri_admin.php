<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
  header("Location: login.php");
  exit;
}

// --- TAMBAH FOTO ---
if (isset($_POST['upload'])) {
  $judul = mysqli_real_escape_string($conn, $_POST['judul']);
  $foto = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];
  $fotobaru = date('dmYHis') . $foto;
  $path = "images/gallery/" . $fotobaru;

  if (move_uploaded_file($tmp, $path)) {
    $query = mysqli_query($conn, "INSERT INTO galeri (judul, gambar) VALUES ('$judul', '$fotobaru')");

    if ($query) {
      $log = "Admin mengupload foto galeri: $judul";
      mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log')");

      $_SESSION['notif_type'] = 'success';
      $_SESSION['notif_msg'] = 'Foto berhasil diupload!';
    }
  }
  header("Location: galeri_admin.php");
  exit;
}

// --- HAPUS FOTO ---
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM galeri WHERE id='$id'"));

  if (file_exists("images/gallery/" . $data['gambar'])) {
    unlink("images/gallery/" . $data['gambar']);
  }

  $hapus = mysqli_query($conn, "DELETE FROM galeri WHERE id='$id'");

  if ($hapus) {
    $_SESSION['notif_type'] = 'success';
    $_SESSION['notif_msg'] = 'Foto berhasil dihapus.';
  }
  header("Location: galeri_admin.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Galeri</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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

    /* Upload Box Modern */
    .upload-box {
      background: #fff;
      padding: 40px;
      border-radius: 16px;
      text-align: center;
      border: 2px dashed #ccc;
      margin-bottom: 40px;
      position: relative;
      cursor: pointer;
      transition: 0.3s;
    }

    .upload-box:hover {
      background: #F9F9F9;
      border-color: #000;
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
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
    }

    .input-judul {
      width: 100%;
      padding: 12px;
      margin-top: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      display: none;
      outline: none;
      transition: 0.3s;
    }

    .input-judul:focus {
      border-color: #000;
    }

    .btn-upload {
      background: #000;
      color: #fff;
      padding: 12px 25px;
      border: none;
      border-radius: 8px;
      margin-top: 15px;
      cursor: pointer;
      font-weight: 600;
      display: none;
      transition: 0.3s;
    }

    .btn-upload:hover {
      background: #333;
      transform: translateY(-2px);
    }

    /* Grid Galeri */
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 25px;
    }

    .gallery-card {
      background: #fff;
      padding: 10px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      position: relative;
      transition: 0.3s;
    }

    .gallery-card:hover {
      transform: translateY(-5px);
    }

    .gallery-img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
    }

    .gallery-caption {
      font-size: 14px;
      margin-top: 10px;
      font-weight: 600;
      color: #333;
      text-align: center;
    }

    .btn-delete {
      position: absolute;
      top: 15px;
      right: 15px;
      background: #fff;
      color: #E53935;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      text-align: center;
      line-height: 32px;
      text-decoration: none;
      font-size: 14px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
      transition: 0.2s;
    }

    .btn-delete:hover {
      background: #E53935;
      color: #fff;
      transform: scale(1.1);
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
      <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>
  </div>

  <div class="main-content">
    <div class="header-title">Galeri</div>

    <form method="POST" enctype="multipart/form-data">
      <div class="upload-box" id="dropZone">
        <div class="upload-label">
          <i class="fas fa-image" style="font-size:32px; color:#ccc;"></i>
          <span>+ Klik untuk Upload Image</span>
        </div>
        <input type="file" name="gambar" id="fileInput" required>
      </div>

      <div id="extraFields" style="display:block; margin-bottom:40px;">
        <input type="text" name="judul" class="input-judul" style="display:inline-block; width:70%; margin-right:10px;"
          placeholder="Masukkan Judul/Caption Foto..." required>
        <button type="submit" name="upload" class="btn-upload" style="display:inline-block;">Upload Sekarang</button>
      </div>
    </form>

    <div class="header-title" style="font-size: 20px; margin-top:40px;">Foto Terupload</div>
    <div class="gallery-grid">
      <?php
      $result = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
      while ($row = mysqli_fetch_assoc($result)):
        ?>
        <div class="gallery-card">
          <img src="images/gallery/<?= $row['gambar']; ?>" class="gallery-img">
          <div class="gallery-caption"><?= $row['judul']; ?></div>
          <button onclick="confirmDelete(<?= $row['id']; ?>)" class="btn-delete" title="Hapus Foto"><i
              class="fas fa-trash"></i></button>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <script>
    const fileInput = document.getElementById('fileInput');
    const labelText = document.querySelector('.upload-label span');
    const labelIcon = document.querySelector('.upload-label i');

    fileInput.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        labelText.textContent = "Siap Upload: " + this.files[0].name;
        labelText.style.color = "#2E7D32";
        labelIcon.className = "fas fa-check-circle";
        labelIcon.style.color = "#2E7D32";
      }
    });

    function confirmDelete(id) {
      Swal.fire({
        title: 'Hapus Foto?',
        text: "Foto akan hilang permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `galeri_admin.php?hapus=${id}`;
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