// ========================================
// HAMBURGER MENU TOGGLE
// ========================================
const hamburger = document.querySelector(".hamburger");
const mainNav = document.querySelector(".main-nav");
const body = document.body;

hamburger.addEventListener("click", () => {
  hamburger.classList.toggle("active");
  mainNav.classList.toggle("active");
  body.style.overflow = mainNav.classList.contains("active") ? "hidden" : "";
});

// Close menu when clicking on nav links
const navLinks = document.querySelectorAll(".main-nav a");
navLinks.forEach((link) => {
  link.addEventListener("click", () => {
    hamburger.classList.remove("active");
    mainNav.classList.remove("active");
    body.style.overflow = "";
  });
});

// Close menu when clicking outside
document.addEventListener("click", (e) => {
  if (!mainNav.contains(e.target) && !hamburger.contains(e.target)) {
    hamburger.classList.remove("active");
    mainNav.classList.remove("active");
    body.style.overflow = "";
  }
});

// ========================================
// STICKY HEADER ON SCROLL
// ========================================
const header = document.querySelector(".site-header");

window.addEventListener("scroll", () => {
  if (window.scrollY > 100) {
    header.classList.add("scrolled");
  } else {
    header.classList.remove("scrolled");
  }
});

// ========================================
// SCROLL ANIMATIONS WITH INTERSECTION OBSERVER
// ========================================
const observerOptions = {
  threshold: 0.15,
  rootMargin: "0px 0px -50px 0px",
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      const delay = entry.target.getAttribute("data-delay") || 0;

      setTimeout(() => {
        entry.target.classList.add("animated");
      }, delay);

      // Stop observing after animation
      observer.unobserve(entry.target);
    }
  });
}, observerOptions);

// Observe all elements with data-animate attribute
const animateElements = document.querySelectorAll("[data-animate]");
animateElements.forEach((el) => observer.observe(el));

// ========================================
// SMOOTH SCROLL FOR ANCHOR LINKS
// ========================================
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    const href = this.getAttribute("href");

    // Skip if href is just "#"
    if (href === "#") {
      e.preventDefault();
      return;
    }

    const target = document.querySelector(href);
    if (target) {
      e.preventDefault();

      const headerHeight = header.offsetHeight;
      const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - headerHeight;

      window.scrollTo({
        top: targetPosition,
        behavior: "smooth",
      });
    }
  });
});

// ========================================
// INITIAL HERO ANIMATION ON PAGE LOAD
// ========================================
window.addEventListener("load", () => {
  const heroElements = document.querySelectorAll(".hero-content [data-animate]");

  heroElements.forEach((el, index) => {
    const baseDelay = parseInt(el.getAttribute("data-delay")) || 0;
    const totalDelay = baseDelay + index * 100;

    setTimeout(() => {
      el.classList.add("animated");
    }, totalDelay);
  });
});

// ========================================
// MARKETPLACE - HAMBURGER MENU
// ========================================
const hamburgerMarketplace = document.querySelector(".hamburger-marketplace");
const navRightMarketplace = document.querySelector(".nav-right-marketplace");

if (hamburgerMarketplace && navRightMarketplace) {
  hamburgerMarketplace.addEventListener("click", () => {
    hamburgerMarketplace.classList.toggle("active");
    navRightMarketplace.classList.toggle("active");
    body.style.overflow = navRightMarketplace.classList.contains("active") ? "hidden" : "";
  });

  // Close menu when clicking on nav links
  const navLinksMarketplace = navRightMarketplace.querySelectorAll("a");
  navLinksMarketplace.forEach((link) => {
    link.addEventListener("click", () => {
      hamburgerMarketplace.classList.remove("active");
      navRightMarketplace.classList.remove("active");
      body.style.overflow = "";
    });
  });

  // Close menu when clicking outside
  document.addEventListener("click", (e) => {
    if (!navRightMarketplace.contains(e.target) && !hamburgerMarketplace.contains(e.target)) {
      hamburgerMarketplace.classList.remove("active");
      navRightMarketplace.classList.remove("active");
      body.style.overflow = "";
    }
  });
}

// ========================================
// MARKETPLACE - SCROLL BUTTONS
// ========================================
function getScrollDistance() {
  if (window.innerWidth >= 1025) {
    return 360; // Desktop: scroll ~1.5 cards
  }
  return 0; // Tablet/Mobile: buttons hidden
}

function updateButtonState(container) {
  const list = container.querySelector(".product-list-marketplace");
  const btnLeft = container.querySelector(".scroll-btn-marketplace.left");
  const btnRight = container.querySelector(".scroll-btn-marketplace.right");

  if (!list || !btnLeft || !btnRight) return;

  // Disable left button if at start
  btnLeft.disabled = list.scrollLeft <= 5;

  // Disable right button if at end
  const maxScroll = list.scrollWidth - list.clientWidth;
  btnRight.disabled = list.scrollLeft >= maxScroll - 5;
}

// Initialize scroll containers
document.querySelectorAll(".scroll-container-marketplace").forEach((container) => {
  const list = container.querySelector(".product-list-marketplace");
  const btnLeft = container.querySelector(".scroll-btn-marketplace.left");
  const btnRight = container.querySelector(".scroll-btn-marketplace.right");

  if (btnLeft && btnRight && list) {
    // Initial button state
    updateButtonState(container);

    // Left button click
    btnLeft.addEventListener("click", () => {
      const distance = getScrollDistance();
      if (distance > 0) {
        list.scrollBy({ left: -distance, behavior: "smooth" });
      }
    });

    // Right button click
    btnRight.addEventListener("click", () => {
      const distance = getScrollDistance();
      if (distance > 0) {
        list.scrollBy({ left: distance, behavior: "smooth" });
      }
    });

    // Update button state on scroll
    list.addEventListener("scroll", () => {
      updateButtonState(container);
    });

    // Update on window resize
    window.addEventListener("resize", () => {
      updateButtonState(container);
    });
  }
});

