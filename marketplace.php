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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/marketplace.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <style>
        /* Modal Overlay & Content */
        .cart-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(3px);
            z-index: 99999;
            display: none;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .cart-modal.show {
            display: flex;
            opacity: 1;
        }

        .cart-content {
            background: white;
            width: 90%;
            max-width: 450px;
            padding: 25px;
            border-radius: 20px;
            position: relative;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }

        .cart-modal.show .cart-content {
            transform: translateY(0);
        }

        /* Scrollable Items */
        #cartItemsContainer {
            overflow-y: auto;
            max-height: 50vh;
            margin-bottom: 15px;
            padding-right: 5px;
        }

        /* Header & Summary */
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 15px;
            flex-shrink: 0;
        }

        .cart-header h2 {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
            color: #333;
        }

        .close-cart {
            font-size: 24px;
            cursor: pointer;
            color: #999;
            transition: 0.2s;
        }

        .close-cart:hover {
            color: #E53935;
        }

        .cart-summary {
            margin-top: auto;
            padding-top: 15px;
            border-top: 2px dashed #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 16px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .total-price {
            color: #E53935;
            font-size: 18px;
            font-weight: 700;
        }

        /* Items */
        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #F9F9F9;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 10px;
            transition: 0.2s;
            border: 1px solid transparent;
        }

        .cart-item:hover {
            border-color: #ddd;
            background: #fff;
        }

        .item-info {
            display: flex;
            flex-direction: column;
        }

        .item-name {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        .item-price {
            font-size: 13px;
            color: #E53935;
            font-weight: 500;
            margin-top: 2px;
        }

        .cart-item-remove {
            width: 30px;
            height: 30px;
            background: #FFEBEE;
            color: #E53935;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s;
        }

        .cart-item-remove:hover {
            background: #E53935;
            color: white;
        }

        /* Form */
        .buyer-form {
            margin-top: 20px;
            flex-shrink: 0;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 12px;
            border: 1px solid #eee;
            border-radius: 10px;
            background: #fcfcfc;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .form-input:focus {
            border-color: #333;
            background: #fff;
        }

        #btnCheckout {
            width: 100%;
            padding: 14px;
            background: #25D366;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }

        #btnCheckout:hover {
            background: #128C7E;
            transform: translateY(-2px);
        }

        #btnCheckout:active {
            transform: translateY(0);
        }

        .empty-cart {
            text-align: center;
            padding: 30px 0;
            color: #999;
        }

        .empty-cart i {
            font-size: 40px;
            margin-bottom: 10px;
            opacity: 0.3;
        }
    </style>
</head>

