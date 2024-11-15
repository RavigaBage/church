<?php
session_start();
require '../../../API/vendor/autoload.php';
include '../SvgPath.php';
$viewDataClass = new Library\viewData();
$val = 1;
$type = "";
$condition = false;
if (isset($_GET['type'])) {
    $type = $_GET['type'];
}
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}
if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];
    $token = $_SESSION['Admin_access'];
    $known = hash('sha256', $unique_id . 'admin');
    if ((hash_equals($known, $token))) {
        if (!isset($_SESSION['Library_Log'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $viewDataClass->DataHistory($unique_id, "Admin permit was used to logged in", $date, "Dashboard library", "Admin permit was used logged in to dashboard");
            $decode = json_decode($newquest);
            if ($decode == 'Success') {
                $_SESSION['Library_Log'] = true;
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
                        <h1>Children ministry</h1>
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
                            d="M666-440 440-666l226-226 226 226-226 226Zm-546-80v-320h320v320H120Zm400 400v-320h320v320H520Zm-400 0v-320h320v320H120Z" />
                    </svg>

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
                <p>You are export data from this database to this current device, if you wish to proceed click on the
                    save button
                </p>

                <button id="exportDataBtn">Save document</button>
            </div>
        </form>
    </div>
    <div class="CloneSearch" hidden>
        <table>
            <tr>
                <td>
                    <div class='details'>
                        <div class='Cloneimg'>
                            <img src='' alt='' />
                        </div>
                        <div class='text'>
                            <p class="Clonename"></p>
                            <p class="Clonedate"></p>
                        </div>

                    </div>
                </td>
                <td class='td_action'>
                    <p class="Clonecat"><a>File source link</a></p>
                </td>
                <td class='td_action'>
                    <p class="Clonesource"></p>
                </td>
                <td class='td_action'>
                    <p class="Cloneauthor"></p>
                </td>

                <td Class="Cloneitem" data-information=''>
                    <div class='btn_record'>
                        <div></div>Inactive
                    </div>
                </td>
                <td class='option'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960' width='48'>
                        <path
                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                    </svg>
                    <div class='opt_element' style="height: 130px;">
                        <p data-id="" delete_item="" class='delete_item dp'>Delete item <i></i></p>
                        <p class='Update_item up' data-id="" Update_item="" data-information=''>Update
                            item
                            <i></i>
                        </p>
                        <p class='add_item' data-id="">Add item<i></i>
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


    <div class="assets_page">

        <div class="event_menu_add main form_data">
            <form>
                <header>Library Records</header>
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
                    <div class="cate_view">
                        <div class="field">
                            <label>file name</label>
                            <input name="name" type="text" placeholder="" />
                        </div>
                        <div class="field">
                            <label>Author</label>
                            <input name="author" type="text" placeholder="" />
                        </div>
                    </div>
                    <div class="field">
                        <label>source</label>
                        <input name="source" type="text" placeholder="" />
                    </div>
                    <div class="field">
                        <label>Select file</label>
                        <div class="upload_blog">
                            <a id="browseButton" name="imageFile">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" />
                                    <path d="M9 15l3 -3l3 3" />
                                    <path d="M12 12l0 9" />
                                </svg>

                                <span>Select file to upload here</span>
                            </a>
                        </div>
                    </div>

                    <div class="field">
                        <label>category/genre</label>
                        <select name="category">
                            <option>Faith</option>
                            <option>Love</option>
                            <option>Grace</option>
                            <option>Hope</option>
                            <option>Forgiveness</option>
                            <option>Justice</option>
                            <option>Peace</option>
                            <option>Joy</option>
                            <option>Suffering</option>
                            <option>Salvation</option>
                            <option>Trinity</option>
                            <option>Atonement</option>
                            <option>Santification</option>
                            <option>Glorification</option>
                            <option>Adolescenes</option>
                            <option>Adulthood</option>
                            <option>Marriage</option>
                            <option>Singleness</option>
                            <option>Parenting</option>
                            <option>Grief</option>
                            <option>Sickness</option>
                            <option>Finance</option>
                            <option>Trinity</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>TAGs  i.e faith,repentence etc.</label>
                        <input name="tag"></input>
                    </div>
                </div>
                <div class="field">
                    <label>Date upload</label>
                    <input name="date" type="date" placeholder="" />
                </div>

                <div class="field">
                    <label>Status</label>
                    <select name="status">
                        <option value="Public">Select the status of this user</option>
                        <option>Active</option>
                        <option>Inconsistency</option>
                        <option>Other reasons</option>
                    </select>
                </div>
                <input name="delete_key" type="number" hidden />
                <button>Record Asset</button>
        </div>
        </form>
    </div>

    <div class="event_menu_add indi">
        <form>
            <header>Sub Records form</header>
            <p class="error_information" style="padding:10px;text-wrap:wrap;display:grid;place-items:center;"></p>
            <p>Add the recent payment information of this partner to update their profile</p>
            <div class="container_event">
                <div class="field">
                    <label>filename</label>
                    <input name="filename" type="text" placeholder="" />
                </div>
                <div class="field">
                    <label>source</label>
                    <input name="source" type="text" placeholder="" />
                </div>

                <input name="delete_key" type="number" hidden />
                <button>Add Record</button>
            </div>
        </form>
    </div>

    <div class="event_menu_add series_version">
        <header>Individual Partner Records</header>
        <div class="container_event">
            <div class="menu event">

            </div>
        </div>
    </div>


    <div class="add_event" data-menu="event">
        <i>+</i>
        <p>New</p>
    </div>
    <div class="content_pages">
        <div class="content_page_event">
            <div class="records_table">
                <?php
                if ($type == "") {
                    $data = $viewDataClass->viewList($val);
                } else {
                    $data = $viewDataClass->Library_filter($type);
                }

                if ($data != 'No Records available' && $data != "Fetching data encountered an error" && $data != 'Error Occurred') {
                    $data = json_decode($data);
                    echo '<table>
                        <thead>
                            <tr>
                                <th>FileName</th>
                                <th>Category</th>
                                <th>Source</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>...</th>
                            </tr>
                        </thead>

                        <tbody>';
                    foreach ($data as $item) {
                        $unique_id = $item->UniqueId;
                        $name = $item->name;
                        $Author = $item->Author;
                        $date = $item->date;
                        $source = $item->source;
                        $category = $item->category;
                        $status = $item->status;
                        $ObjectData = $item->Obj;
                        $cover = $item->cover;
                        $ObjectDataIndividual = $item->IObj;

                        if ($status == 'active') {
                            $item = "<div class='in_btn btn_record'>
                                    <div></div>Active
                                </div>";
                        } else {
                            $item = "<div class='out_btn btn_record'>
                                    <div></div>Inactive
                                </div>";
                        }


                        $path = '../../API/Images_folder/library/covers/' . $cover . '';
                        $svg = $svg_path;
                        if(!file_exists('../../../API/Images_folder/library/covers/' . $cover . '')){
                            $path_img = $svg;
                        }else{
                            $path_img = '<img src='.$path.' alt="image file" />';
                        }

                        echo "
                                    <tr>
                                            <td>
                                                <div class='details'>
                                                    
                                                <div class='img'>
                                                ".$path_img."
                                                </div>
                                                    <div class='text'>
                                                        <p>" . $name . "</p>
                                                        <p>" . $date . "</p>
                                                    </div>
                
                                                </div>
                                            </td>
                                            <td class='td_action'><p>" . $category . "</p></td>
                                            <td class='td_action'><a href=" . $source . " target='_blank'>File source link</a></td>
                                       <td class='td_action'><p>" . $Author . "</p></td>
                                            <td data-information='" . $ObjectDataIndividual . "'>" . $item . "</td>
                                            <td class='option'>
                                                <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960' width='48'>
                                                    <path
                                                        d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                                </svg>
                                                <div class='opt_element' style='height: 130px;'>
                                                <p data-id=" . $unique_id . " delete_item=" . $unique_id . " class='delete_item'>Delete item <i></i></p>
                                                <p class='Update_item' Update_item=" . $unique_id . " data-id=" . $unique_id . " data-information='" . $ObjectData . "'>Update item <i></i></p>
                                                <p data-id=" . $unique_id . " class='add_item'>Add data<i></i></p>
                                                </div>
                                            </td>
                                    </tr>";
                    }
                    echo '</tbody></table>';
                } else {
                    echo '<header class="danger"><h1>No Records Available</h1></header>';
                }
                ?>

            </div>
        </div>
    </div>
    <div class="page_sys">
        <?php
        if (isset($_SESSION['total_pages_partner'])) {
            $total = $_SESSION['total_pages_partner'];
        } else {
            $total = $viewDataClass->partner_pages();
            $_SESSION['total_pages_partner'] = $total;
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

    </div>
    <?php
} else {
    header('Location:../error404/general404.html');
}
?>