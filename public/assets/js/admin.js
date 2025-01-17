document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const sidebarToggle = document.getElementById("sidebar-toggle");
  if (sidebar && sidebarToggle) {
    sidebarToggle.onclick = () => {
      sidebar.classList.toggle("open");
      sidebar.classList.toggle("closed");
    };
  }
});
