<?php
session_start();
require '../../API/vendor/autoload.php';
$viewDataClass = new Gallery\viewData();
$val = 1;
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}
if (isset($_SESSION['login_details'])) {
    $login_details = $_SESSION['login_details'];
    if (!isset($_SESSION['access_entryLog'])) {
        $date = date('Y-m-d H:i:s');
        $newquest = $viewDataClass->DataHistory($login_details, "Access page selection", $date, "Access page section", "Admin Viewed Access page section");
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
                <p class="location_date">membership</p>
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
                    <thead>
                        <tr>
                            <th>file</th>
                            <th>Eventname</th>

                            <th>size</th>
                            <th>upload</th>
                            <th></th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php
                        $data = json_decode($viewDataClass->viewList($val));
                        foreach ($data as $item) {
                            $unique_id = $item->UniqueId;
                            $Eventname = $item->Eventname;
                            $imageName = $item->name;
                            $date_uploaded = $item->date_uploaded;
                            $category = $item->category;
                            $ObjectData = $item->Obj;
                            echo
                                "<tr>
                <td><div class='details'>
<div class='img'>
<img src='../API/Images_folder/gallery/" . $imageName . "' alt='' />
</div>
<div class='text'>
<p>" . $imageName . "</p>
</div>

</div></td>
                <td class='td_action'><div class='table_center'><p>" . $Eventname . "</p></div></td>
                <td class='td_action'><div class='table_center'><p>" . $date_uploaded . "</p></div></td>
                <td class='td_action'><div class='table_center'><p>" . $category . "</p></div></td>

                <td class='option' style='width:100%;display:grid;place-items:center;'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960'
                        width='48'>
                        <path
                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                    </svg>
                    <div class='opt_element' style='height:130px;'>
                                        <p data-id=" . $unique_id . " class='delete_item'>Delete item <i></i></p>
                                        <p class='Update_item' data-id=" . $unique_id . " data-information='" . $ObjectData . "'>Update item <i></i></p>
                                        <a href='../API/Images_folder/gallery/" . $imageName . "' download><p>Download File</p></a>
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
    <div class="add_event" data-menu="event">
        <i>+</i>
        <p>New</p>
    </div>
    <div class="event_menu_add">
        <form>
            <header>Gallery form</header>
            <p class="error_information"></p>
            <div class="container_event">
                <div class="cate_view">

                    <div class="field">
                        <label>Event Name</label>
                        <input name="event_name" type="text" placeholder="" />
                    </div>

                </div>
                <div class="field">
                    <label>Category</label>
                    <select name="category">
                        <option>Funeral</option>
                        <option>Wedding</option>
                        <option>Ceremony</option>
                    </select>
                </div>

                <div class="cate_view">
                    <div class="field">
                        <label>Upload Image</label>
                        <input name="imageFile[]" multiple type="file" />
                    </div>
                    <div class="field">
                        <label>Upload date</label>
                        <input name="date" type="date" placeholder="" />
                    </div>
                </div>
                <div class="image_view">
                    <div class="item">
                        <img src="gallery/x1.jpeg" alt="" />
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <input name="delete_key" type="text" value="" hidden />
                <button>Upload Image</button>
            </div>
        </form>

    </div>
    <?php
} else {
    echo "<header>Sorry, you are not allowed access to this page, please contact the administrator</header>";
}
?>