// ========================================
// MARKETPLACE - KEYBOARD NAVIGATION
// ========================================
let focusedContainer = null;

document.querySelectorAll(".scroll-container-marketplace").forEach((container) => {
  container.addEventListener("mouseenter", () => {
    focusedContainer = container;
  });

  container.addEventListener("mouseleave", () => {
    focusedContainer = null;
  });
});

document.addEventListener("keydown", (e) => {
  if (!focusedContainer) return;

  const list = focusedContainer.querySelector(".product-list-marketplace");
  if (!list) return;

  const distance = getScrollDistance();

  if (e.key === "ArrowLeft" && distance > 0) {
    e.preventDefault();
    list.scrollBy({ left: -distance, behavior: "smooth" });
  } else if (e.key === "ArrowRight" && distance > 0) {
    e.preventDefault();
    list.scrollBy({ left: distance, behavior: "smooth" });
  }
});

// ========================================
// MARKETPLACE - BANNER SLIDER (BASIC)
// ========================================
const bannerLeftBtn = document.querySelector(".banner-arrow.left");
const bannerRightBtn = document.querySelector(".banner-arrow.right");
const bannerDots = document.querySelectorAll(".banner-dots .dot");

let currentSlide = 0;
const totalSlides = bannerDots.length;

function updateBannerDots() {
  bannerDots.forEach((dot, index) => {
    dot.classList.toggle("active", index === currentSlide);
  });
}

if (bannerLeftBtn && bannerRightBtn) {
  bannerLeftBtn.addEventListener("click", () => {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateBannerDots();
    // TODO: Add actual slide change logic here
  });

  bannerRightBtn.addEventListener("click", () => {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateBannerDots();
    // TODO: Add actual slide change logic here
  });
}

bannerDots.forEach((dot, index) => {
  dot.addEventListener("click", () => {
    currentSlide = index;
    updateBannerDots();
    // TODO: Add actual slide change logic here
  });
});

// Auto-slide every 5 seconds
setInterval(() => {
  if (window.innerWidth >= 769) {
    // Only on desktop/tablet
    currentSlide = (currentSlide + 1) % totalSlides;
    updateBannerDots();
  }
}, 5000);

// ========================================
// MARKETPLACE - PRODUCT CARD INTERACTION
// ========================================
document.querySelectorAll(".product-card-marketplace").forEach((card) => {
  card.addEventListener("click", () => {
    const productName = card.querySelector(".product-name").textContent;
    console.log("Product clicked:", productName);
    // TODO: Add navigation to product detail page
    // window.location.href = `product-detail.php?name=${encodeURIComponent(productName)}`;
  });

  // Add keyboard accessibility
  card.setAttribute("tabindex", "0");
  card.setAttribute("role", "button");

  card.addEventListener("keypress", (e) => {
    if (e.key === "Enter" || e.key === " ") {
      e.preventDefault();
      card.click();
    }
  });
});

// ========================================
// MARKETPLACE - CART FUNCTIONALITY (BASIC)
// ========================================
const cartLink = document.querySelector(".cart-link");
const cartBadge = document.querySelector(".cart-badge");
let cartCount = 0;

function updateCartBadge() {
  if (cartBadge) {
    cartBadge.textContent = cartCount;
    cartBadge.style.display = cartCount > 0 ? "flex" : "none";
  }
}

// Initialize cart badge
updateCartBadge();

// Example: Add to cart functionality (can be triggered from product cards)
window.addToCart = function () {
  cartCount++;
  updateCartBadge();

  // Optional: Show notification
  console.log("Product added to cart! Total items:", cartCount);
};

// ========================================
// MARKETPLACE - SMOOTH SCROLL TO TOP
// ========================================
function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

// Optional: Add "Back to Top" button when scrolled down
let backToTopBtn = null;

window.addEventListener("scroll", () => {
  if (window.scrollY > 500) {
    if (!backToTopBtn) {
      backToTopBtn = document.createElement("button");
      backToTopBtn.innerHTML = "↑";
      backToTopBtn.className = "back-to-top-btn";
      backToTopBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #E53935;
        color: #fff;
        border: none;
        font-size: 24px;
        cursor: pointer;
        z-index: 999;
        box-shadow: 0 4px 12px rgba(229, 57, 53, 0.4);
        transition: all 0.3s ease;
      `;
      backToTopBtn.addEventListener("click", scrollToTop);
      document.body.appendChild(backToTopBtn);

      setTimeout(() => {
        backToTopBtn.style.opacity = "1";
        backToTopBtn.style.transform = "scale(1)";
      }, 10);

      backToTopBtn.style.opacity = "0";
      backToTopBtn.style.transform = "scale(0.8)";
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
// MARKETPLACE - LAZY LOADING IMAGES
// ========================================
// TODO: When you add real images, implement lazy loading
// Example:
// const imageObserver = new IntersectionObserver((entries, observer) => {
//   entries.forEach(entry => {
//     if (entry.isIntersecting) {
//       const img = entry.target;
//       img.src = img.dataset.src;
//       img.classList.add('loaded');
//       observer.unobserve(img);
//     }
//   });
// });
//
// document.querySelectorAll('img[data-src]').forEach(img => {
//   imageObserver.observe(img);
// });

console.log("Marketplace JavaScript loaded successfully! 🎸");
