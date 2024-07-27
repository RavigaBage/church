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
  const AsideList = document.querySelectorAll("aside a");
  const SearchBar = document.querySelector(".date_view.search");
  const Search_notify = document.querySelector(".icon_notify");

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
      template: "../pages/404.html",
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
      template: "../pages/library/library.txt",
      title: "Library screen | Router sequence",
      description: "hero",
    },
    Finance: {
      template: "../pages/finance/finance_h.php",
      title: "Library screen | Router sequence",
      description: "hero",
    },
    Dashboard: {
      template: "../pages/Dashboard.html",
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
      template: "../pages/Gallery.txt",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    History: {
      template: "History/history.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    FinanceAccount: {
      template: "../pages/finance/finance_account.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Tithe: {
      template: "../pages/finance/finance_tithe.php",
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
      template: "../pages/finance/transactions.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Expenses: {
      template: "../pages/finance/Expenses.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Budget: {
      template: "../pages/finance/Budget.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    records: {
      template: "records/records.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Announcement: {
      template: "../pages/announcement.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    calender: {
      template: "../pages/calender.php",
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

    try {
      if (!loader_status) {
        if (location == "Access_token") {
          const mainDiv = document.querySelector(".timer_set");
          const HourEle = mainDiv.querySelector(".hour");
          const MinuteEle = mainDiv.querySelector(".min");
          const SecondEle = mainDiv.querySelector(".second");
          const value_set = document.querySelector("#value_data_set");
          const pemChecker = document.querySelector(".permChecker");
          const Current_Data = new Date();
          const CurentNow = Current_Data.getTime();
          async function ConfirmAssign() {
            if (confirm("Are you sure you want to assign this password")) {
              try {
                APIDOCS =
                  "../API/notifications & token & history/data_process.php?APICALL=true&&user=true&&submit=settoken";
                dataSend = {
                  duration: CurentNow,
                  code: document.querySelector(".tokenData div").innerText,
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
                    console.log(data.result);
                    if (data.result == "success") {
                      var timerSet = document.querySelector(".token");
                      var TokenHeader = document.querySelector(
                        ".access_token header"
                      );
                      timerSet.classList.add("active");
                      TokenHeader.innerText = `Security Code has been activated code - ${
                        document.querySelector(".tokenData div").innerText
                      }.
                      Instruct users to use this code as passkey to access limited Admin features `;
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

          if (value_set.value != "empty" || value_set.value != "expired") {
            OriginalValue = value_set.value;
            timer.IntervalSet(HourEle, MinuteEle, SecondEle, OriginalValue);
          }
          if (value_set.value == "empty" || value_set.value == "expired") {
            console.log(value_set.value);
            document
              .querySelector(".token button")
              .addEventListener("click", function () {
                timer.generateToken();
                setTimeout(() => {
                  ConfirmAssign();
                }, 500);
              });
          }
        }
        if (location == "calender") {
          const TabsMenu = document.querySelectorAll(".menu_tab");
          const CategoryMenu = document.querySelector(".event_category");
          const AddBtn = document.querySelector(".plus_arrow");
          const AddMenu = document.querySelector(".new_event_menu");
          const ViewElements = document.querySelector(".grid_space");
          const SaveDetails = document.querySelector("#save_details");
          const selectors = document.querySelectorAll(".svg_wrapper");
          const formData = document.querySelector("#formData");
          const calenderData = document.querySelector("#calender_data");
          const CurrentDay = document.querySelector(".day_event .day_info");
          const Calender_Data = document.querySelector("#calender_data");
          const YearListElem = document.querySelector(".year_list");
          DataCalenderObj = JSON.parse(calenderData.value);
          formData.addEventListener("submit", function (e) {
            e.preventDefault();
          });
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
          const DaySelector = document.querySelectorAll(
            ".min_calenda div span"
          );
          const MenuDate = document.querySelector(".menu_date");
          const YearList = document.querySelector(".year_choose");

          const MenuArrowLeft = document.querySelector(".add_menu .left_arrow");
          const MenuArrowRight = document.querySelector(
            ".add_menu .right_arrow"
          );
          const MenuData = document.querySelector(".menu_date header");
          let currentSpan = "";
          let ActiveTime = 0;
          let DateFetch = new Date();
          let year = DateFetch.getFullYear();
          let month = DateFetch.getMonth();
          let Current = DateFetch.getDate();
          let Current_Day = DateFetch.getDay();
          let Time_position = "";
          let Left_position = "";
          let last = 1;
          let weekObj = [];
          let ResizeOrigin = false;
          let UpdateSession = "";
          let DayVal = "";
          let YItem = year;
          let FilterMonth = month;
          let FilterYear = year;
          let lastChecker = "";

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
          let DaysLater = ["Sun", "Mon", "Tue", "Wed", "Thurs", "Fri", "Sat"];
          CurrentDay.querySelector("header").innerText = Current;
          CurrentDay.querySelector(
            "p"
          ).innerText = `${DaysLater[Current_Day]} , ${Current} ${monthNames[month]}  ,   ${year}`;
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
              console.log(YearListElem);
              if (
                document.querySelector(".month_selector .year header") != null
              ) {
                document.querySelector(
                  ".month_selector .year header"
                ).innerText = element.innerHTML;

                YearListElem.classList.remove("active");
                FilterYear = parseInt(element.innerHTML);
              }
            });
          });

          const MonthListChildren = document.querySelectorAll(
            ".month_selector .view div"
          );
          MonthListChildren.forEach((element) => {
            element.addEventListener("click", function () {
              MonthListChildren.forEach((element) => {
                element.classList.remove("active");
              });
              element.classList.add("active");
              FilterMonth = parseInt(element.getAttribute("data_id"));
            });
          });
          const FilterBtn = document.querySelector(
            ".month_selector .year button"
          );
          FilterBtn.addEventListener("click", function () {
            MenuData.innerHTML = `${monthNames[FilterMonth]} ${FilterYear}`;
            month = FilterMonth;
            year = FilterYear;
            calender.calender(FilterMonth, FilterYear, 1, "wor;d");
            console.log(FilterYear, FilterMonth);
            getWeeks(FilterMonth, FilterYear, 1);
          });

          document
            .querySelector(".year button")
            .addEventListener("click", function () {
              document
                .querySelector(".month_selector")
                .classList.remove("active");
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
          calender.calender(month, year, Current);

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
              CalcReverse =
                IntVal == 12 ? (IntVal = 12) : (IntVal = 12 + IntVal);
            }
            if (SplitInspectionEnd[1].search("am") >= 0) {
              IntVal_Num =
                SplitVal == 12 ? (SplitVal = 1) : (SplitVal = SplitVal);
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
              currentSpan.querySelector(".element_main_data").innerHTML =
                HtmlVal;
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
              DataObj.Start =
                document.querySelector("P.start_time_p").innerText;
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
              value = "upload";
              PHPREQUEST(value);
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
              console.log(weekObj);
              DisplayWeekResult(weekObj);
            } else {
              weekObj = [];
              getWeeks(month, year, last);
              console.log(month, year, "23");
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
            month = parseInt(month);
            year = parseInt(year);
            day = parseInt(day);
            TrialDate = new Date(year, month, day);

            value = TrialDate.getDay();
            MaxDaysMonth = DaysOfMonth[month];
            console.log(DaysOfMonth[month]);
            for (let i = 0; i < 7; i++) {
              figure = day + i;

              console.log(figure);
              if (figure <= MaxDaysMonth) {
                weekObj.push(figure);
                lastChecker = figure;
              } else {
                let new_figure = figure - MaxDaysMonth;
                weekObj.push(new_figure);
              }
            }
            console.log(weekObj);

            last = weekObj[weekObj.length - 1];
            if (weekObj.includes(day)) {
              if (parseInt(weekObj) == 1) {
                weekObj = [];
                PrevMonth = DaysOfMonth[month - 1];
                MonthFirstDay = TrialDate.getDay();
                for (let i = 0; i < 7; i++) {
                  console.log(MonthFirstDay, weekObj);
                  if (MonthFirstDay == 0) {
                    weekObj.push(PrevMonth);
                    MonthFirstDay = null;
                  } else if (MonthFirstDay > 0) {
                    weekObj.push(PrevMonth - MonthFirstDay);
                    MonthFirstDay--;
                    lastChecker = PrevMonth - MonthFirstDay;
                    last = PrevMonth - MonthFirstDay;
                  } else {
                    weekObj.push(i);
                    last = i;
                  }
                }
              }
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
              }
              weekObj.push(day + (m + 1));
              m += 1;
            }
            last = weekObj[weekObj.length - 1];
            lastChecker = weekObj[weekObj.length - 1];

            DisplayWeekResult(weekObj);
            console.log(weekObj, year, month, last);

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
            lastChecker = weekObj[0] - 1;

            DisplayWeekResult(weekObj);
            weekObj = [];
          }
          function DisplayWeekResult(weekObj) {
            const HeaderSelector = document.querySelectorAll("strong[data-id]");

            if (month == 12) {
              month = 0;
            }

            MenuData.innerHTML = `${monthNames[month]} ${year}`;
            var firstElement = HeaderSelector[0].querySelector("span");
            if (HeaderSelector.length - 1 > HeaderSelector.length - 2) {
              if (isNaN(weekObj[0])) {
                firstElement.classList.add("dim");
              }
              firstElement.innerHTML = weekObj[0];
            } else {
              firstElement.classList.add("dim");
              firstElement.innerHTML = weekObj[0];
            }

            weekObj.forEach((element) => {
              Index = weekObj.indexOf(element);
              for (let i = 1; i < HeaderSelector.length; i++) {
                const element = HeaderSelector[i];
                if (parseInt(element.getAttribute("data-id")) === i - 1) {
                  if (isNaN(weekObj[i])) {
                    element.classList.add("dim");
                  }
                  element.querySelector("span").innerHTML = weekObj[i];
                }
              }
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
            const SchedulesData = document.querySelector(".main_schedule");
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
            if (!SchedulesData.contains(target)) {
              GridCells.forEach((element) => {
                const MainElement = document.querySelector("." + element);

                if (MainElement.contains(target)) {
                  if (target.classList.contains(element)) {
                    indexOfElement = GridCells.indexOf(element);
                    const eventDaysStrong = document.querySelectorAll(
                      ".event_days strong[data-id]"
                    );
                    if (!isNaN(indexOfElement)) {
                      DayVal =
                        eventDaysStrong[indexOfElement].querySelector(
                          "span"
                        ).innerText;
                    }

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
                  ObjectParent =
                    target.parentElement.parentElement.parentElement;
                  if (ObjectParent.classList.contains("event_record")) {
                    UpdateSession = ObjectParent;
                  }
                  AddMenu.querySelector('input[name="EventName"]').value =
                    ObjectData["Name"];
                  AddMenu.querySelector('input[name="EventLocation"]').value =
                    ObjectData["Location"];
                  AddMenu.querySelector(
                    'textarea[name="EventDescription"]'
                  ).value = ObjectData["Description"];
                  AddMenu.querySelector("P.start_time_p").innerText =
                    ObjectData["Start"];
                  AddMenu.querySelector("P.End_time_p").innerText =
                    ObjectData["End"];
                  AddMenu.querySelector("P.EventTag").innerText =
                    ObjectData["Tag"];
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
              document
                .querySelector(".month_selector")
                .classList.remove("active");
            }
          });
          MenuArrowLeft.addEventListener("click", function () {
            getPrevWeek(year, month, last);
          });
          MenuArrowRight.addEventListener("click", function () {
            getNextWeek(year, month, last);
          });
          getWeeks(month, year, Current);

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
          function DeleteItemFunction(value, validateKey, MainForm) {
            if (value == "true" && validateKey) {
              let API =
                "../API/SundayRecords/data_process.php?APICALL=true&&user=true&&submit=delete";
              PHPREQUESTDEL(API, validateKey, MainForm);
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
                    document.querySelector(
                      ".content_main table tbody"
                    ).innerHTML = values;
                  }
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }

          async function PHPREQUEST(value) {
            let APIDOCS;
            console.log(value);
            if (value == "update") {
              APIDOCS =
                "../API/calender/data_process.php?APICALL=true&&user=true&&submit=update";
            } else if (value == "upload") {
              APIDOCS =
                "../API/calender/data_process.php?APICALL=true&&user=true&&submit=upload";
            }

            let data;
            try {
              const formMain = new FormData(formData);
              formMain.append(
                "EventTag",
                document.querySelector(".EventTag").innerText
              );
              formMain.append(
                "StartTime",
                document.querySelector(".start_time_p").innerText
              );
              formMain.append(
                "EndTime",
                document.querySelector(".End_time_p").innerText
              );
              formMain.append("year", year);
              formMain.append("month", month);
              formMain.append("Day", DayVal);
              controller = new AbortController();
              const signal = controller.signal;
              const Request = await fetch(APIDOCS, {
                method: "POST",
                body: formMain,
              });

              if (Request.status === 200) {
                data = await Request.json();
                if (data) {
                  console.log(data);
                  if (value == "upload") {
                    if (
                      data["message"] ==
                      "Data entry was a success Page will refresh to display new data"
                    ) {
                    }
                  }
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }

          async function PHPREQUESTDEL(APIDOCS, validateKey, MainForm) {
            let data;

            try {
              console.log(MainForm);
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
                  if ((data["message"] = "Item Deleted Successfully")) {
                    notifyBox.classList.add("active");
                    notifyBox.querySelector("p").innerText = data["message"];
                    MainForm.classList.add("none");
                    dn_message.classList.remove("active");
                  }
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }
          function sortList(original) {
            newList = [];
            original.forEach((element) => {
              newList.push(element["start"]);
            });
            let sortedList = [];
            newList.sort();
            newList.forEach((element) => {
              original.forEach((elementK) => {
                if (elementK["start"] == element) {
                  sortedList.push(elementK);
                }
              });
            });
            return sortedList;
          }
          function FetchData(year, month, day) {
            let data = Calender_Data.value;
            const DayDiv = document.querySelector(".day_details .schedules");
            const Schedules = document.querySelector(".day_details .events");
            let TimeMorningList = [];
            let TimeEveningList = [];
            if (data != "" || data != " ") {
              let convertToObj = JSON.parse(data);

              for (const key in convertToObj) {
                if (Object.hasOwnProperty.call(convertToObj, key)) {
                  const element = convertToObj[key];
                  if (
                    parseInt(element["Day"]) == parseInt(day) &&
                    parseInt(element["Month"]) == parseInt(month) &&
                    parseInt(element["Year"]) == parseInt(year)
                  ) {
                    if (element["start"].search("am") > 0) {
                      TimeMorningList.push(element);
                    } else if (element["start"].search("pm") > 0) {
                      TimeEveningList.push(element);
                    }
                  }
                }
              }

              TimeMorningList = sortList(TimeMorningList);
              TimeEveningList = sortList(TimeEveningList);

              var newObject = TimeMorningList;

              newObject = newObject.concat(TimeEveningList);
              console.log(newObject);
              newObject.forEach((element) => {
                const element_data = element;
                SchedulesTemplate = `<div class="item ${element_data["department"]}" data-time="${element_data["start"]}">
                      <div class="card">
                          <label>Event : </label>
                          <h1>${element_data["name"]}</h1>
                          <p>${element_data["start"]} -  ${element_data["end"]}</p>
                      </div>
                      <p>${element_data["about"]}</p>
                  </div>`;
                Schedules.innerHTML += SchedulesTemplate;
                DayDivTemplate = `<div class="event_schedule ${element_data["department"]}">
                            <p>${element_data["start"]}</p>
                            <div class="details">
                                <div><p>${element_data["department"]} program</p></div>
                                <div></div>
                                <div></div>
                            </div>
                            <p>${element_data["end"]}</p>
                        </div>`;
                DayDiv.innerHTML += DayDivTemplate;
              });
            }
          }

          FetchData(year, month + 1, Current);
        }
        if (
          location == "projects" ||
          location == "Membership" ||
          location == "Department" ||
          location == "Tithe" ||
          location == "Partnership" ||
          location == "Transaction" ||
          location == "Expenses" ||
          location == "Assets"
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

        if (location == "Appearance") {
          let themeId = 0;
          let themeData = 0;
          var Switch_interface = document.querySelector(".switch_theme");
          const toggleModes = document.querySelectorAll(".toggle_mode");
          var ThemesBtn = Switch_interface.querySelectorAll(".btn_confirm");
          async function ConfirmAssign(id, element) {
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
                  if (data.result == "success") {
                    element.classList.toggle("active");
                  }
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }
          ThemesBtn.forEach((element) => {
            element.addEventListener("click", function () {
              if (element.getAttribute("data-confirm") == "true") {
                ConfirmAssign(themeId, themeData);
              }
              Switch_interface.classList.remove("active");
            });
          });

          toggleModes.forEach((element) => {
            element.addEventListener("click", function () {
              themeId = element.getAttribute("data-id");
              themeData = element;
              Switch_interface.classList.add("active");
            });
          });
        }

        if (location == "Finance") {
          ActivityMenu = true;
          let APIDOCS;
          const AddEventBtn = document.querySelector(".add_event");
          const AddEventMenu = document.querySelector(".event_menu_add.main");
          const AddEventMenu_off = document.querySelector(".event_menu_add");
          const OptionElements = document.querySelectorAll(".option");
          const tabs_offertory = document.querySelector(".offertory_itenary");
          const slider_menu = document.querySelector(".slider_menu");
          const Event_tab = document.querySelector(".home_event_itenary");
          const NavigationFilter = document.querySelector(".options .Filter");
          const AddEventMenu_Btn = document.querySelector(
            ".event_menu_add.main Button"
          );
          const AddEventMenu_off_Btn = document.querySelector(
            ".event_menu_add Button"
          );
          const FilterOptionsFunList = document.querySelector(
            ".notification_list_filter"
          );
          const NavigationFilterList = document.querySelectorAll(
            ".notification_list_filter .item"
          );
          const AddEventMenuForm = AddEventMenu.querySelector("form");
          const AddEventMenu_offForm = AddEventMenu_off.querySelector("form");

          AddEventMenuForm.addEventListener("submit", function (e) {
            e.preventDefault();
          });
          AddEventMenu_offForm.addEventListener("submit", function (e) {
            e.preventDefault();
          });

          NavigationFilter.addEventListener("click", function (e) {
            document
              .querySelector(".notification_list_filter")
              .classList.toggle("active");
          });

          NavigationFilterList.forEach((element) => {
            element.addEventListener("click", function () {
              Finance.FilterSystem(
                element.getAttribute("data-filter"),
                ActivityMenu
              );
            });
          });

          confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (validateKey != "") {
                  DeleteItemFunction(element.getAttribute("data-confirm"));
                }
              }
              setTimeout(() => {
                dn_message.classList.add("active");
                dn_message.classList.add("delete");
              }, 100);
            });
          });

          async function PHPREQUEST(APIDOCS, form, loaderBtn) {
            let data;
            try {
              const formMain = new FormData(form);
              controller = new AbortController();
              const signal = controller.signal;
              const Request = await fetch(APIDOCS, {
                method: "POST",
                body: formMain,
              });

              if (Request.status === 200) {
                data = await Request.json();
                if (data) {
                  loaderBtn.innerText = data;
                }
              } else {
                console.log("invalid link directory");
              }
            } catch (error) {
              console.error(error);
            }
          }
          async function PHPREQUESTDEL(APIDOCS, validateKey) {
            let data;
            try {
              dn_message.querySelector("p").innerText = "...processing request";
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
                  dn_message.querySelector("p").innerText = data;
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }

          AddEventMenu_Btn.addEventListener("click", function () {
            var loaderBtn = AddEventMenu.querySelector(".loader");
            loaderBtn.classList.add("active");
            var formConditions = document.querySelectorAll(".form_condition");
            if (ConditionFeilds(formConditions) != false) {
              PHPREQUEST(APIDOCS, AddEventMenuForm, loaderBtn);
            }
          });
          AddEventMenu_off_Btn.addEventListener("click", function () {
            var loaderBtn = AddEventMenu_off.querySelector(".loader");
            loaderBtn.classList.add("active");
            var formConditions = document.querySelectorAll(".form_condition");
            if (ConditionFeilds(formConditions) != false) {
              PHPREQUEST(APIDOCS, AddEventMenu_offForm, loaderBtn);
            }
          });

          AddEventBtn.onclick = function () {
            if (ActivityMenu) {
              AddEventMenu.classList.add("active");
              APIDOCS =
                "../API/finance/data_process.php?APICALL=true&&user=true&&submit=upload";
            } else {
              AddEventMenu_off.classList.add("active");
              APIDOCS =
                "../API/finance/data_process.php?APICALL=true&&user=offertory&&submit=upload";
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
              !NavigationFilter.contains(target) &&
              !FilterOptionsFunList.contains(target)
            ) {
              if (FilterOptionsFunList.classList.contains("active")) {
                FilterOptionsFunList.classList.remove("active");
              }
            }
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
                    target.hasAttribute("Update_item") &&
                    element.contains(target)
                  ) {
                    UpdateItemFunction(target, ActivityMenu);
                  }
                  if (
                    target.hasAttribute("delete_item") &&
                    element.contains(target)
                  ) {
                    dn_message.classList.add("active");
                    ElementOptions.classList.remove("active");
                    validateKey = element
                      .querySelector(".opt_element p")
                      .getAttribute("Update_item");
                    console.log(element);
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
              document.querySelector(
                '.event_menu_add input[name="event"]'
              ).value = newObject["name"];
              document.querySelector(
                '.event_menu_add input[name="amount"]'
              ).value = newObject["amount"];
              document.querySelector(
                '.event_menu_add input[name="Date"]'
              ).value = newObject["date"];
              document.querySelector(
                '.event_menu_add textarea[name="description"]'
              ).value = newObject["purpose"];
              document.querySelector(
                '.event_menu_add input[name="delete_key"]'
              ).value = newObject["id"];
              AddEventMenu_off.classList.add("active");
              APIDOCS =
                "../API/finance/data_process.php?APICALL=true&&user=offertory&&submit=update";
            } else {
              APIDOCS =
                "../API/finance/data_process.php?APICALL=true&&user=true&&submit=update";
              AddEventMenu.querySelector(
                '.event_menu_add input[name="event"]'
              ).value = newObject["name"];

              AddEventMenu.querySelector(
                '.event_menu_add select[name="category"]'
              ).value = newObject["department"];
              AddEventMenu.querySelector(
                '.event_menu_add input[name="amount"]'
              ).value = newObject["amount"];
              AddEventMenu.querySelector(
                '.event_menu_add input[name="date"]'
              ).value = newObject["date"];
              AddEventMenu.querySelector(
                '.event_menu_add textarea[name="description"]'
              ).value = newObject["purpose"];
              AddEventMenu.querySelector(
                '.event_menu_add input[name="delete_key"]'
              ).value = newObject["id"];
              AddEventMenu.classList.add("active");
            }
          }
          function DeleteItemFunction(value) {
            if (value == "true") {
              if (ActivityMenu) {
                APIDOCS =
                  "../API/finance/data_process.php?APICALL=true&&user=true&&submit=delete";
              } else {
                APIDOCS =
                  "../API/finance/data_process.php?APICALL=true&&user=offertory&&submit=delete";
              }
              PHPREQUESTDEL(APIDOCS, validateKey);
            }
          }
        }
        if (location == "Transaction") {
          document.querySelector("li.expand").classList.add("active");
          let APIDOCS;
          APIDOCS =
            "../API/finance/data_process.php?APICALL=transaction&&user=true&&submit=upload";

          let validateKey;
          const loaderBtn = document.querySelector("form .loader");
          const AddEventMenu = document.querySelector(".event_menu_add");
          const AddEventMenuForm = document.querySelector("form");
          const List_filter = document.querySelector(".List_filter");
          const OptionElements = document.querySelectorAll(".delete.option");
          const filter_option = document.querySelectorAll(".filter_option");
          const AddEventMenu_Btn = document.querySelector(
            ".event_menu_add Button"
          );
          AddEventMenuForm.addEventListener("submit", function (e) {
            e.preventDefault();
          });
          filter_option.forEach((element) => {
            element.addEventListener("click", function () {
              filter_option.forEach((element_dr) => {
                if (element_dr != element) {
                  element_dr
                    .querySelector(".select")
                    .classList.remove("active");
                }
              });

              element.querySelector(".select").classList.add("active");
            });
          });
          document
            .querySelector('select[name="catfilter"]')
            .addEventListener("change", function (e) {
              let value = e.target.value;
              let parentVal = e.target.parentElement;
              let Cat = parentVal.querySelector("p");
              Cat.innerText = value;
            });
          document
            .querySelector('select[name="yearfilter"]')
            .addEventListener("change", function (e) {
              let value = e.target.value;
              let parentVal = e.target.parentElement;
              let Cat = parentVal.querySelector("p");
              Cat.innerText = value;
            });
          document
            .querySelector('select[name="accfilter"]')
            .addEventListener("change", function (e) {
              let value = e.target.value;
              let parentVal = e.target.parentElement;
              let Cat = parentVal.querySelector("p");
              Cat.innerText = value;
            });
          List_filter.addEventListener("click", function () {
            APIDOCS =
              "../API/finance/data_process.php?APICALL=transaction&&user=true&&submit=filter";
            PHPREQUESTFILTER(APIDOCS);
          });
          confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (validateKey != "") {
                  DeleteItemFunction(element.getAttribute("data-confirm"));
                }
              }
              setTimeout(() => {
                dn_message.classList.add("active");
                dn_message.classList.add("delete");
              }, 100);
            });
          });

          async function PHPREQUEST(APIDOCS) {
            let data;
            loaderBtn.innerText = " ";
            try {
              const formMain = new FormData(AddEventMenuForm);
              controller = new AbortController();
              const signal = controller.signal;
              const Request = await fetch(APIDOCS, {
                method: "POST",
                body: formMain,
              });

              if (Request.status === 200) {
                data = await Request.json();
                if (data) {
                  loaderBtn.classList.add("active");
                  loaderBtn.innerText = data;
                }
              } else {
                console.log("invalid link directory");
              }
            } catch (error) {
              console.error(error);
            }
          }
          async function PHPREQUESTDEL(APIDOCS, validateKey) {
            let data;
            try {
              dn_message.querySelector("p").innerText = "...processing request";
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
                  dn_message.querySelector("p").innerText = data;
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }
          async function PHPREQUESTFILTER(APIDOCS) {
            let data;
            let DomManipulationElement;
            if (ArrayTables.includes(location)) {
              DomManipulationElement = SkeletonDom_table;
            } else {
              DomManipulationElement = SkeletonDom_list;
            }
            try {
              dn_message.querySelector("p").innerText = "...processing request";
              dataSend = {
                category: document.querySelector('select[name="catfilter"]')
                  .value,
                year: document.querySelector('select[name="yearfilter"]').value,
                account: document.querySelector('select[name="accfilter"]')
                  .value,
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
                  loader_progress.classList.add("active");
                  ContentDom.classList.add("load");
                  DomManipulationElement.classList.add("load");
                  setTimeout(() => {
                    console.log(document.querySelector(".records_table"));
                    document.querySelector(".records_table tbody").innerHTML =
                      data;
                    loader_progress.classList.remove("active");
                    ContentDom.classList.remove("load");
                    DomManipulationElement.classList.remove("load");
                  }, 200);
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }
          AddEventMenu_Btn.onclick = function () {
            AddEventMenu.classList.add("active");
            var formCondiions = document.querySelectorAll(".form_condition");
            console.log(ConditionFeilds(formCondiions));
            if (ConditionFeilds(formCondiions) != false) {
              PHPREQUEST(APIDOCS);
            } else {
              loaderBtn.classList.add("active");
              loaderBtn.innerText = "All feilds are required";
            }
          };

          window.addEventListener("click", function (e) {
            var target = e.target;
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
                    target.hasAttribute("Update_item") &&
                    element.contains(target)
                  ) {
                    setTimeout(() => {
                      console.log("re");
                      UpdateItemFunction(target);
                    }, 200);
                  }
                  if (
                    target.hasAttribute("delete_item") &&
                    element.contains(target)
                  ) {
                    dn_message.classList.add("active");
                    ElementOptions.classList.remove("active");
                    validateKey = element
                      .querySelector(".opt_element p")
                      .getAttribute("Update_item");
                  }
                }
              }
            });
            filter_option.forEach((element) => {
              if (!element.contains(target)) {
                element.querySelector(".select").classList.remove("active");
              }
            });
          });

          function UpdateItemFunction(value) {
            newObject = value.getAttribute("data-information");
            newObject = JSON.parse(newObject);
            console.log(newObject["Date"]);
            document.querySelector(
              '.event_menu_add select[name="account"]'
            ).value = newObject["account"];
            document.querySelector(
              '.event_menu_add input[name="amount"]'
            ).value = newObject["amount"];
            document.querySelector(
              '.event_menu_add input[name="authorize"]'
            ).value = newObject["Authorize"];

            document.querySelector('.event_menu_add input[name="date"]').value =
              newObject["Date"];
            document.querySelector(
              '.event_menu_add select[name="status_information"]'
            ).value = newObject["Status"];
            document.querySelector(
              '.event_menu_add input[name="delete_key"]'
            ).value = newObject["id"];
            APIDOCS =
              "../API/finance/data_process.php?APICALL=transaction&&user=true&&submit=update";

            AddEventMenu.classList.add("active");
          }
          function DeleteItemFunction(value) {
            if (value == "true") {
              APIDOCS =
                "../API/finance/data_process.php?APICALL=transaction&&user=true&&submit=delete";
              PHPREQUESTDEL(APIDOCS, validateKey);
            }
          }
        }
        if (location == "Expenses") {
          let APIDOCS;
          APIDOCS =
            "../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=upload";

          let validateKey;
          const loaderBtn = document.querySelector("form .loader");
          const AddEventMenu = document.querySelector(".event_menu_add");
          const AddEventMenuForm = document.querySelector("form");
          const OptionElements = document.querySelectorAll(".delete.option ");
          const filter_option = document.querySelectorAll(".filter_option");
          const List_filter = document.querySelector(".List_filter");
          filter_option.forEach((element) => {
            element.addEventListener("click", function () {
              filter_option.forEach((element_dr) => {
                if (element_dr != element) {
                  element_dr
                    .querySelector(".select")
                    .classList.remove("active");
                }
              });

              element.querySelector(".select").classList.add("active");
            });
          });

          document
            .querySelector('select[name="catfilter"]')
            .addEventListener("change", function (e) {
              let value = e.target.value;
              let parentVal = e.target.parentElement;
              let Cat = parentVal.querySelector("p");
              Cat.innerText = value;
            });
          document
            .querySelector('select[name="yearfilter"]')
            .addEventListener("change", function (e) {
              let value = e.target.value;
              let parentVal = e.target.parentElement;
              let Cat = parentVal.querySelector("p");
              Cat.innerText = value;
            });

          const AddEventMenu_Btn = document.querySelector(
            ".event_menu_add Button"
          );

          List_filter.addEventListener("click", function () {
            APIDOCS =
              "../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=filter";
            PHPREQUESTFILTER(APIDOCS);
          });

          AddEventMenuForm.addEventListener("submit", function (e) {
            e.preventDefault();
          });
          confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (validateKey != "") {
                  DeleteItemFunction(element.getAttribute("data-confirm"));
                }
                setTimeout(() => {
                  dn_message.classList.add("active");
                  dn_message.classList.add("delete");
                }, 100);
              } else {
                dn_message.classList.remove("active");
                dn_message.classList.remove("delete");
              }
            });
          });
          async function PHPREQUESTFILTER(APIDOCS) {
            let data;
            let DomManipulationElement;
            if (ArrayTables.includes(location)) {
              DomManipulationElement = SkeletonDom_table;
            } else {
              DomManipulationElement = SkeletonDom_list;
            }
            try {
              dn_message.querySelector("p").innerText = "...processing request";
              dataSend = {
                category: document.querySelector('select[name="catfilter"]')
                  .value,
                year: document.querySelector('select[name="yearfilter"]').value,
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
                  loader_progress.classList.add("active");
                  ContentDom.classList.add("load");
                  DomManipulationElement.classList.add("load");
                  setTimeout(() => {
                    console.log(
                      document.querySelector(".records_table  tbody").innerHTML
                    );
                    document.querySelector(".records_table  tbody").innerHTML =
                      data;
                    loader_progress.classList.remove("active");
                    ContentDom.classList.remove("load");
                    DomManipulationElement.classList.remove("load");
                  }, 200);
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }

          async function PHPREQUEST(APIDOCS) {
            let data;
            loaderBtn.innerText = " ";
            try {
              const formMain = new FormData(AddEventMenuForm);
              controller = new AbortController();
              const signal = controller.signal;
              const Request = await fetch(APIDOCS, {
                method: "POST",
                body: formMain,
              });

              if (Request.status === 200) {
                data = await Request.json();
                if (data) {
                  loaderBtn.classList.add("active");
                  loaderBtn.innerText = data;
                }
              } else {
                console.log("invalid link directory");
              }
            } catch (error) {
              console.error(error);
            }
          }
          async function PHPREQUESTDEL(APIDOCS, validateKey) {
            let data;
            try {
              dn_message.querySelector("p").innerText = "...processing request";
              dataSend = {
                key: validateKey,
                date: document.querySelector(
                  '.event_menu_add input[name="Date"]'
                ).value,
              };
              console.log(validateKey);
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
                  dn_message.querySelector("p").innerText = data;
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }
          AddEventMenu_Btn.onclick = function () {
            AddEventMenu.classList.add("active");
            PHPREQUEST(APIDOCS);
          };

          function UpdateItemFunction(value) {
            const AddEventMenu = document.querySelector(".event_menu_add");
            newObject = value.getAttribute("data-information");
            newObject = JSON.parse(newObject);

            document.querySelector(
              '.event_menu_add select[name="category"]'
            ).value = newObject["category"];
            document.querySelector(
              '.event_menu_add input[name="Amount"]'
            ).value = newObject["amount"];

            document.querySelector('.event_menu_add input[name="Date"]').value =
              newObject["date"];
            document.querySelector(
              '.event_menu_add select[name="type"]'
            ).value = newObject["type"];
            document.querySelector(
              '.event_menu_add textarea[name="details"]'
            ).value = newObject["details"];
            document.querySelector(
              '.event_menu_add input[name="delete_key"]'
            ).value = newObject["id"];
            AddEventMenu.classList.add("active");
            APIDOCS =
              "../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=update";
          }
          function DeleteItemFunction(value) {
            if (value == "true") {
              APIDOCS =
                "../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=delete";
              PHPREQUESTDEL(APIDOCS, validateKey);
            }
          }

          window.addEventListener("click", function (e) {
            var target = e.target;

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
                    target.hasAttribute("Update_item") &&
                    element.contains(target)
                  ) {
                    setTimeout(() => {
                      UpdateItemFunction(target);
                    }, 200);
                  }
                  if (
                    target.hasAttribute("delete_item") &&
                    element.contains(target)
                  ) {
                    dn_message.classList.add("active");
                    ElementOptions.classList.remove("active");
                    validateKey = element
                      .querySelector(".opt_element p")
                      .getAttribute("delete_item");
                  }
                }
              }
            });

            filter_option.forEach((element) => {
              if (!element.contains(target)) {
                element.querySelector(".select").classList.remove("active");
              }
            });
          });
        }
        if (location == "records") {
          const AddEventBtn_far = document.querySelector(".add_event.far");
          const FilterBtn = document.querySelector(".filterBtn");
          const RecordsDivs = document.querySelectorAll(".annc_item");
          var OptionElements = document.querySelectorAll("i.delete_item");
          const AddEventBtn = document.querySelector(".add_event");
          const AddEventMenu = document.querySelector(".event_menu_add");
          const notifyBox = document.querySelector(".notifyBox");
          AddEventBtn.addEventListener("click", function (e) {
            APIDOCS =
              "../API/sundayRecords/data_process.php?APICALL=true&&user=true&&submit=true";
            AddEventMenu.classList.add("active");
          });

          window.addEventListener("click", function (e) {
            var target = e.target;
            var FilterUI = document.querySelector(".notification_list_filter");
            if (
              AddEventMenu.classList.contains("active") &&
              !AddEventBtn.contains(target)
            ) {
              if (!AddEventMenu.contains(target)) {
                AddEventMenu.classList.remove("active");
              }
            }

            if (!notifyBox.contains(target)) {
              if (notifyBox.classList.contains("active")) {
                notifyBox.classList.remove("active");
              }
            }
            if (!FilterBtn.contains(target) && !FilterUI.contains(target)) {
              if (FilterUI.classList.contains("active")) {
                FilterUI.classList.remove("active");
              }
            } else {
              FilterUI.classList.add("active");
            }

            OptionElements.forEach((element) => {});
          });
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
                element
                  .querySelector(".Activity_record")
                  .classList.toggle("edit");
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
              newClone
                .querySelector(".Activity_record")
                .classList.toggle("edit");
              EventUpdateButton.parentElement.classList.toggle("active");
            });
            Div.append(newClone);
            document.querySelector(".ancc_list").prepend(Div);
          });
          confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (validateKey != "") {
                  DeleteItemFunction(element.getAttribute("data-confirm"));
                }
              }
              setTimeout(() => {
                dn_message.classList.add("active");
                dn_message.classList.add("delete");
              }, 100);
            });
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
          function DeleteItemFunction(value, validateKey, MainForm) {
            if (value == "true" && validateKey) {
              let API =
                "../API/SundayRecords/data_process.php?APICALL=true&&user=true&&submit=delete";
              PHPREQUESTDEL(API, validateKey, MainForm);
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
                    document.querySelector(
                      ".content_main table tbody"
                    ).innerHTML = values;
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
                      notifyBox.classList.add("active");
                      notifyBox.querySelector("p").innerText = data["message"];
                    }
                  }
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }

          async function PHPREQUESTDEL(APIDOCS, validateKey, MainForm) {
            let data;

            try {
              console.log(MainForm);
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
                  if ((data["message"] = "Item Deleted Successfully")) {
                    notifyBox.classList.add("active");
                    notifyBox.querySelector("p").innerText = data["message"];
                    MainForm.classList.add("none");
                    dn_message.classList.remove("active");
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
          let APIDOCS;
          APIDOCS =
            "../API/finance/data_process.php?APICALL=tithe&&user=true&&submit=upload";

          let validateKey;
          const loaderBtn = document.querySelector("form .loader");
          const AddEventMenu = document.querySelector(".event_menu_add");
          const AddEventMenuForm = document.querySelector("form");
          const filter_option = document.querySelectorAll(".filter_option");
          const AddEventMenu_Btn = document.querySelector(
            ".event_menu_add Button"
          );
          AddEventMenuForm.addEventListener("submit", function (e) {
            e.preventDefault();
          });
          confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (validateKey != "") {
                  DeleteItemFunction(element.getAttribute("data-confirm"));
                }
                setTimeout(() => {
                  dn_message.classList.add("active");
                  dn_message.classList.add("delete");
                }, 100);
              } else {
                dn_message.classList.remove("active");
                dn_message.classList.remove("delete");
              }
            });
          });
          async function PHPREQUEST(APIDOCS) {
            let data;
            loaderBtn.innerText = " ";
            try {
              const formMain = new FormData(AddEventMenuForm);
              controller = new AbortController();
              const signal = controller.signal;
              const Request = await fetch(APIDOCS, {
                method: "POST",
                body: formMain,
              });

              if (Request.status === 200) {
                data = await Request.json();
                if (data) {
                  loaderBtn.classList.add("active");
                  loaderBtn.innerText = data;
                }
              } else {
                console.log("invalid link directory");
              }
            } catch (error) {
              console.error(error);
            }
          }
          async function PHPREQUESTDEL(APIDOCS, validateKey) {
            let data;
            try {
              dn_message.querySelector("p").innerText = "...processing request";
              dataSend = {
                key: validateKey,
                date: document.querySelector(
                  '.event_menu_add input[name="Date"]'
                ).value,
              };
              console.log(validateKey);
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
                  dn_message.querySelector("p").innerText = data;
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }
          AddEventMenu_Btn.onclick = function () {
            AddEventMenu.classList.add("active");
            var formCondiions = document.querySelectorAll(".form_condition");
            console.log(ConditionFeilds(formCondiions));
            if (ConditionFeilds(formCondiions) != false) {
              PHPREQUEST(APIDOCS);
            } else {
              loaderBtn.classList.add("active");
              loaderBtn.innerText = "All feilds are required";
            }
          };
          const FilterBtn = document.querySelector(".filterBtn");
          window.addEventListener("click", function (e) {
            var target = e.target;
            var FilterUI = document.querySelector(".notification_list_filter");
            if (!FilterBtn.contains(target) && !FilterUI.contains(target)) {
              if (FilterUI.classList.contains("active")) {
                FilterUI.classList.remove("active");
              }
            } else {
              FilterUI.classList.add("active");
            }
          });

          function UpdateItemFunction(value) {
            const AddEventMenu = document.querySelector(".event_menu_add");
            newObject = value.getAttribute("data-information");
            newObject = JSON.parse(newObject);

            document.querySelector(
              '.event_menu_add select[name="Name"]'
            ).value = newObject["Name"];
            document.querySelector(
              '.event_menu_add input[name="amount"]'
            ).value = newObject["Amount"];
            document.querySelector(
              '.event_menu_add input[name="medium"]'
            ).value = newObject["medium"];
            document.querySelector(
              '.event_menu_add textarea[name="details"]'
            ).value = newObject["details"];

            document.querySelector('.event_menu_add input[name="Date"]').value =
              newObject["Date"];
            document.querySelector(
              '.event_menu_add input[name="delete_key"]'
            ).value = newObject["id"];
            APIDOCS =
              "../API/finance/data_process.php?APICALL=tithe&&user=true&&submit=update";
            AddEventMenu.classList.add("active");
          }
          function DeleteItemFunction(value) {
            if (value == "true") {
              APIDOCS =
                "../API/finance/data_process.php?APICALL=tithe&&user=true&&submit=delete";
              PHPREQUESTDEL(APIDOCS, validateKey);
            }
          }

          window.addEventListener("click", function (e) {
            var target = e.target;

            filter_option.forEach((element) => {
              if (!element.contains(target)) {
                element.querySelector(".select").classList.remove("active");
              }
            });
          });
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
          const FilterBtn = document.querySelector(".filterBtn");
          window.addEventListener("click", function (e) {
            var target = e.target;
            var FilterUI = document.querySelector(".notification_list_filter");
            if (!FilterBtn.contains(target) && !FilterUI.contains(target)) {
              if (FilterUI.classList.contains("active")) {
                FilterUI.classList.remove("active");
              }
            } else {
              FilterUI.classList.add("active");
            }
          });

          confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
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
            document.querySelector(
              '.event_menu_add input[name="source"]'
            ).value = newObject["source"];
            document.querySelector(
              '.event_menu_add input[name="location"]'
            ).value = newObject["location"];
            document.querySelector('.event_menu_add input[name="date"]').value =
              newObject["date"];
            document.querySelector(
              '.event_menu_add select[name="status"]'
            ).value = newObject["status"];
            document.querySelector(
              '.event_menu_add input[name="value"]'
            ).value = newObject["value"];
            document.querySelector(
              '.event_menu_add input[name="total"]'
            ).value = newObject["total"];
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
        if (location == "records") {
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
                  MainForm = target.parentElement.parentElement.parentElement;
                  formData =
                    target.parentElement.parentElement.parentElement.querySelector(
                      "form"
                    );

                  if (formData.hasAttribute("form-id")) {
                    validateKey = formData.getAttribute("form-id");
                  }
                  if (validateKey != "") {
                    DeleteItemFunction(
                      element.getAttribute("data-confirm"),
                      validateKey,
                      MainForm
                    );
                  }
                }
              });
            });
          });
        }
        if (location == "Announcement") {
          let APIDOCS;
          let Change_status = false;
          const AddEventBtn = document.querySelector(".add_event");
          const toggleModes = document.querySelectorAll(".toggle_mode");
          const SubmitForm = document.querySelector(".event_menu_add form");
          const ResponseView = document.querySelector(".error_information");
          const AddEventMenu = document.querySelector(".event_menu_add");
          AddEventBtn.addEventListener("click", function (e) {
            APIDOCS =
              "../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=true";
            AddEventMenu.classList.add("active");
          });
          window.addEventListener("click", function (e) {
            var target = e.target;
            if (
              AddEventMenu.classList.contains("active") &&
              !AddEventBtn.contains(target)
            ) {
              if (!AddEventMenu.contains(target)) {
                AddEventMenu.classList.remove("active");
              }
            }

            if (target.classList.contains("Update_item")) {
              UpdateItemFunction(target);
            }
            if (target.classList.contains("delete_item")) {
              dn_message.classList.add("active");
              console.log(target);
              if (target.hasAttribute("data-id")) {
                validateKey = target.getAttribute("data-id");
              }
            }
          });

          confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (validateKey != "") {
                  DeleteItemFunction(
                    element.getAttribute("data-confirm"),
                    validateKey
                  );
                }
              }
            });
          });

          toggleModes.forEach((element) => {
            element.addEventListener("click", function () {
              if (element.classList.contains("active")) {
                Change_status = true;
              } else {
                Change_status = false;
              }
              if (Change_status == false) {
                Change_status = true;
              } else {
                Change_status = false;
              }
              Id = "";
              if (element.hasAttribute("data-id")) {
                Id = element.getAttribute("data-id");
              }

              if (Id != "") {
                console.log(Change_status);
                APIDOCS =
                  "../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=status";
                if (PHPREQUESTSTATUS(APIDOCS, Change_status, Id)) {
                  element.classList.toggle("active");
                } else {
                  alert("Sorry, an error occured activation the announcement");
                }
              }
            });
          });
          function UpdateItemFunction(value) {
            const AddEventMenu = document.querySelector(".event_menu_add");
            newObject = value.getAttribute("data-information");
            console.log(typeof newObject);
            newObject = JSON.parse(newObject);

            document.querySelector('.event_menu_add input[name="name"]').value =
              newObject["title"];
            document.querySelector(
              '.event_menu_add textarea[name="message"]'
            ).value = newObject["message"];
            document.querySelector(
              '.event_menu_add input[name="delete_key"]'
            ).value = newObject["id"];
            document.querySelector(
              '.event_menu_add input[name="receiver"]'
            ).value = newObject["receiver"];
            document.querySelector('.event_menu_add input[name="date"]').value =
              newObject["date"];

            AddEventMenu.classList.add("active");
            APIDOCS =
              "../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=upload";
          }
          function DeleteItemFunction(value, validateKey) {
            console.log(value, validateKey);
            if (value == "true") {
              let API =
                "../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=delete_file";
              PHPREQUESTDEL(API, validateKey);
            }
          }
          async function PHPREQUEST(APIDOCS) {
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
                  ResponseView.innerText = data["result"];
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }

          async function PHPREQUESTSTATUS(APIDOCS, key, Id) {
            let data;

            try {
              dataSend = {
                key_Data: key,
                IdData: Id,
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
                  if (data["result"] == "Item changed Successfully") {
                    console.log(data["result"]);
                    return true;
                  } else {
                    return false;
                  }
                }
              } else {
                return "cannot find endpoint";
              }
            } catch (error) {
              return error;
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
                  alert(data["result"]);
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
        if (location == "projects") {
          let APIDOCS;
          const AddEventBtn = document.querySelector(".add_event");
          const SubmitForm = document.querySelector(".event_menu_add form");
          const ResponseView = document.querySelector(".error_information");
          const imageCompound = document.querySelector(
            '.event_menu_add input[name="imageFile"]'
          );
          const FilterBtn = document.querySelector(".filterBtn");
          window.addEventListener("click", function (e) {
            var target = e.target;
            var FilterUI = document.querySelector(".notification_list_filter");
            if (!FilterBtn.contains(target) && !FilterUI.contains(target)) {
              if (FilterUI.classList.contains("active")) {
                FilterUI.classList.remove("active");
              }
            } else {
              FilterUI.classList.add("active");
            }
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
            document.querySelector(
              '.event_menu_add input[name="target"]'
            ).value = newObject["target"];
            document.querySelector(
              '.event_menu_add input[name="current"]'
            ).value = newObject["current"];
            document.querySelector('.event_menu_add input[name="date"]').value =
              newObject["Start"];
            document.querySelector(
              '.event_menu_add select[name="status"]'
            ).value = newObject["Status"];

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
          const FilterBtn = document.querySelector(".filterBtn");
          window.addEventListener("click", function (e) {
            var target = e.target;
            var FilterUI = document.querySelector(".notification_list_filter");
            if (!FilterBtn.contains(target) && !FilterUI.contains(target)) {
              if (FilterUI.classList.contains("active")) {
                FilterUI.classList.remove("active");
              }
            } else {
              FilterUI.classList.add("active");
            }
          });

          let APIDOCS;
          let confirmKey = true;
          const AddEventBtn = document.querySelector(".add_event");
          const SubmitForm = document.querySelector(
            ".event_menu_add.main form"
          );
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
            document.querySelector(
              '.event_menu_add input[name="amount"]'
            ).value = newObject["partnership"];
            document.querySelector(
              '.event_menu_add select[name="type"]'
            ).value = newObject["Type"];
            document.querySelector(
              '.event_menu_add input[name="email"]'
            ).value = newObject["Email"];
            document.querySelector(
              '.event_menu_add input[name="period"]'
            ).value = newObject["Period"];
            document.querySelector(
              '.event_menu_add select[name="status"]'
            ).value = newObject["status"];
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
                    document.querySelector(
                      ".content_main table tbody"
                    ).innerHTML = values;
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
          const FilterBtn = document.querySelector(".filterBtn");
          window.addEventListener("click", function (e) {
            var target = e.target;
            var FilterUI = document.querySelector(".notification_list_filter");
            if (!FilterBtn.contains(target) && !FilterUI.contains(target)) {
              if (FilterUI.classList.contains("active")) {
                FilterUI.classList.remove("active");
              }
            } else {
              FilterUI.classList.add("active");
            }
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

            document.querySelector(
              '.event_menu_add input[name="members"]'
            ).value = newObject["members"];

            document.querySelector(
              '.event_menu_add input[name="manager"]'
            ).value = newObject["manager"];

            document.querySelector(
              '.event_menu_add select[name="status"]'
            ).value = newObject["status"];

            document.querySelector(
              '.event_menu_add input[name="members"]'
            ).value = newObject["members"];

            document.querySelector('.event_menu_add input[name="date"]').value =
              newObject["date"];

            document.querySelector(
              '.event_menu_add textarea[name="about"]'
            ).value = newObject["about"];
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
        if (location == "Budget") {
          const FilterBtn = document.querySelector(".filterBtn");
          window.addEventListener("click", function (e) {
            var target = e.target;
            var FilterUI = document.querySelector(".notification_list_filter");
            if (!FilterBtn.contains(target) && !FilterUI.contains(target)) {
              if (FilterUI.classList.contains("active")) {
                FilterUI.classList.remove("active");
              }
            } else {
              FilterUI.classList.add("active");
            }
          });
        }
        if (location == "Membership") {
          let APIDOCS;
          const AddEventBtn = document.querySelector(".add_event");
          const SubmitForm = document.querySelector(".event_menu_add form");
          const SubmitSearchForm = document.querySelector("#searchInput");
          const SubmitSearchbutton = document.querySelector("#searchBtn");
          const ResponseView = document.querySelector(".error_information");
          const FilterBtn = document.querySelector(".filterBtn");
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

            document.querySelector(
              '.event_menu_add input[name="Oname"]'
            ).value = newObject["Oname"];
            document.querySelector(
              '.event_menu_add input[name="Fname"]'
            ).value = newObject["Fname"];
            document.querySelector(
              '.event_menu_add input[name="birth"]'
            ).value = newObject["birth"];
            document.querySelector(
              '.event_menu_add input[name="occupation"]'
            ).value = newObject["occupation"];
            document.querySelector(
              '.event_menu_add input[name="gender"]'
            ).value = newObject["gender"];
            document.querySelector(
              '.event_menu_add input[name="contact"]'
            ).value = newObject["contact"];
            document.querySelector(
              '.event_menu_add input[name="location"]'
            ).value = newObject["location"];
            document.querySelector(
              '.event_menu_add input[name="baptism"]'
            ).value = newObject["Baptism"];
            document.querySelector(
              '.event_menu_add select[name="status"]'
            ).value = newObject["status"];
            document.querySelector(
              '.event_menu_add input[name="position"]'
            ).value = newObject["Position"];
            document.querySelector(
              '.event_menu_add input[name="birth"]'
            ).value = newObject["birth"];
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

          window.addEventListener("click", function (e) {
            var target = e.target;
            var FilterUI = document.querySelector(".notification_list_filter");
            if (!FilterBtn.contains(target) && !FilterUI.contains(target)) {
              if (FilterUI.classList.contains("active")) {
                FilterUI.classList.remove("active");
              }
            } else {
              FilterUI.classList.add("active");
            }
          });
        }
      }
    } catch (error) {
      console.error(error);
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
    locationHandler(route.template, location)
      .then((data) => {
        loader_progress.classList.remove("active");
        DomManipulationElement.classList.remove("load");
        ContentDom.classList.remove("load");
        setTimeout(() => {
          ProgressLoader(false);
        }, 100);
      })
      .catch((error) => {
        console.log(error);
        loader_progress.classList.remove("active");
        DomManipulationElement.classList.remove("load");
        ContentDom.classList.remove("load");
      });
  }
  function ConditionFeilds(arrayArg) {
    clearance = true;
    arrayArg.forEach((element) => {
      if (
        element.value == "" ||
        element.value == " " ||
        element.value == null
      ) {
        clearance = false;
      }
    });

    return clearance;
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
  AsideList.forEach((element) => {
    element.addEventListener("click", function (e) {
      element.classList.add("active");
      AsideList.forEach((items) => {
        if (items != element) {
          items.classList.remove("active");
        }
      });
    });
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
    var SearchUl = document.querySelector(".ux_search_bar");
    var NotifyUl = document.querySelector(".notification_list");
    if (!Search_notify.contains(target) && !NotifyUl.contains(target)) {
      if (NotifyUl.classList.contains("active")) {
        NotifyUl.classList.remove("active");
      }
    } else {
      NotifyUl.classList.add("active");
    }

    if (!SearchBar.contains(target) && !SearchUl.contains(target)) {
      if (SearchUl.classList.contains("active")) {
        SearchUl.classList.remove("active");
      }
    } else {
      SearchUl.classList.add("active");
    }
  });
});
