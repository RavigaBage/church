var form = document.querySelector("#form");
form.onsubmit = function (e) {
  e.preventDefault();
};
var submit = document.querySelector("#submit");
var error = document.querySelector("#error");

submit.onclick = function () {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../php/prayerRequest.php", true);
  xhr.onload = () => {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      if (xhr.status == 200) {
        let data = xhr.response;
        scrollset();
        if (data == "Upload was a success") {
          error.innerHTML =
            "<span style='color:green !important;'>Data entry was a success <i class='fas fa-check'></i></span>";
        } else {
          error.innerHTML = data + "<i class='fas fa-x'></i>";
        }
      }
    }
  };
  let formData = new FormData(form);
  xhr.send(formData);
};

function scrollset() {
  var rootElement = document.documentElement;
  rootElement.scrollTo({
    top: 4500,
    behavior: "smooth",
  });
}
