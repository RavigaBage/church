<?php
include_once ('../../API/finance/autoloader.php');
$newDataRequest = new viewData();
$val = 1;
$valO = 1;
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}

if (isset($_GET['pageO'])) {
    $valO = $_GET['pageO'];
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
        <div class="Filter item_opt flex filterBtn">
            <i class="fas fa-filter"></i>
            <p>Filter</p>
        </div>
        <div class="notification_list_filter">
            <div class="item" data-filter='modified'>
                <h1>Modified</h1>
            </div>

            <div class="item" data-filter='Ascending'>
                <h1>Ascending</h1>
            </div>

            <div class="item" data-filter='Descending'>
                <h1>Descending</h1>
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


<div class="slider_menu_main">
    <div class="slider_menu">
        <div class="menu event active">
            <header class="title">Contrbutions & Dues tracker</header>
            <div class="container_item">
                <?php
                print_r($newDataRequest->ListDataDues($val))
                ?>
                <div class="page_sys">
                    <?php
                    $total = $newDataRequest->DuesPages();
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
                </div>

            </div>
        </div>

        <div class="menu account">
            <header class="title">Offertory tracker</header>
            <div class="container_item">
                <?php
                print_r($newDataRequest->ListData($valO))
                ?>
                <div class="page_sys">
                    <?php
                    $total = $newDataRequest->DuesPages();
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
                </div>
            </div>
        </div>
    </div>
</div>
<div class="event_menu_add">
    <form>
                    <header>New Activity</header>
                    <div class="loader">.....loading data please wait</div>
                    <div class="container_event">
                        <div class="field">
                            <label>Event name</label>
                            <input type="text" class="form_condtion" name="event" placeholder="specify a name eg:sunday / tarry night / missionary night" />
                        </div>
                        <div class="cate_view">
                            <div class="field">
                                <label>Amount</label>
                                <input type="number" class="form_condtion" name="amount" placeholder="specify the amount collected without any symbols eg $" />
                            </div>
                            <div class="field">
                                <label>Activity date</label>
                                <input type="date" class="form_condtion" name="Date" placeholder="" />
                            </div>
                        </div>
                        <div class="field_e">
                            <label>Activity description</label>
                            <textarea class="form_condtion" name="description"></textarea>
                        </div>
                        <input hidden class="form_condtion" name="delete_key" />
                        <button>create Activity</button>
                    </div>
                </form>
</div>
<div class="event_menu_add main">
    <form>
    <header>New Activity</header>
                    <div class="loader">.....loading data please wait</div>
                    <div class="container_event">
                        <div class="cate_view">
                            <div class="field">
                                <label>Name</label>
                                <input type="text" class="form_condition" name="event" placeholder="please add a name..."/>
                            </div>
                            <div class="field">
                                <label>category</label>
                                <select class="form_condition" name="category">
                                    <option>Select category</option>
                                    <option>All users</option>
                                    <option>presbytery</option>
                                    <option>Department</option>
                                </select>
                            </div>
                        </div>
                        <div class="cate_view">
                            <div class="field">
                                <label>Amount</label>
                                <input type="text" class="form_condition" name="amount" placeholder="" />
                            </div>
                            <div class="field">
                                <label>Activity due date</label>
                                <input type="date" class="form_condition" name="date" placeholder="" />
                            </div>
                        </div>
                        <div class="field_e">
                            <label>Activity description</label>
                            <textarea class="form_condition" name="description"></textarea>
                        </div>
                        <input hidden class="form_condition" name="delete_key" />
                        <button>create Activity</button>
                    </div>
    </form>
</div>
<div class="add_event" data-menu="event">
<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160Zm40 200q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                    <p>New</p>
</div>


