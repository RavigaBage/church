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
  const NavigationBar = document.querySelector(".navigation_content");
  const searchInput = document.querySelector("#searchInput");
  const searchBtn = document.querySelector("#searchBtn");
  let SearchTrigger = false;
  let DomManipulationElement;
  let validateKey;
  let ConvertPages = 0;
  let numoffset = 0;
  let currentPageNum = 1;
  var location;
  searchBtn.addEventListener("click", function () {

    if (ArrayTables.includes(location)) {
      DomManipulationElement = SkeletonDom_table;
    } else {
      DomManipulationElement = SkeletonDom_list;
    }
    SearchTrigger = true;
  })

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
    if (html) {
      document.querySelector(".content_main").innerHTML = html;
    }

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
                    console.log(typeof data.result);
                    console.log(data.result == "success");
                    if (data.result == "success") {
                      var timerSet = document.querySelector(".token");
                      var TokenHeader = document.querySelector(
                        ".access_token header"
                      );
                      timerSet.classList.add("active");
                      TokenHeader.innerText = `Security Code has been activated code - ${document.querySelector(".tokenData div").innerText
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
          let validateKey = "";
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
          const YearButton = document.querySelector(".year button");
          const MonthSelectorElement = document.querySelector(".month_selector");
          const HeaderSelector = document.querySelectorAll("strong[data-id]");
          const MenuData = document.querySelector(".menu_date header");
          const DayInfo = document.querySelector(".day_info");
          let currentSpan = "";
          let ActiveTime = 0;
          let DateFetch = new Date();
          let year = DateFetch.getFullYear();
          let month = DateFetch.getMonth();
          let Current = DateFetch.getDate();
          let Current_Day = DateFetch.getDay();
          let monthNew = 0;
          let monthOld = 0;
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
          let tempMonth = false;
          let tempYear = false;
          let lastChecker = "";
          let firstVal = "";
          let workingMonth = DateFetch.getMonth();
          let stringData = "upload";
          let filterStatus = false;
          GridCells = [
            "gridrowO",
            "gridrowT",
            "gridrowTH",
            "gridrowF",
            "gridrowFI",
            "gridrowS",
            "gridrowSE",
          ];
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
          let WorkingMax = DaysOfMonth[workingMonth];
          let DaysLater = ["Sun", "Mon", "Tue", "Wed", "Thurs", "Fri", "Sat"];
          CurrentDay.querySelector("header").innerText = Current;
          CurrentDay.querySelector("p"
          ).innerText = `${DaysLater[Current_Day]} , ${Current} ${monthNames[month]} , ${year} `;
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
              if (
                document.querySelector(".month_selector .year header") != null
              ) {
                document.querySelector(
                  ".month_selector .year header"
                ).innerText = element.innerHTML;

                YearListElem.classList.remove("active");
                if (!isNaN(element.innerHTML)) {
                  FilterYear = parseInt(element.innerHTML);
                }
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
              if (!isNaN(element.getAttribute("data_id"))) {
                FilterMonth = parseInt(element.getAttribute("data_id"));
              }
            });
          });
          const FilterBtn = document.querySelector(
            ".month_selector .year button"
          );
          FilterBtn.addEventListener("click", function () {
            MenuData.innerHTML = `${monthNames[FilterMonth]} ${FilterYear}`;
            workingMonth = FilterMonth;
            year = FilterYear;
            tempMonth = false;
            tempYear = false;
            monthOld = 0;
            monthNew = 0;
            filterStatus = true;
            try {
              calender.calender(FilterMonth, FilterYear, 1, "wor;d");
              getWeeks(FilterMonth, FilterYear, 1);
            } catch (error) {
              console.log(error);
            }
          });
          MenuArrowLeft.addEventListener("click", function () {
            getPrevWeek(year, workingMonth, firstVal);
            changeTabMenu("WeekTab");
          });
          MenuArrowRight.addEventListener("click", function () {
            getNextWeek(year, workingMonth, last);
            changeTabMenu("WeekTab");
          });
          YearButton.addEventListener("click", function () {
            MonthSelectorElement.classList.remove("active");
          });
          MenuDate.addEventListener("click", function () {
            MonthSelectorElement.classList.add("active");
          });
          MonthSelector.forEach((element) => {
            if (element.hasAttribute("data-icu")) {
              element.addEventListener("click", function () {
                try {
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
                } catch (error) { }
              });
            }
          });
          DaySelector.forEach((element) => {
            if (element.hasAttribute("data-icu")) {
              element.addEventListener("click", function () {
                try {
                  Calender = document.querySelector(".min_calenda");
                  CurrentData = element.querySelector("span").innerText;
                  Year = Calender.getAttribute("data-year");
                  Month = Calender.getAttribute("data-month");
                  document.querySelector("#dayTab").classList.add("active");
                  DayInformation(Year, Month, CurrentData);
                } catch (error) { }
              });
            }
          });
          calender.calender(month, year, Current);
          function ResizeElement(val, origin) {
            try {
              weight = 40;
              StartTimeElement = functionSelector.innerHTML;
              SplitInspection = StartTimeElement.split(":");
              console.log(SplitInspection);
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
            } catch (error) {
              console.log(error);
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
          async function weekDataSet(stringData) {
            element = currentSpan;
            const OldParent = element.parentElement;
            try {
              const Notice = await PHPREQUEST(stringData);
              const ErrorElement = AddMenu.querySelector('.error');
              ErrorElement.innerHTML = `<p class="danger" style="text-align:center;">loading... ... ...</p>`;
              if (Notice == "success") {
                if (stringData != 'update') {
                  const NewParent = document.createElement("div");
                  NewParent.setAttribute("class", "event_record");
                  const CloneItem = element.cloneNode(true);
                  NewParent.classList.add("Owel" + String(Time_position));
                  NewParent.classList.add("active");
                  if (CloneItem.classList.contains("min")) {
                    NewParent.classList.add("min");
                  }
                  CloneItem.innerHTML = `<p class="element_main_data">${document.querySelector('input[name="EventName"]').value
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
                }
              }
              ErrorElement.innerHTML = `<p class="danger" style="text-align:center;">${Notice}</p>`;
            } catch (error) {
              alert("An error occurred pls start the process again");
            }
            currentSpan = 0;
          }


          SaveDetails.addEventListener("click", function () {
            const FormScroll = document.querySelector('.new_event_menu .main');
            FormScroll.scrollTo({
              top: 0,
              behavior: 'smooth'
            })
            weekDataSet(stringData);

            if (currentSpan) {
              currentSpan = 0;
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
            if (currentSpan != 0 || currentSpan) {
              currentSpan = 0;
            }
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
            monthNew = month;
            MaxDaysMonth = DaysOfMonth[month];
            start = 0;
            m = 1;
            if (day == 1) {
              TotalLoop = 7 - value;
              PrevMonth = 0;
              if (month == 0) {
                PrevMonth = 11;
              } else {
                PrevMonth = month - 1;
              }

              for (let i = 0; i < value; i++) {
                weekObj.push(DaysOfMonth[PrevMonth] - ((value - 1) - i));
                monthOld = PrevMonth;
              }
              for (let i = 0; i < TotalLoop; i++) {
                weekObj.push(day + i);
              }
              DisplayWeekResult(weekObj);
            } else {

              if (value == 0) {
                weekObj.push(day);
                for (let i = 1; i < 7; i++) {
                  figure = day + i;
                  if (figure <= MaxDaysMonth) {
                    weekObj.push(figure);
                    lastChecker = figure;
                  } else {
                    let new_figure = m;
                    weekObj.push(new_figure);
                    m++;
                  }

                }
              } else if (value == 6) {
                for (let i = 0; i < 7; i++) {
                  figure = day - i;
                  if (figure > 0) {
                    weekObj.push(figure);
                    lastChecker = figure;
                  } else {
                    prevMonth = DaysOfMonth[month - 1];
                    let new_figure = prevMonth - start;
                    weekObj.push(new_figure);
                    lastChecker = new_figure;
                    start++;
                    monthOld = month - 1;
                  }

                }
                weekObj.reverse();
              } else {
                CalculateVal = 7 - value;
                ConVal = CalculateVal + 1;
                t_total = value + 1;
                for (let i = 1; i < t_total; i++) {
                  figure = day - (t_total - i);
                  if (figure <= 0) {
                    prevMonth = DaysOfMonth[month - 1];

                    let new_figure = prevMonth - (ConVal - start);
                    weekObj.push(new_figure);
                    lastChecker = new_figure;
                    start++;
                    monthOld = month - 1;
                  } else {
                    weekObj.push(figure);
                    lastChecker = figure;
                  }
                }
                weekObj.push(day);
                for (let i = 1; i < CalculateVal; i++) {
                  figure = day + i;
                  console.log(figure, MaxDaysMonth);
                  if (figure <= MaxDaysMonth) {
                    weekObj.push(figure);
                    lastChecker = figure;
                  } else {
                    let new_figure = m;
                    weekObj.push(new_figure);
                    m++;
                  }

                }
              }

              last = weekObj[weekObj.length - 1];
              firstVal = weekObj[0];
              if (weekObj.includes(day)) {
                if (parseInt(weekObj) == 1) {
                  weekObj = [];
                  if (workingMonth == 0) {
                    PrevMonth = DaysOfMonth[11];
                  } else {
                    PrevMonth = DaysOfMonth[workingMonth - 1];
                  }
                  MonthFirstDay = TrialDate.getDay();
                  currentNum = 1;

                  for (let i = 0; i < 7; i++) {
                    if (MonthFirstDay == 0) {
                      weekObj.push(PrevMonth);
                      MonthFirstDay = null;
                    } else if (MonthFirstDay > 0) {
                      weekObj.push(PrevMonth - MonthFirstDay);
                      MonthFirstDay--;
                      lastChecker = PrevMonth - MonthFirstDay;
                      last = PrevMonth - MonthFirstDay;
                    } else {
                      weekObj.push(currentNum);
                      last = currentNum;
                      currentNum++;
                    }
                  }
                }
                console.log(weekObj);
                DisplayWeekResult(weekObj);
              } else {
                weekObj = [];
                getWeeks(month, year, day);
              }
            }
            weekObj = [];
          }
          function getNextWeek(year_t, month_t, day) {
            WorkingMax = DaysOfMonth[workingMonth];
            m = 1;
            for (let i = 1; i < 8; i++) {
              figure = day + i;
              if (figure <= WorkingMax) {
                weekObj.push(figure);
                lastChecker = figure;
              } else {
                let new_figure = m;
                weekObj.push(new_figure);
                m++;
              }
            }
            last = weekObj[weekObj.length - 1];
            firstVal = weekObj[0];
            lastChecker = weekObj[weekObj.length - 1];
            DisplayWeekResult(weekObj, true);
            weekObj = [];
          }
          function getPrevWeek(year_t, month_t, day) {
            if (workingMonth == 0) {
              WorkingMax = DaysOfMonth[11];
            } else {
              WorkingMax = DaysOfMonth[workingMonth - 1];
            }
            m = 0;
            tempChange = 0;
            for (let i = 1; i < 8; i++) {
              figure = day - i;
              if (figure > 0) {
                weekObj.push(figure);
                lastChecker = figure;
              } else {
                monthOld = workingMonth;
                if (figure == 0) {
                  if (workingMonth == 0) {
                    tempChange = 0;
                  } else {
                    tempChange = workingMonth - 1;
                  }
                  monthNew = tempChange;
                }
                let new_figure = DaysOfMonth[tempChange] - m;
                weekObj.push(new_figure);
                m++;
                console.log(tempChange, weekObj, DaysOfMonth[tempChange])
              }

            }
            weekObj.reverse();
            last = weekObj[weekObj.length - 1];
            firstVal = weekObj[0];
            lastChecker = weekObj[weekObj.length - 1];

            DisplayWeekResult(weekObj, false);
            weekObj = [];
          }
          function DisplayWeekResult(weekObj, direction) {
            last = weekObj[weekObj.length - 1];
            firstVal = weekObj[0];

            if (monthOld != 0) {
              if (!filterStatus) {
                if (monthOld != monthNew) {
                  workingMonth = monthOld;
                  monthOld = 0;
                  monthNew = 0;
                }
              } else {
                filterStatus = true;
                monthOld = 0;
                monthNew = 0;
              }

            }


            if (tempMonth != false && direction == true) {
              workingMonth = tempMonth;
              tempMonth = false;
            }
            if (tempYear != false) {
              year = tempYear;
              workingMonth = tempMonth;
              tempMonth = false;
              tempYear = false;
            }

            if (weekObj.includes(WorkingMax)) {
              Index = weekObj.indexOf(WorkingMax);
              if (Index == weekObj.length - 1) {
                if (direction == true) {
                  if (workingMonth > 11) {
                    workingMonth = 0;
                    year++;
                  } else {
                    tempMonth = workingMonth + 1;
                  }
                }
                if (direction == false) {
                  if (workingMonth < 0) {
                    workingMonth = 11;
                    tempYear = year - 1;
                  } else {
                    workingMonth--;
                  }
                }
                WorkingMax = DaysOfMonth[workingMonth];
              } else {
                if (direction == true) {
                  if (workingMonth >= 11) {
                    tempMonth = 0;
                    tempYear = year + 1;
                  } else {
                    tempMonth = workingMonth + 1;
                  }
                } else if (direction == false) {
                  if (workingMonth <= 0) {
                    tempMonth = 11;
                    tempYear = year - 1;
                  } else {
                    tempMonth = workingMonth--;
                  }
                } else {
                  if (workingMonth >= 11) {
                    tempMonth = 0;
                    tempYear = year + 1;
                  } else {
                    tempMonth = workingMonth + 1;
                  }
                }
              }
            }
            DAYSData = ['Monday', 'Tuesday', 'Wednesday', 'Friday', 'Thursday', 'Friday', 'Saturday', 'Sunday']
            const ElementsViewsMain = ViewElements.querySelectorAll(".event_record");
            if (ElementsViewsMain) {
              ElementsViewsMain.forEach((element) => {
                element.classList.remove("active");
              });
            }

            MenuData.innerHTML = `${monthNames[workingMonth]} ${year}`;
            weekObj.forEach((element_main) => {
              Index = weekObj.indexOf(element_main);
              var element;
              SetDateMonth = 0;
              SetDateYear = 0;
              for (let i = 0; i < HeaderSelector.length; i++) {
                element = HeaderSelector[i];
                if (parseInt(element.getAttribute("data-id")) === i) {
                  if (SetDateMonth == 0) {
                    if (i != 0 && weekObj[i] < weekObj[i - 1]) {
                      SetDateMonth = tempMonth;
                    }
                  }
                  if (SetDateYear == 0) {
                    if (i != 0 && weekObj[i] < weekObj[i - 1]) {
                      SetDateYear = tempYear;
                    }
                  }

                  if (isNaN(weekObj[i])) {
                    element.classList.add("dim");
                  }

                  if (SetDateYear != 0) {
                    element.querySelector("span").setAttribute('data_year', SetDateYear);
                  } else {
                    element.querySelector("span").setAttribute('data_year', year);
                  }

                  if (SetDateMonth == 0) {
                    element.querySelector("span").setAttribute('data_month', workingMonth);
                  } else {
                    element.querySelector("span").setAttribute('data_month', SetDateMonth);
                  }

                  element.querySelector("span").innerHTML = weekObj[i];
                }
                titleInfo = `${DAYSData[i]} , ${monthNames[parseInt(element.querySelector("span").getAttribute('data_month'))]} ${element.querySelector("span").innerText} ,${element.querySelector("span").getAttribute('data_year')}  `;
                element.setAttribute('title', titleInfo);
                weekDataDisplay(element.querySelector("span").getAttribute('data_year'), element.querySelector("span").getAttribute('data_month'), element_main, Index);
              }

            });
          }
          function weekDataDisplay(year_d, month_d, day_d, index) {
            try {
              let month = parseInt(month_d);
              let day = parseInt(day_d);
              let year = parseInt(year_d);
              let data = Calender_Data.value;
              const DayDiv = document.querySelector(".day_details .schedules");
              const Schedules = document.querySelector(".day_details .events");
              let ElementTopHeight = 0;
              let ElementHeight = 0;
              const GridCells = [
                "gridrowO",
                "gridrowT",
                "gridrowTH",
                "gridrowF",
                "gridrowFI",
                "gridrowS",
                "gridrowSE",
              ];
              TargetElement = GridCells[index];
              var elementData = document.querySelector("." + TargetElement);
              const ElementsViews = elementData.querySelectorAll(".event_record");
              if (data != "" || data != " ") {
                let convertToObj = JSON.parse(data);
                if (convertToObj) {
                  for (const key in convertToObj) {
                    const element = convertToObj[key];
                    if (
                      parseInt(element["Day"]) == parseInt(day_d) &&
                      parseInt(element["Month"]) == parseInt(month_d) &&
                      parseInt(element["Year"]) == parseInt(year_d)
                    ) {
                      let Contigency = false;
                      if (ElementsViews) {
                        ElementsViews.forEach((element) => {
                          if (element.hasAttribute("data-year")) {
                            if (
                              element.getAttribute("data-year") == parseInt(year_d) &&
                              element.getAttribute("data-month") ==
                              parseInt(month_d) &&
                              element.getAttribute("data-day") == parseInt(day_d)
                            ) {
                              element.classList.add("active");
                              Contigency = true;
                            }
                          }
                        });
                      }
                      if (!Contigency) {
                        StartTime = element["start"];
                        EndTime = element["end"];
                        if (StartTime && EndTime) {
                          let ValuesBegin = StartTime.split(":");
                          let ZoneDivide = ValuesBegin[1].split(" ");
                          let valueCalc = parseInt(ValuesBegin[0]);
                          let ValuesEnd = EndTime.split(":");
                          let ZoneDivideEnd = ValuesEnd[1].split(" ");
                          let valueCalcEnd = parseInt(ValuesEnd[0]);
                          let ElementTopHeight;
                          let ElementHeight;
                          let constant = 40;

                          if (ZoneDivide[ZoneDivide.length - 1] == 'am') {
                            ElementTopHeight = constant * valueCalc;
                            let cntTop = ElementTopHeight;

                            if (ZoneDivideEnd[ZoneDivideEnd.length - 1] == 'am') {
                              let cntVal = valueCalcEnd;
                              let cntTop = ElementTopHeight;
                              if (valueCalc == valueCalcEnd) {
                                cntVal = 0.5;
                                cntTop = 0;
                              }
                              ElementHeight = constant * cntVal;
                              ElementHeight = ElementHeight - cntTop;
                              if (ZoneDivide[0] != '00') {
                                ElementTopHeight += constant * 0.5;
                                ElementHeight = ElementHeight - (constant * 0.5);
                              }
                              if (valueCalc != valueCalcEnd && ZoneDivideEnd[0] != '00') {
                                ElementHeight += constant * 0.5;
                              }
                            } else {
                              let cntVal = parseInt(ValuesEnd[0]);
                              if (cntVal == 12) {
                                cntVal = 0;
                              }

                              ElementHeight = constant * (cntVal + 12);
                              ElementHeight = ElementHeight - cntTop;

                            }
                          } else {
                            ElementTopHeight = constant * (valueCalc + 12);
                            let cntVal = valueCalcEnd;
                            let cntTop = ElementTopHeight;
                            if (ZoneDivideEnd[ZoneDivideEnd.length - 1] == 'pm') {
                              if (valueCalc == valueCalcEnd) {
                                cntVal = 0.5;
                                cntTop = 0;
                              }
                              ElementHeight = constant * (cntVal + 12);
                              ElementHeight = ElementHeight - cntTop;
                              if (ZoneDivide[0] != '00') {
                                ElementTopHeight += constant * (0.5 + 12);
                                ElementHeight = ElementHeight - (constant * (0.5 + 12));
                              }
                              if (valueCalc != valueCalcEnd && ZoneDivideEnd[0] != '00') {
                                ElementHeight += constant * (0.5 + 12);
                              }
                            } else {
                              ElementHeight = constant * cntVal;//** */
                            }
                          }

                          currentSpan =
                            elementData.querySelector(".customize_event");
                          currentSpan.style.setProperty(
                            "--top",
                            ElementTopHeight + "px"
                          );
                          currentSpan.style.height = ElementHeight + "px";
                          Time_position = ElementTopHeight;
                          Class_name = element['department'];
                          const OldParent = elementData;
                          const NewParent = document.createElement("div");
                          NewParent.setAttribute("class", "event_record");
                          const CloneItem = currentSpan.cloneNode(true);
                          NewParent.classList.add(Class_name);
                          NewParent.classList.add("Owel" + String(Time_position));
                          NewParent.setAttribute("data-year", year);
                          NewParent.setAttribute("data-month", month);
                          NewParent.setAttribute("data-day", day);

                          if (CloneItem.classList.contains("min")) {
                            NewParent.classList.add("min");
                          }
                          DisplayName = element["name"];
                          if (DisplayName.length > 15) {
                            DisplayName = DisplayName.slice(0, 15);
                          }
                          CloneItem.innerHTML = `<span class="element_main_data">${DisplayName}</span>`;
                          CloneItem.setAttribute("class", "eventClassData");
                          StyleProperties = currentSpan.getAttribute("style");
                          CloneItem.setAttribute("style", "");
                          NewParent.setAttribute("style", StyleProperties);
                          NewParent.append(CloneItem);
                          OldParent.append(NewParent);

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
                          DataObj.End =
                            document.querySelector("P.End_time_p").innerText;
                          DataObj.Tag =
                            document.querySelector("P.EventTag").innerText;
                          DataObj.top = Time_position;
                          classtag =
                            document.querySelector("P.EventTag").innerText;
                          NewParent.classList.add(classtag);
                          let JsonElement = JSON.stringify(element);
                          template = `<div class="data-details">
                                          <div class="flex">
                                              <i class="fas fa-trash" data-ical="delete" data-val="${element["unique_id"]}"></i>
                                              <i class="fas fa-edit" data-ical="update" data-val="" data-info='${JsonElement}'></i>
                                              <p>${element["name"]}</p>
                                          </div>
                                              <div class="flex">
                                                  <svg xmlns="http://www.w3.org/2000/svg"
                                                      height="24px" viewBox="0 -960 960 960"
                                                      width="24px" fill="#000">
                                                      <path
                                                          d="M480-400q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Z" />
                                                  </svg>
                                                  <header>${element['venue']}</header>
                                              </div>
                                              <div class="flex">
                                                  <i class="fas fa-clock"></i>
                                                  <p>${element['start']} - ${element['end']}</p>
                                              </div>
                  
                                          </div>`;
                          NewParent.innerHTML += template;
                          NewParent.classList.add('active');


                        }
                        ElementTopHeight = 0;
                        ElementHeight = 0;
                      }
                    }
                  }
                }
              }
            } catch (error) {
              console.log("An error occurred pls start the process again", error);
            }
          }
          function CalculateTime(customElementsTemp, value) {
            try {
              Calc = value / 40;
              record = 0;
              if (Calc % 2 != 0) {
                Expression = /\./;
                if (Expression.test(Calc)) {
                  MinutesRange = String(Calc).split(".");
                  if (Expression.test(MinutesRange[1])) {
                    CharacterSplit = MinutesRange[1].split("");
                    if (parseInt(CharacterSplit[0]) > 5) {
                      record = "30";
                    }
                  }
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
              if (span) {
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
            } catch (error) {
              console.log(error)
            }
          }
          function DayInformation(Year, Month, Day) {
            try {
              DaysLater = [
                "Sunday",
                "Monday",
                "Tueday",
                "Weday",
                "Thursday",
                "Friday",
                "Saturday",
              ];
              TrialDate = new Date(Year, Month, Day);
              DayInfo.querySelector("header").innerText = Day;
              DayInfo.querySelector("p").innerText = `${DaysLater[TrialDate.getDay()]
                }, ${monthNames[parseInt(Month)]}, ${Year}`;
            } catch (error) {
              console.log(error)
            }
          }

          selectors.forEach((element) => {
            element.addEventListener("click", function () {
              try {
                const ElementNext = element.parentNode;
                if (ElementNext) {
                  ElementNext.classList.toggle("active");
                  if (element.getAttribute("data-origin") == "start") {
                    ResizeOrigin = true;
                  } else if (element.getAttribute("data-origin") == "end") {
                    ResizeOrigin = false;
                  }
                  selectors.forEach((elementR) => {
                    if (element != elementR) {
                      const ElementNext = elementR.parentNode;
                      if (ElementNext) {
                        ElementNext.classList.remove("active");
                      }
                    }
                  });
                }
              } catch (error) {
                console.log(error);
              }
            });
          });

          window.addEventListener("click", function (e) {
            try {
              const HeaderSelector = document.querySelectorAll("strong[data-id]");
              const ColorPicker_palette = document.querySelector(".colorlist");
              const SchedulesData = document.querySelector(".main_schedule");
              const target = e.target;
              if (target.tagName == "I") {
                if (target.hasAttribute("data-ical")) {
                  if (target.getAttribute("data-ical") == "update") {
                    if (target.getAttribute("data-info")) {
                      let BronzeElement = target.parentElement.parentElement.parentElement.parentElement;
                      currentSpan = target.parentElement.parentElement.parentElement;
                      PositionMenu(BronzeElement, e);
                      UpdateItemFunction(target);
                      stringData = 'update';
                    }
                  } else if (target.getAttribute("data-ical") == "delete") {
                    currentSpan = target.parentElement.parentElement.parentElement;
                    const dn_message = document.querySelector(".dn_message");
                    dn_message.classList.add("active");
                    validateKey = target.getAttribute("data-val");
                  }
                }
              } else
                if (SchedulesData.contains(target)) {
                  const ElementsViews = document.querySelectorAll('.event_record');
                  let Contigency = false;
                  if (ElementsViews) {
                    ElementsViews.forEach((element) => {
                      if (element.hasAttribute("data-year")) {
                        if (element.contains(target)) {
                          Contigency = true;
                        }
                      }

                    });
                  }
                  if (!Contigency) {
                    const customize_event = document.querySelectorAll('.customize_event');
                    let BronzeElement = target;
                    if (target.tagName == "I") {
                      BronzeElement = target.parentElement.parentElement.parentElement.parentElement;
                      currentSpan = target.parentElement.parentElement.parentElement;
                    }
                    customize_event.forEach(element => {
                      element.classList.add('dull');
                    });
                    PositionMenu(BronzeElement, e);
                  }
                } else
                  if (!document.querySelector(".month_selector").contains(target) &&
                    !MenuDate.contains(target)) {
                    document.querySelector(".month_selector").classList.remove("active");
                  }

              confirmsBtns.forEach((element) => {
                const ElementData = element;
                if (target == ElementData) {
                  if (ElementData.getAttribute("data-confirm") == "true") {
                    if (validateKey != "") {
                      DeleteItemFunction(ElementData.getAttribute("data-confirm"));
                    }
                    setTimeout(() => {
                      dn_message.classList.add("active");
                      dn_message.classList.add("delete");
                    }, 100);
                  } else {

                    dn_message.classList.remove("active");
                  }
                }
              });
            } catch (error) {
              console.log(error)
            }

          });
          function PositionMenu(target, e) {
            try {
              GridCells.forEach((element) => {
                const MainElement = document.querySelector("." + element);
                if (MainElement.contains(target)) {
                  if (target.classList.contains(element) || MainElement.contains(target)) {
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
                    BaseWidth = (ViewElements.clientWidth / 2) - 50;
                    BaseHeight = ViewElements.clientHeight / 2;
                    position =
                      e.clientX - ViewElements.getBoundingClientRect().left;
                    topPosition =
                      e.clientY - ViewElements.getBoundingClientRect().top;
                    Time_position = topPosition;
                    Left_position = position;
                    if (position < BaseWidth) {
                      val = position + 400;
                      if (val > 870) {
                        val = 870;
                      }
                      AddMenu.style.setProperty("--left", val + "px");
                    } else {
                      val = position - 350;
                      if (val > 870) {
                        val = 870;
                      }
                      AddMenu.style.setProperty("--left", val + "px");
                    }
                    AddBtn.querySelector("i").classList.add("fa-times");
                    AddMenu.classList.add("active");
                    let customElementsTemp;

                    if (currentSpan) {
                      if (currentSpan.classList.contains('event_record')) {
                        customElementsTemp = currentSpan;
                      } else {
                        customElementsTemp =
                          target.querySelector(".customize_event");
                      }
                    } else {
                      customElementsTemp =
                        target.querySelector(".customize_event");
                    }
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
            } catch (error) {
              console.log(error);
            }
          }
          function changeTabMenu(tabOrder) {
            try {
              TabsMenu.forEach((element) => {
                CategoryMenu.setAttribute("class", "event_category");
                if (tabOrder == "dayTab") {
                  CategoryMenu.classList.add("day");
                } else if (tabOrder == "WeekTab") {
                  CategoryMenu.classList.add("week");
                } else if (tabOrder == "MonthTab") {
                  CategoryMenu.classList.add("month");
                }
                TabsMenu.forEach((element_check) => {
                  if (
                    element_check.classList.contains("active") &&
                    element_check.id != tabOrder
                  ) {
                    element_check.classList.remove("active");
                  }
                });
                if (element.id == tabOrder) {
                  element.classList.add("active");
                }
              });
            } catch (error) {
              console.log(error)
            }
          }
          function UpdateItemFunction(value) {
            TargetElement = value.parentElement.parentElement.parentElement;
            currentSpan = TargetElement;
            if (currentSpan) {
              DataObj = value.getAttribute("data-info");
              DataObj = JSON.parse(DataObj);
              document.querySelector('input[name="EventName"]').value = DataObj["name"];
              document.querySelector(
                'input[name="EventLocation"]'
              ).value = DataObj["venue"];
              document.querySelector(
                'textarea[name="EventDescription"]'
              ).value = DataObj["about"];
              document.querySelector("P.start_time_p").innerText = DataObj["start"];
              document.querySelector("P.End_time_p").innerText = DataObj["end"];
              document.querySelector("P.EventTag").innerText = DataObj["theme"];
              document.querySelector('.event_menu input[name="delete_key"]').value = DataObj["unique_id"];
              APIDOCS = "../API/partnership/data_process.php?APICALL=true&&user=true&&submit=update_file";
              AddMenu.classList.add('active');
            }
          }
          async function DeleteItemFunction(value) {
            try {
              if (value == "true" && validateKey) {
                let API =
                  "../API/calender/data_process.php?APICALL=true&&user=true&&submit=delete";
                let Response = await PHPREQUESTDEL(API, validateKey);
                if (Response == 'success') {
                  currentSpan.classList.remove('active');
                  dn_message.querySelector('p').innerText = 'your request to delete was a success';

                }
              }
            } catch (error) {
              console.log(error)
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
            try {
              let TargetData = false;
              let IndexData = false;
              num = 0;
              if (currentSpan) {
                if (value == "update") {
                  CustomizeList = document.querySelectorAll('.event_record');
                }
                GridCells.forEach((element) => {
                  const MainElement = document.querySelector("." + element);
                  if (MainElement.contains(currentSpan)) {
                    if (MainElement.contains(currentSpan)) {
                      IndexData = GridCells.indexOf(element);
                    }
                  }
                });
                if (IndexData != false) {
                  TargetData = HeaderSelector[IndexData].querySelector('span');
                  console.log(TargetData);
                  if (TargetData.hasAttribute('data_year') && TargetData.hasAttribute('data_month')) {
                    year = parseInt(TargetData.getAttribute('data_year'));
                    month = parseInt(TargetData.getAttribute('data_month'));
                    DayVal = parseInt(TargetData.innerText);

                    console.log(year, month, DayVal);
                    let APIDOCS;
                    if (value == "update") {
                      APIDOCS =
                        "../API/calender/data_process.php?APICALL=true&&user=true&&submit=update";
                    } else if (value == "upload") {
                      APIDOCS =
                        "../API/calender/data_process.php?APICALL=true&&user=true&&submit=upload";
                    }

                    let data;
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
                      console.error(data);
                      if (data) {
                        return String(data);
                      }
                    } else {
                      return "cannot find endpoint";
                    }

                  } else {
                    return 'Error occurred';
                  }
                }
              } else {
                console.log(currentSpan);
              }

            } catch (error) {
              console.error(error)
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
                  return data;
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
          const CalendaList = document.querySelectorAll(
            ".min_data.event_days div"
          );
          const CalendaListMonth = document.querySelectorAll(
            ".view.month_view div.view_main div"
          );
          CalendaList.forEach((element) => {
            Checker = DataCheckList(
              year,
              month + 1,
              element.querySelector("p").innerText,
              element
            );
          });
          CalendaListMonth.forEach((element) => {
            Checker = DataCheckList(
              year,
              month + 1,
              element.innerText,
              element
            );
          });
          function DataCheckList(year, month, day, div) {
            let data = Calender_Data.value;
            const DayDiv = document.querySelector(".day_details .schedules");
            const Schedules = document.querySelector(".day_details .events");
            if (data != "" || data != " ") {
              let convertToObj = JSON.parse(data);

              for (const key in convertToObj) {
                const element = convertToObj[key];
                if (
                  parseInt(element["Day"]) == parseInt(day) &&
                  parseInt(element["Month"]) == parseInt(month) &&
                  parseInt(element["Year"]) == parseInt(year)
                ) {
                  div.innerHTML += `<p>${element["name"]}</p>
                      <p>${element["start"]}<p>
                      <p>${element["end"]}<p>`;
                  div.setAttribute("data-icu", "");
                  div.classList.add(element["department"]);
                  div.classList.add("active_today");
                  div.setAttribute(
                    "title",
                    element["department"] +
                    " titled " +
                    element["name"] +
                    element["name"] +
                    " set at " +
                    element["start"] +
                    " to-" +
                    element["end"]
                  );
                }
              }
            }
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

              TimeMorningList = sortList(TimeMorningList);
              TimeEveningList = sortList(TimeEveningList);

              var newObject = TimeMorningList;

              newObject = newObject.concat(TimeEveningList);
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
          getWeeks(month, year, Current);
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
            AddEventBtn.addEventListener("click", function (e) {
              APIDOCS =
                "../API/Assets&projects/data_process.php?APICALL=true&&user=true&&submit=true";
              AddEventMenu.classList.add("active");
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
              const Pages = document.querySelectorAll(".pages div");
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
              Pages.forEach((element) => {
                if (element.contains(target)) {
                  value = element.innerHTML;
                  pagnationSystem(value);
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
          var OptionElements = document.querySelectorAll(".option");
          const tabs_offertory = document.querySelector(".offertory_itenary");
          const slider_menu = document.querySelector(".slider_menu");
          const Event_tab = document.querySelector(".home_event_itenary");
          const NavigationFilter = document.querySelector(".options .Filter");
          const Export_variables = document.querySelector('#ExportBtn');
          const Export_variables_Dialogue = document.querySelector('.export_dialogue');
          const Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
          const Export_variables_Dialogue_Form = Export_variables_Dialogue.querySelector("form");
          const List_filter = document.querySelector(".List_filter");
          const GeneralFilter = document.querySelector('.options .item_opt.filterBtn');
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
          let ElementEngage = "";
          List_filter.addEventListener("click", function () {
            APIDOCS =
              "../API/finance/data_process.php?APICALL=true&&user=offertory&&submit=filter";
            PHPREQUESTFILTER(APIDOCS);
          });
          AddEventMenuForm.addEventListener("submit", function (e) {
            e.preventDefault();
          });
          AddEventMenu_offForm.addEventListener("submit", function (e) {
            e.preventDefault();
          });
          Export_variables_Dialogue_Form.addEventListener('submit', function (e) {
            e.preventDefault();
          })
          Export_variables.onclick = function () {
            Export_variables_Dialogue.classList.add("active");
          };
          Export_variables_Dialogue_Btn.addEventListener('click', async function () {
            var loaderBtn = Export_variables_Dialogue.querySelector(".loader");
            loaderBtn.classList.add("active");
            var formConditions = Export_variables_Dialogue.querySelectorAll(".form_condition");
            if (ConditionFeilds(formConditions) != false) {
              if (ActivityMenu == false) {
                bodyDisplay = document.querySelector('.menu.account .container_item');
              } else {
                bodyDisplay = document.querySelector('.menu.event .container_item');
              }
              ExportType = Export_variables_Dialogue.querySelector('select[name="export_type"]').value;
              ExportDataName = Export_variables_Dialogue.querySelector('input[name="export_name"]').value;
              if (Export_variables_Dialogue.querySelector('select[name="data_type"]').value == '1') {
                template = "<ul>";
                console.log(bodyDisplay.querySelectorAll('.details p'));
                bodyDisplay.querySelectorAll('.details p').forEach(element => {
                  template += `<li>${element.innerHTML}</li>`;
                });
                template += "</ul>";
                ExportDataToSend = template;
                ExportData(ExportType,ExportDataToSend,ExportDataName);
              } else {
                pageCondition = bodyDisplay.querySelector('.page_sys');
                pagesmore = false;
                if(pageCondition){
                  if(pageCondition.innerText == " " || pageCondition.innerText == ''){
                    template = "<ul>";
                    console.log(bodyDisplay.querySelectorAll('.details p'));
                    bodyDisplay.querySelectorAll('.details p').forEach(element => {
                      template += `<li>${element.innerHTML}</li>`;
                    });
                    template += "</ul>";
                    ExportDataToSend = template;
                    pagesmore = true;
                  }
                }else{
                  pagesmore = true;
                }
                if(pagesmore){
                  APIDOCS = "";
                  if (ActivityMenu == false) {
                    APIDOCS =
                    "../API/finance/data_process.php?APICALL=true&&user=offertory&&submit=export";
                } else {
                  APIDOCS =
                    "../API/finance/data_process.php?APICALL=true&&user=true&&submit=export";
                }

                try {
                  controller = new AbortController();
                  const Request = await fetch(APIDOCS, {
                    method: "POST",
                    body: "",
                  });
    
                  if (Request.status === 200) {
                    data = await Request.json();
                    if (data) {
                      const ObjectDataFrame = JSON.parse(data);
                      if(ObjectDataFrame){
                        template = "<ul>"
                         for (const key in ObjectDataFrame) {
                            namer = ObjectDataFrame[key]['name'];
                            amount = ObjectDataFrame[key]['amount'];
                            date = ObjectDataFrame[key]['date'];
                            template += `<li class='item_name'> <p>${namer} - Total ${amount}</p>
                                  <p>last modified  . ${date }</p></li>`
                          }
                          template += "</ul>";
                          ExportDataToSend = template;
                          ExportData(ExportType,ExportDataToSend,ExportDataName);
                      }
                    }
                  } else {
                    console.log("Cannot iniate Download");
                  }
                } catch (error) {
                  console.error(error);
                }

                // var ExportData = document.querySelector('#OrigDues').value;
                // if (ExportData != "Fetching data encounted a problem" && ExportData != "Not Records Available") {
                //   const ObjectDataFrame = JSON.parse(ExportData);
                //   if (ObjectData) {
                //     ExportString = "";
                //     for (const key in ObjectDataFrame) {
                //       Amount = ObjectDataFrame[key]['amount'];
                //       Name = ObjectDataFrame[key]['name'];
                //       date = ObjectDataFrame[key]['date'];
                //       date_data = ObjectDataFrame[key]['date_data'];
                //       purpose = ObjectDataFrame[key]['purpose'];
                //       department = ObjectDataFrame[key]['department'];
                //       id = ObjectDataFrame[key]['UniqueId'];

                //       ExportString += `<div class='item'>
                //             <div class='file'>
                //             <img src='../images/cfile.png' alt='' />
                //             </div>
                //             <div class='details'>
                //             <a href='finance/finance_event.php?data_page=$id&&amount=${amount}' target='_blank' class='flex'>
                //                 <p class='item_name' data_item=" . ${date_data} . ">" . ${Name} . "  - Total " . ${Amount} . "</p>
                //                 <p>last modified . " . ${date_data} . "</p>
                //             </a>
                //             </div>
                //             <div class='delete option'>
                //                 <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                //                     width='30'>
                //                     <path
                //                         d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                //                 </svg>
                //                 <div class='opt_element'>
                //                     <p Update_item='" . ${id} . "'>Update item <i></i></p>
                //                     <p delete_item='" . ${id} . "'>Delete item <i></i></p>
                //                 </div>
                //             </div>
                //           </div>
                //         `;

                //     }
                //   }
                // }
                }
              }
            }
          })

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
                  setTimeout(() => {
                    dn_message.classList.add("active");
                    dn_message.classList.add("delete");
                  }, 100);
                }
              }

            });
          });

          searchBtn.addEventListener("click", e => {
            APIDOCS;
            if (ActivityMenu == false) {
              APIDOCS =
                "../API/finance/data_process.php?APICALL=true&&user=offertory&&submit=search";
            } else {
              APIDOCS =
                "../API/finance/data_process.php?APICALL=true&&user=true&&submit=search";
            }
            if (searchInput.value != " " && searchInput.value != "") {
              searchSystem(APIDOCS, searchInput.value);
            }

          })

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
                  if (data == 'Item Deleted Successfully') {
                    if (ElementEngage) {
                      ElementEngage.classList.add('hide');
                    }

                  }
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
              loader_progress.classList.add("active");
              ContentDom.classList.add("load");
              DomManipulationElement.classList.add("load");
              dn_message.querySelector("p").innerText = "...processing request";
              dataSend = {
                year: document.querySelector('select[name="yearfilter"]').value
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
                  var bodyDisplay;
                  if (ActivityMenu == false) {
                    bodyDisplay = document.querySelector('.menu.account .container_item');
                  } else {
                    bodyDisplay = document.querySelector('.menu.event .container_item');
                  }
                  setTimeout(() => {
                    if (data == "" || data == 'Error Occurred' || data == 'Not Records Available') {
                      bodyDisplay.innerHTML = "<header class='danger'>AN ERROR OCCURRED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                    } else {
                      bodyDisplay.innerHTML = "";
                      dataDecode = JSON.parse(data);
                      month = 0;
                      for (const key in dataDecode) {
                        Item_name = dataDecode[key]['name'];
                        amount = dataDecode[key]['amount'];
                        date = dataDecode[key]['date'];
                        purpose = dataDecode[key]['purpose'];
                        id = dataDecode[key]['id'];
                        Month = dataDecode[key]['Month'];
                        ObjectData = dataDecode[key]['obj'];
                        if (month != parseInt(Month)) {
                          bodyDisplay.innerHTML += `
                              <div class='itemlist calender'>
                          <img src='../images/calender/" ${Month} ".jpg' alt='calender year " ${Month} "' />
                          </div>`;
                          month = Month;
                        }
                        template = `
                      <div class='item'>
                      <div class='file'>
                      <img src='../images/cfile.png' alt='' />
                      </div>
                      <div class='details'>
                          <p class='item_name' data_item=" ${date} "> ${Item_name}   - Total ${amount} </p>
                          <p>last modified . "${date}"</p>
                          
                      </div>
                      <div class='delete option'>
                          <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                              width='30'>
                              <path
                                  d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                          </svg>
                          <div class='opt_element'>
                              <p Update_item='${id}' data-information='{ObjectData}'>Update item <i></i></p>
                              <p delete_item='${id}'>Delete item <i></i></p>
                          </div>
                      </div>
                  </div>
                 `;
                        bodyDisplay.innerHTML += template;


                      }
                      SearchTrigger = true;
                    }

                  }, 200);
                }
              } else {
                console.log("cannot find endpoint");
              }
              loader_progress.classList.remove("active");
              ContentDom.classList.remove("load");
              DomManipulationElement.classList.remove("load");
            } catch (error) {
              console.error(error);
            }
          }
          AddEventMenu_Btn.addEventListener("click", function () {
            var loaderBtn = AddEventMenu.querySelector(".loader");
            loaderBtn.classList.add("active");
            var formConditions = document.querySelectorAll(".form_condition");
            console.log(ConditionFeilds(formConditions));
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
            if (NavigationBar.classList.contains('search_out')) {
              NavigationBar.classList.remove('search_out');
              GeneralFilter.classList.remove('null');
            }
            ActivityMenu = true;
          };

          tabs_offertory.onclick = function () {
            slider_menu.classList.add("active");
            NavigationBar.classList.add('search_out');
            GeneralFilter.classList.add('null');
            ActivityMenu = false;
          };

          OptionElements.forEach((element) => {
            element.addEventListener("click", function () {
              ElementEngage = element.parentElement;
              var ElementOptions = element.querySelector(".opt_element");
              ElementOptions.classList.add("active");
              dn_message.classList.remove('delete');
              dn_message.querySelector('p').innerText = '';
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

            if (!Export_variables_Dialogue.contains(target) &&
              !Export_variables.contains(target)) {
              Export_variables_Dialogue.classList.remove("active");
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

            // if (target.parentElement.classList.contains('option')) {
            //   targetMain = target.parentElement;
            //   if (!targetMain.classList.contains('active')) {
            //     targetMain.classList.add('active');
            //   }

            //   console.log(targetMain);
            // }
            // if (target.classList.contains('option')) {
            //   console.log(target);
            // }
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
          const searchSystem = debounce(async (APIDOCS, value) => {
            let data;
            try {
              loader_progress.classList.add("active");
              ContentDom.classList.add("load");
              DomManipulationElement.classList.add("load");
              dn_message.querySelector("p").innerText = "...processing request";
              dataSend = {
                key: value,
                numData: numoffset,
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
              data = await Request.json(data);
              if (Request.status === 200) {
                if (data) {
                  if (data != 'No Records Available' && data != 'Fetching data encounted a problem' && data != 'No Records Available') {
                    let ObjectDataFrame = JSON.parse(data);
                    Template = "";
                    if (ActivityMenu == false) {
                      Template = document.querySelector('.menu.account .container_item');
                      CloneObject = document.querySelector('.menu.account').querySelector('.cloneSearch').cloneNode(true);
                    } else {
                      Template = document.querySelector('.menu.event .container_item');
                    }
                    Template.innerHTML = "";
                    ObjectDataFrame = ObjectDataFrame['result'];
                    for (const key in ObjectDataFrame) {
                      Amount = ObjectDataFrame[key]['amount'];
                      Name = ObjectDataFrame[key]['name'];
                      date = ObjectDataFrame[key]['date'];
                      date_data = ObjectDataFrame[key]['date_data'];
                      purpose = ObjectDataFrame[key]['purpose'];
                      department = ObjectDataFrame[key]['department'];
                      id = ObjectDataFrame[key]['UniqueId'];
                      ObjectData = ObjectDataFrame[key]['Obj'];
                      const CloneObject = document.querySelector('.menu.event').querySelector('.cloneSearch').cloneNode(true);
                      if (CloneObject != '') {
                        const ElementDivCone = document.createElement('div');
                        ElementDivCone.classList.add('SearchItem');
                        CloneObject.querySelector('p.item_name').setAttribute('data_item', date_data);
                        CloneObject.querySelector('p.item_name').innerText = `${Name}   - Total  ${Amount} `;
                        CloneObject.querySelector('p.item_modified').innerText = `last modified  ${date_data}`;
                        CloneObject.querySelector('.opt_element p.up').setAttribute('Update_item', id);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                        CloneObject.querySelector('.opt_element p.dp').setAttribute('delete_item', id);
                        CloneObject.querySelector('a').setAttribute('href', `finance/finance_event.php?data_page=${id}&&amount=${Amount}' target='_blank'`)
                        CloneObject.removeAttribute('hidden')
                        ElementDivCone.append(CloneObject);
                        Template.append(ElementDivCone);
                        OptionElements = document.querySelectorAll(".option");
                        const element = ElementDivCone.querySelector('.option');
                        element.addEventListener("click", function () {
                          var ElementOptions = element.querySelector(".opt_element");
                          ElementOptions.classList.add("active");
                        });
                      }


                    }
                    if (ObjectDataFrame['pages'] > 25) {
                      ConvertPages = ObjectDataFrame['pages'];
                      RestructurePages(ConvertPages);
                    }
                  }
                }
              } else {
                console.log("cannot find endpoint");
              }
              loader_progress.classList.remove("active");
              ContentDom.classList.remove("load");
              DomManipulationElement.classList.remove("load");
            } catch (error) {
              console.error(error);
            }
          })
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
                numData: numoffset
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
                  bodyDisplay = document.querySelector(".records_table tbody");
                  setTimeout(() => {
                    if (data == "" || data == 'Error Occurred' || data == 'Not Records Available') {
                      bodyDisplay.innerHTML = "<header class='danger'>AN ERROR OCCURRED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                    } else {
                      bodyDisplay.innerHTML = "";
                      dataDecode = JSON.parse(data);
                      if (dataDecode['pages'] > 25) {
                        ConvertPages = dataDecode['pages'];
                        RestructurePages(ConvertPages);
                      }
                      dataDecode = dataDecode['result'];
                      for (const key in dataDecode) {
                        account = dataDecode[key]["account"];
                        amount = dataDecode[key]["amount"];
                        date = dataDecode[key]["Date"];
                        category = dataDecode[key]["category"];
                        Authorize = dataDecode[key]["Authorize"];
                        Status = dataDecode[key]["Status"];
                        id = dataDecode[key]["id"];
                        ObjectData = dataDecode[key]["obj"];

                        if (Status == 'terminated') {
                          item = "<div class='out_btn'><div></div>" + Status + "</div>";
                        } else
                          if (Status == 'pending') {
                            item = "<div class='in_btn blue'><div></div>" + Status + "</div>";
                          } else {
                            item = "<div class='in_btn'><div></div>" + Status + "</div>";
                          }

                        template = `<tr>
                              <td><div class='details'>

                              <div class='text'>
                              <p>${account}</p>
                              <p>${date}</p>
                              </div>

                              </div></td>
                              <td>${item}</td>
                              <td>${Authorize}</td>
                              <td>${amount}</td>
                              <td>${category}</td>
                              <td class='option'>
                                  <div class='delete option'>
                                          <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                                              width='30'>
                                              <path
                                                  d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                          </svg>
                                          <div class='opt_element'>
                                              <p class='update_item' Update_item='${id}' data-information='${ObjectData}'>Update item <i></i></p>
                                              <p class='delete_item' delete_item='${id}' >Delete item <i></i></p>
                                          </div>
                                  </div>
                              </td>
                          </tr>`;
                        bodyDisplay.innerHTML += template;


                      }
                      SearchTrigger = true;
                    }
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
                numData: numoffset
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
                  bodyDisplay = document.querySelector(".records_table tbody");
                  setTimeout(() => {
                    if (data == "" || data == 'Error Occurred' || data == 'Not Records Available' || data == 'no record found') {
                      bodyDisplay.innerHTML = "<header class='danger'>AN ERROR OCCURRED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                    } else {
                      bodyDisplay.innerHTML = "";
                      dataDecode = JSON.parse(data);
                      if (dataDecode['pages'] > 25) {
                        RestructurePages(dataDecode['pages']);
                      }
                      dataDecode = dataDecode['result'];
                      for (const key in dataDecode) {
                        category = dataDecode[key]["category"];
                        type = dataDecode[key]["type"];
                        details = dataDecode[key]["details"];
                        date = dataDecode[key]["date"];
                        year = dataDecode[key]["year"];
                        month = dataDecode[key]["month"];
                        amount = dataDecode[key]["amount"];
                        recorded_by = dataDecode[key]["recorded_by"];
                        unique_id = dataDecode[key]["id"];
                        ObjExport = dataDecode[key]["obj"];


                        template = `<tr class='${category}'>
                          <td title='${details}'>
                              <p>hover to view details</p>
                          <td>
                              <p>${date}</p>
                          </td>
                          <td>
                              <p>${type}</p>
                          </td>
                          <td>
                              <p>${recorded_by}</p>
                          </td>
                          </td>
                          <td>${amount}</td>
                          <td class='delete option'>
                              <svg xmlns='http://www.w3.org/2000/svg' height='30'
                                  viewBox='0 -960 960 960' width='48'>
                                  <path
                                      d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                              </svg>
                              <div class='opt_element'>
                                  <p delete_item='${unique_id}' class='delete_item'>Delete item <i></i></p>
                                  <p Update_item='${unique_id}' class='Update_item' class='' data-information='" . $ObjExport . "'>Update item <i></i></p>
                              </div>
                          </td>
                      </tr>`;
                        bodyDisplay.innerHTML += template;


                      }
                    }
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
          var FilterUI = document.querySelector(".notification_list_filter");
          var FilterUIList = document.querySelectorAll(".notification_list_filter .item");
          FilterUIList.forEach(element => {
            element.addEventListener('click', function () {
              setTimeout(() => {
                value = element.innerText;
                FilterUI.classList.remove("active");
                let DomManipulationElement;
                const route = Urlroutes[location] || Urlroutes[404];
                if (route) {
                  let request = route.template + "?year=" + value;
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
              }, 100);
            })
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
            var target = e.target;
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
          var OptionElements = document.querySelectorAll(".delete.option");
          const AddEventMenu_Btn = document.querySelector(
            ".event_menu_add Button"
          );
          var FilterUI = document.querySelector(".notification_list_filter");
          var FilterUIList = document.querySelectorAll(".notification_list_filter .item");
          FilterUIList.forEach(element => {
            element.addEventListener('click', function () {
              setTimeout(() => {
                value = element.innerText;
                FilterUI.classList.remove("active");
                let DomManipulationElement;
                const route = Urlroutes[location] || Urlroutes[404];
                if (route) {
                  let request = route.template + "?year=" + value;
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
              }, 100);
            })
          });
          searchBtn.addEventListener("click", e => {
            APIDOCS =
              "../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=search";
            if (searchInput.value != " " && searchInput.value != "") {
              searchSystem(APIDOCS, searchInput.value);
            }

          })

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

            filter_option.forEach((element) => {
              if (!element.contains(target)) {
                element.querySelector(".select").classList.remove("active");
              }
            });

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

          const searchSystem = debounce(async (APIDOCS, value) => {
            let data;
            try {
              loader_progress.classList.add("active");
              ContentDom.classList.add("load");
              DomManipulationElement.classList.add("load");
              dn_message.querySelector("p").innerText = "...processing request";
              dataSend = {
                key: value,
                numData: numoffset,
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
              data = await Request.json(data);
              if (Request.status === 200) {
                if (data) {
                  if (data != 'No Records Available' && data != 'Fetching data encounted a problem' && data != 'No Records Available') {
                    let ObjectDataFrame = JSON.parse(data);
                    Template = "";
                    Template = document.querySelector('.records_table table tbody');
                    Template.innerHTML = "";
                    ObjectDataFrame = ObjectDataFrame['result'];
                    for (const key in ObjectDataFrame) {
                      namer = ObjectDataFrame[key]['Name'];
                      amount = ObjectDataFrame[key]['Amount'];
                      Date = ObjectDataFrame[key]['Date'];
                      namer = ObjectDataFrame[key]['id'];
                      medium = ObjectDataFrame[key]['medium'];
                      detais = ObjectDataFrame[key]['details'];
                      gender = ObjectDataFrame[key]['gender'];
                      contact = ObjectDataFrame[key]['contact'];
                      Email = ObjectDataFrame[key]['Email'];
                      ObjectData = ObjectDataFrame[key]['Obj'];
                      const CloneObject = document.querySelector('.CloneSearch tr').cloneNode(true);
                      if (CloneObject != '') {
                        const ElementDivCone = document.createElement('tr');
                        ElementDivCone.classList.add('SearchItem');

                        CloneObject.querySelector('.Cloneemail').innerText = Email;
                        CloneObject.querySelector('.Clonedate').innerText = Date;
                        CloneObject.querySelector('.Clonegender').innerText = gender;
                        CloneObject.querySelector('.Clonecontact').innerText = contact;
                        CloneObject.querySelector('.Cloneamount').innerText = amount;
                        CloneObject.querySelector('.Clonemedium').innerText = medium;
                        CloneObject.querySelector('.Clonecontact').innerText = contact;
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('Update_item', namer);
                        CloneObject.querySelector('.opt_element p.dp').setAttribute('delete_item', namer);
                        ElementDivCone.innerHTML = CloneObject.innerHTML;
                        Template.append(ElementDivCone);
                        OptionElements = document.querySelectorAll(".option");
                        const element = ElementDivCone.querySelector('.option');
                        element.addEventListener("click", function () {
                          var ElementOptions = element.querySelector(".opt_element");
                          ElementOptions.classList.add("active");
                        });
                      }
                    }




                    if (ObjectDataFrame['pages'] > 25) {
                      ConvertPages = ObjectDataFrame['pages'];
                      RestructurePages(ConvertPages);
                    }

                  }
                } else {
                  console.log("cannot find endpoint");
                }
                loader_progress.classList.remove("active");
                ContentDom.classList.remove("load");
                DomManipulationElement.classList.remove("load");
              }
            } catch (error) {
              console.error(error);
            }

          })
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
          var FilterUI = document.querySelector(".notification_list_filter");
          var FilterUIList = document.querySelectorAll(".notification_list_filter .item");
          FilterUIList.forEach(element => {
            element.addEventListener('click', function () {
              value = element.innerText;
              FilterUI.classList.remove("active");
              let DomManipulationElement;
              const route = Urlroutes[location] || Urlroutes[404];
              if (route) {
                let request = route.template + "?year=" + value;
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
            })
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

          searchBtn.addEventListener("click", e => {
            APIDOCS =
              "../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=search";

            if (searchInput.value != " " && searchInput.value != "") {
              searchSystem(APIDOCS, searchInput.value);
            }

          })
          window.addEventListener("click", function (e) {
            var target = e.target;
            targetMain = '';
            if (target.parentElement.classList.contains('toggle_mode')) {
              targetMain = target.parentElement;

            }
            if (target.parentElement.parentElement.classList.contains('toggle_mode')) {
              targetMain = target.parentElement.parentElement;

            }
            if (target.classList.contains('toggle_mode')) {
              targetMain = target;
            }
            if (targetMain != '') {
              if (targetMain.classList.contains("active")) {
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
              if (targetMain.hasAttribute("data-id")) {
                Id = targetMain.getAttribute("data-id");
              }

              if (Id != "") {
                console.log(Change_status);
                APIDOCS =
                  "../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=status";
                if (PHPREQUESTSTATUS(APIDOCS, Change_status, Id)) {
                  targetMain.classList.toggle('active');

                } else {
                  alert("Sorry, an error occured activation the announcement");
                }
              }


            }


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

          // toggleModes.forEach((element) => {
          //   element.addEventListener("click", function () {
          //     if (element.classList.contains("active")) {
          //       Change_status = true;
          //     } else {
          //       Change_status = false;
          //     }
          //     if (Change_status == false) {
          //       Change_status = true;
          //     } else {
          //       Change_status = false;
          //     }
          //     Id = "";
          //     if (element.hasAttribute("data-id")) {
          //       Id = element.getAttribute("data-id");
          //     }

          //     if (Id != "") {
          //       console.log(Change_status);
          //       APIDOCS =
          //         "../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=status";
          //       if (PHPREQUESTSTATUS(APIDOCS, Change_status, Id)) {
          //         element.classList.toggle("active");
          //       } else {
          //         alert("Sorry, an error occured activation the announcement");
          //       }
          //     }
          //   });
          // });
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
          const searchSystem = debounce(async (APIDOCS, value) => {
            let data;
            try {
              loader_progress.classList.add("active");
              ContentDom.classList.add("load");
              DomManipulationElement.classList.add("load");
              dn_message.querySelector("p").innerText = "...processing request";
              dataSend = {
                key: value,
                numData: numoffset,
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
              data = await Request.json(data);
              if (Request.status === 200) {
                if (data) {
                  if (data != 'No Records Available' && data != 'Fetching data encounted a problem' && data != 'No Records Available') {
                    let ObjectDataFrame = JSON.parse(data);
                    Template = "";
                    Template = document.querySelector('.tithe_list.ancc_list');

                    Template.innerHTML = "";
                    ObjectDataFrame = ObjectDataFrame['result'];
                    for (const key in ObjectDataFrame) {
                      object = {};
                      object.id = ObjectDataFrame[key]['Id'];
                      object.title = ObjectDataFrame[key]['name'];
                      object.receiver = ObjectDataFrame[key]['receiver'];
                      object.date = ObjectDataFrame[key]['date'];
                      object.message = ObjectDataFrame[key]['message'];
                      objectFile = object;
                      temp_item = "";
                      if (ObjectDataFrame[key]['file'] == " " || ObjectDataFrame[key]['file'] == "") {
                        temp_item = `<div class='annc_item'>
                    <div class='flex button'>
                        <div class=' flex title'>
                            <h1>${ObjectDataFrame[key]['name']}</h1>
                            <div class='flex button'><i class='fas fa-date'></i>${ObjectDataFrame[key]['date']}</div>
                        </div>
                    </div>

                    <div class='div_content'>
                        <p>${ObjectDataFrame[key]['message']}</p>
                    </div>
                    <div class=' flex options title'>
                        <div class='edit flex'>
                            <i class='fas fa-edit Update_item' data-information='${objectFile}'></i>
                            <p>Edit</p>
                             <div class='toggle_mode ${ObjectDataFrame[key]['status']}' data-id='${ObjectDataFrame[key]['Id']}'>
                                <svg xmlns='http://www.w3.org/2000/svg' class='on' height='24' fill='green'
                                    viewBox='0 -960 960 960' width='24'>
                                    <path
                                        d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z' />
                                </svg>
                                <svg xmlns='http://www.w3.org/2000/svg' class='off' height='24' fill='red'
                                    viewBox='0 -960 960 960' width='24'>
                                    <path
                                        d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z' />
                                </svg>
                            </div>
                        </div>                        
                        <div class='edit flex'>
                            <i class='fas fa-trash delete_item' data-id='${ObjectDataFrame[key]['Id']}'></i>
                            <p>Remove</p>
                        </div>
                    </div>

                </div>`;
                      } else {

                        temp_item =
                          `
                    <div class='annc_item'>
                       <div class='flex'>
                        <img src='../API${ObjectDataFrame[key]['file']}' alt='' />
                        <div class='img_details'>
                            <div class='flex button'>
                             <div class=' flex title'>
                                 <h1>${ObjectDataFrame[key]['name']}</h1>
                                 <div class='flex button'><i class='fas fa-date'></i>${ObjectDataFrame[key]['date']}</div>
                             </div>
                            </div>
                            <div class='div_content'>
                             <p>${ObjectDataFrame[key]['message']}</p>
                            </div>
                        </div>
                      </div> 
                        <div class=' flex options title'>
                        <div class='edit flex'>
                            <i class='fas fa-edit Update_item' data-information='${objectFile}'></i>
                            <p>Edit</p>
                             <div class='toggle_mode ${ObjectDataFrame[key]['status']}' data-id=${ObjectDataFrame[key]['Id']}>
                                <svg xmlns='http://www.w3.org/2000/svg' class='on' height='24' fill='green'
                                    viewBox='0 -960 960 960' width='24'>
                                    <path
                                        d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z' />
                                </svg>
                                <svg xmlns='http://www.w3.org/2000/svg' class='off' height='24' fill='red'
                                    viewBox='0 -960 960 960' width='24'>
                                    <path
                                        d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z' />
                                </svg>
                            </div>
                        </div>                        
                        <div class='edit flex'>
                            <i class='fas fa-trash delete_item' data-id=${ObjectDataFrame[key]['Id']}></i>
                            <p>Remove</p>
                        </div>
                        </div>
                    </div>                       
                        `;
                      }

                      Template.innerHTML += temp_item;



                    }
                    if (ObjectDataFrame['pages'] > 25) {
                      ConvertPages = ObjectDataFrame['pages'];
                      RestructurePages(ConvertPages);
                    }
                  }
                }
              } else {
                console.log("cannot find endpoint");
              }
              loader_progress.classList.remove("active");
              ContentDom.classList.remove("load");
              DomManipulationElement.classList.remove("load");
            } catch (error) {
              console.error(error);
            }
          })
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
          var FilterUI = document.querySelector(".notification_list_filter");
          var FilterUIList = document.querySelectorAll(".notification_list_filter .item");
          FilterUIList.forEach(element => {
            element.addEventListener('click', function () {
              value = element.innerText;
              FilterUI.classList.remove("active");
              let DomManipulationElement;
              const route = Urlroutes[location] || Urlroutes[404];
              if (route) {
                let request = route.template + "?year=" + value;
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
            })
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
          searchBtn.addEventListener("click", e => {
            APIDOCS =
              "../API/Assets&projects/data_process.php?APICALL=true&&user=projects&&submit=search";
            if (searchInput.value != " " && searchInput.value != "") {
              searchSystem(APIDOCS, searchInput.value);
            }

          })

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
          const searchSystem = debounce(async (APIDOCS, value) => {
            let data;
            try {
              loader_progress.classList.add("active");
              ContentDom.classList.add("load");
              DomManipulationElement.classList.add("load");
              dn_message.querySelector("p").innerText = "...processing request";
              dataSend = {
                key: value,
                numData: numoffset,
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
              data = await Request.json(data);
              if (Request.status === 200) {
                if (data) {
                  if (data != 'No Records Available' && data != 'Fetching data encounted a problem' && data != 'No Records Available') {
                    let ObjectDataFrame = JSON.parse(data);
                    Template = "";
                    Template = document.querySelector('.records_table table tbody');
                    Template.innerHTML = "";
                    ObjectDataFrame = ObjectDataFrame['result'];
                    for (const key in ObjectDataFrame) {
                      id = ObjectDataFrame[key]['id'];
                      namee = ObjectDataFrame[key]['name'];
                      Start = ObjectDataFrame[key]['Start'];
                      End_date = ObjectDataFrame[key]['End_date'];
                      description = ObjectDataFrame[key]['description'];
                      Status = ObjectDataFrame[key]['Status'];
                      image = ObjectDataFrame[key]['Image'];
                      target = ObjectDataFrame[key]['target'];
                      current = ObjectDataFrame[key]['current'];
                      ObjectData = ObjectDataFrame[key]['Obj'];

                      const CloneObject = document.querySelector('.CloneSearch tr').cloneNode(true);
                      if (CloneObject != '') {
                        const ElementDivCone = document.createElement('tr');
                        ElementDivCone.classList.add('SearchItem');
                        if (Status == 'in progress') {
                          Status = "<div class='in_btn blue'><div></div>In progress</div>";
                        } else if (Status == 'complete') {
                          Status = "<div class='in_btn'><div></div>Completed</div>";
                        } else {
                          Status = "<div class='out_btn blue'><div></div>hold</div>";
                        }

                        CloneObject.querySelector('.Clonename').innerText = namee;
                        CloneObject.querySelector('.response_btn').innerHTML = Status;
                        CloneObject.querySelector('.Clonestart').innerText = Start;
                        CloneObject.querySelector('.Clonecurrent').innerText = `${current} / ${target}`;
                        CloneObject.querySelector('.Clonedescription').innerText = description;
                        CloneObject.querySelector('.Cloneend').innerText = End_date;
                        CloneObject.querySelector('.Cloneimage').setAttribute('src', `Asset/images/${image}`);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-id', id);
                        CloneObject.querySelector('.opt_element p.dp').setAttribute('data-id', id);

                        ElementDivCone.innerHTML = CloneObject.innerHTML;
                        Template.append(ElementDivCone);
                        OptionElements = document.querySelectorAll(".option");
                        const element = ElementDivCone.querySelector('.option');
                        element.addEventListener("click", function () {
                          var ElementOptions = element.querySelector(".opt_element");
                          ElementOptions.classList.add("active");
                        });
                      }
                    }




                    if (ObjectDataFrame['pages'] > 25) {
                      ConvertPages = ObjectDataFrame['pages'];
                      RestructurePages(ConvertPages);
                    }

                  }
                } else {
                  console.log("cannot find endpoint");
                }
                loader_progress.classList.remove("active");
                ContentDom.classList.remove("load");
                DomManipulationElement.classList.remove("load");
              }
            } catch (error) {
              console.error(error);
            }

          })
        }
        if (location == "Partnership") {
          var OptionElements = document.querySelectorAll(".btn_record");
          const Partnership_record = document.querySelector(".series_version");
          const AddEventMenu = document.querySelector(".event_menu_add");
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
          var FilterUI = document.querySelector(".notification_list_filter");
          var FilterUIList = document.querySelectorAll(".notification_list_filter .item");
          FilterUIList.forEach(element => {
            element.addEventListener('click', function () {
              setTimeout(() => {
                value = element.innerText;
                FilterUI.classList.remove("active");
                let DomManipulationElement;
                const route = Urlroutes[location] || Urlroutes[404];
                if (route) {
                  let request = route.template + "?type=" + value;
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
              }, 100);
            })
          });
          searchBtn.addEventListener("click", e => {
            APIDOCS =
              "../API/partnership/data_process.php?APICALL=true&&user=true&&submit=filter";
            if (searchInput.value != " " && searchInput.value != "") {
              searchSystem(APIDOCS, searchInput.value);
            }

          })



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
            <div class="option"><i class="fas fa-trash" data-cn="trash" data-id="${newObject[iletrate]["id"]
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
          const searchSystem = debounce(async (APIDOCS, value) => {
            let data;
            try {
              loader_progress.classList.add("active");
              ContentDom.classList.add("load");
              DomManipulationElement.classList.add("load");
              dn_message.querySelector("p").innerText = "...processing request";
              dataSend = {
                key: value,
                numData: numoffset,
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
              data = await Request.json(data);
              if (Request.status === 200) {
                if (data) {
                  if (data != 'No Records Available' && data != 'Fetching data encounted a problem' && data != 'No Records Available') {
                    let ObjectDataFrame = JSON.parse(data);
                    Template = "";
                    Template = document.querySelector('.records_table table tbody');
                    Template.innerHTML = "";
                    ObjectDataFrame = ObjectDataFrame['result'];
                    for (const key in ObjectDataFrame) {
                      unique_id = ObjectDataFrame[key]['UniqueId'];
                      namer = ObjectDataFrame[key]['name'];
                      Partnership = ObjectDataFrame[key]['partnership'];
                      date = ObjectDataFrame[key]['date'];
                      Email = ObjectDataFrame[key]['Email'];
                      Type = ObjectDataFrame[key]['Type'];
                      Period = ObjectDataFrame[key]['Period'];
                      statusi = ObjectDataFrame[key]['status'];
                      ObjectData = ObjectDataFrame[key]['Obj'];
                      ObjectDataIndividual = ObjectDataFrame[key]['IObj'];
                      const CloneObject = document.querySelector('.CloneSearch tr').cloneNode(true);
                      if (CloneObject != '') {
                        const ElementDivCone = document.createElement('tr');
                        ElementDivCone.classList.add('SearchItem');

                        CloneObject.querySelector('.Cloneemail').innerText = Email;
                        CloneObject.querySelector('.Clonedate').innerText = date;
                        CloneObject.querySelector('.Clonetype').innerText = Type;
                        CloneObject.querySelector('.Cloneperiod').innerText = Period;
                        CloneObject.querySelector('.Clonename').innerText = namer;
                        CloneObject.querySelector('.Cloneitem').setAttribute('data-information', ObjectDataIndividual);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-id', unique_id);
                        CloneObject.querySelector('.opt_element p.dp').setAttribute('data-id', unique_id);
                        statusClass = CloneObject.querySelector('.btn_record');
                        if (statusi == 'active') {
                          statusClass.classList.add("in_btn");
                          statusClass.innerHTML = "<div></div>Active";
                        } else {
                          statusClass.classList.add("out_btn");
                          statusClass.innerHTML = "<div></div>Inactive";
                        }
                        ElementDivCone.innerHTML = CloneObject.innerHTML;
                        Template.append(ElementDivCone);
                        OptionElements = document.querySelectorAll(".btn_record");
                        const element = ElementDivCone.querySelector('.option');
                        element.addEventListener("click", function () {
                          var ElementOptions = element.querySelector(".opt_element");
                          ElementOptions.classList.add("active");
                        });
                      }
                    }




                    if (ObjectDataFrame['pages'] > 25) {
                      ConvertPages = ObjectDataFrame['pages'];
                      RestructurePages(ConvertPages);
                    }

                  }
                } else {
                  console.log("cannot find endpoint");
                }
                loader_progress.classList.remove("active");
                ContentDom.classList.remove("load");
                DomManipulationElement.classList.remove("load");
              }
            } catch (error) {
              console.error(error);
            }

          })
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
          var FilterUI = document.querySelector(".notification_list_filter");
          var FilterUIList = document.querySelectorAll(".notification_list_filter .item");
          FilterUIList.forEach(element => {
            element.addEventListener('click', function () {
              value = element.innerText;
              FilterUI.classList.remove("active");
              let DomManipulationElement;
              const route = Urlroutes[location] || Urlroutes[404];
              if (route) {
                let request = route.template + "?yearFilter=" + value;
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
            })
          });

          window.addEventListener("click", function (e) {
            var target = e.target;
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
          SubmitForm.addEventListener("submit", async function (e) {
            ResponseView.innerText = "loading...";
            e.preventDefault();
            PHPREQUEST(APIDOCS);
          });

          SubmitSearchbutton.addEventListener("click", function (e) {
            APIDOCS = "../API/membership/data_process.php?APICALL=true&&user=true&&submit=search_file";
            if (searchInput.value != " " && searchInput.value != "") {
              searchSystem(APIDOCS, searchInput.value);
            }
          })

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
                  ResponseView.innerHTML = "";
                }
              } else {
                console.log("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }
          const searchSystem = debounce(async (APIDOCS, value) => {
            let data;
            try {
              loader_progress.classList.add("active");
              ContentDom.classList.add("load");
              DomManipulationElement.classList.add("load");
              dn_message.querySelector("p").innerText = "...processing request";
              dataSend = {
                key: value,
                numData: numoffset,
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
              data = await Request.json(data);
              if (Request.status === 200) {
                if (data) {
                  if (data != 'No Records Available' && data != 'Fetching data encounted a problem' && data != 'No Records Available') {
                    let ObjectDataFrame = JSON.parse(data);
                    Template = document.querySelector('.membership_table tbody');
                    CloneObject = document.querySelector('.CloneSearch').cloneNode(true);

                    Template.innerHTML = "";
                    ObjectDataFrame = ObjectDataFrame['result'];

                    for (const key in ObjectDataFrame) {
                      unique_id = ObjectDataFrame[key]['UniqueId'];
                      Firstname = ObjectDataFrame[key]['Firstname'];
                      Othername = ObjectDataFrame[key]['Othername'];
                      Age = ObjectDataFrame[key]['birth'];
                      Position = ObjectDataFrame[key]['Position'];
                      contact = ObjectDataFrame[key]['contact'];
                      email = ObjectDataFrame[key]['email'];
                      image = ObjectDataFrame[key]['image'];
                      Address = ObjectDataFrame[key]['Address'];
                      Baptism = ObjectDataFrame[key]['Baptism'];
                      membership_start = ObjectDataFrame[key]['membership_start'];
                      username = ObjectDataFrame[key]['username'];
                      gender = ObjectDataFrame[key]['gender'];
                      occupation = ObjectDataFrame[key]['occupation'];
                      About = ObjectDataFrame[key]['About'];
                      ObjectData = ObjectDataFrame[key]['Obj'];
                      statusr = ObjectDataFrame[key]['status'];

                      if (CloneObject != '') {
                        const ElementDivCone = document.createElement('tr');
                        CloneObject.querySelector('.Clonemeail').innerText = email;
                        CloneObject.querySelector('.Clonename').innerText = `${Firstname}   -   ${Othername} `;
                        CloneObject.querySelector('.Cloneage').innerText = Age;
                        CloneObject.querySelector('.Cloneimage').setAttribute('src', `../API/Images_folder/users/${image}`);
                        CloneObject.querySelector('.Clonegender').innerText = gender;
                        CloneObject.querySelector('.Cloneaddress').innerText = Address;
                        CloneObject.querySelector('.Clonegender').innerText = gender;
                        CloneObject.querySelector('.Clonebaptism').innerText = Baptism;
                        CloneObject.querySelector('.Cloneoccupation').innerText = occupation;
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-id', unique_id);
                        CloneObject.querySelector('.opt_element p.dp').setAttribute('data-id', unique_id);
                        ElementDivCone.innerHTML = CloneObject.innerHTML;
                        Template.append(ElementDivCone);
                        OptionElements = document.querySelectorAll(".option");
                        const element = ElementDivCone.querySelector('.option');
                        console.log(ElementDivCone);
                        element.addEventListener("click", function () {
                          var ElementOptions = element.querySelector(".opt_element");
                          ElementOptions.classList.add("active");
                        });
                      }


                    }
                    if (ObjectDataFrame['pages'] > 25) {
                      ConvertPages = ObjectDataFrame['pages'];
                      RestructurePages(ConvertPages);
                    }
                  }
                }
              } else {
                console.log("cannot find endpoint");
              }
              loader_progress.classList.remove("active");
              ContentDom.classList.remove("load");
              DomManipulationElement.classList.remove("load");
            } catch (error) {
              console.error(error);
            }
          })

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
  function ExportData(type,data,filename){
    var downloadLink = document.createElement("a");
    if(type == 'word'){
      var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
    var postHtml = "</body></html>";
    var html = preHtml+data+postHtml;
    var blob = new Blob(['\ufeff', html], {
        type: 'application/msword'
    });    
    var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
    filename = filename+'.doc';
    document.body.appendChild(downloadLink);
    if(navigator.msSaveOrOpenBlob ){
        navigator.msSaveOrOpenBlob(blob, filename);
    }else{
        downloadLink.hidden = true;
        downloadLink.href = url;
        downloadLink.download = filename;
        downloadLink.click();
    }
  }
    if(type == "excel"){

    }
    if(type =='pdf'){

    }
    document.body.removeChild(downloadLink);
  }
  function UrlTrace() {
    let DomManipulationElement;
    location = window.location.hash.replace("#", "");
    if (location == 'Finance') {
      document.querySelector("li.expand").classList.add("active");
      document.querySelector("li.expand .tabs a").classList.add('active');
    }
    SearchOutList = ['Access_token', 'Transaction', 'Budget', 'Expenses', 'Assets', 'FinanceAccount', 'records', 'Department', 'History', 'calender'];
    if (SearchOutList.includes(location)) {
      NavigationBar.classList.add('search_out')
    } else {
      if (NavigationBar.classList.contains('search_out')) {
        NavigationBar.classList.remove('search_out')
      }
    }

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
        console.log(element);
        clearance = false;
      }
    });

    console.log(clearance);
    return clearance;
  }
  function RestructurePages(number) {
    let num = 1;
    let Cclass = "";
    total = Math.ceil(number / 25);
    const Pages = document.querySelector(".page_sys .pages");
    Pages.innerHTML = "";
    loop = total;
    start = num;
    if (total > 1) {
      if (parseInt(num) >= 6) {
        if (total - 6 > num) {
          if (parseInt(num) <= parseInt(total)) {
            loop = 6 + 6 * Math.round(num / 6);
            start = 6 * Math.round(num / 6);
          }
        } else {
          loop = total;
          start = loop - 6;
        }
      }
    }
    for (i = start; i < loop; i++) {
      if (i == currentPageNum) {
        Cclass = 'active';
        Pages.innerHTML += `<div class="${Cclass}">${i}</div>`;
      } else
        if (num < total) {
          Pages.innerHTML += `<div>${i}</div>`;
        }
      Cclass = '';
    }

    if (loop >= 6 && num <= (total - 11)) {
      Pages.innerHTML += `<span>......</span><div class="${Cclass}">${Math.round(total)}</div>`;
    } else {
      if (total == currentPageNum) {
        Cclass = 'active';
      }
      Pages.innerHTML += `<div class="${Cclass}">${total}</div>`;
    }
  }
  async function pagnationSystem(value) {
    const rootElement = document.documentElement;
    rootElement.scrollTo({
      top: 40,
      behavior: "smooth",
    });
    let DomManipulationElement;
    const route = Urlroutes[location] || Urlroutes[404];
    if (route) {
      request = route.template + "?page=" + value;
      if (SearchTrigger) {
        if (location == "Transaction") {
          if (value > 1) {
            numoffset = value - 1;
          } else {
            numoffset = value;
          }
          currentPageNum = value;
          document.querySelector(".List_filter").click();
          request = false;
        } else {
          if (searchInput.value != "" && searchInput.value != " ") {
            request = route.template + "?search=" + searchInput.value + "&&page=" + value;
          } else {
            request = false;
          }
        }

      }
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
  function debounce(cb, delay = 1000) {
    let timeout

    return (...args) => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        cb(...args)
      }, delay)
    }
  }
});
