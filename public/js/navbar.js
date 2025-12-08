document.addEventListener("DOMContentLoaded", function () {
  const navToggle = document.getElementById("nav-toggle");
  const sideNav = document.getElementById("side-nav");
  const closeNav = document.getElementById("close-nav");

  // Vérifier que tous les éléments existent avant d'ajouter les event listeners
  if (navToggle && sideNav && closeNav) {
    navToggle.addEventListener("click", function () {
      sideNav.classList.add("show");
    });

    closeNav.addEventListener("click", function () {
      sideNav.classList.remove("show");
    });
  }
});
