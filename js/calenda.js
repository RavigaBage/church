var calenda = document.querySelector("#daysList");
var current = document.querySelector(".current");
var monthsListVal = document.querySelectorAll(".monthsList");
var DataToSort = document.querySelectorAll(".hiddenData");
var Name = document.querySelector(".monthName");
var CalendaData = document.querySelector("#months_data").getAttribute('data_calenderData');
const loaderBtn = document.querySelector(".loader_wrapper");
var now = new Date();
var year = now.getFullYear();
var currentDay = now.getDay();
var currentMonth = now.getMonth();
var day = now.getDay();
const list = "2,3,25,28,30";
let EventDay = list.split(",", -1);
let EventYear = 2022;
let EventMonth = 12;
let Value_date = "";
current.setAttribute("datavalue", year);
current.innerHTML = year;
const dataDates = [];


function main() {
  for (const element of DataToSort) {
    Value = element.value;
    split = Value.split("/");
    let Obj = {
      events: split[0],
      Month: parseInt(split[1]),
      Day: parseInt(split[2]),
      _Year: parseInt(split[3]),
    };
    dataDates.push(Obj);
  }
}
main();

function indicator(e) {
  e.classList.toggle("fa-times");
  var value = document.querySelector(".months");
  if (value.classList.contains("active")) {
    value.classList.remove("active");

    e.classList.remove("active");
  } else {
    value.classList.add("active");
    e.classList.add("active");
  }
}
isLeapYear = (year) => {
  return (
    (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) ||
    (year % 100 === 0 && year % 400 === 0)
  );
};
getFebDays = (year) => {
  return isLeapYear(year) ? 29 : 28;
};
SpaceGenerator = (number,  MonthsTotal) => {
  if (number === 0) {
    Value_date = ``;
  } else if (number === 1) {
    Value_date = `<div class='dim sortData'><p>${MonthsTotal}</p></div>`;
  } else if (number === 2) {
    Value_date = `<div class='dim sortData'><p>${MonthsTotal - 1
      }</p></div><div class='dim sortData'><p>${MonthsTotal}</p></div>`;
  } else if (number === 3) {
    Value_date = `<div class='dim sortData'><p>${MonthsTotal - 2
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 1
      }</p></div><div class='dim sortData'><p>${MonthsTotal}</p></div>`;
  } else if (number === 4) {
    Value_date = `<div class='dim sortData'><p>${MonthsTotal - 3
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 2
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 1
      }</p></div><div class='dim sortData'><p>${MonthsTotal}</p></div>`;
  } else if (number === 5) {
    Value_date = `<div class='dim sortData'><p>${MonthsTotal - 4
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 3
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 2
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 1
      }</p></div><div class='dim sortData'><p>${MonthsTotal}</p></div>`;
  } else if (number === 6) {
    Value_date = `<div class='dim sortData'><p>${MonthsTotal - 5
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 4
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 3
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 2
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 1
      }</p></div><div class='dim sortData'><p>${MonthsTotal}</p></div>`;
  } else if (number === 7) {
    Value_date = `<div class='dim sortData'><p>${MonthsTotal - 6
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 5
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 4
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 3
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 2
      }</p></div><div class='dim sortData'><p>${MonthsTotal - 1
      }</p></div><div class='dim sortData'><p>${MonthsTotal}</p></div>`;
  }
  calenda.innerHTML = Value_date;
};

function calender(monthValue, yearValue, dayValue) {
  const monthValue_f = parseInt(monthValue);
  const yearValue_f = parseInt(yearValue);
  const dayValue_f = parseInt(dayValue);
  calenda.innerHTML = "";
  const monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];
  const DaysOfMonth = [
    31,
    getFebDays(year),
    31,
    30,
    31,
    30,
    31,
    31,
    30,
    31,
    30,
    31,
  ];
  ///LeadYear divide by 4,400,100,1000,40000 which must output a 0
  const DayOfWeek = ["", "Mon", "Tue", "Wed", "Thurs", "Fri", "Sat", "Sun"];
  let first_day = new Date(yearValue_f, monthValue_f, 1);
  SpaceGenerator(first_day.getDay(),DaysOfMonth[monthValue_f]);
  for (i = 0; i <= DaysOfMonth[monthValue_f]; i++) {
    if (i <= 0) {
    } else if (
      i === now.getDate() &&
      yearValue_f === now.getFullYear() &&
      monthValue_f === now.getMonth()
    ) {
      calenda.innerHTML += `<div class='sortData active' title="today"><p>${i}</p></div>`;
      
    } else {
      template = `<div class="sortData"><p>${i}</p></div>`;
      Cdata = JSON.parse(CalendaData);
      if (Cdata) {
        pass = false;
        for (const key in Cdata) {
          const element = Cdata[key];
          if (i === parseInt(element['Day']) &&
            yearValue_f === parseInt(element['Year']) &&
            monthValue_f === parseInt(element['Month'])) {
            pass = true;
            template = `<div title= "Event Date click to preview" class="sortData CalenderEvent mark" data_year="${yearValue_f}" data_month="${monthValue_f}" data_day="${i}"><p>${i}</p></div>`;
          }
        }
        if (!pass) {
          calenda.innerHTML += `<div class="sortData" ><p>${i}</p></div>`;
        }else{
          calenda.innerHTML += template;
        }

      }

    }
  }

  Name.innerHTML = monthNames[monthValue];

  ///////////setting month Value
  for (let i = 0; i < monthsListVal.length; i++) {
    const element = monthsListVal[i];
    if (i == monthValue) {
      element.classList.add("display_active");
    } else {
      element.classList.remove("display_active");
    }
  }
}


