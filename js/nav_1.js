var toggleBtn = document.querySelector(".Bar");
var closeBtn = document.querySelector(".Bars");
var menu = document.querySelector("#menu");
var nav = document.querySelector("nav");
toggleBtn.addEventListener("click", function (e) {
  if (toggleBtn.classList.contains("fa-bars")) {
    toggleBtn.classList.remove("fa-bars");
    toggleBtn.classList.add("fa-times");
  } else if (toggleBtn.classList.contains("fa-times")) {
    toggleBtn.classList.add("fa-bars");
    toggleBtn.classList.remove("fa-times");
  }
  if (menu.classList.contains("menu")) {
    menu.classList.remove("menu");
    menu.classList.add("menuactive");
    nav.classList.add("active");
  } else {
    menu.classList.remove("menuactive");
    menu.classList.add("menu");
    nav.classList.remove("active");
  }
});

window.addEventListener("scroll", function () {
  if (scrollY > 70) {
    document.querySelector(".navbar").classList.add("hover");
  } else {
    document.querySelector(".navbar").classList.remove("hover");
  }
});
