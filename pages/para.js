const TextVal = document.querySelector("h1.main");
const cloud_1 = document.querySelector(".cloud_1");
const cloud_2 = document.querySelector(".cloud_2");
const moon = document.querySelector(".moon");
const trees = document.querySelector(".tree");
const mountains = document.querySelector(".mountain");

const ChristmasPage = document.querySelector("#christmas_theme");
// if ('serviceWorker' in navigator) {
//   window.addEventListener('load', () => {
//     navigator.serviceWorker
//       .register('service-worker.js')
//       .then((reg) => console.log('Service Worker: Registered (Scope: ' + reg.scope + ')'))
//       .catch((err) => console.log('Service Worker: Error:', err));
//   });
// }

window.addEventListener("scroll", function (e) {
  percentageY = this.scrollY / 5;
  TextVal.style.bottom = percentageY + "%";
  mountains.style.bottom = -1 * percentageY + "%";
  cloud_2.style.right = percentageY + "%";
  cloud_1.style.left = percentageY + "%";
  ChristmasPage.style.setProperty('--scroll', (percentageY / 3) + "px");
});

