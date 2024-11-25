<?php
session_start();
require '../../../API/vendor/autoload.php';
$newDataRequest = new Finance\viewData();
if (isset($_GET['data_page'])) {
    $num = $_GET['data_page'];
} else {
    $num = 1;
}
if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];
    $token = $_SESSION['Admin_access'];
    $known = hash('sha256', $unique_id . 'admin');
    if ((hash_equals($known, $token))) {
        if (!isset($_SESSION['Expenses_Log'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $newDataRequest->DataHistory($unique_id, "Admin permit was used to logged in", $date, "Dashboard Expenses", "Admin permit was used logged in to dashboard");
            $decode = json_decode($newquest);
            if ($decode == 'Success') {
                $_SESSION['Expenses_Log'] = true;
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

    <div class="export_dialogue" style="width:600px;height:400px;">
        <form>
            <header>Exporting Data</header>
            <div class="loader">All fields required</div>
            <div class="container_event">
                <p>By clicking on the save document button, available data is downloaded unto this current device</p>
                <button id="exportDataBtn">Save document</button>
            </div>
        </form>
    </div>

    <div class="content_pages">
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
                        <label>Select category</label>
                        <select name="category">
                            <option value="expenses">Expenses</option>
                            <option value="income">Income</option>
                            <option value="saving">deposit</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Type</label>
                        <select name="type">
                            <option>Select</option>
                            <option value="housing">housing</option>
                            <option value="ultilities">ultiliy(electricity,water,gas,internet)</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="transportation">transportation</option>
                            <option value="gasoline">gasoline</option>
                            <option value="insurance">insurance</option>
                            <option value="food">food and groceries</option>
                            <option value="clothings">clothings</option>
                            <option value="investment">Investment</option>
                            <option value="bonds">Bonds</option>
                            <option value="paycheck">paychecks</option>
                            <option value="gifts">Gifts</option>
                            <option value="expenses">donation</option>

                            <option value="income">food and drinks</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Amount</label>
                        <input name="Amount" type="number" placeholder="" />
                    </div>
                    <div class="field_e">
                        <label>Details</label>
                        <textarea name="details"></textarea>
                    </div>
                    <div class="field">
                        <label>Activity Date</label>
                        <input name="Date" type="date" placeholder="" required />
                    </div>

                    <button>create Activity</button>
                    <input hidden name="delete_key" type="number"/>
                </div>
            </form>

        </div>
        <div class="content_page_event">

            <div class="add_event">
                <i>+</i>
                <p>New</p>
            </div>


            <div class="transaction_search_menu flex">
                <div class="filter_option">
                    <p>Category</p>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                        <path d="M400-240v-80h160v80H400ZM240-440v-80h480v80H240ZM120-640v-80h720v80H120Z" />
                    </svg>
                    <select class='select' name="catfilter">
                        <option value="expenses">Expenses</option>
                        <option value="income">Income</option>
                        <option value="saving">deposit</option>
                    </select>
                </div>
                <div class="filter_option">
                    <p>Year</p>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                        <path d="M400-240v-80h160v80H400ZM240-440v-80h480v80H240ZM120-640v-80h720v80H120Z" />
                    </svg>

                    <select class='select' name="yearfilter">
                        <option>2024</option>
                        <option>2023</option>
                    </select>
                </div>
                <button class="List_filter">Filter</button>
            </div>

            <div hidden>
                <table>
                    <tr class='' id="CloneSearch">
                        <td class="Clonedeatils" title=''>
                            <p>hover to view details</p>
                        <td>
                            <p class="Clonedate"></p>
                        </td>
                        <td>
                            <p class="Clonetype"></p>
                        </td>
                        <td>
                            <p class="Clonerecord"></p>
                        </td>
                        </td>
                        <td class="Cloneamount"></td>
                        <td class='delete option'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960' width='48'>
                                <path
                                    d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                            </svg>
                            <div class='opt_element'>
                                <p delete_item='' class='delete_item dp'>Delete item <i></i></p>
                                <p Update_item='' class='Update_item up' class='' data-information='"'>Update item <i></i>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="info_information event_menu_add"
                style="height:300px; width:500px; padding:10px;text-wrap:wrap;display:grid;place-items:center;">
                <header class="danger"></header>
            </div>

            <div class="records_table ">
                <?php
                echo '<table id="main_table">
                <thead>
                    <tr>
                        <th>Detail</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Record</th>
                        <th>Amount</th>
                        <th>...</th>
                    </tr>
                </thead>
                <tbody>';
                $data = json_decode($newDataRequest->BudgeCategoryList());
                if (is_object($data)) {
                    foreach ($data as $item) {
                        $category = $item->category;
                        $type = $item->type;
                        $details = $item->details;
                        $date = $item->date;
                        $year = $item->year;
                        $month = $item->month;
                        $amount = $item->amount;
                        $recorded_by = $item->recorded_by;
                        $unique_id = $item->id;
                        $ObjExport = $item->obj;

                        echo " <tr class='" . $category . "'>
                        <td title='" . $details . "'>
                            <p>hover to view details</p>
                        <td>
                            <p>" . $date . "</p>
                        </td>
                        <td>
                            <p>" . $type . "</p>
                        </td>
                        <td>
                            <p>" . $recorded_by . "</p>
                        </td>
                        </td>
                        <td>" . $amount . "</td>
                        <td class='delete option'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='30'
                                viewBox='0 -960 960 960' width='48'>
                                <path
                                    d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                            </svg>
                            <div class='opt_element'>
                                <p delete_item='" . $unique_id . "' class='delete_item'>Delete item <i></i></p>
                                <p Update_item='" . $unique_id . "' class='Update_item' class='' data-information='" . $item->obj . "'>Update item <i></i></p>
                            </div>
                        </td>
                    </tr>";
                    }
                } else {
                    echo '<header class="danger">Data is not available</header>';
                }
                echo '</tbody></table>';
                ?>

            </div>
        </div>

        <div class="page_sys">
            <?php
            if (isset($_SESSION['total_pages_expenses'])) {
                $total = $_SESSION['total_pages_expenses'];
            } else {
                $total = $newDataRequest->BudgeCategoryListpages();
                $_SESSION['total_pages_expenses'] = $total;
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
                            $num = 2;
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
                                echo '<div>' . $final . '</div>';
                            }
                            ?>
                        </div>
                    </header>
                    <?php
                    }
            }
            ?>
        </div>

    </div>
    </div>
    <?php
} else {
    header('Location:../error404/general404.html');
}
?>