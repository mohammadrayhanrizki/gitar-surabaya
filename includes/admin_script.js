document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.getElementById("menuToggle");
  const sidebar = document.querySelector(".sidebar");
  const overlay = document.getElementById("sidebarOverlay");

  // Fungsi Buka/Tutup Sidebar
  function toggleSidebar() {
    sidebar.classList.toggle("active");
    overlay.classList.toggle("active");
  }

  if (menuToggle) {
    menuToggle.addEventListener("click", toggleSidebar);
  }

  // Tutup sidebar jika klik overlay (area gelap)
  if (overlay) {
    overlay.addEventListener("click", toggleSidebar);
  }
});
