const toggle = document.querySelector(".menu_toggle");
const menuDiv = document.querySelector(".nav_ele");
const LinksA = document.querySelectorAll(".nav_ele a");
toggle.addEventListener("click", function (e) {
  toggle.classList.toggle("active");
  menuDiv.classList.toggle("active");
});
LinksA.forEach((element) => {
  element.addEventListener("click", function (e) {
    toggle.classList.remove("active");
    menuDiv.classList.remove("active");
  });
});

window.addEventListener("scroll", function (e) {
  console.log(scrollY);
});

const Elements = document.querySelectorAll("section");
const Indicator = document.querySelector(".line_right .menu_name p");
const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      SectionName = entry.target.getAttribute("id");
      Indicator.innerText = `${SectionName} section`;
    }
  });
});
Elements.forEach((el) => observer.observe(el));
