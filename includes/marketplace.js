// fungsi tombol scroll
document.querySelectorAll(".scroll-container").forEach((container) => {
  const list = container.querySelector(".product-list");
  const btnLeft = container.querySelector(".scroll-btn.left");
  const btnRight = container.querySelector(".scroll-btn.right");

  if (btnLeft && btnRight && list) {
    btnLeft.addEventListener("click", () => {
      list.scrollBy({ left: -300, behavior: "smooth" });
    });
    btnRight.addEventListener("click", () => {
      list.scrollBy({ left: 300, behavior: "smooth" });
    });
  }
});