function monthSelector(e) {
  Name.innerHTML = e.innerHTML;
  currentValue = current.getAttribute("datavalue");
  currentValueMonth = e.getAttribute("datavalue");
  for (i = 0; i < monthsListVal.length; i++) {
    const Variable = document.querySelector("#" + monthsListVal[i].id);
    if (Variable.id === e.id) {
      if (e.classList.contains("active")) {
        e.classList.remove("active");
      } else {
        e.classList.add("active");
      }
    } else {
      Variable.classList.remove("active");
    }
  }

  calender(currentValueMonth, currentValue, 1);
}
function next() {
  //////////////coordinate months and year
  let newValue = year;
  if (currentMonth == 11) {
    newValue = ++year;
    currentMonth = 0;
  } else {
    currentMonth = currentMonth + 1;
  }

  current.innerHTML = newValue;
  let ActualValue = 0;
  for (let f = 0; f < monthsListVal.length; f++) {
    const Months = [
      31,
      getFebDays(year),
      31,
      30,
      31,
      30,
      31,
      31,
      30,
      31,
      30,
      31,
    ];
    if (monthsListVal[f].classList.contains("active")) {
      value = monthsListVal[f].getAttribute("datavalue");
      ActualValue += Months[value];
    } else {
      ActualValue == 0;
    }
  }

  // if(ActualValue == 0){
  calender(currentMonth, newValue, 1);
  // }else{
  //   calenderActive(ActualValue, newValue,1);
  // }
  ActualValue == 0;
}
function Prev() {
  let newValue = year;
  if (currentMonth == 0) {
    newValue = --year;
    currentMonth = 11;
  } else {
    currentMonth = currentMonth - 1;
  }
  currentValue = current.setAttribute("datavalue", newValue);
  current.innerHTML = newValue;
  ActualValueP = 0;

  for (let f = 0; f < monthsListVal.length; f++) {
    const Months = [
      31,
      getFebDays(year),
      31,
      30,
      31,
      30,
      31,
      31,
      30,
      31,
      30,
      31,
    ];
    if (monthsListVal[f].classList.contains("active")) {
      value = monthsListVal[f].getAttribute("datavalue");
      ActualValueP += Months[value];
    } else {
      ActualValueP == 0;
    }
  }

  // if(ActualValueP == 0){
  calender(currentMonth, newValue, 1);
  // }else{
  //   calenderActive(ActualValueP, newValue,1);
  // }
  ActualValueP == 0;
}

function getData(e) {
  let value = e.getAttribute("data-value");
  document.querySelector(
    ".eventsDetails"
  ).innerHTML = `<div class="error"><p>Searching<img src="icons/loader.gif" alt="errorimage" /></p></div>`;
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "php/getCalenderDataG.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let response = xhr.responseText;
        document.querySelector(".eventsDetails").innerHTML = response;
      }
    }
  };
  xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + value);
}

calender(currentMonth, year, day);

window.addEventListener('click', function (e) {
  target = e.target;
  Elements_to_sort = document.querySelectorAll('.CalenderEvent');
  Elements_to_sort.forEach(element => {
    if(element.contains(target)){
      year = element.getAttribute('data_year');
      month = element.getAttribute('data_month');
      day = element.getAttribute('data_day');
      PHPREQUEST(year, month, day);
    }
  });


})

async function PHPREQUEST(year, month, day) {
  loaderBtn.classList.add('play');
  loaderBtn.classList.remove('active');
  loaderBtn.querySelector('.text p').textContent = "";
  try {
    APIDOCS = "../API/calender/data_process.php?APICALL=true&&user=true&&submit=filter";
    dataSend = {
      Year: year,
      Month: month,
      Day: day
    }
    const Request = await fetch(APIDOCS, {
      method: "POST",
      body: JSON.stringify(dataSend),
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (Request.status === 200) {
      
      let ContainerMain = document.querySelector('#eventDataView .content');
      ContainerMain.innerHTML = 'loading data pls wait';
      let data = await Request.json(dataSend);
      if (data) {
        loaderBtn.classList.remove('play');
        loaderBtn.classList.add('active');

        ParseD = JSON.parse(data);
        for (const key in ParseD) {
          const element = ParseD[key];
          let dateStr = element['Year'] + '-' + element['Month'] + '-' + element['Day']
            ; template = `<h1>${element['name']}</h1>
                            <div class="eventsDetails">
                                <div class="head">${new Date(dateStr).toDateString()}</div>
                                <p>${element['about']}</p>
                                <div class="image">
                                    <img src="../API/Images/calenda/${element['image']}" alt="" />
                                </div>
                            </div>`;
          ContainerMain.innerHTML = template;

        }

      }
    }
    loaderBtn.classList.remove('play');
    loaderBtn.classList.add('active');
  } catch (errors) {
    console.log(errors);
  }


}