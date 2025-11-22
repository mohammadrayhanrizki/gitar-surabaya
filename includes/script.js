/**
 * ==========================================
 * GITAR SURABAYA - MAIN SCRIPT
 * Version: 2.1 (Restored)
 * ==========================================
 */

document.addEventListener("DOMContentLoaded", () => {
    console.log("🚀 Gitar Surabaya Script Restored Successfully!");

    // ==========================================
    // 1. GLOBAL UI & NAVIGATION
    // ==========================================
    initGlobalUI();

    // ==========================================
    // 2. MARKETPLACE SPECIFIC UI
    // ==========================================
    initMarketplaceUI();

    // ==========================================
    // 3. SEARCH FUNCTIONALITY
    // ==========================================
    initSearch();

    // ==========================================
    // 4. SHOPPING CART LOGIC
    // ==========================================
    initShoppingCart();

    // ==========================================
    // 5. REALTIME UPDATES (PUSHER)
    // ==========================================
    initPusher();
});

/**
 * 1. GLOBAL UI FUNCTIONS
 */
function initGlobalUI() {
    // Sticky Navbar - Marketplace
    const navbar = document.querySelector(".navbar-marketplace");
    if (navbar) {
        window.addEventListener("scroll", () => {
            if (!navbar) return;
            if (window.scrollY > 50) {
                if (!navbar.classList.contains("scrolled")) navbar.classList.add("scrolled");
            } else {
                if (navbar.classList.contains("scrolled")) navbar.classList.remove("scrolled");
            }
        });
    }

    // Sticky Navbar - Site Header (index, galeri, layanan)
    const siteHeader = document.querySelector(".site-header");
    if (siteHeader) {
        window.addEventListener("scroll", () => {
            if (!siteHeader) return;
            if (window.scrollY > 50) {
                if (!siteHeader.classList.contains("scrolled")) siteHeader.classList.add("scrolled");
            } else {
                if (siteHeader.classList.contains("scrolled")) siteHeader.classList.remove("scrolled");
            }
        });
    }


    // Hamburger Menu - Marketplace
    const hamburger = document.querySelector(".hamburger-marketplace");
    const navRight = document.querySelector(".nav-right-marketplace");
    
    if (hamburger && navRight) {
        hamburger.addEventListener("click", (e) => {
            e.stopPropagation();
            hamburger.classList.toggle("active");
            navRight.classList.toggle("active");
        });

        document.addEventListener("click", (e) => {
            if (navRight.classList.contains("active") && 
                !navRight.contains(e.target) && 
                !hamburger.contains(e.target)) {
                hamburger.classList.remove("active");
                navRight.classList.remove("active");
            }
        });
    }

    // Hamburger Menu - Site Header (index, galeri, layanan)
    const hamburgerSite = document.querySelector(".hamburger");
    const mainNav = document.querySelector(".main-nav");
    
    if (hamburgerSite && mainNav) {
        hamburgerSite.addEventListener("click", (e) => {
            e.stopPropagation();
            hamburgerSite.classList.toggle("active");
            mainNav.classList.toggle("active");
        });

        document.addEventListener("click", (e) => {
            if (mainNav.classList.contains("active") && 
                !mainNav.contains(e.target) && 
                !hamburgerSite.contains(e.target)) {
                hamburgerSite.classList.remove("active");
                mainNav.classList.remove("active");
            }
        });
    }

    // Lazy Loading
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const img = entry.target;
                if (img.dataset.src) {
                    img.src = img.dataset.src;
                    img.classList.add("loaded");
                }
                observer.unobserve(img);
            }
        });
    });
    document.querySelectorAll("img[data-src]").forEach((img) => imageObserver.observe(img));

    // Scroll Animations
    const animateObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const delay = el.dataset.delay || 0;
                setTimeout(() => {
                    el.classList.add("animated");
                }, delay);
                observer.unobserve(el);
            }
        });
    });
    document.querySelectorAll("[data-animate]").forEach((el) => animateObserver.observe(el));
}

/**
 * 2. MARKETPLACE UI FUNCTIONS
 */
