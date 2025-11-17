// ========================================
// MAIN SCRIPT - GITAR SURABAYA
// Berisi logika Navbar, Animasi, Slider, dan Cart Marketplace
// ========================================

document.addEventListener("DOMContentLoaded", () => {
  // ========================================
  // 1. GLOBAL - HAMBURGER MENU
  // ========================================
  const hamburger = document.querySelector(".hamburger");
  const mainNav = document.querySelector(".main-nav");
  const body = document.body;

  if (hamburger && mainNav) {
    hamburger.addEventListener("click", () => {
      hamburger.classList.toggle("active");
      mainNav.classList.toggle("active");
      body.style.overflow = mainNav.classList.contains("active") ? "hidden" : "";
    });

    // Close menu when link clicked
    document.querySelectorAll(".main-nav a").forEach((link) => {
      link.addEventListener("click", () => {
        hamburger.classList.remove("active");
        mainNav.classList.remove("active");
        body.style.overflow = "";
      });
    });

    // Close menu when clicking outside
    document.addEventListener("click", (e) => {
      if (mainNav.classList.contains("active") && !mainNav.contains(e.target) && !hamburger.contains(e.target)) {
        hamburger.classList.remove("active");
        mainNav.classList.remove("active");
        body.style.overflow = "";
      }
    });
  }

  // Padding adjustment for fixed header
  const header = document.querySelector(".site-header");
  const main = document.querySelector(".layanan");
  if (header && main) {
    main.style.paddingTop = header.offsetHeight + 40 + "px";
  }

  // ========================================
  // 2. GLOBAL - SCROLL EFFECTS
  // ========================================

  // Sticky Header
  if (header) {
    window.addEventListener("scroll", () => {
      if (window.scrollY > 100) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }
    });
  }

  // Smooth Scroll for Anchors
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      const href = this.getAttribute("href");
      if (href === "#") {
        e.preventDefault();
        return;
      }

      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        const headerHeight = header ? header.offsetHeight : 0;
        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;
        window.scrollTo({ top: targetPosition, behavior: "smooth" });
      }
    });
  });

  // Scroll to Top Button
  let backToTopBtn = null;
  window.addEventListener("scroll", () => {
    if (window.scrollY > 500) {
      if (!backToTopBtn) {
        backToTopBtn = document.createElement("button");
        backToTopBtn.innerHTML = "↑";
        backToTopBtn.className = "back-to-top-btn";
        backToTopBtn.style.cssText = `
                    position: fixed; bottom: 30px; right: 30px; width: 50px; height: 50px;
                    border-radius: 50%; background: #E53935; color: #fff; border: none;
                    font-size: 24px; cursor: pointer; z-index: 999;
                    box-shadow: 0 4px 12px rgba(229, 57, 53, 0.4); transition: all 0.3s ease; opacity: 0; transform: scale(0.8);
                `;
        backToTopBtn.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
        document.body.appendChild(backToTopBtn);

        // Animate in
        setTimeout(() => {
          backToTopBtn.style.opacity = "1";
          backToTopBtn.style.transform = "scale(1)";
        }, 10);
      }
    } else {
      if (backToTopBtn) {
        backToTopBtn.style.opacity = "0";
        backToTopBtn.style.transform = "scale(0.8)";
        setTimeout(() => {
          if (backToTopBtn && backToTopBtn.parentNode) {
            backToTopBtn.parentNode.removeChild(backToTopBtn);
            backToTopBtn = null;
          }
        }, 300);
      }
    }
  });

  // ========================================
  // 3. GLOBAL - ANIMATIONS (Intersection Observer)
  // ========================================
  const observerOptions = { threshold: 0.15, rootMargin: "0px 0px -50px 0px" };
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const delay = entry.target.getAttribute("data-delay") || 0;
        setTimeout(() => {
          entry.target.classList.add("animated");
        }, delay);
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  document.querySelectorAll("[data-animate]").forEach((el) => observer.observe(el));

  // Initial Hero Animation
  const heroElements = document.querySelectorAll(".hero-content [data-animate]");
  if (heroElements.length > 0) {
    heroElements.forEach((el, index) => {
      const baseDelay = parseInt(el.getAttribute("data-delay")) || 0;
      setTimeout(() => {
        el.classList.add("animated");
      }, baseDelay + index * 100);
    });
  }

  // ========================================
  // 4. MARKETPLACE - UI LOGIC
  // ========================================

  // Sticky Navbar Marketplace
  const navbarMarketplace = document.querySelector(".navbar-marketplace");
  if (navbarMarketplace) {
    window.addEventListener("scroll", () => {
      if (window.scrollY > 100) navbarMarketplace.classList.add("scrolled");
      else navbarMarketplace.classList.remove("scrolled");
    });
  }

  // Hamburger Menu Marketplace
  const hamburgerMarketplace = document.querySelector(".hamburger-marketplace");
  const navRightMarketplace = document.querySelector(".nav-right-marketplace");

  if (hamburgerMarketplace && navRightMarketplace) {
    let isToggling = false;
    hamburgerMarketplace.addEventListener("click", (e) => {
      e.stopPropagation();
      e.preventDefault();
      isToggling = true;
      hamburgerMarketplace.classList.toggle("active");
      navRightMarketplace.classList.toggle("active");
      body.style.overflow = navRightMarketplace.classList.contains("active") ? "hidden" : "";
      setTimeout(() => {
        isToggling = false;
      }, 100);
    });

    navRightMarketplace.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        hamburgerMarketplace.classList.remove("active");
        navRightMarketplace.classList.remove("active");
        body.style.overflow = "";
      });
    });

    document.addEventListener("click", (e) => {
      if (!isToggling && navRightMarketplace.classList.contains("active")) {
        if (!navRightMarketplace.contains(e.target) && !hamburgerMarketplace.contains(e.target)) {
          hamburgerMarketplace.classList.remove("active");
          navRightMarketplace.classList.remove("active");
          body.style.overflow = "";
        }
      }
    });
  }

  // Horizontal Scroll Logic (Product Slider)
  function getScrollDistance() {
    return window.innerWidth >= 1025 ? 360 : 200;
  }

  document.querySelectorAll(".scroll-container-marketplace").forEach((container) => {
    const list = container.querySelector(".product-list-marketplace");
    const btnLeft = container.querySelector(".scroll-btn-marketplace.left");
    const btnRight = container.querySelector(".scroll-btn-marketplace.right");

    if (btnLeft && btnRight && list) {
      const updateButtons = () => {
        btnLeft.disabled = list.scrollLeft <= 5;
        btnRight.disabled = list.scrollLeft >= list.scrollWidth - list.clientWidth - 5;
      };

      btnLeft.addEventListener("click", () => list.scrollBy({ left: -getScrollDistance(), behavior: "smooth" }));
      btnRight.addEventListener("click", () => list.scrollBy({ left: getScrollDistance(), behavior: "smooth" }));
      list.addEventListener("scroll", updateButtons);
      window.addEventListener("resize", updateButtons);
      updateButtons(); // Init
    }
  });

  // Banner Slider Logic (Auto + Manual)
  const bannerDots = document.querySelectorAll(".banner-dots .dot");
  const bannerLeft = document.querySelector(".banner-arrow.left");
  const bannerRight = document.querySelector(".banner-arrow.right");

  if (bannerDots.length > 0) {
    let currentSlide = 0;
    const totalSlides = bannerDots.length;

    function updateBanner() {
      bannerDots.forEach((dot, index) => dot.classList.toggle("active", index === currentSlide));
      // Logic update gambar banner bisa ditambahkan di sini nanti
    }

    if (bannerLeft)
      bannerLeft.addEventListener("click", () => {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        updateBanner();
      });

    if (bannerRight)
      bannerRight.addEventListener("click", () => {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateBanner();
      });

    bannerDots.forEach((dot, index) => {
      dot.addEventListener("click", () => {
        currentSlide = index;
        updateBanner();
      });
    });

    // Auto slide
    setInterval(() => {
      if (window.innerWidth >= 769) {
        currentSlide = (currentSlide + 1) % totalSlides;
        updateBanner();
      }
    }, 5000);
  }

  // Lazy Loading Images
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

  // ========================================
  // 5. MARKETPLACE - SHOPPING CART LOGIC (FINAL)
  // ========================================

  const cartModal = document.getElementById("cartModal");
  const cartLink = document.querySelector(".cart-link");

  if (cartModal && cartLink) {
    // Init Variabel
    let cart = JSON.parse(localStorage.getItem("gitar_cart")) || [];
    const cartBadge = document.querySelector(".cart-badge");
    const cartItemsContainer = document.getElementById("cartItemsContainer");
    const cartTotalElement = document.getElementById("cartTotal");
    const btnCheckout = document.getElementById("btnCheckout");
    const closeCartBtn = document.querySelector(".close-cart");

    // Update UI Badge
    function updateCartUI() {
      if (cartBadge) {
        cartBadge.textContent = cart.length;
        cartBadge.style.display = cart.length > 0 ? "flex" : "none";
      }
      localStorage.setItem("gitar_cart", JSON.stringify(cart));
    }

    // Render List Keranjang
    function renderCartItems() {
      cartItemsContainer.innerHTML = "";
      let total = 0;

      if (cart.length === 0) {
        cartItemsContainer.innerHTML = "<p style='text-align:center; color:#999;'>Keranjang kosong.</p>";
      } else {
        cart.forEach((item, index) => {
          total += parseInt(item.harga);
          let div = document.createElement("div");
          div.classList.add("cart-item");
          div.innerHTML = `
                        <span>${item.nama}</span>
                        <div>
                            <span>Rp ${item.harga.toLocaleString("id-ID")}</span>
                            <span class="cart-item-remove" data-index="${index}" style="cursor:pointer; color:red; margin-left:10px;">×</span>
                        </div>
                    `;
          cartItemsContainer.appendChild(div);
        });
      }
      cartTotalElement.textContent = "Rp " + total.toLocaleString("id-ID");
    }

    // Tambah ke Keranjang (Global Function)
    window.addToCart = function (nama, harga) {
      cart.push({ nama: nama, harga: parseInt(harga) });
      updateCartUI();
      alert(nama + " masuk keranjang!");
    };

    // Hapus Item
    function removeFromCart(index) {
      cart.splice(index, 1);
      renderCartItems();
      updateCartUI();
    }

    // Event Listeners Keranjang
    cartLink.addEventListener("click", (e) => {
      e.preventDefault();
      renderCartItems();
      cartModal.style.display = "flex";
    });

    closeCartBtn.addEventListener("click", () => (cartModal.style.display = "none"));
    window.addEventListener("click", (e) => {
      if (e.target == cartModal) cartModal.style.display = "none";
    });

    // Delete Button Delegation
    cartItemsContainer.addEventListener("click", (e) => {
      if (e.target.classList.contains("cart-item-remove")) {
        removeFromCart(e.target.getAttribute("data-index"));
      }
    });

    // LOGIKA CHECKOUT
    if (btnCheckout) {
      btnCheckout.addEventListener("click", () => {
        const nama = document.getElementById("buyerName").value.trim();
        const wa = document.getElementById("buyerWA").value.trim();

        if (cart.length === 0) return alert("Keranjang kosong!");
        if (!nama || !wa) return alert("Mohon isi Nama dan No. WA!");

        let total = cart.reduce((sum, item) => sum + item.harga, 0);
        let listBarang = cart.map((item) => `- ${item.nama} (Rp ${item.harga.toLocaleString("id-ID")})`).join("\n");

        // GANTI NOMOR WA ADMIN DI SINI
        let nomorAdmin = "6281259970907";
        let textWA = `Halo Gitar Surabaya! 👋%0ASaya mau pesan:%0A%0A${encodeURIComponent(listBarang)}%0A%0ATotal: Rp ${total.toLocaleString("id-ID")}%0A%0ANama: ${nama}%0AWA: ${wa}`;
        let linkWA = `https://wa.me/${nomorAdmin}?text=${textWA}`;

        // Kirim ke Database
        fetch("checkout_process.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ nama, wa, list: listBarang, total }),
        })
          .then((res) => res.json())
          .then((data) => {
            if (data.status === "success") {
              localStorage.removeItem("gitar_cart");
              cart = [];
              updateCartUI();
              cartModal.style.display = "none";

              // Reset Form
              document.getElementById("buyerName").value = "";
              document.getElementById("buyerWA").value = "";

              // Buka WA
              window.open(linkWA, "_blank");
            } else {
              alert("Gagal menyimpan pesanan: " + (data.message || "Error"));
            }
          })
          .catch((err) => {
            console.error(err);
            alert("Terjadi kesalahan koneksi.");
          });
      });
    }

    // Init Cart UI
    updateCartUI();
  }

  console.log("All Scripts Loaded Successfully! 🎸");
}); // End DOMContentLoaded
