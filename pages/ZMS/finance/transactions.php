<?php
require '../../../API/vendor/autoload.php';
$newDataRequest = new Finance\viewData();
session_start();
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
        if (!isset($_SESSION['Transaction_Log'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $newDataRequest->DataHistory($unique_id, "Admin permit was used to logged in", $date, "Dashboard Transaction", "Admin permit was used logged in to dashboard");
            $decode = json_decode($newquest);
            if ($decode == 'Success') {
                $_SESSION['Transaction_Log'] = true;
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

    <div class="filter_wrapper relative">
        <div style="height:40px;width:100%" class="flex">
            <div class="direction flex">
                <p>Dashboard</p>
                <span> - </span>
                <p class="location_date">membership</p>
            </div>
            <div class="options flex opt_left">

            <div class="item_opt flex" id="data_upload">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" />
                        <path d="M9 15l3 -3l3 3" />
                        <path d="M12 12l0 9" />
                        </svg>
                    <p>upload</p>
                </div>
                <div class="item_opt flex">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#5f6368">
                        <path
                            d="M640-640v-120H320v120h-80v-200h480v200h-80Zm-480 80h640-640Zm560 100q17 0 28.5-11.5T760-500q0-17-11.5-28.5T720-540q-17 0-28.5 11.5T680-500q0 17 11.5 28.5T720-460Zm-80 260v-160H320v160h320Zm80 80H240v-160H80v-240q0-51 35-85.5t85-34.5h560q51 0 85.5 34.5T880-520v240H720v160Zm80-240v-160q0-17-11.5-28.5T760-560H200q-17 0-28.5 11.5T160-520v160h80v-80h480v80h80Z" />
                    </svg>
                    <p>Print</p>
                </div>
                <div class="item_opt flex" id="ExportBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#5f6368">
                        <path
                            d="M480-320 280-520l56-58 104 104v-326h80v326l104-104 56 58-200 200ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z" />
                    </svg>
                    <p>Export</p>
                </div>
            </div>
        </div>
    </div>

    <div class="export_dialogue" style="height:300px;width:600px;">
        <form>
            <header>Exporting Data</header>
            <div class="loader">All fields required</div>
            <div class="container_event">
                <p>By clicking on the save document button, available data is downloaded unto this current device</p>
                <button id="exportDataBtn">Save document</button>
            </div>
        </form>
    </div>

    <div class="event_menu_add form_data">
        <form>
            <header>New Activity</header>
            <div class="loader_wrapper">
                <div class="load-3">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
                <div class="text">
                    <p style="color:crimson"></p>
                </div>
            </div>
            <div class="container_event">
                <div class="field">
                    <label>Account</label>
                    <select class="form_condition" name="account">
                        <?php
                        $data = json_decode($newDataRequest->Accounts_list_view());
                        if ($data != "" || $data != 'Error Occurred' || $data != 'Not Records Available') {
                            foreach ($data as $data_row) {
                                foreach($data_row as $row){
                                    echo "<option value='$row'>$row</option>";
                                }
                                
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="field">
                    <label>Status</label>
                    <select class="form_condition" name="status_information" required>
                        <option value="pending">pending</option>
                        <option value="completed">completed</option>
                        <option value="terminated">terminated</option>
                    </select>
                </div>

                <div class="field">
                    <label>Authorize</label>
                    <input type="text" class="form_condition" name="authorize" value="" placeholder="" required />
                </div>
                <div class="field">
                    <label>category</label>
                    <select class="form_condition" name="category">
                        <option value="income">Income</option>
                        <option value="expenses">Expenses</option>

                    </select>
                </div>

                <div class="field">
                    <label>Amount</label>
                    <input class="form_condition" type="number" name="amount" required />
                </div>
                <div class="field">
                    <label>Activity Date</label>
                    <input type="date" class="form_condition" name="date">
                </div>
                <input name="delete_key" value="000" type="number" hidden />
                <button>create Activity</button>
            </div>
        </form>
    </div>
    <div class="content_pages">
        <div class="content_page_event">
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
            <div class="records_table">

                <div class="transaction_search_menu flex">
                    <div class="filter_option">
                        <p>Account</p>

                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#5f6368">
                            <path d="M480-360 280-560h400L480-360Z" />
                        </svg>
                        <select class="select" name="accfilter">
                            <?php
                            $data = json_decode($newDataRequest->Accounts_list_view());
                            if ($data != "" || $data != 'Error Occurred' || $data != 'Not Records Available') {
                                foreach ($data as $data_row) {
                                    foreach($data_row as $row){
                                        echo "<option value='$row'>$row</option>";
                                    }
                                }
                            }
                            ?>
                        </select>


                    </div>

                    <div class="filter_option">
                        <p>Category</p>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#5f6368">
                            <path d="M480-360 280-560h400L480-360Z" />
                        </svg>
                        <select class="select" name="catfilter">
                            <option>Select</option>
                            <option value="expenses">Expenses</option>
                            <option value="income">Income</option>
                            <option value="saving">deposit</option>
                        </select>
                    </div>

                    <div class="filter_option">
                        <p>Year</p>
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#5f6368">
                            <path d="M480-360 280-560h400L480-360Z" />
                        </svg>
                        <select class="select" name="yearfilter">
                            <option>2024</option>
                            <option>2022</option>
                            <option>2023</option>

                        </select>
                    </div><i class="fas fa-funnel"></i>
                    <button class="List_filter">Filter</button>
                </div>
                <div hidden>
                    <table>
                        <tr class="cloneSearch">
                            <td>
                                <div class='details'>
                                    <div class='text'>
                                        <p class="Clonename"></p>
                                        <p class="Clonedate"></p>
                                    </div>

                                </div>
                            </td>
                            <td class="Cloneitem"></td>
                            <td class="CloneAuthorize"></td>
                            <td class="Cloneamount"></td>
                            <td class="Clonecategory"></td>
                            <td class='option'>
                                <div class='delete option'>
                                    <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960' width='30'>
                                        <path
                                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                    </svg>
                                    <div class='opt_element'>
                                        <p class='update_item up' Update_item='' data-information=''>Update item <i></i></p>
                                        <p class='delete_item dp' delete_item=''>Delete item <i></i></p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

                <table id="main_table">
                    <?php
                    $data = $newDataRequest->TransactionList($num);
                    if ($data == "" || $data == 'Error Occurred' || $data == 'No Records Available') {
                        echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                    } else {
                        echo "<thead>
                            <tr>
                                <th>Account</th>
                                <th>status</th>
                                <th>Authorize</th>
                                <th>Amount</th>
                                <th>category</th>
                                <th>...</th>
                            </tr>
                        </thead><tbody>";
                        $data_New = json_decode($data);
                        foreach ($data_New as $item) {
                            $account = $item->account;
                            $amount = $item->amount;
                            $date = $item->Date;
                            $category = $item->category;
                            $Authorize = $item->Authorize;
                            $Status = $item->Status;
                            $id = $item->id;
                            $ObjectData = $item->obj;

                            if ($Status == 'terminated') {
                                $item = "<div class='out_btn'><div></div>" . $Status . "</div>";
                            } else
                                if ($Status == 'pending') {
                                    $item = "<div class='in_btn blue'><div></div>" . $Status . "</div>";
                                } else {
                                    $item = "<div class='in_btn'><div></div>" . $Status . "</div>";
                                }

                            echo "<tr>
                                <td><div class='details'>
                               
                                <div class='text'>
                                <p>" . $account . "</p>
                                <p>" . $date . "</p>
                                </div>
                                
                                </div></td>
                                <td>" . $item . "</td>
                                <td>" . $Authorize . "</td>
                                <td>" . $amount . "</td>
                                <td>" . $category . "</td>
                                <td class='option'>
                                    <div class='delete option'>
                                            <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                                                width='30'>
                                                <path
                                                    d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                            </svg>
                                            <div class='opt_element'>
                                                <p class='update_item' Update_item='" . $id . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                                                <p class='delete_item' delete_item='" . $id . "' >Delete item <i></i></p>
                                            </div>
                                    </div>
                                </td>
                            </tr>";


                        }
                        echo "</tbody>";
                    }
                    ?>



                </table>
            </div>
        </div>
    </div>

    <div class="page_sys">
        <?php
        if (isset($_SESSION['total_pages_transactions'])) {
            $total = $_SESSION['total_pages_transactions'];
        } else {
            $total = $newDataRequest->Trans_Pages();
            $_SESSION['total_pages_transactions'] = $total;
        }
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
    <?php
} else {
    header('Location:../error404/general404.html');
}
?>