<?php
session_start();
require '../../../API/vendor/autoload.php';
$newDataRequest = new Finance\viewData();

if (isset($_GET['page'])) {
    $num = $_GET['page'];
} else {
    $num = 1;
}

if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];
    $token = $_SESSION['Admin_access'];
    $known = hash('sha256', $unique_id . 'admin');
    if ((hash_equals($known, $token))) {
        if (!isset($_SESSION['Account_Log'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $newDataRequest->DataHistory($unique_id, "Admin permit was used to logged in", $date, "Dashboard Account", "Admin permit was used logged in to dashboard");
            $decode = json_decode($newquest);
            if ($decode == 'Success') {
                $_SESSION['Account_Log'] = true;
                $condition = true;
            }
        } else {
            $condition = true;
        }
    } else {
        $condition = false;
    }
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
                                <img src="../../images/BTC.png" alt="card1-1">
                            </div>
                            <img src="../../images/visa.png" class="right" alt="card1-2">
                        </div>
                        <div class="middle">
                            <h1>Ȼ ' . $amount . '</h1>
                            <div class="chip">
                                <img src="../../images/card chip.png" class="chip" alt="card-chip">
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
                $data = json_decode($newDataRequest->Accounts_list_Data($num));
                if ($data == "" || $data == 'Error Occurred' || $data == 'Not Records Available') {
                    echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                } else {
                    echo "<thead>
                    <tr>
                    <th>No.</th>
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

                        echo "<tr><td class='count'><input type='checkbox' /></td>
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
    <div class="page_sys">
        <?php
        $total = $newDataRequest->AccountPages();
        if ($total != 'Error Occurred') {
            ?>
            <header>
                <?php
                $total_raw = $total / 40;
                $total = ceil($total / 40);
                if ($total_raw > 1) {
                    echo 'Pages:';
                    ?>


                    <div class="pages">
                        <?php
                        $loop = $total_raw;
                        $start = 1;
                        $original_1 = $total;
                        if ($total > 6) {
                            $original_1 = 7;
                            if ($num >= 6) {

                                if ($num >= 6 && $num <= ($total - 6)) {
                                    $multiplier = floor($num / 6);
                                    echo $multiplier;
                                    if ($multiplier <= 1) {
                                        $constant = 1;
                                    } else {
                                        $constant = $multiplier + 1;
                                    }
                                    $start = 6 * $constant;
                                    $original_1 = $start + 6;
                                } else {
                                    $start = $total - 6;
                                    $original_1 = $total - 1;
                                }
                            }
                            for ($i = $start; $i < ($original_1); $i++) {
                                $class = "";
                                if ($i == $num) {
                                    $class = 'active';
                                }
                                echo '<div class="' . $class . '">' . $i . '</div>';
                            }
                        } else {

                            for ($i = $start; $i < ($original_1); $i++) {
                                $class = "";
                                if ($i == $num) {
                                    $class = 'active';
                                }
                                echo '<div class="' . $class . '">' . $i . '</div>';
                            }


                        }
                        if ($total_raw > 6) {
                            $final = $total - 1;
                        } else {
                            $final = $total;
                        }
                        if ($loop >= 6 && $original_1 < ($total - 2)) {
                            echo '<span>......</span><div>' . $final . '</div>';
                        } else {
                            $class = '';
                            if ($num == $final) {
                                $class = 'active';
                            }
                            echo '<div class=' . $class . '>' . $final . '</div>';
                        }
                        ?>
                    </div>
                </header>
                <?php
                }
        }
        ?>
    </div>
    <div class="event_menu_add form_data">
        <form>
            <header>New Activity</header>
            <div class="loader">.....loading data please wait</div>
            <div class="container_event">
                <div class="field">
                    <label>Account</label>
                    <input type="text" placeholder="Enter the bank / account name" name="account">
                </div>
                <div class="field">
                    <label>Date created</label>
                    <label>Account</label>
                    <input type="date" placeholder="Enter the date the account was created" name="date">
                </div>

                <div class="field">
                    <label>Authorize</label>
                    <input type="amount" class="form_condition" name="amount"
                        placeholder="what is the current amount in the account" required />
                </div>

                <input name="delete_key" value="000" hidden />
                <button>upload account</button>
            </div>
        </form>
    </div>

    <div class="event_menu_add form_data  acc_delete">
        <form>
            <header>Account Setting</header>
            <?php
            $data = $newDataRequest->Accounts_list_view();
            if(is_object(json_decode($data))){
                $data = json_decode($data);
                foreach($data as $item){
                      foreach ($item as $key) {
                        echo "
                        <div class='item flex'>
                            <div class='details'>
                                <p class='item_name'>".$key."</p>
                            </div>
                            <div class='delete option'>
                            <i class='fas fa-trash delete_item' delete_acc='".$key."'></i>
                            </div>
                        </div>";
                      }
                        
                    }
                  
                }
            
            ?>
        </form>
    </div>
    <div class="info_information event_menu_add"
                style="height:300px; width:500px; padding:10px;text-wrap:wrap;display:grid;place-items:center;">
                <header class="danger"></header>
            </div>

    <div class="add_event" data-menu="event">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
            <path
                d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
        </svg>
        <p>New</p>
    </div>

    <div class="add_event far" data-menu="event">
    <i class='fas fa-trash delete_item' ></i>
        <p>Delete</p>
    </div>
    <?php
} else {
    header('Location:../error404/general404.html');
}
?>