<?php
include_once('../../API/Assets&projects/autoloader.php');
$newDataRequest = new viewData();
$val = 1;
$year = "";
if (isset($_GET['year'])) {
    $year = $_GET['year'];
}

if (isset($_GET['page'])) {
    $val = $_GET['page'];
}

?>
<div class="event_menu_add">
    <form encryption="multipart/form">
        <header>Assets form</header>
        <div class="container_event">
            <p style="color:crimson;font-size:18px;text-align:center" class="error_information"></p>
            <div class="cate_view_e">
                <div class="field">
                    <label>Assets name</label>
                    <input name="name" type="text" placeholder="" value="" required />
                </div>

                <div class="field">
                    <label>Source</label>
                    <input name="source" type="text" placeholder="" value="" required />
                </div>

                <div class="field">
                    <label class="input_date">Date</label>
                    <input name="date" type="date" placeholder="" value="" required />
                </div>
            </div>
            <div class="cate_view_e">
                <div class="field">
                    <label>Total number</label>
                    <input name="total" type="number" placeholder="" value="" required />
                </div>
                <div class="field">
                    <label>Current location</label>
                    <input name="location" type="text" placeholder="" value="" required />
                </div>
                <div class="field">
                    <label>value</label>
                    <input name="value" type="text" placeholder="" value="" required />
                </div>
            </div>

            <div class="cate_view">
                <div class="field">
                    <label>Select file</label>
                    <input name="imageFile" type="file" value="" />
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
            </div>
            <div class="field_e">
                <label>Description</label>
                <textarea name="description">..description this valuable...</textarea>
            </div>

            <input name="delete_key" type="text" value="" hidden />
            <button>Record Asset</button>
        </div>
    </form>
</div>

<div class="add_event" data-menu="event">
    <i>+</i>
    <p>New</p>
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

<div class="assets_page">
    <div class="content_pages">
        <div class="content_page_event">
            <div class="records_table">
                <table>
                    <?php
                    $data = "";
                    if ($year == "") {
                        $data = json_decode($newDataRequest->viewList($val));
                        ;
                    } else {
                        $data = json_decode($newDataRequest->viewListFilter($year));
                    }

                    if ($data == "" || $data == 'Error Occurred' || $data == 'No records available') {
                        echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                    } else {
                        echo "<thead>
                        <tr>
                            <th>Itemname</th>
                            <th>Source</th>
                            <th>location</th>
                            <th>Worth ($)</th>
                            <th>Status</th>
                            <th>...</th>
                        </tr>
                    </thead><tbody>";
                        foreach ($data as $item) {
                            $unique_id = $item->id;
                            $name = $item->name;
                            $Source = $item->source;
                            $Location = $item->location;
                            $Items = $item->total;
                            $date = $item->date;
                            $status = $item->status;
                            $value = $item->value;
                            $Image = $item->Image;
                            $message = $item->About;
                            $ObjectData = $item->Obj;
                            echo "<tr>
                    <td><div class='details'>
                 <div class='img'>
                 <img src='../API/Images_folder/Assets/" . $Image . "' alt='asset file'/>
                 </div>
                 <div class='text'>
                 <p> " . $name . "</p>
                 <p> " . $Items . "</p>
                 </div>
                 
                 </div>
                 </td>
                     <td class='td_action'> " . $Source . " </td>
                     <td class='td_action'> " . $value . " </td>
                     <td class='td_action'>Cote d'voire</td>
                     
                     <td><div class='in_btn'><div></div>Active</div></td>
                     <td class='option'>
                         <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960' width='48'>
                             <path
                                 d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                         </svg>
                         <div class='opt_element'>
                             <p class='delete_item' data-id=" . $unique_id . ">Delete item <i></i></p>
                             <p class='Update_item' data-id=" . $unique_id . " data-information='" . $ObjectData . "'>Update item <i></i></p>
                         </div>
                     </td>
                 </tr>";
                        }
                    }
                    echo '</tbody>'
                        ?>

                </table>
            </div>
        </div>
    </div>

</div>

<div class="page_sys">
    <?php
    $total = $newDataRequest->ProjectsPages();
    ?>
    <header>
        <?php
        if ((round($total / 6)) > 1) {
            echo 'Pages:';
        }
        ?>
        <div class="pages">
            <?php
            $total = $newDataRequest->AssetPages();
            $loop = 0;
            if ((round($total / 6)) > 1) {
                if (($total / 6) > 6) {
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
                    echo '<span>......</span><div>' . $total . '</div>';
                }
            }
            ?>
        </div>
    </header>
</div>