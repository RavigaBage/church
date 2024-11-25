<?php
session_start();
require '../../../API/vendor/autoload.php';
$viewDataClass = new Ministry\viewData();
$val = 1;
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}
if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];
    $token = $_SESSION['Admin_access'];
    $known = hash('sha256', $unique_id . 'admin');
    if ((hash_equals($known, $token))) {
        if (!isset($_SESSION['DepartmentLog'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $viewDataClass->DataHistory($unique_id, "Admin permit was used to logged in", $date, "Dashboard department", "Admin permit was used logged in to dashboard");
            $decode = json_decode($newquest);
            if ($decode == 'Success') {
                $_SESSION['DepartmentLog'] = true;
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
    <div class="info_information event_menu_add"
        style="height:300px; width:500px; padding:10px;text-wrap:wrap;display:grid;place-items:center;">
        <header class="danger"></header>
    </div>

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
                        <h1>modified</h1>
                    </div>
                    <div class="item">
                        <h1>Ascending</h1>
                    </div>
                    <div class="item">
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
                <div class="item_opt flex">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#5f6368">
                        <path
                            d="M640-640v-120H320v120h-80v-200h480v200h-80Zm-480 80h640-640Zm560 100q17 0 28.5-11.5T760-500q0-17-11.5-28.5T720-540q-17 0-28.5 11.5T680-500q0 17 11.5 28.5T720-460Zm-80 260v-160H320v160h320Zm80 80H240v-160H80v-240q0-51 35-85.5t85-34.5h560q51 0 85.5 34.5T880-520v240H720v160Zm80-240v-160q0-17-11.5-28.5T760-560H200q-17 0-28.5 11.5T160-520v160h80v-80h480v80h80Z" />
                    </svg>
                    <p>Print</p>
                </div>
            </div>
        </div>
    </div>


    <div class="menu event">
        <?php
        $data = json_decode($viewDataClass->viewList());
        if ($data != 'Error occured' || $data != 'Fetching data encountered a problem' || $data != "") {


            foreach ($data as $item) {
                $unique_id = $item->UniqueId;
                $name = $item->name;
                $members = $item->members;
                $message = $item->about;
                $date = $item->date;
                $manager = $item->manager;
                $status = $item->status;
                $ObjectData = $item->Obj;
                echo "
        <div class='item' data-id='" . $unique_id . "' data-name='" . $name . "'>
        <div class='details' style='width:calc(100% - 30px)'>
            <p>" . $name . " <span style='margin-left:10px;width:fit-content;text-align:center;font-size:13px;'>" . $message . "</span> </p>
            <p>You edited . " . $date . "</p>
        </div>
        <div class='delete option'>
        <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960' width='30'>
            <path
                d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
        </svg>
        <div class='opt_element'>
        <p data-id=" . $unique_id . " class='delete_item'>Delete item <i></i></p>
        <p class='Update_item' data-id=" . $unique_id . " data-information='" . $ObjectData . "'>Update item <i></i></p>
    </div>
    </div>
    </div>";
            }
        } else {
            echo '<header>We cannot find any data available</header>';
        }
        ?>
    </div>

    <div class="ministry_data">
        <header>Ministry Data</header>
        <p class="error_information" style="color:crimson;text-align:center;"></p>
        <div class="container_event" style="width:100%;height:calc(100% - 120px);overflow:auto;">
            <div class="members">
                <table></table>
            </div>
            <header>Select new member</header>
            <div class="new_members">
                <?php
                $data = $viewDataClass->DepartmentMembersView();
                if ($data != 'Error occured' || $data != 'Fetching data encountered a problem' || $data != "") {
                    $data_v = json_decode($data);
                    echo '<table>
                        <thead>
                        <tr>
                        <th></th>
                        <th>Firstname</th>
                        <th>Othername</th>
                        </tr>
                        <thead>
                        <tbody>';
                    foreach ($data_v as $value) {
                        $firstname = $value->Fname;
                        $Othername = $value->Oname;
                        $id = $value->UniqueId;
                        echo '<tr>
                           <td><input type="checkbox" value="' . $id . '" /></td>
                           <td>' . $firstname . '</td>
                            <td>' . $Othername . '</td>
                           </tr>';
                    }
                    echo '</tbody></table>';
                }
                ?>
            </div>
        </div>

        <div class="dp_buttons">
            <button class="remove_new">Remove</button>
            <button class="add_new">Add Record</button>
        </div>

    </div>
    <div class="event_menu_add form_data">
        <form>
            <header>Records book for ministries</header>
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
            <div class="field">
                <label>Name</label>
                <input name="name" required placeholder="Add name" />
            </div>
            <div class="cate_view">
                <div class="field">
                    <label>manager</label>
                    <input name="manager" required type="text" value="">
                </div>
                <div class="field">
                    <label>total participants</label>
                    <input name="members" required type="text" value="">
                </div>
            </div>
            <div class="field">
                <label>status</label>
                <select name="status" required>
                    <option>select</option>
                    <option>active</option>
                    <option>inactive</option>
                    <option>in progress</option>
                </select>
            </div>

            <div class="field">
                <label>record date</label>
                <input name="date" type="date" required value="">
            </div>

            <div class="field_e">
                <label>record description</label>
                <textarea name="about" required></textarea>
            </div>
            <input name="delete_key" type="text" hidden />
            <button>Add record</button>
    </div>
    </form>
    </div>

    <div class="add_event" data-menu="event">
        <i>+</i>
        <p>New</p>
    </div>


    <?php
} else {
    header('Location:../error404/general404.html');
}
?>