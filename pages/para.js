const TextVal = document.querySelector("h1.main");
const cloud_1 = document.querySelector(".cloud_1");
const cloud_2 = document.querySelector(".cloud_2");
const moon = document.querySelector(".moon");
const trees = document.querySelector(".tree");
const mountains = document.querySelector(".mountain");
const toggle = document.querySelector(".menu_toggle");
const menuDiv = document.querySelector(".navigation");
var sendUp = document.querySelector(".send_up");

window.addEventListener("scroll", function (e) {
  percentageY = this.scrollY / 5;
  TextVal.style.bottom = percentageY + "%";
  cloud_2.style.right = percentageY + "%";
  cloud_1.style.left = percentageY + "%";
});

toggle.addEventListener("click", function (e) {
  toggle.classList.toggle("active");
  menuDiv.classList.toggle("active");
});

document.addEventListener("scroll", function () {
  if (window.scrollY > 100) {
    sendUp.classList.add("active");
  } else {
    sendUp.classList.remove("active");
  }
});
var rootElement = document.documentElement;
sendUp.addEventListener("click", function () {
  rootElement.scrollTo({
    top: 0,
    behavior: "smooth",
  });
});
