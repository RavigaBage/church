<?php
session_start();
require '../../API/vendor/autoload.php';
$newDataRequest = new Finance\viewData();
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

    <div class="part_1">
        <div class="middle">
            <div class="cards">
                <?php
                $data = json_decode($newDataRequest->Accounts_list_Card());
                if ($data != "" || $data != "Fetch data encountered an error") {
                    foreach ($data as $item) {
                        $amount = number_format(($item->amount), 2, '.', ',');
                        $modified = $item->modified;
                        $name = $item->name;

                        echo '<div class="card">
                        <div class="top">
                            <div class="left">
                                <img src="../images/BTC.png" alt="card1-1">
                            </div>
                            <img src="../images/visa.png" class="right" alt="card1-2">
                        </div>
                        <div class="middle">
                            <h1>Ȼ ' . $amount . '</h1>
                            <div class="chip">
                                <img src="../images/card chip.png" class="chip" alt="card-chip">
                            </div>
                        </div>
                        <b>' . $name . '</b>
                        <div class="bottom">
                            <div class="right">
                                <div class="card_data">
                                    <small>Holder</small>
                                    <h5>Church</h5>
                                </div>
                                
                                <div class="cvv">
                                    <small>modified</small>
                                    <h5>' . $modified . '</h5>
                                </div>
                            </div>
                        </div>
                    </div>';
                    }
                }
                ?>
            </div>
            <!-- monthly report -->
            <div class="monthly-report">
                <div class="report">
                    <h3>Income</h3>
                    <div>
                        <details>
                            <h1>$19,230</h1>
                            <h4 class="success">+4.6%</h4>
                        </details>
                        <p class="text-muted">Compared to $18,384 last month</p>
                    </div>
                </div>
                <div class="report">
                    <h3>Expenses</h3>
                    <div>
                        <details>
                            <h1>$9,113</h1>
                            <h4 class="danger">-6.2%</h4>
                        </details>
                        <p class="text-muted">Compared to $9,715 last month</p>
                    </div>
                </div>
                <div class="report">
                    <h3>Cashback</h3>
                    <div>
                        <details>
                            <h1>$4,390</h1>
                            <h4 class="success">+2.9%</h4>
                        </details>
                        <p class="text-muted">Compared to $4,266 last month</p>
                    </div>
                </div>
                <div class="report">
                    <h3>Income</h3>
                    <div>
                        <details>
                            <h1>$86,374</h1>
                            <h4 class="danger">-5.2%</h4>
                        </details>
                        <p class="text-muted">Compared to $91,111 last month</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="right">
            <table id="account_chart">

                <?php
                $data = json_decode($newDataRequest->Accounts_list_Data());
                if ($data == "" || $data == 'Error Occurred' || $data == 'Not Records Available') {
                    echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                } else {
                    echo "<thead>
                    <tr>
                       <th>Description</th>
                        <th>Date</th>
                        <th>category</th>
                        <th>P%</th>
                        <th>Amount</th>
                        <th>Balance</th>
                    </tr>
                </thead><tbody>";
                    foreach ($data as $item) {

                        $description = $item->description;
                        $amount = $item->amount;
                        $balance = $item->balance;
                        $percentage = $item->percentage;
                        $category = $item->category;
                        $date = $item->date;
                        $account = $item->account;

                        if ($category == 'expenses') {
                            $item = "<div class='out_btn'><div></div>Out</div>";
                        } else {
                            $item = "<div class='in_btn'><div></div>In</div>";
                        }

                        if (intval($percentage) <= 0) {
                            $item_2 = "<div class='danger'>" . $percentage . "%</div>";
                        } else {
                            $item_2 = "<div class='success'>+ " . $percentage . "%</div>";
                        }

                        echo "<tr>
                    <td>" . $account . " " . $description . "</td>
                    <td>" . $date . "</td>
                    <td>" . $item . "</td>
                    <td>" . $item_2 . "</td>
                    <td>" . $amount . "</td>
                    <td>" . $balance . "</td>
                </tr>";
                    }
                    echo "</tbody>";
                }
                ?>
            </table>
        </div>
    </div>
    <?php
} else {
    echo "<header>Sorry, you are not allowed on this page, please contact your administrator</header>";
}
?>