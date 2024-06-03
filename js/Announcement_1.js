var Forms = document.querySelector("#mainForm");
var button = document.querySelector("#mainBtn");
var deleteBtn = document.querySelector("#deleteBtn");

Forms.onsubmit = (e) => {
  e.preventDefault();
};
function Scrollback(value) {
  element = document.querySelector("#" + value);
  element.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

function uploadData() {
  const uploaderror = document.querySelector(".errorPage");
  uploaderror.innerHTML = `<img src="../icons/loader.gif" alt=""></img><p>Loading</p>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/Announcement/uploadForm.php", true);
  xhr.onload = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        uploaderror.innerText = response;
      }
    }
  };
  let data = new FormData(Forms);
  xhr.send(data);
}
button.onclick = () => {
  uploadData();
};
function Delete(value) {
  const uploaderror = document.querySelector(".deleteArea");
  uploaderror.innerHTML = `<div class="error"><p>LOADING<img src="../icons/loader.gif" alt="errorimage" /></p></div>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/Announcement/Delete.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        uploaderror.innerHTML = response;

        if (response == "Item Deleted Successfully") {
          setTimeout(() => {
            location.href = "Announcement.php";
          }, 500);
        }
      }
    }
  };
  xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  xhr.send("requestId=" + value);
}
function messageView(e) {
  let Item = document.querySelector("#" + e.getAttribute("data-value"));
  Item.classList.add("active");
  let message = e.getAttribute("data-id");
  let viewer = document.querySelector(".viewLog");
  viewer.innerText = message;
}
function status(e) {
  value = e.getAttribute("data-value");
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/announcement/announcementStat.php", true);
  xhr.onload = function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        if (response == "success") {
          setTimeout(() => {
            alert("Command executed successfully");
            location.href = "Announcement.php";
          }, 500);
        } else {
          alert(response);
        }
      }
    }
  };
  xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + value);
}
deleteBtn.onclick = (e) => {
  Delete(deleteBtn.getAttribute("data-value"));
};
