define(["jQuery", "xlsx", "Access", "projects", "finance", "calender", "slick", "transaction", "Expenses", "Tithe", "resumable", "intlTelInput"], function (
  jQuery,
  XLSX,
  timer,
  projects,
  Finance,
  Ca_data,
  slick,
  transactions,
  Expenses,
  TitheCall,
  resumable,
  intlTelInput
  // emailjs
) {
  //   if ('serviceWorker' in navigator) {
  //     window.addEventListener('load', () => {
  //         navigator.serviceWorker
  //             .register('script/service-worker.js')
  //             .then((reg) => console.error('Service Worker: Registered (Scope: ' + reg.scope + ')'))
  //             .catch((err) => console.error('Service Worker: Error:', err));
  //     });
  // }
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
  const get_current_date = document.querySelector(".get_current_date");
  const BatchPlatform = document.querySelector('.data_upload_platform');
  const BatchSelect = document.querySelector('#batch_file');
  const LogOutButton = document.querySelector("#LogOut");
  var MainFormDel = "";
  var formDataDel = "";
  let SearchTrigger = false;
  let DomManipulationElement;
  let validateKey = "";
  let ConvertPages = 0;
  let numoffset = 0;
  let currentPageNum = 1;
  var location;
  let APIDOCS = "";
  let requestData;
  let ElementEngage = "";
  let newObject;
  let currentPhase = false;
  let calendaDate = false;
  // (function () {
  //   // https://dashboard.emailjs.com/admin/account
  //   emailjs.init({
  //     publicKey: "RtfFLq0ZUtE5gn-AE",
  //   });
  // })();
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
      template: "../error404",
      title: "404 | page not found",
      description: "404 page directions",
    },
    "/": {
      template: "home.php",
      title: "404 | page not found",
      description: "404 page directions",
    },
    Membership: {
      template: "Membership/membership.php",
      title: "Membership screen | Router sequence",
      description: "hero",
    },
    Library: {
      template: "library/library.php",
      title: "Library screen | Router sequence",
      description: "hero",
    },
    Finance: {
      template: "finance/finance_h.php",
      title: "Library screen | Router sequence",
      description: "hero",
    },
    Dashboard: {
      template: "Dashboard.html",
      title: "Homepage screen | Router sequence",
      description: "hero",
    },
    Gallery: {
      template: "gallery/gallery.php",
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
    History: {
      template: "History/history.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    FinanceAccount: {
      template: "finance/finance_account.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Tithe: {
      template: "finance/finance_tithe.php",
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
      template: "finance/transactions.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Expenses: {
      template: "finance/Expenses.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Budget: {
      template: "finance/Budget.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    records: {
      template: "records/records.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    Announcement: {
      template: "announcement.php",
      title: "project | All uploaded projects are currently being tracked",
      description: "hero",
    },
    calender: {
      template: "calender.php",
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
      });
    if (html) {
      document.querySelector(".content_main").innerHTML = html;
      ResetUrl();
    }

    try {
      if (!loader_status) {
        document.querySelectorAll('.itemView').forEach(element => {
          element.classList.remove('b_view');
        });

        if (document.querySelector('.location_date')) {
          document.querySelector('.location_date').innerText = location;
        }

        if (location == '/' || location == "") {
          var _seed = 42;
          Math.random = function () {
            _seed = _seed * 16807 % 2147483647;
            return (_seed - 1) / 2147483646;
          };
          titheData = JSON.parse(document.querySelector('#chartData').innerText);
          if (titheData) {
            titheData_num = [];
            for (const key in titheData) {

              const element = titheData[key];
              titheData_num.push(element[0]);

            }
            var options = {
              series: [{
                name: "Desktops",
                data: titheData_num
              }],
              chart: {
                height: 290,
                type: 'line',
                zoom: {
                  enabled: false
                }
              },
              dataLabels: {
                enabled: false
              },
              stroke: {
                curve: 'straight'
              },
              title: {
                text: 'Tithe payment Trends by Month',
                align: 'left',
                fill: '#000'
              },
              grid: {
                row: {
                  colors: ['#f3f3f3', 'transparent'],
                  opacity: 0.5
                },
              },
              xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
              }
            };
            var chart = new ApexCharts(document.querySelector("#charts_data"), options);
            chart.render();
          }
          $("#sliderMain")
            .slick({
              autoplay: false,
              speed: 800,
              lazyload: "progressive",
              arrows: false,
              dots: false,
              autoplay: true,
              // variableWidth: true,
              responsive: [
                {
                  breakpoint: 992,
                  settings: {
                    dots: true,
                    arrows: false,
                  },
                },
              ],
            })

        }
        //all clear
        if (location == "Access_token") {
          const Access_mainDiv = document.querySelector(".timer_set");
          const Access_HourEle = Access_mainDiv.querySelector(".hour");
          const Access_MinuteEle = Access_mainDiv.querySelector(".min");
          const Access_SecondEle = Access_mainDiv.querySelector(".second");
          const Access_value_set = document.querySelector("#value_data_set");
          const Access_pemChecker = document.querySelector(".permChecker");
          const Access_Current_Data = new Date();
          const Access_CurentNow = Access_Current_Data.getTime();
          async function Access_ConfirmAssign() {
            if (location_updator() == "Access_token") {
              if (confirm("Are you sure you want to assign this password")) {
                try {
                  Access_APIDOCS = "../../API/notifications & token & history/data_process.php?APICALL=true&&user=true&&submit=settoken";
                  dataSend = {
                    duration: Access_CurentNow,
                    code: document.querySelector(".tokenData .data_main").innerText,
                  };
                  const Request = await fetch(Access_APIDOCS, {
                    method: "POST",
                    body: JSON.stringify(dataSend),
                    headers: {
                      "Content-Type": "application/json",
                    },
                  });

                  if (Request.status === 200) {
                    let Access_data = await Request.json(dataSend);
                    if (Access_data) {
                      const Access_Fetchresult = Access_data;
                      Access_result = Access_Fetchresult.replace(/"/g, '');
                      if (Access_result == "success") {
                        const Access_timerSet = document.querySelector(".token");
                        const Access_TokenHeader = document.querySelector(".access_token header");
                        Access_timerSet.classList.add("active");
                        Access_TokenHeader.innerText = `Security Code has been activated code.
                      Instruct users to use this code as passkey to access limited Admin features `;
                        document.querySelector(".token button").classList.add('hide');
                      }
                    }
                  } else {
                    console.error("cannot find endpoint");
                  }
                } catch (error) {
                  console.error(error);
                }
              }
            }
          }

          if (Access_value_set.value != "empty" || Access_value_set.value != "expired") {
            Access_OriginalValue = Access_value_set.value;
            timer.IntervalSet(Access_HourEle, Access_MinuteEle, Access_SecondEle, Access_OriginalValue);
          }
          if (Access_value_set.value == "empty" || Access_value_set.value == "expired") {
            document.querySelector(".token button").addEventListener("click", function () {
              timer.generateToken();
              setTimeout(() => {
                Access_ConfirmAssign();
              }, 500);
            });
          }
          const Access_CopyMain = document.querySelector(".tokenData .copyt");
          const Access_CopyMainValue = document.querySelector(".tokenData .data_main");
          Access_CopyMain.addEventListener('click', function () {
            Access_value = Access_CopyMainValue.innerHTML;
            navigator.clipboard.writeText(Access_CopyMainValue.innerText).then((result) => {
              alert('Key has been copied to your clipboard');
            }).catch((error) => {
              alert('failed to copy to clipboard');
            })
          })
        }
        if (location == "calender") {
          let CalendaMediaFilenames = [];
          let Update_trigger = false;
          const TabsMenu = document.querySelectorAll(".menu_tab");
          const CategoryMenu = document.querySelector(".event_category");
          const AddBtn = document.querySelector(".plus_arrow");
          const AddMenu = document.querySelector(".new_event_menu");
          const ViewElements = document.querySelector(".grid_space");
          const SaveDetails = document.querySelector("#save_details");
          const selectors = document.querySelectorAll(".wrapper_selectors");
          const formData = document.querySelector("#formData");
          const calenderData = document.querySelector("#calender_data");
          const CurrentDay = document.querySelector(".day_event .day_info");
          const Calender_Data = document.querySelector("#calender_data");
          const YearListElem = document.querySelector(".year_list");
          var CalendaList = document.querySelectorAll(".min_data.event_days div");
          var CalendaListMonth = document.querySelectorAll(".view.month_view div.view_main div");
          const selectorOptions = document.querySelectorAll(".items_selector .VKy0Ic");
          const functionSelector = document.querySelector(".function.selector p.start_time_p");
          const functionSelectorEnd = document.querySelector(".function.selector p.End_time_p");
          const UpdateDetails = document.querySelector("#Update_details");
          const MonthSelector = document.querySelectorAll(".month_view .view_main div");
          const DaySelector = document.querySelectorAll(".min_calenda div span");
          const MenuDate = document.querySelector(".menu_date");
          const YearList = document.querySelector(".year_choose");
          const MenuArrowLeft = document.querySelector(".add_menu .left_arrow");
          const MenuArrowRight = document.querySelector(".add_menu .right_arrow");
          const YearButton = document.querySelector(".year button");
          const MonthSelectorElement = document.querySelector(".month_selector");
          const HeaderSelector = document.querySelectorAll("strong[data-id]");
          const MenuData = document.querySelector(".menu_date header");
          const DayInfo = document.querySelector(".day_info");
          const SchedulesData = document.querySelector(".main_schedule");
          const loaderBtn = document.querySelector('.loader_wrapper');
          formData.addEventListener("submit", function (e) {
            e.preventDefault();
          });
          let validateKey = "";
          DataCalenderObj = JSON.parse(calenderData.value);
          let currentSpan = "";
          let ActiveTime = 0;
          let DateFetch = new Date();
          let year = DateFetch.getFullYear();
          let month = DateFetch.getMonth();
          let Current = DateFetch.getDate();
          let Current_Day = DateFetch.getDay();
          let DetectYear = true;
          let Time_position = "";
          let Left_position = "";
          let last = 1;
          let weekObj = [];
          let weekObjTemp = [];
          let ResizeOrigin = false;
          let UpdateSession = "";
          let DayVal = "";
          let YItem = year;
          let FilterMonth = false;
          let FilterYear = year;
          let tempMonth = false;
          let tempYear = false;
          let firstVal = "";
          let workingMonth = DateFetch.getMonth();
          let stringData = "upload";
          let AutoCall = false;

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
            if (year % 4 == 0) {
              if ((year % 100) % 4 == 0) {
                if ((year % 400) % 4 == 0) {
                  return true
                }
              }
            }
            return false

          };
          getFebDays = (year) => {
            return isLeapYear(year) ? 29 : 28;
          };
          var DaysOfMonth = [
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
          let WorkingMax = DaysOfMonth[workingMonth];
          let DaysLater = ["Sun", "Mon", "Tue", "Wed", "Thurs", "Fri", "Sat"];

          if (location_updator() == "calender") {
            r.assignBrowse(document.getElementById('browseButton'));
            r.on('filesAdded', function (array) {
              document.querySelector('#browseButton span').textContent = `${r.files.length} file has been added`;
            });
            document.getElementById('browseButton').addEventListener('click', function () {
              r.cancel();
            });
          }

          CurrentDay.querySelector("header").innerText = Current;
          CurrentDay.querySelector("p").innerText = `${DaysLater[Current_Day]} , ${Current} ${monthNames[month]} , ${year} `;
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
                document.querySelector(".month_selector .year header").innerText = element.innerHTML;

                YearListElem.classList.remove("active");
                if (!isNaN(element.innerHTML)) {
                  FilterYear = parseInt(element.innerHTML);
                  DetectYear = parseInt(element.innerHTML);
                }
              }
            });
          });
          const MonthListChildren = document.querySelectorAll(".month_selector .view div");
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
          const FilterBtn = document.querySelector(".month_selector .year button");
          FilterBtn.addEventListener("click", function () {
            filterStatus = true;
            YearSet = year;
            MonthSet = 0;
            if (typeof DetectYear != 'boolean') {
              YearSet = DetectYear;
            }
            if (typeof FilterMonth != 'boolean') {
              MonthSet = FilterMonth - 1;
            }
            workingMonth = MonthSet;
            year = YearSet;
            direction = 'none';
            MenuData.innerHTML = `${monthNames[FilterMonth]} ${YearSet}`;
            try {
              Ca_data.calender(MonthSet, YearSet, 1, "wor;d");
              getWeeks(MonthSet, YearSet, 1);
              setMonthData();
              AutoCall = true
            } catch (error) {
              console.error(error);
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
          Ca_data.calender(month, year, Current);
          function ResizeElement(val, origin) {
            try {
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
              console.error(error);
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
            Update_trigger = true;
          });
          async function weekDataSet(stringData) {
            element = currentSpan;
            loaderBtn.classList.add('play');
            loaderBtn.classList.remove('active');
            try {
              let Notice = await PHPREQUEST(stringData);
              loaderBtn.classList.remove('play');
              loaderBtn.classList.add('active');
              loaderBtn.querySelector('.text p').textContent = Notice;
              Notice = Notice.toLowerCase();
              if (Notice.includes('success')) {
                r.cancel();
                setTimeout(() => {
                  UrlTrace();
                }, 900);
              }

            } catch (error) {
              console.log(error)
              alert("An error occurred please start the process again");
            }
            loaderBtn.classList.remove('play');
            loaderBtn.classList.add('active');
          }
          function loadRegistry() {
            const FormScroll = document.querySelector('.new_event_menu .main');
            FormScroll.scrollTo({
              top: 0,
              behavior: 'smooth'
            })
            if (weekDataSet(stringData) == 'success') {
              if (currentSpan) {
                currentSpan = 0;
              }
            }
          }
          SaveDetails.addEventListener("click", function () {
            acceptedExtension = ['jpg', 'png', 'jpeg'];
            permission = true;
            if (Update_trigger && r.files.length == 0) {
              loadRegistry()
            } else {
              if (r.files.length > 0) {
                if (r.files.length > 1) {
                  loaderBtn.classList.add('active');
                  loaderBtn.querySelector('.text p').textContent = "You can only upload a single file during update";
                }
                r.files.forEach(element => {
                  if (acceptedExtension.includes(element.file.name.split('.')[1])) {
                    CalendaMediaFilenames.push(element.file.name);
                  } else {
                    permission = false;
                  }
                })
              } else {
                loadRegistry();
              }

              if (permission) {
                if (CalendaMediaFilenames.length > 0) {
                  if (CalendaMediaFilenames.length > 1 && Update_trigger) {
                    loaderBtn.classList.add('active');
                    loaderBtn.querySelector('.text p').textContent = "You can only upload a single file during update";
                  } else {
                    loaderBtn.classList.add('play');
                    loaderBtn.classList.remove('active');
                    const FormScroll = document.querySelector('.new_event_menu .main');
                    FormScroll.scrollTo({
                      top: 0,
                      behavior: 'smooth'
                    })

                    r.upload();
                    r.on('complete', function () {
                      loadRegistry();
                    });
                  }

                }
              } else {
                loaderBtn.classList.add('active');
                loaderBtn.querySelector('.text p').textContent = "Files accepted should have either JPG,PNG,JPEG";
              }
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
            loaderBtn.querySelector('.text p').textContent = "";
            document.querySelector('#browseButton span').textContent = "Select file to Upload";
          });
          TabsMenu.forEach((element) => {
            element.addEventListener("click", () => {
              changeTabMenu(element.id);
            });
          });
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
                CalculateVal = 6 - value;
                ConVal = CalculateVal + 1;
                t_total = value + 1;
                for (let i = 1; i < t_total; i++) {
                  figureCondition = day - i;
                  figure = day - (t_total - i);
                  if (figureCondition <= 0) {
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
                for (let i = 1; i < ConVal; i++) {
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


              }
              ;
              last = weekObj[weekObj.length - 1];
              firstVal = weekObj[0];
              if (weekObj.includes(day)) {
                ;
                DisplayWeekResult(weekObj);
              } else {
                weekObj = [];
                getWeeks(month, year, day);
              }
            }
            weekObj = [];
          }
          function getNextWeek(year_t, month_t, day) {
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

            if (typeof DetectYear != 'boolean') {
              year = DetectYear;
            }
            if (direction == false) {
              if (weekObjTemp.includes(1)) {
                if (workingMonth - 1 < 0) {
                  workingMonth = 11;
                  year--;
                  DaysOfMonth[1] = getFebDays(year);
                  if (typeof DetectYear != 'boolean') {
                    DetectYear--;
                  }
                } else {
                  workingMonth--;
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
            monthNamesRecord = monthNames[workingMonth];
            WorkingMax = DaysOfMonth[workingMonth];


            MenuData.innerHTML = `${monthNamesRecord} ${year}`;
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
                element.setAttribute('data_year', element.querySelector("span").getAttribute('data_year'));
                element.setAttribute('data_month', monthNames[parseInt(element.querySelector("span").getAttribute('data_month'))]);
                element.setAttribute('data_day', DAYSData[i]);
                weekDataDisplay(element.querySelector("span").getAttribute('data_year'), element.querySelector("span").getAttribute('data_month'), element_main, Index);
              }

            });
            weekObjTemp = weekObj;

            calendaDate = `${workingMonth} -${year}  - ${weekObjTemp[0]}`;
            if (direction == true) {
              if (weekObj.includes(WorkingMax)) {
                if (workingMonth + 1 >= 12) {
                  workingMonth = 0;
                  year++;
                  DaysOfMonth[1] = getFebDays(year);
                  if (typeof DetectYear != 'boolean') {
                    DetectYear++;
                  }
                } else {
                  workingMonth++;

                }
              }
            }

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


                          console.error(ZoneDivide, ZoneDivideEnd);

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
                          let JsonElement = JSON.stringify(element);
                          classdata = "";
                          imageClass = "";
                          if (element["image"] != "" || element["image"] != '') {
                            classdata = "image";
                            imageClass = "--image: url('../../../API/images/calenda/" + element["image"] + "');";
                          }

                          template = `<div class="data-details ${classdata}"  style="${imageClass}">
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
              console.error("An error occurred pls start the process again", error);
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
              console.error(error)
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
              console.error(error)
            }
          }

          selectors.forEach((element) => {
            element.addEventListener("click", function () {
              try {
                const ElementNext = element;
                if (ElementNext) {
                  ElementNext.classList.toggle("active");
                  if (element.getAttribute("data-origin") == "start") {
                    ResizeOrigin = true;
                  } else if (element.getAttribute("data-origin") == "end") {
                    ResizeOrigin = false;
                  }
                  selectors.forEach((elementR) => {
                    if (element != elementR) {
                      const ElementNext = elementR;
                      if (ElementNext) {
                        ElementNext.classList.remove("active");
                      }
                    }
                  });
                }
              } catch (error) {
                console.error(error);
              }
            });
          });
          window.addEventListener("click", function (e) {
            try {
              if (location_updator() == "calender") {
                const HeaderSelector = document.querySelectorAll("strong[data-id]");
                const ColorPicker_palette = document.querySelector(".colorlist");
                var CalendaList = document.querySelectorAll(".min_data.event_days div");
                const target = e.target;
                if (!AddMenu.contains(target) && AddMenu.classList.contains('active') && currentSpan && currentSpan.classList.contains('event_record') && currentSpan.classList.contains('active')) {
                  AddMenu.classList.remove('active');
                  currentSpan = "";
                } else {
                  CalendaList.forEach(element => {
                    if (element.contains(target)) {
                      if (element.hasAttribute('title')) {
                        year = element.getAttribute('data_year');
                        month = element.getAttribute('data_month');
                        day = element.getAttribute('data_Day');
                        FetchData(year, month, day);
                        loaderBtn.querySelector('.text p').textContent = "";
                        Update_trigger = false;
                        r.cancel();
                      }
                    }
                  });

                  if (target.tagName == "I") {
                    if (target.hasAttribute("data-ical")) {
                      if (target.getAttribute("data-ical") == "update") {
                        if (target.getAttribute("data-info")) {
                          let BronzeElement = target.parentElement.parentElement.parentElement.parentElement;
                          currentSpan = target.parentElement.parentElement.parentElement;
                          console.log(currentSpan);
                          if (!currentSpan.classList.contains('event_record')) {
                            PositionMenu(BronzeElement, e);
                          }


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
                  } else if (SchedulesData.contains(target)) {
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
              }
            } catch (error) {
              console.error(error)
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
              console.error(error);
            }
          }
          function changeTabMenu(tabOrder) {
            try {
              currentPhase = tabOrder;
              if (tabOrder != false) {
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
                      console.log(element_check);
                    }
                  });
                  if (element.id == tabOrder) {
                    element.classList.add("active");
                    console.log(element);
                  }
                });
              }
            } catch (error) {
              console.error(error)
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
              APIDOCS = "../../API/partnership/data_process.php?APICALL=true&&user=true&&submit=update_file";
              AddMenu.classList.add('active');
              Update_trigger = true;
            }
          }
          async function DeleteItemFunction(value) {
            try {
              if (value == "true" && validateKey) {
                let API =
                  "../../API/calender/data_process.php?APICALL=true&&user=true&&submit=delete";
                let Response = await PHPREQUESTDEL(API, validateKey);
                dn_message.querySelector('p').innerText = Response;
                if (Response == 'success') {
                  currentSpan.classList.remove('active');
                }
              }
            } catch (error) {
              console.error(error)
            }
          }

          async function PHPREQUEST(value) {
            try {
              let TargetData = false;
              let IndexData = 'false';
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
                if (IndexData != 'false') {
                  TargetData = HeaderSelector[IndexData].querySelector('span');
                  if (TargetData.hasAttribute('data_year') && TargetData.hasAttribute('data_month')) {
                    year = parseInt(TargetData.getAttribute('data_year'));
                    month = parseInt(TargetData.getAttribute('data_month'));
                    DayVal = parseInt(TargetData.innerText);
                    let APIDOCS;
                    if (value == "update") {
                      APIDOCS =
                        "../../API/calender/data_process.php?APICALL=true&&user=true&&submit=update";
                    } else if (value == "upload") {
                      APIDOCS =
                        "../../API/calender/data_process.php?APICALL=true&&user=true&&submit=upload";
                    }

                    let data;
                    const formMain = new FormData(formData);
                    formMain.append('fileNames', JSON.stringify(CalendaMediaFilenames));
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
                console.error("cannot find endpoint");
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
          function setMonthData() {
            var CalendaList = document.querySelectorAll(".min_data.event_days div");
            var CalendaListMonth = document.querySelectorAll(".view.month_view div.view_main div");

            CalendaList.forEach((element) => {
              Checker = DataCheckList(
                year,
                workingMonth,
                element.querySelector("p").innerText,
                element
              );
              element.addEventListener('click', function () {
                FetchData(year, workingMonth, element.innerText);
              })
            });
            CalendaListMonth.forEach((element) => {
              var data_list = element.querySelector('.data_list');
              if (!data_list) {
                data_list = "";
              }
              Checker = DataCheckList(
                year,
                workingMonth,
                element.innerText,
                data_list
              );


            });
          }
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
                  // if (data_list != '') {
                  //   main = data_list;
                  // } else {
                  //   main = div;
                  // }
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

                  div.setAttribute('data_day', element["Day"]);
                  div.setAttribute('data_year', element["Year"]);
                  div.setAttribute('data_month', (element["Month"]));

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
            DayDiv.innerHTML = "";
            Schedules.innerHTML = "";
            if (JSON.parse(data)) {
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

          if (calendaDate != "") {
            calendaDate = calendaDate.split('-');
            if (calendaDate.length == 3) {
              getWeeks(calendaDate[0], calendaDate[1] + 1, calendaDate[2]);
            } else {
              getWeeks(month, year, Current);
            }

          } else {
            getWeeks(month, year, Current);

          }
          FetchData(year, month, Current);
          setMonthData();
          changeTabMenu(currentPhase);

        }
        //all clear
        if (location == "Appearance") {
          let Appearance_themeId = 0;
          let appearance_themeData = 0;
          var appearance_Switch_interface = document.querySelector(".switch_theme");
          const appearance_toggleModes = document.querySelectorAll(".toggle_mode");
          var ThemesBtn = appearance_Switch_interface.querySelectorAll(".btn_confirm");
          async function Appearance_ConfirmAssign(id, element) {
            if (location_updator() == "Appearance") {
              try {
                Appearance_APIDOCS = "../../API/notifications & token & history/data_process.php?APICALL=true&&user=true&&submit=theme";
                dataSend = {
                  key: id,
                };

                const Request = await fetch(Appearance_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  let data = await Request.json(dataSend);
                  if (data) {
                    if (data == "success") {
                      element.classList.toggle("active");
                      appearance_toggleModes.forEach((element_r) => {
                        if (element_r != element) {
                          element_r.classList.remove("active");
                        }
                      });
                    }
                  }
                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          ThemesBtn.forEach((element) => {
            element.addEventListener("click", function () {
              if (element.getAttribute("data-confirm") == "true") {

                Appearance_ConfirmAssign(Appearance_themeId, appearance_themeData);
              }
              appearance_Switch_interface.classList.remove("active");
            });
          });

          appearance_toggleModes.forEach((element) => {
            element.addEventListener("click", function () {
              Appearance_themeId = element.getAttribute("data-id");
              appearance_themeData = element;
              appearance_Switch_interface.classList.add("active");
            });
          });
        }
        if (location == "Finance") {
          finance_ActivityMenu = true;
          let Finance_APIDOCS;
          let requestData;
          let Finance_validateKey = false;
          let Finance_numoffset = 0;
          const Finance_AddEventBtn = document.querySelector(".add_event");
          const Finance_AddEventMenu = document.querySelector(".event_menu_add.main");
          const Finance_AddEventMenu_off = document.querySelector(".event_menu_add");
          const Finance_loader_View = document.querySelector(".info_information.event_menu_add");
          var Finance_OptionElements = document.querySelectorAll(".option");
          const Finance_tabs_offertory = document.querySelector(".offertory_itenary");
          const Finance_slider_menu = document.querySelector(".slider_menu");
          const Finance_Event_tab = document.querySelector(".home_event_itenary");
          const Finance_NavigationFilter = document.querySelector(".options .Filter");
          const Finance_Export_variables = document.querySelector('#ExportBtn');
          const Finance_Export_variables_Dialogue = document.querySelector('.export_dialogue');
          const Finance_Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
          const Finance_Export_variables_Dialogue_Form = Finance_Export_variables_Dialogue.querySelector("form");
          const Finance_List_filter = document.querySelector(".List_filter");
          const Finance_GeneralFilter = document.querySelector('.options .item_opt.filterBtn');
          const Finance_dn_message = document.querySelector(".dn_message");
          const Finance_confirmsBtns = document.querySelectorAll(".btn_confirm");
          const Finance_AddEventMenu_Btn = document.querySelector(".event_menu_add.main Button");
          const Finance_AddEventMenu_off_Btn = document.querySelector(".event_menu_add Button");
          const FilterOptionsFunList = document.querySelector(".notification_list_filter");
          const Finance_NavigationFilterList = document.querySelectorAll(".notification_Finance_list_filter .item");
          const Finance_AddEventMenuForm = Finance_AddEventMenu.querySelector("form");
          const Finance_AddEventMenu_offForm = Finance_AddEventMenu_off.querySelector("form");

          document.querySelectorAll('.itemView').forEach(element => {
            element.classList.add('b_view');
          });
          Finance_List_filter.addEventListener("click", function () {
            Finance_APIDOCS = "../../API/finance/data_process.php?APICALL=true&&user=offertory&&submit=filter";
            Finance_PHPREQUESTFILTER(Finance_APIDOCS);
          });
          Finance_AddEventMenuForm.addEventListener("submit", function (e) {
            e.preventDefault();
          });
          Finance_AddEventMenu_offForm.addEventListener("submit", function (e) {
            e.preventDefault();
          });

          Finance_Export_variables.onclick = function () {
            Finance_Export_variables_Dialogue.classList.add("active");
          };
          Finance_Export_variables_Dialogue_Btn.addEventListener('click', async function () {

            Finance_APIDOCS = "";
            Finance_name = 'default';
            if (finance_ActivityMenu == false) {
              Finance_name = 'offertory records'
              Finance_APIDOCS = "../../API/finance/data_process.php?APICALL=true&&user=offertory&&submit=export";
            } else {
              Finance_name = 'dues and contributions records'
              Finance_APIDOCS = "../../API/finance/data_process.php?APICALL=true&&user=true&&submit=export";
            }
            ExportData(Finance_name, 'excel', Finance_APIDOCS)

          })

          Finance_NavigationFilter.addEventListener("click", function (e) {
            document.querySelector(".notification_list_filter").classList.toggle("active");
          });

          Finance_NavigationFilterList.forEach((element) => {
            element.addEventListener("click", function () {
              Finance.FilterSystem(
                element.getAttribute("data-filter"),
                finance_ActivityMenu
              );
            });
          });

          Finance_confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (Finance_validateKey != "") {
                  DeleteItemFunction(element.getAttribute("data-confirm"));

                }
              }

            });
          });

          searchBtn.addEventListener("click", e => {
            Finance_APIDOCS;
            if (finance_ActivityMenu == false) {
              Finance_APIDOCS =
                "../../API/finance/data_process.php?APICALL=true&&user=offertory&&submit=search";
            } else {
              Finance_APIDOCS =
                "../../API/finance/data_process.php?APICALL=true&&user=true&&submit=search";
            }
            if (searchInput.value != " " && searchInput.value != "") {
              Finance_searchSystem(Finance_APIDOCS, searchInput.value);
            }

          })
          Finance_AddEventMenu_Btn.addEventListener("click", function () {
            var Finance_loaderBtn = Finance_AddEventMenu.querySelector(".loader_wrapper");
            var Finance_formConditions = Finance_AddEventMenu.querySelectorAll(".form_condition");
            if (ConditionFeilds(Finance_formConditions) != false) {
              Finance_PHPREQUEST(Finance_APIDOCS, Finance_AddEventMenuForm, Finance_loaderBtn);
            } else {
              Finance_loaderBtn.classList.add('active');
              Finance_loaderBtn.querySelector('.text p').textContent = "All Fields Required !!";
            }
          });
          Finance_AddEventMenu_off_Btn.addEventListener("click", function () {
            var Finance_loaderBtn = Finance_AddEventMenu_off.querySelector(".loader_wrapper");
            Finance_loaderBtn.classList.add("active");
            var Finance_formConditions = Finance_AddEventMenu_off.querySelectorAll(".form_condition");
            if (ConditionFeilds(Finance_formConditions) != false) {
              Finance_PHPREQUEST(Finance_APIDOCS, Finance_AddEventMenu_offForm, Finance_loaderBtn);
            }
          });
          Finance_AddEventBtn.onclick = function () {
            if (finance_ActivityMenu) {
              Finance_AddEventMenu.classList.add("active");
              Finance_APIDOCS = "../../API/finance/data_process.php?APICALL=true&&user=true&&submit=upload";
            } else {
              Finance_AddEventMenu_off.classList.add("active");
              Finance_APIDOCS = "../../API/finance/data_process.php?APICALL=true&&user=offertory&&submit=upload";
            }
            Finance_validateKey = false;
          };
          Finance_Event_tab.onclick = function () {
            ResetUrl()
            Finance_slider_menu.classList.remove("active");
            if (NavigationBar.classList.contains('search_out')) {
              NavigationBar.classList.remove('search_out');
              Finance_GeneralFilter.classList.remove('null');
              Finance_Event_tab.classList.add('active');
              Finance_tabs_offertory.classList.remove("active");
            }
            finance_ActivityMenu = true;
            Finance_validateKey = false;
          };

          Finance_tabs_offertory.onclick = function () {
            ResetUrl()
            Finance_slider_menu.classList.add("active");
            NavigationBar.classList.add('search_out');
            Finance_GeneralFilter.classList.add('null');
            Finance_Event_tab.classList.remove('active');
            Finance_tabs_offertory.classList.add("active");
            finance_ActivityMenu = false;
            Finance_validateKey = false;

          };

          window.addEventListener("click", function (e) {
            if (location_updator() == "Finance") {
              var Finance_target = e.target;
              if (
                !Finance_NavigationFilter.contains(Finance_target) &&
                !FilterOptionsFunList.contains(Finance_target)
              ) {
                if (FilterOptionsFunList.classList.contains("active")) {
                  FilterOptionsFunList.classList.remove("active");
                }
              }
              if ((Finance_AddEventMenu_off.classList.contains("active") &&
                !Finance_AddEventBtn.contains(Finance_target)) ||
                (Finance_AddEventMenu.classList.contains("active") &&
                  !Finance_AddEventBtn.contains(Finance_target))
              ) {
                if (
                  !Finance_AddEventMenu.contains(Finance_target) &&
                  !Finance_AddEventMenu_off.contains(Finance_target)
                ) {
                  Finance_AddEventMenu.classList.remove("active");
                  Finance_AddEventMenu_off.classList.remove("active");
                  const Finance_Loaders = document.querySelectorAll('.loader_wrapper');
                  Finance_Loaders.forEach(element => {
                    if (element.classList.contains('active')) {
                      element.querySelector('.text p').textContent = "";
                    }
                  });
                }
              }

              if (!Finance_Export_variables_Dialogue.contains(Finance_target) &&
                !Finance_Export_variables.contains(Finance_target)) {
                Finance_Export_variables_Dialogue.classList.remove("active");
              }

              Finance_OptionElements = document.querySelectorAll(".option");
              Finance_OptionElements.forEach((element) => {
                var ElementOptions = element.querySelector(".opt_element");
                if (ElementOptions != null) {
                  if (!ElementOptions.classList.contains("active") && element.contains(Finance_target)) {
                    ElementOptions.classList.add("active");
                    Finance_dn_message.classList.remove('delete');
                    Finance_dn_message.querySelector('p').innerText = '';
                  } else if (ElementOptions.classList.contains("active") && !element.contains(Finance_target)) {
                    if (!ElementOptions.contains(Finance_target)) {
                      ElementOptions.classList.remove("active");
                    }
                  } else {
                    Finance_MainBody = document.querySelectorAll('.container_item .item');
                    if (Finance_MainBody) {
                      Finance_MainBody.forEach(element => {
                        if (element.contains(Finance_target)) {
                          Finance_MainFormDel = element;
                        }
                      })
                    }
                    if (Finance_target.hasAttribute("Update_item") && element.contains(Finance_target)) {
                      Finance_validateKey = element.querySelector(".opt_element p").getAttribute("Update_item");
                      UpdateItemFunction(Finance_target, finance_ActivityMenu);
                    }
                    if (Finance_target.hasAttribute("delete_item") && element.contains(Finance_target)) {
                      Finance_dn_message.classList.add("active");
                      ElementOptions.classList.remove("active");
                      Finance_validateKey = element
                        .querySelector(".opt_element p")
                        .getAttribute("Update_item");

                      DeleteItemFunction("values", finance_ActivityMenu);
                    }
                  }
                }
              });
              setTimeout(() => {
                if (!Finance_loader_View.contains(Finance_target) && !Finance_target.classList.contains('btn_confirm')) {
                  if (Finance_loader_View.classList.contains('active')) {
                    Finance_loader_View.classList.remove('active');
                    Finance_loader_View.innerText = "";
                  }
                }
              }, 100)
            }
          });

          async function Finance_PHPREQUEST(Finance_APIDOCS, form, Finance_loaderBtn) {
            if (location_updator() == "Finance") {
              let Finance_data;
              Finance_loaderBtn.classList.remove('active');
              Finance_loaderBtn.classList.add('play');
              try {

                const formMain = new FormData(form);
                const Request = await fetch(Finance_APIDOCS, {
                  method: "POST",
                  body: formMain,
                });

                if (Request.status === 200) {
                  Finance_data = await Request.json();
                  if (Finance_data) {
                    if (Finance_data == 'success' || Finance_data == 'update success') {
                      Finance_loaderBtn.classList.remove('play');
                      Finance_loaderBtn.classList.add('active');
                      Finance_loaderBtn.querySelector('.text p').textContent = Finance_data;
                      requestData = Finance_data;
                      if (!Finance_validateKey) {
                        Finance_validateKey = "";
                      }
                      if (finance_ActivityMenu != false) {
                        Finance_APIDOCS =
                          "../../API/finance/data_process.php?APICALL=true&&user=true&&submit=fetchlatest";
                        Finance_PHPLIVEUPDATE(Finance_APIDOCS, Finance_validateKey);
                      } else {
                        UrlTrace();
                      }
                    } else {
                      Finance_loaderBtn.classList.remove('play');
                      Finance_loaderBtn.classList.add('active');
                      Finance_loaderBtn.querySelector('.text p').textContent = Finance_data;
                    }


                  }
                } else {
                  console.error("invalid link directory");
                }
              } catch (error) {
                console.error(error);
              }
              Finance_loaderBtn.classList.remove('play');
            }
          }
          async function Finance_PHPREQUESTDEL(Finance_APIDOCS, Finance_validateKey) {
            if (location_updator() == "Finance") {
              let data;
              try {
                Finance_loader_View.classList.add('active');
                dataSend = {
                  key: Finance_validateKey,
                };

                const Request = await fetch(Finance_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  data = data.toLowerCase();
                  if (data == 'item deleted successfully') {
                    if (Finance_MainFormDel) {
                      Finance_MainFormDel.classList.add('hide');
                    }
                    Finance_loader_View.innerHTML = data;
                  }
                } else {
                  console.error("cannot find endpoint");
                }

              } catch (error) {
                console.error(error);
              }
            }

          }
          async function Finance_PHPREQUESTFILTER(Finance_APIDOCS) {
            if (location_updator() == "Finance") {
              let Finance_data;
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
                Finance_dn_message.querySelector("p").innerText = "...processing request";
                dataSend = {
                  year: document.querySelector('select[name="yearfilter"]').value
                };


                const Request = await fetch(Finance_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  Finance_data = await Request.json(Finance_data);
                  if (Finance_data) {
                    var Finance_bodyDisplay;
                    if (finance_ActivityMenu == false) {
                      Finance_bodyDisplay = document.querySelector('.menu.account .container_item');
                    } else {
                      Finance_bodyDisplay = document.querySelector('.menu.event .container_item');
                    }
                    setTimeout(() => {
                      if (typeof Finance_data != 'object') {
                        Finance_bodyDisplay.innerHTML = "<p class='danger'>AN ERROR OCCURRED CANNOT FIND DATA CONTENTS FOR THIS SESSION</p>";
                      } else {
                        Finance_bodyDisplay.innerHTML = "";
                        dataDecode = Finance_data;
                        month = 0;
                        images_collection = ['bkg_01_january.jpg', 'bkg_02_february.jpg', 'bkg_03_march.jpg', 'bkg_04_april.jpg', 'bkg_05_may.jpg', 'bkg_06_june.jpg', 'bkg_07_july.jpg', 'bkg_08_august.jpg', 'bkg_09_september.jpg', 'bkg_10_october.jpg', 'bkg_11_november.jpg', 'bkg_12_december.jpg'];

                        for (const key in dataDecode) {
                          Item_name = dataDecode[key]['name'];
                          amount = dataDecode[key]['amount'];
                          date = dataDecode[key]['date'];
                          purpose = dataDecode[key]['purpose'];
                          id = dataDecode[key]['UniqueId'];
                          Month = parseInt(dataDecode[key]['Month']);
                          ObjectData = dataDecode[key]['Obj'];

                          if (Month > 1) {
                            Month = Month - 1;
                          } else {
                            Month = Month;
                          }

                          if (month != parseInt(Month)) {
                            Finance_bodyDisplay.innerHTML += `<div class='itemlist calender' style='width:100%;height:200px;'>
                            <img  style='width:100%;height:100%;object-fit:cover;' src='../../membership/images/${images_collection[Month]}' alt='calender year ${images_collection[Month]}' />
                            </div>`;
                            month = Month;
                          }
                          Finance_template = `
                      <div class='item'>
                      <div class='file'>
                      <img src='../../images/cfile.png' alt='' />
                      </div>
                      <div class='details'>
                          <p class='item_name' data_item= ${date} > ${Item_name}   - Total ${amount} </p>
                          <p>last modified . ${date}</p>
        
                      </div>
                      <div class='delete option'>
                          <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                              width='30'>
                              <path
                                  d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                          </svg>
                          <div class='opt_element'>
                              <p Update_item='${id}' data-information='${ObjectData}'>Update item <i></i></p>
                              <p delete_item='${id}'>Delete item <i></i></p>
                          </div>
                      </div>
                  </div>
                 `;
                          Finance_bodyDisplay.innerHTML += Finance_template;


                        }
                        SearchTrigger = true;
                      }

                    }, 200);
                    Finance_OptionElements = document.querySelectorAll(".option");
                  }
                } else {
                  console.error("cannot find endpoint");
                }
                loader_progress.classList.remove("active");
                ContentDom.classList.remove("load");
                DomManipulationElement.classList.remove("load");
              } catch (error) {
                console.error(error);
              }
            }
          }
          async function Finance_PHPLIVEUPDATE(Finance_APIDOCS, Finance_validateKey) {
            if (location_updator() == "Finance") {
              let Finance_data;
              try {
                dataSend = {
                  key: Finance_validateKey
                };
                const Request = await fetch(Finance_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  Finance_data = await Request.json(Finance_data);
                  if (typeof Finance_data != 'object') {
                    let Finance_ObjectDataFrame = JSON.parse(Finance_data);
                    Finance_Template = "";
                    var Finance_CloneObject = '';
                    if (finance_ActivityMenu == false) {
                      Finance_Template = document.querySelector('.menu.account .container_item');
                      Finance_CloneObject = document.querySelector('.menu.account').querySelector('.cloneSearch .item').cloneNode(true);
                    } else {
                      Finance_Template = document.querySelector('.menu.event .container_item');
                      Finance_CloneObject = document.querySelector('.menu.event').querySelector('.cloneSearch .item').cloneNode(true);
                    }
                    for (const key in Finance_ObjectDataFrame) {
                      Amount = Finance_ObjectDataFrame[key]['amount'];
                      Name = Finance_ObjectDataFrame[key]['name'];
                      date = Finance_ObjectDataFrame[key]['date'];
                      date_data = Finance_ObjectDataFrame[key]['date_data'];
                      purpose = Finance_ObjectDataFrame[key]['purpose'];
                      department = Finance_ObjectDataFrame[key]['department'];
                      id = Finance_ObjectDataFrame[key]['UniqueId'];
                      ObjectData = Finance_ObjectDataFrame[key]['Obj'];

                      if (Finance_CloneObject != '') {
                        Finance_CloneObject.querySelector('p.item_name').setAttribute('data_item', date_data);
                        Finance_CloneObject.querySelector('p.item_name').innerText = `${Name}   - Total  ${Amount} `;
                        Finance_CloneObject.querySelector('p.item_modified').innerText = `last modified  ${date_data}`;
                        Finance_CloneObject.querySelector('.opt_element p.up').setAttribute('Update_item', id);
                        Finance_CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                        Finance_CloneObject.querySelector('.opt_element p.dp').setAttribute('delete_item', id);
                        Finance_CloneObject.querySelector('a').setAttribute('href', `finance/finance_event.php?data_page=${id}&&amount=${Amount}' Finance_target='_blank'`)
                        Finance_CloneObject.removeAttribute('hidden')
                        if (Finance_Template.querySelector('p.danger')) {
                          Finance_Template.innerHTML = "";
                        }
                        Finance_Template.prepend(Finance_CloneObject);
                        if (requestData == 'update success') {
                          Finance_MainFormDel.classList.add('hide');
                          Finance_validateKey = '';
                        }
                        Finance_MainFormDel = Finance_CloneObject;
                        Finance_OptionElements = document.querySelectorAll(".option");
                        const element = Finance_CloneObject.querySelector('.option');
                        element.addEventListener("click", function () {
                          var ElementOptions = element.querySelector(".opt_element");
                          ElementOptions.classList.add("active");
                        });
                      }


                    }
                  }

                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          function UpdateItemFunction(value, finance_ActivityMenu) {
            Finance_newObject = value.getAttribute("data-information");
            Finance_newObject = JSON.parse(Finance_newObject);
            if (finance_ActivityMenu == false) {
              document.querySelector('.event_menu_add input[name="event"]').value = Finance_newObject["name"];
              document.querySelector('.event_menu_add input[name="amount"]').value = Finance_newObject["amount"];
              document.querySelector('.event_menu_add input[name="Date"]').value = Finance_newObject["date"];
              document.querySelector('.event_menu_add textarea[name="description"]').value = Finance_newObject["purpose"];
              document.querySelector('.event_menu_add input[name="delete_key"]').value = Finance_validateKey;
              Finance_AddEventMenu_off.classList.add("active");
              Finance_APIDOCS = "../../API/finance/data_process.php?APICALL=true&&user=offertory&&submit=update";
            } else {
              Finance_APIDOCS = "../../API/finance/data_process.php?APICALL=true&&user=true&&submit=update";
              Finance_AddEventMenu.querySelector('.event_menu_add.main input[name="event"]').value = Finance_newObject["name"];
              Finance_AddEventMenu.querySelector('.event_menu_add.main select[name="category"]').value = Finance_newObject["department"];
              Finance_AddEventMenu.querySelector('.event_menu_add.main input[name="amount"]').value = Finance_newObject["amount"];
              Finance_AddEventMenu.querySelector('.event_menu_add.main input[name="date"]').value = Finance_newObject["date"];
              Finance_AddEventMenu.querySelector('.event_menu_add.main textarea[name="description"]').value = Finance_newObject["purpose"];
              Finance_AddEventMenu.querySelector('.event_menu_add.main input[name="delete_key"]').value = Finance_validateKey;
              Finance_AddEventMenu.classList.add("active");
            }
          }
          function DeleteItemFunction(value) {
            if (value == "true" && location_updator() == "Finance") {
              if (finance_ActivityMenu) {
                Finance_APIDOCS = "../../API/finance/data_process.php?APICALL=true&&user=true&&submit=delete";
              } else {
                Finance_APIDOCS = "../../API/finance/data_process.php?APICALL=true&&user=offertory&&submit=delete";
              }
              Finance_PHPREQUESTDEL(Finance_APIDOCS, Finance_validateKey);

            }
          }
          const Finance_searchSystem = debounce(async (Finance_APIDOCS, value) => {
            if (location_updator() == "Finance") {
              let data;
              try {
                loader_progress.classList.add("active");
                ContentDom.classList.add("load");
                DomManipulationElement.classList.add("load");
                Finance_dn_message.querySelector("p").innerText = "...processing request";
                dataSend = {
                  key: value,
                  numData: Finance_numoffset,
                };

                const Request = await fetch(Finance_APIDOCS, {
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
                      let Finance_ObjectDataFrame = JSON.parse(Finance_data);
                      Finance_Template = "";
                      if (finance_ActivityMenu == false) {
                        Finance_Template = document.querySelector('.menu.account .container_item');
                        CloneObject = document.querySelector('.menu.account').querySelector('.cloneSearch').cloneNode(true);
                      } else {
                        Finance_Template = document.querySelector('.menu.event .container_item');
                      }
                      Finance_Template.innerHTML = "";
                      Finance_ObjectDataFrame = Finance_ObjectDataFrame['result'];
                      for (const key in Finance_ObjectDataFrame) {
                        Amount = Finance_ObjectDataFrame[key]['amount'];
                        Name = Finance_ObjectDataFrame[key]['name'];
                        date = Finance_ObjectDataFrame[key]['date'];
                        date_data = Finance_ObjectDataFrame[key]['date_data'];
                        purpose = Finance_ObjectDataFrame[key]['purpose'];
                        department = Finance_ObjectDataFrame[key]['department'];
                        id = Finance_ObjectDataFrame[key]['UniqueId'];
                        ObjectData = Finance_ObjectDataFrame[key]['Obj'];
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
                          CloneObject.querySelector('a').setAttribute('href', `finance/finance_event.php?data_page=${id}&&amount=${Amount}' Finance_target='_blank'`)
                          CloneObject.removeAttribute('hidden')
                          ElementDivCone.append(CloneObject);
                          Finance_Template.append(ElementDivCone);
                          Finance_OptionElements = document.querySelectorAll(".option");
                          const element = ElementDivCone.querySelector('.option');
                          element.addEventListener("click", function () {
                            var ElementOptions = element.querySelector(".opt_element");
                            ElementOptions.classList.add("active");
                          });
                        }


                      }
                      if (Finance_ObjectDataFrame['pages'] > 25) {
                        ConvertPages = Finance_ObjectDataFrame['pages'];
                        RestructurePages(ConvertPages);
                      }
                    }
                  }
                } else {
                  console.error("cannot find endpoint");
                }
                loader_progress.classList.remove("active");
                ContentDom.classList.remove("load");
                DomManipulationElement.classList.remove("load");
              } catch (error) {
                console.error(error);
              }
            }
          })
        }
        if (location == "Transaction") {
          let data;
          let Transaction_validateKey = false;
          let Transactions_APIDOCS = "";
          let Transaction_MainFormDel = "";
          document.querySelector("li.expand").classList.add("active");
          const Transactions_AddEventBtn = document.querySelector(".add_event");
          const Transactions_AddEventMenu = document.querySelector(".event_menu_add.form_data");
          const Transactions_dn_message = document.querySelector(".dn_message");
          const Transactions_confirmsBtns = document.querySelectorAll(".btn_confirm");
          const Transactions_loaderBtn = document.querySelector(".event_menu_add.form_data .loader_wrapper");
          const Transactions_AddEventMenuForm = Transactions_AddEventMenu.querySelector("form");
          const Transactions_List_filter = document.querySelector(".List_filter");
          const Transactions_ResponseView = document.querySelector(".info_information.event_menu_add");
          var Transactions_OptionElements = document.querySelectorAll(".delete.option");
          const Transactions_Transaction_filter_option = document.querySelectorAll(".filter_option");
          const Transactions_Export_variables = document.querySelector('#ExportBtn');
          const Transactions_Export_variables_Dialogue = document.querySelector('.export_dialogue');
          const Transactions_Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
          const Transactions_Export_variables_Dialogue_Form = Transactions_Export_variables_Dialogue.querySelector("form");
          const Transactions_AddEventMenu_Btn = document.querySelector(".event_menu_add.form_data Button");
          const BatchUpload = document.querySelector('#data_upload');
          let BatchUpload_Content = false;
          BatchUpload.addEventListener('click', function () {
            BatchSelect.click();
          });
          BatchSelect.addEventListener('change', function (e) {
            if (e.target.files[0]) {
              BatchUpload_Content = e.target.files[0];
              ExtensionName = BatchUpload_Content.name.split('.');
              ExtensionNameList = ['xlsx', 'xlx', 'xls'];
              if (ExtensionNameList.includes(ExtensionName[1].toLowerCase())) {
                BatchPlatform.querySelector('header').textContent = `${BatchUpload_Content.name} has been selected. Click on the upload button to proceed`;
              } else {
                BatchPlatform.querySelector('header').textContent = `Target file must be in excel formate.!!!`;
              }

              BatchPlatform.classList.add('active');
            }

          });

          BatchPlatform.querySelector('button').addEventListener('click', function () {
            if (BatchUpload_Content != false) {
              BatchPlatform.querySelector('.loader_wrapper').classList.add('play');
              var File_reader = new FileReader();
              File_reader.onload = function (event) {
                var data = new Uint8Array(event.target.result);
                var workbook = XLSX.read(data, {
                  type: "array"
                });
                workbook.SheetNames.forEach((sheet) => {
                  let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                  ObjectKeys = Object.keys(rowObject[0]);
                  if (ObjectKeys.length == 7 || ObjectKeys.length == 6) {
                    if (ObjectKeys.includes('id') || ObjectKeys.includes('ID') || ObjectKeys.includes('Id') || ObjectKeys.includes('iD')) {
                      rowObject.slice(1);
                    }
                    BatchPlatform.querySelector('header').textContent = ` Number of file to expected to upload : ${rowObject.length}`;
                    rowObject.slice(1)
                    rowObject.forEach(element => {
                      Transaction_Batch(element).then(data => {
                        if (data == 'success') {
                          BatchPlatform.querySelector('.upload').innerHTML += `<p>Uploading data ${rowObject.indexOf(element)} was a success</p>`;
                        } else {
                          BatchPlatform.querySelector('.error').innerHTML += `<p>Uploading data ${rowObject.indexOf(element)} encountered an error ${data}</p>`;
                        }
                      }).catch(error => {
                        console.log(error);
                      })

                    })
                  } else if (ObjectKeys.length > 7 || ObjectKeys.length < 6) {
                    BatchPlatform.querySelector('header').textContent = `Uploaded file ought to have 6 columns, unequal columns detected !!`;
                  }
                  BatchPlatform.querySelector('.loader_wrapper').classList.remove('play');
                  console.log(rowObject);
                })
              }
              File_reader.readAsArrayBuffer(BatchUpload_Content);
            }
            BatchUpload_Content = false;

          })

          async function Transaction_Batch(element) {
            if (location_updator() == "Transaction") {
              if (typeof element == 'object') {
                try {
                  const formMain = new FormData();
                  Keys = Object.keys(element);
                  if (Keys.length == 6) {
                    formMain.append('account', element[Keys[0]]);
                    formMain.append('status_information', element[Keys[1]]);
                    formMain.append('authorize', element[Keys[2]]);
                    formMain.append('category', element[Keys[3]]);
                    formMain.append('amount', element[Keys[4]]);
                    formMain.append('date', element[Keys[5]]);
                    Transaction_APIDOCS = "../../API/finance/data_process.php?APICALL=transaction&&user=true&&submit=upload";
                    const Request = await fetch(Transaction_APIDOCS, {
                      method: "POST",
                      body: formMain,
                    });

                    if (Request.status === 200) {
                      data = await Request.json();
                      return data
                    } else {
                      return `request responded with ${Request.status}`;
                    }
                  } else {
                    return `data is missing a columns `
                  }

                } catch (error) {
                  return error
                }
              } else {
                return "Connot convert file";
              }

            } else {
              return false;
            }
          }
          Transactions_AddEventMenuForm.addEventListener("submit", function (e) {
            e.preventDefault();
          });
          Transactions_Export_variables_Dialogue_Form.addEventListener('submit', function (e) {
            e.preventDefault();
          })
          Transactions_AddEventBtn.addEventListener("click", function (e) {
            Transactions_AddEventMenu.classList.add("active");
            Transaction_validateKey = false;
          });
          Transactions_Export_variables.onclick = function () {
            Transactions_Export_variables_Dialogue.classList.add("active");
          };

          Transactions_AddEventBtn.addEventListener("click", function (e) {
            Transactions_APIDOCS = transactions.DirCalls('Upload');
          });

          Transactions_Export_variables_Dialogue_Btn.addEventListener('click', async function () {
            Transactions_APIDOCS = transactions.DirCalls('Export');
            ExportData('transactiondata', 'excel', Transactions_APIDOCS)
          });

          window.addEventListener("click", function (e) {
            if (location_updator() == 'Transaction') {
              var Transactions_target = e.target;

              if (BatchPlatform.classList.contains("active") && !BatchUpload.contains(Transactions_target)) {
                if (!BatchPlatform.contains(Transactions_target)) {
                  BatchPlatform.classList.remove("active");

                  BatchSelect.value = "";
                  BatchPlatform.querySelector('header').textContent = ` `;
                  BatchPlatform.querySelector('.upload').innerHTML = ` `;
                  BatchPlatform.querySelector('.error').innerHTML = ` `;


                }
              }

              var Transactions_OptionElements = document.querySelectorAll(".delete.option");
              const Transactions_Pages = document.querySelectorAll(".pages div");
              Transactions_OptionElements.forEach((element) => {
                var Transaction_ElementOptions = element.querySelector(".opt_element");
                if (Transaction_ElementOptions != null) {
                  if (Transaction_ElementOptions.classList.contains("active") && !element.contains(Transactions_target)) {
                    if (!Transaction_ElementOptions.contains(Transactions_target)) {
                      Transaction_ElementOptions.classList.remove("active");
                    }
                  } else {
                    if (element.contains(Transactions_target) && !Transaction_ElementOptions.classList.contains('active')) {
                      Transaction_ElementOptions.classList.add("active");
                    } else {
                      Transaction_MainBody = document.querySelectorAll('#main_table tbody tr');
                      if (Transaction_MainBody) {
                        Transaction_MainBody.forEach(element => {
                          if (element.contains(Transactions_target)) {
                            Transaction_MainFormDel = element;

                          }
                        })
                        if (Transactions_target.hasAttribute("update_item") && element.contains(Transactions_target)) {
                          Transactions_APIDOCS = transactions.DirCalls('Update');
                          if (transactions.UpdateItemFunction(Transactions_target)) {
                            Transactions_AddEventMenu.classList.add('active');
                            Transaction_validateKey = element
                              .querySelector(".opt_element p")
                              .getAttribute("Update_item");
                          }

                        } else
                          if (Transactions_target.hasAttribute("delete_item") && element.contains(Transactions_target)) {
                            Transactions_dn_message.classList.add("active");
                            Transaction_ElementOptions.classList.remove("active");
                            Transaction_validateKey = element
                              .querySelector(".opt_element p")
                              .getAttribute("Update_item");
                          }
                      }
                    }

                  }
                }
              });
              if (Transactions_AddEventMenu.classList.contains("active") && !Transactions_AddEventBtn.contains(Transactions_target)) {
                if (!Transactions_AddEventMenu.contains(Transactions_target) && !Transactions_target.hasAttribute("update_item")) {
                  Transactions_AddEventMenu.classList.remove("active");
                  Transactions_loaderBtn.querySelector('.text p').textContent = "";
                }
              }
              Transactions_Transaction_filter_option.forEach((element) => {
                if (!element.contains(Transactions_target)) {
                  element.querySelector(".select").classList.remove("active");
                }
              });
              if (Transactions_Export_variables_Dialogue.classList.contains('active') && !Transactions_Export_variables.contains(Transactions_target)) {
                if (!Transactions_Export_variables_Dialogue.contains(Transactions_target)) {
                  Transactions_Export_variables_Dialogue.classList.remove('active')
                }
              }
              setTimeout(() => {
                if (!Transactions_ResponseView.contains(Transactions_target) && !Transactions_target.classList.contains('btn_confirm')) {
                  if (Transactions_ResponseView.classList.contains('active')) {
                    Transactions_ResponseView.classList.remove('active');
                    Transactions_ResponseView.innerText = "";
                  }
                }
              }, 100)
              Transactions_Pages.forEach((element) => {
                if (element.contains(Transactions_target)) {
                  value = element.innerHTML;
                  pagnationSystem(value);
                }
              });
            }
          });
          Transactions_Transaction_filter_option.forEach((element) => {
            element.addEventListener("click", function () {
              Transactions_Transaction_filter_option.forEach((element_dr) => {
                if (element_dr != element) {
                  element_dr.querySelector(".select").classList.remove("active");
                }
              });

              element.querySelector(".select").classList.add("active");
            });
          });
          document.querySelector('select[name="catfilter"]').addEventListener("change", function (e) {
            let value = e.target.value;
            let parentVal = e.target.parentElement;
            let Cat = parentVal.querySelector("p");
            Cat.innerText = value;
          });
          document.querySelector('select[name="yearfilter"]').addEventListener("change", function (e) {
            let value = e.target.value;
            let parentVal = e.target.parentElement;
            let Cat = parentVal.querySelector("p");
            Cat.innerText = value;
          });
          document.querySelector('select[name="accfilter"]').addEventListener("change", function (e) {
            let value = e.target.value;
            let parentVal = e.target.parentElement;
            let Cat = parentVal.querySelector("p");
            Cat.innerText = value;
          });
          Transactions_List_filter.addEventListener("click", function () {
            Transactions_APIDOCS = transactions.DirCalls('Filter');
            transactions.PHPREQUESTFILTER(Transactions_APIDOCS, data, ArrayTables, Transactions_dn_message, loader_progress, ContentDom, SearchTrigger, numoffset, location)
          });
          Transactions_confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (Transaction_validateKey != "") {
                  transactions.DeleteItemFunction(element.getAttribute("data-confirm"), Transaction_validateKey, Transactions_ResponseView, Transaction_MainFormDel, location_updator()).then(data => {
                    if (data == 'item deleted successfully') {
                      if (Transaction_MainFormDel != '') {
                        Transaction_MainFormDel.classList.add('hide');
                        Transaction_MainFormDel = "";
                      }
                    }
                  })
                  Transaction_validateKey = "";
                }
              }
            });
          });
          Transactions_AddEventMenu_Btn.onclick = function () {
            Transactions_AddEventMenu.classList.add("active");
            var Transaction_formConditons = document.querySelectorAll(".form_condition");
            Transactions_loaderBtn.classList.add('active');
            if (ConditionFeilds(Transaction_formConditons) != false) {
              console.log(Transaction_validateKey)
              transactions.PHPREQUEST(Transactions_APIDOCS, Transactions_loaderBtn, Transactions_AddEventMenuForm, Transaction_validateKey, Transaction_MainFormDel, location_updator()).then(data => {
                if (typeof data == 'object') {
                  Transaction_MainFormDel = data[1];
                  console.log(Transaction_validateKey);
                }
              }).catch(error => {
                console.log(error);
              })

            } else {
              Transactions_loaderBtn.querySelector('.text p').textContent = "All feilds required !!";
            }
          };

        }
        if (location == 'Expenses') {
          let Expenses_APIDOCS = "";
          let Expenses_validateKey = "";
          let Expenses_requestData = "";
          let Expenses_MainFormDel = "";
          let data = "";
          const Expenses_AddEventMenu = document.querySelector(".event_menu_add.form_data");
          const Expenses_dn_message = document.querySelector(".dn_message");
          const Expenses_confirmsBtns = document.querySelectorAll(".btn_confirm");
          const Expenses_AddEventBtn = document.querySelector(".add_event");
          const Expenses_loaderBtn = document.querySelector(".event_menu_add.form_data .loader_wrapper");
          const Expenses_AddEventMenuForm = Expenses_AddEventMenu.querySelector("form");
          var Expenses_OptionElements = document.querySelectorAll(".delete.option");
          const Expenses_filter_option = document.querySelectorAll(".filter_option");
          const Expenses_ResponseView = document.querySelector(".info_information.event_menu_add");
          const Expenses_List_filter = document.querySelector(".List_filter");
          const Expenses_Export_variables = document.querySelector('#ExportBtn');
          const Expenses_Export_variables_Dialogue = document.querySelector('.export_dialogue');
          const Expenses_Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
          const Expenses_Export_variables_Dialogue_Form = Expenses_Export_variables_Dialogue.querySelector("form");
          const BatchUpload = document.querySelector('#data_upload');
          let BatchUpload_Content = false;
          BatchUpload.addEventListener('click', function () {
            BatchSelect.click();
          });
          BatchSelect.addEventListener('change', function (e) {
            if (e.target.files[0]) {
              BatchUpload_Content = e.target.files[0];
              ExtensionName = BatchUpload_Content.name.split('.');
              ExtensionNameList = ['xlsx', 'xlx', 'xls'];
              if (ExtensionNameList.includes(ExtensionName[1].toLowerCase())) {
                BatchPlatform.querySelector('header').textContent = `${BatchUpload_Content.name} has been selected. Click on the upload button to proceed`;
              } else {
                BatchPlatform.querySelector('header').textContent = `Target file must be in excel formate.!!!`;
              }

              BatchPlatform.classList.add('active');
            }

          });

          BatchPlatform.querySelector('button').addEventListener('click', function () {
            if (BatchUpload_Content != false) {
              BatchPlatform.querySelector('.loader_wrapper').classList.add('play');
              var File_reader = new FileReader();
              File_reader.onload = function (event) {
                var data = new Uint8Array(event.target.result);
                var workbook = XLSX.read(data, {
                  type: "array"
                });
                workbook.SheetNames.forEach((sheet) => {
                  let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                  ObjectKeys = Object.keys(rowObject[0]);
                  if (ObjectKeys.length == 7 || ObjectKeys.length == 5) {
                    if (ObjectKeys.includes('id') || ObjectKeys.includes('ID') || ObjectKeys.includes('Id') || ObjectKeys.includes('iD')) {
                      rowObject.slice(1);
                    }
                    BatchPlatform.querySelector('header').textContent = ` Number of file to expected to upload : ${rowObject.length}`;
                    rowObject.slice(1)
                    rowObject.forEach(element => {
                      Expenses_Batch(element).then(data => {
                        if (data == 'success') {
                          BatchPlatform.querySelector('.upload').innerHTML += `<p>Uploading data ${rowObject.indexOf(element)} was a success</p>`;
                        } else {
                          BatchPlatform.querySelector('.error').innerHTML += `<p>Uploading data ${rowObject.indexOf(element)} encountered an error ${data}</p>`;
                        }
                      }).catch(error => {
                        console.log(error);
                      })

                    })
                  } else if (ObjectKeys.length > 7 || ObjectKeys.length < 5) {
                    BatchPlatform.querySelector('header').textContent = `Uploaded file ought to have 5 columns, unequal columns detected !!`;
                  }
                  BatchPlatform.querySelector('.loader_wrapper').classList.remove('play');
                  console.log(rowObject);
                })
              }
              File_reader.readAsArrayBuffer(BatchUpload_Content);
            }
            BatchUpload_Content = false;

          })

          async function Expenses_Batch(element) {
            if (location_updator() == "Expenses") {
              if (typeof element == 'object') {
                try {
                  const formMain = new FormData();
                  Keys = Object.keys(element);
                  if (Keys.length == 5) {
                    formMain.append('category', element[Keys[0]]);
                    formMain.append('type', element[Keys[1]]);
                    formMain.append('Amount', element[Keys[2]]);
                    formMain.append('details', element[Keys[3]]);
                    formMain.append('Date', element[Keys[4]]);
                    Transaction_APIDOCS = "../../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=upload";
                    const Request = await fetch(Transaction_APIDOCS, {
                      method: "POST",
                      body: formMain,
                    });

                    if (Request.status === 200) {
                      data = await Request.json();
                      return data
                    } else {
                      return `request responded with ${Request.status}`;
                    }
                  } else {
                    return `data is missing a columns `
                  }

                } catch (error) {
                  return error
                }
              } else {
                return "Connot convert file";
              }

            } else {
              return false;
            }
          }
          Expenses_AddEventBtn.addEventListener("click", function (e) {
            Expenses_AddEventMenu.classList.add("active");
            Expenses_APIDOCS = Expenses.DirCalls('Upload');
            Expenses_validateKey = "";
          });

          Expenses_Export_variables_Dialogue_Form.addEventListener('submit', function (e) {
            e.preventDefault();
          })
          Expenses_Export_variables.onclick = function () {
            Expenses_Export_variables_Dialogue.classList.add("active");
          };
          Expenses_Export_variables_Dialogue_Btn.addEventListener('click', async function () {
            Expenses_APIDOCS = Expenses.DirCalls('Export');
            ExportData('Expenses', 'excel', Expenses_APIDOCS)
          })
          Expenses_filter_option.forEach((element) => {
            element.addEventListener("click", function () {
              Expenses_filter_option.forEach((element_dr) => {
                if (element_dr != element) {
                  element_dr
                    .querySelector(".select")
                    .classList.remove("active");
                }
              });
              element.querySelector(".select").classList.add("active");
            });
          });

          document.querySelector('select[name="catfilter"]').addEventListener("change", function (e) {
            let value = e.target.value;
            let parentVal = e.target.parentElement;
            let Cat = parentVal.querySelector("p");
            Cat.innerText = value;
          });
          document.querySelector('select[name="yearfilter"]').addEventListener("change", function (e) {
            let value = e.target.value;
            let parentVal = e.target.parentElement;
            let Cat = parentVal.querySelector("p");
            Cat.innerText = value;
          });

          const Expenses_AddEventMenu_Btn = document.querySelector(".event_menu_add Button");

          Expenses_List_filter.addEventListener("click", function () {
            Expenses_APIDOCS = Expenses.DirCalls('Filter');
            Expenses.PHPREQUESTFILTER(Expenses_APIDOCS, data, ArrayTables, Expenses_dn_message, loader_progress, ContentDom, numoffset, location_updator());
          });

          Expenses_AddEventMenuForm.addEventListener("submit", function (e) {
            e.preventDefault();
          });
          Expenses_confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (Expenses_validateKey != "") {
                  Expenses.DeleteItemFunction(element.getAttribute("data-confirm"), Expenses_validateKey, Expenses_ResponseView, Expenses_MainFormDel, location_updator());
                  Expenses_validateKey = "";
                }
              } else {
                Expenses_dn_message.classList.remove("active");
              }
            });
          });
          window.addEventListener("click", function (e) {
            if (location_updator() == 'Expenses') {
              var Expenses_target = e.target;

              if (BatchPlatform.classList.contains("active") && !BatchUpload.contains(Expenses_target)) {
                if (!BatchPlatform.contains(Expenses_target)) {
                  BatchPlatform.classList.remove("active");

                  BatchSelect.value = "";
                  BatchPlatform.querySelector('header').textContent = ` `;
                  BatchPlatform.querySelector('.upload').innerHTML = ` `;
                  BatchPlatform.querySelector('.error').innerHTML = ` `;


                }
              }

              var Expenses_OptionElements = document.querySelectorAll(".option");
              const Expenses_Pages = document.querySelectorAll(".pages div");
              if (Expenses_AddEventMenu.classList.contains("active") && !Expenses_AddEventBtn.contains(Expenses_target)
              ) {
                if (!Expenses_AddEventMenu.contains(Expenses_target)) {
                  Expenses_AddEventMenu.classList.remove("active");
                }
              }

              Expenses_OptionElements.forEach((element) => {
                var ElementOptions = element.querySelector(".opt_element");
                if (ElementOptions != null) {
                  if (
                    ElementOptions.classList.contains("active") &&
                    !element.contains(Expenses_target)
                  ) {
                    if (!ElementOptions.contains(Expenses_target)) {
                      ElementOptions.classList.remove("active");
                      Expenses_loaderBtn.querySelector('.text p').textContent = '';
                    }
                  } else {
                    if (element.contains(Expenses_target) && !ElementOptions.classList.contains('active')) {
                      ElementOptions.classList.add("active");
                    } else {
                      MainBody = document.querySelectorAll('#main_table tbody tr');
                      if (MainBody) {
                        MainBody.forEach(element => {
                          if (element.contains(Expenses_target)) {
                            Expenses_MainFormDel = element;
                          }
                        })

                        if (
                          Expenses_target.hasAttribute("Update_item") &&
                          element.contains(Expenses_target)
                        ) {
                          ElementEngage = element.parentElement;
                          Expenses_APIDOCS = Expenses.DirCalls('Update');
                          Expenses.UpdateItemExpensesFunction(Expenses_target);
                          Expenses_validateKey = element
                            .querySelector(".opt_element p")
                            .getAttribute("delete_item");
                        }
                        if (
                          Expenses_target.hasAttribute("delete_item") &&
                          element.contains(Expenses_target)
                        ) {
                          Expenses_dn_message.classList.add("active");
                          ElementOptions.classList.remove("active");
                          ElementEngage = element.parentElement;
                          Expenses_validateKey = element
                            .querySelector(".opt_element p")
                            .getAttribute("delete_item");
                        }
                      }
                    }


                  }
                }
              });
              if (Expenses_Export_variables_Dialogue.classList.contains('active') && !Expenses_Export_variables.contains(Expenses_target)) {
                if (!Expenses_Export_variables_Dialogue.contains(Expenses_target)) {
                  Expenses_Export_variables_Dialogue.classList.remove('active')
                }
              }
              setTimeout(() => {
                if (!Expenses_ResponseView.contains(Expenses_target) && Expenses_target.classList.contains('btn_confirm')) {
                  if (Expenses_ResponseView.classList.contains('active')) {
                    Expenses_ResponseView.classList.remove('active');
                    Expenses_loaderBtn.innerText = "";
                  }
                }
              }, 100)

              Expenses_filter_option.forEach((element) => {
                if (!element.contains(Expenses_target)) {
                  element.querySelector(".select").classList.remove("active");
                }
              });
              Expenses_Pages.forEach((element) => {
                if (element.contains(Expenses_target)) {
                  value = element.innerHTML;
                  pagnationSystem(value);
                }
              });
            }
          });
          Expenses_AddEventMenu_Btn.onclick = function () {
            Expenses_AddEventMenu.classList.add("active");
            Expenses.PHPREQUEST(Expenses_APIDOCS, Expenses_loaderBtn, Expenses_AddEventMenuForm, Expenses_requestData, Expenses_validateKey, Expenses_MainFormDel, location_updator()).then(data => {
              if (typeof data == 'object') {
                Expenses_MainFormDel = data[1];
              }
            });


          };
        }
        if (location == "records") {
          let Records_RecordMenu = true;
          let Records_TemplateSet = true;
          let Records_TemplateSetRecord = false;
          let Records_validateKey = false;
          const Records_dn_message = document.querySelector(".dn_message");
          const Records_confirmsBtns = document.querySelectorAll(".btn_confirm");
          const Records_AddEventBtn_far = document.querySelector(".add_event.far");
          const Records_FilterBtn = document.querySelector(".filterBtn");
          const Records_RecordsDivs = document.querySelectorAll(".annc_item");
          var Records_OptionElements = document.querySelectorAll("i.delete_item");
          const Records_AddEventBtn = document.querySelector(".add_event");
          const Records_mainContainer = document.querySelector(".main_container");
          const Records_AddEventMenu = document.querySelector(".event_menu_add");
          const Records_Export_variables = document.querySelector('#ExportBtn');
          const Records_Export_variables_Dialogue = document.querySelector('.export_dialogue');
          const Records_Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
          const Records_Export_variables_Dialogue_Form = Records_Export_variables_Dialogue.querySelector("form");
          const Records_AddEventMenu_Btn = document.querySelector(".event_menu_add Button");
          var Records_FilterUI = document.querySelector(".notification_list_filter");
          var Records_FilterUIList = document.querySelectorAll(".notification_list_filter .item");
          Records_Export_variables_Dialogue_Form.addEventListener('submit', function (e) {
            e.preventDefault();
          })
          Records_Export_variables.onclick = function () {
            Records_Export_variables_Dialogue.classList.add("active");
          };
          Records_Export_variables_Dialogue_Btn.addEventListener('click', async function () {
            Records_APIDOCS = "";
            if (Records_RecordMenu) {
              Records_APIDOCS =
                "../../API/sundayRecords/data_process.php?APICALL=true&&user=true&&submit=export";
            } else {
              Records_APIDOCS =
                "../../API/sundayRecords/data_process.php?APICALL=record&&user=true&&submit=export";
            }
            if (Records_APIDOCS != "") {
              ExportData('records', 'excel', Records_APIDOCS)
            }

          })
          Records_AddEventBtn.addEventListener("click", function (e) {
            Records_APIDOCS =
              "../../API/sundayRecords/data_process.php?APICALL=true&&user=true&&submit=true";
            Records_mainContainer.classList.add("active");
            Records_validateKey = false;
            Records_RecordMenu = false;
            Records_DetectFunction();
          });

          Records_FilterUIList.forEach(element => {
            element.addEventListener('click', function () {
              setTimeout(() => {
                value = element.innerText;
                Records_FilterUI.classList.remove("active");
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
            if (location_updator() == 'records') {
              var target = e.target;
              var Records_FilterUI = document.querySelector(".notification_list_filter");

              if (target.classList.contains('delete_item')) {
                Records_MainFormDel = target.parentElement.parentElement.parentElement;
                Records_formDataDel = target.parentElement.parentElement.parentElement.querySelector("form");
              }

              if (target.classList.contains("Update_item")) {
                Records_UpdateItemFunction(target);
              }
              if (target.classList.contains("delete_item")) {
                Records_dn_message.classList.add("active");
              }
              Records_confirmsBtns.forEach((element) => {
                if (element.contains(target)) {
                  if (element.getAttribute("data-confirm") == "true") {
                    if (Records_MainFormDel != "" && Records_formDataDel != "") {
                      if (Records_formDataDel.hasAttribute("form-id")) {
                        Records_validateKey = Records_formDataDel.getAttribute("form-id");
                      }
                      if (Records_validateKey != "") {
                        Records_DeleteItemFunction(
                          element.getAttribute("data-confirm"),
                          Records_validateKey,
                          Records_MainFormDel
                        );

                      }
                    }

                  }

                }
              });

              if (!Records_FilterBtn.contains(target) && !Records_FilterUI.contains(target)) {
                if (Records_FilterUI.classList.contains("active")) {
                  Records_FilterUI.classList.remove("active");
                }
              } else {
                Records_FilterUI.classList.add("active");
              }
              if (Records_Export_variables_Dialogue.classList.contains('active') && !Records_Export_variables.contains(target)) {
                if (!Records_Export_variables_Dialogue.contains(target)) {
                  Records_Export_variables_Dialogue.classList.remove('active')
                }
              }
              if (Records_AddEventMenu.classList.contains("active") && !Records_AddEventBtn.contains(target)) {
                if (!Records_AddEventMenu.contains(target)) {
                  Records_AddEventMenu.classList.remove("active");
                }
              }
            }
          });
          Records_RecordsDivs.forEach((element) => {
            var Records_MainData = element.querySelector("i.Update_item");
            const SubmitForm = element.querySelector("form");
            SubmitForm.addEventListener("submit", function (e) {
              e.preventDefault();
              if (SubmitForm.hasAttribute("form-id")) {
                Records_PHPREQUEST("update", SubmitForm);
              } else {
                Records_PHPREQUEST("upload", SubmitForm);
              }
            });
            if (Records_MainData != null) {
              Records_MainData.addEventListener("click", function () {
                element.querySelector(".Activity_record").classList.toggle("edit");
                Records_MainData.parentElement.classList.toggle("active");
              });
            }
          });
          Records_AddEventBtn_far.addEventListener("click", function () {
            Records_RecordMenu = true;
            Records_mainContainer.classList.remove("active");
            Records_validateKey = false;
            Records_RecordMenu = true;
            Records_DetectFunction();
          });
          Records_confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (Records_validateKey != "") {
                  Records_DeleteItemFunction(element.getAttribute("data-confirm"));
                }
              } else {
                Records_dn_message.classList.remove("active");
              }
            });
          });
          function Records_DetectFunction() {
            var Template;
            var Records_ContainerMain;
            if (Records_RecordMenu) {
              Records_ContainerMain = document.querySelector('.profile_main .ancc_list');
              Template = document.querySelector("#template");
            } else {
              Records_ContainerMain = document.querySelector('.profile.records_main .ancc_list');
              Template = document.querySelector("#Recordtemplate");

            }
            if (Records_RecordMenu && Records_TemplateSet || !Records_RecordMenu && !Records_TemplateSetRecord) {
              const Div = document.createElement("div");
              const newClone = Template.cloneNode(true);
              newClone.setAttribute("id", "newClone");
              newClone.removeAttribute("hidden");
              var EventUpdateButton = newClone.querySelector("i.Update_item");
              const SubmitForm = newClone.querySelector("form");
              SubmitForm.addEventListener("submit", function (e) {
                e.preventDefault();
                if (SubmitForm.hasAttribute("form-id")) {
                  Records_PHPREQUEST("update", SubmitForm);
                } else {
                  Records_PHPREQUEST("upload", SubmitForm);
                }
              });
              EventUpdateButton.addEventListener("click", function () {
                newClone
                  .querySelector(".Activity_record")
                  .classList.toggle("edit");
                EventUpdateButton.parentElement.classList.toggle("active");
              });
              Div.append(newClone);
              Records_ContainerMain.prepend(Div);
              if (Records_RecordMenu && Records_TemplateSet) {
                Records_TemplateSet = false;
              }
              if (!Records_RecordMenu && !Records_TemplateSetRecord) {
                Records_TemplateSetRecord = true;
              }
            }
          }
          function Records_UpdateItemFunction(value) {
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
            //  Records_AddEventMenu.classList.add("active");
            //  Records_APIDOCS =
            //   "../../API/partnership/data_process.php?APICALL=true&&user=true&&submit=update_file";
          }
          function Records_DeleteItemFunction(value, Records_validateKey, MainForm) {
            let API;
            if (value == "true" && Records_validateKey && location_updator() == 'records') {
              if (!Records_RecordMenu) {
                API = "../../API/SundayRecords/data_process.php?APICALL=record&&user=true&&submit=delete";
              } else {
                API =
                  "../../API/SundayRecords/data_process.php?APICALL=true&&user=true&&submit=delete";
              }
              Records_PHPREQUESTDEL(API, Records_validateKey, MainForm);
            }
          }

          async function Records_PHPREQUEST(value, SubmitForm) {
            let Records_APIDOCS;
            if (Records_RecordMenu) {
              if (value == "update") {
                Records_APIDOCS =
                  "../../API/SundayRecords/data_process.php?APICALL=true&&user=true&&submit=update";
              } else if (value == "upload") {
                Records_APIDOCS =
                  "../../API/SundayRecords/data_process.php?APICALL=true&&user=true&&submit=upload";
              }
            } else {
              if (value == "update") {
                Records_APIDOCS =
                  "../../API/SundayRecords/data_process.php?APICALL=record&&user=true&&submit=update";
              } else if (value == "upload") {
                Records_APIDOCS =
                  "../../API/SundayRecords/data_process.php?APICALL=record&&user=true&&submit=upload";
              }
            }

            let data;
            try {
              const formMain = new FormData(SubmitForm);

              const Request = await fetch(Records_APIDOCS, {
                method: "POST",
                body: formMain,
              });

              if (Request.status === 200) {
                data = await Request.json();
                if (data) {
                  if (value == "upload") {
                    if (typeof data == 'object') {
                      message = data['message'];
                      if (message == "Upload was a success" || message == "Update was a success") {
                        SubmitForm.setAttribute("form-id", data["Id"]);
                        SubmitForm.querySelector('input[name="delete_key"]').value = data["Id"];
                        ParentElementR = SubmitForm.parentElement.parentElement.parentElement;
                        ParentElementR.querySelector('.edit.flex').classList.remove('active');
                        ParentElementR.querySelector(".Activity_record").classList.remove("edit");
                        if (!Records_RecordMenu) {
                          ParentElementR.querySelector('.flex.title h1').innerText += SubmitForm.querySelector('select[name="category"]').value;
                        }
                        ParentElementR.classList.add('list_mode');
                      }
                    }

                  }
                  Records_AddEventMenu.classList.add('active');
                  Records_AddEventMenu.querySelector('header').innerText = data['message'] || data;
                  if (Records_RecordMenu) {
                    Records_TemplateSet = true;
                  }
                  if (!Records_RecordMenu) {
                    Records_TemplateSetRecord = false;
                  }


                }
              } else {
                console.error("cannot find endpoint");
              }
            } catch (error) {
              console.error(error);
            }
          }
          async function Records_PHPREQUESTDEL(Records_APIDOCS, Records_validateKey, MainForm) {
            if (location_updator() == 'records') {
              let data;
              try {
                dataSend = {
                  key: Records_validateKey,
                };

                const Request = await fetch(Records_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  if (data) {
                    if (data["message"] || data == "Item Deleted Successfully") {
                      MainForm.classList.add("none");
                      Records_dn_message.classList.remove("active");
                    }
                    Records_AddEventMenu.classList.add('active');
                    Records_AddEventMenu.querySelector('header').innerText = data['message'] || data;
                  }
                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
        }
        if (location == "Library") {
          let Library_requestData = "";
          let Library_ElementEngage = "";
          let Library_validateKey = false;
          let Library_DeleteItemI = [];
          const Library_dn_message = document.querySelector(".dn_message");
          const Library_confirmsBtns = document.querySelectorAll(".btn_confirm");
          let Library_UploadFlow = true;
          let Library_Exclusion = false;
          let LibraryMediaFilenames = {};
          let Update_tigger = false;
          var Library_OptionElement_r = document.querySelectorAll(".option");
          var Library_OptionElements = document.querySelectorAll(".btn_record");
          const Library_loaderBtn = document.querySelector(".event_menu_add.form_data .loader_wrapper");
          const Library_Partnership_record = document.querySelector(".series_version");
          const Library_AddEventMenu = document.querySelector(".event_menu_add.form_data");
          const Library_AddEventMenuIndi = document.querySelector('.event_menu_add.indi')
          const Library_AddEventMenuIndiBtn = document.querySelector('.event_menu_add.indi button');
          const Library_ResponseView = document.querySelector(".info_information.event_menu_add");
          const Library_Export_variables = document.querySelector('#ExportBtn');
          const Library_Export_variables_Dialogue = document.querySelector('.export_dialogue');
          const Library_Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
          const Library_Export_variables_Dialogue_Form = Library_Export_variables_Dialogue.querySelector("form");
          const Library_FileChange = document.querySelector('input[name="upload_cover"]');
          const BatchUpload = document.querySelector('#data_upload');

          ArrayList = document.querySelectorAll('.event_menu_add select[name="category"] option');
          ListFine = [];
          ArrayList.forEach(element => {
            ListFine.push(element.innerHTML);
          })
          ListFine.sort();
          document.querySelector('.event_menu_add select[name="category"]').innerHTML = "";
          console.log(ListFine);
          ListFine.forEach(element => {
            document.querySelector('.event_menu_add select[name="category"]').innerHTML += `<option>${element}</option>`;
          })

          // let BatchUpload_Content = false;
          // BatchUpload.addEventListener('click', function () {
          //   BatchSelect.click();
          // });
          // BatchSelect.addEventListener('change', function (e) {
          //   if (e.target.files[0]) {
          //     BatchUpload_Content = e.target.files[0];
          //     ExtensionName = BatchUpload_Content.name.split('.');
          //     ExtensionNameList = ['xlsx', 'xlx', 'xls'];
          //     if (ExtensionNameList.includes(ExtensionName[1].toLowerCase())) {
          //       BatchPlatform.querySelector('header').textContent = `${BatchUpload_Content.name} has been selected. Click on the upload button to proceed`;
          //     } else {
          //       BatchPlatform.querySelector('header').textContent = `Target file must be in excel formate.!!!`;
          //     }

          //     BatchPlatform.classList.add('active');
          //   }

          // });

          // BatchPlatform.querySelector('button').addEventListener('click', function () {
          //   if (BatchUpload_Content != false) {
          //     BatchPlatform.querySelector('.loader_wrapper').classList.add('play');
          //     var File_reader = new FileReader();
          //     File_reader.onload = function (event) {
          //       var data = new Uint8Array(event.target.result);
          //       var workbook = XLSX.read(data, {
          //         type: "array"
          //       });
          //       workbook.SheetNames.forEach((sheet) => {
          //         let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
          //         ObjectKeys = Object.keys(rowObject[0]);
          //         if (ObjectKeys.length == 7 || ObjectKeys.length == 5) {
          //           if (ObjectKeys.includes('id') || ObjectKeys.includes('ID') || ObjectKeys.includes('Id') || ObjectKeys.includes('iD')) {
          //             rowObject.slice(1);
          //           }
          //           BatchPlatform.querySelector('header').textContent = ` Number of file to expected to upload : ${rowObject.length}`;
          //           rowObject.slice(1)
          //           rowObject.forEach(element => {
          //             Library_Batch(element).then(data => {
          //               if (data == 'success') {
          //                 BatchPlatform.querySelector('.upload').innerHTML += `<p>Uploading data ${rowObject.indexOf(element)} was a success</p>`;
          //               } else {
          //                 BatchPlatform.querySelector('.error').innerHTML += `<p>Uploading data ${rowObject.indexOf(element)} encountered an error ${data}</p>`;
          //               }
          //             }).catch(error => {
          //               console.log(error);
          //             })

          //           })
          //         } else if (ObjectKeys.length > 7 || ObjectKeys.length < 5) {
          //           BatchPlatform.querySelector('header').textContent = `Uploaded file ought to have 5 columns, unequal columns detected !!`;
          //         }
          //         BatchPlatform.querySelector('.loader_wrapper').classList.remove('play');
          //         console.log(rowObject);
          //       })
          //     }
          //     File_reader.readAsArrayBuffer(BatchUpload_Content);
          //   }
          //   BatchUpload_Content = false;

          // })

          // async function Library_Batch(element) {
          //   if (location_updator() == "Library") {
          //     if (typeof element == 'object') {
          //       try {
          //         const formMain = new FormData();
          //         Keys = Object.keys(element);
          //         if (Keys.length == 5) {
          //           formMain.append('category', element[Keys[0]]);
          //           formMain.append('type', element[Keys[1]]);
          //           formMain.append('Amount', element[Keys[2]]);
          //           formMain.append('details', element[Keys[3]]);
          //           formMain.append('Date', element[Keys[4]]);
          //           Transaction_APIDOCS = "../../API/finance/data_process.php?APICALL=expensis&&user=true&&submit=upload";
          //           const Request = await fetch(Transaction_APIDOCS, {
          //             method: "POST",
          //             body: formMain,
          //           });

          //           if (Request.status === 200) {
          //             data = await Request.json();
          //             return data
          //           } else {
          //             return `request responded with ${Request.status}`;
          //           }
          //         } else {
          //           return `data is missing a columns `
          //         }

          //       } catch (error) {
          //         return error
          //       }
          //     } else {
          //       return "Connot convert file";
          //     }

          //   } else {
          //     return false;
          //   }
          // }


          if (location_updator() == "Library") {
            r.assignBrowse(document.getElementById('browseButton'));
            r.on('filesAdded', function (array) {
              document.querySelector('#browseButton span').textContent = `${r.files.length} file has been added`;
            });
            document.getElementById('browseButton').addEventListener('click', function () {
              r.cancel();
            });
          }

          Library_Export_variables_Dialogue_Form.addEventListener('submit', function (e) {
            e.preventDefault();
          })
          Library_Export_variables.onclick = function () {
            Library_Export_variables_Dialogue.classList.add("active");
          };

          Library_Export_variables_Dialogue_Btn.addEventListener('click', async function () {
            APIDOCS =
              "../../API/Library/data_process.php?APICALL=true&&user=true&&submit=export";
            ExportData('LibraryExport', 'excel', APIDOCS)
          })
          let APIDOCS;
          let confirmKey = true;
          const Library_AddEventBtn = document.querySelector(".add_event");
          const Library_SubmitForm = document.querySelector(".event_menu_add.main form");
          Library_confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                console.error(document.querySelector(".delete_item"));

                if (Library_validateKey != "") {
                  Library_DeleteItemFunction(
                    element.getAttribute("data-confirm"),
                    Library_validateKey
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
              "../../API/Library/data_process.php?APICALL=true&&user=true&&submit=filter";
            if (searchInput.value != " " && searchInput.value != "") {
              searchSystem(APIDOCS, searchInput.value);
            }

          })

          Library_AddEventBtn.addEventListener("click", function (e) {
            APIDOCS = "../../API/Library/data_process.php?APICALL=true&&user=true&&submit=upload";
            Library_AddEventMenu.classList.add("active");
            Library_validateKey = false;
          });
          Library_AddEventMenuIndiBtn.addEventListener("click", function (e) {
            APIDOCS = "../../API/Library/data_process.php?APICALL=true&&user=true&&submit=upload_ind";
            Library_PHPREQUESTIND(APIDOCS);
          });
          function DestructureJson(element) {
            if (location_updator() == "Library") {
              newObject = JSON.parse(
                element.parentElement.getAttribute("data-information")
              );
              Library_Partnership_record.classList.add('active');
              const PartnerContainer =
                Library_Partnership_record.querySelector(".menu.event");
              if (Object.keys(newObject).length > 0) {

                PartnerContainer.innerHTML = "";
                for (const iletrate in newObject) {
                  let val = newObject[iletrate]["id"].trim();
                  if (!Library_DeleteItemI.includes(val)) {
                    dataVal = newObject[iletrate]["date"];
                    PartnerContainer.innerHTML += `<div class="item"><div class="details">
                <p>${newObject[iletrate]["filename"]}</p>
                <p> source . ${newObject[iletrate]["source"]}</p>
            </div>
            <div class="option"><i class="fas fa-trash" data-cn="trash" data-id="${newObject[iletrate]["id"].trim()
                      }"></i><div>
            </div>`;
                  }

                }
              } else {
                PartnerContainer.innerHTML = `<div class="item"><div class="details">
                <p>No Records Available</p>
            </div></div>`;
              }
            }
          }

          window.addEventListener("click", function (e) {
            if (location_updator() == "Library") {
              var target = e.target;

              var Library_OptionElement_r = document.querySelectorAll(".option");
              var Library_OptionElements = document.querySelectorAll(".btn_record");
              const Pages = document.querySelectorAll(".pages div");

              // if (BatchPlatform.classList.contains("active") && !BatchUpload.contains(target)) {
              //   if (!BatchPlatform.contains(target)) {
              //     BatchPlatform.classList.remove("active");

              //     BatchSelect.value = "";
              //     BatchPlatform.querySelector('header').textContent = ` `;
              //     BatchPlatform.querySelector('.upload').innerHTML = ` `;
              //     BatchPlatform.querySelector('.error').innerHTML = ` `;


              //   }
              // }

              if (Library_AddEventMenu.classList.contains("active") && !Library_AddEventBtn.contains(target)) {
                if (!Library_AddEventMenu.contains(target)) {
                  Library_AddEventMenu.classList.remove("active");
                  Library_loaderBtn.querySelector('.text p').textContent = "";
                }
              }
              if (Library_Export_variables_Dialogue.classList.contains('active') && !Library_Export_variables.contains(target)) {
                if (!Library_Export_variables_Dialogue.contains(target)) {
                  Library_Export_variables_Dialogue.classList.remove('active')
                }
              }
              setTimeout(() => {
                if (!Library_ResponseView.contains(target) && !target.classList.contains('btn_confirm')) {
                  if (Library_ResponseView.classList.contains('active')) {
                    Library_ResponseView.classList.remove('active');
                    Library_ResponseView.innerText = "";
                  }
                }
              }, 100)
              if (Library_AddEventMenuIndi.classList.contains("active") && !Library_AddEventMenuIndiBtn.contains(target)) {
                if (!Library_AddEventMenuIndi.contains(target)) {
                  Library_AddEventMenuIndi.classList.remove("active");
                }
              }

              if (!target.classList.contains("btn_record")) {
                if (Library_Partnership_record.classList.contains("active") &&
                  !Library_Partnership_record.contains(target)
                ) {
                  Library_Partnership_record.classList.remove("active");
                }
              }
              if (target.tagName == "I") {
                if (target.hasAttribute("data-cn")) {
                  if (target.hasAttribute("data-id")) {
                    Library_ElementEngage = target.parentElement.parentElement;
                    Library_validateKey = target.getAttribute("data-id");
                    Library_Partnership_record.classList.remove("active");
                    Library_dn_message.classList.add("active");
                    confirmKey = false;
                  }
                }
              }
              Library_OptionElement_r.forEach((element) => {
                var ElementOptions = element.querySelector(".opt_element");
                if (ElementOptions != null) {
                  if (!ElementOptions.classList.contains("active") && element.contains(target)) {
                    ElementOptions.classList.add("active");
                  }

                  if (ElementOptions.classList.contains("active") && !element.contains(target)) {
                    if (!ElementOptions.contains(target)) {
                      ElementOptions.classList.remove("active");
                    }
                  } else {
                    MainBody = document.querySelectorAll('.records_table tbody tr');
                    if (MainBody) {
                      MainBody.forEach(element => {
                        if (element.contains(target)) {
                          Library_ElementEngage = element;
                        }
                      })
                      if (target.hasAttribute("Update_item") && element.contains(target)) {
                        Library_validateKey = element.querySelector(".opt_element p").getAttribute("data-id");
                        ElementOptions.classList.remove("active");
                        Library_UpdateItemFunction(target)
                      }
                      if (target.hasAttribute("delete_item") && element.contains(target)) {
                        Library_validateKey = element.querySelector(".opt_element p").getAttribute("data-id");
                        Library_dn_message.classList.add("active");
                        ElementOptions.classList.remove("active");
                      }


                      if (target.classList.contains("add_item") && element.contains(target)) {
                        Library_AddEventMenuIndi.classList.add('active');
                        Library_AddEventMenuIndi.querySelector('form input[name="delete_key"]').value = target.getAttribute("data-id");
                        Library_Exclusion = true;

                      }
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
              Library_OptionElements.forEach((element) => {
                var ElementOptions = element.querySelector(".opt_element");
                if (element == target) {
                  DestructureJson(element);
                }

                if (ElementOptions != null) {
                  if (!ElementOptions.classList.contains("active") && element.contains(target)) {
                    ElementOptions.classList.add("active");
                  }

                  if (ElementOptions.classList.contains("active") &&
                    !element.contains(target)
                  ) {

                    if (!ElementOptions.contains(target)) {
                      ElementOptions.classList.remove("active");
                    }
                  } else {

                    MainBody.forEach(element => {
                      if (element.contains(target)) {
                        MainFormDel = element;
                      }
                    })
                    if (
                      target.classList.contains("Update_item") &&
                      element.contains(target)
                    ) {
                      Library_validateKey = target.getAttribute("data-id");
                      Library_UpdateItemFunction(target);
                      ElementOptions.classList.remove("active");
                    }
                    if (
                      target.classList.contains("delete_item") &&
                      element.contains(target)
                    ) {
                      Library_validateKey = target.getAttribute("data-id");
                      Library_dn_message.classList.add('active');
                      ElementOptions.classList.remove("active");
                    }

                  }
                }
              });
            }



          });

          function Library_UpdateItemFunction(value) {
            newObject = value.getAttribute("data-information");
            newObject = JSON.parse(newObject);
            document.querySelector('.event_menu_add input[name="name"]').value =
              newObject["name"];
            document.querySelector(
              '.event_menu_add input[name="author"]'
            ).value = newObject["Author"];
            document.querySelector(
              '.event_menu_add select[name="category"]'
            ).value = newObject["category"];
            document.querySelector(
              '.event_menu_add input[name="tag"]'
            ).value = newObject["tag"];
            document.querySelector(
              '.event_menu_add input[name="source"]'
            ).value = newObject["source"];
            document.querySelector(
              '.event_menu_add select[name="status"]'
            ).value = newObject["status"];
            document.querySelector('.event_menu_add input[name="date"]').value =
              newObject["date"];
            document.querySelector(
              '.event_menu_add input[name="delete_key"]'
            ).value = newObject["UniqueId"];
            Library_AddEventMenu.classList.add("active");
            APIDOCS =
              "../../API/Library/data_process.php?APICALL=true&&user=true&&submit=update_file";
            Update_tigger = true;
          }
          function Library_DeleteItemFunction(value, Library_validateKey) {
            if (value == "true" && confirmKey && location_updator() == "Library") {
              let API =
                "../../API/Library/data_process.php?APICALL=true&&user=true&&submit=delete_file";
              Library_PHPREQUESTDEL(API, Library_validateKey);
            } else if (value == "true" && !confirmKey && location_updator() == "Library") {
              API =
                "../../API/Library/data_process.php?APICALL=true&&user=true&&submit=delete_ini";
              Library_PHPREQUESTDEL(API, Library_validateKey);
            }
          }
          async function Library_PHPREQUESTIND(APIDOCS) {
            if (location_updator() == "Library") {
              let data;
              try {
                let loader = Library_AddEventMenuIndi.querySelector('form .error_information');
                const formMain = new FormData(Library_AddEventMenuIndi.querySelector('form'));
                controller = new AbortController();
                const Request = await fetch(APIDOCS, {
                  method: "POST",
                  body: formMain,
                });

                if (Request.status === 200) {
                  data = await Request.json();
                  loader.innerText = data;
                  if (data == "Upload was a success") {
                    APIDOCS =
                      "../../API/Library/data_process.php?APICALL=true&&user=true&&submit=fetchlatest";
                    Library_validateKey = Library_AddEventMenuIndi.querySelector('form input[name="delete_key"]').value;
                    Library_PHPLIVEUPDATE(APIDOCS, Library_validateKey);


                  }
                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          async function Library_PHPREQUEST(APIDOCS) {
            if (location_updator() == "Library") {
              let data;
              Library_loaderBtn.classList.add('play');
              Library_loaderBtn.classList.remove('active');
              try {
                const formMain = new FormData(Library_SubmitForm);
                formMain.append('fileNames', JSON.stringify(LibraryMediaFilenames));
                const Request = await fetch(APIDOCS, {
                  method: "POST",
                  body: formMain,
                });
                if (Request.status === 200) {
                  data = await Request.json();
                  Library_loaderBtn.classList.remove('play');
                  Library_loaderBtn.classList.add('active');
                  Library_loaderBtn.querySelector('.text p').textContent = data;

                  Library_requestData = data;
                  if (data == 'success' || data == 'Update success') {
                    APIDOCS =
                      "../../API/Library/data_process.php?APICALL=true&&user=true&&submit=fetchlatest";
                    if (!Library_validateKey) {
                      Library_validateKey = "";
                    }
                    Library_PHPLIVEUPDATE(APIDOCS, Library_validateKey);
                  }
                  r.cancel();
                } else {

                  Library_loaderBtn.classList.remove('play');
                  Library_loaderBtn.classList.add('active');
                  Library_loaderBtn.querySelector('.text p').textContent = "cannot find endpoint";
                }


              } catch (error) {
                Library_loaderBtn.classList.remove('play');
                Library_loaderBtn.classList.add('active');
                Library_loaderBtn.querySelector('.text p').textContent = "An error occurred";

              }
            }
          }
          async function Library_PHPREQUESTDEL(APIDOCS, Library_validateKey) {
            if (location_updator() == "Library") {
              let data;
              try {
                Library_ResponseView.classList.add('active');
                dataSend = {
                  key: Library_validateKey,
                };

                const Request = await fetch(APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  Library_ResponseView.innerText = data;
                  if (data == 'Item Deleted Successfully') {
                    if (Library_ElementEngage.querySelector('i').hasAttribute('data-id')) {
                      Library_DeleteItemI.push(Library_ElementEngage.querySelector('i').getAttribute('data-id'))
                    }
                    Library_ElementEngage.classList.add('hide')
                    Library_validateKey = '';
                  }
                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          async function Library_PHPLIVEUPDATE(APIDOCS, Library_validateKey) {
            if (location_updator() == "Library") {
              let data;
              try {
                if (!Library_Exclusion) {
                  dataSend = {
                    key: Library_validateKey
                  };
                  const Request = await fetch(APIDOCS, {
                    method: "POST",
                    body: JSON.stringify(dataSend),
                    headers: {
                      "Content-Type": "application/json",
                    },
                  });

                  if (Request.status === 200) {
                    data = await Request.json(data);
                    console.log(data, "No Records available");
                    if (data != '' || data != '' && data != 'Fetching data encounted a problem' && data != 'No Records Available') {
                      let ObjectDataFrame = JSON.parse(data);
                      Template = document.querySelector('.records_table table tbody');
                      for (const key in ObjectDataFrame) {
                        unique_id = ObjectDataFrame[key]['UniqueId'];
                        namer = ObjectDataFrame[key]['name'];
                        author = ObjectDataFrame[key]['Author'];
                        date = ObjectDataFrame[key]['date'];
                        source = ObjectDataFrame[key]['source'];
                        category = ObjectDataFrame[key]['category'];
                        statusi = ObjectDataFrame[key]['status'];
                        ObjectData = ObjectDataFrame[key]['Obj'];
                        cover = ObjectDataFrame[key]['cover'];
                        ObjectDataIndividual = ObjectDataFrame[key]['IObj'];
                        const CloneObject = document.querySelector('.CloneSearch tr').cloneNode(true);
                        if (CloneObject != '') {
                          const ElementDivCone = document.createElement('tr');
                          ElementDivCone.classList.add('SearchItem');
                          CloneObject.querySelector('.Clonecat a').setAttribute('href', `http://${source}`);
                          CloneObject.querySelector('.Clonedate').innerText = date;
                          CloneObject.querySelector('.Clonesource').innerText = category;
                          CloneObject.querySelector('.Cloneauthor').innerText = author;
                          CloneObject.querySelector('.Clonename').innerText = namer;
                          CloneObject.querySelector('.Cloneimg img').setAttribute('src', `../../API/Images_folder/library/covers/${cover}`)
                          CloneObject.querySelector('.Cloneitem').setAttribute('data-information', ObjectDataIndividual);
                          CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                          CloneObject.querySelector('.opt_element p.up').setAttribute('data-id', unique_id);
                          CloneObject.querySelector('.opt_element p.dp').setAttribute('data-id', unique_id);
                          CloneObject.querySelector('.opt_element p.up').setAttribute('Update_item', unique_id);
                          CloneObject.querySelector('.opt_element p.dp').setAttribute('delete_item', unique_id);
                          CloneObject.querySelector('.opt_element p.add_item').setAttribute('data-id', unique_id);
                          statusClass = CloneObject.querySelector('.btn_record');
                          if (statusi == 'active') {
                            statusClass.classList.add("in_btn");
                            statusClass.innerHTML = "<div></div>Active";
                          } else {
                            statusClass.classList.add("out_btn");
                            statusClass.innerHTML = "<div></div>Inactive";
                          }
                          ElementDivCone.innerHTML = CloneObject.innerHTML;
                          Template.prepend(ElementDivCone);
                          if (Library_requestData == 'Update success') {
                            Library_ElementEngage.classList.add('none');
                            Library_validateKey = '';
                            Library_ElementEngage = ElementDivCone;
                          }
                          Library_OptionElements = document.querySelectorAll(".btn_record");
                          Library_OptionElement_r = document.querySelectorAll(".option");
                          const element = ElementDivCone.querySelector('.option');
                          element.addEventListener("click", function () {
                            var ElementOptions = element.querySelector(".opt_element");
                            ElementOptions.classList.add("active");
                          });

                          const elementAdd = ElementDivCone.querySelector('.opt_element p.add_item');
                          elementAdd.addEventListener("click", function () {
                            Library_AddEventMenuIndi.classList.add("active");
                          });

                        }
                      }

                    }

                  } else {
                    console.error("cannot find endpoint");
                  }
                  Library_Exclusion = false;
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          Library_SubmitForm.addEventListener("submit", async function (e) {
            Library_ResponseView.innerText = "loading...";
            e.preventDefault();
            acceptedExtension = ['jpg', 'png', 'jpeg'];
            permission = true;
            console.log(Update_tigger && r.files.length);
            if (Update_tigger && r.files.length == 0) {
              Library_PHPREQUEST(APIDOCS);
            } else {
              if (r.files.length > 0) {
                if (r.files.length > 1) {
                  Library_loaderBtn.classList.add('active');
                  Library_loaderBtn.querySelector('.text p').textContent = "You can only upload a single file during upload";
                }
                LibraryMediaFilenames = [];
                r.files.forEach(element => {
                  if (acceptedExtension.includes(element.file.name.split('.')[1])) {
                    LibraryMediaFilenames.push(element.file.name);
                  } else {
                    permission = false;
                  }
                })
              }

              if (permission) {
                if (LibraryMediaFilenames.length > 0) {
                  if (LibraryMediaFilenames.length > 1 && Update_tigger) {
                    Library_loaderBtn.classList.add('active');
                    Library_loaderBtn.querySelector('.text p').textContent = "You can only upload a single file during update";
                  } else {
                    Library_loaderBtn.classList.add('play');
                    Library_loaderBtn.classList.remove('active');
                    r.upload();
                    r.on('complete', function () {
                      console.log('complete');
                      document.querySelector('#browseButton span').textContent = "Select file to Upload";
                      r.cancel();
                      Library_PHPREQUEST(APIDOCS);

                      LibraryMediaFilenames = [];
                    });

                  }

                }
              } else {
                Library_loaderBtn.classList.add('active');
                Library_loaderBtn.querySelector('.text p').textContent = "Files accepted should have either JPG,PNG,JPEG";
              }
            }

          });
          Library_AddEventMenuIndi.querySelector('form').addEventListener("submit", async function (e) {
            Library_AddEventMenuIndi.querySelector(".error_information").innerText = "loading...";
            e.preventDefault();
          });
          const searchSystem = debounce(async (APIDOCS, value) => {
            if (location_updator() == "Library") {
              let data;
              try {
                loader_progress.classList.add("active");
                ContentDom.classList.add("load");
                DomManipulationElement.classList.add("load");
                Library_dn_message.querySelector("p").innerText = "...processing request";
                dataSend = {
                  key: value,
                  numData: numoffset,
                };

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
                    if (typeof data == 'object') {
                      let ObjectDataFrame = data;
                      Template = "";
                      Template = document.querySelector('.records_table table tbody');
                      Template.innerHTML = "";
                      ObjectDataFrame = ObjectDataFrame['result'];
                      for (const key in ObjectDataFrame) {
                        unique_id = ObjectDataFrame[key]['UniqueId'];
                        namer = ObjectDataFrame[key]['name'];
                        author = ObjectDataFrame[key]['Author'];
                        date = ObjectDataFrame[key]['date'];
                        source = ObjectDataFrame[key]['source'];
                        category = ObjectDataFrame[key]['category'];
                        statusi = ObjectDataFrame[key]['status'];
                        ObjectData = ObjectDataFrame[key]['Obj'];
                        ObjectDataIndividual = ObjectDataFrame[key]['IObj'];
                        const CloneObject = document.querySelector('.CloneSearch tr').cloneNode(true);
                        if (CloneObject != '') {
                          const ElementDivCone = document.createElement('tr');
                          ElementDivCone.classList.add('SearchItem');

                          CloneObject.querySelector('.Clonecat').innerText = source;
                          CloneObject.querySelector('.Clonedate').innerText = date;
                          CloneObject.querySelector('.Clonesource').innerText = category;
                          CloneObject.querySelector('.Cloneauthor').innerText = author;
                          CloneObject.querySelector('.Clonename').innerText = namer;
                          CloneObject.querySelector('.Cloneitem').setAttribute('data-information', ObjectDataIndividual);
                          CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                          CloneObject.querySelector('.opt_element p.up').setAttribute('data-id', unique_id);
                          CloneObject.querySelector('.opt_element p.dp').setAttribute('data-id', unique_id);
                          CloneObject.querySelector('.opt_element p.up').setAttribute('Update_item', unique_id);
                          CloneObject.querySelector('.opt_element p.dp').setAttribute('delete_item', unique_id);
                          CloneObject.querySelector('.opt_element p.add_item').setAttribute('data_id', unique_id);
                          statusClass = CloneObject.querySelector('.btn_record');
                          if (statusi == 'active') {
                            statusClass.classList.add("in_btn");
                            statusClass.innerHTML = "<div></div>Active";
                          } else {
                            statusClass.classList.add("out_btn");
                            statusClass.innerHTML = "<div></div>Inactive";
                          }
                          ElementDivCone.innerHTML = CloneObject.innerHTML;
                          Template.prepend(ElementDivCone);
                          if (Library_requestData == 'Update success') {
                            Library_ElementEngage.classList.add('none');
                            Library_validateKey = '';
                          }
                          Library_OptionElements = document.querySelectorAll(".btn_record");
                          Library_OptionElement_r = document.querySelectorAll(".option");
                          const element = ElementDivCone.querySelector('.option');
                          element.addEventListener("click", function () {
                            var ElementOptions = element.querySelector(".opt_element");
                            ElementOptions.classList.add("active");
                          });

                          const elementAdd = ElementDivCone.querySelector('.opt_element p.add_item');
                          elementAdd.addEventListener("click", function () {
                            Library_AddEventMenuIndi.classList.add("active");
                          });

                        }
                      }




                      if (ObjectDataFrame['pages'] > 25) {
                        ConvertPages = ObjectDataFrame['pages'];
                        RestructurePages(ConvertPages);
                      }

                    } else {
                      Library_ResponseView.classList.add('active');
                      Library_ResponseView.innerText = data;
                      document.querySelector('.skeleton_loader').classList.remove('load');
                    }
                  } else {
                    console.error("cannot find endpoint");
                  }
                  loader_progress.classList.remove("active");
                  ContentDom.classList.remove("load");
                  DomManipulationElement.classList.remove("load");
                }
              } catch (error) {
                console.error(error);
              }
            }

          })
        }
        if (location == 'Tithe') {
          let Tithe_APIDOCS;
          let Tithe_validateKey = false;
          let Tithe_requestData;
          let Tithe_MainFormDel = false;
          let d = "";
          const Tithe_loaderBtn = document.querySelector(".event_menu_add.form_data .loader_wrapper");
          const Tithe_AddEventMenu = document.querySelector(".event_menu_add.form_data");
          const Tithe_ResponseView = document.querySelector(".info_information.event_menu_add");
          const Tithe_AddEventMenuForm = Tithe_AddEventMenu.querySelector("form");
          const Tithe_filter_option = document.querySelectorAll(".filter_option");
          var Tithe_OptionElements = document.querySelectorAll(".delete.option");
          const Tithe_Export_variables = document.querySelector('#ExportBtn');
          const Tithe_Export_variables_Dialogue = document.querySelector('.export_dialogue');
          const Tithe_Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
          const Tithe_Export_variables_Dialogue_Form = Tithe_Export_variables_Dialogue.querySelector("form");
          const Tithe_AddEventBtn = document.querySelector(".add_event");
          const Tithe_dn_message = document.querySelector(".dn_message");
          const Tithe_searchInput = document.querySelector("#searchInput");
          const Tithe_searchBtn = document.querySelector("#searchBtn");
          const Tithe_confirmsBtns = document.querySelectorAll(".btn_confirm");
          const Tithe_BatchUpload = document.querySelector('#data_upload');
          let Tithe_BatchUpload_Content = false;
          Tithe_BatchUpload.addEventListener('click', function () {
            BatchSelect.click();
          });
          BatchSelect.addEventListener('change', function (e) {
            if (e.target.files[0]) {
              Tithe_BatchUpload_Content = e.target.files[0];
              ExtensionName = Tithe_BatchUpload_Content.name.split('.');
              ExtensionNameList = ['xlsx', 'xlx', 'xls'];
              console.log('ExtensionName');
              if (ExtensionNameList.includes(ExtensionName[1].toLowerCase())) {
                BatchPlatform.querySelector('header').textContent = `${Tithe_BatchUpload_Content.name} has been selected. Click on the upload button to proceed`;
              } else {
                BatchPlatform.querySelector('header').textContent = `Target file must be in excel formate.!!!`;
              }

              BatchPlatform.classList.add('active');
            }

          });

          BatchPlatform.querySelector('button').addEventListener('click', function () {
            tithe_permission_key = true;
            if (Tithe_BatchUpload_Content != false) {
              BatchPlatform.querySelector('.loader_wrapper').classList.add('play');
              var File_reader = new FileReader();
              File_reader.onload = function (event) {
                var data = new Uint8Array(event.target.result);
                var workbook = XLSX.read(data, {
                  type: "array"
                });
                workbook.SheetNames.forEach((sheet) => {
                  let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                  rowObject.forEach(element => {
                    ObjectKeys = Object.keys(element);
                    defaultLength = ObjectKeys.length + 1;
                    if (defaultLength == 6 || defaultLength == 5) {
                      if (ObjectKeys.includes('id') || ObjectKeys.includes('ID') || ObjectKeys.includes('Id') || ObjectKeys.includes('iD')) {
                        delete element[ObjectKeys[0]];
                        console.log(element);
                      }
                    }
                    if (defaultLength > 7 || defaultLength < 5) {
                      tithe_permission_key = false;
                    }
                  })

                  if (!tithe_permission_key) {
                    BatchPlatform.querySelector('header').textContent = `Uploaded file ought to have 5 columns, unequal columns detected !!`;
                  } else {

                    BatchPlatform.querySelector('header').textContent = ` Number of file to expected to upload : ${rowObject.length}`;

                    rowObject.forEach(element => {
                      Tithe_Batch(element).then(data => {
                        if (data == 'success') {
                          BatchPlatform.querySelector('.upload').innerHTML += `<p>Uploading data ${rowObject.indexOf(element)} was a success</p>`;
                        } else {
                          BatchPlatform.querySelector('.error').innerHTML += `<p>Uploading data ${rowObject.indexOf(element)} encountered an error ${data}</p>`;
                        }
                      }).catch(error => {
                        console.log(error);
                      })

                    })

                  }
                  BatchPlatform.querySelector('.loader_wrapper').classList.remove('play');
                })
              }
              File_reader.readAsArrayBuffer(Tithe_BatchUpload_Content);
            }
            Tithe_BatchUpload_Content = false;

          })

          Tithe_AddEventBtn.addEventListener("click", function (e) {
            Tithe_AddEventMenu.classList.add('active');
            Tithe_APIDOCS = TitheCall.DirCalls('Upload');
          });
          const Tithe_AddEventMenu_Btn = document.querySelector(
            ".event_menu_add Button"
          );
          Tithe_Export_variables_Dialogue_Form.addEventListener('submit', function (e) {
            e.preventDefault();
          })
          Tithe_Export_variables.onclick = function () {
            Tithe_Export_variables_Dialogue.classList.add("active");
          };
          Tithe_Export_variables_Dialogue_Btn.addEventListener('click', async function () {
            Tithe_APIDOCS = TitheCall.DirCalls('Export');
            ExportData('Tithe', 'excel', Tithe_APIDOCS)
          })
          var Tithe_FilterUI = document.querySelector(".notification_list_filter");
          var Tithe_FilterUIList = document.querySelectorAll(".notification_list_filter .item");
          Tithe_FilterUIList.forEach(element => {
            element.addEventListener('click', function () {
              setTimeout(() => {
                value = element.innerText;
                Tithe_FilterUI.classList.remove("active");
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
          Tithe_searchBtn.addEventListener("click", e => {
            Tithe_APIDOCS = TitheCall.DirCalls('Search');
            if (Tithe_searchInput.value != " " && Tithe_searchInput.value != "") {
              searchSystem(Tithe_APIDOCS, Tithe_searchInput.value);
            }

          })

          Tithe_AddEventMenuForm.addEventListener("submit", function (e) {
            e.preventDefault();
          });
          Tithe_confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (Tithe_validateKey != "") {
                  TitheCall.DeleteItemFunction(element.getAttribute("data-confirm"), Tithe_validateKey, Tithe_ResponseView, Tithe_MainFormDel, location_updator());
                }
              } else {
                Tithe_dn_message.classList.remove("active");
              }
            });
          });
          Tithe_AddEventMenu_Btn.onclick = function () {
            Tithe_AddEventMenu.classList.add("active");
            Tithe_loaderBtn.classList.add("active");
            Tithe_validateKey = false;
            var formCondiions = document.querySelectorAll(".form_condition");
            if (ConditionFeilds(formCondiions) != false) {
              TitheCall.PHPREQUEST(Tithe_APIDOCS, Tithe_loaderBtn, Tithe_AddEventMenuForm, Tithe_requestData, Tithe_validateKey, Tithe_MainFormDel, location_updator()).then(data => {
                if (typeof data == 'object') {
                  Tithe_MainFormDel = data[1];
                }
              });
              validateKey = '';
            } else {
              Tithe_loaderBtn.innerText = "All feilds are required";
            }
          };
          window.addEventListener("click", function (e) {
            if (location_updator() == 'Tithe') {
              var Tithe_target = e.target;

              if (BatchPlatform.classList.contains("active") && !Tithe_BatchUpload.contains(Tithe_target)) {
                if (!BatchPlatform.contains(Tithe_target)) {
                  BatchPlatform.classList.remove("active");

                  BatchSelect.value = "";
                  BatchPlatform.querySelector('header').textContent = ` `;
                  BatchPlatform.querySelector('.upload').innerHTML = ` `;
                  BatchPlatform.querySelector('.error').innerHTML = ` `;


                }
              }

              const Tithe_Pages = document.querySelectorAll(".pages div");
              if (Tithe_AddEventMenu.classList.contains("active") && !Tithe_AddEventBtn.contains(Tithe_target)
              ) {
                if (!Tithe_AddEventMenu.contains(Tithe_target)) {
                  Tithe_AddEventMenu.classList.remove("active");
                }
              }

              Tithe_OptionElements.forEach((element) => {
                var ElementOptions = element.querySelector(".opt_element");
                if (ElementOptions != null) {
                  if (!ElementOptions.classList.contains("active") && element.contains(Tithe_target)) {
                    ElementOptions.classList.add("active");
                  }
                  if (ElementOptions.classList.contains("active") &&
                    !element.contains(Tithe_target)
                  ) {
                    if (!ElementOptions.contains(Tithe_target)) {
                      ElementOptions.classList.remove("active");
                    }
                  } else {
                    Tithe_MainBody = document.querySelectorAll('#main_table tbody tr');
                    if (Tithe_MainBody) {
                      Tithe_MainBody.forEach(element => {
                        if (element.contains(Tithe_target)) {
                          Tithe_MainFormDel = element;
                        }
                      })

                      if (Tithe_target.hasAttribute("Update_item") && element.contains(Tithe_target)) {
                        setTimeout(() => {
                          Tithe_APIDOCS = TitheCall.DirCalls('Update');
                          TitheCall.UpdateItemFunction(Tithe_target);
                          ElementOptions.classList.remove("active");
                        }, 200);
                        Tithe_validateKey = element.querySelector(".opt_element p").getAttribute("Update_item");
                      }
                      if (Tithe_target.hasAttribute("delete_item") && element.contains(Tithe_target)) {
                        Tithe_validateKey = element.querySelector(".opt_element p").getAttribute("Update_item");
                        Tithe_dn_message.classList.add("active");
                        ElementOptions.classList.remove("active");
                      }
                    }
                  }
                }
              });
              if (Tithe_Export_variables_Dialogue.classList.contains('active') && !Tithe_Export_variables.contains(Tithe_target)) {
                if (!Tithe_Export_variables_Dialogue.contains(Tithe_target)) {
                  Tithe_Export_variables_Dialogue.classList.remove('active')
                }
              }
              setTimeout(() => {
                if (!Tithe_ResponseView.contains(Tithe_target) && !Tithe_target.classList.contains('btn_confirm')) {
                  if (Tithe_ResponseView.classList.contains('active')) {
                    Tithe_ResponseView.classList.remove('active');
                    Tithe_ResponseView.innerText = ""
                  }
                }
              }, 100)

              Tithe_filter_option.forEach((element) => {
                if (!element.contains(Tithe_target)) {
                  element.querySelector(".select").classList.remove("active");
                }
              });
              Tithe_Pages.forEach((element) => {
                if (element.contains(target)) {
                  value = element.innerHTML;
                  pagnationSystem(value);
                }
              });

            }
          });
          const searchSystem = debounce(async (Tithe_APIDOCS, value) => {
            if (location_updator() == 'Tithe') {
              let data;
              try {
                loader_progress.classList.add("active");
                ContentDom.classList.add("load");
                DomManipulationElement.classList.add("load");
                Tithe_dn_message.querySelector("p").innerText = "...processing request";
                dataSend = {
                  key: value,
                  numData: numoffset,
                };

                const Request = await fetch(Tithe_APIDOCS, {
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
                          Tithe_OptionElements = document.querySelectorAll(".option");
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
                    console.error("cannot find endpoint");
                  }
                  loader_progress.classList.remove("active");
                  ContentDom.classList.remove("load");
                  DomManipulationElement.classList.remove("load");
                }
              } catch (error) {
                console.error(error);
              }
            }

          })
          async function Tithe_Batch(element) {
            if (location_updator() == "Tithe") {
              if (typeof element == 'object') {
                try {

                  Keys = Object.keys(element);

                  if (Keys.length == 5) {
                    TitheCheck_APIDOCS = "../../API/finance/data_process.php?confirm_name=true&&submit=true";
                    const Request_Check = await fetch(TitheCheck_APIDOCS, {
                      method: "POST",
                      body: JSON.stringify({ name: element[Keys[0]] }),
                    });

                    if (Request_Check.status === 200) {
                      data = await Request_Check.json();
                      console.log(typeof data);
                      if (parseInt(data)) {
                        const formMain = new FormData();
                        formMain.append('Name', parseInt(data));
                        formMain.append('amount', element[Keys[1]]);
                        formMain.append('Date', element[Keys[2]]);
                        formMain.append('details', element[Keys[3]]);
                        formMain.append('medium', element[Keys[4]]);

                        Memebership_APIDOCS = "../../API/finance/data_process.php?APICALL=tithe&&user=true&&submit=upload";
                        const Request = await fetch(Memebership_APIDOCS, {
                          method: "POST",
                          body: formMain,
                        });

                        if (Request.status === 200) {
                          data = await Request.json();
                          return data
                        } else {
                          return `request responded with ${Request.status}`;
                        }
                      } else {
                        return `name- ${element[Keys[0]]} does not exist in the database as a member`
                      }

                    } else {
                      return "request error";
                    }

                  } else {
                    return `data is missing a columns `
                  }

                } catch (error) {
                  return error
                }
              } else {
                return "Connot convert file";
              }

            } else {
              return false;
            }
          }
        }

        if (location == "Assets") {
          let Assets_APIDOCS;
          var Assets_newObject = "";
          let Assets_requestData;
          let Assets_validateKey = false;
          let Assets_MainFormDel = "";
          AssetsMediaFilenames = [];
          Update_tigger = false;
          const Assets_dn_message = document.querySelector(".dn_message");
          const Assets_confirmsBtns = document.querySelectorAll(".btn_confirm");
          const Assets_AddEventBtn = document.querySelector(".add_event");
          var Assets_OptionElements = document.querySelectorAll(".option");
          const Assets_SubmitForm = document.querySelector(".event_menu_add.form_data form");
          const Assets_loaderBtn = document.querySelector(".loader_wrapper");
          const Assets_loaderView = document.querySelector('.info_information.event_menu_add');
          const Assets_imageCompound = document.querySelector('.event_menu_add.form_data input[name="imageFile"]');
          const Assets_FilterBtn = document.querySelector(".filterBtn");
          var Assets_FilterUI = document.querySelector(".notification_list_filter");
          var Assets_FilterUIList = document.querySelectorAll(".notification_list_filter .item");
          const Assets_Export_variables = document.querySelector('#ExportBtn');
          const Assets_Export_variables_Dialogue = document.querySelector('.export_dialogue');
          const Assets_Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
          const Assets_Export_variables_Dialogue_Form = Assets_Export_variables_Dialogue.querySelector("form");
          const AddEventMenu = document.querySelector(".event_menu_add.form_data");
          var Assets_OptionElements = document.querySelectorAll(".option");
          Assets_AddEventBtn.addEventListener("click", function (e) {
            AddEventMenu.classList.add("active");
          });
          if (location_updator() == "Assets") {
            r.assignBrowse(document.getElementById('browseButton'));
            r.on('filesAdded', function (array) {
              document.querySelector('#browseButton span').textContent = `${r.files.length} file has been added`;
            });
            document.getElementById('browseButton').addEventListener('click', function () {
              r.cancel();
            });
          }

          Assets_Export_variables_Dialogue_Form.addEventListener('submit', function (e) {
            e.preventDefault();
          })
          Assets_Export_variables.onclick = function () {
            Assets_Export_variables_Dialogue.classList.add("active");
          };
          Assets_Export_variables_Dialogue_Btn.addEventListener('click', async function () {
            Assets_APIDOCS =
              "../../API/Assets&projects/data_process.php?APICALL=true&&user=assets&&submit=export";
            ExportData('AssetsExport', 'excel', Assets_APIDOCS)
          })
          Assets_FilterUIList.forEach(element => {
            element.addEventListener('click', function () {
              value = element.innerText;
              Assets_FilterUI.classList.remove("active");
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
            if (location_updator() == 'Assets') {
              var target = e.target;
              var Assets_FilterUI = document.querySelector(".notification_list_filter");
              const Assets_Pages = document.querySelectorAll(".pages div");
              var Assets_OptionElements = document.querySelectorAll(".option");
              if (AddEventMenu.classList.contains("active") && !Assets_AddEventBtn.contains(target)) {
                if (!AddEventMenu.contains(target)) {
                  AddEventMenu.classList.remove("active");
                  Assets_validateKey = false;
                  r.cancel();
                  true
                }
              }
              if (Assets_Export_variables_Dialogue.classList.contains('active') && !Assets_Export_variables.contains(target)) {
                if (!Assets_Export_variables_Dialogue.contains(target)) {
                  Assets_Export_variables_Dialogue.classList.remove('active')
                }
              }

              if (!Assets_FilterBtn.contains(target) && !Assets_FilterUI.contains(target)) {
                if (Assets_FilterUI.classList.contains("active")) {
                  Assets_FilterUI.classList.remove("active");
                }
              } else {
                Assets_FilterUI.classList.add("active");
              }
              Assets_OptionElements.forEach((element) => {
                var ElementOptions = element.querySelector(".opt_element");
                if (ElementOptions != null) {
                  if (!ElementOptions.classList.contains("active") && element.contains(target)) {
                    ElementOptions.classList.add("active");
                  }
                  if (
                    ElementOptions.classList.contains("active") &&
                    !element.contains(target)
                  ) {
                    if (!ElementOptions.contains(target)) {
                      ElementOptions.classList.remove("active");
                    }
                  } else {
                    Assets_MainBody = document.querySelectorAll('.records_table tbody tr');
                    if (Assets_MainBody) {
                      Assets_MainBody.forEach(element => {
                        if (element.contains(target)) {
                          Assets_MainFormDel = element;
                        }
                      })
                      if (
                        target.classList.contains("Update_item") &&
                        element.contains(target)
                      ) {
                        Assets_validateKey = target.getAttribute("data-id");
                        Assets_UpdateItemFunction(target);
                        ElementOptions.classList.remove("active");
                      }

                      if (
                        target.classList.contains("delete_item") &&
                        element.contains(target)
                      ) {
                        Assets_validateKey = target.getAttribute("data-id");
                        Assets_MainFormDel = target.parentElement.parentElement.parentElement;
                        Assets_dn_message.classList.add('active');
                        ElementOptions.classList.remove("active");
                      }
                    }
                  }
                }
              });
              setTimeout(() => {
                if (!Assets_loaderView.contains(target) && !target.classList.contains('btn_confirm')) {
                  if (Assets_loaderView.classList.contains('active')) {
                    Assets_loaderView.classList.remove('active');
                    Assets_loaderView.innerText = "";
                  }
                }
              }, 100)
              Assets_Pages.forEach((element) => {
                if (element.contains(target)) {
                  value = element.innerHTML;
                  pagnationSystem(value);
                }
              });

            }

          });

          Assets_confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (Assets_validateKey != "") {
                  Assets_DeleteItemFunction(
                    element.getAttribute("data-confirm"),
                    Assets_validateKey
                  );
                }
              }
            });
          });

          Assets_AddEventBtn.addEventListener("click", function (e) {
            Assets_APIDOCS =
              "../../API/Assets&projects/data_process.php?APICALL=true&&user=true&&submit=true";

          });
          function Assets_UpdateItemFunction(value) {
            const AddEventMenu = document.querySelector(".event_menu_add.form_data");
            Assets_newObject = value.getAttribute("data-information");
            Assets_newObject = JSON.parse(Assets_newObject);

            document.querySelector('.event_menu_add.form_data input[name="name"]').value =
              Assets_newObject["name"];
            document.querySelector(
              '.event_menu_add.form_data input[name="source"]'
            ).value = Assets_newObject["source"];
            document.querySelector(
              '.event_menu_add.form_data input[name="location"]'
            ).value = Assets_newObject["location"];
            document.querySelector('.event_menu_add.form_data input[name="date"]').value =
              Assets_newObject["date"];
            document.querySelector(
              '.event_menu_add.form_data select[name="status"]'
            ).value = Assets_newObject["status"];
            document.querySelector(
              '.event_menu_add.form_data input[name="value"]'
            ).value = Assets_newObject["value"];
            document.querySelector(
              '.event_menu_add.form_data input[name="total"]'
            ).value = Assets_newObject["total"];
            document.querySelector(".event_menu_add.form_data textarea").value =
              Assets_newObject["About"];
            document.querySelector(
              '.event_menu_add.form_data input[name="delete_key"]'
            ).value = Assets_newObject["id"];
            AddEventMenu.classList.add("active");
            Assets_APIDOCS =
              "../../API/Assets&projects/data_process.php?APICALL=true&&user=true&&submit=update_file";
            Update_tigger = true;
          }

          function Assets_DeleteItemFunction(value, Assets_validateKey) {
            if (value == "true" && location_updator() == 'Assets') {
              Assets_loaderView.classList.add('active');
              let API =
                "../../API/Assets&projects/data_process.php?APICALL=true&&user=true&&submit=delete_file";
              Assets_PHPREQUESTDEL(API, Assets_validateKey);
            }
          }
          async function Assets_PHPREQUEST(Assets_APIDOCS) {
            if (location_updator() == 'Assets') {
              let data;
              Assets_loaderBtn.classList.add('play');
              Assets_loaderBtn.classList.remove('active');
              try {
                const formMain = new FormData(Assets_SubmitForm);
                formMain.append('fileNames', JSON.stringify(AssetsMediaFilenames));
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

                const Request = await fetch(Assets_APIDOCS, {
                  method: "POST",
                  body: formMain,
                });

                if (Request.status === 200) {
                  data = await Request.json();
                  Assets_requestData = data;
                  Assets_loaderBtn.classList.remove('play');
                  Assets_loaderBtn.classList.add('active');
                  Assets_loaderBtn.querySelector('.text p').textContent = data;

                  if (data == 'success' || data == 'Update success') {
                    if (!Assets_validateKey) {
                      Assets_validateKey = "";
                    }
                    Assets_APIDOCS = "../../API/Assets&projects/data_process.php?APICALL=true&&user=true&&submit=fetchlatest";
                    Assets_PHPLIVEUPDATE(Assets_APIDOCS, Assets_validateKey)

                  }
                  r.cancel();
                } else {
                  Assets_loaderBtn.classList.remove('play');
                  Assets_loaderBtn.classList.add('active');
                  Assets_loaderBtn.querySelector('.text p').textContent = "cannot find endpoint";
                }
              } catch (error) {
                Assets_loaderBtn.classList.remove('play');
                Assets_loaderBtn.classList.add('active');
                Assets_loaderBtn.querySelector('.text p').textContent = error;

              }
            }
          }

          async function Assets_PHPREQUESTDEL(Assets_APIDOCS, Assets_validateKey) {
            if (location_updator() == 'Assets') {
              let data;

              try {
                Assets_loaderView.classList.add('active')
                dataSend = {
                  key: Assets_validateKey,
                };

                const Request = await fetch(Assets_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  if (data == 'success') {
                    Assets_MainFormDel.classList.add('none')
                    Assets_loaderView.innerText = data;
                  }
                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          async function Assets_PHPLIVEUPDATE(Assets_APIDOCS, Assets_validateKey) {
            if (location_updator() == 'Assets') {
              let data;
              try {
                dataSend = {
                  key: Assets_validateKey
                };
                const Request = await fetch(Assets_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  if (typeof data == 'object') {
                    Template = document.querySelector('.records_table tbody');
                    let CloneObject = document.querySelector('.CloneSearch').cloneNode(true);
                    ObjectDataFrame = JSON.parse(data);
                    for (const key in ObjectDataFrame) {
                      unique_id = ObjectDataFrame[key]['id'];
                      Name = ObjectDataFrame[key]['name'];
                      Source = ObjectDataFrame[key]['source'];
                      Location = ObjectDataFrame[key]['location'];
                      Items = ObjectDataFrame[key]['total'];
                      date = ObjectDataFrame[key]['date'];
                      Status = ObjectDataFrame[key]['status'];
                      image = ObjectDataFrame[key]['Image'];
                      value = ObjectDataFrame[key]['value'];
                      message = ObjectDataFrame[key]['About'];
                      ObjectData = ObjectDataFrame[key]['Obj'];

                      if (CloneObject != '') {

                        const ElementDivCone = document.createElement('tr');
                        CloneObject.querySelector('.Clonename').innerText = Name;
                        CloneObject.querySelector('.Cloneitem').innerText = Items;
                        CloneObject.querySelector('.Cloneimage').setAttribute('src', `../../API/Images_folder/Assets/${image}`);
                        CloneObject.querySelector('.Clonesource').innerText = Source;
                        CloneObject.querySelector('.Clonevalue').innerText = value;
                        CloneObject.querySelector('.Clonelocation').innerText = location;
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-id', unique_id);
                        CloneObject.querySelector('.opt_element p.dp').setAttribute('data-id', unique_id);
                        ElementDivCone.innerHTML = CloneObject.innerHTML;
                        if (Assets_requestData == 'Update success') {
                          Assets_MainFormDel.classList.add('none');
                        }
                        Template.prepend(ElementDivCone);
                        Assets_MainFormDel = ElementDivCone;
                        Assets_OptionElements = document.querySelectorAll(".option");
                        const element = ElementDivCone.querySelector('.option');
                        element.addEventListener("click", function () {
                          var ElementOptions = element.querySelector(".opt_element");
                          ElementOptions.classList.add("active");
                        });
                      }


                    }

                  }

                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }

          Assets_SubmitForm.addEventListener("submit", async function (e) {
            e.preventDefault();

            acceptedExtension = ['jpg', 'png', 'jpeg'];
            permission = true;
            if (Update_tigger && r.files.length == 0) {
              Assets_PHPREQUEST(Assets_APIDOCS);
            } else {
              if (r.files.length > 0) {
                if (r.files.length > 1) {
                  Assets_loaderBtn.classList.add('active');
                  Assets_loaderBtn.querySelector('.text p').textContent = "You can only upload a single file during upload";
                }
                AssetsMediaFilenames = [];
                r.files.forEach(element => {
                  if (acceptedExtension.includes(element.file.name.split('.')[1])) {
                    AssetsMediaFilenames.push(element.file.name);
                  } else {
                    permission = false;
                  }
                })
              }

              if (permission) {
                if (AssetsMediaFilenames.length > 0) {
                  if (AssetsMediaFilenames.length > 1 && Update_tigger) {
                    Assets_loaderBtn.classList.add('active');
                    Assets_loaderBtn.querySelector('.text p').textContent = "You can only upload a single file during update";
                  } else {
                    Assets_loaderBtn.classList.add('play');
                    Assets_loaderBtn.classList.remove('active');
                    r.upload();
                    r.on('complete', function () {
                      console.log('complete');
                      document.querySelector('#browseButton span').textContent = "Select file to Upload";
                      r.cancel();
                      Assets_PHPREQUEST(Assets_APIDOCS);

                      AssetsMediaFilenames = [];
                    });

                  }

                }
              } else {
                Assets_loaderBtn.classList.add('active');
                Assets_loaderBtn.querySelector('.text p').textContent = "Files accepted should have either JPG,PNG,JPEG";
              }
            }

          });
        }
        if (location == "Announcement") {
          let Announcement_APIDOCS;
          let Change_status = false;
          let Update_trigger = false;
          let AnccMediaFilenames = [];
          const Announcement_AddEventBtn = document.querySelector(".add_event");
          const Announcement_ResponseView = document.querySelector(".loader_wrapper");
          const toggleModes = document.querySelectorAll(".toggle_mode");
          const Annoucement_loaderView = document.querySelector('.info_information.event_menu_add');
          const Announcement_loaderBtn = document.querySelector(".event_menu_add.form_data .loader_wrapper");
          const Announcement_SubmitForm = document.querySelector(".event_menu_add.form_data form");
          const Announcement_AddEventMenu = document.querySelector(".event_menu_add.form_data");
          let requestData;
          Announcement_AddEventBtn.addEventListener("click", function (e) {
            Announcement_APIDOCS =
              "../../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=true";
            Announcement_AddEventMenu.classList.add("active");
          });
          Announcement_SubmitForm.addEventListener("submit", async function (e) {
            e.preventDefault();
            permission = true;
            if (Update_trigger && r.files.length == 0) {
              Announcement_PHPREQUEST(Announcement_APIDOCS);
            } else {
              if (r.files.length > 0) {
                if (r.files.length > 1) {
                  Announcement_loaderBtn.classList.add('active');
                  Announcement_loaderBtn.querySelector('.text p').textContent = "You can only upload a single file during upload";
                }
                AnccMediaFilenames = [];
                r.files.forEach(element => {
                  AnccMediaFilenames.push(element.file.name);
                })
              } else {
                Announcement_PHPREQUEST(Announcement_APIDOCS);
              }
              if (permission) {
                if (AnccMediaFilenames.length > 0) {
                  if (AnccMediaFilenames.length > 1 && Update_trigger) {
                    Announcement_loaderBtn.classList.add('active');
                    Announcement_loaderBtn.querySelector('.text p').textContent = "You can only upload a single file during update";
                  } else {
                    Announcement_loaderBtn.classList.add('play');
                    Announcement_loaderBtn.classList.remove('active');
                    r.upload();
                    r.on('complete', function () {
                      console.log('complete');
                      document.querySelector('#browseButton span').textContent = "Select file to Upload";
                      r.cancel();
                      Announcement_PHPREQUEST(Announcement_APIDOCS);
                      AnccMediaFilenames = [];
                    });
                    r.on('fileError', function () {
                      Announcement_loaderBtn.classList.remove('play');
                      Announcement_loaderBtn.classList.remove('active');
                      Announcement_loaderBtn.querySelector('.text p').textContent = "An error occurred in uploading this file";
                    })
                    r.on('error', function () {
                      Announcement_loaderBtn.classList.remove('play');
                      Announcement_loaderBtn.classList.remove('active');
                      Announcement_loaderBtn.querySelector('.text p').textContent = "An error occurred in uploading this file";
                    })
                  }

                }
              } else {
                Announcement_loaderBtn.classList.remove('play');
                Announcement_loaderBtn.classList.add('active');
                Announcement_loaderBtn.querySelector('.text p').textContent = "Files accepted should have either JPG,PNG,JPEG";
              }
            }


          });

          searchBtn.addEventListener("click", e => {
            Announcement_APIDOCS =
              "../../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=search";

            if (searchInput.value != " " && searchInput.value != "") {
              searchSystem(Announcement_APIDOCS, searchInput.value);
            }

          })

          if (location_updator() == "Announcement") {
            r.assignBrowse(document.getElementById('browseButton'));
            r.on('filesAdded', function (array) {
              document.querySelector('#browseButton span').textContent = `${r.files.length} file has been added`;
            });

          }
          window.addEventListener("click", function (e) {
            if (location_updator() == "Announcement") {
              var target = e.target;
              let targetMain = '';
              if (target.parentElement.classList.contains('toggle_mode')) {
                targetMain = target.parentElement;
              }
              if (target.parentElement.parentElement.classList.contains('toggle_mode')) {
                targetMain = target.parentElement.parentElement;

              }
              if (target.classList.contains('toggle_mode')) {
                targetMain = target;
              }
              Id = "";

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

                if (targetMain.hasAttribute("data-id")) {
                  Id = targetMain.getAttribute("data-id");
                }

                if (Id != "") {

                  Announcement_APIDOCS =
                    "../../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=status";
                  if (Announcement_PHPREQUESTSTATUS(Announcement_APIDOCS, Change_status, Id)) {
                    targetMain.classList.toggle('active');
                  } else {
                    alert("Sorry, an error occured activation the announcement");
                  }
                }


              }


              if (
                Announcement_AddEventMenu.classList.contains("active") &&
                !Announcement_AddEventBtn.contains(target)
              ) {
                if (!Announcement_AddEventMenu.contains(target)) {
                  Announcement_AddEventMenu.classList.remove("active");
                  Announcement_loaderBtn.querySelector('.text p').textContent = "";
                  r.cancel();
                }
              }

              if (target.classList.contains("Update_item")) {
                ElementEngage = target.parentElement.parentElement.parentElement;
                validateKey = target.getAttribute("data-id");
                setTimeout(() => {
                  UpdateItemFunction(target);
                }, 100)

              }
              if (target.classList.contains("delete_item")) {
                dn_message.classList.add("active");
                ElementEngage = target.parentElement.parentElement.parentElement;
                if (target.hasAttribute("data-id")) {
                  validateKey = target.getAttribute("data-id");
                }
              }

              setTimeout(() => {
                if (!Annoucement_loaderView.contains(target) && !target.classList.contains('btn_confirm')) {
                  if (Annoucement_loaderView.classList.contains('active')) {
                    Annoucement_loaderView.classList.remove('active');
                    Annoucement_loaderView.innerText = "";
                  }
                }
              }, 100)
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

          async function EmailSend(reciever_id) {
            const ElementReciever = reciever_id;
            const Checkbox = document.querySelector('.event_menu_add.form_data input[type="checkbox"]');
            if (ElementReciever !== null) {
              if (Checkbox.checked) {
                dataSendKey = {
                  key: ElementReciever.value,
                };
                try {
                  Announcement_APIDOCS =
                    "../../API/ministriesData & theme/data_process.php?APICALL=true&&user=true&&submit=list";
                  const Request = await fetch(Announcement_APIDOCS, {
                    method: "POST",
                    body: JSON.stringify(dataSendKey),
                    headers: {
                      "Content-Type": "application/json",
                    }
                  });

                  if (Request.status === 200) {
                    data = await Request.json();
                    Announcement_loaderBtn.querySelector('.text p').textContent = data;

                    if (data == 'success' || data == 'Update success' || data['status'] == 'success') {

                      if (typeof data['data'] == 'object') {
                        Announcement_loaderBtn.innerText = 'Announcement data was uploaded successfully. please wait, as we send the emails accordingly';
                        EmailList = data['data'];
                        for (item in EmailList) {
                          emailjs.sendForm('service_sffdk0b', 'template_jihe9xi', this, { recipientEmail: item })
                            .then(() => {
                              Announcement_loaderBtn.querySelector('.text p').textContent = "SUCCESS";
                            }, (error) => {
                              Announcement_loaderBtn.querySelector('.text p').textContent = error;
                            });
                        }

                      }
                    }
                  } else {
                    Announcement_loaderBtn.querySelector('.text p').textContent = "cannot find endpoint";
                  }
                } catch (error) {
                  Announcement_loaderBtn.querySelector('.text p').textContent = "An error occurred";

                }
              }
            }
          }

          function UpdateItemFunction(value) {
            const Announcement_AddEventMenu = document.querySelector(".event_menu_add.form_data");
            newObject = value.getAttribute("data-information");
            newObject = JSON.parse(newObject);

            document.querySelector('.event_menu_add.form_data input[name="name"]').value =
              newObject["name"] || newObject["title"];
            document.querySelector(
              '.event_menu_add.form_data textarea[name="message"]'
            ).value = newObject["message"];
            document.querySelector(
              '.event_menu_add.form_data input[name="delete_key"]'
            ).value = newObject["Id"] || newObject["id"];
            document.querySelector(
              '.event_menu_add.form_data select[name="receiver"]'
            ).value = newObject["receiver"];
            document.querySelector('.event_menu_add.form_data input[name="date"]').value =
              newObject["date"];

            Announcement_AddEventMenu.classList.add("active");
            Announcement_APIDOCS =
              "../../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=update";
          }
          function DeleteItemFunction(value, validateKey) {
            if (value == "true" && location_updator() == "Announcement") {
              let API =
                "../../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=delete_file";
              Announcement_PHPREQUESTDEL(API, validateKey);
            }
          }
          async function Announcement_PHPREQUEST(Announcement_APIDOCS) {

            if (location_updator() == "Announcement") {
              let data;
              Announcement_loaderBtn.classList.add('play');
              Announcement_loaderBtn.classList.remove('active');
              try {
                const formMain = new FormData(Announcement_SubmitForm);
                formMain.append('fileNames', JSON.stringify(AnccMediaFilenames));
                const Request = await fetch(Announcement_APIDOCS, {
                  method: "POST",
                  body: formMain,
                });

                if (Request.status === 200) {
                  data = await Request.json();
                  data = String(data).trim();
                  requestData = data;
                  Announcement_loaderBtn.classList.remove('play');
                  Announcement_loaderBtn.classList.add('active');
                  Announcement_loaderBtn.querySelector('.text p').textContent = data;
                  if (data == 'success' || data == 'Update success') {
                    Announcement_APIDOCS =
                      "../../API/notifications & token & history/data_process.php?APICALL=true&&user=annc&&submit=fetchlatest";
                    if (!validateKey) {
                      validateKey = "";
                    }
                    PHPLIVEUPDATE(Announcement_APIDOCS, validateKey);
                    RecieverId = document.querySelector(
                      '.event_menu_add.form_data select[name="receiver"]'
                    );
                    EmailSend(RecieverId);

                  }
                }
              } catch (error) {
                Announcement_loaderBtn.classList.remove('play');
                Announcement_loaderBtn.classList.add('active');
                Announcement_loaderBtn.querySelector('.text p').textContent = 'An error occurred';
              }
              Announcement_loaderBtn.classList.add('active');
            }
          }
          async function Announcement_PHPREQUESTSTATUS(Announcement_APIDOCS, key, Id) {
            if (location_updator() == "Announcement") {
              let data;
              try {
                dataSend = {
                  key_Data: key,
                  IdData: Id,
                };
                const Request = await fetch(Announcement_APIDOCS, {
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
          }

          async function Announcement_PHPREQUESTDEL(Announcement_APIDOCS, validateKey) {
            if (location_updator() == "Announcement") {
              let data;
              Annoucement_loaderView.classList.add('active')
              try {
                dataSend = {
                  key: validateKey,
                };

                const Request = await fetch(Announcement_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  data = data.toLowerCase();
                  if (data == 'item deleted successfully') {
                    ElementEngage.classList.add('none')

                    Annoucement_loaderView.innerText = "Delete was a success";
                    validateKey = '';
                  }
                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          async function PHPLIVEUPDATE(Announcement_APIDOCS, validateKey) {
            if (location_updator() == "Announcement") {
              let data;
              try {
                dataSend = {
                  key: validateKey
                };
                const Request = await fetch(Announcement_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  if (typeof data == 'object') {
                    let ObjectDataFrame = JSON.parse(data);
                    Template = document.querySelector('.tithe_list.ancc_list');
                    for (const key in ObjectDataFrame) {
                      unique_id = ObjectDataFrame[key]['Id'];
                      Name = ObjectDataFrame[key]['name'];
                      receiver = ObjectDataFrame[key]['receiver'];
                      message = ObjectDataFrame[key]['message'];
                      date = ObjectDataFrame[key]['date'];
                      file_data = ObjectDataFrame[key]['file'];
                      Status = ObjectDataFrame[key]['status'];
                      var CloneObject;
                      if (file_data == " " || file_data == "") {
                        CloneObject = document.querySelector('#CloneSearchS').cloneNode(true);
                      } else {
                        CloneObject = document.querySelector('#CloneSearchB').cloneNode(true);
                      }

                      ObjectData = JSON.stringify(ObjectDataFrame[key]);
                      if (CloneObject != '') {
                        const ElementDivCone = document.createElement('div');
                        ElementDivCone.classList.add('annc_item');

                        CloneObject.querySelector('.Clonename').innerText = Name;
                        CloneObject.querySelector('.Clonedate').innerText = date;
                        CloneObject.querySelector('.CloneM').innerText = message;
                        CloneObject.querySelector('.options .up').setAttribute('data-information', ObjectData);
                        CloneObject.querySelector('.options .up').setAttribute('Update_item', unique_id);
                        CloneObject.querySelector('.options .up').setAttribute('data-id', unique_id);
                        CloneObject.querySelector('.options .dp').setAttribute('data-id', unique_id);
                        CloneObject.querySelector('.options .dp').setAttribute('delete_item', unique_id);
                        CloneObject.querySelector('.options .toggle_mode').classList.add(Status);
                        CloneObject.querySelector('.options .toggle_mode').setAttribute('data-id', unique_id);
                        if (CloneObject.querySelector('.Clonefile')) {
                          CloneObject.querySelector('.Clonefile').setAttribute('src', '../../API/images/annc/' + file_data);
                        }
                        ElementDivCone.innerHTML = CloneObject.innerHTML;
                        if (Template.querySelector('h1.empty')) {
                          Template.innerHTML = "";
                        }
                        Template.prepend(ElementDivCone);
                        if (requestData == 'Update success') {
                          ElementEngage.classList.add('none');
                          validateKey = '';
                          ElementEngage = ElementDivCone;
                        }

                      }
                    }

                  }

                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          const searchSystem = debounce(async (Announcement_APIDOCS, value) => {
            if (location_updator() == "Announcement") {
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

                const Request = await fetch(Announcement_APIDOCS, {
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
                        <img src='../../API${ObjectDataFrame[key]['file']}' alt='' />
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
                  console.error("cannot find endpoint");
                }
                loader_progress.classList.remove("active");
                ContentDom.classList.remove("load");
                DomManipulationElement.classList.remove("load");
              } catch (error) {
                console.error(error);
              }
            }
          })
        }
        if (location == "projects") {
          let Project_APIDOCS;
          let Project_requestData;
          let Project_validateKey = false;
          let Project_MainFormDel = "";
          let Update_trigger = false;
          ProjectsMediaFilenames = [];
          const Project_AddEventBtn = document.querySelector(".add_event");
          const Project_SubmitForm = document.querySelector(".event_menu_add.form_data form");
          const Project_loaderBtn = document.querySelector(".loader_wrapper");
          const Projects_dn_message = document.querySelector(".dn_message");
          const Projects_confirmsBtns = document.querySelectorAll(".btn_confirm");
          var Project_OptionElements = document.querySelectorAll(".option");
          const Project_Export_variables = document.querySelector('#ExportBtn');
          const Project_loaderView = document.querySelector('.info_information.event_menu_add');
          const Project_Export_variables_Dialogue = document.querySelector('.export_dialogue');
          const Project_Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
          const Project_Export_variables_Dialogue_Form = Project_Export_variables_Dialogue.querySelector("form");
          const Project_AddEventMenu = document.querySelector(".event_menu_add.form_data");
          var Project_OptionElements = document.querySelectorAll(".option");
          if (location_updator() == "projects") {
            r.assignBrowse(document.getElementById('browseButton'));
            r.on('filesAdded', function (array) {
              document.querySelector('#browseButton span').textContent = `${r.files.length} file has been added`;
            });
            document.getElementById('browseButton').addEventListener('click', function () {
              r.cancel();
            });
          }

          Project_AddEventBtn.addEventListener("click", function (e) {
            Project_AddEventMenu.classList.add("active");
            Project_validateKey = false;
          });

          Project_Export_variables_Dialogue_Form.addEventListener('submit', function (e) {
            e.preventDefault();
          })
          Project_Export_variables.onclick = function () {
            Project_Export_variables_Dialogue.classList.add("active");
          };
          Project_Export_variables_Dialogue_Btn.addEventListener('click', async function () {
            Project_APIDOCS =
              "../../API/Assets&projects/data_process.php?APICALL=true&&user=projects&&submit=export";
            ExportData('ProjectExport', 'excel', Project_APIDOCS)
          })
          var Project_FilterUI = document.querySelector(".notification_list_filter");
          var Project_FilterUIList = document.querySelectorAll(".notification_list_filter .item");
          Project_FilterUIList.forEach(element => {
            element.addEventListener('click', function () {
              value = element.innerText;
              Project_FilterUI.classList.remove("active");
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
            if (location_updator() == 'projects') {
              var target = e.target;
              var Project_FilterUI = document.querySelector(".notification_list_filter");
              const Project_Pages = document.querySelectorAll(".pages div");
              var Project_OptionElements = document.querySelectorAll(".option");
              if (Project_AddEventMenu.classList.contains("active") && !Project_AddEventBtn.contains(target)) {
                if (!Project_AddEventMenu.contains(target)) {
                  Project_AddEventMenu.classList.remove("active");
                  r.cancel();
                  Update_trigger = false;
                }
              }

              if (Project_Export_variables_Dialogue.classList.contains('active') && !Project_Export_variables.contains(target)) {
                if (!Project_Export_variables_Dialogue.contains(target)) {
                  Project_Export_variables_Dialogue.classList.remove('active')
                }
              }

              if (!Project_FilterUI.contains(target)) {
                if (Project_FilterUI.classList.contains("active")) {
                  Project_FilterUI.classList.remove("active");
                }
              } else {
                Project_FilterUI.classList.add("active");
              }
              Project_OptionElements.forEach((element) => {
                var ElementOptions = element.querySelector(".opt_element");
                if (ElementOptions != null) {

                  if (!ElementOptions.classList.contains("active") && element.contains(target)) {
                    ElementOptions.classList.add("active");
                  }

                  if (ElementOptions.classList.contains("active") && !element.contains(target)
                  ) {
                    if (!ElementOptions.contains(target)) {
                      ElementOptions.classList.remove("active");
                    }
                  } else {
                    Project_MainBody = document.querySelectorAll('.records_table tbody tr');
                    if (Project_MainBody) {
                      Project_MainBody.forEach(element => {
                        if (element.contains(target)) {
                          Project_MainFormDel = element;
                        }
                      })
                      if (
                        target.classList.contains("Update_item") &&
                        element.contains(target)
                      ) {
                        Project_validateKey = target.getAttribute("data-id");
                        Project_UpdateItemFunction(target);
                        ElementOptions.classList.remove("active");
                      }
                      if (
                        target.classList.contains("delete_item") &&
                        element.contains(target)
                      ) {
                        Project_validateKey = target.getAttribute("data-id");
                        Projects_dn_message.classList.add('active');
                        ElementOptions.classList.remove("active");
                      }
                    }

                  }
                }
              });
              setTimeout(() => {
                if (!Project_loaderView.contains(target) && !target.classList.contains('btn_confirm')) {
                  if (Project_loaderView.classList.contains('active')) {
                    Project_loaderView.classList.remove('active');
                    Project_loaderView.innerText = "";
                  }
                }
              }, 100)
            }
          });

          Projects_confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (Project_validateKey != "") {
                  Project_DeleteItemFunction(
                    element.getAttribute("data-confirm"),
                    Project_validateKey
                  );
                }
              }
            });
          });

          Project_AddEventBtn.addEventListener("click", function (e) {
            Project_APIDOCS = "../../API/Assets&projects/data_process.php?APICALL=true&&user=projects&&submit=true";

          });
          function Project_UpdateItemFunction(value) {
            const Project_AddEventMenu = document.querySelector(".event_menu_add.form_data");
            newObject = value.getAttribute("data-information");
            newObject = JSON.parse(newObject);
            console.log(newObject['team']);

            document.querySelector('.event_menu_add.form_data input[name="name"]').value =
              newObject["name"];
            document.querySelector('.event_menu_add.form_data input[name="team"]').value =
              newObject["team"];
            document.querySelector(
              '.event_menu_add.form_data input[name="target"]'
            ).value = newObject["target"];
            document.querySelector(
              '.event_menu_add.form_data input[name="current"]'
            ).value = newObject["current"];
            document.querySelector('.event_menu_add.form_data input[name="date"]').value =
              newObject["Start"];
            document.querySelector(
              '.event_menu_add.form_data select[name="status"]'
            ).value = newObject["Status"];

            document.querySelector(".event_menu_add.form_data textarea").value =
              newObject["description"];
            document.querySelector(
              '.event_menu_add.form_data input[name="delete_key"]'
            ).value = newObject["id"];
            Project_AddEventMenu.classList.add("active");
            Project_APIDOCS =
              "../../API/Assets&projects/data_process.php?APICALL=true&&user=projects&&submit=update_file";
            Update_trigger = true;
          }
          searchBtn.addEventListener("click", e => {
            Project_APIDOCS =
              "../../API/Assets&projects/data_process.php?APICALL=true&&user=projects&&submit=search";
            if (searchInput.value != " " && searchInput.value != "") {
              Project_searchSystem(Project_APIDOCS, searchInput.value);
            }

          })

          function Project_DeleteItemFunction(value, Project_validateKey) {

            if (value == "true" && location_updator() == 'projects') {
              let API =
                "../../API/Assets&projects/data_process.php?APICALL=true&&user=projects&&submit=delete_file";
              Project_PHPREQUESTDEL(API, Project_validateKey);
            }
          }
          async function Project_PHPREQUEST(Project_APIDOCS) {
            if (location_updator() == 'projects') {
              let data;
              Project_loaderBtn.classList.add('play');
              Project_loaderBtn.classList.remove('active');
              try {
                const formMain = new FormData(Project_SubmitForm);
                formMain.append('fileNames', JSON.stringify(ProjectsMediaFilenames));
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

                const Request = await fetch(Project_APIDOCS, {
                  method: "POST",
                  body: formMain,
                });

                if (Request.status === 200) {
                  data = await Request.json();
                  Project_requestData = data;
                  Project_loaderBtn.classList.remove('play');
                  Project_loaderBtn.classList.add('active');
                  Project_loaderBtn.querySelector('.text p').textContent = data;
                  data = data.toLowerCase();
                  if (data == 'success' || data == 'update success') {
                    if (!Project_validateKey) {
                      Project_validateKey = "";
                    }
                    Project_APIDOCS = "../../API/Assets&projects/data_process.php?APICALL=true&&user=projects&&submit=fetchlatest";
                    Project_PHPLIVEUPDATE(Project_APIDOCS, Project_validateKey);
                  }
                  r.cancel();
                } else {
                  Project_loaderBtn.classList.remove('play');
                  Project_loaderBtn.classList.add('active');
                  Project_loaderBtn.querySelector('.text p').textContent = "cannot find endpoint";
                }
              } catch (error) {
                Project_loaderBtn.classList.remove('play');
                Project_loaderBtn.classList.add('active');
                Project_loaderBtn.querySelector('.text p').textContent = "An error Occurred";

              }
            }
          }
          async function Project_PHPLIVEUPDATE(Project_APIDOCS, Project_validateKey) {
            if (location_updator() == 'projects') {
              let data;
              try {
                dataSend = {
                  key: Project_validateKey
                };
                const Request = await fetch(Project_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  if (typeof data == 'object') {

                    Template = document.querySelector('.records_table table tbody');
                    ObjectDataFrame = JSON.parse(data);
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
                        if (Status.includes('progress')) {
                          Status = "<div class='in_btn blue'><div></div>In progress</div>";
                        } else if (Status.includes('complete')) {
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
                        CloneObject.querySelector('.Cloneimage').setAttribute('src', `../../API/Images_folder/projects/${image}`);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-id', id);
                        CloneObject.querySelector('.opt_element p.dp').setAttribute('data-id', id);

                        ElementDivCone.innerHTML = CloneObject.innerHTML;
                        if (Project_requestData == 'Update success') {
                          Project_MainFormDel.classList.add('none');

                        }
                        Template.prepend(ElementDivCone);
                        Project_MainFormDel = ElementDivCone;
                        Project_OptionElements = document.querySelectorAll(".option");
                        const element = ElementDivCone.querySelector('.option');
                        element.addEventListener("click", function () {
                          var ElementOptions = element.querySelector(".opt_element");
                          ElementOptions.classList.add("active");
                        });
                      }
                    }

                  }

                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          async function Project_PHPREQUESTDEL(Project_APIDOCS, Project_validateKey) {
            if (location_updator() == 'projects') {
              let data;

              try {
                Project_loaderView.classList.add('active');
                dataSend = {
                  key: Project_validateKey,
                };

                const Request = await fetch(Project_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  Project_loaderView.innerText = data;
                  if (data == 'Item Deleted Successfully') {
                    Project_MainFormDel.classList.add('none');
                  }
                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          Project_SubmitForm.addEventListener("submit", async function (e) {
            e.preventDefault();

            acceptedExtension = ['jpg', 'png', 'jpeg'];
            permission = true;
            if (Update_trigger && r.files.length == 0) {
              Project_PHPREQUEST(Project_APIDOCS);
            } else {
              if (r.files.length > 0) {
                if (r.files.length > 1) {
                  Project_loaderBtn.classList.add('active');
                  Project_loaderBtn.querySelector('.text p').textContent = "You can only upload a single file during upload";
                }
                ProjectsMediaFilenames = [];
                r.files.forEach(element => {
                  if (acceptedExtension.includes(element.file.name.split('.')[1])) {
                    ProjectsMediaFilenames.push(element.file.name);
                  } else {
                    permission = false;
                  }
                })
              }

              if (permission) {
                if (ProjectsMediaFilenames.length > 0) {
                  if (ProjectsMediaFilenames.length > 1 && Update_trigger) {
                    Project_loaderBtn.classList.add('active');
                    Project_loaderBtn.querySelector('.text p').textContent = "You can only upload a single file during update";
                  } else {
                    Project_loaderBtn.classList.add('play');
                    Project_loaderBtn.classList.remove('active');
                    r.upload();
                    r.on('complete', function () {
                      document.querySelector('#browseButton span').textContent = "Select file to Upload";
                      r.cancel();
                      Project_PHPREQUEST(Project_APIDOCS);

                      ProjectsMediaFilenames = [];
                    });

                  }

                }
              } else {
                Project_loaderBtn.classList.add('active');
                Project_loaderBtn.querySelector('.text p').textContent = "Files accepted should have either JPG,PNG,JPEG";
              }
            }

          });
          const Project_searchSystem = debounce(async (Project_APIDOCS, value) => {
            if (location_updator() == 'projects') {
              let data;
              try {
                loader_progress.classList.add("active");
                ContentDom.classList.add("load");
                DomManipulationElement.classList.add("load");
                Projects_dn_message.querySelector("p").innerText = "...processing request";
                dataSend = {
                  key: value,
                  numData: numoffset,
                };

                const Request = await fetch(Project_APIDOCS, {
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

                          if (Status.includes('progress')) {
                            Status = "<div class='in_btn blue'><div></div>In progress</div>";
                          } else if (Status.includes('complete')) {
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
                          Project_OptionElements = document.querySelectorAll(".option");
                          const element = ElementDivCone.querySelector('.option');
                          element.addEventListener("click", function () {
                            var ElementOptions = element.querySelector(".opt_element");
                            ElementOptions.classList.add("active");
                          });
                        }
                      }




                      if (ObjectDataFrame['Project_pages'] > 25) {
                        ConvertProject_Pages = ObjectDataFrame['Project_pages'];
                        RestructureProject_Pages(ConvertProject_Pages);
                      }

                    }
                  } else {
                    console.error("cannot find endpoint");
                  }
                  loader_progress.classList.remove("active");
                  ContentDom.classList.remove("load");
                  DomManipulationElement.classList.remove("load");
                }
              } catch (error) {
                console.error(error);
              }
            }

          })
        }

        if (location == "Partnership") {
          let Partner_requestData = "";
          let Partner_APIDOCS = "";
          let Partner_validateKey = false;
          let Partner_confirmKey = true;
          let Partner_MainFormDel = "";
          const Partner_AddEventBtn = document.querySelector(".add_event");
          const Partner_AddEventMenu = document.querySelector(".event_menu_add.form_data");
          const Partner_dn_message = document.querySelector(".dn_message");
          const Partner_confirmsBtns = document.querySelectorAll(".btn_confirm");
          var Partner_OptionElement_r = document.querySelectorAll(".option");
          var Partner_OptionElements = document.querySelectorAll(".btn_record");
          const Partner_searchInput = document.querySelector("#searchInput");
          const Partner_searchBtn = document.querySelector("#searchBtn");
          const Partner_loaderBtn = document.querySelector(".event_menu_add.form_data .loader_wrapper");
          const Partnership_record = document.querySelector(".series_version");
          const Partner_AddEventMenuIndi = document.querySelector('.event_menu_add.indi')
          const Partner_AddEventMenuIndiBtn = document.querySelector('.event_menu_add.indi button');
          const Partner_ResponseView = document.querySelector(".info_information.event_menu_add");
          const Partner_FilterBtn = document.querySelector(".filterBtn");
          const Partner_Export_variables = document.querySelector('#ExportBtn');
          const Partner_Export_variables_Dialogue = document.querySelector('.export_dialogue');
          const Partner_Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
          const Partner_Export_variables_Dialogue_Form = Partner_Export_variables_Dialogue.querySelector("form");
          Partner_AddEventBtn.addEventListener("click", function (e) {
            Partner_AddEventMenu.classList.add("active");
            Partner_validateKey = ""
          });

          Partner_Export_variables_Dialogue_Form.addEventListener('submit', function (e) {
            e.preventDefault();
          })
          Partner_Export_variables.onclick = function () {
            Partner_Export_variables_Dialogue.classList.add("active");
          };
          Partner_Export_variables_Dialogue_Btn.addEventListener('click', async function () {
            Partner_APIDOCS =
              "../../API/partnership/data_process.php?APICALL=true&&user=true&&submit=export";
            ExportData('PartnershipExport', 'excel', Partner_APIDOCS)
          })

          const Partner_SubmitForm = document.querySelector(".event_menu_add.main form");
          Partner_confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                if (Partner_validateKey != "") {
                  partner_DeleteItemFunction(element.getAttribute("data-confirm"), Partner_validateKey);
                }
              }
            });
          });
          var Partner_FilterUI = document.querySelector(".notification_list_filter");
          var Partner_FilterUIList = document.querySelectorAll(".notification_list_filter .item");
          Partner_FilterUIList.forEach(element => {
            element.addEventListener('click', function () {
              setTimeout(() => {
                value = element.innerText;
                Partner_FilterUI.classList.remove("active");
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
          Partner_searchBtn.addEventListener("click", e => {
            Partner_APIDOCS = "../../API/partnership/data_process.php?APICALL=true&&user=true&&submit=filter";
            if (Partner_searchInput.value != " " && Partner_searchInput.value != "") {
              Partner_searchSystem(Partner_APIDOCS, Partner_searchInput.value);
            }
          })

          Partner_AddEventBtn.addEventListener("click", function (e) {
            Partner_APIDOCS = "../../API/partnership/data_process.php?APICALL=true&&user=true&&submit=upload&&Admin=true";
          });
          Partner_AddEventMenuIndiBtn.addEventListener("click", function (e) {
            Partner_APIDOCS = "../../API/partnership/data_process.php?APICALL=true&&user=true&&submit=upload_ind";
            Partner_PHPREQUESTIND(Partner_APIDOCS);
          });
          function Partner_DestructureJson(element) {
            newObject = JSON.parse(
              element.parentElement.getAttribute("data-information"));
            Partnership_record.classList.add('active');
            const PartnerContainer =
              Partnership_record.querySelector(".menu.event");
            if (Object.keys(newObject).length > 0) {
              PartnerContainer.innerHTML = "";
              for (const iletrate in newObject) {
                dataVal = newObject[iletrate]["date"];
                PartnerContainer.innerHTML += `<div class="item"><div class="details">
                <p>${new Date(dataVal)}</p>
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
            if (location_updator() == "Partnership") {
              var Partner_target = e.target;
              var Partner_FilterUI = document.querySelector(".notification_list_filter");
              const Partner_Pages = document.querySelectorAll(".pages div");
              var Partner_OptionElements = document.querySelectorAll(".btn_record");
              var Partner_OptionElement_r = document.querySelectorAll(".option");
              if (Partner_AddEventMenu.classList.contains("active") && !Partner_AddEventBtn.contains(Partner_target)) {
                if (!Partner_AddEventMenu.contains(Partner_target)) {
                  Partner_AddEventMenu.classList.remove("active");
                  Partner_loaderBtn.querySelector('.text p').textContent = "";
                }
              }
              if (!Partner_FilterBtn.contains(Partner_target) && !Partner_FilterUI.contains(Partner_target)) {
                if (Partner_FilterUI.classList.contains("active")) {
                  Partner_FilterUI.classList.remove("active");
                }
              } else {
                Partner_FilterUI.classList.add("active");
              }
              if (Partner_Export_variables_Dialogue.classList.contains('active') && !Partner_Export_variables.contains(Partner_target)) {
                if (!Partner_Export_variables_Dialogue.contains(Partner_target)) {
                  Partner_Export_variables_Dialogue.classList.remove('active')
                }
              }
              setTimeout(() => {
                if (!Partner_ResponseView.contains(Partner_target) && !Partner_target.classList.contains('btn_confirm')) {
                  if (Partner_ResponseView.classList.contains('active')) {
                    Partner_ResponseView.classList.remove('active');
                    Partner_ResponseView.innerText = "";
                  }
                }
              }, 100)
              if (Partner_target.tagName == "I") {
                if (Partner_target.hasAttribute("data-cn")) {
                  if (Partner_target.hasAttribute("data-id")) {
                    Partner_MainFormDel = Partner_target.parentElement.parentElement;
                    Partner_MainFormDel.classList.add('none');
                    Partner_validateKey = Partner_target.getAttribute("data-id");
                    Partnership_record.classList.remove("active");
                    Partner_dn_message.classList.add("active");
                    Partner_confirmKey = false;
                  }
                }
              }
              Partner_Pages.forEach((element) => {
                if (element.contains(Partner_target)) {
                  value = element.innerHTML;
                  pagnationSystem(value);
                }
              });

              if (Partner_AddEventMenuIndi.classList.contains("active") && !Partner_AddEventMenuIndiBtn.contains(Partner_target)) {
                if (!Partner_AddEventMenuIndi.contains(Partner_target)) {
                  Partner_AddEventMenuIndi.classList.remove("active");
                }
              }

              if (!Partner_target.classList.contains("btn_record")) {
                if (Partnership_record.classList.contains("active") && !Partnership_record.contains(Partner_target)) {
                  Partnership_record.classList.remove("active");
                }
              }
              Partner_OptionElement_r.forEach((element) => {
                var ElementOptions = element.querySelector(".opt_element");
                if (ElementOptions != null) {
                  if (!ElementOptions.classList.contains("active") && element.contains(Partner_target)) {
                    ElementOptions.classList.add("active");
                  }

                  if (
                    ElementOptions.classList.contains("active") &&
                    !element.contains(Partner_target)
                  ) {
                    if (!ElementOptions.contains(Partner_target)) {
                      ElementOptions.classList.remove("active");
                    }
                  } else {
                    Partner_MainBody = document.querySelectorAll('#main_table tbody tr');
                    if (Partner_MainBody) {
                      Partner_MainBody.forEach(element => {
                        if (element.contains(Partner_target)) {
                          Partner_MainFormDel = element;
                        }
                      })
                      if (Partner_target.hasAttribute("Update_item") && element.contains(Partner_target)) {
                        Partner_validateKey = element.querySelector(".opt_element p").getAttribute("data-id");
                        Partner_UpdateItemFunction(Partner_target);
                      }
                      if (Partner_target.hasAttribute("delete_item") && element.contains(Partner_target)) {
                        Partner_validateKey = element.querySelector(".opt_element p").getAttribute("data-id");
                        Partner_dn_message.classList.add("active");
                        ElementOptions.classList.remove("active");
                      }


                      if (
                        Partner_target.classList.contains("add_item") && element.contains(Partner_target)) {

                        Partner_AddEventMenuIndi.classList.add('active');
                        Partner_AddEventMenuIndi.querySelector('form input[name="delete_key"]').value = Partner_target.getAttribute("data-id");

                      }
                    }
                  }
                }
              });
              Partner_OptionElements.forEach((element) => {
                if (element == Partner_target) {
                  Partner_DestructureJson(element);
                }
              })
            }
          });

          function Partner_UpdateItemFunction(value) {
            newObject = value.getAttribute("data-information");
            newObject = JSON.parse(newObject);
            document.querySelector('.event_menu_add input[name="name"]').value =
              newObject["name"];
            document.querySelector(
              '.event_menu_add input[name="amount"]').value = newObject["partnership"];
            document.querySelector(
              '.event_menu_add select[name="type"]').value = newObject["Type"];
            document.querySelector(
              '.event_menu_add input[name="email"]').value = newObject["Email"];
            document.querySelector(
              '.event_menu_add input[name="period"]').value = newObject["Period"];
            document.querySelector(
              '.event_menu_add select[name="status"]').value = newObject["status"];
            document.querySelector('.event_menu_add input[name="date"]').value =
              newObject["date"];
            document.querySelector(
              '.event_menu_add input[name="delete_key"]').value = newObject["UniqueId"];
            Partner_AddEventMenu.classList.add("active");
            Partner_APIDOCS =
              "../../API/partnership/data_process.php?APICALL=true&&user=true&&submit=update_file";
          }
          function partner_DeleteItemFunction(value, Partner_validateKey) {
            if (value == "true" && Partner_confirmKey && location_updator() == "Partnership") {
              let API =
                "../../API/partnership/data_process.php?APICALL=true&&user=true&&submit=delete_file";
              Partner_PHPREQUESTDEL(API, Partner_validateKey);
            } else if (value == "true" && !Partner_confirmKey) {
              API =
                "../../API/partnership/data_process.php?APICALL=true&&user=true&&submit=delete_ini";
              Partner_PHPREQUESTDEL(API, Partner_validateKey);
            }
          }
          async function Partner_PHPREQUESTIND(Partner_APIDOCS) {
            if (location_updator() == "Partnership") {
              let data;
              try {
                let loader = Partner_AddEventMenuIndi.querySelector('form .error_information');
                const formMain = new FormData(Partner_AddEventMenuIndi.querySelector('form'));
                controller = new AbortController();
                const Request = await fetch(Partner_APIDOCS, {
                  method: "POST",
                  body: formMain,
                });

                if (Request.status === 200) {
                  data = await Request.json();
                  loader.innerText = data;
                  if (data == "Upload was a success") {
                    Partner_APIDOCS =
                      "../../API/partnership/data_process.php?APICALL=true&&user=true&&submit=fetchlatest";
                    Partner_validateKey = Partner_AddEventMenuIndi.querySelector('form input[name="delete_key"]').value;
                    PHPLIVEUPDATE(Partner_APIDOCS, Partner_validateKey);


                  }
                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }

          async function Partner_PHPREQUEST(Partner_APIDOCS) {
            if (location_updator() == "Partnership") {
              let data;
              Partner_loaderBtn.classList.add('play');
              Partner_loaderBtn.classList.remove('active');
              try {
                const formMain = new FormData(Partner_SubmitForm);

                const Request = await fetch(Partner_APIDOCS, {
                  method: "POST",
                  body: formMain,
                });
                if (Request.status === 200) {
                  data = await Request.json();
                  Partner_requestData = data;
                  Partner_loaderBtn.classList.remove('play');
                  Partner_loaderBtn.classList.add('active');
                  Partner_loaderBtn.querySelector('.text p').textContent = data;
                  if (data == 'success' || data == 'Update success') {
                    Partner_APIDOCS =
                      "../../API/partnership/data_process.php?APICALL=true&&user=true&&submit=fetchlatest";
                    if (!Partner_validateKey) {
                      Partner_validateKey = "";
                    }
                    PHPLIVEUPDATE(Partner_APIDOCS, Partner_validateKey);
                  }
                } else {
                  Partner_loaderBtn.classList.remove('play');
                  Partner_loaderBtn.classList.add('active');
                  Partner_loaderBtn.querySelector('.text p').textContent = "cannot find endpoint";
                }
              } catch (error) {
                Partner_loaderBtn.classList.remove('play');
                Partner_loaderBtn.classList.add('active');
                Partner_loaderBtn.querySelector('.text p').textContent = "An error occurred";

              }
            }
          }

          async function Partner_PHPREQUESTDEL(Partner_APIDOCS, Partner_validateKey) {
            if (location_updator() == "Partnership") {
              let data;
              try {
                Partner_ResponseView.classList.add('active');
                dataSend = {
                  key: Partner_validateKey,
                };

                const Request = await fetch(Partner_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  data = data.toLowerCase();
                  Partner_ResponseView.innerText = data
                  if (data == 'item deleted successfully') {
                    Partner_MainFormDel.classList.add('none');
                    console.log(Partner_MainFormDel);
                  }
                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          async function PHPLIVEUPDATE(Partner_APIDOCS, Partner_validateKey) {
            if (location_updator() == "Partnership") {
              let data;
              try {
                dataSend = {
                  key: Partner_validateKey
                };
                controller = new AbortController();
                const Request = await fetch(Partner_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  if (typeof data == 'object') {
                    let ObjectDataFrame = JSON.parse(data);
                    Template = document.querySelector('.records_table table tbody');

                    for (const key in ObjectDataFrame) {
                      unique_id = ObjectDataFrame[key]['UniqueId'];
                      namer = ObjectDataFrame[key]['name'];
                      Partnership = ObjectDataFrame[key]['partnership'];
                      date = ObjectDataFrame[key]['date'];
                      Email = ObjectDataFrame[key]['Email'];
                      Type = ObjectDataFrame[key]['Type'];
                      Period = ObjectDataFrame[key]['Period'];
                      statusi = ObjectDataFrame[key]['status'];
                      ///fix the problem, clean sent data to capture date;

                      ObjectData = ObjectDataFrame[key]['Obj'];
                      ObjectDataIndividual = ObjectDataFrame[key]['IObj'];
                      const CloneObject = document.querySelector('.CloneSearch tr').cloneNode(true);
                      if (CloneObject != '') {
                        CloneObject.querySelector('.Cloneemail').innerText = Email;
                        CloneObject.querySelector('.Clonedate').innerText = date;
                        CloneObject.querySelector('.Clonetype').innerText = Type;
                        CloneObject.querySelector('.Cloneperiod').innerText = Period;
                        CloneObject.querySelector('.Clonename').innerText = namer;
                        CloneObject.querySelector('.Cloneitem').setAttribute('data-information', ObjectDataIndividual);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-id', unique_id);
                        CloneObject.querySelector('.opt_element p.dp').setAttribute('data-id', unique_id);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('Update_item', unique_id);
                        CloneObject.querySelector('.opt_element p.dp').setAttribute('delete_item', unique_id);
                        CloneObject.querySelector('.opt_element p.add_item').setAttribute('data_id', unique_id);
                        statusClass = CloneObject.querySelector('.btn_record');
                        if (statusi == 'active') {
                          statusClass.classList.add("in_btn");
                          statusClass.innerHTML = "<div></div>Active";
                        } else {
                          statusClass.classList.add("out_btn");
                          statusClass.innerHTML = "<div></div>Inactive";
                        }
                        Template.prepend(CloneObject);
                        if (Partner_requestData == 'Update success') {
                          Partner_MainFormDel.classList.add('none');
                          Partner_validateKey = '';
                          Partner_MainFormDel = CloneObject;
                        }
                        Partner_OptionElements = document.querySelectorAll(".btn_record");
                        Partner_OptionElement_r = document.querySelectorAll(".option");
                        const element = CloneObject.querySelector('.option');
                        element.addEventListener("click", function () {
                          var ElementOptions = element.querySelector(".opt_element");
                          ElementOptions.classList.add("active");
                        });

                        const elementAdd = CloneObject.querySelector('.opt_element p.add_item');
                        elementAdd.addEventListener("click", function () {
                          Partner_AddEventMenuIndi.classList.add("active");
                        });

                      }
                    }

                  }

                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          Partner_SubmitForm.addEventListener("submit", async function (e) {
            Partner_ResponseView.innerText = "loading...";
            e.preventDefault();

            Partner_PHPREQUEST(Partner_APIDOCS);
          });
          Partner_AddEventMenuIndi.querySelector('form').addEventListener("submit", async function (e) {
            Partner_AddEventMenuIndi.querySelector(".error_information").innerText = "loading...";
            e.preventDefault();
          });

          const Partner_searchSystem = debounce(async (Partner_APIDOCS, value) => {
            if (location_updator() == "Partnership") {
              let data;
              try {
                loader_progress.classList.add("active");
                ContentDom.classList.add("load");
                DomManipulationElement.classList.add("load");
                Partner_dn_message.querySelector("p").innerText = "...processing request";
                dataSend = {
                  key: value,
                  numData: numoffset,
                };

                const Request = await fetch(Partner_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });
                data = await Request.json(data);
                if (Request.status === 200) {
                  if (data) {
                    if (typeof data == 'object') {
                      let ObjectDataFrame = data;
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
                          ElementDivCone.classList.add('Partner_SearchItem');

                          CloneObject.querySelector('.Cloneemail').innerText = Email;
                          CloneObject.querySelector('.Clonedate').innerText = date;
                          CloneObject.querySelector('.Clonetype').innerText = Type;
                          CloneObject.querySelector('.Cloneperiod').innerText = Period;
                          CloneObject.querySelector('.Clonename').innerText = namer;
                          CloneObject.querySelector('.Cloneitem').setAttribute('data-information', ObjectDataIndividual);
                          CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                          CloneObject.querySelector('.opt_element p.up').setAttribute('data-id', unique_id);
                          CloneObject.querySelector('.opt_element p.dp').setAttribute('data-id', unique_id);
                          CloneObject.querySelector('.opt_element p.up').setAttribute('Update_item', unique_id);
                          CloneObject.querySelector('.opt_element p.dp').setAttribute('delete_item', unique_id);
                          CloneObject.querySelector('.opt_element p.add_item').setAttribute('data_id', unique_id);
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
                          Partner_OptionElements = document.querySelectorAll(".btn_record");
                          Partner_OptionElement_r = document.querySelectorAll(".option");
                          const element = ElementDivCone.querySelector('.option');
                          element.addEventListener("click", function () {
                            var ElementOptions = element.querySelector(".opt_element");
                            ElementOptions.classList.add("active");
                          });

                          const elementAdd = ElementDivCone.querySelector('.opt_element p.add_item');
                          elementAdd.addEventListener("click", function () {
                            Partner_AddEventMenuIndi.classList.add("active");
                          });

                        }
                      }




                      if (ObjectDataFrame['Partner_pages'] > 25) {
                        ConvertPartner_Pages = ObjectDataFrame['Partner_pages'];
                        RestructurePartner_Pages(ConvertPartner_Pages);
                      }

                    } else {
                      Partner_ResponseView.classList.add('active');
                      Partner_ResponseView.innerText = data;
                      document.querySelector('.skeleton_loader').classList.remove('load');
                    }
                  } else {
                    console.error("cannot find endpoint");
                  }
                  loader_progress.classList.remove("active");
                  ContentDom.classList.remove("load");
                  DomManipulationElement.classList.remove("load");
                }
              } catch (error) {
                console.error(error);
              }
            }

          })
        }
        if (location == "Department") {
          let Department_APIDOCS;
          let Department_CounterView = false;
          let Dp_Key_remove = "";
          let Department_validateKey = false;
          const Department_SubmitForm = document.querySelector(".event_menu_add.form_data form");
          const Department_loaderView = document.querySelector('.info_information.event_menu_add');
          var Department_OptionElements = document.querySelectorAll(".option");
          const Department_loaderBtn = document.querySelector(".loader_wrapper");
          const Department_FilterBtn = document.querySelector(".filterBtn");
          const Department_AddBtn = document.querySelector("button.add_new");
          const Department_RemoveBtn = document.querySelector("button.remove_new");
          const Department_DepartmentList = document.querySelectorAll(".menu.event .item");
          const Department_DepartmentView = document.querySelector(".ministry_data");
          const Department_AddEventBtn = document.querySelector(".add_event");
          const Department_AddEventMenu = document.querySelector(".event_menu_add.form_data");
          var Department_OptionElements = document.querySelectorAll(".option");
          Department_AddEventBtn.addEventListener("click", function (e) {
            Department_AddEventMenu.classList.add("active");
            Department_validateKey = false;
          });


          window.addEventListener("click", function (e) {
            if (location_updator() == "Department") {
              var target = e.target;
              var Department_FilterUI = document.querySelector(".notification_list_filter");
              const Pages = document.querySelectorAll(".pages div");
              var Department_OptionElements = document.querySelectorAll(".option");
              if (Department_AddEventMenu.classList.contains("active") && !Department_AddEventBtn.contains(target)) {
                if (!Department_AddEventMenu.contains(target)) {
                  Department_AddEventMenu.classList.remove("active");
                }
              }
              Pages.forEach((element) => {
                if (element.contains(target)) {
                  value = element.innerHTML;
                  pagnationSystem(value);
                }
              });
              if (!Department_FilterBtn.contains(target) && !Department_FilterUI.contains(target)) {
                if (Department_FilterUI.classList.contains("active")) {
                  Department_FilterUI.classList.remove("active");
                }
              } else {
                Department_FilterUI.classList.add("active");
              }
              if (!Department_DepartmentView.contains(target) && !target.parentElement.parentElement.classList.contains('item')) {
                if (Department_CounterView == false) {

                  Department_DepartmentList.forEach(element => {
                    if (element.contains(target)) {
                      if (!Department_DepartmentView.classList.contains('active')) {
                        Department_DepartmentView.classList.add('active');

                        Department_CounterView = true;
                        if (element.hasAttribute('data-name')) {

                          Dp_Key_remove = element.getAttribute('data-name');
                          Deparment_GetmembershipData(Dp_Key_remove)
                        }

                      }
                    }
                  });
                } else {
                  Department_DepartmentView.classList.remove('active');
                  Department_CounterView = false;

                }
              }

              setTimeout(() => {
                if (!Department_loaderView.contains(target) && !target.classList.contains('btn_confirm')) {
                  if (Department_loaderView.classList.contains('active')) {
                    Department_loaderView.classList.remove('active');
                  }
                }
              }, 100)

              Department_OptionElements.forEach((element) => {
                var ElementOptions = element.querySelector(".opt_element");
                if (ElementOptions != null) {

                  if (!ElementOptions.classList.contains("active") && element.contains(target)) {
                    ElementOptions.classList.add("active");
                  }
                  if (ElementOptions.classList.contains("active") && !element.contains(target)
                  ) {
                    if (!ElementOptions.contains(target)) {
                      ElementOptions.classList.remove("active");
                    }
                  } else {
                    MainBody = document.querySelectorAll('#main_table tbody tr');
                    if (MainBody) {
                      MainBody.forEach(element => {
                        if (element.contains(target)) {
                          MainFormDel = element;
                        }
                      })

                      if (
                        target.classList.contains("Update_item") &&
                        element.contains(target)
                      ) {
                        Department_validateKey = target.getAttribute("data-id");
                        Department_UpdateItemFunction(target);
                        ElementOptions.classList.remove("active");
                      }
                      if (target.classList.contains("delete_item") && element.contains(target)) {
                        Department_validateKey = target.getAttribute("data-id");
                        MainFormDel = target.parentElement.parentElement.parentElement;
                        dn_message.classList.add('active');
                        ElementOptions.classList.remove("active");
                      }
                    }
                  }
                }
              });
            }
          });
          confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {
                console.error(document.querySelector(".delete_item"));

                if (Department_validateKey != "") {
                  Department_DeleteItemFunction(element.getAttribute("data-confirm"), Department_validateKey
                  );
                }
              }
            });
          });

          Department_AddEventBtn.addEventListener("click", function (e) {
            Department_APIDOCS = "../../API/ministriesData & theme/data_process.php?APICALL=true&&user=true&&submit=true";
          });

          function Department_UpdateItemFunction(value) {
            const Department_AddEventMenu = document.querySelector(".event_menu_add.form_data");
            newObject = value.getAttribute("data-information");
            newObject = JSON.parse(newObject);
            document.querySelector('.event_menu_add.form_data input[name="name"]').value =
              newObject["name"];

            document.querySelector(
              '.event_menu_add.form_data input[name="members"]').value = newObject["members"];

            document.querySelector(
              '.event_menu_add.form_data input[name="manager"]').value = newObject["manager"];

            document.querySelector(
              '.event_menu_add.form_data select[name="status"]').value = newObject["status"];

            document.querySelector(
              '.event_menu_add.form_data input[name="members"]').value = newObject["members"];

            document.querySelector('.event_menu_add.form_data input[name="date"]').value =
              newObject["date"];

            document.querySelector(
              '.event_menu_add.form_data textarea[name="about"]').value = newObject["about"];
            document.querySelector(
              '.event_menu_add.form_data input[name="delete_key"]').value = newObject["UniqueId"];
            Department_AddEventMenu.classList.add("active");
            Department_APIDOCS = "../../API/ministriesData & theme/data_process.php?APICALL=true&&user=true&&submit=update_file";
          }
          function Department_DeleteItemFunction(value, Department_validateKey) {
            if (value == "true" && location_updator() == "Department") {
              let API =
                "../../API/ministriesData & theme/data_process.php?APICALL=true&&user=true&&submit=delete_file";
              Department_PHPREQUESTDEL(API, Department_validateKey);
            }
          }
          async function Deparment_GetmembershipData(name) {
            if (location_updator() == "Department") {
              Department_APIDOCS = "../../API/ministriesData & theme/data_process.php?APICALL=true&&user=view&&submit=dpList";
              let data;
              bodySend = {
                DpKey: name,
              }
              try {
                const Request = await fetch(Department_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(bodySend),
                  headers: {
                    "Content-Type": "application/json"
                  }
                });

                if (Request.status === 200) {
                  data = await Request.json();
                  if (data['status'] == 'success') {
                    ObjectData = data['data'];
                    if (typeof ObjectData == 'object') {

                      var TableMain = document.querySelector('.members table');
                      TableMain.innerHTML = '';
                      TableMain.innerHTML = ` <thead>
                <tr>
                <th></th>
                <th>image</th>
                <th>username</th>
                <th>position</th>
                </tr>
                <thead>
                <tbody>`;
                      for (const key in ObjectData) {
                        TableMain.innerHTML += `<tr>
                   <td><input type="checkbox" value="${key}" /></td>
                   <td><img src="../../API/Images_folder/users/${ObjectData[key]['image']}" alt="" /></td>
                   <td>${ObjectData[key]['username']}</td>
                    <td>${ObjectData[key]['position']}</td>
                   </tr>`;
                      }
                      TableMain.innerHTML += `</tbody>`;
                    }
                  }
                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          Department_RemoveBtn.addEventListener("click", async function (e) {

            Department_APIDOCS = "../../API/ministriesData & theme/data_process.php?APICALL=delete&&user=true&&submit=dpList";

            AllChecked = document.querySelectorAll('.members table input[type="checkbox"]');
            CheckedVal = [];
            AllChecked.forEach(element => {
              if (element.checked) {
                CheckedVal.push(element.value);
              }
            });
            let dataSend = {
              Keys: CheckedVal,
              DpKey: Dp_Key_remove,
            }

            try {
              if (CheckedVal.length < 1) {
                alert('You have a select / check at least one user to perform this action ');
              } else {
                const Request = await fetch(Department_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json();
                  ResponseView.innerText = data['data'];
                  if (data['status'] == 'success') {
                    ObjectData = data['data'];
                    if (ObjectData == 'success') {
                      UrlTrace();
                    }
                  }
                } else {
                  console.error("cannot find endpoint");
                }
              }

            } catch (error) {
              console.error(error);
            }

          })
          Department_AddBtn.addEventListener("click", async function (e) {
            Department_APIDOCS = "../../API/ministriesData & theme/data_process.php?APICALL=true&&user=true&&submit=dpList";

            AllChecked = document.querySelectorAll('table input[type="checkbox"]');
            CheckedVal = [];
            AllChecked.forEach(element => {
              if (element.checked) {
                CheckedVal.push(element.value);
              }
            });
            let dataSend = {
              Keys: CheckedVal,
              DpKey: Dp_Key_remove,
            }
            try {
              if (CheckedVal.length < 1) {
                alert('You have a select / check at least one user to perform this action ');
              } else {
                const Request = await fetch(Department_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json();
                  ResponseView.innerText = data['data'];
                  if (data['status'] == 'success') {
                    ObjectData = data['data'];
                    if (ObjectData == 'success') {
                      UrlTrace();
                    }
                  }
                } else {
                  console.error("cannot find endpoint");
                }
              }

            } catch (error) {
              console.error(error);
            }

          })
          async function Department_PHPREQUEST(Department_APIDOCS) {
            if (location_updator() == "Department") {
              let data;
              Department_loaderBtn.classList.add('play');
              Department_loaderBtn.classList.remove('active');
              try {
                const formMain = new FormData(Department_SubmitForm);

                const Request = await fetch(Department_APIDOCS, {
                  method: "POST",
                  body: formMain,
                });

                if (Request.status === 200) {
                  data = await Request.json();
                  Department_loaderBtn.classList.remove('play');
                  Department_loaderBtn.classList.add('active');
                  Department_loaderBtn.querySelector('.text p').textContent = data;

                  if (data == 'success' || data == 'Update success') {
                    UrlTrace();
                  }
                } else {
                  Department_loaderBtn.classList.remove('play');
                  Department_loaderBtn.classList.add('active');
                  Department_loaderBtn.querySelector('.text p').textContent = "cannot find endpoint";
                }
              } catch (error) {
                Department_loaderBtn.classList.remove('play');
                Department_loaderBtn.classList.add('active');
                Department_loaderBtn.querySelector('.text p').textContent = "An error occurred";

              }
            }
          }

          async function Department_PHPREQUESTDEL(Department_APIDOCS, Department_validateKey) {
            if (location_updator() == "Department") {
              let data;
              try {
                Department_loaderView.classList.add('active')
                dataSend = {
                  key: Department_validateKey,
                };

                const Request = await fetch(Department_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  Department_loaderView.innerText = data;
                  if (data == 'Item Deleted Successfully') {
                    UrlTrace();
                  }
                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }
          }
          Department_SubmitForm.addEventListener("submit", async function (e) {
            e.preventDefault();
            Department_PHPREQUEST(Department_APIDOCS);
          });
        }

        if (location == "Budget") {
          const Budget_FilterBtn = document.querySelector(".filterBtn");
          var Budget_FilterUI = document.querySelector(".notification_list_filter");
          var Budget_FilterUIList = document.querySelectorAll(".notification_list_filter .item");
          var Details = document.querySelectorAll('.Budget_details');

          Budget_FilterUIList.forEach(element => {
            element.addEventListener('click', function () {
              value = element.innerText;
              Budget_FilterUI.classList.remove("active");
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
            if (location_updator() == 'Budget') {
              var Budget_target = e.target;
              if (!Budget_FilterBtn.contains(Budget_target) && !Budget_FilterUI.contains(Budget_target)) {
                if (Budget_FilterUI.classList.contains("active")) {
                  Budget_FilterUI.classList.remove("active");
                }
              } else {
                Budget_FilterUI.classList.add("active");
              }
              Details.forEach(element => {

                if (element.contains(Budget_target)) {
                  element.classList.add('active');
                } else {
                  element.classList.remove('active');
                }
              })
            }
          });
        }
        if (location == "Membership") {
          const Membership_AddEventBtn = document.querySelector(".add_event");
          const Membership_AddEventMenu = document.querySelector(".event_menu_add.form_data");
          var Membership_OptionElements = document.querySelectorAll(".option");
          let MembershipMediaFilenames = [];
          let Update_trigger = false;
          let Memebership_APIDOCS = "";
          let Membership_requestData = "";
          let Membership_validateKey = false;
          let Membership_MainFormDel = '';
          const Membership_dn_message = document.querySelector(".dn_message");
          const Membership_confirmsBtns = document.querySelectorAll(".btn_confirm");
          const Membership_SubmitForm = document.querySelector(".event_menu_add.form_data form");
          var Membership_OptionElements = document.querySelectorAll(".option");
          const SubmitSearchForm = document.querySelector("#searchInput");
          const Membership_SubmitSearchbutton = document.querySelector("#searchBtn");
          const Membership_loaderBtn = document.querySelector(".loader_wrapper");
          const Membership_loaderiew = document.querySelector(".info_information.event_menu_add");
          const FilterBtn = document.querySelector(".filterBtn");
          const Membership_Export_variables = document.querySelector('#ExportBtn');
          const Membership_Export_variables_Dialogue = document.querySelector('.export_dialogue');
          const Membership_Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
          const Membership_Export_variables_Dialogue_Form = Membership_Export_variables_Dialogue.querySelector("form");
          const BatchUpload = document.querySelector('#data_upload');
          let BatchUpload_Content = false;
          BatchUpload.addEventListener('click', function () {
            BatchSelect.click();
          });
          BatchSelect.addEventListener('change', function (e) {
            if (e.target.files[0]) {
              BatchUpload_Content = e.target.files[0];
              ExtensionName = BatchUpload_Content.name.split('.');
              ExtensionNameList = ['xlsx', 'xlx', 'xls'];
              console.log('ExtensionName');
              if (ExtensionNameList.includes(ExtensionName[1].toLowerCase())) {
                BatchPlatform.querySelector('header').textContent = `${BatchUpload_Content.name} has been selected. Click on the upload button to proceed`;
              } else {
                BatchPlatform.querySelector('header').textContent = `Target file must be in excel formate.!!!`;
              }

              BatchPlatform.classList.add('active');
            }

          });

          BatchPlatform.querySelector('button').addEventListener('click', function () {
            member_permission_key = true;
            if (BatchUpload_Content != false) {
              BatchPlatform.querySelector('.loader_wrapper').classList.add('play');
              var File_reader = new FileReader();
              File_reader.onload = function (event) {
                var data = new Uint8Array(event.target.result);
                var workbook = XLSX.read(data, {
                  type: "array"
                });
                workbook.SheetNames.forEach((sheet) => {
                  let rowObject = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
                  rowObject.forEach(element => {
                    ObjectKeys = Object.keys(element);
                    defaultLength = ObjectKeys.length + 1;
                    if (defaultLength == 12 || defaultLength == 11) {
                      if (ObjectKeys.includes('id') || ObjectKeys.includes('ID') || ObjectKeys.includes('Id') || ObjectKeys.includes('iD')) {
                        delete element[ObjectKeys[0]];
                      }
                    }
                    if (defaultLength > 12 || defaultLength < 11) {
                      console.log(ObjectKeys.length);
                      member_permission_key = false;
                    }
                  })

                  if (!member_permission_key) {
                    BatchPlatform.querySelector('header').textContent = `Uploaded file ought to have 10 columns, unequal columns detected !!`;
                  } else {
                    BatchPlatform.querySelector('header').textContent = ` Number of file to expected to upload : ${rowObject.length}`;
                    rowObject.forEach(element => {
                      Membership_Batch(element).then(data => {
                        if (data == 'success') {
                          BatchPlatform.querySelector('.upload').innerHTML += `<p>Uploading data ${rowObject.indexOf(element)} was a success</p>`;
                        } else {
                          BatchPlatform.querySelector('.error').innerHTML += `<p>Uploading data ${rowObject.indexOf(element)} encountered an error ${data}</p>`;
                        }
                      }).catch(error => {
                        console.log(error);
                      })

                    })
                  }
                  BatchPlatform.querySelector('.loader_wrapper').classList.remove('play');
                  console.log(rowObject);
                })
              }
              File_reader.readAsArrayBuffer(BatchUpload_Content);
            }
            BatchUpload_Content = false;

          })
          Membership_AddEventBtn.addEventListener("click", function (e) {
            Membership_AddEventMenu.classList.add("active");
            Membership_validateKey = false;
            document.querySelector('#browseButton span').textContent = "Select file to Upload";
            Update_trigger = false;
          });
          Membership_Export_variables_Dialogue_Form.addEventListener('submit', function (e) {
            e.preventDefault();
          })
          Membership_Export_variables.onclick = function () {
            Membership_Export_variables_Dialogue.classList.add("active");
          };
          Membership_Export_variables_Dialogue_Btn.addEventListener('click', async function () {
            Memebership_APIDOCS = "../../API/membership/data_process.php?APICALL=true&&user=true&&submit=export";
            ExportData('MembershipExport', 'excel', Memebership_APIDOCS)
          })
          if (location_updator() == "Membership") {
            r.assignBrowse(document.getElementById('browseButton'));
            r.on('filesAdded', function (array) {
              document.querySelector('#browseButton span').textContent = `${r.files.length} file has been added`;

            });

          }
          window.addEventListener('click', function (e) {
            if (location_updator() == "Membership") {
              var target = e.target;
              const Membership_Pages = document.querySelectorAll(".pages div");
              var Membership_OptionElements = document.querySelectorAll(".option");

              if (BatchPlatform.classList.contains("active") && !BatchUpload.contains(target)) {
                if (!BatchPlatform.contains(target)) {
                  BatchPlatform.classList.remove("active");

                  BatchSelect.value = "";
                  BatchPlatform.querySelector('header').textContent = ` `;
                  BatchPlatform.querySelector('.upload').innerHTML = ` `;
                  BatchPlatform.querySelector('.error').innerHTML = ` `;


                }
              }

              if (Membership_AddEventMenu.classList.contains("active") && !Membership_AddEventBtn.contains(target)) {
                if (!Membership_AddEventMenu.contains(target)) {
                  Membership_AddEventMenu.classList.remove("active");
                  Membership_loaderBtn.querySelector('.text p').textContent = "";
                  r.cancel();
                  MembershipMediaFilenames = []
                }
              }

              if (Membership_Export_variables_Dialogue.classList.contains('active') && !Membership_Export_variables.contains(target)) {
                if (!Membership_Export_variables_Dialogue.contains(target)) {
                  Membership_Export_variables_Dialogue.classList.remove('active')
                }
              }
              Membership_OptionElements.forEach((element) => {
                var ElementOptions = element.querySelector(".opt_element");
                if (ElementOptions != null) {
                  if (!ElementOptions.classList.contains("active") && element.contains(target)) {
                    ElementOptions.classList.add("active");
                  }

                  if (ElementOptions.classList.contains("active") && !element.contains(target)) {
                    if (!ElementOptions.contains(target)) {
                      ElementOptions.classList.remove("active");
                    }
                  } else {
                    Membership_MainBody = document.querySelectorAll('.membership_table tbody tr');
                    if (Membership_MainBody) {
                      Membership_MainBody.forEach(element => {
                        if (element.contains(target)) {
                          Membership_MainFormDel = element;
                        }
                      })
                      if (
                        target.classList.contains("Update_item") &&
                        element.contains(target)
                      ) {
                        Membership_validateKey = target.getAttribute("data-id");
                        Membership_UpdateItemFunction(target);
                        ElementOptions.classList.remove("active");
                      }
                      if (
                        target.classList.contains("delete_item") &&
                        element.contains(target)
                      ) {
                        ElementOptions.classList.remove("active");

                        Membership_validateKey = target.getAttribute("data-id");
                        Membership_MainFormDel = target.parentElement.parentElement.parentElement;
                        Membership_dn_message.classList.add('active');

                      }
                    }
                  }
                }
              });
              setTimeout(() => {
                if (!Membership_loaderiew.contains(target) && !target.classList.contains('btn_confirm')) {
                  if (Membership_loaderiew.classList.contains('active')) {
                    Membership_loaderiew.classList.remove('active');
                    Membership_loaderiew.innerText = "";
                  }
                }
              }, 100)
              Membership_Pages.forEach((element) => {
                if (element.contains(target)) {
                  value = element.innerHTML;
                  pagnationSystem(value);
                }
              });
            }

          })
          Membership_confirmsBtns.forEach((element) => {
            element.addEventListener("click", (e) => {
              if (element.getAttribute("data-confirm") == "true") {

                if (Membership_validateKey != "") {
                  Membership_DeleteItemFunction(
                    element.getAttribute("data-confirm"),
                    Membership_validateKey
                  );
                }
              }
            });
          });

          Membership_SubmitForm.addEventListener("submit", async function (e) {
            e.preventDefault();

            acceptedExtension = ['jpg', 'png', 'jpeg'];
            permission = true;
            if (Update_trigger && r.files.length == 0) {
              Membership_PHPREQUEST(Memebership_APIDOCS);
            } else {
              if (r.files.length > 0) {
                if (r.files.length > 1) {
                  Membership_loaderBtn.classList.add('active');
                  Membership_loaderBtn.querySelector('.text p').textContent = "You can only upload a single file during upload";
                }
                MembershipMediaFilenames = [];
                r.files.forEach(element => {
                  if (acceptedExtension.includes(element.file.name.split('.')[1])) {
                    MembershipMediaFilenames.push(element.file.name);
                  } else {
                    permission = false;
                  }
                })
              } else {
                Membership_PHPREQUEST(Memebership_APIDOCS);
              }

              if (permission) {
                if (MembershipMediaFilenames.length > 0) {
                  if (MembershipMediaFilenames.length > 1 && Update_trigger) {
                    Membership_loaderBtn.classList.add('active');
                    Membership_loaderBtn.querySelector('.text p').textContent = "You can only upload a single file during update";
                  } else {
                    Membership_loaderBtn.classList.add('play');
                    Membership_loaderBtn.classList.remove('active');
                    r.upload();
                    r.on('complete', function () {
                      console.log('complete');
                      document.querySelector('#browseButton span').textContent = "Select file to Upload";
                      r.cancel();
                      Membership_PHPREQUEST(Memebership_APIDOCS);

                      MembershipMediaFilenames = [];
                    });
                  }

                }
              } else {
                Membership_loaderBtn.classList.add('active');
                Membership_loaderBtn.querySelector('.text p').textContent = "Files accepted should have either JPG,PNG,JPEG";
              }
            }


          });

          Membership_SubmitSearchbutton.addEventListener("click", function (e) {
            Memebership_APIDOCS = "../../API/membership/data_process.php?APICALL=true&&user=true&&submit=search_file";
            if (searchInput.value != " " && searchInput.value != "") {
              Membership_searchSystem(Memebership_APIDOCS, searchInput.value);
            }
          })

          Membership_AddEventBtn.addEventListener("click", function (e) {
            Memebership_APIDOCS = "../../API/membership/data_process.php?APICALL=true&&user=true&&submit=true";
            Membership_validateKey = false;
          });
          function Membership_UpdateItemFunction(value) {
            if (location_updator() == 'Membership') {
              const AddEventMenu = document.querySelector(".event_menu_add.form_data");
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
                '.event_menu_add select[name="status"]'
              ).value = newObject["status"];
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
              document.querySelector('.event_menu_add select[name="status"]').value = newObject["status"];
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
              Memebership_APIDOCS =
                "../../API/membership/data_process.php?APICALL=true&&user=true&&submit=update_file";
              Update_trigger = true;
            }
          }
          function Membership_DeleteItemFunction(value, Membership_validateKey) {
            if (value == "true" && location_updator() == "Membership") {
              let API =
                "../../API/membership/data_process.php?APICALL=true&&user=true&&submit=delete_file";
              Membership_PHPREQUESTDEL(API, Membership_validateKey);
            }
          }
          async function Membership_PHPREQUEST(Memebership_APIDOCS) {
            if (location_updator() == "Membership") {
              let data;
              Membership_loaderBtn.classList.add('play');
              Membership_loaderBtn.classList.remove('active');
              try {
                countryCode = intInit.getSelectedCountryData().dialCode;
                if (parseInt(countryCode)) {
                  contactForms = document.querySelector(
                    '.event_menu_add input[name="contact"]'
                  ).value
                  document.querySelector('.event_menu_add input[name="contact"]').value = countryCode + String(contactForms);
                  console.log(document.querySelector('.event_menu_add input[name="contact"]').value);

                  const formMain = new FormData(Membership_SubmitForm);
                  formMain.append('fileNames', JSON.stringify(MembershipMediaFilenames))
                  formMain.append(
                    "status",
                    document.querySelector('.event_menu_add select[name="status"]')
                      .value
                  );
                  const Request = await fetch(Memebership_APIDOCS, {
                    method: "POST",
                    body: formMain,
                  });

                  if (Request.status === 200) {
                    data = await Request.json();
                    Membership_loaderBtn.classList.remove('play');
                    Membership_loaderBtn.classList.add('active');
                    Membership_loaderBtn.querySelector('.text p').textContent = data;

                    Membership_requestData = data;
                    if (data == 'success' || data == 'Update success') {
                      if (!Membership_validateKey) {
                        Membership_validateKey = "";
                      }
                      Memebership_APIDOCS =
                        "../../API/membership/data_process.php?APICALL=true&&user=true&&submit=fetchlatest";
                      Membership_PHPLIVEUPDATE(Memebership_APIDOCS, Membership_validateKey);

                    }

                  } else {
                    Membership_loaderBtn.classList.remove('play');
                    Membership_loaderBtn.classList.add('active');
                    Membership_loaderBtn.querySelector('.text p').textContent = "cannot find endpoint";
                  }
                } else {
                  Membership_loaderBtn.classList.remove('play');
                  Membership_loaderBtn.classList.add('active');
                  Membership_loaderBtn.querySelector('.text p').textContent = "country code was not captured!!";
                }

              } catch (error) {
                Membership_loaderBtn.classList.remove('play');
                Membership_loaderBtn.classList.add('active');
                Membership_loaderBtn.querySelector('.text p').textContent = error;
              }
            }
          }
          async function Membership_Batch(element) {
            if (location_updator() == "Membership") {
              if (typeof element == 'object') {
                try {
                  const formMain = new FormData();
                  Keys = Object.keys(element);
                  if (Keys.length == 10) {
                    formMain.append('Fname', element[Keys[0]]);
                    formMain.append('Oname', element[Keys[1]]);
                    formMain.append('birth', element[Keys[2]]);
                    formMain.append('gender', element[Keys[3]]);
                    formMain.append('contact', element[Keys[4]]);
                    formMain.append('occupation', element[Keys[5]]);
                    formMain.append('location', element[Keys[6]]);
                    formMain.append('status', element[Keys[7]]);
                    formMain.append('baptism', element[Keys[8]]);
                    formMain.append('position', element[Keys[9]]);
                    formMain.append('delete_key', "");
                    formMain.append('fileNames', JSON.stringify([]));
                    formMain.append('status', element[Keys[10]]);
                    Memebership_APIDOCS = "../../API/membership/data_process.php?APICALL=true&&user=true&&submit=true";
                    const Request = await fetch(Memebership_APIDOCS, {
                      method: "POST",
                      body: formMain,
                    });

                    if (Request.status === 200) {
                      data = await Request.json();
                      return data
                    } else {
                      return `request responded with ${Request.status}`;
                    }
                  } else {
                    return `data is missing a columns `
                  }

                } catch (error) {
                  return error
                }
              } else {
                return "Connot convert file";
              }

            } else {
              return false;
            }
          }


          async function Membership_PHPREQUESTDEL(Memebership_APIDOCS, Membership_validateKey) {
            if (location_updator() == "Membership") {
              let data;
              try {
                Membership_loaderiew.classList.add('active');
                dataSend = {
                  key: Membership_validateKey,
                };

                const Request = await fetch(Memebership_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  if (data == "Item Deleted Successfully") {
                    Membership_MainFormDel.classList.add('none');
                    Membership_loaderiew.innerHTML = data;
                  }
                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }

          }
          async function Membership_PHPLIVEUPDATE(Memebership_APIDOCS, Membership_validateKey) {
            if (location_updator() == "Membership") {
              let data;
              try {
                dataSend = {
                  key: Membership_validateKey
                };
                controller = new AbortController();
                const Request = await fetch(Memebership_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });

                if (Request.status === 200) {
                  data = await Request.json(data);
                  if (typeof data == 'object') {
                    Template = document.querySelector('.membership_table tbody');
                    let CloneObject = document.querySelector('.CloneSearch').cloneNode(true);
                    ObjectDataFrame = JSON.parse(data);

                    for (const key in ObjectDataFrame) {

                      unique_id = ObjectDataFrame[key]['UniqueId'];
                      Firstname = ObjectDataFrame[key]['Firstname'];
                      Othername = ObjectDataFrame[key]['Othername'];
                      Age = ObjectDataFrame[key]['Age'];
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
                        CloneObject.querySelector('.Cloneimage').setAttribute('src', `../../API/Images_folder/users/${image}`);
                        CloneObject.querySelector('.Clonegender').innerText = gender;
                        CloneObject.querySelector('.Cloneaddress').innerText = Address;
                        CloneObject.querySelector('.Clonegender').innerText = gender;
                        CloneObject.querySelector('.Clonebaptism').innerText = Baptism;
                        CloneObject.querySelector('.Cloneoccupation').innerText = occupation;
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-id', unique_id);
                        CloneObject.querySelector('.opt_element p.dp').setAttribute('data-id', unique_id);
                        ElementDivCone.innerHTML = CloneObject.innerHTML;
                        if (Membership_requestData == 'Update success') {
                          Membership_MainFormDel.classList.add('none');
                        }
                        Template.prepend(ElementDivCone);
                        Membership_MainFormDel = ElementDivCone;
                        Membership_OptionElements = document.querySelectorAll(".option");
                        const element = ElementDivCone.querySelector('.option');
                        element.addEventListener("click", function () {
                          var ElementOptions = element.querySelector(".opt_element");
                          ElementOptions.classList.add("active");
                        });
                      }


                    }

                  }

                } else {
                  console.error("cannot find endpoint");
                }
              } catch (error) {
                console.error(error);
              }
            }

          }
          const Membership_searchSystem = debounce(async (Memebership_APIDOCS, value) => {
            if (location_updator() == "Membership") {
              let data;
              try {
                loader_progress.classList.add("active");
                ContentDom.classList.add("load");
                DomManipulationElement.classList.add("load");
                Membership_dn_message.querySelector("p").innerText = "...processing request";
                dataSend = {
                  key: value,
                  numData: numoffset,
                };

                const Request = await fetch(Memebership_APIDOCS, {
                  method: "POST",
                  body: JSON.stringify(dataSend),
                  headers: {
                    "Content-Type": "application/json",
                  },
                });
                data = await Request.json(data);
                if (Request.status === 200) {
                  if (data) {

                    if (typeof data == 'object') {
                      let ObjectDataFrame = data;
                      Template = document.querySelector('.membership_table tbody');
                      CloneObject = document.querySelector('.CloneSearch').cloneNode(true);

                      Template.innerHTML = "";
                      ObjectDataFrame = ObjectDataFrame['result'];

                      for (const key in ObjectDataFrame) {
                        unique_id = ObjectDataFrame[key]['UniqueId'];
                        Firstname = ObjectDataFrame[key]['Fname'];
                        Othername = ObjectDataFrame[key]['Oname'];
                        Age = ObjectDataFrame[key]['birth'];
                        Position = ObjectDataFrame[key]['Position'];
                        contact = ObjectDataFrame[key]['contact'];
                        email = ObjectDataFrame[key]['email'];
                        image = ObjectDataFrame[key]['image'];
                        Address = ObjectDataFrame[key]['location'];
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
                          CloneObject.querySelector('.Cloneimage').setAttribute('src', `../../API/Images_folder/users/${image}`);
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
                          Membership_OptionElements = document.querySelectorAll(".option");
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
                  console.error("cannot find endpoint");
                }
                loader_progress.classList.remove("active");
                ContentDom.classList.remove("load");
                DomManipulationElement.classList.remove("load");
              } catch (error) {
                console.error(error);
              }
            }
          })
          const inputFeild = document.querySelector('#contact_form');
          const intInit = window.intlTelInput(inputFeild, {
            hiddenInput: function (inputFeild) {
              return {
                phone: "phone_full",
                country: "country_code"
              }
            },
            initialCountry: "gh",
            nationalMode: true,
            loadUtilsOnInit: "intl-tel-input-24.6.1/build/js/utils.js",
          })

          intInit

        }
        if (location == "Gallery") {
          require(['Gallery', "resumable"], function (Gallery, resumable) {

            if (location_updator() == "Gallery") {
              r.assignBrowse(document.getElementById('browseButton'));
              r.on('filesAdded', function (array) {
                document.querySelector('#browseButton span').textContent = `${r.files.length} file has been added`;
              });
              document.getElementById('browseButton').addEventListener('click', function () {
                r.cancel();
              });
            }
            acceptedExtension = ['jpg', 'png', 'jpeg'];
            Gal_SubmitForm.addEventListener("submit", async function (e) {
              e.preventDefault();
              Gal_Loader.classList.add('play');
              Gal_Loader.classList.remove('active');
              setTimeout(() => {
                permission = true;
                if (Update_trigger && r.files.length == 0) {
                  Gal_PHPREQUEST(Gal_APIDOCS);
                  document.querySelector('#browseButton span').textContent = `Select a file to upload`;
                  r.cancel();
                  MediaFilenames = [];
                } else {
                  if (r.files.length > 0) {
                    r.files.forEach(element => {
                      if (acceptedExtension.includes(element.file.name.split('.')[1].toLowerCase())) {
                        MediaFilenames.push(element.file.name);
                      } else {
                        permission = false;
                      }
                    })
                    Gal_total = MediaFilenames.length;
                  } else {
                    Gal_Loader.classList.add('active');
                    Gal_Loader.querySelector('.text p').textContent = "Select a file to upload !!";

                  }

                  if (permission) {
                    if (MediaFilenames.length > 0) {
                      if (MediaFilenames.length > 1 && Update_trigger) {
                        Gal_Loader.classList.add('active');
                        Gal_Loader.querySelector('.text p').textContent = "You can only upload a single file during update";

                      } else {
                        r.upload();
                        r.on('complete', function () {
                          Gal_PHPREQUEST(Gal_APIDOCS);
                          document.querySelector('#browseButton span').textContent = `Select a file to upload`;
                          r.cancel();
                          MediaFilenames = [];
                        });
                      }

                    }
                  } else {
                    Gal_Loader.classList.add('active');
                    Gal_Loader.querySelector('.text p').textContent = "Files accepted should have either JPG,PNG,JPEG";
                  }
                }

              }, 400)




            });
          })
        }
        if (location == "FinanceAccount") {
          require(['Accounts'], function (Accounts) {

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
  async function ExportData(filename, type_sr, APIDOCS) {

    if (type_sr == 'word') {
      var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
      var postHtml = "</body></html>";
      var html = preHtml + data + postHtml;
      var blob = new Blob(['\ufeff', html], {
        type: 'application/msword'
      });
      var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);
      filename = filename + '.doc';
      document.body.appendChild(downloadLink);
      if (navigator.msSaveOrOpenBlob) {
        navigator.msSaveOrOpenBlob(blob, filename);
      } else {
        downloadLink.hidden = true;
        downloadLink.href = url;
        downloadLink.download = filename;
        downloadLink.click();
      }
    }
    if (type_sr == "excel") {
      try {
        dataSend = {
          num: 1,
        };
        const Request = await fetch(APIDOCS, {
          method: "POST",
          body: JSON.stringify(dataSend),
          headers: {
            "Content-Type": "application/json",
          },
        });

        if (Request.status === 200) {
          data = await Request.json();
          if (data) {
            var ExportData_vr = data;
            if (typeof ExportData_vr == 'object') {
              const ObjectDataFrame = JSON.parse(ExportData_vr);
              if (ObjectDataFrame) {
                ExportString = "";
                jsonData = []
                for (const key in ObjectDataFrame) {
                  Obj = {}
                  jsonData.push(ObjectDataFrame[key]);
                }

                const worksheet = XLSX.utils.json_to_sheet(jsonData);
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");
                const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
                const link = document.createElement('a');
                const blob = new Blob([excelBuffer], { type: 'application/octet-stream' });
                link.href = URL.createObjectURL(blob);
                link.download = filename + '.xlsx';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
              }

            } else {
              alert('Not enough data to export');
            }


          }
        } else {
          console.error("Cannot iniate Download");
        }
      } catch (error) {
        console.error(error);
      }
    }
    if (type_sr == 'pdf') {

    }

  }
  function UrlTrace() {
    let DomManipulationElement;
    location = window.location.hash.replace("#", "");
    if (location != 'calender') {
      currentPhase = false;
      calendaDate = false;
    }
    if (location == 'Finance') {
      document.querySelector("li.expand").classList.add("active");
      document.querySelector("li.expand .tabs a").classList.add('active');
    }

    SearchOutList = ['Gallery', 'Appearance', '', '/', 'Access_token', 'Transaction', 'Budget', 'Expenses', 'Assets', 'FinanceAccount', 'records', 'Department', 'History', 'calender'];
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
        console.error(error);
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
  function RestructurePages(number) {
    pagesMain = document.querySelector(".page_sys");
    if (pagesMain.classList.contains('hide')) {
      document.querySelector(".page_sys").classList.remove('hide');
    }
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
          numoffset = value;
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
  function ResetUrl() {
    MainFormDel = "";
    formDataDel = "";
    SearchTrigger = false;
    DomManipulationElement = false;
    validateKey = false;
    ConvertPages = false;
    numoffset = 0;
    ActivityMenu = false;
    currentPageNum = 0;
    APIDOCS = "";
    requestData = false;
    ElementEngage = false;
    newObject = false;
  }
  const location_updator = () => {
    location = window.location.hash.replace("#", "")
    return (location);
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
  function getUploadApi() {
    if (location_updator() == "Membership") {
      return "../../API/membership/data_process.php?upload_submit=upload";
    } else
      if (location_updator() == 'Gallery') {
        return "../../API/Gallery/data_process.php?upload_submit=upload";
      } else
        if (location_updator() == "calender") {
          return "../../API/calender/data_process.php?upload_submit=upload";
        } else if (location_updator() == 'Assets') {
          return "../../API/Assets&projects/data_process.php?upload_submit=upload&&APICALL=Assets";
        } else if (location_updator() == 'projects') {
          return "../../API/Assets&projects/data_process.php?upload_submit=upload&&APICALL=Projects";
        } else if (location_updator() == 'Library') {
          return "../../API/Library/data_process.php?upload_submit=upload";
        } else if (location_updator() == 'Announcement') {
          return "../../API/notifications & token & history/data_process.php?upload_submit=upload";
        } else {
          return "sample.test";
        }

  }
  LogOutButton.addEventListener('click', async function () {
    if (confirm("You are loging out of your account, confirm request")) {
      Logout = document.createElement('a');
      Logout.href = '../../API/login/logout.php?logout';
      document.querySelector('body').append(Logout);
      Logout.click();
    }
  });
  var r = new resumable({
    target: getUploadApi(),
    query: { upload_token: 'my_token' }
  });

});
