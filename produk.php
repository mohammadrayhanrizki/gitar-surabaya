<?php
session_start();
include 'koneksi.php';

// Cek Login
if (!isset($_SESSION['status_login']) || $_SESSION['status_login'] != true) {
  header("Location: login.php");
  exit;
}

// --- LOGIKA 1: TAMBAH PRODUK ---
if (isset($_POST['tambah'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama']);
  $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);

  // Bersihkan Harga (Hapus titik/koma/Rp)
  $harga_input = $_POST['harga'];
  $harga = preg_replace('/[^0-9]/', '', $harga_input);

  // Ambil Stok
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
    // UPDATE QUERY: Tambahkan kolom 'stok'
    $query = mysqli_query($conn, "INSERT INTO produk (nama_produk, kategori, harga, stok, deskripsi, gambar) VALUES ('$nama', '$kategori', '$harga', '$stok', '$deskripsi', '$fotobaru')");

    if ($query) {
      $log_text = "Admin menambahkan produk $nama (Stok: $stok)";
      mysqli_query($conn, "INSERT INTO riwayat_aktivitas (isi_aktivitas) VALUES ('$log_text')");

      $_SESSION['notif_type'] = 'success';
      $_SESSION['notif_msg'] = 'Produk berhasil ditambahkan!';
    } else {
      $_SESSION['notif_type'] = 'error';
      $_SESSION['notif_msg'] = 'Gagal menyimpan ke database.';
    }
  } else {
    $_SESSION['notif_type'] = 'error';
    $_SESSION['notif_msg'] = 'Gagal mengupload gambar.';
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
      transition: 0.3s;
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

    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
      display: flex;
      gap: 30px;
      margin-bottom: 50px;
    }

    .image-upload {
      flex: 1;
      background: #F5F6FA;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 350px;
      border: 2px dashed #ccc;
      position: relative;
      overflow: hidden;
      cursor: pointer;
      transition: 0.3s;
    }

    .image-upload:hover {
      border-color: #333;
      background: #eee;
    }

    .image-upload input {
      position: absolute;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
      z-index: 2;
    }

    .image-upload span {
      z-index: 1;
      color: #888;
      font-weight: 500;
      text-align: center;
    }

    #imgPreview {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: none;
      z-index: 1;
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
      font-size: 14px;
    }

    .form-control:focus {
      border-color: #000;
    }

    /* Layout Harga & Stok Sebelahan */
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
      margin-top: 15px;
      transition: 0.3s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-submit:hover {
      background: #333;
      transform: translateY(-2px);
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 25px;
    }

    .product-card {
      background: #fff;
      padding: 15px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      transition: 0.3s;
      border: 1px solid transparent;
      position: relative;
    }

    .product-card:hover {
      transform: translateY(-5px);
      border-color: #eee;
    }

    .product-img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
      background: #F5F6FA;
      margin-bottom: 15px;
    }

    .product-name {
      font-weight: 600;
      font-size: 15px;
      margin-bottom: 5px;
      color: #333;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .product-price {
      color: #E53935;
      font-weight: 700;
      font-size: 14px;
      margin-bottom: 5px;
    }

    .product-stock {
      font-size: 12px;
      color: #666;
      margin-bottom: 15px;
      background: #eee;
      display: inline-block;
      padding: 2px 8px;
      border-radius: 4px;
    }

    .action-links {
      display: flex;
      justify-content: center;
      gap: 8px;
    }

    .btn-icon {
      width: 35px;
      height: 35px;
      border-radius: 8px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      transition: 0.2s;
      text-decoration: none;
      border: none;
      cursor: pointer;
      font-size: 14px;
    }

    .btn-edit {
      background: #FFF3E0;
      color: #F57C00;
    }

    .btn-edit:hover {
      background: #F57C00;
      color: #fff;
    }

    .btn-delete {
      background: #FFEBEE;
      color: #E53935;
    }

    .btn-delete:hover {
      background: #E53935;
      color: #fff;
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
              <input type="text" name="harga" class="form-control" placeholder="Contoh: 1500000" required>
            </div>
            <div class="form-group">
              <label>Stok</label>
              <input type="number" name="stok" class="form-control" placeholder="Jumlah" required>
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
        confirmButtonText: 'Ya, Hapus!'
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