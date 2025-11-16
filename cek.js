// ========================================
// MARKETPLACE - HORIZONTAL SCROLL LOGIC
// ========================================
document.querySelectorAll(".slider-container").forEach((container) => {
  const track = container.querySelector(".product-scroll-track");
  const btnRight = container.querySelector(".nav-arrow.right");
  const btnLeft = container.querySelector(".nav-arrow.left"); // Jika nanti ditambah tombol kiri

  if (track && btnRight) {
    btnRight.addEventListener("click", () => {
      // Scroll sejauh 300px ke kanan
      track.scrollBy({ left: 300, behavior: "smooth" });
    });
  }

  if (track && btnLeft) {
    btnLeft.addEventListener("click", () => {
      track.scrollBy({ left: -300, behavior: "smooth" });
    });
  }
});
