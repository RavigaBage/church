define(function () {
  var CalenderMethods = {};
  var now = new Date();
  var year = now.getFullYear();
  var month = now.getMonth();
  isLeapYear = (year) => {
    return (
      (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) ||
      (year % 100 === 0 && year % 400 === 0)
    );
  };
  getFebDays = (year) => {
    return isLeapYear(year) ? 29 : 28;
  };
  SpaceGenerator = (number, calender, MonthsTotal) => {
    if (number === 0) {
      Value_date = ``;
    } else if (number === 1) {
      Value_date = `<div class='dim'><p>${MonthsTotal}</p></div>`;
    } else if (number === 2) {
      Value_date = `<div class='dim'><p>${MonthsTotal - 1
        }</p></div><div class='dim'><p>${MonthsTotal}</p></div>`;
    } else if (number === 3) {
      Value_date = `<div class='dim'><p>${MonthsTotal - 2
        }</p></div><div class='dim'><p>${MonthsTotal - 1
        }</p></div><div class='dim'><p>${MonthsTotal}</p></div>`;
    } else if (number === 4) {
      Value_date = `<div class='dim'><p>${MonthsTotal - 3
        }</p></div><div class='dim'><p>${MonthsTotal - 2
        }</p></div><div class='dim'><p>${MonthsTotal - 1
        }</p></div><div class='dim'><p>${MonthsTotal}</p></div>`;
    } else if (number === 5) {
      Value_date = `<div class='dim'><p>${MonthsTotal - 4
        }</p></div><div class='dim'><p>${MonthsTotal - 3
        }</p></div><div class='dim'><p>${MonthsTotal - 2
        }</p></div><div class='dim'><p>${MonthsTotal - 1
        }</p></div><div class='dim'><p>${MonthsTotal}</p></div>`;
    } else if (number === 6) {
      Value_date = `<div class='dim'><p>${MonthsTotal - 5
        }</p></div><div class='dim'><p>${MonthsTotal - 4
        }</p></div><div class='dim'><p>${MonthsTotal - 3
        }</p></div><div class='dim'><p>${MonthsTotal - 2
        }</p></div><div class='dim'><p>${MonthsTotal - 1
        }</p></div><div class='dim'><p>${MonthsTotal}</p></div>`;
    } else if (number === 7) {
      Value_date = `<div class='dim'><p>${MonthsTotal - 6
        }</p></div><div class='dim'><p>${MonthsTotal - 5
        }</p></div><div class='dim'><p>${MonthsTotal - 4
        }</p></div><div class='dim'><p>${MonthsTotal - 3
        }</p></div><div class='dim'><p>${MonthsTotal - 2
        }</p></div><div class='dim'><p>${MonthsTotal - 1
        }</p></div><div class='dim'><p>${MonthsTotal}</p></div>`;
    }
    calender.innerHTML = Value_date;
  };
  // function EventList_Marking(monthValue, yearValue, dayValue, objData) {
  //   colors = ["pink", "crimson", "blue"];
  //   pTemp = "";
  //   let ParseData = JSON.parse(objData);
  //   KeysData = Object.keys(ParseData);
  //   KeysData.forEach((element) => {
  //     const elementObj = ParseData[element];
  //     let name = elementObj["name"];
  //     let year = elementObj["year"];
  //     let month = elementObj["Month"];
  //     let Day = elementObj["Day"];
  //     let start = elementObj["start"];
  //     let end = elementObj["end"];
  //     let venue = elementObj["venue"];
  //     let theme = elementObj["theme"];
  //     let about = elementObj["about"];
  //     let file = elementObj["image"];
  //     let department = elementObj["department"];
  //     let state = elementObj["state"];
  //     let unique_id = elementObj["unique_id"];
  //     ColorRand = Math.round((Math.random() * 100) % 5);
  //     if (ColorRand > 2) {
  //       ColorRand = 2;
  //     }
  //     if (
  //       parseInt(dayValue) === parseInt(Day) &&
  //       parseInt(yearValue) === parseInt(year) &&
  //       parseInt(monthValue) === parseInt(month) - 1
  //     ) {
  //       pTemp += `<p style="--color:${colors[ColorRand]}">${name}</p>`;
  //     }
  //   });
  //   return pTemp;
  // }
  CalenderMethods.EvenData = (objData) => {
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
  CalenderMethods.calender = (monthValue, yearValue, dayValue, eventData) => {
    const calender = document.querySelector(".min_data.event_days");
    const CalenderMonth = document.querySelector(".view.month_view .view_main");
    const monthValue_f = parseInt(monthValue);
    const yearValue_f = parseInt(yearValue);
    const dayValue_f = parseInt(dayValue);
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
    let MonthsTotal = DaysOfMonth[monthValue_f - 1];
    SpaceGenerator(first_day.getDay(), calender, MonthsTotal);
    SpaceGenerator(first_day.getDay(), CalenderMonth, MonthsTotal);
    for (i = 0; i <= DaysOfMonth[monthValue_f]; i++) {
      if (i <= 0) {
      } else if (
        i === now.getDate() &&
        yearValue_f === now.getFullYear() &&
        monthValue_f === now.getMonth()
      ) {
        calender.innerHTML += `<div class='active_today' title="today" data-icu=""><p>${i}</p></div>`;
        CalenderMonth.innerHTML += `<div class='active_today' title="today" data-icu=""><span>${i}</span></div>`;
      } else {
        calender.innerHTML += `<div class="" data-icu=""><p>${i}</p></div>`;
        CalenderMonth.innerHTML += `<div data-icu=""><span>${i}</span></div>`;
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

  return CalenderMethods;
});
