var elementToCount = document.querySelectorAll(".count");
var sendUp = document.querySelector(".send_up");
var EventList = document.querySelectorAll(".CalenderEvent");
const Loader = document.querySelector(".events .loader");

$(document).ready(function () {
  $("#autoWidth,#autoWidth2").lightSlider({
    autoWidth: true,
    loop: true,
    auto: true,
    dots: true,
    speed: 1500,
    pause: 6000,
    controls: true,
    onSliderLoad: function () {
      $("#autoWidth,#autoWidth2").removeClass("cS-hidden");
    },
  });
  $("#slick").slick({
    dots: false,
    lazyLoad: "ondemand",
    infinite: true,
    autoplay: true,
    arrows: false,
  });
});

$(document).ready(function () {
  //AO
  AOS.init();
});

$(document).ready(function () {
  $("#autoWidth3").lightSlider({
    autoWidth: true,
    loop: true,
    auto: true,
    dots: true,
    speed: 1500,
    pause: 6000,
    controls: false,
    onSliderLoad: function () {
      $("#autoWidth3").removeClass("cS-hidden");
    },
  });
});

window.onload = () => {
  //  for (let i = 0; i < elementToCount.length; i++) {
  //     const element = elementToCount[i];}
  elementToCount.forEach((value) => {
    const CountDown = () => {
      if (isNaN(parseInt(value.getAttribute("data-target")))) {
        value.innerText = 0;
      } else {
        Target = parseInt(value.getAttribute("data-target"));
        count = +value.innerText;
        speed = 200;
        increment = Math.trunc(Target / speed);
        if (Target < 10) {
          value.innerText = Target;
        } else if (count < Target && Target > 0) {
          value.innerText = Math.ceil(count + increment);
          setTimeout(CountDown, 40);
        } else {
          value.innerText = Target;
        }
      }
    };
    CountDown();
  });
};

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

for (var i = 0; i < EventList.length; i++) {
  const element = EventList[i];
  element.onclick = function () {
    Loader.classList.add("active");
  };
}
// setTimeout(function(){
//     Loader.classList.remove('active');
//  },40)
