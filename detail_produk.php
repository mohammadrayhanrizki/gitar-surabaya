<?php
include 'koneksi.php';

// 1. Cek ID di URL
if (!isset($_GET['id'])) {
  header("Location: marketplace.php");
  exit;
}

$id = $_GET['id'];

// 2. Ambil Data Produk
$query = mysqli_query($conn, "SELECT * FROM produk WHERE id = '$id'");
$produk = mysqli_fetch_assoc($query);

// Jika produk tidak ditemukan (misal ID ngawur)
if (!$produk) {
  echo "<script>alert('Produk tidak ditemukan!'); window.location='marketplace.php';</script>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $produk['nama_produk']; ?> - Gitar Surabaya</title>
  <link rel="icon" type="image/png" href="./images/logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="css/global.css">
  <link rel="stylesheet" href="css/components.css">
  <link rel="stylesheet" href="css/marketplace.css">
  <link rel="icon" type="image/png" href="./images/logo.png">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    /* CSS KHUSUS HALAMAN DETAIL */
    .detail-container {
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 20px;
      display: flex;
      gap: 50px;
      align-items: flex-start;
    }

    /* Bagian Kiri: Gambar */
    .detail-image {
      flex: 1;
      background: #f9f9f9;
      border-radius: 20px;
      overflow: hidden;
      border: 1px solid #eee;
      position: relative;
    }

    .detail-image img {
      width: 100%;
      height: auto;
      object-fit: contain;
      display: block;
    }

    /* Bagian Kanan: Info */
    .detail-info {
      flex: 1;
      padding: 20px 0;
    }

    .detail-cat {
      font-size: 14px;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .detail-title {
      font-size: 36px;
      font-weight: 800;
      color: #333;
      margin-bottom: 15px;
      line-height: 1.2;
    }

    .detail-price {
      font-size: 28px;
      font-weight: 700;
      color: #E53935;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .stock-badge {
      font-size: 14px;
      background: #E8F5E9;
      color: #2E7D32;
      padding: 5px 12px;
      border-radius: 50px;
      font-weight: 600;
    }

    .stock-habis {
      background: #FFEBEE;
      color: #E53935;
    }

    .detail-desc {
      font-size: 16px;
      color: #555;
      line-height: 1.8;
      margin-bottom: 40px;
      border-top: 1px solid #eee;
      padding-top: 20px;
    }

    /* Tombol Aksi */
    .action-buttons {
      display: flex;
      gap: 15px;
    }

    .btn-cart-big {
      flex: 1;
      padding: 15px;
      background: #fff;
      border: 2px solid #000;
      color: #000;
      font-weight: 700;
      border-radius: 10px;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s;
    }

    .btn-cart-big:hover {
      background: #f0f0f0;
    }

    .btn-buy-wa {
      flex: 1;
      padding: 15px;
      background: #000;
      border: 2px solid #000;
      color: #fff;
      font-weight: 700;
      border-radius: 10px;
      cursor: pointer;
      font-size: 16px;
      transition: 0.3s;
      text-align: center;
      text-decoration: none;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .btn-buy-wa:hover {
      background: #333;
      border-color: #333;
    }

    /* Produk Lainnya */
    .related-section {
      max-width: 1200px;
      margin: 80px auto 40px;
      padding: 0 20px;
    }

    .related-title {
      font-size: 24px;
      font-weight: 700;
      margin-bottom: 30px;
      border-left: 5px solid #E53935;
      padding-left: 15px;
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
      .detail-container {
        flex-direction: column;
        gap: 30px;
        margin-top: 20px;
      }

      .detail-title {
        font-size: 28px;
      }

      .action-buttons {
        flex-direction: column;
      }
    }

    /* Re-use Modal Cart Styles */
    .cart-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 9999;
      display: none;
      justify-content: center;
      align-items: center;
    }

    .cart-content {
      background: white;
      width: 90%;
      max-width: 400px;
      padding: 20px;
      border-radius: 10px;
      position: relative;
      max-height: 90vh;
      overflow-y: auto;
    }

    .close-cart {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      cursor: pointer;
      font-weight: bold;
    }

    .cart-item {
      display: flex;
      justify-content: space-between;
      border-bottom: 1px solid #eee;
      padding: 10px 0;
      font-size: 14px;
    }

    .cart-item-remove {
      color: red;
      cursor: pointer;
      font-weight: bold;
      margin-left: 10px;
    }
  </style>
</head>

<body>

  <header class="navbar-marketplace">
    <div class="navbar-container">
      <div class="logo-marketplace">
        <a href="index.php"><img src="images/logo-1.png" alt="Gitar Surabaya"></a>
      </div>
      
      <a href="#cart" class="cart-link">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="9" cy="21" r="1"></circle>
          <circle cx="20" cy="21" r="1"></circle>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
        <span class="cart-badge">0</span>
      </a>
    </div>
  </header>

  <div class="back-nav-container">
    <a href="marketplace.php" class="back-nav">
      <i class="fas fa-arrow-left"></i> Kembali ke Marketplace
    </a>
  </div>

  <div class="detail-container">
    <div class="detail-image">
      <img src="images/products/<?= $produk['gambar']; ?>" alt="<?= $produk['nama_produk']; ?>">
    </div>

    <div class="detail-info">
      <div class="detail-cat"><?= $produk['kategori']; ?></div>
      <h1 class="detail-title"><?= $produk['nama_produk']; ?></h1>

      <div class="detail-price">
        Rp <?= number_format($produk['harga'], 0, ',', '.'); ?>
        <?php if ($produk['stok'] > 0): ?>
          <span class="stock-badge">Stok: <?= $produk['stok']; ?></span>
        <?php else: ?>
          <span class="stock-badge stock-habis">Habis</span>
        <?php endif; ?>
      </div>

      <div class="detail-desc">
        <p><strong>Deskripsi Produk:</strong></p>
        <?= nl2br(htmlspecialchars($produk['deskripsi'])); ?>
      </div>

      <div class="action-buttons">
        <button class="btn-cart-big" onclick="addToCart('<?= htmlspecialchars($produk['nama_produk'], ENT_QUOTES); ?>', <?= $produk['harga']; ?>)">
          <i class="fas fa-cart-plus"></i> Masukkan Keranjang
        </button>

        <?php
        $pesanWA = "Halo Gitar Surabaya, saya mau beli langsung produk ini: " . $produk['nama_produk'];
        $linkWA = "https://wa.me/6281259970907?text=" . urlencode($pesanWA);
        ?>
        <a href="<?= $linkWA; ?>" target="_blank" class="btn-buy-wa">
          <i class="fab fa-whatsapp"></i> Beli Sekarang
        </a>
      </div>
    </div>
  </div>

  <div class="related-section">
    <h3 class="related-title">Produk Lainnya</h3>
    <div class="product-list-marketplace" style="overflow-x: auto; display: flex; gap: 20px; padding-bottom: 20px;">
      <?php
      // Ambil 5 produk acak selain produk ini
      $related = mysqli_query($conn, "SELECT * FROM produk WHERE id != '$id' ORDER BY RAND() LIMIT 5");
      while ($row = mysqli_fetch_assoc($related)) {
        ?>
        <div class="product-card-marketplace" onclick="window.location.href='detail_produk.php?id=<?= $row['id']; ?>'"
          style="min-width: 220px;">
          <div class="product-image-placeholder" style="height: 180px;">
            <img src="images/products/<?= $row['gambar']; ?>" style="width:100%; height:100%; object-fit:cover;">
          </div>
          <p class="product-name" style="font-size: 14px; margin-top: 10px;"><?= $row['nama_produk']; ?></p>
          <p class="product-price" style="font-size: 16px;">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
        </div>
      <?php } ?>
    </div>
  </div>

  <?php include './includes/footer.php'; ?>

  <div id="cartModal" class="cart-modal" style="display:none;">
    <div class="cart-content">
      <span class="close-cart">&times;</span>
      <h2>Keranjang Belanja</h2>
      <div id="cartItemsContainer">
        <p style="text-align:center; color:#999;">Keranjang kosong.</p>
      </div>
      <div class="cart-summary">
        <p>Total: <strong id="cartTotal">Rp 0</strong></p>
      </div>
      <div class="buyer-form" style="margin-top:20px; border-top:1px solid #eee; padding-top:15px;">
        <input type="text" id="buyerName" placeholder="Nama Anda"
          style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd; border-radius:5px;">
        <input type="text" id="buyerWA" placeholder="Nomor WhatsApp"
          style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd; border-radius:5px;">
        <button id="btnCheckout"
          style="width:100%; padding:12px; background:#25D366; color:white; border:none; border-radius:5px; font-weight:bold; cursor:pointer;">Checkout
          ke WhatsApp</button>
      </div>
    </div>
  </div>

  <script src="./includes/script.js"></script>

</body>

</html>