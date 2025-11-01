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
