var _seed = 42;
Math.random = function () {
  _seed = (_seed * 16807) % 2147483647;
  return (_seed - 1) / 2147483646;
};

var options = {
  series: [
    {
      name: "STOCK ABC",
      data: series.monthDataSeries1.prices,
    },
  ],
  chart: {
    type: "area",
    height: 300,
    zoom: {
      enabled: false,
    },
  },
  dataLabels: {
    enabled: false,
  },
  stroke: {
    curve: "straight",
  },

  title: {
    text: "Fundamental Analysis of Church growth",
    align: "left",
  },
  subtitle: {
    text: "Growth Movements",
    align: "left",
  },
  labels: series.monthDataSeries1.dates,
  xaxis: {
    type: "datetime",
  },
  yaxis: {
    opposite: true,
  },
  legend: {
    horizontalAlign: "left",
  },
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();

var options = {
  series: [44, 55, 13, 43, 22],
  chart: {
    width: 320,
    type: "pie",
  },
  labels: ["Male", "Females", "Teen", "Kids", "Elderly"],
  responsive: [
    {
      breakpoint: 480,
      options: {
        chart: {
          width: 200,
        },
        legend: {
          position: "bottom",
        },
      },
    },
  ],
};

var chart = new ApexCharts(document.querySelector("#chart_2"), options);
chart.render();
