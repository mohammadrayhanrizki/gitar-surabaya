<?php
session_start();
include 'koneksi.php';

// Cek Login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
  header("Location: login.php");
  exit;
}

// --- LOAD LIBRARY PUSHER (SUPAYA BISA REALTIME) ---
require __DIR__ . '/vendor/autoload.php';
$options = array('cluster' => 'ap1', 'useTLS' => true);

try {
  $pusher = new Pusher\Pusher(
    '122fe5dc53b428646f8b', // Key
    '0be57d1316e4c58ef72c', // Secret
    '2079485',              // App ID
    $options
  );
} catch (Exception $e) {
  $pusher = null;
}

// --- LOGIKA 1: TAMBAH BANNER ---
if (isset($_POST['upload'])) {
  $judul = mysqli_real_escape_string($conn, $_POST['judul']);
  $subjudul = mysqli_real_escape_string($conn, $_POST['subjudul']);

  // Upload Gambar
  $foto = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];
  $fotobaru = date('dmYHis') . $foto;
  $path = "images/banners/" . $fotobaru;

  // Cek Folder
  if (!file_exists('images/banners')) {
    mkdir('images/banners', 0777, true);
  }

  // --- VALIDASI FILE ---
  $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
  $file_type = mime_content_type($tmp);
  
  if (!in_array($file_type, $allowed_types)) {
      $_SESSION['notif_type'] = 'error';
      $_SESSION['notif_msg'] = 'Format file tidak valid! Hanya JPG, PNG, GIF, WEBP.';
      header("Location: banner_admin.php");
      exit;
  }

  if (move_uploaded_file($tmp, $path)) {
    $query = mysqli_query($conn, "INSERT INTO banners (judul, subjudul, gambar) VALUES ('$judul', '$subjudul', '$fotobaru')");

    if ($query) {
      // --- KIRIM SINYAL REALTIME ---
      if ($pusher) {
        $pusher->trigger('marketplace-channel', 'update-produk', ['message' => 'Banner baru ditambahkan!']);
      }

      // Log Aktivitas
      $log = "Admin mengupload banner promo: $judul";
      mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log')");

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

// --- LOGIKA 2: HAPUS BANNER ---
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];

  // Ambil data lama
  $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM banners WHERE id='$id'"));

  // Hapus Database
  $hapus = mysqli_query($conn, "DELETE FROM banners WHERE id='$id'");

  if ($hapus) {
    // --- KIRIM SINYAL REALTIME ---
    if ($pusher) {
      $pusher->trigger('marketplace-channel', 'update-produk', ['message' => 'Banner dihapus!']);
    }

    // Log
    $log = "Admin menghapus banner: " . $data['judul'];
    mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log')");

    // Hapus File Fisik
    if (file_exists("images/banners/" . $data['gambar'])) {
      unlink("images/banners/" . $data['gambar']);
    }

    $_SESSION['notif_type'] = 'success';
    $_SESSION['notif_msg'] = 'Banner berhasil dihapus.';
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
  <title>Kelola Banner - Gitar Surabaya</title>
  <link rel="icon" type="image/png" href="./images/logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" href="css/admin.css">

  <style>
    .banner-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
    }

    .banner-card {
      background: #fff;
      padding: 15px;
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      position: relative;
      transition: 0.3s;
    }

    .banner-card:hover {
      transform: translateY(-5px);
    }

    .banner-img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      border-radius: 8px;
      background: #eee;
      margin-bottom: 10px;
    }

    .banner-info h4 {
      font-size: 16px;
      font-weight: 700;
      margin-bottom: 5px;
      color: #333;
    }

    .banner-info p {
      font-size: 13px;
      color: #666;
    }

    .btn-delete-banner {
      position: absolute;
      top: 10px;
      right: 10px;
      background: rgba(255, 255, 255, 0.9);
      color: #E53935;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      transition: 0.2s;
    }

    .btn-delete-banner:hover {
      background: #E53935;
      color: #fff;
    }

    /* CSS Khusus untuk Upload Box (Diambil dari galeri_admin.php) */
    .upload-box {
      background: #fff;
      padding: 40px;
      border-radius: 16px;
      text-align: center;
      border: 2px dashed #ccc;
      margin-bottom: 30px;
      position: relative;
      cursor: pointer;
      transition: 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 250px;
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
      z-index: 3;
    }

    .upload-label {
      font-size: 18px;
      font-weight: 600;
      color: #555;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px;
      z-index: 1;
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
      <a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
      <a href="produk.php"><i class="fas fa-box"></i> Manajemen Produk</a>
      <a href="pesanan.php"><i class="fas fa-shopping-cart"></i> Pesanan</a>
      <a href="galeri_admin.php"><i class="fas fa-images"></i> Galeri</a>
      <a href="banner_admin.php" class="active"><i class="fas fa-bullhorn"></i> Banner Promo</a>
      <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>
  </div>

  <div class="main-content">
    <div class="header-title">Kelola Banner Promo</div>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-container" style="flex-direction: column;">

        <div class="upload-box" id="dropZone">
          
          <!-- Label Default -->
          <div class="upload-label" id="uploadLabel">
            <i class="fas fa-image" style="font-size:32px; color:#ccc;"></i>
            <span id="uploadText">Klik Upload Banner (Landscape)</span>
          </div>

          <!-- Image Preview -->
          <img id="imgPreview" src="" alt="Preview Banner"
            style="display:none; max-width:100%; max-height:100%; object-fit:contain; border-radius:12px; z-index: 2;">
          
          <!-- Input File -->
          <input type="file" name="gambar" id="fileInput" accept="image/*" required>
        </div>

        <div id="extraFields" style="display: none; width: 100%; margin-top: 20px;">
          <div class="row-group" style="display: flex; gap: 20px;">
            <div class="form-group" style="flex: 1;">
              <label>Judul Utama (Opsional)</label>
              <input type="text" name="judul" class="form-control" placeholder="Contoh: Diskon Merdeka">
            </div>
            <div class="form-group" style="flex: 1;">
              <label>Sub-Judul (Opsional)</label>
              <input type="text" name="subjudul" class="form-control" placeholder="Contoh: Up to 50% Off">
            </div>
          </div>

          <button type="submit" name="upload" class="btn-submit"><i class="fas fa-upload"></i> Upload Banner</button>
        </div>

      </div>
    </form>

    <div class="header-title" style="font-size: 20px; margin-top: 40px;">List Banner Aktif</div>

    <div class="banner-grid">
      <?php
      $result = mysqli_query($conn, "SELECT * FROM banners ORDER BY id DESC");
      if (mysqli_num_rows($result) > 0):
        while ($row = mysqli_fetch_assoc($result)):
          ?>
          <div class="banner-card">
            <img src="images/banners/<?= $row['gambar']; ?>" class="banner-img">
            <div class="banner-info">
              <h4><?= $row['judul']; ?></h4>
              <p><?= $row['subjudul']; ?></p>
            </div>

            <a href="#" onclick="confirmDelete(<?= $row['id']; ?>)" class="btn-delete-banner" title="Hapus Banner">
              <i class="fas fa-trash"></i>
            </a>
          </div>
          <?php
        endwhile;
      else:
        ?>
        <p style="color:#999; grid-column: 1/-1; text-align:center;">Belum ada banner yang diupload.</p>
      <?php endif; ?>
    </div>

  </div>

  <script src="includes/admin_script.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Preview Image Logic
      const fileInput = document.getElementById('fileInput');
      const imgPreview = document.getElementById('imgPreview');
      const uploadLabel = document.getElementById('uploadLabel');
      const extraFields = document.getElementById('extraFields');

      if (fileInput) {
        fileInput.addEventListener('change', function () {
          console.log("File input changed");
          const file = this.files[0];
          if (file) {
            console.log("File selected:", file.name);
            const reader = new FileReader();
            reader.onload = function (e) {
              console.log("File read successfully");
              // Tampilkan gambar
              imgPreview.src = e.target.result;
              imgPreview.style.setProperty('display', 'block', 'important');
              
              // Sembunyikan label
              uploadLabel.style.setProperty('display', 'none', 'important');
            }
            reader.readAsDataURL(file);

            // Tampilkan input fields
            extraFields.style.display = 'block';
          } else {
            console.log("No file selected");
          }
        });
      }
    });

    // SweetAlert Delete
    function confirmDelete(id) {
      Swal.fire({
        title: 'Hapus Banner?',
        text: "Data tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `banner_admin.php?hapus=${id}`;
        }
      })
    }

    <?php if (isset($_SESSION['notif_type'])): ?>
      Swal.fire({
        icon: '<?= $_SESSION['notif_type']; ?>',
        title: '<?= $_SESSION['notif_type'] == 'success' ? 'Berhasil!' : 'Gagal!'; ?>',
        text: '<?= $_SESSION['notif_msg']; ?>',
        timer: 1500,
        showConfirmButton: false
      });
      <?php unset($_SESSION['notif_type']);
      unset($_SESSION['notif_msg']); ?>
    <?php endif; ?>
  </script>

</body>

</html>