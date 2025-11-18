<?php
session_start();
include 'koneksi.php';

// Cek Login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
  header("Location: login.php");
  exit;
}

// --- LOAD LIBRARY PUSHER (WAJIB) ---
require __DIR__ . '/vendor/autoload.php';

// --- KONFIGURASI PUSHER ---
$options = array(
  'cluster' => 'ap1',
  'useTLS' => true
);

// Inisialisasi Pusher dengan Try-Catch agar aman
try {
  $pusher = new Pusher\Pusher(
    '122fe5dc53b428646f8b',       // Key
    '0be57d1316e4c58ef72c',       // Secret
    '2079485',                    // App ID
    $options
  );
} catch (Exception $e) {
  $pusher = null; // Jika gagal load, biarkan null
}

// --- LOGIKA 1: TAMBAH PRODUK ---
if (isset($_POST['tambah'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);

  // Bersihkan Harga
  $harga = preg_replace('/[^0-9]/', '', $_POST['harga']);

  $stok = $_POST['stok'];
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

  // Upload Gambar
  $foto = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];
  $fotobaru = date('dmYHis') . $foto;
  $path = "images/products/" . $fotobaru;

  if (!file_exists('images/products')) {
    mkdir('images/products', 0777, true);
  }

  if (move_uploaded_file($tmp, $path)) {
    $query = mysqli_query($conn, "INSERT INTO produk (nama_produk, kategori, harga, stok, deskripsi, gambar) VALUES ('$nama', '$kategori', '$harga', '$stok', '$deskripsi', '$fotobaru')");

    if ($query) {
      // --- KIRIM SINYAL REALTIME KE PUSHER ---
      if ($pusher) {
        $data['message'] = 'Produk baru: ' . $nama;
        $pusher->trigger('marketplace-channel', 'update-produk', $data);
      }
      // ---------------------------------------

      $log_text = "Admin menambahkan produk $nama (Stok: $stok)";
      mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log_text')");

      $_SESSION['notif_type'] = 'success';
      $_SESSION['notif_msg'] = 'Produk berhasil ditambahkan!';
    } else {
      $_SESSION['notif_type'] = 'error';
      $_SESSION['notif_msg'] = 'Database Error: ' . mysqli_error($conn);
    }
  } else {
    $_SESSION['notif_type'] = 'error';
    $_SESSION['notif_msg'] = 'Gagal upload gambar.';
  }
  header("Location: produk.php");
  exit;
}

// --- LOGIKA 2: HAPUS PRODUK ---
if (isset($_GET['hapus'])) {
  $id = $_GET['hapus'];
  $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM produk WHERE id='$id'"));

  $hapus = mysqli_query($conn, "DELETE FROM produk WHERE id='$id'");

  if ($hapus) {
    // --- KIRIM SINYAL REALTIME KE PUSHER ---
    if ($pusher) {
      $pusher->trigger('marketplace-channel', 'update-produk', ['message' => 'Produk dihapus']);
    }
    // ---------------------------------------

    $log_text = "Admin menghapus produk " . $data['nama_produk'];
    mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log_text')");

    if (file_exists("images/products/" . $data['gambar'])) {
      unlink("images/products/" . $data['gambar']);
    }

    $_SESSION['notif_type'] = 'success';
    $_SESSION['notif_msg'] = 'Produk berhasil dihapus.';
  } else {
    $_SESSION['notif_type'] = 'error';
    $_SESSION['notif_msg'] = 'Gagal menghapus data.';
  }
  header("Location: produk.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Produk</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
      <a href="produk.php" class="active"><i class="fas fa-box"></i> Manajemen Produk</a>
      <a href="pesanan.php"><i class="fas fa-shopping-cart"></i> Pesanan</a>
      <a href="galeri_admin.php"><i class="fas fa-images"></i> Galeri</a>
      <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Keluar</a>
    </div>
  </div>

  <div class="main-content">
    <div class="header-title">Manajemen Produk</div>

    <form method="POST" enctype="multipart/form-data">
      <div class="form-container">
        <div class="image-upload">
          <span id="uploadText"><i class="fas fa-cloud-upload-alt"
              style="font-size: 32px; margin-bottom: 10px;"></i><br>Klik Upload Image</span>
          <img id="imgPreview" src="#" alt="Preview Gambar">
          <input type="file" name="gambar" id="fileInput" accept="image/*" required>
        </div>

        <div class="form-inputs">
          <div class="form-group">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" placeholder="Contoh: Yamaha F310" required>
          </div>
          <div class="form-group">
            <label>Kategori / Merk</label>
            <select name="kategori" class="form-control" required>
              <option value="">-- Pilih Merk --</option>
              <option value="Yamaha">Yamaha</option>
              <option value="Bromo">Bromo</option>
              <option value="Cort">Cort</option>
              <option value="Ibanez">Ibanez</option>
              <option value="Aksesoris">Senar Gitar</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>

          <div class="row-group">
            <div class="form-group">
              <label>Harga (Rp)</label>
              <input type="number" name="harga" class="form-control" placeholder="Contoh: 1500000" required>
            </div>
            <div class="form-group">
              <label>Stok</label>
              <input type="number" name="stok" class="form-control" placeholder="Jumlah Stok" required>
            </div>
          </div>

          <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Spesifikasi singkat..."></textarea>
          </div>
          <button type="submit" name="tambah" class="btn-submit"><i class="fas fa-plus"></i> Tambahkan Produk</button>
        </div>
      </div>
    </form>

    <div class="header-title" style="font-size: 20px;">List Produk</div>

    <div class="product-grid">
      <?php
      $result = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
      if (mysqli_num_rows($result) > 0):
        while ($row = mysqli_fetch_assoc($result)):
          ?>
          <div class="product-card">
            <img src="images/products/<?= $row['gambar']; ?>" class="product-img">
            <div class="product-name"><?= $row['nama_produk']; ?></div>
            <div class="product-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></div>
            <div class="product-stock">Stok: <?= $row['stok']; ?></div>

            <div class="action-links">
              <a href="edit_produk.php?id=<?= $row['id']; ?>" class="btn-icon btn-edit" title="Edit">
                <i class="fas fa-pen"></i>
              </a>
              <button onclick="confirmDelete(<?= $row['id']; ?>)" class="btn-icon btn-delete" title="Hapus">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
        <?php
        endwhile;
      else:
        ?>
        <p style="color:#999; grid-column: 1/-1; text-align:center;">Belum ada produk yang diupload.</p>
      <?php endif; ?>
    </div>
  </div>

  <script src="includes/admin_script.js"></script>
  <script>
    const fileInput = document.getElementById('fileInput');
    const imgPreview = document.getElementById('imgPreview');
    const uploadText = document.getElementById('uploadText');

    fileInput.addEventListener('change', function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          imgPreview.src = e.target.result;
          imgPreview.style.display = 'block';
          uploadText.style.display = 'none';
        }
        reader.readAsDataURL(file);
      }
    });

    function confirmDelete(id) {
      Swal.fire({
        title: 'Yakin Hapus?',
        text: "Produk yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `produk.php?hapus=${id}`;
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