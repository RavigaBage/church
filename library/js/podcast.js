$(document).ready(function () {
  var slider = $("#autoWidth").lightSlider({
    autoWidth: true,
    loop: true,
    dots: false,
    controls: false,
    onSliderLoad: function () {
      $("#autoWidth").removeClass("cS-hidden");
    },
  });
  $("#slidePrev").click(function () {
    slider.goToPrevSlide();
  });
  $("#slideNext").click(function () {
    slider.goToNextSlide();
  });

  var slider2 = $("#autoWidth2").lightSlider({
    autoWidth: true,
    loop: true,
    dots: false,
    controls: false,
    onSliderLoad: function () {
      $("#autoWidth2").removeClass("cS-hidden");
    },
  });
  $("#slidePrev2").click(function () {
    slider2.goToPrevSlide();
  });
  $("#slideNext2").click(function () {
    slider2.goToNextSlide();
  });
});

var swiper = new Swiper(".swiper_class", {
  effect: "coverflow",
  grabCursor: true,
  centeredSlides: true,
  slidesPerView: "auto",
  coverflowEffect: {
    rotate: 0,
    stretch: 0,
    depth: 100,
    modifier: 2,
    slideShadows: true,
  },
  loop: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
});

//   var swiper = new Swiper(".review-slider", {
//       slidesPerView: 1,
//       grabCursor: true,
//       loop:true,
//       spaceBetween: 10,
//       breakpoints: {
//         0: {
//             slidesPerView: 1,
//         },
//         700: {
//           slidesPerView: 2,
//         },
//         1050: {
//           slidesPerView: 3,
//         },
//       },
//       autoplay:{
//         delay: 5000,
//         disableOnInteraction:false,
//     }
//   });
