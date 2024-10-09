<?php
session_start();
require '../../../API/vendor/autoload.php';
$newDataRequest = new AssetProject\viewData();
$val = 1;
$year = "";
if (isset($_GET['year'])) {
    $year = $_GET['year'];
}
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}

if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];
    $token = $_SESSION['Admin_access'];
    $known = hash('sha256', $unique_id . 'admin');
    if ((hash_equals($known, $token))) {
        if (!isset($_SESSION['projectLog'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $newDataRequest->DataHistory($unique_id, "Admin permit was used to logged in", $date, "Dashboard Projects", "Admin permit was used logged in to dashboard");
            $decode = json_decode($newquest);
            if ($decode == 'Success') {
                $_SESSION['projectLog'] = true;
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
    <div class="info_information event_menu_add"
        style="height:300px; width:500px; padding:10px;text-wrap:wrap;display:grid;place-items:center;">
        <header class="danger"></header>
    </div>
    <div class="CloneSearch" hidden>
        <table>
            <tr>
                <td>
                    <div class='details'>
                        <div class='img'>
                            <img class="Cloneimage" src='' alt='' />
                        </div>
                        <div class='text'>
                            <p class="Clonename"></p>
                            <p class="Clonestart"></p>
                        </div>

                    </div>
                </td>
                <td class='td_action Clonecurrent'></td>
                <td class='td_action Clonedescription'></td>
                <td class='td_action Cloneend'></td>
                <td class="response_btn">
                    <div class=' in_btn blue'>
                        <div></div>In progress
                    </div>
                </td>
                <td class='option'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960' width='48'>
                        <path
                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                    </svg>
                    <div class='opt_element'>
                        <p data-id='' class='delete_item dp'>Delete item <i></i></p>
                        <p class='Update_item up' data-id='' data-information=''>Update item
                            <i></i>
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="assets_page">
        <div class="content_pages">
            <div class="content_page_event">
                <div class="records_table">
                    <table>
                        <thead>
                            <tr>
                                <th>item name</th>
                                <th>Current</th>
                                <th>Description</th>
                                <th>End-date</th>
                                <th>Status</th>
                                <th>...</th>
                            </tr>
                        </thead>


                        <tbody>
                            <tr>
                                <td>
                                    <div class="details">
                                        <div class="img">
                                            <img src="../images/blog-3.jpg" alt="" />
                                        </div>
                                        <div class="text">
                                            <p>Camiel@gmail.com</p>
                                            <p>20/03/2024</p>
                                        </div>

                                    </div>
                                </td>
                                <td class="td_action">23</td>
                                <td class="td_action">Female</td>
                                <td class="td_action">Cote d'voire</td>

                                <td>
                                    <div class="in_btn">
                                        <div></div>Active
                                    </div>
                                </td>
                                <td class="option">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48">
                                        <path
                                            d="M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z" />
                                    </svg>
                                    <div class="opt_element">
                                        <p class="delete_item">Delete item <i></i></p>
                                        <p class="Update_item"
                                            data-information='{"id":2,"name":"tarry sunday","target":"122","current":"Aug,12,2023","description":"more","date":"","status":""}'>
                                            Update item <i></i></p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="details">
                                        <div class="img">
                                            <img src="../images/blog-3.jpg" alt="" />
                                        </div>
                                        <div class="text">
                                            <p>Camiel@gmail.com</p>
                                            <p>20/03/2024</p>
                                        </div>

                                    </div>
                                </td>
                                <td class="td_action">23</td>
                                <td class="td_action">Female</td>
                                <td class="td_action">Cote d'voire</td>

                                <td>
                                    <div class="out_btn">
                                        <div></div>Active
                                    </div>
                                </td>
                                <td class="option">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48">
                                        <path
                                            d="M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z" />
                                    </svg>
                                    <div class="opt_element">
                                        <p class="delete_item">Delete item <i></i></p>
                                        <p class="update_item">Update item <i></i></p>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $data = "";
                            if ($year == "") {
                                $data = json_decode($newDataRequest->Project_viewList($val));
                            } else {
                                $data = json_decode($newDataRequest->Project_viewListFilter($year));
                            }
                            foreach ($data as $item) {
                                $id = $item->id;
                                $name = $item->name;
                                $Start = $item->Start;
                                $End_date = $item->End_date;
                                $description = $item->description;
                                $Status = $item->Status;
                                $Image = $item->Image;
                                $target = $item->target;
                                $current = $item->current;
                                $ObjectData = $item->Obj;

                                if (strlen($description > 72)) {
                                    $description = str_split($description, 72)[0] + "....";
                                }

                                if ($Status == 'in progress') {
                                    $Status = "<div class='in_btn blue'><div></div>In progress</div>";
                                } else if ($Status == 'complete') {
                                    $Status = "<div class='in_btn'><div></div>Completed</div>";
                                } else {
                                    $Status = "<div class='out_btn blue'><div></div>hold</div>";
                                }

                                echo " <tr>
                                       <td><div class='details'>
                                    <div class='img'>
                                    <img src='../../API/Images_folder/projects/" . $Image . "' alt='' />
                                    </div>
                                    <div class='text'>
                                    <p>" . $name . "</p>
                                    <p>" . $Start . "</p>
                                    </div>
                                    
                                    </div>
                                    </td>
                                        <td class='td_action'>" . $current . " / " . $target . "</td>
                                        <td class='td_action'>" . $description . "</td>
                                        <td class='td_action'>" . $End_date . "</td>                                
                                        <td>" . $Status . "</td>
                                        <td class='option'>
                                            <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960' width='48'>
                                                <path
                                                    d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                            </svg>
                                            <div class='opt_element'>
                                                <p data-id='" . $id . "' class='delete_item'>Delete item <i></i></p>
                                                <p class='Update_item' data-id='" . $id . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                                            </div>
                                        </td>
                                    </tr>";
                            }

                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="event_menu_add form_data">
        <form>
            <header>Project form</header>
            <p style="color:crimson;font-size:18px;text-align:center" class="error_information"></p>
            <div class="container_event">
                <div class="cate_view">
                    <div class="field">
                        <label>Project name</label>
                        <input name="name" type="text" placeholder="" />
                    </div>
                    <div class="field">
                        <label>Image</label>
                        <input name="imageFile" type="file" />
                    </div>
                </div>
                <div class="cate_view_e">
                    <div class="field">
                        <label>Target</label>
                        <input name="target" type="number" placeholder="" />
                    </div>
                    <div class="field">
                        <label>Current</label>
                        <input name="current" type="number" placeholder="" />
                    </div>
                    <div class="field">
                        <label>Date</label>
                        <input name="date" type="date" placeholder="" />
                    </div>
                </div>
                <div class="cate_view">
                    <div class="field">
                        <label>Team</label>
                        <input name="team" type="text" placeholder="" />
                    </div>
                    <div class="field">
                        <label>Status</label>
                        <select name="status">
                            <option value="Public">Select the status of this user</option>
                            <option>in progress</option>
                            <option>completed</option>
                            <option>inactive</option>
                        </select>
                    </div>
                </div>
                <div class="field_e">
                    <label>description</label>
                    <textarea name="description"></textarea>
                </div>
                <input name="delete_key" value="" hidden />
                <button>Record Asset</button>
            </div>
        </form>
    </div>

    <div class="add_event " data-menu="event">
        <i>+</i>
        <p>New</p>
    </div>;
    <div class="page_sys">
        <?php
        if (isset($_SESSION['total_pages_projects'])) {
            $total = $_SESSION['total_pages_projects'];
        } else {
            $total = $newDataRequest->ProjectsPages();
            $_SESSION['total_pages_projects'] = $total;
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