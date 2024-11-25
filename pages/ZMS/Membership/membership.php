<?php
session_start();
require '../../../API/vendor/autoload.php';
include '../SvgPath.php';
$viewDataClass = new Membership\viewData();
$num = 1;
if (isset($_GET['page'])) {
    $num = $_GET['page'];
}
if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];
    $token = $_SESSION['Admin_access'];
    $known = hash('sha256', $unique_id . 'admin');
    if ((hash_equals($known, $token))) {
        if (!isset($_SESSION['Membership_Log'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $viewDataClass->DataHistory($unique_id, "Admin permit was used to logged in", $date, "Dashboard membership", "Admin permit was used logged in to dashboard");
            $decode = json_decode($newquest);
            if ($decode == 'Success') {
                $_SESSION['Membership_Log'] = true;
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

    <div class="CloneSearch" hidden>
        <table>
            <tr>
                <td>
                    <div class='details'>
                        <div class='img'>
                            <img class="Cloneimage" src='../API/Images_folder/users/' alt='' />
                        </div>
                        <div class='text'>
                            <p class="Clonemeail"></p>
                            <p class="Clonename"></p>
                        </div>

                    </div>
                </td>
                <td class='td_action'>
                    <div class='table_center'>
                        <p class="Cloneage"></p>
                    </div>
                </td>
                <td class='td_action'>
                    <div class='table_center'>
                        <p class="Clonegender"></p>
                    </div>
                </td>
                <td class='td_action'>
                    <div class='table_center'>
                        <p class="Cloneaddress"></p>
                    </div>
                </td>
                <td class='td_action'>
                    <div class='table_center'>
                        <p class="Clonebaptism"></p>
                    </div>
                </td>
                <td class='td_action'>
                    <div class='table_center'>
                        <p class="Cloneoccupation"></p>
                    </div>
                </td>

                <td>
                    <div class='table_center'>
                        <p class="Clonestatus">
                        <div class="RecordBtn in_btn">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="green">
                                <path
                                    d="M200-120v-680h360l16 80h224v400H520l-16-80H280v280h-80Zm300-440Zm86 160h134v-240H510l-16-80H280v240h290l16 80Z" />
                            </svg>
                            active
                        </div>
                        </p>
                    </div>
                </td>

                <td class='option' style='width:100%;display:grid;place-items:center;'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960' width='48'>
                        <path
                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                    </svg>
                    <div class='opt_element'>
                        <p data-id=" . $unique_id . " class='delete_item dp'>Delete item <i></i></p>
                        <p class='Update_item up' data-id=" . $unique_id . " data-information='" . $ObjectData . "'>Update
                            item
                            <i></i>
                        </p>
                    </div>
                </td>
            </tr>
        </table>
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
            <div class="membership_table">
                <table>
                    <?php
                    $data = json_decode($viewDataClass->viewList($num));
                    if ($data == "" || $data == 'Error Occurred' || $data == 'Not Records Available') {
                        echo "<header class='danger'><header><b>Not Records Available</b></header>";
                    } else {
                        echo '
                    <thead>
                        <tr>
                            <th>username</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Location</th>
                            <th>Baptism</th>
                            <th>Occupation</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach ($data as $item) {
                            $item = json_decode($item);

                            $unique_id = $item->UniqueId;
                            $Firstname = $item->Oname;
                            $Othername = $item->Fname;
                            $Age = $item->birth;
                            $Position = $item->Position;
                            $contact = $item->contact;
                            $email = $item->email;
                            $image = $item->image;
                            $Address = $item->location;
                            $Baptism = $item->Baptism;
                            $membership_start = $item->membership_start;
                            $username = $item->username;
                            $gender = $item->gender;
                            $occupation = $item->occupation;
                            $About = $item->About;
                            $ObjectData = $item->Obj;
                            $status = $item->status;

                            if ($status == 'active' || $status == 'Active') {
                                $status = '<div class="in_btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="green"><path d="M200-120v-680h360l16 80h224v400H520l-16-80H280v280h-80Zm300-440Zm86 160h134v-240H510l-16-80H280v240h290l16 80Z"/></svg>
                    active</div>';
                            } else {
                                $status = '<div class="out_btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="red"><path d="M200-120v-680h360l16 80h224v400H520l-16-80H280v280h-80Zm300-440Zm86 160h134v-240H510l-16-80H280v240h290l16 80Z"/></svg>
                    Inactive</div>';
                            }
                            $path = '../../API/Images_folder/users/' . $image. '';
                            $svg = $svg_path;
                            if(empty($image) || !file_exists('../../../API/Images_folder/users/' . $image. '')){
                                $path_img = $svg;
                            }else{
                                $path_img = '<img src='.$path.' alt="image file" />';
                            }

                            echo
                                "<tr>
                <td><div class='details'>
<div class='img'>
".$path_img."
</div>
<div class='text'>
<p>" . $email . "</p>
<p>" . $Firstname . "  " . $Othername . "</p>
</div>

</div></td>
                <td class='td_action'><div class='table_center'><p>" . $Age . "</p></div></td>
                <td class='td_action'><div class='table_center'><p>" . $gender . "</p></div></td>
                <td class='td_action'><div class='table_center'><p>" . $Address . "</p></div></td>
                <td class='td_action'><div class='table_center'><p>" . $Baptism . "</p></div></td>
                <td class='td_action'><div class='table_center'><p>" . $occupation . "</p></div></td>
                
                <td><div class='table_center'><p>" . $status . "</p></div></td>

                <td class='option' style='width:100%;display:grid;place-items:center;'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960'
                        width='48'>
                        <path
                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                    </svg>
                    <div class='opt_element'>
                                        <p data-id=" . $unique_id . " class='delete_item'>Delete item <i></i></p>
                                        <p class='Update_item' data-id=" . $unique_id . " data-information='" . $ObjectData . "'>Update item <i></i></p>
                                    </div>
                </td>
            </tr>";



                        }
                        echo '</tbody>';

                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <div class="add_event" data-menu="event">
        <i>+</i>
        <p>New</p>
    </div>
    <div class="info_information event_menu_add"
        style="height:300px; width:500px; padding:10px;text-wrap:wrap;display:grid;place-items:center;">
        <header class="danger"></header>
    </div>

    <div class="event_menu_add form_data">
        <form>
            <header>Membership form</header>
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
                        <label>First name</label>
                        <input name="Fname" type="text" placeholder="" required />
                    </div>
                    <div class="field">
                        <label>Other name</label>
                        <input name="Oname" type="text" placeholder="" required />
                    </div>

                </div>

                <div class="cate_view_e">
                    <div class="field">
                        <label>Birth</label>
                        <input name="birth" type="date" placeholder="" required />
                    </div>
                    <div class="field">
                        <label>Gender</label>
                        <input name="gender" type="text" placeholder="" required />
                    </div>
                    <div class="field">
                        <label>contact</label>
                        <input id="contact_form" name="contact" type="tel" placeholder="553838464" pattern="[0-9]{2}[0-9]{3}[0-9]{4}" required />
                    </div>
                </div>
                <div class="cate_view">
                    <div class="field">
                        <label>Occupation</label>
                        <input name="occupation" type="text" placeholder="" required />
                    </div>
                    <div class="field">
                        <label>Location (city,town and street)</label>
                        <input name="location" type="text" placeholder="" required />
                    </div>
                </div>
                <div class="field">
                    <label>Status</label>
                    <select name="status" required>
                        <option value="Public">Select the status of this user</option>
                        <option>Active</option>
                        <option>Inconsistency</option>
                        <option>Other reasons</option>
                    </select>
                </div>
                <div class="cate_view">
                    <div class="field">
                        <label>Baptism(specify both if available ..eg water & fire)</label>
                        <input name="baptism" type="text" placeholder="" required />
                    </div>
                    <div class="field">
                        <label>Position</label>
                        <input name="position" type="text" placeholder="" required />
                    </div>
                </div>
                <div class="field">
                    <label>Profile Image</label>
                    <div class="upload_blog">
                        <a id="browseButton" name="imageFile">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M7 18a4.6 4.4 0 0 1 0 -9a5 4.5 0 0 1 11 2h1a3.5 3.5 0 0 1 0 7h-1" />
                                <path d="M9 15l3 -3l3 3" />
                                <path d="M12 12l0 9" />
                            </svg>

                            <span>Select file to upload here</span>
                        </a>
                    </div>
                </div>
                <input name="delete_key" type="number" value="" hidden />
                <button>create Activity</button>
            </div>
        </form>

    </div>
    <div class="page_sys">
        <?php
        if (isset($_SESSION['total_pages_membership'])) {
            $total = $_SESSION['total_pages_membership'];
        } else {
            $total = $viewDataClass->viewpages();
            $_SESSION['total_pages_membership'] = $total;
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