<?php
include_once('../../API/sundayRecords/autoloader.php');
$newDataRequest = new viewData();
$year = date('Y');
if (isset($_GET['year'])) {
    $year = $_GET['year'];
}
if (isset($_GET['data_page'])) {
    $num = $_GET['data_page'];
} else {
    $num = 1;
}
?>
<div class="notifyBox">
    <p>
        Items delete successfully
    </p>
</div>

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

            <div class="item_opt flex">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                    <path
                        d="m105-233-65-47 200-320 120 140 160-260 109 163q-23 1-43.5 5.5T545-539l-22-33-152 247-121-141-145 233ZM863-40 738-165q-20 14-44.5 21t-50.5 7q-75 0-127.5-52.5T463-317q0-75 52.5-127.5T643-497q75 0 127.5 52.5T823-317q0 26-7 50.5T795-221L920-97l-57 57ZM643-217q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm89-320q-19-8-39.5-13t-42.5-6l205-324 65 47-188 296Z" />
                </svg>
                <a style="text-decoration:none;" target="_blank" href="finance/budgetAnalysis.html">chart</a>
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



<div class="profile_main">
    <header>SUNDAY SERVICE PROGRAMME DATA</header>
    <div class="grid_sx tithebook">
        <div class="profile">
            <div class="tithe_list ancc_list">
                <?php
                $data = json_decode($newDataRequest->View_List($year));
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
                        echo '                     <div class="annc_item">
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
                                            <input type="text" name="opening_prayer" placeholder=".............." />
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
                                            <input type="text" name="scripture_reading" placeholder=".............." />
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
                                            <input type="text" name="opening_Hymn" placeholder=".............." />
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
                                            <input type="text" name="sermon_prayer" placeholder=".............." />
                                        </div>
                                        <div class="field">
                                            <label>From:</label>
                                            <input type="text" name="sermon_from" placeholder=".............." />
                                        </div>
                                    </div>
                                    <div class="cate_view">
                                        <div class="field">
                                            <label>Scripture from preacher:</label>
                                            <input type="text" name="scripture_preacher" placeholder=".............." />
                                        </div>
                                        <div class="field">
                                            <label>Time Duratoin for the preacher:</label>
                                            <input type="text" name="peacher_duration" placeholder=".............." />
                                        </div>
                                    </div>
                                    <div class="cate_view">
                                        <div class="field">
                                            <label>Alter Call By:</label>
                                            <input type="text" name="alter_call" placeholder=".............." />
                                        </div>
                                        <div class="field">
                                            <label>Tithe and Offering</label>
                                            <input type="text" name="tithe_offering" placeholder=".............." />
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label>Special Appeal</label>
                                        <input type="text" name="special_appeal" placeholder=".............." />
                                    </div>
                                    <div class="cate_view">
                                        <div class="field">
                                            <label>Welcome of visitors</label>
                                            <input type="text" name="welcome_visitors" placeholder=".............." />
                                        </div>
                                        <div class="field">
                                            <label>Announcement</label>
                                            <input type="text" name="Announcement" placeholder=".............." />
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
                                            <input type="text" name="Benediction" placeholder=".............." />
                                        </div>
                                        <div class="field">
                                            <label>Mc</label>
                                            <input type="text" name="MC" placeholder=".............." />
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label>Total Attendance</label>
                                        <input type="text" name="Total_attendance" placeholder=".............." />
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
</div>
<div class="event_menu_add">
    <header>Add to records (2024)</header>
    <div class="flex title">
        <div class="item">
            <p><span>23</span> births</p>
        </div>
        <div class="item">
            <p><span>3</span> Deaths</p>
        </div>
        <div class="item">
            <p><span>12</span> water baptism</p>
        </div>
        <div class="item">
            <p><span>11</span> fire baptism</p>
        </div>
        <div class="item">
            <p><span>23</span> births</p>
        </div>
    </div>
    <div class="container_event">
        <div class="field">
            <label>Select category</label>
            <select>
                <option>new Birth</option>
                <option>death</option>
                <option>water_baptism</option>
                <option>fire_baptism</option>
            </select>
        </div>
        <div class="field_e">
            <label>Details</label>
            <textarea></textarea>
        </div>
        <div class="field">
            <button>submit data</button>
        </div>

    </div>
</div>


<div class="add_event" data-menu="event">
    <i>+</i>
    <p>Record</p>
</div>

<div class="add_event far" data-menu="event">
    <i>+</i>
    <p>Sunday</p>
</div>