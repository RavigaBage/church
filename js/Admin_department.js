var AboutForm = document.querySelector("#aboutForm");
let UpdateForm = document.querySelector("#updateForm");
var deleteBtn = document.querySelector("#deleteBtn");
var search = document.querySelector("#search");
let update_trigger = document.querySelector("#update_trigger");
let check_id = document.querySelectorAll(".checkbox");
var departmentForm = document.querySelector("#departmentForm_form");
var membershipForm = document.querySelector("#membershipForm_form");
var forms = document.querySelectorAll("form");
var idValue = "";
UpdateForm.onsubmit = function (e) {
  e.preventDefault();
};
forms.forEach(function (entry) {
  const element = entry;
  element.onsubmit = function (e) {
    e.preventDefault();
  };
});
function Scrollback(value) {
  element = document.querySelector("#" + value);
  element.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

department_form.onsubmit = function (e) {
  e.preventDefault();
};
membership_form.onsubmit = function (e) {
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
function Update() {
  Scrollback("FormUpdate");
  const uploaderror = document.querySelector(".update_error");
  uploaderror.innerHTML = `<img src="../icons/loader.gif" alt=""></img><p>Loading</p>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/department/updateEvent.php", true);
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
  Scrollback("update_form");
  const uploaderror = document.querySelector(".updateWrapper");
  uploaderror.innerHTML = `<div class="error"><p>LOADING<img src="../icons/loader.gif" alt="errorimage" /></p></div>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/department/RequestInfoEvent.php", true);
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
function RevealEvent(e) {
  let Item = document.querySelector("#" + e.getAttribute("data-value"));
  Item.classList.add("active");
  let id = e.getAttribute("data-id");
  let value = id;
  AboutForm.innerHTML = `<div class="error"><p>Searching<img src="../icons/loader.gif" alt="errorimage" /></p></div>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/department/DepartmentInfo.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        AboutForm.innerHTML = response;
        console.log(value, response);
      }
    }
  };
  xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + value);
}
function Add_new(e) {
  let Item = document.querySelector("#" + e.getAttribute("data-value"));
  Item.classList.add("active");
}
document.querySelector(".databutton").onclick = function (e) {
  const uploaderror = document.querySelector("#department_form .uploaderror");
  uploaderror.innerHTML = `<div class="error"><p>LOADING<img src="../icons/loader.gif" alt="errorimage" /></p></div>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/department/add_new.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        uploaderror.innerHTML = response;
        if (response == "Data captured successfully") {
          setTimeout(() => {
            location.href = "department.php";
          }, 500);
        }
      }
    }
  };
  let data = new FormData(departmentForm);
  xhr.send(data);

  Scrollback("department_form");
};

function AssignMember(e) {
  let Item = document.querySelector("#" + e.getAttribute("data-value"));
  Item.classList.add("active");
}
document.querySelector(".assignbutton").onclick = function (e) {
  const uploaderror = document.querySelector("#membership_form .uploaderror");
  uploaderror.innerHTML = `<div class="error"><p>LOADING<img src="../icons/loader.gif" alt="errorimage" /></p></div>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/department/assign.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        uploaderror.innerHTML = response;
        if (response == "Data captured successfully") {
          setTimeout(() => {
            location.href = "department.php";
          }, 500);
        }
      }
    }
  };
  let data = new FormData(membershipForm);
  xhr.send(data);
};
function requestDelete(e) {
  var deleteBtn = document.querySelector("#deleteBtn");
  deleteBtn.setAttribute("data-value", e.getAttribute("data-id"));
  let Item = document.querySelector("#" + e.getAttribute("data-value"));
  Item.classList.add("active");
}
search.onkeyup = () => {
  alert("Search funtion not included");
};
function Delete(value) {
  const uploaderror = document.querySelector(".deleteArea");
  uploaderror.innerHTML = `<div class="error"><p>LOADING<img src="../icons/loader.gif" alt="errorimage" /></p></div>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/department/Delete_department.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        uploaderror.innerHTML = response;

        if (response == "Item Deleted Successfully") {
          setTimeout(() => {
            location.href = "department.php";
          }, 500);
        }
      }
    }
  };
  xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  xhr.send("requestId=" + value);
}
function collapseEvent(e) {
  let Item = document.querySelector("#" + e.getAttribute("data-value"));
  Item.classList.remove("active");
}
deleteBtn.onclick = (e) => {
  Delete(deleteBtn.getAttribute("data-value"));
};
update_trigger.onclick = (e) => {
  Update();
};
