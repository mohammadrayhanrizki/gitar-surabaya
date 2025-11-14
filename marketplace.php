<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Gitar Surabaya</title>
    <link rel="icon" type="image/png" href="./images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <!-- ===== NAVBAR MARKETPLACE ===== -->
    <header class="navbar-marketplace">
        <div class="navbar-container">
            <div class="logo-marketplace">
                <a href="index.php">
                    <img src="images/logo-1.png" alt="Gitar Surabaya">
                </a>
            </div>

            <!-- Search Bar -->
            <div class="search-bar-marketplace">
                <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
                <input type="text" placeholder="Cari gitar, merek, atau aksesori...">
            </div>

            <!-- Navigation Right (Beranda & Kontak) -->
            <nav class="nav-right-marketplace">
                <a href="index.php">Beranda</a>
                <a href="#kontak">Kontak</a>
            </nav>

            <!-- Cart Icon (Terpisah dari nav) -->
            <a href="#cart" class="cart-link">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="9" cy="21" r="1"></circle>
                    <circle cx="20" cy="21" r="1"></circle>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                </svg>
                <span class="cart-badge">0</span>
            </a>

            <!-- Hamburger Button -->
            <button class="hamburger-marketplace" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    <!-- ===== BANNER SLIDER ===== -->
    <section class="banner-marketplace">
        <button class="banner-arrow left" aria-label="Previous slide">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </button>
        <div class="banner-placeholder">
            <div class="banner-content">
                <h2>Promo Spesial!</h2>
                <p>Diskon hingga 30% untuk semua produk gitar</p>
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

    <!-- ===== SEMUA PRODUK ===== -->
    <section class="product-section-marketplace">
        <h2>Semua Produk</h2>
        <div class="scroll-container-marketplace">
            <button class="scroll-btn-marketplace left" aria-label="Scroll left">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <div class="product-list-marketplace">
                <div class="product-card-marketplace">
                    <div class="product-image-placeholder">
                        <div class="shimmer"></div>
                    </div>
                    <p class="product-name">Yamaha F310</p>
                    <p class="product-price">Rp 1.550.000</p>
                    <p class="product-status available">Tersedia</p>
                </div>
                <div class="product-card-marketplace">
                    <div class="product-image-placeholder">
                        <div class="shimmer"></div>
                    </div>
                    <p class="product-name">Cort AD810</p>
                    <p class="product-price">Rp 3.200.000</p>
                    <p class="product-status available">Tersedia</p>
                </div>
                <div class="product-card-marketplace">
                    <div class="product-image-placeholder">
                        <div class="shimmer"></div>
                    </div>
                    <p class="product-name">Fender CD-60</p>
                    <p class="product-price">Rp 2.850.000</p>
                    <p class="product-status available">Tersedia</p>
                </div>
                <div class="product-card-marketplace">
                    <div class="product-image-placeholder">
                        <div class="shimmer"></div>
                    </div>
                    <p class="product-name">Taylor 110e</p>
                    <p class="product-price">Rp 14.000.000</p>
                    <p class="product-status preorder">Pre-order</p>
                </div>
                <div class="product-card-marketplace">
                    <div class="product-image-placeholder">
                        <div class="shimmer"></div>
                    </div>
                    <p class="product-name">Ibanez V50NJP</p>
                    <p class="product-price">Rp 2.500.000</p>
                    <p class="product-status available">Tersedia</p>
                </div>
                <div class="product-card-marketplace">
                    <div class="product-image-placeholder">
                        <div class="shimmer"></div>
                    </div>
                    <p class="product-name">Epiphone DR-100</p>
                    <p class="product-price">Rp 2.200.000</p>
                    <p class="product-status available">Tersedia</p>
                </div>
            </div>
            <button class="scroll-btn-marketplace right" aria-label="Scroll right">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>
        </div>
    </section>

    <!-- ===== BRAND SECTION - YAMAHA ===== -->
    <section class="brand-section-marketplace">
        <div class="brand-container">
            <div class="brand-logo-marketplace">
                <img src="images/yamaha-logo.png" alt="Yamaha" onerror="this.style.display='none'">
            </div>
            <div class="scroll-container-marketplace">
                <button class="scroll-btn-marketplace left" aria-label="Scroll left">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <div class="product-list-marketplace">
                    <div class="product-card-marketplace">
                        <div class="product-image-placeholder">
                            <div class="shimmer"></div>
                        </div>
                        <p class="product-name">Yamaha F310</p>
                        <p class="product-price">Rp 1.550.000</p>
                        <p class="product-status available">Tersedia</p>
                    </div>
                    <div class="product-card-marketplace">
                        <div class="product-image-placeholder">
                            <div class="shimmer"></div>
                        </div>
                        <p class="product-name">Yamaha C40</p>
                        <p class="product-price">Rp 1.800.000</p>
                        <p class="product-status available">Tersedia</p>
                    </div>
                    <div class="product-card-marketplace">
                        <div class="product-image-placeholder">
                            <div class="shimmer"></div>
                        </div>
                        <p class="product-name">Yamaha APX600</p>
                        <p class="product-price">Rp 5.000.000</p>
                        <p class="product-status available">Tersedia</p>
                    </div>
                    <div class="product-card-marketplace">
                        <div class="product-image-placeholder">
                            <div class="shimmer"></div>
                        </div>
                        <p class="product-name">Yamaha FG800</p>
                        <p class="product-price">Rp 3.400.000</p>
                        <p class="product-status available">Tersedia</p>
                    </div>
                </div>
                <button class="scroll-btn-marketplace right" aria-label="Scroll right">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- ===== BRAND SECTION - FENDER ===== -->
    <section class="brand-section-marketplace">
        <div class="brand-container">
            <div class="brand-logo-marketplace">
                <img src="images/fender-logo.png" alt="Fender" onerror="this.style.display='none'">
            </div>
            <div class="scroll-container-marketplace">
                <button class="scroll-btn-marketplace left" aria-label="Scroll left">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <div class="product-list-marketplace">
                    <div class="product-card-marketplace">
                        <div class="product-image-placeholder">
                            <div class="shimmer"></div>
                        </div>
                        <p class="product-name">Fender CD-60</p>
                        <p class="product-price">Rp 2.850.000</p>
                        <p class="product-status available">Tersedia</p>
                    </div>
                    <div class="product-card-marketplace">
                        <div class="product-image-placeholder">
                            <div class="shimmer"></div>
                        </div>
                        <p class="product-name">Fender FA-125</p>
                        <p class="product-price">Rp 2.100.000</p>
                        <p class="product-status available">Tersedia</p>
                    </div>
                    <div class="product-card-marketplace">
                        <div class="product-image-placeholder">
                            <div class="shimmer"></div>
                        </div>
                        <p class="product-name">Fender Redondo</p>
                        <p class="product-price">Rp 4.500.000</p>
                        <p class="product-status available">Tersedia</p>
                    </div>
                    <div class="product-card-marketplace">
                        <div class="product-image-placeholder">
                            <div class="shimmer"></div>
                        </div>
                        <p class="product-name">Fender Malibu</p>
                        <p class="product-price">Rp 5.200.000</p>
                        <p class="product-status preorder">Pre-order</p>
                    </div>
                </div>
                <button class="scroll-btn-marketplace right" aria-label="Scroll right">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
        <div class="container-footer">
            <div class="footer-logo">
                <img src="./images/logofooter.png" alt="Gitar Surabaya">
            </div>

            <div class="footer-divider"></div>

            <div class="footer-socials">
                <div class="social-item">
                    <img src="./images/ig.png" alt="Instagram">
                    <p>@gitarsurabaya</p>
                </div>
                <div class="social-item">
                    <img src="./images/yt.png" alt="YouTube">
                    <p>gitarsurabaya</p>
                </div>
                <div class="social-item">
                    <img src="./images/wa.png" alt="WhatsApp">
                    <p>+62 812 5997 0907</p>
                </div>
            </div>

            <div class="footer-divider"></div>

            <div class="footer-maps">
                <div class="maps-title">
                    <img src="./images/maps.png" alt="Map">
                    <p>Maps</p>
                </div>
                <p>Jalan Nginden Semolo No.40<br>
                    Surabaya Nginden, Semolowaru, Kec.<br>
                    Sukolilo, Surabaya, Jawa Timur 60119</p>
            </div>
        </div>
    </footer>

    <script src="./includes/script.js"></script>
</body>

</html>