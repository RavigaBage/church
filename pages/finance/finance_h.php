<?php
session_start();
include_once('../../API/finance/autoloader.php');
$newDataRequest = new viewData();
$val = 1;
$valO = 1;
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}

if (isset($_GET['pageO'])) {
    $valO = $_GET['pageO'];
}

$condition = false;
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
                <p>membership</p>
                <span> - </span>
                <p>filter(20years)</p>
            </div>
            <div class="options flex opt_left">
                <div class="Filter item_opt flex filterBtn">
                    <i class="fas fa-filter"></i>
                    <p>Filter</p>
                </div>
                <div class="notification_list_filter">
                    <div class="item" data-filter='modified'>
                        <h1>Modified</h1>
                    </div>

                    <div class="item" data-filter='Ascending'>
                        <h1>Ascending</h1>
                    </div>

                    <div class="item" data-filter='Descending'>
                        <h1>Descending</h1>
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
                <div class="item_opt flex" id="print_page" onclick="window.print()">
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
                <div class="field">
                    <label>Select Option</label>
                    <select required name="data_type">
                        <option value="1">Export Data displayed on this page</option>
                        <option value="2">Export All Data in database relating to this page</option>
                    </select>
                </div>
                <div class="cate_view">
                    <div class="field">
                        <label>Export Name</label>
                        <input required type="text" class="form_condtion" name="export_name"
                            placeholder="specify the a name to export this data with" />
                    </div>
                    <div class="field">
                        <label>Export type</label>
                        <select required name="export_type">
                            <option value="word">MsWord(.docx)</option>
                            <!-- <option value="pdf">Pdf file(.pdf)</option>
                        <option value="excel">Excel file(.xlsx)</option> -->
                        </select>
                    </div>
                </div>
                <button id="exportDataBtn">Save document</button>
            </div>
        </form>
    </div>

    <div class="event_menu_add">
        <form>
            <header>New Activity</header>
            <div class="loader">.....loading data please wait</div>
            <div class="container_event">
                <div class="field">
                    <label>Event name</label>
                    <input type="text" class="form_condtion" name="event"
                        placeholder="specify a name eg:sunday / tarry night / missionary night" />
                </div>
                <div class="cate_view">
                    <div class="field">
                        <label>Amount</label>
                        <input type="number" class="form_condtion" name="amount"
                            placeholder="specify the amount collected without any symbols eg $" />
                    </div>
                    <div class="field">
                        <label>Activity date</label>
                        <input type="date" class="form_condtion" name="Date" placeholder="" />
                    </div>
                </div>
                <div class="field_e">
                    <label>Activity description</label>
                    <textarea class="form_condtion" name="description"></textarea>
                </div>
                <input hidden class="form_condtion" name="delete_key" value="000" />
                <button>create Activity</button>
            </div>
        </form>
    </div>
    <div class="event_menu_add main">
        <form>
            <header>New Activity</header>
            <div class="loader">.....loading data please wait</div>
            <div class="container_event">
                <div class="cate_view">
                    <div class="field">
                        <label>Name</label>
                        <input type="text" class="form_condition" name="event" placeholder="please add a name..." />
                    </div>
                    <div class="field">
                        <label>category</label>
                        <select class="form_condition" name="category">
                            <option>Select category</option>
                            <option>All users</option>
                            <option>presbytery</option>
                            <option>Department</option>
                        </select>
                    </div>
                </div>
                <div class="cate_view">
                    <div class="field">
                        <label>Amount</label>
                        <input type="text" class="form_condition" name="amount" placeholder="" />
                    </div>
                    <div class="field">
                        <label>Activity due date</label>
                        <input type="date" class="form_condition" name="date" placeholder="" />
                    </div>
                </div>
                <div class="field_e">
                    <label>Activity description</label>
                    <textarea class="form_condition" name="description"></textarea>
                </div>
                <input hidden class="form_condition" name="delete_key" value="000" />
                <button>create Activity</button>
            </div>
        </form>
    </div>

    <div class="add_event" data-menu="event">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
            <path
                d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
        </svg>
        <p>New</p>
    </div>


    <div class="slider_menu_main">
        <div class="slider_menu">
            <div class="menu event active">
                <header class="title">Contribution & Dues tracker</header>
                <input type="hidden" id="OrigDues" value='
            <?php
            $dataRequestR = $newDataRequest->ListDataDues($val);
            print_r($dataRequestR);
            $dataRequest = json_decode($dataRequestR);
            ?>' />
                <div hidden class="cloneSearch">
                    <div class='item'>
                        <div class='file'>
                            <img src='../images/cfile.png' alt='' />
                        </div>
                        <div class='details'>
                            <a href='' class='flex'>
                                <p class='item_name' data_item=" . $date_data . "></p>
                                <p class="item_modified"></p>
                            </a>
                        </div>
                        <div class='delete option'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960' width='30'>
                                <path
                                    d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                            </svg>
                            <div class='opt_element'>
                                <p class="up" Update_item='' data-information=''>Update item <i></i></p>
                                <p class="dp" delete_item=''>Delete item <i></i></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container_item">
                    <?php
                    if ($dataRequest == "Fetching data encounted a problem") {
                        echo "<header class='danger'>Error Occurred</header>";
                    } else if ($dataRequest != "Not Records Available") {
                        foreach ($dataRequest as $item) {
                            $amount = $item->amount;
                            $name = $item->name;
                            $date = $item->date;
                            $date_data = $item->date_data;
                            $purpose = $item->purpose;
                            $department = $item->department;
                            $id = $item->UniqueId;
                            $ObjectData = $item->Obj;
                            echo
                                " <div class='item'>
                            <div class='file'>
                            <img src='../images/cfile.png' alt='' />
                            </div>
                            <div class='details'>
                            <a href='finance/finance_event.php?data_page=$id&&amount=$amount' target='_blank' class='flex'>
                                <p class='item_name' data_item=" . $date_data . ">" . $name . "  - Total " . $amount . "</p>
                                <p>last modified . " . $date_data . "</p>
                            </a>
                            </div>
                            <div class='delete option'>
                                <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                                    width='30'>
                                    <path
                                        d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                </svg>
                                <div class='opt_element'>
                                    <p Update_item='" . $id . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                                    <p delete_item='" . $id . "'>Delete item <i></i></p>
                                </div>
                            </div>
                          </div>
                        ";
                        }
                    } else {
                        echo "<header class='danger'>Not Records Available</header>";
                    }
                    ?>
                    <div class="page_sys">
                        <?php
                        $total = $newDataRequest->DuesPages();
                        ?>
                        <header>
                            <?php

                            if ((round($total / 6)) > 1) {
                                echo 'Pages:';
                            }
                            ?>
                            <div class="pages">
                                <?php

                                $loop = 0;
                                if ((round($total / 6)) > 1) {
                                    if ($total > 6) {
                                        $loop = 6;
                                    } else {
                                        $loop = ($total / 6);
                                    }
                                    for ($i = 0; $i < $loop; $i++) {
                                        $class = "";
                                        if ($i == $val - 1) {
                                            $class = 'active';
                                        }
                                        echo '<div class="' . $class . '">' . ($i + 1) . '</div>';
                                    }
                                    if ($loop == 6) {
                                        echo '<span>......</span><div>' . ($total / 6) . '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </header>
                    </div>

                </div>
            </div>

            <div class="menu account">
                <div class="off_filter flex">
                    <select class="select" name="yearfilter">
                        <option>2024</option>
                        <option>2022</option>
                        <option>2023</option>
                    </select>
                    <button class="List_filter">Filter</button>
                </div>

                <header class="title">Offertory tracker</header>
                <input type="hidden" id="OrigOffertory" value="
            <?php
            $dataRequestR = $newDataRequest->ListData($valO);
            print_r($dataRequestR);
            $dataRequest = json_decode($dataRequestR);
            ?>" />
                <div hidden class="cloneSearch">
                    <div class='item'>
                        <div class='file'>
                            <img src='../images/cfile.png' alt='' />
                        </div>
                        <div class='details'>
                            <a href='' class='flex'>
                                <p class='item_name' data_item=" . $date_data . "></p>
                                <p class="item_modified"></p>
                            </a>
                        </div>
                        <div class='delete option'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960' width='30'>
                                <path
                                    d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                            </svg>
                            <div class='opt_element'>
                                <p class="up" Update_item='' data-information=''>Update item <i></i></p>
                                <p class="dp" delete_item=''>Delete item <i></i></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container_item">
                    <?php
                    $month = 0;
                    if ($dataRequest == "Fetching data encounted a problem") {
                        echo "<header class='danger'>Error Occurred</header>";
                    } else if ($dataRequest != "Not Records Available") {
                        foreach ($dataRequest as $item) {
                            $name = $item->name;
                            $amount = $item->amount;
                            $date = $item->date;
                            $purpose = $item->purpose;
                            $id = $item->id;
                            $Month = $item->Month;
                            $ObjectData = $item->obj;
                            if ($month != intval($Month)) {
                                echo
                                    "<div class='itemlist calender'>
                            <img src='../images/calender/" . $Month . ".jpg' alt='calender year " . $Month . "' />
                            </div>";
                                $month = $Month;
                            }
                            echo "
                        <div class='item'>
                        <div class='file'>
                        <img src='../images/cfile.png' alt='' />
                        </div>
                        <div class='details'>
                            <p class='item_name' data_item=" . $date . ">" . $name . "  - Total " . $amount . "</p>
                            <p>last modified . " . $date . "</p>
                            
                        </div>
                        <div class='delete option'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                                width='30'>
                                <path
                                    d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                            </svg>
                            <div class='opt_element'>
                                <p Update_item='" . $id . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                                <p delete_item='" . $id . "'>Delete item <i></i></p>
                            </div>
                        </div>
                    </div>
                   ";
                        }
                    } else {
                        echo "<header class='danger'>Not Records Available</header>";
                    }
                    ?>
                    <div class="page_sys">
                        <?php
                        $total = $newDataRequest->DuesPages();
                        ?>
                        <header>
                            <?php

                            if ((round($total / 6)) > 1) {
                                echo 'Pages:';
                            }
                            ?>
                            <div class="pages">
                                <?php

                                $loop = 0;
                                if ((round($total / 6)) > 1) {
                                    if ($total > 6) {
                                        $loop = 6;
                                    } else {
                                        $loop = ($total / 6);
                                    }
                                    for ($i = 0; $i < $loop; $i++) {
                                        $class = "";
                                        if ($i == $val - 1) {
                                            $class = 'active';
                                        }
                                        echo '<div class="' . $class . '">' . ($i + 1) . '</div>';
                                    }
                                    if ($loop == 6) {
                                        echo '<span>......</span><div>' . ($total / 6) . '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </header>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

} else {
    echo "<header>Sorry, you are currently disconnected from the admin privilege, please contact your administrator</header>";
}
?>