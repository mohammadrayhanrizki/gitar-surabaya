<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gitar Surabaya</title>
    <link rel="icon" type="image/png" href="./images/logo.png">
    <!-- FONT & STYLES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <!-- NAVBAR -->
    <?php include './includes/navbar.php'; ?>

    <!-- MAIN CONTENT -->
    <main class="content-wrapper">

        <!-- ====== BANNER SLIDER ====== -->
        <section class="banner-slider">
            <div class="slider-placeholder"></div>

            <button class="slider-arrow left-arrow">❮</button>
            <button class="slider-arrow right-arrow">❯</button>
        </section>

        <!-- ====== SEMUA PRODUK ====== -->
        <section class="product-section">
            <h2 class="section-title">Semua Produk</h2>

            <div class="product-list horizontal-scroll">

                <div class="product-card">
                    <div class="product-image-placeholder"></div>
                    <div class="product-info">
                        <p class="product-name">Yamaha F310</p>
                        <p class="product-price">Rp. 999.999.999</p>
                        <p class="product-status">Tersedia</p>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image-placeholder"></div>
                    <div class="product-info">
                        <p class="product-name">Cort AD810</p>
                        <p class="product-price">Rp. 3.200.000</p>
                        <p class="product-status">Tersedia</p>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image-placeholder"></div>
                    <div class="product-info">
                        <p class="product-name">Fender CD-60</p>
                        <p class="product-price">Rp. 2.850.000</p>
                        <p class="product-status">Tersedia</p>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image-placeholder"></div>
                    <div class="product-info">
                        <p class="product-name">Taylor 110e</p>
                        <p class="product-price">Rp. 14.000.000</p>
                        <p class="product-status">Pre-order</p>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image-placeholder"></div>
                    <div class="product-info">
                        <p class="product-name">Ibanez V50NJP</p>
                        <p class="product-price">Rp. 2.500.000</p>
                        <p class="product-status">Tersedia</p>
                    </div>
                </div>

            </div>

            <button class="scroll-arrow right-arrow">❯</button>
        </section>

        <!-- ====== BRAND SECTION ====== -->
        <section class="brand-section">
            <div class="brand-logo-container">
                <img src="images/yamaha-logo.png" alt="Yamaha Logo" class="brand-logo-placeholder">
                <p>YAMAHA</p>
            </div>

            <div class="product-list horizontal-scroll">

                <div class="product-card">
                    <div class="product-image-placeholder"></div>
                    <div class="product-info">
                        <p class="product-name">Yamaha F310</p>
                        <p class="product-price">Rp. 1.550.000</p>
                        <p class="product-status">Tersedia</p>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image-placeholder"></div>
                    <div class="product-info">
                        <p class="product-name">Yamaha C40</p>
                        <p class="product-price">Rp. 1.800.000</p>
                        <p class="product-status">Tersedia</p>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image-placeholder"></div>
                    <div class="product-info">
                        <p class="product-name">Yamaha APX600</p>
                        <p class="product-price">Rp. 5.000.000</p>
                        <p class="product-status">Tersedia</p>
                    </div>
                </div>

                <div class="product-card">
                    <div class="product-image-placeholder"></div>
                    <div class="product-info">
                        <p class="product-name">Yamaha FG800</p>
                        <p class="product-price">Rp. 3.400.000</p>
                        <p class="product-status">Tersedia</p>
                    </div>
                </div>

            </div>

            <button class="scroll-arrow right-arrow">❯</button>
        </section>

    </main>

    <!-- FOOTER -->
    <?php include './includes/footer.php'; ?>

    <script src="./includes/script.js"></script>

</body>

</html>