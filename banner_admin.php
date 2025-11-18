<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
  header("Location: login.php");
  exit;
}

// --- TAMBAH BANNER ---
if (isset($_POST['upload'])) {
  $judul = mysqli_real_escape_string($conn, $_POST['judul']);
  $subjudul = mysqli_real_escape_string($conn, $_POST['subjudul']);

  $foto = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];
  $fotobaru = date('dmYHis') . $foto;
  $path = "images/banners/" . $fotobaru;

  if (!file_exists('images/banners')) {
    mkdir('images/banners', 0777, true);
  }

  if (move_uploaded_file($tmp, $path)) {
    $query = mysqli_query($conn, "INSERT INTO banners (judul, subjudul, gambar) VALUES ('$judul', '$subjudul', '$fotobaru')");

    if ($query) {
      $_SESSION['notif_type'] = 'success';
      $_SESSION['notif_msg'] = 'Banner berhasil diupload!';
    }
  } else {
    $_SESSION['notif_type'] = 'error';
    $_SESSION['notif_msg'] = 'Gagal upload gambar.';
  }
  header("Location: banner_admin.php");
  exit;
}

// --- HAPUS BANNER ---
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM banners WHERE id='$id'"));

  if (file_exists("images/banners/" . $data['gambar'])) {
    unlink("images/banners/" . $data['gambar']);
  }

  if (mysqli_query($conn, "DELETE FROM banners WHERE id='$id'")) {
    $_SESSION['notif_type'] = 'success';
    $_SESSION['notif_msg'] = 'Banner dihapus.';
  }
  header("Location: banner_admin.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Banner</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="css/admin.css">
  <style>
    /* Style tambahan khusus banner grid (lebar) */
    .banner-grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 20px;
    }

    .banner-card {
      background: #fff;
      padding: 10px;
      border-radius: 12px;
      position: relative;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .banner-img {
      width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
    }

    .banner-info {
      padding: 10px;
    }

    .banner-info h4 {
      margin: 0;
      font-size: 16px;
    }

    .banner-info p {
      margin: 5px 0 0;
      color: #666;
      font-size: 14px;
    }
  </style>
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
      <a href="dashboard.php">Dashboard</a>
      <a href="produk.php">Manajemen Produk</a>
      <a href="pesanan.php">Pesanan</a>
      <a href="galeri_admin.php">Galeri</a>
      <a href="banner_admin.php" class="active">Banner Promo</a>
      <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>
  </div>
  <div class="main-content">
    <div class="header-title">Kelola Banner Promo</div>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-container" style="flex-direction: column;">
        <div class="image-upload" style="width: 100%; height: 200px;">
          <span id="uploadText"><i class="fas fa-image"></i> Klik Upload Banner (Landscape)</span>
          <img id="imgPreview" src="#" alt="Preview" style="display:none;">
          <input type="file" name="gambar" id="fileInput" accept="image/*" required>
        </div>

        <div class="row-group" s
tyle="display: flex; gap: 15px;">
          <div class="form-group" style="flex:1;">
            <label>Judul Utama</label>
            <input type="text" name="judul" class="form-control" placeholder="Contoh: Diskon Akhir Tahun">
          </div>
          <div class="form-group" style="flex:1;">
            <label>Sub-Judul</label>
            <input type="text" name="subjudul" class="form-control" placeholder="Contoh: Diskon hingga 50%">
          </div>
        </div>
        <button type="submit" name="upload" class="btn-submit">Upload Banner</button>
      </div>
    </form>

    <div class="header-title" style="font-size: 20px;">List Banner Aktif</div>

    <div class="banner-grid">
      <?php
      $result = mysqli_query($conn, "SELECT * FROM banners ORDER BY id DESC");
      while ($row = mysqli_fetch_assoc($result)):
        ?>
        <div class="banner-card">
          <img src="images/banners/<?= $row['gambar']; ?>" class="banner-img">
          <div class="banner-info">
            <h4><?= $row['judul']; ?></h4>
            <p><?= $row['subjudul']; ?></p>
          </div>
          <a href="#" onclick="confirmDelete(<?= $row['id']; ?>)" class="btn-delete" style="top: 10px; right: 10px;">
            <i class="fas fa-trash"></i>
          </a>
        </div>
      <?php endwhile; ?>
    </div>
  </div>

  <script src="includes/admin_script.js"></script>
  <script>
    const fileInput = document.getElementById('fileInput');
    const imgPreview = document.getElementById('imgPreview');
    const uploadText = document.getElementById('uploadText');

    fileInput.addEventListener('change', function () {
      if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imgPreview.src = e.target.result;
          imgPreview.style.display = 'block';
          uploadText.style.display = 'none';
        }
        reader.readAsDataURL(this.files[0]);
      }
    });

    function confirmDelete(id) {
      Swal.fire({
        title: 'Hapus Banner?', text: "Tidak bisa dikembalikan!", icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Ya, Hapus!'
      }).then((result) => {
        if (result.isConfirmed) window.location.href = `banner_admin.php?hapus=${id}`;
      })
    }

    <?php if (isset($_SESSION['notif_type'])): ?>
      Swal.fire({ icon: '<?= $_SESSION['notif_type']; ?>', title: '<?= $_SESSION['notif_msg']; ?>', timer: 1500, showConfirmButton: false });
      <?php unset($_SESSION['notif_type']);
      unset($_SESSION['notif_msg']); ?>
    <?php endif; ?>
  </script>
</body>

</html>