<body>

    <header class="navbar-marketplace">
        <div class="navbar-container">
            <div class="logo-marketplace">
                <a href="index.php"><img src="images/logo-1.png" alt="Gitar Surabaya"></a>
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
            <button class="hamburger-marketplace"
                aria-label="Toggle menu"><span></span><span></span><span></span></button>
        </div>
    </header>

    <section class="banner-marketplace">
        <button class="banner-arrow left"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
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
                    <div class="banner-slide <?= $activeClass; ?>"
                        style="background-image: url('images/banners/<?= $row['gambar']; ?>');">
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
        <button class="banner-arrow right"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg></button>
        <div class="banner-dots">
            <?php for ($k = 0; $k < $total_banner; $k++): ?><span class="dot <?= ($k == 0) ? 'active' : ''; ?>"
                    data-index="<?= $k; ?>"></span><?php endfor; ?>
        </div>
    </section>

    <section class="semua-produk">
        <h2>Semua Produk</h2>
    </section>
    <section class="product-section-marketplace">
        <div class="scroll-container-marketplace">
            <button class="scroll-btn-marketplace left"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg></button>
            <div class="product-list-marketplace">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
                if (mysqli_num_rows($query) > 0) {
                    while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <div class="product-card-marketplace"
                            onclick="window.location.href='detail_produk.php?id=<?= $row['id']; ?>'">
                            <div class="product-image-placeholder"><img src="images/products/<?= $row['gambar']; ?>"
                                    style="width:100%; height:100%; object-fit:cover;"></div>
                            <p class="product-name"><?= $row['nama_produk']; ?></p>
                            <p class="product-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                            <?php if ($row['stok'] > 0): ?>
                                <p class="product-status available">Tersedia</p><?php else: ?>
                                <p class="product-status preorder" style="background:#ffebee; color:red;">Habis</p><?php endif; ?>
                            <button class="btn-belanja mobile"
                                style="display:block; width:100%; margin-top:10px; margin-left:0; padding:8px; font-size:12px; border:1px solid #000;"
                                onclick="event.stopPropagation(); addToCart('<?= $row['nama_produk']; ?>', <?= $row['harga']; ?>)">+
                                Keranjang</button>
                        </div>
                    <?php }
                } else {
                    echo "<p style='padding:20px; width:100%; text-align:center;'>Belum ada produk.</p>";
                } ?>
            </div>
            <button class="scroll-btn-marketplace right"><svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg></button>
        </div>
    </section>

    <?php
    $brands = [
        ['name' => 'Yamaha', 'logo' => 'yamaha.png'],
        ['name' => 'Fender', 'logo' => 'logo_fender.png'],
        ['name' => 'Bromo', 'logo' => 'bromo.png'],
        ['name' => 'Cort', 'logo' => 'logo_cort.png'],
        ['name' => 'Taylor', 'logo' => 'logo_taylor.png'],
        ['name' => 'Ibanez', 'logo' => 'logo_ibanez.png'],
        ['name' => 'Aksesoris', 'logo' => 'logo_aksesoris.png', 'query' => "kategori = 'Aksesoris' OR kategori = 'Lainnya'"]
    ];

    foreach ($brands as $brand) {
        $brandName = $brand['name'];
        $brandLogo = $brand['logo'];
        $sqlWhere = isset($brand['query']) ? $brand['query'] : "kategori LIKE '%$brandName%'";
        ?>
        <section class="brand-section-marketplace">
            <div class="brand-container">
                <div class="brand-logo-sidebar">
                    <img src="./images/<?= $brandLogo; ?>" alt="<?= $brandName; ?>" class="brand-img-placeholder"
                        style="object-fit:contain; background:white;">
                    <?php if ($brandName == 'Aksesoris')
                        echo '<p style="text-align:center; font-weight:bold; margin-top:5px;">AKSESORIS</p>'; ?>
                </div>
                <div class="brand-product-slider">
                    <div class="scroll-container-marketplace">
                        <button class="scroll-btn-marketplace left"><svg width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg></button>
                        <div class="product-list-marketplace">
                            <?php
                            $brand_query = mysqli_query($conn, "SELECT * FROM produk WHERE $sqlWhere LIMIT 10");
                            if (mysqli_num_rows($brand_query) > 0) {
                                while ($row = mysqli_fetch_assoc($brand_query)) {
                                    ?>
                                    <div class="product-card-marketplace"
                                        onclick="window.location.href='detail_produk.php?id=<?= $row['id']; ?>'">
                                        <div class="product-image-placeholder"><img src="images/products/<?= $row['gambar']; ?>"
                                                style="width:100%; height:100%; object-fit:cover;"></div>
                                        <p class="product-name"><?= $row['nama_produk']; ?></p>
                                        <p class="product-price">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                                        <?php if ($row['stok'] > 0): ?>
                                            <p class="product-status available">Tersedia</p><?php else: ?>
                                            <p class="product-status preorder" style="background:#ffebee; color:red;">Habis</p>
                                        <?php endif; ?>
                                        <button class="btn-belanja mobile"
                                            style="display:block; width:100%; margin-top:10px; margin-left:0; padding:8px; font-size:12px; border:1px solid #000;"
                                            onclick="event.stopPropagation(); addToCart('<?= $row['nama_produk']; ?>', <?= $row['harga']; ?>)">+
                                            Keranjang</button>
                                    </div>
                                <?php }
                            } else {
                                echo "<p style='padding:10px;'>Produk $brandName belum tersedia.</p>";
                            } ?>
                        </div>
                        <button class="scroll-btn-marketplace right"><svg width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg></button>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>

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
                <input type="tel" id="buyerWA" class="form-input" placeholder="Nomor WhatsApp (08...)"
                    autocomplete="off">
                <button id="btnCheckout"><i class="fab fa-whatsapp"></i> Checkout Sekarang</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // --- 1. HAMBURGER MENU ---
            const hamburger = document.querySelector(".hamburger-marketplace");
            const navRight = document.querySelector(".nav-right-marketplace");
            if (hamburger && navRight) {
                hamburger.addEventListener("click", (e) => {
                    e.stopPropagation();
                    hamburger.classList.toggle("active");
                    navRight.classList.toggle("active");
                });
                document.addEventListener("click", (e) => {
                    if (navRight.classList.contains("active") && !navRight.contains(e.target) && !hamburger.contains(e.target)) {
                        hamburger.classList.remove("active");
                        navRight.classList.remove("active");
                    }
                });
            }

            // --- 2. BANNER SLIDER ---
            const slides = document.querySelectorAll(".banner-slide");
            const dots = document.querySelectorAll(".banner-dots .dot");
            const btnRight = document.querySelector(".banner-arrow.right");
            const btnLeft = document.querySelector(".banner-arrow.left");

            if (slides.length > 0) {
                let currentSlide = 0;
                const totalSlides = slides.length;

                function showSlide(index) {
                    slides.forEach(s => s.classList.remove("active"));
                    dots.forEach(d => d.classList.remove("active"));
                    if (index >= totalSlides) currentSlide = 0;
                    else if (index < 0) currentSlide = totalSlides - 1;
                    else currentSlide = index;
                    slides[currentSlide].classList.add("active");
                    if (dots[currentSlide]) dots[currentSlide].classList.add("active");
                }

                if (btnRight) btnRight.addEventListener("click", () => showSlide(currentSlide + 1));
                if (btnLeft) btnLeft.addEventListener("click", () => showSlide(currentSlide - 1));
                setInterval(() => showSlide(currentSlide + 1), 5000);

                // Swipe
                const wrapper = document.querySelector('.banner-marketplace');
                let touchStartX = 0;
                if (wrapper) {
                    wrapper.addEventListener('touchstart', e => touchStartX = e.changedTouches[0].screenX);
                    wrapper.addEventListener('touchend', e => {
                        if (e.changedTouches[0].screenX < touchStartX - 50) showSlide(currentSlide + 1);
                        if (e.changedTouches[0].screenX > touchStartX + 50) showSlide(currentSlide - 1);
                    });
                }
            }

            // --- 3. SCROLL PRODUCT ---
            document.querySelectorAll('.scroll-container-marketplace').forEach(container => {
                const list = container.querySelector('.product-list-marketplace');
                const leftBtn = container.querySelector('.scroll-btn-marketplace.left');
                const rightBtn = container.querySelector('.scroll-btn-marketplace.right');
                if (list && leftBtn && rightBtn) {
                    leftBtn.addEventListener('click', () => list.scrollBy({ left: -300, behavior: 'smooth' }));
                    rightBtn.addEventListener('click', () => list.scrollBy({ left: 300, behavior: 'smooth' }));
                }
            });

            // --- 4. SHOPPING CART ---
            const cartModal = document.getElementById('cartModal');
            const cartLink = document.querySelector('.cart-link');

            if (cartModal && cartLink) {
                let cart = JSON.parse(localStorage.getItem('gitar_cart')) || [];
                const cartBadge = document.querySelector('.cart-badge');
                const cartItemsContainer = document.getElementById('cartItemsContainer');
                const cartTotalElement = document.getElementById('cartTotal');
                const btnCheckout = document.getElementById('btnCheckout');
                const closeCartBtn = document.querySelector('.close-cart');

                function updateCartUI() {
                    if (cartBadge) {
                        cartBadge.textContent = cart.length;
                        cartBadge.style.display = cart.length > 0 ? 'flex' : 'none';
                    }
                    localStorage.setItem('gitar_cart', JSON.stringify(cart));
                }

                function renderCartItems() {
                    cartItemsContainer.innerHTML = '';
                    let total = 0;
                    if (cart.length === 0) {
                        cartItemsContainer.innerHTML = `<div class="empty-cart" style="text-align:center; color:#999; padding:20px;"><i class="fas fa-shopping-basket" style="font-size:40px; opacity:0.3; margin-bottom:10px;"></i><p>Keranjang kosong.</p></div>`;
                        btnCheckout.style.opacity = "0.5"; btnCheckout.style.pointerEvents = "none";
                    } else {
                        btnCheckout.style.opacity = "1"; btnCheckout.style.pointerEvents = "auto";
                        cart.forEach((item, index) => {
                            total += parseInt(item.harga);
                            let div = document.createElement('div');
                            div.classList.add('cart-item');
                            div.innerHTML = `<div class="item-info"><span class="item-name">${item.nama}</span><span class="item-price">Rp ${item.harga.toLocaleString('id-ID')}</span></div><div class="cart-item-remove" data-index="${index}"><i class="fas fa-trash-alt"></i></div>`;
                            cartItemsContainer.appendChild(div);
                        });
                    }
                    cartTotalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
                }

                // Global Function Add To Cart (SweetAlert)
                window.addToCart = function (nama, harga) {
                    cart.push({ nama: nama, harga: parseInt(harga) });
                    updateCartUI();
                    Swal.fire({
                        icon: 'success', title: 'Berhasil Masuk!', text: nama + ' ditambahkan.',
                        timer: 1500, showConfirmButton: false, position: 'top-end', toast: true,
                        background: '#fff', color: '#333', iconColor: '#25D366'
                    });
                };

                function removeFromCart(index) { cart.splice(index, 1); renderCartItems(); updateCartUI(); }

                cartLink.addEventListener('click', (e) => { e.preventDefault(); renderCartItems(); cartModal.classList.add('show'); });
                closeCartBtn.addEventListener('click', () => cartModal.classList.remove('show'));
                window.addEventListener('click', (e) => { if (e.target == cartModal) cartModal.classList.remove('show'); });
                cartItemsContainer.addEventListener('click', (e) => { const btn = e.target.closest('.cart-item-remove'); if (btn) removeFromCart(btn.getAttribute('data-index')); });

                // CHECKOUT LOGIC
                if (btnCheckout) {
                    btnCheckout.addEventListener('click', () => {
                        const nama = document.getElementById('buyerName').value.trim();
                        const wa = document.getElementById('buyerWA').value.trim();

                        if (cart.length === 0) return;
                        if (!nama || !wa) {
                            Swal.fire({ icon: 'warning', title: 'Data Kurang', text: 'Mohon isi Nama dan Nomor WhatsApp!' });
                            return;
                        }

                        let total = cart.reduce((sum, item) => sum + item.harga, 0);
                        let listBarang = cart.map(item => `- ${item.nama} (Rp ${item.harga.toLocaleString('id-ID')})`).join('\n');
                        let nomorAdmin = "6281259970907";
                        let textWA = `Halo Gitar Surabaya! 👋%0ASaya mau pesan:%0A%0A${encodeURIComponent(listBarang)}%0A%0ATotal: Rp ${total.toLocaleString('id-ID')}%0A%0ANama: ${nama}%0AWA: ${wa}`;
                        let linkWA = `https://wa.me/${nomorAdmin}?text=${textWA}`;

                        // Loading Animation
                        btnCheckout.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

                        fetch('checkout_process.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ nama, wa, list: listBarang, total })
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    localStorage.removeItem('gitar_cart'); cart = []; updateCartUI(); cartModal.classList.remove('show');
                                    document.getElementById('buyerName').value = ''; document.getElementById('buyerWA').value = '';
                                    btnCheckout.innerHTML = '<i class="fab fa-whatsapp"></i> Checkout Sekarang';
                                    Swal.fire({ icon: 'success', title: 'Pesanan Dibuat!', text: 'Mengarahkan ke WhatsApp...', timer: 2000, showConfirmButton: false }).then(() => { window.open(linkWA, '_blank'); });
                                } else {
                                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'DB Error: ' + data.message });
                                    btnCheckout.innerHTML = '<i class="fab fa-whatsapp"></i> Checkout Sekarang';
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Koneksi bermasalah.' });
                                btnCheckout.innerHTML = '<i class="fab fa-whatsapp"></i> Checkout Sekarang';
                            });
                    });
                }
                updateCartUI();
            }
        });

        // --- 5. PUSHER REALTIME ---
        var pusher = new Pusher('122fe5dc53b428646f8b', { cluster: 'ap1' });
        var channel = pusher.subscribe('marketplace-channel');
        channel.bind('update-produk', function (data) {
            const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true, didOpen: (toast) => { toast.onmouseenter = Swal.stopTimer; toast.onmouseleave = Swal.resumeTimer; } });
            Toast.fire({ icon: 'info', title: data.message || 'Ada update produk baru!' });
            setTimeout(() => { location.reload(); }, 1500);
        });
    </script>
</body>

</html>