function initMarketplaceUI() {
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

            if(slides[currentSlide]) slides[currentSlide].classList.add("active");
            if(dots[currentSlide]) dots[currentSlide].classList.add("active");
        }

        if (btnRight) btnRight.addEventListener("click", () => showSlide(currentSlide + 1));
        if (btnLeft) btnLeft.addEventListener("click", () => showSlide(currentSlide - 1));
        
        setInterval(() => showSlide(currentSlide + 1), 5000);

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

    document.querySelectorAll('.scroll-container-marketplace').forEach(container => {
        const list = container.querySelector('.product-list-marketplace');
        const leftBtn = container.querySelector('.scroll-btn-marketplace.left');
        const rightBtn = container.querySelector('.scroll-btn-marketplace.right');
        
        if (list && leftBtn && rightBtn) {
            const scrollAmount = window.innerWidth > 768 ? 300 : 200;
            leftBtn.addEventListener('click', () => list.scrollBy({ left: -scrollAmount, behavior: 'smooth' }));
            rightBtn.addEventListener('click', () => list.scrollBy({ left: scrollAmount, behavior: 'smooth' }));
        }
    });
}

/**
 * 3. SEARCH FUNCTIONALITY
 */
function initSearch() {
    const searchInput = document.querySelector('.search-bar-marketplace input');
    const productCards = document.querySelectorAll('.product-card-marketplace');

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const keyword = e.target.value.toLowerCase().trim();

            productCards.forEach(card => {
                const nameEl = card.querySelector('.product-name');
                if (nameEl) {
                    const productName = nameEl.innerText.toLowerCase();
                    if (productName.includes(keyword)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                }
            });
        });
    }
}

/**
 * 4. SHOPPING CART LOGIC
 */
