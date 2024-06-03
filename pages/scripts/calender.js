define(function () {
  var callMethod = {};
  var now = new Date();
  var year = now.getFullYear();
  var currentDay = now.getDay();
  var currentMonth = now.getMonth();
  var day = now.getDay();
  isLeapYear = (year) => {
    return (
      (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) ||
      (year % 100 === 0 && year % 400 === 0)
    );
  };
  getFebDays = (year) => {
    return isLeapYear(year) ? 29 : 28;
  };
  SpaceGenerator = (number, calender) => {
    console.log(number);
    if (number === 0) {
      Value_date = ``;
    } else if (number === 1) {
      Value_date = `<div></div>`;
    } else if (number === 2) {
      Value_date = `<div></div><div></div>`;
    } else if (number === 3) {
      Value_date = `<div></div><div></div><div></div>`;
    } else if (number === 4) {
      Value_date = `<div></div><div></div><div></div><div></div>`;
    } else if (number === 5) {
      Value_date = `<div></div><div></div><div></div><div></div><div></div>`;
    } else if (number === 6) {
      Value_date = `<div ></div><div></div><div></div><div></div><div></div><div></div>`;
    } else if (number === 7) {
      Value_date = `<div ></div><div></div><div></div><div></div><div></div><div></div><div></div>`;
    }
    calender.innerHTML = Value_date;
  };
  function EventList_Marking(monthValue, yearValue, dayValue, objData) {
    colors = ["pink", "crimson", "blue"];
    pTemp = "";
    let ParseData = JSON.parse(objData);
    KeysData = Object.keys(ParseData);
    KeysData.forEach((element) => {
      const elementObj = ParseData[element];
      let name = elementObj["name"];
      let year = elementObj["year"];
      let month = elementObj["Month"];
      let Day = elementObj["Day"];
      let start = elementObj["start"];
      let end = elementObj["end"];
      let venue = elementObj["venue"];
      let theme = elementObj["theme"];
      let about = elementObj["about"];
      let file = elementObj["image"];
      let department = elementObj["department"];
      let state = elementObj["state"];
      let unique_id = elementObj["unique_id"];
      ColorRand = Math.round((Math.random() * 100) % 5);
      if (ColorRand > 2) {
        ColorRand = 2;
      }
      if (
        parseInt(dayValue) === parseInt(Day) &&
        parseInt(yearValue) === parseInt(year) &&
        parseInt(monthValue) === parseInt(month) - 1
      ) {
        pTemp += `<p style="--color:${colors[ColorRand]}">${name}</p>`;
      }
    });
    return pTemp;
  }

  callMethod.EvenData = (objData) => {
    let ParseData = JSON.parse(objData);
    ParseData.foreach((element) => {
      const elementObj = element;
      let name = elementObj["name"];
      let year = elementObj["year"];
      let month = elementObj["Month"];
      let Day = elementObj["Day"];
      let start = elementObj["start"];
      let end = elementObj["end"];
      let venue = elementObj["venue"];
      let theme = elementObj["theme"];
      let about = elementObj["about"];
      let file = elementObj["image"];
      let department = elementObj["department"];
      let state = elementObj["state"];
      let unique_id = elementObj["unique_id"];
    });
  };
  callMethod.calender = (monthValue, yearValue, dayValue, eventData) => {
    const calender = document.querySelector(".view.month_view .view_main ");
    const monthValue_f = parseInt(monthValue) - 1;
    const yearValue_f = parseInt(yearValue);
    const dayValue_f = parseInt(dayValue);
    calender.innerHTML = "";
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

    const DayOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thurs", "Fri", "Sat"];
    let first_day = new Date(yearValue_f, monthValue_f, 1);
    console.log(first_day);
    SpaceGenerator(first_day.getDay(), calender);
    for (i = 0; i <= DaysOfMonth[monthValue_f]; i++) {
      if (i <= 0) {
      } else if (
        i === now.getDate() &&
        yearValue_f === now.getFullYear() &&
        monthValue_f === now.getMonth()
      ) {
        calender.innerHTML += `<div class='active_today' title="today">${i}${EventList_Marking(
          monthValue_f,
          yearValue_f,
          dayValue_f,
          eventData
        )}</div>`;
      } else {
        calender.innerHTML += `<div class="" >${i}${EventList_Marking(
          monthValue_f,
          yearValue_f,
          i,
          eventData
        )}</div>`;
      }
    }
    // Name.innerHTML = monthNames[monthValue];

    ///////////setting month Value
    // for (let i = 0; i < monthsListVal.length; i++) {
    //   const element = monthsListVal[i];
    //   if (i == monthValue) {
    //     element.classList.add("display_active");
    //   } else {
    //     element.classList.remove("display_active");
    //   }
    // }
  };

  return callMethod;
});