<?php
include 'koneksi.php'; // 1. Panggil koneksi database
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gitar Surabaya - Marketplace</title>
    <link rel="icon" type="image/png" href="./images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/marketplace.css">

    <style>
        .cart-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
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
                <a href="index.php">
                    <img src="images/logo-1.png" alt="Gitar Surabaya">
                </a>
            </div>

            <div class="search-bar-marketplace">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <input type="text" placeholder="Cari gitar, merek, atau aksesori...">
            </div>

            <nav class="nav-right-marketplace">
                <a href="index.php">Beranda</a>
                <a href="#kontak">Kontak</a>
            </nav>

            <a href="#cart" class="cart-link">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span class="cart-badge">0</span>
            </a>

            <button class="hamburger-marketplace" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </header>

    <section class="banner-marketplace">
        <button class="banner-arrow left" aria-label="Previous slide">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>

        <div class="banner-placeholder">
            <div class="banner-content">
                <h2>Promo Spesial</h2>
                <p>Dapatkan diskon menarik hari ini!</p>
            </div>
        </div>

        <button class="banner-arrow right" aria-label="Next slide">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </button>
        <div class="banner-dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </section>

    <section class="semua-produk">
        <h2>Semua Produk</h2>
    </section>

    <section class="product-section-marketplace">
        <div class="scroll-container-marketplace">
            <button class="scroll-btn-marketplace left" aria-label="Scroll left">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>

            <div class="product-list-marketplace">
                <?php
                // Query Ambil Semua Produk (Terbaru, tanpa filter kategori)
                $query_all = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");

                if (mysqli_num_rows($query_all) > 0) {
                    while ($row = mysqli_fetch_assoc($query_all)) {
                        ?>
                        <div class="product-card-marketplace">
                            <div class="product-image-placeholder">
                                <img src="images/products/<?= $row['gambar']; ?>" alt="<?= $row['nama_produk']; ?>"
                                    style="width:100%; height:100%; object-fit:cover;">
                            </div>

                            <p class="product-name"><?= $row['nama_produk']; ?></p>
                            <p class="product-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>

                            <?php if ($row['stok'] > 0): ?>
                                <p class="product-status available">Tersedia</p>
                            <?php else: ?>
                                <p class="product-status preorder" style="background:#ffebee; color:red;">Habis</p>
                            <?php endif; ?>

                            <button class="btn-belanja mobile"
                                style="display:block; width:100%; margin-top:10px; margin-left:0; padding:8px; font-size:12px; border:1px solid #000;"
                                onclick="event.stopPropagation(); addToCart('<?= $row['nama_produk']; ?>', <?= $row['harga']; ?>)">
                                + Keranjang
                            </button>
                        </div>
                    <?php
                    } // End While
                } else {
                    echo "<p style='padding:20px; text-align:center; width:100%;'>Belum ada produk yang diupload.</p>";
                }
                ?>
            </div>

            <button class="scroll-btn-marketplace right" aria-label="Scroll right">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>
    </section>


    <section class="brand-section-marketplace">
        <div class="brand-container">
            <div class="brand-logo-sidebar">
                <img src="./images/yamaha.png" alt="Logo Yamaha" class="brand-img-placeholder">
            </div>

            <div class="brand-product-slider">
                <div class="scroll-container-marketplace">
                    <button class="scroll-btn-marketplace left" aria-label="Scroll left">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>

                    <div class="product-list-marketplace">
                        <?php
                        // Query Khusus Yamaha
                        // Pastikan saat upload produk, pilih Kategori: Yamaha
                        $yamaha_query = mysqli_query($conn, "SELECT * FROM produk WHERE kategori LIKE '%Yamaha%' LIMIT 10");

                        if (mysqli_num_rows($yamaha_query) > 0) {
                            while ($row = mysqli_fetch_assoc($yamaha_query)) {
                                ?>
                                <div class="product-card-marketplace">
                                    <div class="product-image-placeholder">
                                        <img src="images/products/<?= $row['gambar']; ?>"
                                            style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                    <p class="product-name"><?= $row['nama_produk']; ?></p>
                                    <p class="product-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>

                                    <?php if ($row['stok'] > 0): ?>
                                        <p class="product-status available">Tersedia</p>
                                    <?php else: ?>
                                        <p class="product-status preorder" style="background:#ffebee; color:red;">Habis</p>
                                    <?php endif; ?>

                                    <button class="btn-belanja mobile"
                                        style="display:block; width:100%; margin-top:10px; margin-left:0; padding:8px; font-size:12px; border:1px solid #000;"
                                        onclick="event.stopPropagation(); addToCart('<?= $row['nama_produk']; ?>', <?= $row['harga']; ?>)">
                                        + Keranjang
                                    </button>
                                </div>
                            <?php
                            }
                        } else {
                            echo "<p style='padding:10px;'>Produk Yamaha belum tersedia.</p>";
                        }
                        ?>
                    </div>

                    <button class="scroll-btn-marketplace right" aria-label="Scroll right">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>


    <section class="brand-section-marketplace">
        <div class="brand-container">
            <div class="brand-logo-sidebar">
                <img src="./images/bromo.png" alt="Logo Fender" class="brand-img-placeholder">
            </div>

            <div class="brand-product-slider">
                <div class="scroll-container-marketplace">
                    <button class="scroll-btn-marketplace left" aria-label="Scroll left">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>

                    <div class="product-list-marketplace">
                        <?php
                        // Query Khusus Fender
                        $fender_query = mysqli_query($conn, "SELECT * FROM produk WHERE kategori LIKE '%Fender%' LIMIT 10");

                        if (mysqli_num_rows($fender_query) > 0) {
                            while ($row = mysqli_fetch_assoc($fender_query)) {
                                ?>
                                <div class="product-card-marketplace">
                                    <div class="product-image-placeholder">
                                        <img src="images/products/<?= $row['gambar']; ?>"
                                            style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                    <p class="product-name"><?= $row['nama_produk']; ?></p>
                                    <p class="product-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>

                                    <?php if ($row['stok'] > 0): ?>
                                        <p class="product-status available">Tersedia</p>
                                    <?php else: ?>
                                        <p class="product-status preorder" style="background:#ffebee; color:red;">Habis</p>
                                    <?php endif; ?>

                                    <button class="btn-belanja mobile"
                                        style="display:block; width:100%; margin-top:10px; margin-left:0; padding:8px; font-size:12px; border:1px solid #000;"
                                        onclick="event.stopPropagation(); addToCart('<?= $row['nama_produk']; ?>', <?= $row['harga']; ?>)">
                                        + Keranjang
                                    </button>
                                </div>
                            <?php
                            }
                        } else {
                            echo "<p style='padding:10px;'>Produk Fender belum tersedia.</p>";
                        }
                        ?>
                    </div>

                    <button class="scroll-btn-marketplace right" aria-label="Scroll right">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <section class="brand-section-marketplace">
        <div class="brand-container">
            <div class="brand-logo-sidebar">
                <img src="./images/bromo.png" alt="Logo Bromo" class="brand-img-placeholder">
            </div>

            <div class="brand-product-slider">
                <div class="scroll-container-marketplace">
                    <button class="scroll-btn-marketplace left" aria-label="Scroll left">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </button>

                    <div class="product-list-marketplace">
                        <?php
                        // Query Khusus Bromo
                        $bromo_query = mysqli_query($conn, "SELECT * FROM produk WHERE kategori LIKE '%Bromo%' LIMIT 10");

                        if (mysqli_num_rows($bromo_query) > 0) {
                            while ($row = mysqli_fetch_assoc($bromo_query)) {
                                ?>
                                <div class="product-card-marketplace">
                                    <div class="product-image-placeholder">
                                        <img src="images/products/<?= $row['gambar']; ?>"
                                            style="width:100%; height:100%; object-fit:cover;">
                                    </div>
                                    <p class="product-name"><?= $row['nama_produk']; ?></p>
                                    <p class="product-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>

                                    <?php if ($row['stok'] > 0): ?>
                                        <p class="product-status available">Tersedia</p>
                                    <?php else: ?>
                                        <p class="product-status preorder" style="background:#ffebee; color:red;">Habis</p>
                                    <?php endif; ?>

                                    <button class="btn-belanja mobile"
                                        style="display:block; width:100%; margin-top:10px; margin-left:0; padding:8px; font-size:12px; border:1px solid #000;"
                                        onclick="event.stopPropagation(); addToCart('<?= $row['nama_produk']; ?>', <?= $row['harga']; ?>)">
                                        + Keranjang
                                    </button>
                                </div>
                            <?php
                            }
                        } else {
                            echo "<p style='padding:10px;'>Produk Bromo belum tersedia.</p>";
                        }
                        ?>
                    </div>

                    <button class="scroll-btn-marketplace right" aria-label="Scroll right">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <?php include './includes/footer.php'; ?>

    <div id="cartModal" class="cart-modal" style="display:none;">
        <div class="cart-content">
            <span class="close-cart">&times;</span>
            <h2>Keranjang Belanja</h2>

            <div id="cartItemsContainer">
                <p style="text-align:center; color:#999;">Keranjang masih kosong.</p>
            </div>

            <div class="cart-summary">
                <p>Total: <strong id="cartTotal">Rp 0</strong></p>
            </div>

            <div class="buyer-form" style="margin-top:20px; border-top:1px solid #eee; padding-top:15px;">
                <input type="text" id="buyerName" placeholder="Nama Anda"
                    style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd; border-radius:5px;">
                <input type="text" id="buyerWA" placeholder="Nomor WhatsApp (08xx)"
                    style="width:100%; padding:10px; margin-bottom:10px; border:1px solid #ddd; border-radius:5px;">
                <button id="btnCheckout"
                    style="width:100%; padding:12px; background:#25D366; color:white; border:none; border-radius:5px; font-weight:bold; cursor:pointer;">
                    Checkout ke WhatsApp
                </button>
            </div>
        </div>
    </div>

    <script src="./includes/script.js"></script>

</body>

</html>