function initShoppingCart() {
    const cartModal = document.getElementById('cartModal');
    const cartLink = document.querySelector('.cart-link');
    const cartBadge = document.querySelector('.cart-badge');
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    const cartTotalElement = document.getElementById('cartTotal');
    const btnCheckout = document.getElementById('btnCheckout');
    const closeCartBtn = document.querySelector('.close-cart');

    if (!cartModal || !cartLink) return;

    let cart = [];
    try {
        cart = JSON.parse(localStorage.getItem('gitar_cart')) || [];
    } catch (e) {
        console.error("Error parsing cart data:", e);
        localStorage.removeItem('gitar_cart');
        cart = [];
    }

    function updateCartUI() {
        if (cartBadge) {
            cartBadge.textContent = cart.length;
            cartBadge.style.display = cart.length > 0 ? 'flex' : 'none';
        }
        localStorage.setItem('gitar_cart', JSON.stringify(cart));
    }

    function renderCartItems() {
        if (!cartItemsContainer) return;
        cartItemsContainer.innerHTML = '';
        let total = 0;

        if (cart.length === 0) {
            cartItemsContainer.innerHTML = `
                <div class="empty-cart">
                    <i class="fas fa-shopping-basket"></i>
                    <p>Keranjang kosong.</p>
                </div>`;
            if (btnCheckout) {
                btnCheckout.style.opacity = "0.5";
                btnCheckout.style.pointerEvents = "none";
            }
        } else {
            if (btnCheckout) {
                btnCheckout.style.opacity = "1";
                btnCheckout.style.pointerEvents = "auto";
            }
            cart.forEach((item, index) => {
                total += parseInt(item.harga);
                const div = document.createElement('div');
                div.classList.add('cart-item');
                div.innerHTML = `
                    <div class="item-info">
                        <span class="item-name">${item.nama}</span>
                        <span class="item-price">Rp ${item.harga.toLocaleString('id-ID')}</span>
                    </div>
                    <div class="cart-item-remove" data-index="${index}">
                        <i class="fas fa-trash-alt"></i>
                    </div>`;
                cartItemsContainer.appendChild(div);
            });
        }
        if (cartTotalElement) {
            cartTotalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        renderCartItems();
        updateCartUI();
    }

    window.addToCart = function(nama, harga) {
        console.log("Adding to cart:", nama, harga);
        cart.push({ nama: nama, harga: parseInt(harga) });
        updateCartUI();
        
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Masuk!',
                text: `${nama} ditambahkan ke keranjang.`,
                timer: 1500,
                showConfirmButton: false,
                position: 'top-end',
                toast: true,
                background: '#fff',
                color: '#333',
                iconColor: '#25D366'
            });
        } else {
            alert(`${nama} ditambahkan ke keranjang!`);
        }
    };

    cartLink.addEventListener('click', (e) => {
        e.preventDefault();
        renderCartItems();
        cartModal.classList.add('show');
        cartModal.style.display = 'flex';
    });

    if (closeCartBtn) {
        closeCartBtn.addEventListener('click', () => {
            cartModal.classList.remove('show');
            setTimeout(() => { cartModal.style.display = 'none'; }, 300);
        });
    }

    window.addEventListener('click', (e) => {
        if (e.target == cartModal) {
            cartModal.classList.remove('show');
            setTimeout(() => { cartModal.style.display = 'none'; }, 300);
        }
    });

    if (cartItemsContainer) {
        cartItemsContainer.addEventListener('click', (e) => {
            const btn = e.target.closest('.cart-item-remove');
            if (btn) {
                removeFromCart(btn.getAttribute('data-index'));
            }
        });
    }

    if (btnCheckout) {
        btnCheckout.addEventListener('click', () => {
            const namaInput = document.getElementById('buyerName');
            const waInput = document.getElementById('buyerWA');
            const nama = namaInput.value.trim();
            const wa = waInput.value.trim();

            if (cart.length === 0) return;
            
            if (!nama || !wa) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Kurang',
                    text: 'Mohon isi Nama dan Nomor WhatsApp untuk pemesanan!'
                });
                return;
            }

            const total = cart.reduce((sum, item) => sum + item.harga, 0);
            const listBarang = cart.map(item => `- ${item.nama} (Rp ${item.harga.toLocaleString('id-ID')})`).join('\n');
            const nomorAdmin = "6281259970907";
            const textWA = `Halo Gitar Surabaya! 👋%0ASaya mau pesan:%0A%0A${encodeURIComponent(listBarang)}%0A%0ATotal: Rp ${total.toLocaleString('id-ID')}%0A%0ANama: ${nama}%0AWA: ${wa}`;
            const linkWA = `https://wa.me/${nomorAdmin}?text=${textWA}`;

            const originalBtnText = btnCheckout.innerHTML;
            btnCheckout.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

            fetch('checkout_process.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ nama, wa, list: listBarang, total })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    localStorage.removeItem('gitar_cart');
                    cart = [];
                    updateCartUI();
                    cartModal.classList.remove('show');
                    setTimeout(() => { cartModal.style.display = 'none'; }, 300);
                    
                    namaInput.value = '';
                    waInput.value = '';
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Pesanan Dibuat!',
                        text: 'Mengarahkan ke WhatsApp...',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.open(linkWA, '_blank');
                    });
                } else {
                    throw new Error(data.message || 'Database Error');
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'warning',
                    title: 'Koneksi Bermasalah',
                    text: 'Gagal mencatat di database, tapi tetap lanjut ke WhatsApp ya.',
                    showConfirmButton: true
                }).then(() => {
                    window.open(linkWA, '_blank');
                });
            })
            .finally(() => {
                btnCheckout.innerHTML = originalBtnText;
            });
        });
    }

    updateCartUI();
}

/**
 * 5. REALTIME UPDATES (PUSHER)
 */
function initPusher() {
    if (typeof Pusher === 'undefined') return;

    const pusher = new Pusher('122fe5dc53b428646f8b', {
        cluster: 'ap1'
    });

    const channel = pusher.subscribe('marketplace-channel');
    channel.bind('update-produk', function(data) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });

        Toast.fire({
            icon: 'info',
            title: data.message || 'Ada update produk baru!'
        });

        setTimeout(() => {
            location.reload();
        }, 1500);
    });
}
