<?php
if (isset($_SESSION['Admin_access'])) {
    $login_details = $_SESSION['Admin_access'];
    if (!isset($_SESSION['access_entryLog'])) {
        $date = date('Y-m-d H:i:s');
        $newquest = $newDataRequest->DataHistory($login_details, "Access page selection", $date, "Access page section", "Admin Viewed Access page section");
        $decode = json_decode($newquest);
        if ($decode == 'Success') {
            $condition = true;
            $_SESSION['access_entryLog'] = true;
        }
    } else {
        $condition = true;
    }
} else {
    $condition = false;
}

if ($condition) {
    if (isset($_GET['year'])) {
        require '../../../API/vendor/autoload.php';
        $newDataRequest = new Finance\viewData();

        $year_fetch = $_GET['year'];

        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/budget_analysis.css" />
            <title>budget summary analysis</title>
        </head>

        <body>
            <main>
                <div class="navigation">
                    <nav>
                        <div class="card">
                            <p>Select Period </p>
                            <div class="btns">
                                <div class="select">
                                    <span>march</span>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <p>Period Expenses Tracker </p>
                            <span class="sxml"><strong class="red income_tile"></strong>of the total <strong
                                    class="income_t">(100%)</strong> income earn was
                                saved</span>
                        </div>

                        <div class="card">
                            <p>Select saving </p>
                            <span class="sxml"><strong class="blue expenses_tile">35.23%</strong> of the total income was spent
                                on expenditure <b class="red saving_tile">90%</b> become the amount left</span>
                        </div>

                        <div class="card last">
                            <div class="item">
                                <p>Year</p>
                                <p><?php echo $year_fetch; ?></p>
                            </div>
                            <div class="item">
                                <p>Period</p>
                                <p>full year</p>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="container">
                    <div class="tables">
                        <div class="title">
                            <p>Breakdown - <?php echo $year_fetch; ?></p>
                        </div>
                        <?php
                        $data = $newDataRequest->BudgetList($year_fetch);
                        $DecodedData = json_decode($data);
                        $income = $DecodedData->INCOME->income;
                        $offertory = $DecodedData->INCOME->offertory;
                        $tithe = $DecodedData->INCOME->tithe;


                        $Ultilities = $DecodedData->EXPENSES->Ultilities;
                        $Housing = $DecodedData->EXPENSES->Housing;
                        $paycheck = $DecodedData->EXPENSES->paycheck;
                        $Others = $DecodedData->EXPENSES->Others;

                        ?>
                        <table class="income">
                            <thead>
                                <tr class="income_deep">
                                    <th>Income</th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>May</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Aug</th>
                                    <th>Sep</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    <th>Dec</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                function declareName($tableValue)
                                {
                                    if ($tableValue == "0" || $tableValue == 0) {
                                        $tableValue = "-";
                                    }
                                    return $tableValue;
                                }
                                echo "<tr class='income'>
                      <td>Offertory</td>";
                                foreach ($offertory as $tableValue) {
                                    $tableValue = declareName($tableValue);
                                    echo "<td>" . $tableValue . "</td>";
                                }
                                echo "</tr>";


                                echo "<tr class='income'>
                                            <td>Tithes</td>";
                                foreach ($tithe as $tableValue) {
                                    $tableValue = declareName($tableValue);
                                    echo "<td>" . $tableValue . "</td>";
                                }
                                echo "</tr>";

                                echo "<tr class='income'>
                                            <td>Other sources</td>";
                                foreach ($income as $tableValue) {
                                    $tableValue = declareName($tableValue);
                                    echo "<td>" . $tableValue . "</td>";
                                }
                                echo "</tr>";




                                $Months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                echo "<tr class='neutral'>
                                            <td>Total</td>";
                                foreach ($Months as $month) {
                                    $TotalIncome = intval($offertory->$month) + intval($tithe->$month) +
                                        intval($income->$month);
                                    $TotalIncome = declareName($TotalIncome);
                                    echo "<td class='income total'>" . $TotalIncome . "</td>";
                                }
                                echo "</tr>";
                                ?>

                            </tbody>

                        </table>
                        <table class="expenses">
                            <thead>
                                <tr class="expenses_deep">
                                    <th>expense</th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>May</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Aug</th>
                                    <th>Sep</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    <th>Dec</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                echo "<tr class='expenses'>
                                            <td>Ultilities</td>";
                                foreach ($Ultilities as $tableValue) {
                                    $tableValue = declareName($tableValue);
                                    echo "<td>" . $tableValue . "</td>";
                                }
                                echo "</tr>";
                                echo "<tr class='expenses'>
                                            <td>Housing</td>";
                                foreach ($Housing as $tableValue) {
                                    $tableValue = declareName($tableValue);
                                    echo "<td>" . $tableValue . "</td>";
                                }
                                echo "</tr>";

                                echo "<tr class='expenses'>
                                            <td>Paychecks</td>";
                                foreach ($paycheck as $tableValue) {
                                    $tableValue = declareName($tableValue);
                                    echo "<td>" . $tableValue . "</td>";
                                }
                                echo "</tr>";

                                echo "<tr class='expenses'>
                                            <td>Others</td>";
                                foreach ($Others as $tableValue) {
                                    $tableValue = declareName($tableValue);
                                    echo "<td>" . $tableValue . "</td>";
                                }
                                echo "</tr>";




                                $Months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                echo "<tr class='neutral'>
                                            <td>Total</td>";
                                foreach ($Months as $month) {
                                    $TotalIncome = intval($Ultilities->$month) + intval($Housing->$month) + intval($paycheck->$month) + intval($Others->$month);
                                    $TotalIncome = declareName($TotalIncome);
                                    echo "<td class='expenses total'>" . $TotalIncome . "</td>";
                                }
                                echo "</tr>";
                                ?>

                            </tbody>

                        </table>

                        <table class="records">
                            <thead>
                                <tr class="record_deep">
                                    <th>SAVINGS</th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>May</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Aug</th>
                                    <th>Sep</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    <th>Dec</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $Months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                                echo "<tr class='record'>
                                            <td>Total</td>";
                                foreach ($Months as $month) {
                                    $TotalExpenses = intval($Ultilities->$month) + intval($Housing->$month) + intval($paycheck->$month) + intval($Others->$month);



                                    $TotalIncome = intval($offertory->$month) + intval($tithe->$month) +
                                        intval($income->$month);

                                    $Savings = declareName(intval($TotalIncome) - intval($TotalExpenses));
                                    echo "<td class='saving total'>" . $Savings . "</td>";
                                }
                                echo "</tr>";
                                ?>

                            </tbody>

                        </table>
                    </div>
                    <div class="summary">
                        <div class="title">
                            <p>Summary - Year <?php echo $year_fetch; ?></p>
                        </div>
                        <div class="charts">
                            <div class="main_data income_chart"></div>
                            <div class="main_data Tracked_Budget"></div>
                            <div class="main_data Expenses_chart"></div>
                            <div class="main_data saving_chart"></div>
                        </div>
                    </div>
            </main>
            <script src="../department/apexcharts-bundle/dist/apexcharts.js"></script>
            <script src="../department/apexcharts-bundle/samples/assets/stock-prices.js"></script>
            <script>
                var IncomeList = document.querySelectorAll('td.income.total');
                var expensesList = document.querySelectorAll('td.expenses.total');
                var savingList = document.querySelectorAll('td.saving.total');

                IncomeChart = [];
                ExpensesChart = [];
                SavingChart = [];

                TotalIncome = 0;
                TotalExpenses = 0;
                TotalSaving = 0;
                function AnalyseData(TotalIncome, TotalExpenses, TotalSaving) {
                    var IncomeSpan = document.querySelector('.income_tile');
                    var ExpensesSpan = document.querySelector('.expenses_tile');
                    var SavingSpan = document.querySelector('.saving_tile');
                    var Incometotal = document.querySelector('.income_t');
                    IncomeList.forEach(element => {
                        target = element.innerText
                        if (!target.includes('-')) {
                            if (parseInt(target)) {
                                TotalIncome += parseInt(target);
                            }
                        } else {
                            target = '0';
                        }
                        IncomeChart.push(parseInt(target));

                    });
                    expensesList.forEach(element => {
                        target = element.innerText
                        if (!target.includes('-')) {
                            if (parseInt(target)) {
                                TotalExpenses += parseInt(target);
                            }
                        } else {
                            target = '0';
                        }
                        ExpensesChart.push(parseInt(target));
                    });
                    savingList.forEach(element => {
                        target = element.innerText
                        if (!target.includes('-')) {
                            if (parseInt(target)) {
                                TotalSaving += parseInt(target);
                            }
                        } else {
                            target = '0';
                        }
                        SavingChart.push(parseInt(target));
                    });
                    Percentile = 100 * TotalSaving / TotalIncome;
                    IncomeSpan.innerText = `${Math.ceil(Percentile)}% `;
                    ExpensesSpan.innerText = `${100 - Math.ceil(Percentile)}% `;
                    SavingSpan.innerText = `${TotalSaving}`;
                    Incometotal.innerText = `${TotalIncome}`;
                }
                AnalyseData(TotalIncome, TotalExpenses, TotalSaving);
                var _seed = 42;
                Math.random = function () {
                    _seed = _seed * 16807 % 2147483647;
                    return (_seed - 1) / 2147483646;
                };

                var options = {
                    series: [44, 55, 41, 17, 15],
                    chart: {
                        width: 380,
                        type: 'donut',
                        color: '#fff'
                    },
                    colors: ['#086d38', '#ddd', '#fff', '#ffd'],
                    plotOptions: {
                        pie: {
                            startAngle: -90,
                            endAngle: 270
                        }
                    },
                    dataLabels: {
                        enabled: false,
                        style: {
                            colors: ['#086d38', '#ddd', '#fff', '#ffd'],
                        },
                    },
                    fill: {
                        colors: ['#086d38', '#ddd', '#fff', '#ffd'],

                    },
                    legend: {
                        formatter: function (val, opts) {
                            return val + " - " + opts.w.globals.series[opts.seriesIndex]
                        }
                    },
                    title: {
                        text: 'Chart representation of data'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };
                var options3 = {
                    series: IncomeChart,
                    chart: {
                        width: 380,
                        type: 'donut',
                        color: '#fff'
                    },
                    colors: ['#29373b', '#e7870c', '#086d38', '#09aced', '#ddd', '#0fdba4', '#c54040', '#ffd', '#c5aa40', '#b1db0f', '#ed0970', '#f37373'],
                    plotOptions: {
                        pie: {
                            startAngle: -90,
                            endAngle: 270
                        }
                    },
                    dataLabels: {
                        enabled: false,
                        style: {
                            colors: ['#29373b', '#e7870c', '#086d38', '#09aced', '#ddd', '#0fdba4', '#c54040', '#ffd', '#c5aa40', '#b1db0f', '#ed0970', '#f37373'],
                        },
                    },
                    fill: {
                        colors: ['#29373b', '#e7870c', '#086d38', '#09aced', '#ddd', '#0fdba4', '#c54040', '#ffd', '#c5aa40', '#b1db0f', '#ed0970', '#f37373'],

                    },
                    title: {
                        text: 'Chart representation of Income data'
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            }
                        }
                    }]
                };
                var options41 = {
                    series: [{
                        name: "Expenses",
                        data: ExpensesChart,
                    }],
                    chart: {
                        height: 350,
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
                        text: 'Expenses Trends by Month',
                        align: 'left'
                    },
                    grid: {
                        row: {
                            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    xaxis: {
                        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    }
                };

                var options2 = {
                    series: [{
                        name: 'Income',
                        type: 'column',
                        data: IncomeChart
                    }, {
                        name: 'Expenses',
                        type: 'area',
                        data: ExpensesChart
                    }, {
                        name: 'Saving',
                        type: 'line',
                        data: SavingChart
                    }],
                    chart: {
                        height: 240,
                        type: 'line',
                        stacked: false,
                    },
                    stroke: {
                        width: [0, 2, 5],
                        curve: 'smooth'
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '50%'
                        }
                    },

                    fill: {
                        opacity: [0.85, 0.25, 1],
                        gradient: {
                            inverseColors: false,
                            shade: 'light',
                            type: "vertical",
                            opacityFrom: 0.85,
                            opacityTo: 0.55,
                            stops: [0, 100, 100, 100]
                        }
                    },
                    labels: ['01/01/<?php echo $year_fetch; ?>', '02/01/<?php echo $year_fetch; ?>', '03/01/<?php echo $year_fetch; ?>', '04/01/<?php echo $year_fetch; ?>', '05/01/<?php echo $year_fetch; ?>', '06/01/<?php echo $year_fetch; ?>', '07/01/<?php echo $year_fetch; ?>',
                        '08/01/<?php echo $year_fetch; ?>', '09/01/<?php echo $year_fetch; ?>', '10/01/<?php echo $year_fetch; ?>', '11/01/<?php echo $year_fetch; ?>'
                    ],
                    markers: {
                        size: 0
                    },
                    xaxis: {
                        type: 'datetime'
                    },
                    yaxis: {
                        title: {
                            text: 'Points',
                        },
                        min: 0
                    },
                    tooltip: {
                        shared: true,
                        intersect: false,
                        y: {
                            formatter: function (y) {
                                if (typeof y !== "undefined") {
                                    return y.toFixed(0) + " points";
                                }
                                return y;

                            }
                        }
                    }
                };
                var options5 = {
                    series: [{
                        data: SavingChart
                    }],
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            borderRadiusApplication: 'end',
                            horizontal: true,
                        }
                    },
                    title: {
                        text: 'Chart representation of Saving data'
                    },
                    dataLabels: {
                        enabled: false
                    },
                    xaxis: {
                        categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
                        ],
                    }
                };

                var chart1 = new ApexCharts(document.querySelector(".Tracked_Budget"), options2);
                chart1.render();

                var chart = new ApexCharts(document.querySelector(".income_chart"), options3);
                chart.render();
                var chart2 = new ApexCharts(document.querySelector(".Expenses_chart"), options41);
                chart2.render();
                var chart3 = new ApexCharts(document.querySelector(".saving_chart"), options5);
                chart3.render();



            </script>
        </body>

        </html>
        <?php
    }
} else {
    header('Location:../error404/general404.html');
    }
?>