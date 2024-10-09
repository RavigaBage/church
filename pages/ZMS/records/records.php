<?php
session_start();
require '../../../API/vendor/autoload.php';
$viewDataClass = new Records\viewData();
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
        if (!isset($_SESSION['records_Log'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $viewDataClass->DataHistory($unique_id, "Admin permit was used to logged in", $date, "Dashboard records", "Admin permit was used logged in to dashboard");
            $decode = json_decode($newquest);
            if ($decode == 'Success') {
                $_SESSION['records_Log'] = true;
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
    <div class="main_container">
        <div class="ui_controller">
            <div class="profile_main ">
                <header>SUNDAY SERVICE PROGRAMME DATA</header>
                <div class="grid_sx tithebook">
                    <div class="profile">
                        <div class="tithe_list ancc_list">
                            <?php
                            $data = json_decode($viewDataClass->View_List($year, $num));
                            if ($data == "" || $data == 'Error Occurred' || $data == 'Not Records Available') {
                                echo "<header class='danger'>Not Records Available</header>";
                            } else {
                                foreach ($data as $item) {
                                    $open_prayer = $item->open_prayer;
                                    $praise = $item->praise;
                                    $scripture_read = $item->scripture_read;
                                    $scripture = $item->scripture;
                                    $hymn = $item->hymn;
                                    $hymn_new = $item->hymn_new;
                                    $hymn_title = $item->hymn_title;
                                    $worship = $item->worship;
                                    $testimonies = $item->testimonies;
                                    $song_thanksgivning = $item->song_thanksgivning;
                                    $sermon_prayer = $item->sermon_prayer;
                                    $sermon_from = $item->sermon_from;
                                    $scipture_preacher = $item->scipture_preacher;
                                    $preacher_duration = $item->preacher_duration;
                                    $alter_call = $item->alter_call;
                                    $tithe_offering = $item->tithe_offering;
                                    $special_appeal = $item->special_appeal;
                                    $welcome_visitors = $item->welcome_visitors;
                                    $annc = $item->annc;
                                    $closing_prayer = $item->closing_prayer;
                                    $Benediction = $item->Benediction;
                                    $mc = $item->mc;
                                    $total_attendance = $item->total_attendance;
                                    $date = $item->date;
                                    $id = $item->id;
                                    echo '  <div class="annc_item list_mode">
                    <div class="flex button">
                        <div class=" flex title">
                            <h1>Sunday Record ' . $sermon_from . '</h1>
                            <div class="flex button"><i class="fas fa-date"></i>' . $date . '</div>
                        </div>
                    </div>
    
                    <div class="div_content">
                        <details>
                        <form form-id=' . $id . '>
                        <input name="delete_key" type="hidden" value=' . $id . ' />
                            <div class="Activity_record">
                                <div class="cate_view">
                                    <div class="field">
                                        <label>Opening Prayer led By</label>
                                        <input type="text" value=' . $open_prayer . ' placeholder="' . $open_prayer . '" name="opening_prayer" />
                                    </div>
                                    <div class="field">
                                        <label>Praises By:</label>
                                        <input type="text" name="praises" placeholder="' . $praise . '" value=' . $praise . ' />
                                    </div>
                                </div>
                                <header>Scripture reading</header>
                                <div class="cate_view">
                                    <div class="field">
                                        <label>Scripture Reading By</label>
                                        <input type="text" name="scripture_reading" placeholder="' . $scripture_read . '" value=' . $scripture_read . ' />
                                    </div>
                                    <div class="field">
                                        <label>Scripture read:</label>
                                        <input type="text" name="scripture" placeholder="' . $scripture . '" value=' . $scripture . ' />
                                    </div>
                                </div>
    
                                <header>Hymn</header>
                                <div class="cate_view_e">
                                    <div class="field">
                                        <label>Opening Hymn No</label>
                                        <input type="text" name="opening_Hymn" placeholder="' . $hymn . '" value=' . $hymn . ' />
                                    </div>
                                    <div class="field">
                                        <label>New:</label>
                                        <input type="text" name="Hymn_new" placeholder="' . $hymn_new . '" value=' . $hymn_new . ' />
                                    </div>
                                    <div class="field">
                                        <label>Title:</label>
                                        <input type="text" name="Hymn_title" placeholder="' . $hymn_title . '" value=' . $hymn_title . ' />
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Call to worship</label>
                                    <input type="text" name="worship" placeholder="' . $worship . '" value=' . $worship . ' />
                                </div>
                                <div class="field">
                                    <label>Testimonies</label>
                                    <input type="text" name="testimonies" value=' . $testimonies . ' placeholder="' . $testimonies . '" />
                                </div>
                                <div class="field">
                                    <label>Song Ministration & Thanksgiving Offering:</label>
                                    <input type="text" name="song_thanksgving_offering" value=' . $song_thanksgivning . ' placeholder="' . $song_thanksgivning . '" />
                                </div>
    
                                <header>Sermon</header>
                                <div class="cate_view">
                                    <div class="field">
                                        <label>Sermon & Prayer By:</label>
                                        <input type="text" name="sermon_prayer" value=' . $sermon_prayer . ' placeholder="' . $sermon_prayer . '" />
                                    </div>
                                    <div class="field">
                                        <label>From:</label>
                                        <input type="text" name="sermon_from" value=' . $sermon_from . ' placeholder="' . $sermon_from . '" />
                                    </div>
                                </div>
                                <div class="cate_view">
                                    <div class="field">
                                        <label>Scripture from preacher:</label>
                                        <input type="text" name="scripture_preacher" value=' . $scipture_preacher . ' placeholder="' . $scipture_preacher . '" />
                                    </div>
                                    <div class="field">
                                        <label>Time Duratoin for the preacher:</label>
                                        <input type="text" name="peacher_duration" placeholder="' . $preacher_duration . '" value=' . $preacher_duration . '"/>
                                    </div>
                                </div>
                                <div class="cate_view">
                                    <div class="field">
                                        <label>Alter Call By:</label>
                                        <input type="text" name="alter_call" placeholder="' . $alter_call . '" value=' . $alter_call . ' />
                                    </div>
                                    <div class="field">
                                        <label>Tithe and Offering</label>
                                        <input type="text" name="tithe_offering" placeholder="' . $tithe_offering . '" value=' . $tithe_offering . ' />
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Special Appeal</label>
                                    <input type="text"  name="special_appeal" placeholder="' . $special_appeal . '" value=' . $special_appeal . ' />
                                </div>
                                <div class="cate_view">
                                    <div class="field">
                                        <label>Welcome of visitors</label>
                                        <input type="text" name="welcome_visitors" value=' . $welcome_visitors . ' placeholder="' . $welcome_visitors . '" />
                                    </div>
                                    <div class="field">
                                        <label>Announcement</label>
                                        <input type="text" name="Announcement" placeholder="' . $annc . '" value=' . $annc . ' />
                                    </div>
                                </div>
                                <header>Closing..</header>
                                <div class="field">
                                    <label>Closing Prayer</label>
                                    <input type="text" name="closing_prayer" value=' . $closing_prayer . ' placeholder="' . $closing_prayer . '" />
                                </div>
                                <div class="cate_view">
                                    <div class="field">
                                        <label>Benediction</label>
                                        <input type="text" name="Benediction" value=' . $Benediction . ' placeholder="' . $Benediction . '" />
                                    </div>
                                    <div class="field">
                                        <label>Mc</label>
                                        <input type="text" name="MC" placeholder="' . $mc . '" value=' . $mc . ' />
                                    </div>
                                </div>
                                <div class="field">
                                    <label>Total Attendance</label>
                                    <input type="text" name="Total_attendance" value=' . $total_attendance . ' placeholder="' . $total_attendance . '" />
                                </div>
                                <div class="field">
                                            <label>Date</label>
                                            <input type="date" name="date" placeholder="" value=' . $date . ' />
                                        </div>
                              <button>Record message</button>
                            </div>
                            </form>
                        </details>
                    </div>
                        <div class=" flex options title">
                            <div class="edit flex Update_item">
                                <i class="fas fa-edit Update_item"></i>
                                <p>Edit</p>
                            </div>
    
                            <div class="edit flex">
                                <i class="fas fa-trash delete_item"></i>
                                <p>Remove</p>
                            </div>
                        </div>
                </div>';
                                }
                            }
                            ?>
                            <div class="annc_item" hidden id="template">
                                <div class="flex button">
                                    <div class=" flex title">
                                        <h1>new Sunday edit to save </h1>
                                        <div class="flex button"><i class="fas fa-date"></i>2023,04,12</div>
                                    </div>
                                </div>

                                <div class="div_content">
                                    <details>
                                        <form>
                                            <input name="delete_key" type="hidden" value='' />
                                            <div class="Activity_record">
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Opening Prayer led By</label>
                                                        <input type="text" name="opening_prayer"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Praises By:</label>
                                                        <input type="text" name="praises" placeholder=".............." />
                                                    </div>
                                                </div>
                                                <header>Scripture reading</header>
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Scripture Reading By</label>
                                                        <input type="text" name="scripture_reading"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Scripture read:</label>
                                                        <input type="text" name="scripture" placeholder=".............." />
                                                    </div>
                                                </div>

                                                <header>Hymn</header>
                                                <div class="cate_view_e">
                                                    <div class="field">
                                                        <label>Opening Hymn No</label>
                                                        <input type="text" name="opening_Hymn"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>New:</label>
                                                        <input type="text" name="Hymn_new" placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Title:</label>
                                                        <input type="text" name="Hymn_title" placeholder=".............." />
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label>Call to worship</label>
                                                    <input type="text" name="worship" placeholder=".............." />
                                                </div>
                                                <div class="field">
                                                    <label>Testimonies</label>
                                                    <input type="text" name="testimonies" placeholder=".............." />
                                                </div>
                                                <div class="field">
                                                    <label>Song Ministration & Thanksgiving Offering:</label>
                                                    <input type="text" name="song_thanksgving_offering"
                                                        placeholder=".............." />
                                                </div>

                                                <header>Sermon</header>
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Sermon & Prayer By:</label>
                                                        <input type="text" name="sermon_prayer"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>From:</label>
                                                        <input type="text" name="sermon_from"
                                                            placeholder=".............." />
                                                    </div>
                                                </div>
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Scripture from preacher:</label>
                                                        <input type="text" name="scripture_preacher"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Time Duratoin for the preacher:</label>
                                                        <input type="text" name="peacher_duration"
                                                            placeholder=".............." />
                                                    </div>
                                                </div>
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Alter Call By:</label>
                                                        <input type="text" name="alter_call" placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Tithe and Offering</label>
                                                        <input type="text" name="tithe_offering"
                                                            placeholder=".............." />
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label>Special Appeal</label>
                                                    <input type="text" name="special_appeal" placeholder=".............." />
                                                </div>
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Welcome of visitors</label>
                                                        <input type="text" name="welcome_visitors"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Announcement</label>
                                                        <input type="text" name="Announcement"
                                                            placeholder=".............." />
                                                    </div>
                                                </div>
                                                <header>Closing..</header>
                                                <div class="field">
                                                    <label>Closing Prayer</label>
                                                    <input type="text" name="closing_prayer" placeholder=".............." />
                                                </div>
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Benediction</label>
                                                        <input type="text" name="Benediction"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Mc</label>
                                                        <input type="text" name="MC" placeholder=".............." />
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label>Total Attendance</label>
                                                    <input type="text" name="Total_attendance"
                                                        placeholder=".............." />
                                                </div>
                                                <div class="field">
                                                    <label>Date</label>
                                                    <input type="date" name="date" placeholder=".............." />
                                                </div>
                                                <button>Record message</button>
                                            </div>
                                        </form>
                                    </details>
                                </div>
                                <div class=" flex options title">
                                    <div class="edit flex Update_item">
                                        <i class="fas fa-edit Update_item"></i>
                                        <p>Edit</p>
                                    </div>


                                    <div class="edit flex">
                                        <i class="fas fa-trash delete_item"></i>
                                        <p>Remove</p>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="page_sys">
                    <?php
                    if (isset($_SESSION['total_pages_sunDay'])) {
                        $total = $_SESSION['total_pages_sunDay'];
                    } else {
                        $total = $viewDataClass->SundayPages();
                        $_SESSION['total_pages_sunDay'] = $total;
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
            <div class="profile_main records_data">
                <header>SUNDAY SERVICE PROGRAMME DATA</header>
                <div class="grid_sx tithebook">
                    <div class="profile records_main">
                        <div class="annc_item" hidden id="Recordtemplate">
                            <div class="flex button">
                                <div class=" flex title">
                                    <h1>Church Record</h1>
                                    <div class="flex button"><i class="fas fa-date"></i></div>
                                </div>
                            </div>

                            <div class="div_content">
                                <details>
                                    <form>
                                        <input name="delete_key" type="hidden" value=' ' />
                                        <div class="Activity_record">
                                            <div class="field">
                                                <label>Category</label>
                                                <select name="category">
                                                    <option>Birth</option>
                                                    <option>Death</option>
                                                    <option>water baptism</option>
                                                    <option>fire baptism</option>
                                                    <option>wedding</option>
                                                </select>
                                            </div>
                                            <div class="field">
                                                <label>Year</label>
                                                <select name="year" value="">
                                                    <option>2024</option>
                                                    <option>2023</option>
                                                    <option>2022</option>
                                                    <option>2021</option>
                                                </select>
                                            </div>

                                            <div class="field_e">
                                                <label>Details</label>
                                                <textarea name="details" value=''></textarea>
                                            </div>
                                            <button>Record message</button>
                                        </div>
                                    </form>
                                </details>
                            </div>
                            <div class=" flex options title">
                                <div class="edit flex Update_item">
                                    <i class="fas fa-edit Update_item"></i>
                                    <p>Edit</p>
                                </div>

                                <div class="edit flex">
                                    <i class="fas fa-trash delete_item"></i>
                                    <p>Remove</p>
                                </div>
                            </div>
                        </div>
                        <div class="tithe_list ancc_list">
                            <?php
                            $data = json_decode($viewDataClass->church_record_viewList($year, $num));
                            if ($data == "" || $data == 'Error Occurred' || $data == 'Not Records Available') {
                                echo "<header class='danger'>Not Records Available</header>";
                            } else {
                                foreach ($data as $item) {
                                    $name = $item->name;
                                    $details = $item->details;
                                    $date = $item->date;
                                    $year = $item->year;
                                    $id = $item->id;
                                    echo
                                        ' <div class="annc_item list_mode">
                    <div class="flex button">
                        <div class=" flex title">
                            <h1>Church Record' . $name . '</h1>
                            <div class="flex button"><i class="fas fa-date"></i>' . $date . '</div>
                        </div>
                    </div>
    
                    <div class="div_content">
                        <details>
                        <form form-id=' . $id . '>
                        <input name="delete_key" type="hidden" value=' . $id . ' />
                            <div class="Activity_record">
                            <div class="field">
                            <label>Category</label>
                                <select name="category">
                             <option>Birth</option>
                              <option>Death</option>
                               <option>water baptism</option>
                                <option>fire baptism</option>
                                 <option>wedding</option>
                             </select>
                            </div>
                            <div class="field">
                                                <label>Year of record</label>
                                                 <select name="year" value="' . $year . '">
                             <option>2024</option>
                              <option>2023</option>
                               <option>2022</option>
                                <option>2021</option>
                             </select>
                                            </div>

                             <div class="field_e">
                                <label>Details</label>
                                 <textarea name="details">' . $details . '</textarea>
                            </div>
                             <button>Record message</button>
                            </div>
                            </form>
                        </details>
                    </div>
                        <div class=" flex options title">
                            <div class="edit flex Update_item">
                                <i class="fas fa-edit Update_item"></i>
                                <p>Edit</p>
                            </div>
    
                            <div class="edit flex">
                                <i class="fas fa-trash delete_item"></i>
                                <p>Remove</p>
                            </div>
                        </div>
                </div>';
                                }
                            }
                            ?>
                            <div class="annc_item" hidden id="template">
                                <div class="flex button">
                                    <div class=" flex title">
                                        <h1>Sunday </h1>
                                        <div class="flex button"><i class="fas fa-date"></i>2023,04,12</div>
                                    </div>
                                </div>

                                <div class="div_content">
                                    <details>
                                        <form>
                                            <div class="Activity_record">
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Opening Prayer led By</label>
                                                        <input type="text" name="opening_prayer"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Praises By:</label>
                                                        <input type="text" name="praises" placeholder=".............." />
                                                    </div>
                                                </div>
                                                <header>Scripture reading</header>
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Scripture Reading By</label>
                                                        <input type="text" name="scripture_reading"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Scripture read:</label>
                                                        <input type="text" name="scripture" placeholder=".............." />
                                                    </div>
                                                </div>

                                                <header>Hymn</header>
                                                <div class="cate_view_e">
                                                    <div class="field">
                                                        <label>Opening Hymn No</label>
                                                        <input type="text" name="opening_Hymn"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>New:</label>
                                                        <input type="text" name="Hymn_new" placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Title:</label>
                                                        <input type="text" name="Hymn_title" placeholder=".............." />
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label>Call to worship</label>
                                                    <input type="text" name="worship" placeholder=".............." />
                                                </div>
                                                <div class="field">
                                                    <label>Testimonies</label>
                                                    <input type="text" name="testimonies" placeholder=".............." />
                                                </div>
                                                <div class="field">
                                                    <label>Song Ministration & Thanksgiving Offering:</label>
                                                    <input type="text" name="song_thanksgving_offering"
                                                        placeholder=".............." />
                                                </div>

                                                <header>Sermon</header>
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Sermon & Prayer By:</label>
                                                        <input type="text" name="sermon_prayer"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>From:</label>
                                                        <input type="text" name="sermon_from"
                                                            placeholder=".............." />
                                                    </div>
                                                </div>
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Scripture from preacher:</label>
                                                        <input type="text" name="scripture_preacher"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Time Duratoin for the preacher:</label>
                                                        <input type="text" name="peacher_duration"
                                                            placeholder=".............." />
                                                    </div>
                                                </div>
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Alter Call By:</label>
                                                        <input type="text" name="alter_call" placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Tithe and Offering</label>
                                                        <input type="text" name="tithe_offering"
                                                            placeholder=".............." />
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label>Special Appeal</label>
                                                    <input type="text" name="special_appeal" placeholder=".............." />
                                                </div>
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Welcome of visitors</label>
                                                        <input type="text" name="welcome_visitors"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Announcement</label>
                                                        <input type="text" name="Announcement"
                                                            placeholder=".............." />
                                                    </div>
                                                </div>
                                                <header>Closing..</header>
                                                <div class="field">
                                                    <label>Closing Prayer</label>
                                                    <input type="text" name="closing_prayer" placeholder=".............." />
                                                </div>
                                                <div class="cate_view">
                                                    <div class="field">
                                                        <label>Benediction</label>
                                                        <input type="text" name="Benediction"
                                                            placeholder=".............." />
                                                    </div>
                                                    <div class="field">
                                                        <label>Mc</label>
                                                        <input type="text" name="MC" placeholder=".............." />
                                                    </div>
                                                </div>
                                                <div class="field">
                                                    <label>Total Attendance</label>
                                                    <input type="text" name="Total_attendance"
                                                        placeholder=".............." />
                                                </div>
                                                <div class="field">
                                                    <label>Date</label>
                                                    <input type="date" name="date" placeholder=".............." />
                                                </div>
                                                <button>Record message</button>
                                            </div>
                                        </form>
                                    </details>
                                </div>
                                <div class=" flex options title">
                                    <div class="edit flex Update_item">
                                        <i class="fas fa-edit Update_item"></i>
                                        <p>Edit</p>
                                    </div>


                                    <div class="edit flex">
                                        <i class="fas fa-trash delete_item"></i>
                                        <p>Remove</p>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="page_sys">
                    <?php
                    if (isset($_SESSION['total_pages_record'])) {
                        $total = $_SESSION['total_pages_record'];
                    } else {
                        $total = $viewDataClass->RecordPages();
                        $_SESSION['total_pages_record'] = $total;
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
        </div>
    </div>
    <div class="event_menu_add"
        style="height:300px; width:500px; padding:10px;text-wrap:wrap;display:grid;place-items:center;">
        <header class="danger">Validation failed</header>
    </div>


    <div class="add_event" data-menu="event">
        <i>+</i>
        <p>Record</p>
    </div>

    <div class="add_event far" data-menu="event">
        <i>+</i>
        <p>Sunday</p>
    </div>
    <?php

} else {
    header('Location:../error404/general404.html');
}
?>