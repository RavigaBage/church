<?php
include_once('../../API/finance/autoloader.php');
$newDataRequest = new viewData();
session_start();
if (isset($_GET['page'])) {
    $num = $_GET['page'];
    echo "fresh" . $num;
} else {
    $num = 1;
}
?>

<div class="filter_wrapper relative">
    <div style="height:40px;width:100%" class="flex">
        <div class="direction flex">
            <p>Dashboard</p>
            <span> - </span>
            <p>membership</p>
            <span> - </span>
            <p>filter(20years)</p>
        </div>
        <div class="options flex opt_left">

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

<div class="export_dialogue">
    <form>
        <header>Exporting Data</header>
        <div class="loader">All fields required</div>
        <div class="container_event">
            <p>You are export data from this database to this current device, if you wish to proceed click on the
                save button
            </p>

            <button id="exportDataBtn">Save document</button>
        </div>
    </form>
</div>


<div class="content_pages">
    <div class="content_page_event">

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
                        <option>ABSA BANK</option>
                        <option value="FBNBank">FBN BANK</option>
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

            <table>
                <?php
                $data = $newDataRequest->TransactionList($num);
                if ($data == "" || $data == 'Error Occurred' || $data == 'Not Records Available') {
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

<div class="event_menu_add">
    <form>
        <header>New Activity</header>
        <h1 class="loader"></h1>
        <div class="container_event">
            <div class="field">
                <label>Account</label>
                <select class="form_condition" name="account">
                    <?php
                    $data = $newDataRequest->Accounts_list_view();
                    echo ($data);
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
                    <option>select category</option>
                    <option value="expenses">Expenses</option>
                    <option value="income">Income</option>
                </select>
            </div>

            <div class="field">
                <label>Amount</label>
                <input class="form_condition" name="amount" required />
            </div>
            <div class="field">
                <label>Activity Date</label>
                <input type="date" class="form_condition" name="date">
            </div>
            <input name="delete_key" hidden />
            <button>create Activity</button>
        </div>
    </form>
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

            <!-- #fix pages for here -->
            <?php
            $total = ($total - 1);
            $total = ceil($total / 40);
            if ($total > 1) {
                echo 'Pages:';
                ?>


                <div class="pages">
                    <?php
                    $loop = 6;

                    $start = $num;
                    if ($total > 1) {
                        if (intval($num) >= 6) {
                            if ($total - 6 > $num) {
                                if (intval($num) <= intval($total)) {
                                    $loop = 6 + 6 * round($num / 6);
                                    $start = 6 * round($num / 6);
                                }
                            } else {
                                $loop = $total;
                                $start = $loop - 6;
                            }
                        }
                    }
                    for ($i = $start; $i < $loop; $i++) {
                        $class = "";

                        if (($i + 1) == $num) {
                            $class = 'active';
                        }
                        if ($num < $total) {
                            echo '<div class="' . $class . '">' . ($i + 1) . '</div>';
                        } else {
                            echo '<div class="' . $class . '">' . $i . '</div>';
                        }
                    }

                    if ($loop >= 6 && $num <= ($total - 11)) {
                        echo '<span>......</span><div>' . round($total) . '</div>';
                    } else {
                        echo '<div>' . $total . '</div>';
                    }
                    ?>
                </div>
            </header>
            <?php
            }
    }
    ?>
</div>