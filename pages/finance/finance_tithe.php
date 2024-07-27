<?php
include_once ('../../API/finance/autoloader.php');
$newDataRequest = new viewData();
if(isset($_GET['data_page'])){
$num = $_GET['data_page'];
}else{
    $num = 1;
}
?>

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
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" ><path d="M400-240v-80h160v80H400ZM240-440v-80h480v80H240ZM120-640v-80h720v80H120Z"/></svg>
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
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M720-80q-50 0-85-35t-35-85q0-7 1-14.5t3-13.5L322-392q-17 15-38 23.5t-44 8.5q-50 0-85-35t-35-85q0-50 35-85t85-35q23 0 44 8.5t38 23.5l282-164q-2-6-3-13.5t-1-14.5q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35q-23 0-44-8.5T638-672L356-508q2 6 3 13.5t1 14.5q0 7-1 14.5t-3 13.5l282 164q17-15 38-23.5t44-8.5q50 0 85 35t35 85q0 50-35 85t-85 35Zm0-640q17 0 28.5-11.5T760-760q0-17-11.5-28.5T720-800q-17 0-28.5 11.5T680-760q0 17 11.5 28.5T720-720ZM240-440q17 0 28.5-11.5T280-480q0-17-11.5-28.5T240-520q-17 0-28.5 11.5T200-480q0 17 11.5 28.5T240-440Zm480 280q17 0 28.5-11.5T760-200q0-17-11.5-28.5T720-240q-17 0-28.5 11.5T680-200q0 17 11.5 28.5T720-160Zm0-600ZM240-480Zm480 280Z"/></svg>
                <p>Share</p>
            </div>
            <div class="item_opt flex">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M640-640v-120H320v120h-80v-200h480v200h-80Zm-480 80h640-640Zm560 100q17 0 28.5-11.5T760-500q0-17-11.5-28.5T720-540q-17 0-28.5 11.5T680-500q0 17 11.5 28.5T720-460Zm-80 260v-160H320v160h320Zm80 80H240v-160H80v-240q0-51 35-85.5t85-34.5h560q51 0 85.5 34.5T880-520v240H720v160Zm80-240v-160q0-17-11.5-28.5T760-560H200q-17 0-28.5 11.5T160-520v160h80v-80h480v80h80Z"/></svg>
            <p>Print</p>
            </div>

           
            

            <div class="item_opt flex">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368"><path d="M480-320 280-520l56-58 104 104v-326h80v326l104-104 56 58-200 200ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z"/></svg>
            <p>Export</p>
            </div>
        </div>
    </div>
</div>

<div class="content_pages">
    <div class="content_page_event">
        <div class="add_event">
            <i>+</i>
            <p>New</p>
        </div>

        <div class="records_table">
        <table>
                
                <?php
                    $data = $newDataRequest->TitheData($num); 

                    if($data == "" || $data == 'Error Occurred' || $data == 'Not Records Available'){
                        echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                    }else{
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
                        print_r($data);
                        echo "</tbody>";
                    }
                ?>
                 
                

            </table>

        </div>
    </div>
</div>
<div class="event_menu_add">
    <form>
    <header>New Activity</header>
    <h1 class="loader"></h1>
    <div class="container_event">
        <div class="field">
            <label>User - name</label>
            <select class="form_condition" name="Name">
                <option value=""></option>
                <?php
                $total_name = $newDataRequest->Records_usernames();
                echo $total_name;
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
        <input hidden  name="delete_key" />
    </div>
    </form>
</div>

<div class="page_sys">
                    <?php
                    $total = $newDataRequest->Trans_Pages();
                    if($total !=  'Error Occurred'){
                    ?>
                    <header>
                        <?php

                        if ((round($total / 6)) > 1) {
                            echo 'Pages:';
                        }
                        ?>
                        <div class="pages">
                            <?php
                            
                            $loop = 0;
                            if ((round($total / 6)) > 1) {
                                if ($total > 6) {
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
                                    echo '<span>......</span><div>' . ($total / 6) . '</div>';
                                }
                            }
                            ?>
                        </div>
                    </header>
                    <?php               
                        }
                    ?>
</div>