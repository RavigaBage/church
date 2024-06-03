let UploadForm = document.querySelector("#uploadForm");
let UpdateForm = document.querySelector("#updateForm");
let uploadtrigger = document.querySelector("#uploadtrigger");
let update_trigger = document.querySelector("#update_trigger");
let check_id = document.querySelectorAll(".checkbox");
var deleteBtn = document.querySelector("#deleteBtn");

const Searchform = document.querySelector("#search");
const searchInput = document.querySelector(".search_Input");
const searchbutton = document.querySelector(".btn-btn");
const searchResult = document.querySelector(".searchArea");

var idValue = "";
UploadForm.onsubmit = function (e) {
  e.preventDefault();
};
Searchform.onsubmit = function (e) {
  e.preventDefault();
};
UpdateForm.onsubmit = function (e) {
  e.preventDefault();
};
function request_Update(value) {
  if (check_id.length == 1) {
    idValue = check_id[0].value;
  } else {
    for (let i = 0; i < check_id.length; i++) {
      element = check_id[i];
      if (element.checked) {
        idValue = element.value;
      }
    }
  }

  if (idValue == "") {
    alert("Check an item to request Update");
  } else {
    let Item = document.querySelector("#" + value);
    Item.classList.add("active");
    UpdateRequest();
  }
}
function singleRequest(e) {
  idValue = e.getAttribute("data-id");
  value = e.getAttribute("data-value");
  let Item = document.querySelector("#" + value);
  Item.classList.add("active");
  UpdateRequest();
}
function Upload() {
  Scrollback("upload_form");
  const uploaderror = document.querySelector(".uploaderror");
  uploaderror.innerHTML = `<img src="../icons/loader.gif" alt=""></img><p>Loading</p>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/EventFolder/uploadEvent.php", true);
  xhr.onload = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        uploaderror.innerText = response;
        if (
          response ==
          "Data entry was a success Page will refresh to display new data"
        ) {
          setTimeout(() => {
            location.href = "Events.php";
          }, 500);
        }
        console.log(response);
      }
    }
  };
  let data = new FormData(UploadForm);
  xhr.send(data);
}
function Update() {
  Scrollback("FormUpdate");
  const uploaderror = document.querySelector(".update_error");
  uploaderror.innerHTML = `<img src="../icons/loader.gif" alt=""></img><p>Loading</p>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/EventFolder/updateEvent.php", true);
  xhr.onload = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        uploaderror.innerText = response;
        console.log(response);
        if (
          response ==
          "Data entry was a success Page will refresh to display new data"
        ) {
          setTimeout(() => {
            location.href = "Events.php";
          }, 500);
        }
      }
    }
  };
  let data = new FormData(UpdateForm);
  xhr.send(data);
}
function UpdateRequest() {
  Scrollback("upload_form");
  const uploaderror = document.querySelector(".updateWrapper");
  uploaderror.innerHTML = `<div class="error"><p>LOADING<img src="../icons/loader.gif" alt="errorimage" /></p></div>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/EventFolder/RequestInfoEvent.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        uploaderror.innerHTML = response;
      }
    }
  };
  xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  xhr.send("requestId=" + idValue);
}

function Delete(value) {
  const uploaderror = document.querySelector(".deleteArea");
  uploaderror.innerHTML = `<div class="error"><p>LOADING<img src="../icons/loader.gif" alt="errorimage" /></p></div>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/EventFolder/DeleteEvent.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        uploaderror.innerHTML = response;

        if (response == "Item Deleted Successfully") {
          setTimeout(() => {
            location.href = "Events.php";
          }, 500);
        }
      }
    }
  };
  xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  xhr.send("requestId=" + value);
}

function Scrollback(value) {
  element = document.querySelector("#" + value);
  element.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}
searchInput.onkeyup = (e) => {
  if (searchInput.value == "") {
  } else {
    let value = searchInput.value;
    searchResult.innerHTML = `<div class="error"><p>Searching<img src="../icons/loader.gif" alt="errorimage" /></p></div>`;
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/EventFolder/searchEvent.php", true);
    xhr.onload = () => {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          let response = xhr.responseText;
          searchResult.innerHTML = response;
        }
      }
    };
    xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + value);
  }
};
searchbutton.onkeyup = (e) => {
  let value = searchInput.value;
  searchResult.innerHTML = `<div class="error"><p>Searching<img src="../icons/loader.gif" alt="errorimage" /></p></div>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/EventFolder/searchEvent.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        searchResult.innerHTML = response;
        searchInput.innerHTML = "";
      }
    }
  };
  xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + value);
};

uploadtrigger.onclick = (e) => {
  Upload();
};

update_trigger.onclick = (e) => {
  Update();
};

deleteBtn.onclick = (e) => {
  Delete(deleteBtn.getAttribute("data-value"));
};
