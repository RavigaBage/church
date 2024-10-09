<?php
session_start();
require '../../../API/vendor/autoload.php';
$newDataRequest = new Finance\viewData();
$year = date('Y');
if (isset($_GET['year'])) {
    $year = $_GET['year'];
}
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
        if (!isset($_SESSION['Tithe_Log'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $newDataRequest->DataHistory($unique_id, "Admin permit was used to logged in", $date, "Dashboard Tithe", "Admin permit was used logged in to dashboard");
            $decode = json_decode($newquest);
            if ($decode == 'Success') {
                $_SESSION['Tithe_Log'] = true;
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
            <div class="add_event">
                <i>+</i>
                <p>New</p>
            </div>
            <div class="CloneSearch" hidden>
                <table>
                    <tr>
                        <td>
                            <div class='details'>
                                <div class='text'>
                                    <p class="Cloneemail"></p>
                                    <p class="Clonedate"></p>
                                </div>

                            </div>
                        </td>

                        <td>
                            <p class="Clonegender"></p>
                        </td>
                        <td class="Clonecontact"></td>
                        <td class="Cloneamount"></td>

                        <td class="Clonemedium"></td>
                        <td class='delete option'>

                            <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960' width='30'>
                                <path
                                    d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                            </svg>
                            <div class='opt_element'>
                                <p class="up" Update_item='' data-information=''>Update
                                    item
                                    <i></i>
                                </p>
                                <p class="dp" delete_item=''>Delete item <i></i></p>
                            </div>
                        </td>

                    </tr>
                </table>
            </div>

            <div class="records_table">
                <table>

                    <?php
                    $data = json_decode($newDataRequest->TitheData($num, $year));

                    if ($data == "" || $data == 'Error Occurred' || $data == 'Not Records Available') {
                        echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                    } else {
                        echo "<thead>
                    <tr>
                        <th>user-name</th>
                        <th>gender</th>
                        <th>contact</th>
                        <th>Amount ($)</th>
                        <th>Payment</th>
                        <th>...</th>
                    </tr>
                </thead><tbody>";
                        foreach ($data as $item) {

                            $namer = $item->Name;
                            $amount = $item->Amount;
                            $Date = $item->Date;
                            $namer = $item->id;
                            $medium = $item->medium;
                            $detais = $item->details;
                            $gender = $item->gender;
                            $contact = $item->contact;
                            $Email = $item->Email;
                            $ObjectData = $item->Obj;

                            echo "
                        <tr>
                        <td>
                            <div class='details'>
                                <div class='text'>
                                    <p>" . $Email . "</p>
                                    <p>" . $Date . "</p>
                                </div>

                            </div>
                        </td>

                        <td>
                            <p>" . $gender . "</p>
                        </td>
                        <td>" . $contact . "</td>
                        <td>" . $amount . "</td>

                        <td>" . $medium . "</td>
                        <td class='delete option'>
                         
                    <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                        width='30'>
                        <path
                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                    </svg>
                    <div class='opt_element'>
                        <p Update_item='" . $namer . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                        <p delete_item='" . $namer . "'>Delete item <i></i></p>
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
    <div class="info_information event_menu_add"
        style="height:300px; width:500px; padding:10px;text-wrap:wrap;display:grid;place-items:center;">
        <header class="danger"></header>
    </div>

    <div class="event_menu_add form_data">
        <form>
            <header>New Activity</header>
            <div class="loader"></div>
            <div class="container_event">
                <div class="field">
                    <label>User - name</label>
                    <select class="form_condition" name="Name">
                        <?php
                        $data = $newDataRequest->Records_usernames();
                        if ($data != "" || $data != 'Error Occurred' || $data != 'No Records Available') {
                            foreach ($data as $value) {
                                $name = $value->name;
                                $id = $value->id;

                                echo "<option value=" . $id . ">" . $name . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="field">
                    <label>Activity Amount</label>
                    <input class="form_condition" name="amount" type="number" placeholder="" />
                </div>
                <div class="field">
                    <label>Activity Date</label>
                    <input class="form_condition" name="Date" type="date" placeholder="" />
                </div>

                <div class="field_e">
                    <label>Details</label>
                    <textarea name="details"></textarea>
                </div>

                <div class="field">
                    <label>Medium of payment</label>
                    <input class="form_condition" name="medium" type="input" placeholder="" />
                </div>
                <button>create Activity</button>
                <input hidden name="delete_key" />
            </div>
        </form>
    </div>

    <div class="page_sys">
        <?php
        if (isset($_SESSION['total_pages_tithe'])) {
            $total = $_SESSION['total_pages_tithe'];
        } else {
            $total = $newDataRequest->TithePages();
            $_SESSION['total_pages_tithe'] = $total;
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
    <?php

} else {
    header('Location:../error404/general404.html');
}
?>