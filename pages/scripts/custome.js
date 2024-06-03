define(["Access", "projects", "finance", "calender"], function (
  timer,
  asset,
  Finance,
  calender
) {
  const ContentDom = document.querySelector(".content_main");
  const SkeletonDom_list = document.querySelector(".skeleton_loader.list");
  const SkeletonDom_table = document.querySelector(".skeleton_loader.table");
  const loader_progress = document.querySelector(".loader_progress");
  const AsideManipulator = document.querySelector("li .page_expand");
  const dn_message = document.querySelector(".dn_message");
  const confirmsBtns = document.querySelectorAll(".btn_confirm");
  let validateKey;

  var location;
  deleteTemplate = `<h1>
  By accepting you wil permanently delete this record from the church's database. 
  </h1>
  <p>Are you sure you want to delete this record</p>
  <div class="btn">
  <div class="btn_confirm">No</div>
  <div class="btn_confirm">Yes</div>
  </div>`;
  var intVal = 0;
  var IntervalSetAnimation;
  ArrayTables = [
    "Membership",
    "Library",
    "projects",
    "History",
    "Tithe",
    "Partnership",
  ];

  const Urlroutes = {
    404: {
      template: "/pages/404.html",
      title: "404 | page not found",
      description: "404 page directions",
    },
    "/": {
      template: "home.txt",
      title: "404 | page not found",
      description: "404 page directions",
    },
    Membership: {
      template: "Membership/membership.php",
      title: "Membership screen | Router sequence",
      description: "hero",
    },
    Library: {
      template: "/pages/library/library.txt",
      title: "Library screen | Router sequence",
      description: "hero",
    },
    Finance: {
      template: "/pages/finance/finance_h.txt",
      title: "Library screen | Router sequence",
      description: "hero",
    },
    Dashboard: {
      template: "/pages/Dashboard.html",
      title: "Homepage screen | Router sequence",
      description: "hero",
    },
    Access_token: {
      template: "Access_token.php",
      title: "Access token | Router sequence",
      description: "hero",
    },
    projects: {
      template: "Assets/projects.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Assets: {
      template: "Assets/Assets.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Appearance: {
      template: "Appearance/Homeview.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Gallery: {
      template: "/pages/Gallery.txt",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    History: {
      template: "History/history.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    FinanceAccount: {
      template: "/pages/finance/finance_account.txt",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Tithe: {
      template: "/pages/finance/finance_tithe.txt",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Partnership: {
      template: "partnership/dash_partner.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Department: {
      template: "department/home.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Transaction: {
      template: "/pages/finance/transactions.txt",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Expenses: {
      template: "/pages/finance/Expenses.txt",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Budget: {
      template: "/pages/finance/Budget.txt",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    records: {
      template: "records/records.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Announcement: {
      template: "/pages/announcement.txt",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    calender: {
      template: "/pages/calender.txt",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
  };
  const locationHandler = async (value, location) => {
    loader_status = false;
    const html = await fetch(value)
      .then((response) => response.text())
      .catch((error) => {
        loader_status = true;
        console.log(error);
      });
    document.querySelector(".content_main").innerHTML = html;

    if (location == "Access_token") {
      const mainDiv = document.querySelector(".timer_set");
      const HourEle = mainDiv.querySelector(".hour");
      const MinuteEle = mainDiv.querySelector(".min");
      const SecondEle = mainDiv.querySelector(".second");
      const value_set = document.querySelector("#value_data_set");
      OriginalValue = value_set.value;
      const Current_Data = new Date();
      const CurentNow = Current_Data.getTime();
      async function ConfirmAssign() {
        if (confirm("Are you sure you want to assign this password")) {
          try {
            APIDOCS =
              "../API/notifications & token & history/data_process.php?APICALL=true&&user=true&&submit=settoken";
            dataSend = {
              duration: CurentNow,
              code: document.querySelector(".tokenData div").innerHTML,
            };
            console.log(CurentNow);
            controller = new AbortController();
            const signal = controller.signal;
            const Request = await fetch(APIDOCS, {
              method: "POST",
              body: JSON.stringify(dataSend),
              headers: {
                "Content-Type": "application/json",
              },
            });

            if (Request.status === 200) {
              let data = await Request.json(dataSend);
              if (data) {
                console.log(data);
                s;
              }
            } else {
              console.log("cannot find endpoint");
            }
          } catch (error) {
            console.error(error);
          }
        }
      }
      timer.IntervalSet(HourEle, MinuteEle, SecondEle, OriginalValue);
      document
        .querySelector(".token button")
        .addEventListener("click", function () {
          timer.generateToken();
          ConfirmAssign();
        });
    }
    if (location == "calender") {
      const TabsMenu = document.querySelectorAll(".menu_tab");
      const CategoryMenu = document.querySelector(".event_category");
      const AddBtn = document.querySelector(".plus_arrow");
      const AddMenu = document.querySelector(".new_event_menu");
      const ViewElements = document.querySelector(".grid_space");
      const SaveDetails = document.querySelector("#save_details");
      const selectors = document.querySelectorAll(".svg_wrapper");
      const selectorOptions = document.querySelectorAll(
        ".items_selector .VKy0Ic"
      );
      const functionSelector = document.querySelector(
        ".function.selector p.start_time_p"
      );
      const functionSelectorEnd = document.querySelector(
        ".function.selector p.End_time_p"
      );
      const UpdateDetails = document.querySelector("#Update_details");
      const MonthSelector = document.querySelectorAll(
        ".month_view .view_main div"
      );
      const DaySelector = document.querySelectorAll(".min_calenda div span");
      const MenuDate = document.querySelector(".menu_date");
      const YearList = document.querySelector(".year_choose");

      const MenuArrowLeft = document.querySelector(".add_menu .left_arrow");
      const MenuArrowRight = document.querySelector(".add_menu .right_arrow");
      let currentSpan = "";
      let ActiveTime = 0;
      let DateFetch = new Date();
      let year = DateFetch.getFullYear();
      let month = DateFetch.getMonth();
      let Current = DateFetch.getDate();
      let Time_position = "";
      let Left_position = "";
      let last = 1;
      let weekObj = [];
      let ResizeOrigin = false;
      let UpdateSession = "";
      let YItem = year;
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

      isLeapYear = (year) => {
        return (
          (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) ||
          (year % 100 === 0 && year % 400 === 0)
        );
      };
      getFebDays = (year) => {
        return isLeapYear(year) ? 29 : 28;
      };
      const DaysOfMonth = [
        31,
        getFebDays(2024),
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
      DaysLater = ["Sun", "Mon", "Tue", "Wed", "Thurs", "Fri", "Sat"];

      const YearsList = document.querySelector(".year_list");
      for (let i = 0; i < 35; i++) {
        YearsList.innerHTML += `<p>${YItem}</p>`;
        YItem += -1;
      }
      YearList.addEventListener("click", function () {
        YearsList.classList.toggle("active");
      });
      const YearsListChildren = document.querySelectorAll(".year_list p");
      YearsListChildren.forEach((element) => {
        element.addEventListener("click", function () {
          if (document.querySelector(".month_selector .year header") != null) {
            document.querySelector(".month_selector .year header").innerText =
              element.innerHTML;
          }
        });
      });
      document
        .querySelector(".year button")
        .addEventListener("click", function () {
          document.querySelector(".month_selector").classList.remove("active");
        });
      MenuDate.addEventListener("click", function () {
        document.querySelector(".month_selector").classList.add("active");
      });

      MonthSelector.forEach((element) => {
        if (element.hasAttribute("data-icu")) {
          element.addEventListener("click", function () {
            Calender = document.querySelector(".month_view .view_main");
            CurrentData = element.querySelector("span").innerText;
            Year = Calender.getAttribute("data-year");
            Month = Calender.getAttribute("data-month");

            document.querySelector("#dayTab").classList.add("active");
            DayInformation(Year, Month, CurrentData);
            TabsMenu.forEach((element) => {
              if (element.id == "dayTab") {
                element.classList.add("active");
              } else {
                element.classList.remove("active");
              }
            });
            CategoryMenu.classList.add("day");
          });
        }
      });
      DaySelector.forEach((element) => {
        if (element.hasAttribute("data-icu")) {
          element.addEventListener("click", function () {
            Calender = document.querySelector(".min_calenda");
            CurrentData = element.querySelector("span").innerText;
            Year = Calender.getAttribute("data-year");
            Month = Calender.getAttribute("data-month");

            document.querySelector("#dayTab").classList.add("active");
            DayInformation(Year, Month, CurrentData);
          });
        }
      });

      function ResizeElement(val, origin) {
        weight = 40;
        StartTimeElement = functionSelector.innerHTML;
        SplitInspection = StartTimeElement.split(":");
        if (SplitInspection.length >= 2) {
          IntVal = parseInt(SplitInspection[0]);
        }
        EndTimeElement = functionSelectorEnd.innerHTML;
        SplitInspectionEnd = EndTimeElement.split(":");

        if (SplitInspection[1].search("00") >= 0) {
          if (currentSpan.classList.contains("min_upper")) {
            currentSpan.classList.remove("min");
          }
        } else if (!currentSpan.classList.contains("min_upper")) {
          currentSpan.classList.add("min_upper");
        }

        if (SplitInspectionEnd[1].search("00") >= 0) {
          if (currentSpan.classList.contains("min_bottom")) {
            currentSpan.classList.remove("min_bottom");
          }
        } else if (!currentSpan.classList.contains("min_bottom")) {
          currentSpan.classList.add("min_bottom");
        }

        // if (ResizeOrigin) {} else {}
        if (SplitInspectionEnd.length >= 2) {
          SplitVal = SplitInspectionEnd[0];
        }
        if (SplitInspection[1].search("am") >= 0) {
          CalcReverse = IntVal == 12 ? (IntVal = 0) : (IntVal = IntVal);
        }
        if (SplitInspection[1].search("pm") >= 0) {
          CalcReverse = IntVal == 12 ? (IntVal = 12) : (IntVal = 12 + IntVal);
        }
        if (SplitInspectionEnd[1].search("am") >= 0) {
          IntVal_Num = SplitVal == 12 ? (SplitVal = 1) : (SplitVal = SplitVal);
        }

        if (SplitInspectionEnd[1].search("pm") >= 0) {
          IntVal_Num = 12 + parseInt(SplitVal);
        }
        if (CalcReverse <= IntVal_Num) {
          newVal = weight * CalcReverse;
          heightVal = weight * (IntVal_Num - CalcReverse);

          if (currentSpan.classList.contains("min")) {
            heightVal += -20;
          }
          if (currentSpan != "") {
            currentSpan.style.setProperty("--top", newVal + "px");
            if (SplitInspectionEnd[1].search("00") < 0) {
              currentSpan.style.height = heightVal + 20 + "px";
            } else {
              currentSpan.style.height = heightVal + "px";
            }
          }
          if (StartTimeElement.indexOf("(")) {
            SplitInspection = StartTimeElement.split("(");
            SplitInspection = SplitInspection[0];
          }
          if (EndTimeElement.indexOf("(") >= 0) {
            SplitInspectionEnd = EndTimeElement.split("(");
            SplitInspectionEnd = SplitInspectionEnd[0];
          }
          HtmlVal = `<p style="font-size:13px">${SplitInspection} - ${SplitInspectionEnd}</p>`;
          currentSpan.querySelector(".element_main_data").innerHTML = HtmlVal;
        }
      }
      selectorOptions.forEach((element) => {
        element.addEventListener("click", function () {
          selectorOptions.forEach((element) => {
            element.setAttribute("arial-selected", "false");
            element.classList.remove("active");
          });
          const ElementNext = element.parentNode.parentNode.parentNode;
          if (ElementNext) {
            ElementNext.querySelector("p").innerText = element.innerText;
            ElementNext.classList.remove("active");
            element.setAttribute("arial-selected", "true");
            element.classList.add("active");
            if (!element.classList.contains("tag")) {
              ResizeElement(element.innerHTML);
            }
          }
        });
      });
      Update_details.addEventListener("click", function () {
        currentSpan = UpdateSession;
        ResizeElement("trial_run", false);
        const customElementsTemp =
          document.querySelectorAll(".customize_event");
        customElementsTemp.forEach((element) => {
          element.classList.add("dull");
        });
        AddMenu.classList.remove("active");
        DataObj = {};
        DataObj.name = document.querySelector('input[name="EventName"]').value;
        DataObj.Location = document.querySelector(
          'input[name="EventLocation"]'
        ).value;
        DataObj.Description = document.querySelector(
          'textarea[name="EventDescription"]'
        ).value;
        DataObj.Start = document.querySelector("P.start_time_p").innerText;
        DataObj.End = document.querySelector("P.End_time_p").innerText;
        DataObj.Tag = document.querySelector("P.EventTag").innerText;
        DataObj.top = Time_position;
        let class_tag = document.querySelector("P.EventTag").innerText;
        UpdateSession.classList.add(class_tag);
        AddMenu.classList.remove("Update");
      });

      SaveDetails.addEventListener("click", function () {
        element = currentSpan;
        const OldParent = element.parentElement;
        const NewParent = document.createElement("div");
        NewParent.setAttribute("class", "event_record");
        try {
          const CloneItem = element.cloneNode(true);
          NewParent.classList.add("Owel" + String(Time_position));
          if (CloneItem.classList.contains("min")) {
            NewParent.classList.add("min");
          }
          CloneItem.innerHTML = `<p class="element_main_data">${
            document.querySelector('input[name="EventName"]').value
          }</p>`;
          CloneItem.setAttribute("class", "eventClassData");
          StyleProperties = CloneItem.getAttribute("style");
          NewParent.setAttribute("style", StyleProperties);
          NewParent.append(CloneItem);
          OldParent.append(NewParent);
          AddMenu.classList.remove("active");

          DataObj = {};
          DataObj.name = document.querySelector(
            'input[name="EventName"]'
          ).value;
          DataObj.Location = document.querySelector(
            'input[name="EventLocation"]'
          ).value;
          DataObj.Description = document.querySelector(
            'textarea[name="EventDescription"]'
          ).value;
          DataObj.Start = document.querySelector("P.start_time_p").innerText;
          DataObj.End = document.querySelector("P.End_time_p").innerText;
          DataObj.Tag = document.querySelector("P.EventTag").innerText;
          DataObj.top = Time_position;
          classtag = document.querySelector("P.EventTag").innerText;
          NewParent.classList.add(classtag);

          template = `<div class="data-details">
                        <div class="flex">
                            <i class="fas fa-trash" data-ical="delete" data-val=""></i>
                            <i class="fas fa-edit" data-ical="update" data-val="" data-info='{"id":2,"Name":"Grand Blue","Location":"as","Start":"2:00 am","End":"5:00 am","Tag":"Area","Description":"lorem ispume"}'></i>
                        </div>
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    height="24px" viewBox="0 -960 960 960"
                                    width="24px" fill="#000">
                                    <path
                                        d="M480-400q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Z" />
                                </svg>
                                <header>${DataObj.name}</header>
                            </div>
                            <div class="flex">
                                <i class="fas fa-clock"></i>
                                <p>${DataObj.Start} - ${DataObj.End}</p>
                            </div>

                        </div>`;
          NewParent.innerHTML += template;
        } catch (error) {
          alert("An error occurred pls start the process again");
          console.log(error);
        }
      });

      AddBtn.addEventListener("click", () => {
        const customElementsTemp =
          document.querySelectorAll(".customize_event");
        customElementsTemp.forEach((element) => {
          element.classList.add("dull");
        });
        AddBtn.querySelector("i").classList.remove("fa-times");
        AddMenu.classList.remove("min");
        AddMenu.classList.remove("active");
        AddMenu.style.removeProperty("--left");
      });
      TabsMenu.forEach((element) => {
        element.addEventListener("click", () => {
          CategoryMenu.setAttribute("class", "event_category");
          if (element.id == "dayTab") {
            CategoryMenu.classList.add("day");
          } else if (element.id == "WeekTab") {
            CategoryMenu.classList.add("week");
          } else if (element.id == "MonthTab") {
            CategoryMenu.classList.add("month");
          }
          TabsMenu.forEach((element_check) => {
            if (
              element_check.classList.contains("active") &&
              element_check != element
            ) {
              element_check.classList.remove("active");
            }
          });
          element.classList.add("active");
        });
      });
      function GetWeekCalender(year, month) {
        TrialDate = new Date(year, month, 1);
        value = TrialDate.getDay();
        Determine_Days(value, month);
        if (value != 0) {
          max = 7 - value;
        } else {
          max = 7;
        }
        last = max;
        for (let i = 0; i < max; i++) {
          weekObj.push(i + 1);
        }
        last = weekObj[weekObj.length - 1] + 1;
        if (weekObj.includes(Current)) {
          DisplayWeekResult(weekObj);
        } else {
          weekObj = [];
          getWeeks(month, year, last);
        }
      }
      function Determine_Days(value, month) {
        if (value != 0) {
          for (let i = 0; i < value; i++) {
            if (month == 0) {
              PrevMonth = DaysOfMonth[11];
            } else {
              PrevMonth = DaysOfMonth[month - 1];
            }

            console.log(PrevMonth);
            weekObj.push(PrevMonth - (value - (i + 1)));
          }
        }
      }
      function getWeeks(month, year, day) {
        TrialDate = new Date(year, month, day);
        value = TrialDate.getDay();
        console.log(day);
        for (let i = 0; i < 7; i++) {
          weekObj.push(day + i);
        }
        last = weekObj[weekObj.length - 1];
        if (weekObj.includes(Current)) {
          DisplayWeekResult(weekObj);
        } else {
          weekObj = [];
          getWeeks(month, year, day);
        }
        weekObj = [];
      }
      function getNextWeek(year_t, month_t, day) {
        m = 0;
        for (let i = 0; i < 7; i++) {
          if (month_t <= 11) {
            if (day + (i + 1) > DaysOfMonth[month_t]) {
              day = 0;
              m = 0;
              month = month_t + 1;
            }
          } else {
            month = 0;
            month_t = month;

            day = 0;
            m = 0;
            year = year_t + 1;
            year_t = year;
            console.log(month_t, year_t, day);
          }

          weekObj.push(day + (m + 1));
          m += 1;
        }
        last = weekObj[weekObj.length - 1];

        DisplayWeekResult(weekObj);
        weekObj = [];
      }
      function getPrevWeek(year_t, month_t, day) {
        m = day;
        for (let i = 0; i < 7; i++) {
          if (month_t >= 0) {
            if (month_t == 0) {
              month_t = 12;
            }
            if (m <= 0) {
              day = DaysOfMonth[month_t - 1];
              m = DaysOfMonth[month_t - 1];
              month = month_t - 1;
            }
          } else {
            month = 11;
            month_t = month;
            day = DaysOfMonth[month_t - 1];
            m = DaysOfMonth[month_t - 1];
            year = year_t - 1;
            year_t = year;
          }
          console.log(month, "-----------m");
          weekObj.push(m);
          m += -1;
        }
        weekObj.reverse();
        last = weekObj[0] - 1;
        console.log(weekObj, last);
        DisplayWeekResult(weekObj);
        weekObj = [];
      }
      function DisplayWeekResult(weekObj) {
        const HeaderSelector = document.querySelectorAll("strong[data-id]");
        const MenuData = document.querySelector(".menu_date header");
        if (month == 12) {
          month = 0;
        }
        MenuData.innerHTML = `${monthNames[month]} ${year}`;
        weekObj.forEach((element) => {
          Index = weekObj.indexOf(element);
          HeaderSelector.forEach((element) => {
            if (parseInt(element.getAttribute("data-id")) === Index) {
              element.querySelector("span").innerHTML = weekObj[Index];
            }
          });
        });
      }
      function CalculateTime(customElementsTemp, value) {
        Calc = value / 40;
        record = 0;
        if (Calc % 2 != 0) {
          MinutesRange = String(Calc).split(".");
          console.log(MinutesRange);
          CharacterSplit = MinutesRange[1].split("");
          if (parseInt(CharacterSplit[0]) > 5) {
            record = "30";
          }
        }
        HourRange = Math.ceil(value / 40);
        HourRange1 = HourRange - 1;
        newHourRange = String(HourRange);
        newHourRange1 = String(HourRange1);
        timeZone = "am";
        if (HourRange >= 12) {
          timeZone = "pm";
          newHourRange = String(HourRange - 12);
        }
        if (HourRange1 >= 12) {
          newHourRange1 = String(HourRange1 - 12);
          ScrollH = HourRange + 12;
        }

        const span = customElementsTemp.querySelector("span");
        if (record == "30") {
          customElementsTemp.classList.add("min");
          span.innerHTML = `k, ${newHourRange1} : ${newHourRange1}:30 ${timeZone}`;
          functionSelector.innerHTML = `${newHourRange1}:00 ${timeZone}`;
          functionSelectorEnd.innerHTML = `${newHourRange1}:30 ${timeZone}`;
        } else {
          customElementsTemp.classList.remove("min");
          span.innerHTML = `k, ${newHourRange1}  - ${newHourRange}  ${timeZone}`;
          functionSelector.innerHTML = `${newHourRange1}:00  ${timeZone}`;
          functionSelectorEnd.innerHTML = `${newHourRange}:00  ${timeZone}`;
        }
        Time_position = 40 * HourRange1;
        customElementsTemp.style.setProperty("--top", Time_position + "px");
        currentSpan = customElementsTemp;

        return customElementsTemp;
      }
      function DayInformation(Year, Month, Day) {
        DaysLater = [
          "Sunday",
          "Monday",
          "Tueday",
          "Weday",
          "Thursday",
          "Friday",
          "Saturday",
        ];
        const DayInfo = document.querySelector(".day_info");
        TrialDate = new Date(Year, Month, Day);
        DayInfo.querySelector("header").innerText = Day;
        console.log(Year, Month, Day);
        DayInfo.querySelector("p").innerText = `${
          DaysLater[TrialDate.getDay()]
        }, ${monthNames[parseInt(Month)]}, ${Year}`;
      }

      selectors.forEach((element) => {
        element.addEventListener("click", function () {
          const ElementNext = element.parentNode;
          ElementNext.classList.toggle("active");
          if (element.getAttribute("data-origin") == "start") {
            ResizeOrigin = true;
          } else if (element.getAttribute("data-origin") == "end") {
            ResizeOrigin = false;
          }
          selectors.forEach((elementR) => {
            if (element != elementR) {
              const ElementNext = elementR.parentNode;
              ElementNext.classList.remove("active");
            }
          });
        });
      });

      window.addEventListener("click", function (e) {
        const HeaderSelector = document.querySelectorAll("strong[data-id]");
        const ColorPicker_palette = document.querySelector(".colorlist");
        const target = e.target;
        GridCells = [
          "gridrowO",
          "gridrowT",
          "gridrowTH",
          "gridrowF",
          "gridrowFI",
          "gridrowS",
          "gridrowSE",
        ];
        if (!AddMenu.contains(target)) {
          GridCells.forEach((element) => {
            const MainElement = document.querySelector("." + element);

            if (MainElement.contains(target)) {
              console.log("ue");
              if (target.classList.contains(element)) {
                BaseWidth = ViewElements.clientWidth / 2;
                BaseHeight = ViewElements.clientHeight / 2;
                position =
                  e.clientX - ViewElements.getBoundingClientRect().left;
                topPosition =
                  e.clientY - ViewElements.getBoundingClientRect().top;
                Time_position = topPosition;
                Left_position = position;
                if (position < BaseWidth) {
                  val = position + 70 + 400;
                  if (val > 870) {
                    val = 870;
                  }
                  AddMenu.style.setProperty("--left", val + "px");
                } else {
                  val = position - 400;
                  if (val > 870) {
                    val = 870;
                  }
                  AddMenu.style.setProperty("--left", val + "px");
                }

                AddBtn.querySelector("i").classList.add("fa-times");
                AddMenu.classList.add("active");

                const customElementsTemp =
                  target.querySelector(".customize_event");
                customElementsTemp.classList.remove("dull");
                CalculateTime(customElementsTemp, Time_position);
              } else {
                const customElementsTemp = ViewElements;
                const ElementEvent =
                  customElementsTemp.querySelector(".customize_event");
                ElementEvent.classList.add("dull");
                if (AddMenu.classList.contains("active")) {
                  AddMenu.classList.remove("active");
                }
              }
            }
          });
        }
        if (target.tagName == "I") {
          if (target.hasAttribute("data-ical")) {
            if (target.getAttribute("data-ical") == "update") {
              ObjectInfo = target.getAttribute("data-info");
              ObjectData = JSON.parse(ObjectInfo);
              ObjectParent = target.parentElement.parentElement.parentElement;
              if (ObjectParent.classList.contains("event_record")) {
                UpdateSession = ObjectParent;
              }
              AddMenu.querySelector('input[name="EventName"]').value =
                ObjectData["Name"];
              AddMenu.querySelector('input[name="EventLocation"]').value =
                ObjectData["Location"];
              AddMenu.querySelector('textarea[name="EventDescription"]').value =
                ObjectData["Description"];
              AddMenu.querySelector("P.start_time_p").innerText =
                ObjectData["Start"];
              AddMenu.querySelector("P.End_time_p").innerText =
                ObjectData["End"];
              AddMenu.querySelector("P.EventTag").innerText = ObjectData["Tag"];
              AddMenu.classList.add("active");
              AddMenu.classList.add("Update");
              UpdateSession.classList.remove(ObjectData["Tag"]);
            } else if (target.getAttribute("data-ical") == "delete") {
              const dn_message = document.querySelector(".dn_message");
              dn_message.classList.add("active");
            }
          }
        }

        if (
          !document.querySelector(".month_selector").contains(target) &&
          !MenuDate.contains(target)
        ) {
          document.querySelector(".month_selector").classList.remove("active");
        }
      });
      MenuArrowLeft.addEventListener("click", function () {
        getPrevWeek(year, month, last);
      });
      MenuArrowRight.addEventListener("click", function () {
        console.log(weekObj);
        getNextWeek(year, month, last);
      });
      getWeeks(month, year, Current);
    }
    if (
      location == "projects" ||
      location == "Membership" ||
      location == "Department" ||
      location == "Tithe" ||
      location == "Partnership" ||
      location == "Transaction" ||
      location == "Expenses" ||
      location == "records" ||
      location == "Assets" ||
      location == "Announcement"
    ) {
      setTimeout(function () {
        const AddEventBtn = document.querySelector(".add_event");
        const AddEventMenu = document.querySelector(".event_menu_add");
        var OptionElements = document.querySelectorAll(".option");
        const Pages = document.querySelectorAll(".pages div");

        AddEventBtn.addEventListener("click", function (e) {
          APIDOCS =
            "../API/Assets&projects/data_process.php?APICALL=true&&user=true&&submit=true";
          AddEventMenu.classList.add("active");
        });
        Pages.forEach((element) => {
          element.addEventListener("click", function () {
            value = element.innerHTML;
            pagnationSystem(value);
          });
        });

        OptionElements.forEach((element) => {
          element.addEventListener("click", function () {
            var ElementOptions = element.querySelector(".opt_element");
            if (ElementOptions != null) {
              ElementOptions.classList.add("active");
            }
          });
        });

        window.addEventListener("click", function (e) {
          var target = e.target;
          var OptionElements = document.querySelectorAll(".option");
          if (
            AddEventMenu.classList.contains("active") &&
            !AddEventBtn.contains(target)
          ) {
            if (!AddEventMenu.contains(target)) {
              AddEventMenu.classList.remove("active");
            }
          }
          OptionElements.forEach((element) => {
            var ElementOptions = element.querySelector(".opt_element");
            if (ElementOptions != null) {
              if (
                ElementOptions.classList.contains("active") &&
                !element.contains(target)
              ) {
                if (!ElementOptions.contains(target)) {
                  ElementOptions.classList.remove("active");
                }
              } else {
                if (
                  target.classList.contains("Update_item") &&
                  element.contains(target)
                ) {
                  UpdateItemFunction(target);
                }
                if (
                  target.classList.contains("delete_item") &&
                  element.contains(target)
                ) {
                  validateKey = target.getAttribute("data-id");
                  dn_message.classList.add("active");
                }
              }
            }
          });
        });
      }, 900);
    }

    if (location == "Gal") {
      const toggle = document.querySelector(".menu_toggle");
      const menuDiv = document.querySelector(".nav_ele");
      const LinksA = document.querySelectorAll(".nav_ele a");
      toggle.addEventListener("click", function (e) {
        toggle.classList.toggle("active");
        menuDiv.classList.toggle("active");
      });
      LinksA.forEach((element) => {
        element.addEventListener("click", function (e) {
          toggle.classList.remove("active");
          menuDiv.classList.remove("active");
        });
      });

      const Elements = document.querySelectorAll("section");
      const Indicator = document.querySelector(".line_right .menu_name p");
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            SectionName = entry.target.getAttribute("id");
            Indicator.innerText = `${SectionName} section`;
          }
        });
      });
      Elements.forEach((el) => observer.observe(el));
    }
    // if (location == "Library") {
    //   const AddEventBtn = document.querySelector(".add_event");
    //   const AddEventMenu = document.querySelector(".event_menu_add.main");
    //   const OptionElements = document.querySelectorAll(".option");
    //   const Series_objAll = document.querySelectorAll(".series_obj");
    //   const UploadObj = document.querySelector(".series_upload");
    //   const Upload_trigger = document.querySelector(".upload_item_series");
    //   const Series_close_element = document.querySelector(
    //     ".event_menu_add.series_upload .close"
    //   );
    //   const Series_upload_version = document.querySelector(".series_version");
    //   const series_genre = document.querySelector("#genre");
    //   const series_genre_container = document.querySelector(".genre");

    //   series_genre.onchange = function (e) {
    //     series_genre_container.innerHTML += `<div class="g_item"><p>#${series_genre.value}</p></div>`;
    //   };
    //   Upload_trigger.onclick = function () {
    //     UploadObj.classList.add("active");
    //   };
    //   AddEventBtn.onclick = function () {
    //     AddEventMenu.classList.add("active");
    //   };
    //   Series_close_element.onclick = function () {
    //     UploadObj.classList.remove("active");
    //   };
    //   OptionElements.forEach((element) => {
    //     element.addEventListener("click", function () {
    //       var ElementOptions = element.querySelector(".opt_element");
    //       ElementOptions.classList.add("active");
    //     });
    //   });
    //   Series_objAll.forEach((element) => {
    //     element.addEventListener("click", function () {
    //       Series_upload_version.classList.add("active");
    //     });
    //   });
    //   window.addEventListener("click", function (e) {
    //     var target = e.target;

    //     if (
    //       AddEventMenu.classList.contains("active") &&
    //       !AddEventBtn.contains(target)
    //     ) {
    //       if (AddEventMenu.contains(target)) {
    //         console.log("element clicked");
    //       } else {
    //         AddEventMenu.classList.remove("active");
    //       }
    //     }

    //     OptionElements.forEach((element) => {
    //       var ElementOptions = element.querySelector(".opt_element");
    //       console.log(target);
    //       if (
    //         ElementOptions.classList.contains("active") &&
    //         !element.contains(target)
    //       ) {
    //         if (!ElementOptions.contains(target)) {
    //           ElementOptions.classList.remove("active");
    //         } else {
    //           console.log("jerllops");
    //         }
    //       } else {
    //         if (target.classList.contains("update_item")) {
    //           console.log("jer");
    //           UpdateItemFunction("values");
    //         }
    //         if (target.classList.contains("delete_item")) {
    //           DeleteItemFunction("values");
    //         }
    //       }
    //     });

    //     Series_objAll.forEach((element) => {
    //       var ElementOptions = document.querySelector(".series_version");
    //       if (
    //         ElementOptions.classList.contains("active") &&
    //         !element.contains(target)
    //       ) {
    //         if (
    //           !ElementOptions.contains(target) &&
    //           !UploadObj.contains(target) &&
    //           !UploadObj.classList.contains("active")
    //         ) {
    //           ElementOptions.classList.remove("active");
    //         }
    //       } else {
    //         if (target.classList.contains("update_item")) {
    //           UpdateItemFunction("values");
    //         }
    //         if (target.classList.contains("delete_item")) {
    //           DeleteItemFunction("values");
    //         }
    //       }
    //     });
    //   });

    //   function UpdateItemFunction(value) {
    //     console.log("welwelwel");
    //   }
    //   function DeleteItemFunction(value) {
    //     console.log("welw");
    //   }
    // }
    if (location == "Appearance") {
      const toggleModes = document.querySelectorAll(".toggle_mode");
      async function ConfirmAssign(id) {
        if (confirm("Are you sure you want to assign this password")) {
          try {
            APIDOCS =
              "../API/notifications & token & history/data_process.php?APICALL=true&&user=true&&submit=theme";
            dataSend = {
              key: id,
            };
            controller = new AbortController();
            const signal = controller.signal;
            const Request = await fetch(APIDOCS, {
              method: "POST",
              body: JSON.stringify(dataSend),
              headers: {
                "Content-Type": "application/json",
              },
            });

            if (Request.status === 200) {
              let data = await Request.json(dataSend);
              if (data) {
                console.log(data);
                s;
              }
            } else {
              console.log("cannot find endpoint");
            }
          } catch (error) {
            console.error(error);
          }
        }
      }

      toggleModes.forEach((element) => {
        element.addEventListener("click", function () {
          element.classList.toggle("active");
          ConfirmAssign(element.getAttribute("data-id"));
        });
      });
    }
    if (location == "Finance") {
      ActivityMenu = true;
      const AddEventBtn = document.querySelector(".add_event");
      const AddEventMenu = document.querySelector(".event_menu_add.main");
      const AddEventMenu_off = document.querySelector(".event_menu_add");
      const OptionElements = document.querySelectorAll(".option");
      const tabs_offertory = document.querySelector(".offertory_itenary");
      const slider_menu = document.querySelector(".slider_menu");
      const Event_tab = document.querySelector(".home_event_itenary");
      const NavigationFilter = document.querySelectorAll(
        ".navigation.Filter .item"
      );

      document
        .querySelector(".navigation.Filter")
        .addEventListener("click", function (e) {
          this.classList.toggle("active");
        });
      NavigationFilter.forEach((element) => {
        element.addEventListener("click", function () {
          Finance.FilterSystem(
            element.getAttribute("data-filter"),
            ActivityMenu
          );
        });
      });

      AddEventBtn.onclick = function () {
        if (ActivityMenu) {
          AddEventMenu.classList.add("active");
        } else {
          AddEventMenu_off.classList.add("active");
        }
      };

      Event_tab.onclick = function () {
        slider_menu.classList.remove("active");
        ActivityMenu = true;
      };

      tabs_offertory.onclick = function () {
        slider_menu.classList.add("active");
        ActivityMenu = false;
      };

      OptionElements.forEach((element) => {
        element.addEventListener("click", function () {
          var ElementOptions = element.querySelector(".opt_element");
          ElementOptions.classList.add("active");
        });
      });
      window.addEventListener("click", function (e) {
        var target = e.target;
        if (
          (AddEventMenu_off.classList.contains("active") &&
            !AddEventBtn.contains(target)) ||
          (AddEventMenu.classList.contains("active") &&
            !AddEventBtn.contains(target))
        ) {
          if (
            !AddEventMenu.contains(target) &&
            !AddEventMenu_off.contains(target)
          ) {
            AddEventMenu.classList.remove("active");
            AddEventMenu_off.classList.remove("active");
          }
        }

        OptionElements.forEach((element) => {
          var ElementOptions = element.querySelector(".opt_element");
          if (ElementOptions != null) {
            if (
              ElementOptions.classList.contains("active") &&
              !element.contains(target)
            ) {
              if (!ElementOptions.contains(target)) {
                ElementOptions.classList.remove("active");
              }
            } else {
              if (
                target.classList.contains("Update_item") &&
                element.contains(target)
              ) {
                UpdateItemFunction(target, ActivityMenu);
              }
              if (
                target.classList.contains("delete_item") &&
                element.contains(target)
              ) {
                dn_message.classList.add("active");
                ElementOptions.classList.remove("active");
                DeleteItemFunction("values", ActivityMenu);
              }
            }
          }
        });
      });

      function UpdateItemFunction(value, ActivityMenu) {
        newObject = value.getAttribute("data-information");
        newObject = JSON.parse(newObject);

        if (ActivityMenu == false) {
          document.querySelector('.event_menu_add input[name="event"]').value =
            newObject["name"];
          document.querySelector('.event_menu_add input[name="amount"]').value =
            newObject["Amount"];
          document.querySelector('.event_menu_add input[name="Date"]').value =
            newObject["Date"];
          document.querySelector(
            '.event_menu_add textarea[name="description"]'
          ).value = newObject["description"];
          document.querySelector(
            '.event_menu_add input[name="delete_key"]'
          ).value = newObject["id"];
          AddEventMenu_off.classList.add("active");
          console.log("actia");
        } else {
          document.querySelector(
            '.event_menu_add select[name="account"]'
          ).value = newObject["Account"];
          document.querySelector(
            '.event_menu_add input[name="category"]'
          ).value = newObject["category"];
          document.querySelector('.event_menu_add input[name="amount"]').value =
            newObject["Amount"];
          document.querySelector('.event_menu_add input[name="date"]').value =
            newObject["Date"];
          document.querySelector(
            '.event_menu_add textarea[name="description"]'
          ).value = newObject["description"];
          document.querySelector(
            '.event_menu_add input[name="delete_key"]'
          ).value = newObject["id"];
          AddEventMenu.classList.add("active");
        }
      }
      function DeleteItemFunction(value) {
        if (ActivityMenu) {
          console.log("wlew");
        } else {
          console.log("welw");
        }
      }
    }
    if (location == "Transaction") {
      function UpdateItemFunction(value) {
        const AddEventMenu = document.querySelector(".event_menu_add");
        newObject = value.getAttribute("data-information");
        newObject = JSON.parse(newObject);

        document.querySelector('.event_menu_add select[name="account"]').value =
          newObject["account"];
        document.querySelector('.event_menu_add input[name="amount"]').value =
          newObject["Amount"];
        document.querySelector(
          '.event_menu_add input[name="authorize"]'
        ).value = newObject["authorize"];
        document.querySelector('.event_menu_add input[name="date"]').value =
          newObject["Date"];
        document.querySelector('.event_menu_add select[name="status"]').value =
          newObject["status"];
        document.querySelector(
          '.event_menu_add input[name="delete_key"]'
        ).value = newObject["id"];
        AddEventMenu.classList.add("active");
        console.log("actia");
      }
      function DeleteItemFunction(value) {
        console.log("welw");
      }
    }
    if (location == "Expenses") {
      function UpdateItemFunction(value) {
        const AddEventMenu = document.querySelector(".event_menu_add");
        newObject = value.getAttribute("data-information");
        newObject = JSON.parse(newObject);

        document.querySelector(
          '.event_menu_add select[name="category"]'
        ).value = newObject["Category"];
        document.querySelector('.event_menu_add input[name="Amount"]').value =
          newObject["Amount"];

        document.querySelector('.event_menu_add input[name="Date"]').value =
          newObject["Date"];
        document.querySelector('.event_menu_add select[name="type"]').value =
          newObject["Type"];
        document.querySelector(
          '.event_menu_add textarea[name="details"]'
        ).value = newObject["Details"];
        document.querySelector(
          '.event_menu_add input[name="delete_key"]'
        ).value = newObject["id"];
        AddEventMenu.classList.add("active");
        console.log("actia");
      }
      function DeleteItemFunction(value) {
        console.log("welw");
      }
    }
    if (location == "records") {
      const AddEventBtn_far = document.querySelector(".add_event.far");
      const RecordsDivs = document.querySelectorAll(".annc_item");
      RecordsDivs.forEach((element) => {
        var MainData = element.querySelector("i.Update_item");
        const SubmitForm = element.querySelector("form");
        SubmitForm.addEventListener("submit", function (e) {
          e.preventDefault();
          if (SubmitForm.hasAttribute("form-id")) {
            PHPREQUEST("update", SubmitForm);
          } else {
            PHPREQUEST("upload", SubmitForm);
          }
        });
        if (MainData != null) {
          MainData.addEventListener("click", function () {
            element.querySelector(".Activity_record").classList.toggle("edit");
            MainData.parentElement.classList.toggle("active");
          });
        }
      });
      AddEventBtn_far.addEventListener("click", function () {
        const Template = document.querySelector("#template");
        const Div = document.createElement("div");
        const newClone = Template.cloneNode(true);
        newClone.setAttribute("id", "newClone");
        newClone.removeAttribute("hidden");
        var EventUpdateButton = newClone.querySelector("i.Update_item");
        const SubmitForm = newClone.querySelector("form");
        SubmitForm.addEventListener("submit", function (e) {
          e.preventDefault();
          if (SubmitForm.hasAttribute("form-id")) {
            PHPREQUEST("update", SubmitForm);
          } else {
            PHPREQUEST("upload", SubmitForm);
          }
        });
        EventUpdateButton.addEventListener("click", function () {
          newClone.querySelector(".Activity_record").classList.toggle("edit");
          EventUpdateButton.parentElement.classList.toggle("active");
        });
        Div.append(newClone);
        document.querySelector(".ancc_list").prepend(Div);
      });
      function UpdateItemFunction(value) {
        // newObject = value.getAttribute("data-information");
        // newObject = JSON.parse(newObject);
        // document.querySelector('.event_menu_add input[name="name"]').value =
        //   newObject["name"];
        // document.querySelector('.event_menu_add input[name="amount"]').value =
        //   newObject["partnership"];
        // document.querySelector('.event_menu_add select[name="type"]').value =
        //   newObject["Type"];
        // document.querySelector('.event_menu_add input[name="email"]').value =
        //   newObject["Email"];
        // document.querySelector('.event_menu_add input[name="period"]').value =
        //   newObject["Period"];
        // document.querySelector('.event_menu_add select[name="status"]').value =
        //   newObject["status"];
        // document.querySelector('.event_menu_add input[name="date"]').value =
        //   newObject["date"];
        // document.querySelector(
        //   '.event_menu_add input[name="delete_key"]'
        // ).value = newObject["UniqueId"];
        // AddEventMenu.classList.add("active");
        // APIDOCS =
        //   "../API/partnership/data_process.php?APICALL=true&&user=true&&submit=update_file";
      }
      function DeleteItemFunction(value, validateKey) {
        console.log(value, validateKey);
        if (value == "true" && validateKey) {
          let API =
            "../API/SundayRecords/data_process.php?APICALL=true&&user=true&&submit=delete";
          PHPREQUESTDEL(API, validateKey);
        }
      }

      async function FilterOptionsFun(APIDOCS, validateKey) {
        let data;

        try {
          dataSend = {
            key: validateKey,
          };
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: JSON.stringify(dataSend),
            headers: {
              "Content-Type": "application/json",
            },
          });

          if (Request.status === 200) {
            data = await Request.json(data);
            if (data) {
              if (data["message"] == "Not Records Available") {
                alert("Not Records Available");
              } else {
                values = data["message"];
                document.querySelector(".content_main table tbody").innerHTML =
                  values;
              }
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }

      async function PHPREQUEST(value, SubmitForm) {
        let APIDOCS;
        let formMain = new FormData(SubmitForm);
        console.log(value);
        if (value == "update") {
          APIDOCS =
            "../API/SundayRecords/data_process.php?APICALL=true&&user=true&&submit=update";
        } else if (value == "upload") {
          APIDOCS =
            "../API/SundayRecords/data_process.php?APICALL=true&&user=true&&submit=upload";
        }
        let data;
        try {
          const formMain = new FormData(SubmitForm);
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: formMain,
          });

          if (Request.status === 200) {
            data = await Request.json();
            if (data) {
              if (value == "upload") {
                if (
                  data["message"] ==
                  "Data entry was a success Page will refresh to display new data"
                ) {
                  SubmitForm.setAttribute("form-id", data["id"]);
                }
              }
              console.log(data);
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }

      async function PHPREQUESTDEL(APIDOCS, validateKey) {
        let data;

        try {
          dataSend = {
            key: validateKey,
          };
          console.log(dataSend);
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: JSON.stringify(dataSend),
            headers: {
              "Content-Type": "application/json",
            },
          });

          if (Request.status === 200) {
            data = await Request.json(data);
            if (data) {
              if ((data["message"] = "Item Deleted Successfully")) {
                console.log(data);
              }
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }
    }
    if (location == "Tithe") {
      function UpdateItemFunction(value) {
        const AddEventMenu = document.querySelector(".event_menu_add");
        newObject = value.getAttribute("data-information");
        newObject = JSON.parse(newObject);

        document.querySelector('.event_menu_add select[name="Name"]').value =
          newObject["Name"];
        document.querySelector('.event_menu_add input[name="amount"]').value =
          newObject["Amount"];

        document.querySelector('.event_menu_add input[name="Date"]').value =
          newObject["Date"];
        document.querySelector(
          '.event_menu_add input[name="delete_key"]'
        ).value = newObject["id"];
        AddEventMenu.classList.add("active");
        console.log("actia");
      }
      function DeleteItemFunction(value) {
        console.log("welw");
      }
    }
    if (location == "Assets") {
      let APIDOCS;
      var newObject = "";
      const AddEventBtn = document.querySelector(".add_event");
      const SubmitBtn = document.querySelector(".event_menu_add button");
      const SubmitForm = document.querySelector(".event_menu_add form");
      const ResponseView = document.querySelector(".error_information");
      const imageCompound = document.querySelector(
        '.event_menu_add input[name="imageFile"]'
      );
      confirmsBtns.forEach((element) => {
        element.addEventListener("click", (e) => {
          if (element.getAttribute("data-confirm") == "true") {
            console.log(document.querySelector(".delete_item"));

            if (validateKey != "") {
              DeleteItemFunction(
                element.getAttribute("data-confirm"),
                validateKey
              );
            }
          }
        });
      });

      AddEventBtn.addEventListener("click", function (e) {
        APIDOCS =
          "../API/Assets&projects/data_process.php?APICALL=true&&user=true&&submit=delete_file";

        if (!imageCompound.hasAttribute("required")) {
          imageCompound.setAttribute("required", "true");
        }
      });
      function UpdateItemFunction(value) {
        const AddEventMenu = document.querySelector(".event_menu_add");
        newObject = value.getAttribute("data-information");
        newObject = JSON.parse(newObject);

        document.querySelector('.event_menu_add input[name="name"]').value =
          newObject["name"];
        document.querySelector('.event_menu_add input[name="source"]').value =
          newObject["source"];
        document.querySelector('.event_menu_add input[name="location"]').value =
          newObject["location"];
        document.querySelector('.event_menu_add input[name="date"]').value =
          newObject["date"];
        document.querySelector('.event_menu_add select[name="status"]').value =
          newObject["status"];
        document.querySelector('.event_menu_add input[name="value"]').value =
          newObject["value"];
        document.querySelector('.event_menu_add input[name="total"]').value =
          newObject["total"];
        document.querySelector(".event_menu_add textarea").value =
          newObject["About"];
        document.querySelector(
          '.event_menu_add input[name="delete_key"]'
        ).value = newObject["id"];
        AddEventMenu.classList.add("active");
        if (imageCompound.hasAttribute("required")) {
          imageCompound.removeAttribute("required");
        }

        APIDOCS =
          "../API/Assets&projects/data_process.php?APICALL=true&&user=true&&submit=update_file";
      }

      function DeleteItemFunction(value, validateKey) {
        console.log(value, validateKey);
        if (value == "true") {
          let API =
            "../API/Assets&projects/data_process.php?APICALL=true&&user=true&&submit=delete_file";
          PHPREQUESTDEL(API, validateKey);
        }
      }
      async function PHPREQUEST(APIDOCS) {
        let data;
        try {
          const formMain = new FormData(SubmitForm);
          formMain.append(
            "status",
            document.querySelector('.event_menu_add select[name="status"]')
              .value
          );
          formMain.append(
            "file",
            document.querySelector('.event_menu_add input[type="file"]')
              .files[0]
          );
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: formMain,
          });

          if (Request.status === 200) {
            data = await Request.json();
            if (data) {
              ResponseView.innerText = data;
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }

      async function PHPREQUESTDEL(APIDOCS, validateKey) {
        let data;

        try {
          dataSend = {
            key: validateKey,
          };
          console.log(dataSend);
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: JSON.stringify(dataSend),
            headers: {
              "Content-Type": "application/json",
            },
          });

          if (Request.status === 200) {
            data = await Request.json(data);
            if (data) {
              ResponseView.innerText = data;
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }

      SubmitForm.addEventListener("submit", async function (e) {
        ResponseView.innerText = "loading...";
        e.preventDefault();
        PHPREQUEST(APIDOCS);
      });
    }
    if (location == "Announcement" || location == "records") {
      window.addEventListener("click", function (e) {
        var target = e.target;
        if (target.classList.contains("Update_item")) {
          UpdateItemFunction(target);
        }
        if (target.classList.contains("delete_item")) {
          dn_message.classList.add("active");
        }
        confirmsBtns.forEach((element) => {
          element.addEventListener("click", (e) => {
            if (element.getAttribute("data-confirm") == "true") {
              validateKey = target.getAttribute("data-id");
              if (validateKey != "") {
                console.log("sdsd");
                DeleteItemFunction(
                  element.getAttribute("data-confirm"),
                  validateKey
                );
              }
            }
          });
        });
      });
    }
    if (location == "Announcement") {
      const toggleModes = document.querySelectorAll(".toggle_mode");
      toggleModes.forEach((element) => {
        element.addEventListener("click", function () {
          element.classList.toggle("active");
        });
      });
      function UpdateItemFunction(value) {
        const AddEventMenu = document.querySelector(".event_menu_add");
        newObject = value.getAttribute("data-information");
        newObject = JSON.parse(newObject);

        document.querySelector(
          '.event_menu_add textarea[name="message"]'
        ).value = newObject["message"];
        document.querySelector(
          '.event_menu_add input[name="delete_key"]'
        ).value = newObject["id"];
        AddEventMenu.classList.add("active");
      }
    }
    if (location == "projects") {
      let APIDOCS;
      const AddEventBtn = document.querySelector(".add_event");
      const SubmitForm = document.querySelector(".event_menu_add form");
      const ResponseView = document.querySelector(".error_information");
      const imageCompound = document.querySelector(
        '.event_menu_add input[name="imageFile"]'
      );

      confirmsBtns.forEach((element) => {
        element.addEventListener("click", (e) => {
          if (element.getAttribute("data-confirm") == "true") {
            console.log(document.querySelector(".delete_item"));

            if (validateKey != "") {
              DeleteItemFunction(
                element.getAttribute("data-confirm"),
                validateKey
              );
            }
          }
        });
      });

      AddEventBtn.addEventListener("click", function (e) {
        APIDOCS =
          "../API/Assets&projects/data_process.php?APICALL=true&&user=true&&submit=true";

        if (!imageCompound.hasAttribute("required")) {
          imageCompound.setAttribute("required", "true");
        }
      });
      function UpdateItemFunction(value) {
        const AddEventMenu = document.querySelector(".event_menu_add");
        newObject = value.getAttribute("data-information");
        newObject = JSON.parse(newObject);

        document.querySelector('.event_menu_add input[name="name"]').value =
          newObject["name"];
        document.querySelector('.event_menu_add input[name="target"]').value =
          newObject["target"];
        document.querySelector('.event_menu_add input[name="current"]').value =
          newObject["current"];
        document.querySelector('.event_menu_add input[name="date"]').value =
          newObject["Start"];
        document.querySelector('.event_menu_add select[name="status"]').value =
          newObject["Status"];

        document.querySelector(".event_menu_add textarea").value =
          newObject["description"];
        document.querySelector(
          '.event_menu_add input[name="delete_key"]'
        ).value = newObject["id"];
        AddEventMenu.classList.add("active");
        if (imageCompound.hasAttribute("required")) {
          imageCompound.removeAttribute("required");
        }

        APIDOCS =
          "../API/Assets&projects/data_process.php?APICALL=true&&user=true&&submit=update_file";
      }

      function DeleteItemFunction(value, validateKey) {
        console.log(value, validateKey);
        if (value == "true") {
          let API =
            "../API/Assets&projects/data_process.php?APICALL=true&&user=true&&submit=delete_file";
          PHPREQUESTDEL(API, validateKey);
        }
      }
      async function PHPREQUEST(APIDOCS) {
        console.log(APIDOCS);
        let data;
        try {
          const formMain = new FormData(SubmitForm);
          formMain.append(
            "status",
            document.querySelector('.event_menu_add select[name="status"]')
              .value
          );
          formMain.append(
            "file",
            document.querySelector('.event_menu_add input[type="file"]')
              .files[0]
          );
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: formMain,
          });

          if (Request.status === 200) {
            data = await Request.json();
            if (data) {
              ResponseView.innerText = data;
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }

      async function PHPREQUESTDEL(APIDOCS, validateKey) {
        let data;

        try {
          dataSend = {
            key: validateKey,
          };
          console.log(dataSend);
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: JSON.stringify(dataSend),
            headers: {
              "Content-Type": "application/json",
            },
          });

          if (Request.status === 200) {
            data = await Request.json(data);
            if (data) {
              ResponseView.innerText = data;
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }
      SubmitForm.addEventListener("submit", async function (e) {
        ResponseView.innerText = "loading...";
        e.preventDefault();
        PHPREQUEST(APIDOCS);
      });
    }
    if (location == "Partnership") {
      const OptionElements = document.querySelectorAll(".btn_record");
      const Partnership_record = document.querySelector(".series_version");
      const AddEventMenu = document.querySelector(".event_menu_add");
      const Export_variables = document.querySelector(
        ".exportFiles.filter_content"
      );
      const FilterOptions = document.querySelectorAll(
        ".exportFiles.filter_content .item_passage"
      );
      let APIDOCS;
      let confirmKey = true;
      const AddEventBtn = document.querySelector(".add_event");
      const SubmitForm = document.querySelector(".event_menu_add.main form");
      const ResponseView = document.querySelector(".error_information");
      Export_variables.addEventListener("click", (e) => {
        var nextElements = document.querySelector(".filter_content_space");
        nextElements.classList.toggle("active");
      });
      confirmsBtns.forEach((element) => {
        element.addEventListener("click", (e) => {
          if (element.getAttribute("data-confirm") == "true") {
            console.log(document.querySelector(".delete_item"));

            if (validateKey != "") {
              DeleteItemFunction(
                element.getAttribute("data-confirm"),
                validateKey
              );
            }
          }
        });
      });
      FilterOptions.forEach((element) => {
        element.addEventListener("click", function (e) {
          option = element.getAttribute("filter_value");
          APIDOCS =
            "../API/partnership/data_process.php?APICALL=true&&user=true&&submit=filter";
          FilterOptionsFun(APIDOCS, option);
        });
      });

      AddEventBtn.addEventListener("click", function (e) {
        APIDOCS =
          "../API/partnership/data_process.php?APICALL=true&&user=true&&submit=true";
      });
      function DestructureJson(element) {
        newObject = JSON.parse(
          element.parentElement.getAttribute("data-information")
        );
        const PartnerContainer =
          Partnership_record.querySelector(".menu.event");
        if (Object.keys(newObject).length > 0) {
          PartnerContainer.innerHTML = "";
          for (const iletrate in newObject) {
            PartnerContainer.innerHTML += `<div class="item"><div class="details">
            <p>${new Date(newObject[iletrate]["date"])}</p>
            <p> recorded . ${newObject[iletrate]["Amount"]}</p>
        </div>
        <div class="option"><i class="fas fa-trash" data-cn="trash" data-id="${
          newObject[iletrate]["id"]
        }"></i><div>
        </div>`;
          }
        } else {
          PartnerContainer.innerHTML = `<div class="item"><div class="details">
            <p>No Records Available</p>
        </div></div>`;
        }
      }

      window.addEventListener("click", function (e) {
        var target = e.target;
        console.log(target.parentElement);
        if (
          target.parentElement.classList.contains("option") ||
          target.parentElement.parentElement.classList.contains("option")
        ) {
          let parentElement;
          if (target.parentElement.classList.contains("option")) {
            parentElement = target.parentElement;
          } else if (
            target.parentElement.parentElement.classList.contains("option")
          ) {
            parentElement = target.parentElement.parentElement;
          }
          var ElementOptions = parentElement.querySelector(".opt_element");
          if (ElementOptions != null) {
            ElementOptions.classList.add("active");
          }
        }
        if (target.tagName == "I") {
          if (target.hasAttribute("data-cn")) {
            if (target.hasAttribute("data-id")) {
              validateKey = target.getAttribute("data-id");
              Partnership_record.classList.remove("active");
              dn_message.classList.add("active");
              confirmKey = false;
            }
          }
        }
        OptionElements.forEach((element) => {
          if (element.contains(target)) {
            Partnership_record.classList.add("active");
            DestructureJson(element);
          }
        });

        if (!target.classList.contains("btn_record")) {
          if (
            Partnership_record.classList.contains("active") &&
            !Partnership_record.contains(target)
          ) {
            Partnership_record.classList.remove("active");
          }
        }
      });

      function UpdateItemFunction(value) {
        newObject = value.getAttribute("data-information");
        newObject = JSON.parse(newObject);
        document.querySelector('.event_menu_add input[name="name"]').value =
          newObject["name"];
        document.querySelector('.event_menu_add input[name="amount"]').value =
          newObject["partnership"];
        document.querySelector('.event_menu_add select[name="type"]').value =
          newObject["Type"];
        document.querySelector('.event_menu_add input[name="email"]').value =
          newObject["Email"];
        document.querySelector('.event_menu_add input[name="period"]').value =
          newObject["Period"];
        document.querySelector('.event_menu_add select[name="status"]').value =
          newObject["status"];
        document.querySelector('.event_menu_add input[name="date"]').value =
          newObject["date"];
        document.querySelector(
          '.event_menu_add input[name="delete_key"]'
        ).value = newObject["UniqueId"];
        AddEventMenu.classList.add("active");
        APIDOCS =
          "../API/partnership/data_process.php?APICALL=true&&user=true&&submit=update_file";
      }
      function DeleteItemFunction(value, validateKey) {
        if (value == "true" && confirmKey) {
          let API =
            "../API/partnership/data_process.php?APICALL=true&&user=true&&submit=delete_file";
          PHPREQUESTDEL(API, validateKey);
        } else if (value == "true" && !confirmKey) {
          API =
            "../API/partnership/data_process.php?APICALL=true&&user=true&&submit=delete_ini";
          PHPREQUESTDEL(API, validateKey);
        }
      }

      async function FilterOptionsFun(APIDOCS, validateKey) {
        let data;

        try {
          dataSend = {
            key: validateKey,
          };
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: JSON.stringify(dataSend),
            headers: {
              "Content-Type": "application/json",
            },
          });

          if (Request.status === 200) {
            data = await Request.json(data);
            if (data) {
              if (data["message"] == "Not Records Available") {
                alert("Not Records Available");
              } else {
                values = data["message"];
                document.querySelector(".content_main table tbody").innerHTML =
                  values;
              }
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }

      async function PHPREQUEST(APIDOCS) {
        console.log(APIDOCS);
        let data;
        try {
          const formMain = new FormData(SubmitForm);
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: formMain,
          });

          if (Request.status === 200) {
            data = await Request.json();
            if (data) {
              ResponseView.innerText = data;
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }

      async function PHPREQUESTDEL(APIDOCS, validateKey) {
        let data;

        try {
          dataSend = {
            key: validateKey,
          };
          console.log(dataSend);
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: JSON.stringify(dataSend),
            headers: {
              "Content-Type": "application/json",
            },
          });

          if (Request.status === 200) {
            data = await Request.json(data);
            if (data) {
              ResponseView.innerText = data;
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }
      SubmitForm.addEventListener("submit", async function (e) {
        ResponseView.innerText = "loading...";
        e.preventDefault();

        PHPREQUEST(APIDOCS);
      });
    }
    if (location == "Department") {
      let APIDOCS;
      const AddEventBtn = document.querySelector(".add_event");
      const SubmitForm = document.querySelector(".event_menu_add form");
      const ResponseView = document.querySelector(".error_information");

      confirmsBtns.forEach((element) => {
        element.addEventListener("click", (e) => {
          if (element.getAttribute("data-confirm") == "true") {
            console.log(document.querySelector(".delete_item"));

            if (validateKey != "") {
              DeleteItemFunction(
                element.getAttribute("data-confirm"),
                validateKey
              );
            }
          }
        });
      });

      AddEventBtn.addEventListener("click", function (e) {
        APIDOCS =
          "../API/ministriesData & theme/data_process.php?APICALL=true&&user=true&&submit=true";
      });

      function UpdateItemFunction(value) {
        const AddEventMenu = document.querySelector(".event_menu_add");
        newObject = value.getAttribute("data-information");
        newObject = JSON.parse(newObject);
        document.querySelector('.event_menu_add input[name="name"]').value =
          newObject["name"];

        document.querySelector('.event_menu_add input[name="members"]').value =
          newObject["members"];

        document.querySelector('.event_menu_add input[name="manager"]').value =
          newObject["manager"];

        document.querySelector('.event_menu_add select[name="status"]').value =
          newObject["status"];

        document.querySelector('.event_menu_add input[name="members"]').value =
          newObject["members"];

        document.querySelector('.event_menu_add input[name="date"]').value =
          newObject["date"];

        document.querySelector('.event_menu_add textarea[name="about"]').value =
          newObject["about"];
        document.querySelector(
          '.event_menu_add input[name="delete_key"]'
        ).value = newObject["UniqueId"];
        AddEventMenu.classList.add("active");
        APIDOCS =
          "../API/ministriesData & theme/data_process.php?APICALL=true&&user=true&&submit=update_file";
      }
      function DeleteItemFunction(value, validateKey) {
        console.log(value, validateKey);
        if (value == "true") {
          let API =
            "../API/ministriesData & theme/data_process.php?APICALL=true&&user=true&&submit=delete_file";
          PHPREQUESTDEL(API, validateKey);
        }
      }
      async function PHPREQUEST(APIDOCS) {
        console.log(APIDOCS);
        let data;
        try {
          const formMain = new FormData(SubmitForm);
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: formMain,
          });

          if (Request.status === 200) {
            data = await Request.json();
            if (data) {
              ResponseView.innerText = data;
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }

      async function PHPREQUESTDEL(APIDOCS, validateKey) {
        let data;

        try {
          dataSend = {
            key: validateKey,
          };
          console.log(dataSend);
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: JSON.stringify(dataSend),
            headers: {
              "Content-Type": "application/json",
            },
          });

          if (Request.status === 200) {
            data = await Request.json(data);
            if (data) {
              ResponseView.innerText = data;
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }
      SubmitForm.addEventListener("submit", async function (e) {
        ResponseView.innerText = "loading...";
        e.preventDefault();

        PHPREQUEST(APIDOCS);
      });
    }

    if (location == "Membership") {
      let APIDOCS;
      const AddEventBtn = document.querySelector(".add_event");
      const SubmitForm = document.querySelector(".event_menu_add form");
      const SubmitSearchForm = document.querySelector("#searchInput");
      const SubmitSearchbutton = document.querySelector("#searchBtn");
      const ResponseView = document.querySelector(".error_information");
      const imageCompound = document.querySelector(
        '.event_menu_add input[name="imageFile"]'
      );
      confirmsBtns.forEach((element) => {
        element.addEventListener("click", (e) => {
          if (element.getAttribute("data-confirm") == "true") {
            console.log(document.querySelector(".delete_item"));

            if (validateKey != "") {
              DeleteItemFunction(
                element.getAttribute("data-confirm"),
                validateKey
              );
            }
          }
        });
      });
      SubmitSearchbutton.addEventListener("click", function (e) {
        value = SubmitSearchForm.value;
        console.log(value);
        APIDOCS =
          "../API/membership/data_process.php?APICALL=true&&user=true&&submit=search_file";
        PHPREQUESTDEL(APIDOCS, value);
      });
      // SubmitSearchForm.addEventListener("keyup", function (e) {
      //   value = SubmitSearchForm.value;
      //   console.log(value);
      //   APIDOCS =
      //     "../API/membership/data_process.php?APICALL=true&&user=true&&submit=search_file";
      //   PHPREQUESTDEL(APIDOCS, value);
      // });

      AddEventBtn.addEventListener("click", function (e) {
        APIDOCS =
          "../API/membership/data_process.php?APICALL=true&&user=true&&submit=true";

        if (!imageCompound.hasAttribute("required")) {
          imageCompound.setAttribute("required", "true");
        }
      });
      function UpdateItemFunction(value) {
        const AddEventMenu = document.querySelector(".event_menu_add");
        newObject = value.getAttribute("data-information");
        newObject = JSON.parse(newObject);

        document.querySelector('.event_menu_add input[name="Oname"]').value =
          newObject["Oname"];
        document.querySelector('.event_menu_add input[name="Fname"]').value =
          newObject["Fname"];
        document.querySelector('.event_menu_add input[name="birth"]').value =
          newObject["birth"];
        document.querySelector(
          '.event_menu_add input[name="occupation"]'
        ).value = newObject["occupation"];
        document.querySelector('.event_menu_add input[name="gender"]').value =
          newObject["gender"];
        document.querySelector('.event_menu_add input[name="contact"]').value =
          newObject["contact"];
        document.querySelector('.event_menu_add input[name="location"]').value =
          newObject["location"];
        document.querySelector('.event_menu_add input[name="baptism"]').value =
          newObject["Baptism"];
        document.querySelector('.event_menu_add select[name="status"]').value =
          newObject["status"];
        document.querySelector('.event_menu_add input[name="position"]').value =
          newObject["Position"];
        document.querySelector('.event_menu_add input[name="birth"]').value =
          newObject["birth"];
        document.querySelector(
          '.event_menu_add input[name="delete_key"]'
        ).value = newObject["UniqueId"];
        AddEventMenu.classList.add("active");
        APIDOCS =
          "../API/membership/data_process.php?APICALL=true&&user=true&&submit=update_file";
      }
      function DeleteItemFunction(value, validateKey) {
        console.log(value, validateKey);
        if (value == "true") {
          let API =
            "../API/membership/data_process.php?APICALL=true&&user=true&&submit=delete_file";
          PHPREQUESTDEL(API, validateKey);
        }
      }
      async function PHPREQUEST(APIDOCS) {
        console.log(APIDOCS);
        let data;
        try {
          const formMain = new FormData(SubmitForm);
          formMain.append(
            "status",
            document.querySelector('.event_menu_add select[name="status"]')
              .value
          );
          formMain.append(
            "file",
            document.querySelector('.event_menu_add input[type="file"]')
              .files[0]
          );
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: formMain,
          });

          if (Request.status === 200) {
            data = await Request.json();
            if (data) {
              ResponseView.innerText = data;
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }

      async function PHPREQUESTDEL(APIDOCS, validateKey) {
        let data;

        try {
          dataSend = {
            key: validateKey,
          };
          console.log(dataSend);
          controller = new AbortController();
          const signal = controller.signal;
          const Request = await fetch(APIDOCS, {
            method: "POST",
            body: JSON.stringify(dataSend),
            headers: {
              "Content-Type": "application/json",
            },
          });

          if (Request.status === 200) {
            data = await Request.json(data);
            if (data) {
              ResponseView.innerText = data;
            }
          } else {
            console.log("cannot find endpoint");
          }
        } catch (error) {
          console.error(error);
        }
      }
      SubmitForm.addEventListener("submit", async function (e) {
        ResponseView.innerText = "loading...";
        e.preventDefault();
        PHPREQUEST(APIDOCS);
      });
    }
  };
  function setIntervalData() {
    IntervalSetAnimation = setInterval(() => {
      if (intVal < 99) {
        loader_progress.style.setProperty("--pr", intVal++);
        intVal += 2;
      } else {
        clearInterval(IntervalSetAnimation);
        loader_progress.querySelector(".progress").classList.add("animateStar");
      }
    }, 500);
  }
  function ProgressLoader(val) {
    if (val == true) {
      if (loader_progress.classList.contains("active")) {
        setIntervalData();
      }
    } else {
      loader_progress.style.setProperty("--pr", 100);
      clearInterval(IntervalSetAnimation);
      loader_progress.style.setProperty("--pr", 0);
      loader_progress
        .querySelector(".progress")
        .classList.remove("animateStar");
      intVal = 0;
    }
  }

  function UrlTrace() {
    let DomManipulationElement;
    location = window.location.hash.replace("#", "");

    if (location.length == 0) {
      location = "/";
    }
    const route = Urlroutes[location] || Urlroutes[404];
    if (ArrayTables.includes(location)) {
      DomManipulationElement = SkeletonDom_table;
    } else {
      DomManipulationElement = SkeletonDom_list;
    }
    loader_progress.classList.add("active");

    ContentDom.classList.add("load");
    DomManipulationElement.classList.add("load");
    setTimeout(() => {
      ProgressLoader(true);
    }, 100);
    locationHandler(route.template, location).then((data) => {
      loader_progress.classList.remove("active");
      DomManipulationElement.classList.remove("load");
      ContentDom.classList.remove("load");
      setTimeout(() => {
        ProgressLoader(false);
      }, 100);
    });
  }

  async function pagnationSystem(value) {
    ///scroll functionalities
    const rootElement = document.documentElement;
    rootElement.scrollTo({
      top: 40,
      behavior: "smooth",
    });
    let DomManipulationElement;
    const route = Urlroutes[location] || Urlroutes[404];
    if (route) {
      request = route.template + "?page=" + value;
      if (request) {
        if (ArrayTables.includes(location)) {
          DomManipulationElement = SkeletonDom_table;
        } else {
          DomManipulationElement = SkeletonDom_list;
        }
        loader_progress.classList.add("active");

        ContentDom.classList.add("load");
        DomManipulationElement.classList.add("load");
        setTimeout(() => {
          ProgressLoader(true);
        }, 100);

        locationHandler(request, location).then((data) => {
          loader_progress.classList.remove("active");
          DomManipulationElement.classList.remove("load");
          ContentDom.classList.remove("load");
          setTimeout(() => {
            ProgressLoader(false);
          }, 100);
        });
      }
    }
  }
  window.addEventListener("hashchange", function (e) {
    document.documentElement.scrollTo({
      top: 0,
      behavior: "smooth",
    });
    UrlTrace();
  });
  AsideManipulator.addEventListener("click", function (e) {
    document.querySelector("li.expand").classList.toggle("active");
  });
  UrlTrace();

  window.addEventListener("scroll", function (e) {
    if (this.scrollY > 30) {
      document.querySelector("main").classList.add("scroll_overflow");
    } else {
      document.querySelector("main").classList.remove("scroll_overflow");
    }
  });
  window.addEventListener("click", function (e) {
    var target = e.target;
    if (
      dn_message.classList.contains("active") &&
      !target.classList.contains("btn_confirm")
    ) {
      dn_message.classList.remove("active");
    } else if (
      dn_message.classList.contains("active") &&
      target.classList.contains("btn_confirm")
    ) {
      dn_message.classList.remove("active");
    }
  });
});
