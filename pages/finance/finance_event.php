<?php
include_once('../../API/finance/autoloader.php');
$newDataRequest = new viewData();
if (isset($_GET['data_page'])) {
    $num = $_GET['data_page'];
} else {
    $num = 1;
}
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
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../icons/css/all.css" />
        <link rel="stylesheet" href="../css/dash.css">
        <link rel="stylesheet" href="../css/membership.css" />
        <title>Zoe worship centre Admin Dashboard</title>
    </head>

    <body>
        <main class="scroll_overflow" style="margin-left:0%;width:100%;">
            <div class="loader_progress">
                <div class="progress"></div>
            </div>
            <section>
                <nav>
                    <div class="navigation_content" style="justify-content: flex-end;">
                        <div class="nav_profile_link">
                            <div class="date_view search">
                                <div class="ux_search_bar"
                                    style="position:relative;transform:translateY(0px);pointer-events:initial">
                                    <input type="search_data" type="search" id="searchInput" name="search"
                                        placeholder="...search here" />
                                    <button id="searchBtn"><i class="fas fa-search" aria-hidden></i></button>
                                </div>
                            </div>

                            <div class="icon_notify">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                    fill="#5f6368">
                                    <path
                                        d="M160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v28q80 20 130 84.5T720-560v280h80v80H160Zm320-300Zm0 420q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM320-280h320v-280q0-66-47-113t-113-47q-66 0-113 47t-47 113v280Z" />
                                </svg>
                                <div class="counter">
                                    <p>2</p>
                                </div>
                                <div class="notification_list">
                                    <div class="item">
                                        <h1>Announcement site</h1>
                                        <p>23.01.24</p>
                                    </div>

                                    <div class="item">
                                        <h1>Membership site</h1>
                                        <p>23.01.24</p>
                                    </div>
                                </div>
                            </div>

                            <div class="nav_profile">
                                <img src="../../images/blog-1.jpg" alt="profile" />
                            </div>
                        </div>
                    </div>

                </nav>

                <div class="filter_wrapper relative">
                    <div style="height:40px;width:100%" class="flex">
                        <h1>Contribution</h1>

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

                <div class="content_body">
                    <div class="export_dialogue">
                        <form>
                            <header>Exporting Data</header>
                            <div class="loader">All fields required</div>
                            <div class="container_event">
                                <div class="cate_view">
                                    <div class="field">
                                        <label>Export Name</label>
                                        <input required type="text" class="form_condition" name="export_name"
                                            placeholder="specify the a name to export this data with" />
                                    </div>
                                    <div class="field">
                                        <label>Export type</label>
                                        <select required name="export_type">
                                            <option value="pdf">Pdf file(.pdf)</option>
                                            <option value="excel">Excel file(.xlsx)</option>
                                        </select>
                                    </div>
                                </div>
                                <button id="exportDataBtn">Save document</button>
                            </div>
                        </form>
                    </div>
                    <div class="skeleton_loader list">
                        <div class="div_sample">
                            <div class="main"></div>
                            <div class="min"></div>
                        </div>
                        <div class="div_sample">
                            <div class="main"></div>
                            <div class="min"></div>
                        </div>
                        <div class="div_sample">
                            <div class="main"></div>
                            <div class="min"></div>
                        </div>
                        <div class="div_sample">
                            <div class="main"></div>
                            <div class="min"></div>
                        </div>
                        <div class="div_sample">
                            <div class="main"></div>
                            <div class="min"></div>
                        </div>
                    </div>
                    <div class="skeleton_loader table ">
                        <table>
                            <thead>
                                <tr>
                                    <th>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                    <div class="content_main ">
                        <div class="content_main">
                            <div class="content_pages">
                                <div class="content_page_event">
                                    <div class="add_event" data-menu="event">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px">
                                            <path
                                                d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z" />
                                        </svg>
                                        <p>New</p>
                                    </div>
                                    <div class="CloneSearch" hidden>
                                        <table>
                                            <tr>
                                                <td></td>
                                                <td class='td_action Clonename'></td>
                                                <td class='td_action Clonegender'></td>
                                                <td class='td_action Clonecontact'></td>
                                                <td class='td_action Cloneamount'>
                                                    <div></div>
                                                </td>
                                                <td class='td_action Clonemedium'></td>
                                                <td class='td_action Clonerecord'></td>
                                                <td class='option'>
                                                    <div class='delete option'>
                                                        <svg xmlns='http://www.w3.org/2000/svg' height='30'
                                                            viewBox='0 -960 960 960' width='30'>
                                                            <path
                                                                d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                                        </svg>
                                                        <div class='opt_element'>
                                                            <p class='update_item up' Update_item='' data-information=''>
                                                                Update item <i></i></p>
                                                            <p class='delete_item dp' delete_item='" . $id . "'
                                                                delete_table=''>Delete item <i></i></p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="records_table">
                                        <table>
                                            <?php
                                            $update = json_decode($newDataRequest->Dues_pay_list_update($num));
                                            if ($update == "updated") {
                                                $data = json_decode($newDataRequest->Dues_pay_list($num));
                                                if ($data == "" || $data == 'Error Occurred' || $data == 'No Records Available') {
                                                    echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                                                } else {
                                                    echo '
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>user-name</th>
                                                <th>gender</th>
                                                <th>contact</th>
                                                <th>Amount(' . $_GET['amount'] . ')</th>
                                                <th>Gateway</th>
                                                <th>Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                                                    foreach ($data as $item) {
                                                        $amount = $item->amount;
                                                        $Name = $item->name;
                                                        $gender = $item->gender;
                                                        $contact = $item->contact;
                                                        $Medium = $item->medium;
                                                        $Record_date = $item->record_date;
                                                        $id = $item->UniqueId;
                                                        $ObjectData = $item->Obj;
                                                        $name = $item->Uname;

                                                        $amtVal = "<td class='td_action'>" . $amount . "<div></div></td>";

                                                        if (isset($_GET['amount'])) {
                                                            if ((intval($_GET['amount']) - ($amount)) <= 0) {
                                                                $amtVal = "<td class='td_action'> 
                                                                <div class='flex '><b>" . $amount . "</b>
                                                                <svg xmlns='http://www.w3.org/2000/svg' height='24px' class='success'viewBox='0 -960 960 960' width='24px' fill='#5f6368'><path d='M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q65 0 123 19t107 53l-58 59q-38-24-81-37.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q32 0 62-6t58-17l60 61q-41 20-86 31t-94 11Zm280-80v-120H640v-80h120v-120h80v120h120v80H840v120h-80ZM424-296 254-466l56-56 114 114 400-401 56 56-456 457Z'/></svg></div></td>
                                                            ";
                                                            } else {
                                                                $amtVal =
                                                                    "<td class='td_action'>" . $amount . " (<b class='danger'>- " . (intval($_GET['amount']) - $amount) . "</b>)<div></div></td>";
                                                            }
                                                        }

                                                        echo "
                                                        <tr>
                                                            <td></td>
                                                            <td class='td_action'>" . $Name . "</td>
                                                            <td class='td_action'>" . $gender . "</td>
                                                            <td class='td_action'>" . $contact . "</td>
                                                            " . $amtVal . "
                                                            <td class='td_action'>" . $Medium . "</td>
                                                            <td class='td_action'>" . $Record_date . "</td>
                                                            <td class='option'>
                                                                <div class='delete option'>
                                                                    <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                                                                        width='30'>
                                                                        <path
                                                                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                                                    </svg>
                                                                    <div class='opt_element'>
                                                                        <p class='update_item up' Update_item='" . $id . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                                                                        <p class='delete_item dp' delete_item='" . $id . "' delete_table='" . $name . "'>Delete item <i></i></p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>        
                                        ";
                                                    }
                                                    echo ' </tbody>';
                                                }
                                            } else {
                                                echo "Error ocurred" . $update;
                                            }

                                            ?>



                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="event_menu_add">
                                <form>
                                    <header>New Activity</header>
                                    <h1 class="loader">..loading data</h1>
                                    <div class="container_event">
                                        <div class="field">
                                            <label>User - name</label>
                                            <select name="name" required>
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
                                            <input type="number" name="amount" placeholder="" />
                                        </div>
                                        <div class="field">
                                            <label>Gateway</label>
                                            <select name="medium" value="">
                                                <option>Select</option>
                                                <option>in-person</option>
                                                <option>Bank Account</option>
                                                <option>Mobile mobile Account</option>
                                            </select>
                                        </div>

                                        <div class="field">
                                            <label>Activity Date</label>
                                            <input type="date" name="Date" placeholder="" />
                                        </div>
                                        <input type="hidden" name="delete_key" />
                                        <input type="hidden" name="formName" value="<?php echo $_GET['data_page']; ?>" />
                                        <button>create Activity</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="dn_message">
                        <h1>
                            By accepting you wil permanently delete this record from the church's database.
                        </h1>
                        <p>Are you sure you want to delete this record</p>
                        <div class="btn">
                            <div class="btn_confirm" data-confirm="false">No</div>
                            <div class="btn_confirm" data-confirm="true">Yes</div>
                        </div>
                    </div>
            </section>
        </main>
        <script src="../scripts/xlsx.full.min.js"></script>
        <script>
            let validateKey;
            let validateName;
            let APIDOCS;
            const Forms = document.querySelectorAll('form');

            function ConditionFeilds(arrayArg) {
                clearance = true;
                console.log(arrayArg);
                arrayArg.forEach((element) => {

                    if (
                        element.value == "" ||
                        element.value == " " ||
                        element.value == null
                    ) {
                        clearance = false;
                    }
                });
                return clearance;
            }
            Forms.forEach(element => {
                element.addEventListener('submit', function (e) {
                    e.preventDefault();
                });

            })
            const AddEventBtn = document.querySelector('.add_event');
            const AddEventMenu = document.querySelector('.event_menu_add');
            var OptionElements = document.querySelectorAll('td.option');
            const AddEventMenu_Btn = document.querySelector(".event_menu_add Button");
            const dn_message = document.querySelector(".dn_message");
            const confirmsBtns = document.querySelectorAll(".btn_confirm");
            const searchInput = document.querySelector("#searchInput");
            const searchBtn = document.querySelector("#searchBtn");
            const loader_progress = document.querySelector(".loader_progress");
            const ContentDom = document.querySelector(".content_main");
            const SkeletonDom_table = document.querySelector(".skeleton_loader.table");
            var DomManipulationElement = SkeletonDom_table;
            const Export_variables = document.querySelector('#ExportBtn');
            const Export_variables_Dialogue = document.querySelector('.export_dialogue');
            const Export_variables_Dialogue_Btn = document.querySelector('.export_dialogue button');
            const Export_variables_Dialogue_Form = Export_variables_Dialogue.querySelector("form");



            AddEventBtn.onclick = function () {
                AddEventMenu.classList.add('active');
                APIDOCS =
                    "../../API/finance/data_process.php?APICALL=event&&user=true&&submit=upload";

            }
            AddEventMenu_Btn.addEventListener('click', function () {
                var loaderBtn = AddEventMenu.querySelector('.loader');
                loaderBtn.classList.add('active');
                PHPREQUEST(APIDOCS, Forms, loaderBtn)
            })

            searchBtn.addEventListener("click", e => {
                APIDOCS =
                    "../../API/finance/data_process.php?APICALL=true&&user=event&&submit=search";
                if (searchInput.value != " " && searchInput.value != "") {
                    loader_progress.classList.add("active");
                    ContentDom.classList.add("load");
                    DomManipulationElement.classList.add("load");
                    searchSystem(APIDOCS, searchInput.value);
                    loader_progress.classList.remove("active");
                    ContentDom.classList.remove("load");
                    DomManipulationElement.classList.remove("load");
                }
            })

            OptionElements.forEach(element => {
                element.addEventListener('click', function () {
                    var ElementOptions = element.querySelector('.opt_element');
                    ElementOptions.classList.add('active')
                })
            });
            window.addEventListener('click', function (e) {
                var target = e.target
                if (AddEventMenu.classList.contains('active') && !AddEventBtn.contains(target)) {
                    if (!AddEventMenu.contains(target)) {
                        AddEventMenu.classList.remove('active')
                    }
                }
                if (Export_variables_Dialogue.classList.contains('active') && !Export_variables.contains(target)) {
                    if (!Export_variables_Dialogue.contains(target)) {
                        Export_variables_Dialogue.classList.remove('active')
                    }
                }

                OptionElements.forEach(element => {
                    var ElementOptions = element.querySelector('.opt_element');

                    if (ElementOptions.classList.contains('active') && !element.contains(target)) {
                        if (!ElementOptions.contains(target)) {
                            ElementOptions.classList.remove('active')
                        }
                    } else {
                        if (target.classList.contains('update_item')) {
                            UpdateItemFunction(target)
                        }
                        if (target.classList.contains('delete_item')) {
                            validateKey = target.getAttribute("delete_item");
                            validateName = target.getAttribute("delete_table");
                            dn_message.classList.add("active");
                        }
                    }


                })


            })
            confirmsBtns.forEach((element) => {
                element.addEventListener("click", (e) => {
                    if (element.getAttribute("data-confirm") == "true") {
                        if (validateKey != "") {
                            DeleteItemFunction(
                                element.getAttribute("data-confirm")
                            );
                        }
                        setTimeout(() => {
                            dn_message.classList.add("active")
                            dn_message.classList.add("delete")
                        }, 100)
                    } else {
                        dn_message.classList.remove("active")
                    }


                });
            });

            async function PHPREQUEST(APIDOCS, form, loaderBtn) {
                let data;
                try {
                    form = document.querySelector('.event_menu_add form');
                    const formMain = new FormData(form);
                    controller = new AbortController();
                    const signal = controller.signal;
                    formMain.append('medium', document.querySelector('select[name="medium"').value);
                    const Request = await fetch(APIDOCS, {
                        method: "POST",
                        body: formMain,
                    });

                    if (Request.status === 200) {
                        data = await Request.json();
                        if (data) {
                            loaderBtn.innerText = data;
                        }
                    } else {
                        console.log("invalid link directory");
                    }
                } catch (error) {
                    console.error(error);
                }
            }
            async function PHPREQUESTDEL(APIDOCS, validateKey, validateName) {
                let data;
                try {
                    dn_message.querySelector('p').innerText = '...processing request';
                    dataSend = {
                        key: validateKey,
                        name: validateName
                    };
                    controller = new AbortController();
                    const signal = controller.signal;
                    const Request = await fetch(APIDOCS, {
                        method: "POST",
                        body: JSON.stringify(dataSend),
                        headers: {
                            "Content-Type": "application/json",
                        },
                    });

                    if (Request.status === 200) {
                        data = await Request.json(data);
                        if (data) {
                            dn_message.querySelector('p').innerText = data;

                            setTimeout(() => {
                                dn_message.classList.remove('delete');
                                dn_message.classList.remove('active');
                            }, 100);
                        }
                    } else {
                        console.log("cannot find endpoint");
                    }
                } catch (error) {
                    console.error(error);
                }
            }
            function UpdateItemFunction(value, ActivityMenu) {
                newObject = value.getAttribute("data-information");
                newObject = JSON.parse(newObject);
                document.querySelector(
                    '.event_menu_add input[name="name"]'
                ).value = newObject["name"];
                document.querySelector(
                    '.event_menu_add input[name="amount"]'
                ).value = newObject["amount"];
                document.querySelector(
                    '.event_menu_add input[name="Date"]'
                ).value = newObject["date"];
                document.querySelector(
                    '.event_menu_add input[name="delete_key"]'
                ).value = newObject["id"];
                document.querySelector(
                    '.event_menu_add input[name="formName"]'
                ).value = newObject["Formname"];
                document.querySelector(
                    '.event_menu_add select[name="medium"]'
                ).value = newObject["Medium"];

                AddEventMenu.classList.add("active");
                APIDOCS =
                    "../../API/finance/data_process.php?APICALL=event&&user=true&&submit=update";
            }

            function DeleteItemFunction() {
                APIDOCS =
                    "../../API/finance/data_process.php?APICALL=event&&user=true&&submit=delete";
                PHPREQUESTDEL(APIDOCS, validateKey, validateName)


            }
            const searchSystem = debounce(async (APIDOCS, value) => {
                let data;
                try {

                    dataSend = {
                        id: <?php echo $_GET['data_page']; ?>,
                        search: value,
                    };
                    const Request = await fetch(APIDOCS, {
                        method: "POST",
                        body: JSON.stringify(dataSend),
                        headers: {
                            "Content-Type": "application/json",
                        },
                    });
                    data = await Request.json(data);
                    if (Request.status === 200) {

                        if (data) {
                            Template = document.querySelector('.records_table tbody');
                            if (data != 'No Records Available' && data != 'Fetching data encounted a problem' && data != 'No record Found') {
                                let ObjectDataFrame = JSON.parse(data);
                                Template.innerHTML = "";

                                for (const key in ObjectDataFrame) {
                                    amount = ObjectDataFrame[key]['amount'];
                                    Name = ObjectDataFrame[key]['name'];
                                    gender = ObjectDataFrame[key]['gender'];
                                    contact = ObjectDataFrame[key]['contact'];
                                    Medium = ObjectDataFrame[key]['medium'];
                                    Record_date = ObjectDataFrame[key]['record_date'];
                                    id = ObjectDataFrame[key]['UniqueId'];
                                    ObjectData = ObjectDataFrame[key]['Obj'];
                                    namet = ObjectDataFrame[key]['Uname'];
                                    const CloneObject = document.querySelector('.CloneSearch tr').cloneNode(true);
                                    if (CloneObject != '') {
                                        const ElementDivCone = document.createElement('tr');
                                        CloneObject.querySelector('.Clonename').innerText = Name;
                                        CloneObject.querySelector('.Clonegender').innerText = gender;
                                        CloneObject.querySelector('.Clonerecord').innerText = Record_date;
                                        CloneObject.querySelector('.Clonecontact').innerText = contact;
                                        CloneObject.querySelector('.Cloneamount').innerText = amount;
                                        CloneObject.querySelector('.Clonemedium').innerText = Medium;
                                        CloneObject.querySelector('.opt_element p.up').setAttribute('data-information', ObjectData);
                                        CloneObject.querySelector('.opt_element p.up').setAttribute('Update_item', id);
                                        CloneObject.querySelector('.opt_element p.dp').setAttribute('delete_item', id);
                                        CloneObject.querySelector('.opt_element p.dp').setAttribute('delete_table', namet);
                                        ElementDivCone.innerHTML = CloneObject.innerHTML;
                                        Template.append(ElementDivCone);
                                        OptionElements = document.querySelectorAll(".option");
                                        const element = ElementDivCone.querySelector('.option');
                                        element.addEventListener("click", function () {
                                            var ElementOptions = element.querySelector(".opt_element");
                                            ElementOptions.classList.add("active");
                                        });
                                    } else {
                                        console.log('no clone')
                                    }


                                }

                            } else {
                                console.log('erl')
                                Template.innerHTML = "NO RECORD FOUND";
                            }
                        }
                    } else {
                        console.log("cannot find endpoint");
                    }
                } catch (error) {
                    console.error(error);
                }
            })
            function debounce(cb, delay = 1000) {
                let timeout

                return (...args) => {
                    clearTimeout(timeout)
                    timeout = setTimeout(() => {
                        cb(...args)
                    }, delay)
                }
            }
            Export_variables_Dialogue_Form.addEventListener('submit', function (e) {
                e.preventDefault();
            })
            Export_variables.onclick = function () {
                Export_variables_Dialogue.classList.add("active");
            };
            Export_variables_Dialogue_Btn.addEventListener('click', async function () {
                var loaderBtn = Export_variables_Dialogue.querySelector(".loader");
                loaderBtn.classList.add("active");
                var formConditions = Export_variables_Dialogue.querySelectorAll(".form_condition");
                console.log(ConditionFeilds(formConditions));
                if (ConditionFeilds(formConditions) != false) {
                    ExportType = Export_variables_Dialogue.querySelector('select[name="export_type"]').value;
                    ExportDataName = Export_variables_Dialogue.querySelector('input[name="export_name"]').value;
                    if (ExportType == 'excel') {
                        APIDOCS =
                            "../../API/finance/data_process.php?APICALL=true&&user=event&&submit=export_dues";
                        try {
                            let Id = document.querySelector('input[name="formName"]').value;
                            dataSend = {
                                num: 784750276,
                            };
                            const Request = await fetch(APIDOCS, {
                                method: "POST",
                                body: JSON.stringify(dataSend),
                                headers: {
                                    "Content-Type": "application/json",
                                },
                            });

                            if (Request.status === 200) {
                                data = await Request.json();
                                if (data) {
                                    var ExportData = data;
                                    if (ExportData != "Fetching data encounted a problem" && ExportData != "Not Records Available") {

                                        const ObjectDataFrame = JSON.parse(ExportData);
                                        if (ObjectDataFrame) {
                                            ExportString = "";
                                            jsonData = []
                                            for (const key in ObjectDataFrame) {
                                                Obj = {}
                                                amount = ObjectDataFrame[key]['amount'];
                                                Name = ObjectDataFrame[key]['name'];
                                                gender = ObjectDataFrame[key]['gender'];
                                                contact = ObjectDataFrame[key]['contact'];
                                                Medium = ObjectDataFrame[key]['medium'];
                                                date = ObjectDataFrame[key]['record_date'];
                                                id = ObjectDataFrame[key]['UniqueId'];
                                                name = ObjectDataFrame[key]['Uname'];

                                                Obj['Amount'] = amount;
                                                Obj['Name'] = name;
                                                Obj['date'] = date;
                                                Obj['contact'] = contact;
                                                Obj['gender'] = gender;
                                                Obj['Medium'] = Medium;
                                                jsonData.push(Obj);
                                            }

                                            const worksheet = XLSX.utils.json_to_sheet(jsonData);
                                            const workbook = XLSX.utils.book_new();
                                            XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");
                                            const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });

                                            const blob = new Blob([excelBuffer], { type: 'application/octet-stream' });
                                            const link = document.createElement('a');
                                            link.href = URL.createObjectURL(blob);
                                            link.download = ExportDataName + '.xlsx';
                                            document.body.appendChild(link);
                                            link.click();
                                            document.body.removeChild(link);

                                        }
                                    }

                                }
                            } else {
                                console.log("Cannot iniate Download");
                            }
                        } catch (error) {
                            console.error(error);
                        }
                    }

                }
            })
        </script>
    </body>

    </html>
    <?php
} else {
    echo "<header>Sorry, you are not allowed to access to the contents of this page, please contact your administrator</header>";
}
?>