var form = document.querySelector("#form");
form.onsubmit = function (e) {
  e.preventDefault();
};
var submit = document.querySelector("#submit");
var error = document.querySelector("#error");
var display = document.querySelector(".error");

submit.onclick = function () {
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/complains.php", true);
  xhr.onload = () => {
    if (xhr.readyState == XMLHttpRequest.DONE) {
      if (xhr.status == 200) {
        let data = xhr.response;
        scrollset();
        if (data == "Upload was a success") {
          display.style.display = "block";
          error.innerHTML =
            "Data entry was a success <i class='fas fa-check'></i> and thank you for your concern ";
        } else {
          display.style.display = "block";
          error.innerHTML = data + "<i class='fas fa-x'></i>";
        }
      }
    }
  };
  let formData = new FormData(form);
  xhr.send(formData);
};

function scrollset() {
  var rootElement = document.querySelector("body");
  rootElement.scrollTo({
    top: 1000,
    behavior: "smooth",
  });
}
