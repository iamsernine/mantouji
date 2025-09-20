document.addEventListener("DOMContentLoaded", function () {
  const navToggle = document.getElementById("nav-toggle");
  const sideNav = document.getElementById("side-nav");
  const closeNav = document.getElementById("close-nav");

  navToggle.addEventListener("click", function () {
    sideNav.classList.add("show");
  });

  closeNav.addEventListener("click", function () {
    sideNav.classList.remove("show");
  });
});
