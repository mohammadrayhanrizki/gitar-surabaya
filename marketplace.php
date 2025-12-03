<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gitar Surabaya - Marketplace</title>
    <link rel="icon" type="image/png" href="./images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/marketplace.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
</head>

<body>

    <header class="navbar-marketplace">
        <div class="navbar-container">
            <div class="logo-marketplace">
                <a href="index.php"><img src="images/logo-1.png" alt="Gitar Surabaya"></a>
            </div>
            <div class="search-bar-marketplace">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <input type="text" placeholder="Cari gitar, merek, atau aksesori...">
            </div>
            <nav class="nav-right-marketplace">
                <a href="index.php">Beranda</a>
                <a href="https://linkbio.co/gitarsurabaya" target="_blank">Kontak</a>
            </nav>
            <a href="#cart" class="cart-link">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span class="cart-badge">0</span>
            </a>
            <button class="hamburger-marketplace" aria-label="Toggle menu"><span></span><span></span><span></span></button>
        </div>
    </header>

    <section class="banner-marketplace">
        <button class="banner-arrow left"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg></button>
        <div class="banner-wrapper">
            <?php
            $banner_query = mysqli_query($conn, "SELECT * FROM banners ORDER BY id DESC");
            $total_banner = mysqli_num_rows($banner_query);
            $i = 0;
            if ($total_banner > 0) {
                while ($row = mysqli_fetch_assoc($banner_query)) {
                    $activeClass = ($i == 0) ? 'active' : '';
            ?>
                    <div class="banner-slide <?= $activeClass; ?>" style="background-image: url('images/banners/<?= $row['gambar']; ?>');">
                        <div class="banner-content">
                            <h2><?= $row['judul']; ?></h2>
                            <p><?= $row['subjudul']; ?></p>
                        </div>
                        <div class="banner-overlay"></div>
                    </div>
            <?php $i++;
                }
            } else {
                echo '<div class="banner-slide active" style="background: #ddd; display:flex; align-items:center; justify-content:center;"><div class="banner-content" style="color:#333;"><h2>Promo Spesial</h2><p>Belum ada banner.</p></div></div>';
            } ?>
        </div>
        <button class="banner-arrow right"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg></button>
        <div class="banner-dots">
            <?php for ($k = 0; $k < $total_banner; $k++): ?><span class="dot <?= ($k == 0) ? 'active' : ''; ?>" data-index="<?= $k; ?>"></span><?php endfor; ?>
        </div>
    </section>

    <section class="semua-produk">
        <h2>Semua Produk</h2>
    </section>
    <section class="product-section-marketplace">
        <div class="scroll-container-marketplace">
            <button class="scroll-btn-marketplace left"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg></button>
            <div class="product-list-marketplace">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                ?>
                        <div class="product-card-marketplace" onclick="window.location.href='detail_produk.php?id=<?= $row['id']; ?>'">
                            <div class="product-image-placeholder"><img src="images/products/<?= $row['gambar']; ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"></div>
                            <p class="product-name"><?= $row['nama_produk']; ?></p>
                            <p class="product-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                            <?php if ($row['stok'] > 0): ?>
                                <p class="product-status available">Tersedia</p><?php else: ?>
                                <p class="product-status preorder" style="background:#ffebee; color:red;">Habis</p><?php endif; ?>
                            <button class="btn-belanja mobile" style="display:block; width:100%; margin-top:10px; margin-left:0; padding:8px; font-size:12px; border:1px solid #000;" onclick="event.stopPropagation(); addToCart('<?= $row['nama_produk']; ?>', <?= $row['harga']; ?>)">+
                                Keranjang</button>
                        </div>
                <?php }
                } else {
                    echo "<p style='padding:20px; width:100%; text-align:center;'>Belum ada produk.</p>";
                } ?>
            </div>
            <button class="scroll-btn-marketplace right"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg></button>
        </div>
    </section>

    <?php
    $brands = [
        ['name' => 'Cowboy', 'logo' => 'Logo-Cowboy-fix.png'],
        ['name' => 'Yamaha', 'logo' => 'yamaha.png'],
        ['name' => 'Karafuru', 'logo' => 'karafuru-logo2.png'],
        ['name' => 'Bromo', 'logo' => 'bromo.png'],
        ['name' => 'Odlair', 'logo' => 'logo-odlair.png']
    ];

    foreach ($brands as $brand) {
        $brandName = $brand['name'];
        $brandLogo = $brand['logo'];
        $sqlWhere = isset($brand['query']) ? $brand['query'] : "kategori LIKE '%$brandName%'";
    ?>
        <section class="brand-section-marketplace">
            <div class="brand-container">
                <div class="brand-logo-sidebar">
                    <img src="./images/<?= $brandLogo; ?>" alt="<?= $brandName; ?>" class="brand-img-placeholder" style="object-fit:contain; background:white;">
                    <?php if ($brandName == 'Aksesoris')
                        echo '<p style="text-align:center; font-weight:bold; margin-top:5px;">AKSESORIS</p>'; ?>
                </div>
                <div class="brand-product-slider">
                    <div class="scroll-container-marketplace">
                        <button class="scroll-btn-marketplace left"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg></button>
                        <div class="product-list-marketplace">
                            <?php
                            $brand_query = mysqli_query($conn, "SELECT * FROM produk WHERE $sqlWhere LIMIT 10");
                            if (mysqli_num_rows($brand_query) > 0) {
                                while ($row = mysqli_fetch_assoc($brand_query)) {
                            ?>
                                    <div class="product-card-marketplace" onclick="window.location.href='detail_produk.php?id=<?= $row['id']; ?>'">
                                        <div class="product-image-placeholder"><img src="images/products/<?= $row['gambar']; ?>" style="width:100%; height:100%; object-fit:cover;" loading="lazy"></div>
                                        <p class="product-name"><?= $row['nama_produk']; ?></p>
                                        <p class="product-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                                        <?php if ($row['stok'] > 0): ?>
                                            <p class="product-status available">Tersedia</p><?php else: ?>
                                            <p class="product-status preorder" style="background:#ffebee; color:red;">Habis</p>
                                        <?php endif; ?>
                                        <button class="btn-belanja mobile" style="display:block; width:100%; margin-top:10px; margin-left:0; padding:8px; font-size:12px; border:1px solid #000;" onclick="event.stopPropagation(); addToCart('<?= $row['nama_produk']; ?>', <?= $row['harga']; ?>)">+
                                            Keranjang</button>
                                    </div>
                            <?php }
                            } else {
                                echo "<p style='padding:10px;'>Produk $brandName belum tersedia.</p>";
                            } ?>
                        </div>
                        <button class="scroll-btn-marketplace right"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg></button>
                    </div>
                </div>
            </div>
        </section>
    <?php }  ?>

    <?php include './includes/footer.php'; ?>

    <div id="cartModal" class="cart-modal">
        <div class="cart-content">
            <div class="cart-header">
                <h2><i class="fas fa-shopping-bag"></i> Keranjang Saya</h2>
                <span class="close-cart">&times;</span>
            </div>
            <div id="cartItemsContainer"></div>
            <div class="cart-summary">
                <span>Total Belanja</span>
                <span class="total-price" id="cartTotal">Rp 0</span>
            </div>
            <div class="buyer-form">
                <input type="text" id="buyerName" class="form-input" placeholder="Nama Lengkap" autocomplete="off">
                <input type="tel" id="buyerWA" class="form-input" placeholder="Nomor WhatsApp (08...)">
                <button id="btnCheckout"><i class="fab fa-whatsapp"></i> Checkout Sekarang</button>
            </div>
        </div>
    </div>

    <script src="includes/script.js?v=<?= time(); ?>"></script>
</body>

</html>