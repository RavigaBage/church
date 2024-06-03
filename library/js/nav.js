var menuBar = document.querySelector("#triggerMenu");
var sideBar = document.querySelector(".sidebar");
var closeBar = document.querySelector("#closeBar");

function menuDisplay() {
  sideBar.classList.add("active");
}
function menuClose() {
  sideBar.classList.remove("active");
}

menuBar.addEventListener("click", menuDisplay);
closeBar.addEventListener("click", menuClose);
