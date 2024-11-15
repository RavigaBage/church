<?php
session_start();
require '../../../API/vendor/autoload.php';
$newDataRequest = new Finance\viewData();
if (isset($_GET['Year'])) {
  $year = $_GET['Year'];
  $condition = true;
  $Tithe_data = $newDataRequest->ChartAnalysis($year);

  if (!is_object(json_decode($Tithe_data))) {
    $condition = false;
  }


  if ($condition) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="analysis.css" />
      <link rel="stylesheet" href="../scripts/apexcharts-bundle/samples/assets/styles.css" />
      <script src="../scripts/apexcharts-bundle/samples/assets/stock-prices.js"></script>
      <title>Aaron Analysis</title>
    </head>
    <style>
      .apexcharts-text tspan {
        font-family: semi-boldFont !important;
      }

      rect {
        stroke: #fff;
      }
    </style>

    <body>
      <main>
        <section class="grid_T">
          <div class="tithe_main">
            <div class="tithe_char">
              <div class="tithe_gross">
                <label>Gross Volume</label>
                <div class="tithe_gross" style="height:40px; display:flex;justify-content:space-between;">
                  <div class="current_val">
                    <h1>$34,9018.901</h1>
                    <div class="icon">
                      <p class="h1"><span>12.34%</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                          <path
                            d="M10.586 3l-6.586 6.586a2 2 0 0 0 -.434 2.18l.068 .145a2 2 0 0 0 1.78 1.089h2.586v2a1 1 0 0 0 1 1h6l.117 -.007a1 1 0 0 0 .883 -.993l-.001 -2h2.587a2 2 0 0 0 1.414 -3.414l-6.586 -6.586a2 2 0 0 0 -2.828 0z" />
                          <path d="M15 20a1 1 0 0 1 .117 1.993l-.117 .007h-6a1 1 0 0 1 -.117 -1.993l.117 -.007h6z" />
                          <path d="M15 17a1 1 0 0 1 .117 1.993l-.117 .007h-6a1 1 0 0 1 -.117 -1.993l.117 -.007h6z" />
                        </svg>

                      </p>
                    </div>
                  </div>
                  <div class="previous_val">
                    <h1 class="dim">$30,9018.901</h1>
                  </div>
                </div>
                <div id="tithe_main"></div>
              </div>
            </div>
            <div class="tithe_details">
              <label>Current BALANCE</label>
              <div class="current_val">
                <h1>$34,9018.901</h1>
                <div class="icon">
                  <p class="h1"><span>12.34%</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                      <path
                        d="M10.586 3l-6.586 6.586a2 2 0 0 0 -.434 2.18l.068 .145a2 2 0 0 0 1.78 1.089h2.586v2a1 1 0 0 0 1 1h6l.117 -.007a1 1 0 0 0 .883 -.993l-.001 -2h2.587a2 2 0 0 0 1.414 -3.414l-6.586 -6.586a2 2 0 0 0 -2.828 0z" />
                      <path d="M15 20a1 1 0 0 1 .117 1.993l-.117 .007h-6a1 1 0 0 1 -.117 -1.993l.117 -.007h6z" />
                      <path d="M15 17a1 1 0 0 1 .117 1.993l-.117 .007h-6a1 1 0 0 1 -.117 -1.993l.117 -.007h6z" />
                    </svg>

                  </p>
                </div>
              </div>
              <label class="b_line">current value as at <span class="warning">june 24 / 204</span></label>
              <div class="graph_gap" id="tithe_com"></div>
            </div>
          </div>
          <div class="records_main">
            <h1>RECORDS DATA</h1>
            <div id="Records"></div>
          </div>
        </section>
        <section class="grid_TH">
          <div class="visitors_time">
            <p class="header">Visits By Time</p>
            <div id="visits"></div>
          </div>
          <div class="payment_comparism">
            <p class="header">Tithe Payment Flow</p>
            <span class="intro_details">This is an illustrated summary of the medium, users use in the payment of tithes,
              offertories,donations and other transactions recorded in the followinf account history.
              Tithe,offertory,expenses,transactions and donations
            </span>
            <div class="compare">
              <div class="main">
                <div class="online">
                  <div class="storm_label left">
                    <p>Online</p>
                  </div>
                  <h1>60%</h1>
                  <span class="dim" data_id='Eamount'>2,1291.29</span>
                </div>
                <div class="vrs">
                  <p>vs</p>
                </div>
                <div class="in_person">
                  <div class="storm_label right">
                    <p>in-person</p>
                  </div>
                  <h1>40%</h1>
                  <span class="dim" data_id='Inamount'>29,1291.29</span>
                </div>
              </div>
              <div class="colors">
                <div class="color online" style="--width:60%"></div>
                <div class="color in_person" style="--width:40%"></div>
              </div>
            </div>
          </div>
          <div class="Budget_main">
            <p class="header">Budget summary 2024</p>
            <div id="budget"></div>
          </div>
        </section>
        <section class="grid_F last">
          <div class="partnership_main">
            <p class="header">Partnership summary</p>
            <label>amount accrued</label>
            <div class="current_val">
              <h1>3,302</h1>
              <div class="icon">
                <p class="h1">12.34%
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                      d="M10.586 3l-6.586 6.586a2 2 0 0 0 -.434 2.18l.068 .145a2 2 0 0 0 1.78 1.089h2.586v2a1 1 0 0 0 1 1h6l.117 -.007a1 1 0 0 0 .883 -.993l-.001 -2h2.587a2 2 0 0 0 1.414 -3.414l-6.586 -6.586a2 2 0 0 0 -2.828 0z" />
                    <path d="M15 20a1 1 0 0 1 .117 1.993l-.117 .007h-6a1 1 0 0 1 -.117 -1.993l.117 -.007h6z" />
                    <path d="M15 17a1 1 0 0 1 .117 1.993l-.117 .007h-6a1 1 0 0 1 -.117 -1.993l.117 -.007h6z" />
                  </svg>
                </p>
              </div>
            </div>
            <div class="summary local">
              <p>From the church</p>
              <p class='dim'>45%</p>
            </div>
            <div class="summary notlocal">
              <p>Outside the church</p>
              <p class='dim'>55%</p>
            </div>
          </div>
          <div class="events_main">
            <p class="header">Events summary</p>

            <div id="events"></div>
          </div>
          <div class="membership_main">
            <p class="header">Member summary</p>
            <div class="current_val">
              <h1>1002</h1>

            </div>
            <div id="membership"></div>
          </div>
          <div class="offertory_main">
            <p class="header">Offertory summary</p>
            <div class="current_val">
              <h1>10,102.01</h1>
              <div class="icon">
                <p class="h1">98.4%
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path
                      d="M10.586 3l-6.586 6.586a2 2 0 0 0 -.434 2.18l.068 .145a2 2 0 0 0 1.78 1.089h2.586v2a1 1 0 0 0 1 1h6l.117 -.007a1 1 0 0 0 .883 -.993l-.001 -2h2.587a2 2 0 0 0 1.414 -3.414l-6.586 -6.586a2 2 0 0 0 -2.828 0z" />
                    <path d="M15 20a1 1 0 0 1 .117 1.993l-.117 .007h-6a1 1 0 0 1 -.117 -1.993l.117 -.007h6z" />
                    <path d="M15 17a1 1 0 0 1 .117 1.993l-.117 .007h-6a1 1 0 0 1 -.117 -1.993l.117 -.007h6z" />
                  </svg>

                </p>
              </div>
            </div>
            <div id="offertory"></div>
          </div>
        </section>
      </main>
      <script>
        var _seed = 42;
        Math.random = function () {
          _seed = _seed * 16807 % 2147483647;
          return (_seed - 1) / 2147483646;
        };
      </script>
      <script src="../scripts/apexcharts-bundle/dist/apexcharts.js"></script>
      <script>
        const Ecash = document.querySelector('.online');
        const Incash = document.querySelector('.in_person');
        condition = true;
        const userData = <?php print_r(($Tithe_data)); ?>;
        try {
          if (typeof userData == 'object' && Object.keys(userData).length > 0) {
            for (const key in userData) {
              const element = userData[key];
              if (typeof element != 'object' && typeof element != 'array') {
                condition = false;
                break;
              }
            }
            if (condition) {
              RecordsTithe = userData['Tithe'];
              RecordsTitheYear = userData['TitheYear'];
              RecordData = userData['Records'];
              VisitorsChat = userData['visitors'];
              titheComparism = userData['TitheComparism'];
              BudgetData = userData['BudgetData'];
              Partnership = userData['Partnership'];
              ChartEvent = userData['Events'];
              Membership = userData['membership'];
              Offertory = userData['offertory'];

              function GetPartnershipRegistry() {
                if (typeof Partnership == 'object') {
                  const ParenElement = document.querySelector('.partnership_main');
                  ParenElement.querySelector('.current_val h1').textContent = Partnership['Data'][0];
                  ParenElement.querySelector('.summary.local p.dim').textContent = Partnership['Data'][1].toFixed(1) + '%';
                  ParenElement.querySelector('.summary.notlocal p.dim').textContent = Partnership['Data'][2].toFixed(1) + '%';
                }
              }
              GetPartnershipRegistry();
              function GetCashRegistry() {
                if (typeof titheComparism == 'object') {

                  document.querySelector('.color.online').style.setProperty('--width', titheComparism['Ecash'][0].toFixed('1') + '%');
                  Ecash.querySelector('h1').textContent = titheComparism['Ecash'][0].toFixed('1') + '%';
                  Ecash.querySelector('span.dim').textContent = '$' + titheComparism['Ecash'][1];
                  document.querySelector('.color.in_person').style.setProperty('--width', titheComparism['Incash'][0].toFixed('1') + '%');
                  Incash.querySelector('h1').textContent = titheComparism['Incash'][0].toFixed('1') + '%';
                  Incash.querySelector('span.dim').textContent = '$' + titheComparism['Incash'][1];
                }
              }
              GetCashRegistry();
              const monthNames = [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
              ];
              function generateData(count, yrange) {
                WeekDays = ['Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun']
                var i = 0;
                var series = [];
                while (i < count) {
                  var x = WeekDays[i];
                  var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

                  series.push({
                    x: x,
                    y: y
                  });
                  i++;
                }
                return series;
              }
              function GetTitheData(direction) {
                const Mainparent = document.querySelector('.tithe_gross');
                Mainparent.querySelector('.current_val h1').textContent = RecordsTithe['Total'];
                Mainparent.querySelector('.previous_val h1').textContent = RecordsTithe['PrevTotal'];
                Mainparent.querySelector('.current_val .icon span').textContent = RecordsTithe['percent'].toFixed(2);
                data = [];
                labels = [];
                for (const key in RecordsTithe) {
                  const element = RecordsTithe[key];
                  if (typeof element == 'object') {
                    data.push(element[1])
                    labels.push(element[0])
                  }

                }
                let returnObj;
                if (direction == 'data') {
                  returnObj = data
                } else { returnObj = labels; }
                return returnObj;
              }
              function GetRecords(direction) {
                data = [];
                labels = [];
                for (const key in RecordData) {
                  const element = RecordData[key];
                  data.push(element)
                  labels.push(key)
                }
                let returnObj;
                if (direction == 'data') {
                  returnObj = data
                } else { returnObj = labels; }
                return returnObj;
              }
              function GetVisitors(month) {
                data = [];
                WeekDays = ['Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'];
                respond = true;
                for (const key in VisitorsChat) {
                  const element = VisitorsChat[key];
                  if (month == monthNames[parseInt(key)]) {
                    respond = false;
                    for (let i = 0; i < 7; i++) {
                      if (Object.keys(element).includes(String(i))) {
                        data.push({
                          x: WeekDays[i],
                          y: element[i]
                        })
                      } else {
                        data.push({
                          x: WeekDays[i],
                          y: 0
                        })
                      }

                    }
                  }
                }
                if (respond) {
                  for (let i = 0; i < 7; i++) {

                    data.push({
                      x: WeekDays[i],
                      y: 0
                    })


                  }
                }
                returnObj = data
                return returnObj;
              }
              function GetBudget(dir) {
                data_income = [];
                data_expenses = [];
                data_savings = [];
                labels = [];
                if (typeof BudgetData == 'object') {
                  for (const key in BudgetData) {
                    const element = BudgetData[key];
                    if (dir == 'income') {
                      data_income.push(element[0]);
                    }
                    if (dir == 'expenses') {
                      data_expenses.push(element[1]);
                    }
                    if (dir == 'savings') {
                      data_savings.push(element[2]);
                    }
                    if (dir == 'label') {
                      labels.push(monthNames[parseInt(key) - 1])
                    }
                  }
                  let returnObj;
                  if (dir == 'income') {
                    returnObj = data_income
                  }
                  if (dir == 'expenses') {
                    returnObj = data_expenses;
                  }
                  if (dir == 'savings') {
                    returnObj = data_savings;
                  }
                  if (dir == 'label') {
                    returnObj = labels;
                  }
                  return returnObj;
                }
              }
              function GetTitheYear(direction, specify) {
                const Mainparent = document.querySelector('.tithe_details');
                Mainparent.querySelector('.current_val h1').textContent = RecordsTithe['Total'];
                Mainparent.querySelector('.current_val .icon span').textContent = RecordsTithe['percent'].toFixed(2);

                data = [];
                labels = [];
                for (const key in RecordsTitheYear) {
                  const element = RecordsTitheYear[key];
                  if (typeof element == 'object') {
                    if (specify == 1) {
                      data.push(element['firstQ']);
                    }
                    if (specify == 2) {
                      data.push(element['secondQ']);
                    }
                    if (specify == 3) {
                      data.push(element['thirdQ']);
                    }

                    labels.push(key)
                  }

                }
                let returnObj;
                if (direction == 'data') {
                  returnObj = data
                } else { returnObj = labels; }
                return returnObj;
              }

              var options = {
                series: [{
                  name: "Amount",
                  data: GetTitheData('data')
                }],
                chart: {
                  type: 'area',
                  height: 280,
                  zoom: {
                    enabled: false
                  }
                },
                dataLabels: {
                  enabled: true
                },

                subtitle: {
                  text: 'Tithe summary Evalution',
                  align: 'left'
                },
                labels: GetTitheData('label'),

                yaxis: {
                  opposite: true
                },
                legend: {
                  horizontalAlign: 'left'
                },
                fill: {
                  type: 'gradient',
                  gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0,
                    opacityTo: 0.9,
                    stops: [0, 100]
                  }
                },
                markers: {
                  size: 1,
                  hover: {
                    size: 9
                  }
                },
                colors: ['#059fce'],
              };
              function GetEvent(dir) {
                data_events = [];
                data_revenue = [];
                labels = [];
                if (typeof ChartEvent == 'object') {
                  for (const key in ChartEvent) {
                    const element = ChartEvent[key];
                    if (dir == 'event' && key != 'Total') {
                      console.log(element);
                      data_events.push(element['firstQ'][0]);
                      data_events.push(element['secondQ'][0]);
                      data_events.push(element['thirdQ'][0]);
                    }
                    if (dir == 'revenue' && key != 'Total') {
                      data_revenue.push(element['firstQ'][1]);
                      data_revenue.push(element['secondQ'][1]);
                      data_revenue.push(element['thirdQ'][1]);
                    }

                  }
                  let returnObj;
                  if (dir == 'event') {
                    returnObj = data_events
                  }
                  if (dir == 'revenue') {
                    returnObj = data_revenue;
                  }
                  if (dir == 'label') {
                    returnObj = labels;
                  }
                  return returnObj;
                }
              }
              function GetMembers() {
                const MembershipElement = document.querySelector('.membership_main .current_val h1');
                MembershipElement.textContent = Membership['Data'][0];
                newData = [];
                for (let i = 1; i < 6; i++) {
                  newData.push(parseInt(Membership['Data'][i]));
                }
                return newData
              }
              function GetOffYear(direction, specify) {
                data = [];
                for (const key in Offertory) {
                  const element = Offertory[key];
                  if (typeof element == 'object') {
                    if (specify == 1) {
                      data.push(element['firstQ']);

                      data.push(element['secondQ']);

                      data.push(element['thirdQ']);
                    }

                  }

                }
                let returnObj;
                if (direction == 'data') {
                  returnObj = data
                }
                return returnObj;
              }

              var options = {
                series: [{
                  name: "Amount",
                  data: GetTitheData('data')
                }],
                chart: {
                  type: 'area',
                  height: 280,
                  zoom: {
                    enabled: false
                  }
                },
                dataLabels: {
                  enabled: true
                },

                subtitle: {
                  text: 'Tithe summary Evalution',
                  align: 'left'
                },
                labels: GetTitheData('label'),

                yaxis: {
                  opposite: true
                },
                legend: {
                  horizontalAlign: 'left'
                },
                fill: {
                  type: 'gradient',
                  gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0,
                    opacityTo: 0.9,
                    stops: [0, 100]
                  }
                },
                markers: {
                  size: 1,
                  hover: {
                    size: 9
                  }
                },
                colors: ['#059fce'],
              };


              var chart = new ApexCharts(document.querySelector("#tithe_main"), options);
              chart.render();

              var options2 = {
                series: [{
                  name: 'Records-',
                  data: GetRecords('data')
                }],
                chart: {
                  height: 350,
                  type: 'radar',
                },
                dataLabels: {
                  enabled: true
                },
                plotOptions: {
                  radar: {
                    size: 140,
                    polygons: {
                      strokeColors: '#e9e9e9',
                      fill: {
                        colors: ['#fff']
                      }
                    }
                  }
                },
                title: {
                  text: 'Records data summary <?php echo $_GET['Year']; ?>'
                },
                colors: ['#059fce'],
                markers: {
                  size: 4,
                  colors: ['#fff'],
                  strokeColor: '#059fce',
                  strokeWidth: 2,
                },
                tooltip: {
                  y: {
                    formatter: function (val) {
                      return val
                    }
                  }
                },
                xaxis: {
                  categories: GetRecords('label')
                },
                yaxis: {
                  tickAmount: 7,
                  labels: {
                    formatter: function (val, i) {
                      if (i % 2 === 0) {
                        return val
                      } else {
                        return ''
                      }
                    }
                  }
                }
              };

              var chart2 = new ApexCharts(document.querySelector("#Records"), options2);
              chart2.render();

              var options3 = {
                series: [{
                  name: 'Jan',
                  data: GetVisitors('Jan')
                },
                {
                  name: 'Feb',
                  data: GetVisitors('Feb')
                },
                {
                  name: 'Mar',
                  data: GetVisitors('Mar')
                },
                {
                  name: 'Apr',
                  data: GetVisitors('Apr')
                },
                {
                  name: 'May',
                  data: GetVisitors('May')
                },
                {
                  name: 'Jun',
                  data: GetVisitors('Jun')
                },
                {
                  name: 'Jul',
                  data: GetVisitors('Jul')
                },
                {
                  name: 'Aug',
                  data: GetVisitors('Aug')
                },
                {
                  name: 'Sep',
                  data: GetVisitors('Sep')
                },
                {
                  name: 'Oct',
                  data: GetVisitors('Oct')
                },
                {
                  name: 'Nov',
                  data: GetVisitors('Nov')
                },
                {
                  name: 'Dec',
                  data: GetVisitors('Dec')
                }
                ],
                chart: {
                  height: 280,
                  type: 'heatmap',
                },
                plotOptions: {
                  heatmap: {
                    shadeIntensity: 0.5,
                    radius: 3,
                    useFillColorAsStroke: true,
                    colorScale: {
                      ranges: [{
                        from: -100,
                        to: 0,
                        name: 'low',
                        color: '#8fd7ed'
                      },
                      {
                        from: 1,
                        to: 65,
                        name: 'high',
                        color: '#059fce'
                      },

                      ]
                    }
                  }
                },
                dataLabels: {
                  enabled: false
                },
                stroke: {
                  width: 1
                },
                title: {
                  text: 'Visitors range map'
                },
              };

              var chart3 = new ApexCharts(document.querySelector("#visits"), options3);
              chart3.render();

              var options4 = {
                series: [{
                  name: 'Income',
                  data: GetBudget('income')
                }, {
                  name: 'Expenses',
                  data: GetBudget('expenses')
                }, {
                  name: 'savings',
                  data: GetBudget('savings')
                }],
                chart: {
                  type: 'bar',
                  height: 350
                },
                plotOptions: {
                  bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                  },
                },
                dataLabels: {
                  enabled: false
                },
                stroke: {
                  show: true,
                  width: 2,
                  colors: ['transparent']
                },
                xaxis: {
                  categories: GetBudget('label'),
                },
                yaxis: {
                  title: {
                    text: ' (thousands)'
                  }
                },
                fill: {
                  opacity: 1
                },
                colors: ['#00E396', '#f30434', '#059fce'],
                tooltip: {
                  y: {
                    formatter: function (val) {
                      return " " + val + " .00"
                    }
                  }
                }
              };

              var chart4 = new ApexCharts(document.querySelector("#budget"), options4);
              chart4.render();
              var options5 = {
                series: [{
                  name: 'Total Events',
                  data: GetEvent('event')
                }, {
                  name: 'Revenue',
                  data: GetEvent('revenue')
                }],
                chart: {
                  type: 'bar',
                  height: 180
                },
                plotOptions: {
                  bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                  },
                },
                dataLabels: {
                  enabled: false
                },
                stroke: {
                  show: true,
                  width: 2,
                  colors: ['transparent']
                },
                xaxis: {
                  categories: ['first quarta', 'second quarta', 'third quarta'],
                },
                yaxis: {
                  title: {
                    text: ''
                  }
                },
                fill: {
                  opacity: 1
                },
                tooltip: {
                  y: {
                    formatter: function (val) {
                      return val
                    }
                  }
                }
              };

              var chart5 = new ApexCharts(document.querySelector("#events"), options5);
              chart5.render();

              var options6 = {
                labels: ["Adult males", "Adult females", "children male", "children female", 'uncategorized'],
                series: GetMembers(),
                chart: {
                  type: 'donut',
                  width: 340,
                  height: 217
                },
                legend: {
                  position: 'top'
                },
                plotOptions: {
                  pie: {
                    startAngle: -90,
                    endAngle: 90,
                    offsetY: 10
                  }
                },
                grid: {
                  padding: {
                    bottom: -10,
                  }
                },
                responsive: [{
                  breakpoint: 480,
                  options: {
                    chart: {
                      width: 280
                    },
                    legend: {
                      position: 'top'
                    }
                  }
                }]
              };

              var chart6 = new ApexCharts(document.querySelector("#membership"), options6);
              chart6.render();

              var options7 = {
                series: [{
                  name: 'Amount',
                  data: GetOffYear('data', 1)
                }],
                chart: {
                  height: 180,
                  type: 'bar',
                },
                plotOptions: {
                  bar: {
                    borderRadius: 10,
                    dataLabels: {
                      position: 'top', // top, center, bottom
                    },
                  }
                },
                dataLabels: {
                  enabled: true,
                  formatter: function (val) {
                    return val;
                  },
                  offsetY: -20,
                  style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                  }
                },

                xaxis: {
                  categories: ["Jan - Apr", "May - Aug", "Sep - Dec"],
                  position: 'bottom',
                  axisBorder: {
                    show: false
                  },
                  axisTicks: {
                    show: false
                  },
                  crosshairs: {
                    fill: {
                      type: 'gradient',
                      gradient: {
                        colorFrom: '#D8E3F0',
                        colorTo: '#BED1E6',
                        stops: [0, 100],
                        opacityFrom: 0.4,
                        opacityTo: 0.5,
                      }
                    }
                  },
                  tooltip: {
                    enabled: true,
                  }
                },
                yaxis: {
                  axisBorder: {
                    show: false
                  },
                  axisTicks: {
                    show: false,
                  },
                  labels: {
                    show: false,
                    formatter: function (val) {
                      return val + "";
                    }
                  }

                },
                title: {
                  floating: true,
                  align: 'center',
                  style: {
                    color: '#444'
                  }
                }
              };

              var chart7 = new ApexCharts(document.querySelector("#offertory"), options7);
              chart7.render();


              var options8 = {
                series: [
                  {
                    name: '1st quarta',
                    data: GetTitheYear('data', 1)
                  },
                  {
                    name: '2nd quarta',
                    data: GetTitheYear('data', 2)
                  },
                  {
                    name: '3rd quarta',
                    data: GetTitheYear('data', 3)
                  }
                ],
                chart: {
                  height: 200,
                  type: 'area',
                  zoom: {
                    enabled: false
                  }
                },
                dataLabels: {
                  enabled: false
                },
                stroke: {
                  curve: 'smooth'
                },
                xaxis: {
                  categories: GetTitheYear('label', 1)
                }
              };

              var chart8 = new ApexCharts(document.querySelector("#tithe_com"), options8);
              chart8.render();
            } else {
              alert('Analysis cannot be performed. insufficient Data');
            }
          }
        } catch (error) {
          console.error(error)
        }

      </script>
    </body>

    </html>

    <?php
  } else {
    echo '<h2 style="color:crimson;text-transform:uppercase;">An Error Occurred: Insufficient Data to perform analysis, upload more data and try again</h2>';
  }
} else {
  header('Location:../../../login/?Admin');
}
?>