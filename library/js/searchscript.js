var form = document.querySelector("form");
var list = document.querySelector(".search_list");
var contain = document.querySelector(".container_list");
var searchBtn = document.querySelector(".btn-btn");
var Sort = document.querySelector(".filter");
var search = document.querySelector(".search_Input ");

form.onsubmit = (e) => {
  e.preventDefault();
};

// Sort.onclick =()=>{
//     let xhr = new XMLHttpRequest();
//     xhr.open("POST", "filterVariables.php", true);
//     xhr.onload = ()=>{
//       if(xhr.readyState === XMLHttpRequest.DONE){
//         if(xhr.status === 200){
//           let data = xhr.response;
//          list.innerHTML = data;

//         }
//       }
//     }
//     let formData = new FormData(form);
//     xhr.send(formData);
//   }

// search.onkeyup =(e)=>{

//     //MAKING A A REQUEST
//     if(search.value == ''){

//     }else{

//     let xhr = new XMLHttpRequest();
//     xhr.open("POST", "filtersearch.php", true);
//     xhr.onload = ()=>{
//       if(xhr.readyState === XMLHttpRequest.DONE){
//         if(xhr.status === 200){
//           let data = xhr.response;
//           list.innerHTML = data;
//         }
//       }
//     }
//     let formData = new FormData(form);
//     xhr.send(formData);
//   }
//  }

// searchBtn.onclick =()=>{
//   let xhr = new XMLHttpRequest();
//   xhr.open("POST", "filtersearch.php", true);
//   xhr.onload = ()=>{
//     if(xhr.readyState === XMLHttpRequest.DONE){
//       if(xhr.status === 200){
//         let data = xhr.response;
//         list.innerHTML = data;
//       }
//     }
//   }
//   let formData = new FormData(form);
//   xhr.send(formData);
// }

function myFunction() {
  document.getElementById("clad").style.display = "none";
  document.getElementById("clone").style.display = "none";
  document.getElementById("cube").style.display = "none";
  document.getElementById("logan").style.display = "none";
  document.getElementById("type").style.display = "none";
  var dojo = document.getElementById("myDropdown");
  if (dojo.style.display == "block") dojo.style.display = "none";
  else dojo.style.display = "block";
}

function filter() {
  document.getElementById("myDropdown").style.display = "none";
  document.getElementById("clone").style.display = "none";
  document.getElementById("cube").style.display = "none";
  document.getElementById("logan").style.display = "none";
  document.getElementById("type").style.display = "none";
  var obj = document.getElementById("clad");
  if (obj.style.display == "block") obj.style.display = "none";
  else obj.style.display = "block";
}

function rith() {
  document.getElementById("myDropdown").style.display = "none";
  document.getElementById("clad").style.display = "none";
  document.getElementById("cube").style.display = "none";
  document.getElementById("logan").style.display = "none";
  document.getElementById("type").style.display = "none";
  var denzai = document.getElementById("clone");
  if (denzai.style.display == "block") denzai.style.display = "none";
  else denzai.style.display = "block";
}
function quartz() {
  document.getElementById("myDropdown").style.display = "none";
  document.getElementById("clad").style.display = "none";
  document.getElementById("clone").style.display = "none";
  document.getElementById("logan").style.display = "none";
  document.getElementById("type").style.display = "none";
  var lopez = document.getElementById("cube");
  if (lopez.style.display == "block") lopez.style.display = "none";
  else lopez.style.display = "block";
}
function fost() {
  document.getElementById("myDropdown").style.display = "none";
  document.getElementById("clad").style.display = "none";
  document.getElementById("clone").style.display = "none";
  document.getElementById("cube").style.display = "none";
  document.getElementById("type").style.display = "none";
  var sporty = document.getElementById("logan");
  if (sporty.style.display == "block") sporty.style.display = "none";
  else sporty.style.display = "block";
}
function typo() {
  document.getElementById("myDropdown").style.display = "none";
  document.getElementById("clad").style.display = "none";
  document.getElementById("clone").style.display = "none";
  document.getElementById("cube").style.display = "none";
  document.getElementById("logan").style.display = "none";
  var lopez = document.getElementById("type");
  if (lopez.style.display == "block") lopez.style.display = "none";
  else lopez.style.display = "block";
}
///////////////////////////////////////////////////
//   //check if user selected an option then change parentBox background color
//   var parentBox = document.querySelector('#Genre');
//   var nameBox = document.querySelectorAll('#nameBox');
//   function genre(e){
//   var okay = false;
//     for (var i = 0, l=nameBox.length; i<l; i++)
//     {
//       if(nameBox[i].checked)
//       {
//         okay = true;

//         break;
//       }

//     }
//       if(okay)parentBox.classList.add('change');
//       else parentBox.classList.remove('change');
// }

// ///////////////////////////////////////////////////////////////

// var parentBox2 = document.querySelector('#COUNTRY');
// var nameBox2 = document.querySelectorAll('#count');
// function con(e){
// var okay2 = false;
//   for (var i = 0, l=nameBox2.length; i<l; i++)
//   {
//     if(nameBox2[i].checked)
//     {
//       okay2 = true;

//       break;
//     }

//   }
//     if(okay2)parentBox2.classList.add('change');
//     else parentBox2.classList.remove('change');
// }

// //////////////////////////////////////////////////////

// var parentBox3 = document.querySelector('#SUB');
// var nameBox3 = document.querySelectorAll('#subcontrol');
// function subherb(e){
// var okay3 = false;
//   for (var i = 0, l=nameBox3.length; i<l; i++)
//   {
//     if(nameBox3[i].checked)
//     {
//       okay3 = true;

//       break;
//     }

//   }
//     if(okay3)parentBox3.classList.add('change');
//     else parentBox3.classList.remove('change');
// }

// //////////////////////////////////////////////////////

// var parentBox4 = document.querySelector('#yeat');
// var nameBox4 = document.querySelectorAll('#typecontrol');
// function typecont(e){
// var okay4 = false;
//   for (var i = 0, l=nameBox4.length; i<l; i++)
//   {
//     if(nameBox4[i].checked)
//     {
//       okay4 = true;

//       break;
//     }

//   }
//     if(okay4)parentBox4.classList.add('change');
//     else parentBox4.classList.remove('change');
// }

// //////////////////////////////////////////////////////

// var parentBox5 = document.querySelector('#age');
// var nameBox5 = document.querySelectorAll('#years');
// function year(e){
// var okay5 = false;
//   for (var i = 0, l=nameBox5.length; i<l; i++)
//   {
//     if(nameBox5[i].checked)
//     {
//       okay5 = true;

//       break;
//     }

//   }
//     if(okay5)parentBox5.classList.add('change');
//     else parentBox5.classList.remove('change');
// }

// //////////////////////////////////////////////////////

// var parentBox6 = document.querySelector('#pixel');
// var nameBox6 = document.querySelectorAll('#imagesID');
// function mager(e){
// var okay6 = false;
//   for (var i = 0, l=nameBox6.length; i<l; i++)
//   {
//     if(nameBox6[i].checked)
//     {
//       okay6 = true;

//       break;
//     }

//   }
//     if(okay6)parentBox6.classList.add('change');
//     else parentBox6.classList.remove('change');
// }

// ///////////////////////////////////////////////////////
// var Boxes = document.querySelectorAll('.trailerhouse');
// function displayImage(e){

//   var ImageSrc = document.querySelector('#'+e.id+' .trailerimg img');

// }
