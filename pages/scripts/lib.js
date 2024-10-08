const AddEventBtn = document.querySelector(".add_event");
const AddEventMenu = document.querySelector(".event_menu_add.main");
const OptionElements = document.querySelectorAll(".option");
const Series_objAll = document.querySelectorAll(".series_obj");
const UploadObj = document.querySelector(".series_upload");
const Upload_trigger = document.querySelector(".upload_item_series");
const Series_close_element = document.querySelector(
  ".event_menu_add.series_upload .close"
);
const Series_upload_version = document.querySelector(".series_version");
const series_genre = document.querySelector("#genre");
const series_genre_container = document.querySelector(".genre");

series_genre.onchange = function (e) {
  series_genre_container.innerHTML += `<div class="g_item"><p>#${series_genre.value}</p></div>`;
};
Upload_trigger.onclick = function () {
  UploadObj.classList.add("active");
};
AddEventBtn.onclick = function () {
  AddEventMenu.classList.add("active");
};
Series_close_element.onclick = function () {
  UploadObj.classList.remove("active");
};
OptionElements.forEach((element) => {
  element.addEventListener("click", function () {
    var ElementOptions = element.querySelector(".opt_element");
    ElementOptions.classList.add("active");
  });
});
Series_objAll.forEach((element) => {
  element.addEventListener("click", function () {
    Series_upload_version.classList.add("active");
  });
});
window.addEventListener("click", function (e) {
  var target = e.target;

  if (
    AddEventMenu.classList.contains("active") &&
    !AddEventBtn.contains(target)
  ) {
    if (AddEventMenu.contains(target)) {
      console.log("element clicked");
    } else {
      AddEventMenu.classList.remove("active");
    }
  }

  OptionElements.forEach((element) => {
    var ElementOptions = element.querySelector(".opt_element");
    console.log(target);
    if (
      ElementOptions.classList.contains("active") &&
      !element.contains(target)
    ) {
      if (!ElementOptions.contains(target)) {
        ElementOptions.classList.remove("active");
      } else {
        console.log("jerllops");
      }
    } else {
      if (target.classList.contains("update_item")) {
        console.log("jer");
        UpdateItemFunction("values");
      }
      if (target.classList.contains("delete_item")) {
        DeleteItemFunction("values");
      }
    }
  });

  Series_objAll.forEach((element) => {
    var ElementOptions = document.querySelector(".series_version");
    if (
      ElementOptions.classList.contains("active") &&
      !element.contains(target)
    ) {
      if (
        !ElementOptions.contains(target) &&
        !UploadObj.contains(target) &&
        !UploadObj.classList.contains("active")
      ) {
        ElementOptions.classList.remove("active");
      }
    } else {
      if (target.classList.contains("update_item")) {
        UpdateItemFunction("values");
      }
      if (target.classList.contains("delete_item")) {
        DeleteItemFunction("values");
      }
    }
  });
});

function UpdateItemFunction(value) {
  console.log("welwelwel");
}
function DeleteItemFunction(value) {
  console.log("welw");
}
