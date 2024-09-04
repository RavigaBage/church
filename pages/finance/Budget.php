<?php
session_start();
require '../../API/vendor/autoload.php';
$newDataRequest = new Finance\viewData();
$year_fetch = date('Y');
if (isset($_GET['yearFilter'])) {
    $year_fetch = $_GET['yearFilter'];
}
if (isset($_GET['data_page'])) {
    $num = $_GET['data_page'];
} else {
    $num = 1;
}
if (isset($_SESSION['login_details'])) {
    $login_details = $_SESSION['login_details'];
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
    ?>

    <div class="filter_wrapper relative">
        <div style="height:40px;width:100%" class="flex">
            <div class="direction flex">
                <p>Dashboard</p>
                <span> - </span>
                <p class="location_date"></p>
            </div>
            <div class="options flex opt_left">
                <div class="item_opt flex filterBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                        <path d="M400-240v-80h160v80H400ZM240-440v-80h480v80H240ZM120-640v-80h720v80H120Z" />
                    </svg>
                    <p>Filter</p>
                </div>
                <div class="notification_list_filter">
                    <div class="item">
                        <h1>2024</h1>
                    </div>

                    <div class="item">
                        <h1>2023</h1>
                    </div>
                </div>


                <div class="item_opt flex">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#5f6368">
                        <path
                            d="M720-80q-50 0-85-35t-35-85q0-7 1-14.5t3-13.5L322-392q-17 15-38 23.5t-44 8.5q-50 0-85-35t-35-85q0-50 35-85t85-35q23 0 44 8.5t38 23.5l282-164q-2-6-3-13.5t-1-14.5q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35q-23 0-44-8.5T638-672L356-508q2 6 3 13.5t1 14.5q0 7-1 14.5t-3 13.5l282 164q17-15 38-23.5t44-8.5q50 0 85 35t35 85q0 50-35 85t-85 35Zm0-640q17 0 28.5-11.5T760-760q0-17-11.5-28.5T720-800q-17 0-28.5 11.5T680-760q0 17 11.5 28.5T720-720ZM240-440q17 0 28.5-11.5T280-480q0-17-11.5-28.5T240-520q-17 0-28.5 11.5T200-480q0 17 11.5 28.5T240-440Zm480 280q17 0 28.5-11.5T760-200q0-17-11.5-28.5T720-240q-17 0-28.5 11.5T680-200q0 17 11.5 28.5T720-160Zm0-600ZM240-480Zm480 280Z" />
                    </svg>
                    <p>Share</p>
                </div>
                <div class="item_opt flex">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#5f6368">
                        <path
                            d="M640-640v-120H320v120h-80v-200h480v200h-80Zm-480 80h640-640Zm560 100q17 0 28.5-11.5T760-500q0-17-11.5-28.5T720-540q-17 0-28.5 11.5T680-500q0 17 11.5 28.5T720-460Zm-80 260v-160H320v160h320Zm80 80H240v-160H80v-240q0-51 35-85.5t85-34.5h560q51 0 85.5 34.5T880-520v240H720v160Zm80-240v-160q0-17-11.5-28.5T760-560H200q-17 0-28.5 11.5T160-520v160h80v-80h480v80h80Z" />
                    </svg>
                    <p>Print</p>
                </div>

                <div class="item_opt flex">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                        <path
                            d="m105-233-65-47 200-320 120 140 160-260 109 163q-23 1-43.5 5.5T545-539l-22-33-152 247-121-141-145 233ZM863-40 738-165q-20 14-44.5 21t-50.5 7q-75 0-127.5-52.5T463-317q0-75 52.5-127.5T643-497q75 0 127.5 52.5T823-317q0 26-7 50.5T795-221L920-97l-57 57ZM643-217q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm89-320q-19-8-39.5-13t-42.5-6l205-324 65 47-188 296Z" />
                    </svg>
                    <a style="text-decoration:none;" target="_blank"
                        href="finance/budgetAnalysis.html?year=<?php echo $year_fetch; ?>">chart</a>
                </div>



            </div>
        </div>
    </div>

    <div class="content_pages">
        <div class="content_page_event">
            <div class="records_table ">
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
                <table class="budget">
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
                            echo "<td>" . $TotalIncome . "</td>";
                        }
                        echo "</tr>";
                        ?>

                    </tbody>

                </table>
                <table class="budget">
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
                            echo "<td>" . $TotalIncome . "</td>";
                        }
                        echo "</tr>";
                        ?>

                    </tbody>

                </table>

                <table class="budget">
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
                            echo "<td>" . $Savings . "</td>";
                        }
                        echo "</tr>";
                        ?>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <?php
} else {
    echo "<header>Sorry, You currently do not have access to any Admin privileges, please contact your administrator</header>";
}
?>