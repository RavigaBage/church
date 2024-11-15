<?php
session_start();
require '../../API/vendor/autoload.php';
include 'SvgPath.php';
$newDataRequest = new notification\viewData();
$val = 1;
$condition = false;
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}
if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];
    $token = $_SESSION['Admin_access'];
    $known = hash('sha256', $unique_id . 'admin');
    if ((hash_equals($known, $token))) {
        if (!isset($_SESSION['access_entryLog'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $newDataRequest->DataHistory($unique_id, "anouncement page selection", $date, "anouncement page section", "Admin Viewed Announcement page section");
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
} else {
    $condition = false;
}

if ($condition) {
    ?>

    <div class="profile_main">
        <div class="navigation Filter">
            <div class="filter_wrapper mini">
                <div style="height:40px;" class="flex">
                    <div class="ux_search_bar">
                        <button id="searchBtn"><i class="fas fa-search" aria-hidden></i></button>
                        <input type="search_data" type="search" id="searchInput" name="search"
                            placeholder="...search here" />
                    </div>
                </div>
            </div>
        </div>
        <div hidden>
            <div class='annc_item' id="CloneSearchS">
                <div class='flex button'>
                    <div class=' flex title'>
                        <h1 class="Clonename"></h1>
                        <div class='flex button Clonedate'><i class='fas fa-date'></i></div>
                    </div>
                </div>

                <div class='div_content'>
                    <p class="CloneM"></p>
                </div>
                <div class=' flex options title'>
                    <div class='edit flex'>
                        <i class='fas fa-edit Update_item up' data-information=''></i>
                        <p>Edit</p>
                        <div class='toggle_mode ' data-id=''>
                            <svg xmlns='http://www.w3.org/2000/svg' class='on' height='24' fill='green'
                                viewBox='0 -960 960 960' width='24'>
                                <path
                                    d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z' />
                            </svg>
                            <svg xmlns='http://www.w3.org/2000/svg' class='off' height='24' fill='red'
                                viewBox='0 -960 960 960' width='24'>
                                <path
                                    d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z' />
                            </svg>
                        </div>
                    </div>
                    <div class='edit flex'>
                        <i class='fas fa-trash delete_item dp' data-id=''></i>
                        <p>Remove</p>
                    </div>
                </div>

            </div>
            <div class='annc_item' id="CloneSearchB">
                <div class='flex'>
                    <img class="Clonefile" src='' alt='' />
                    <div class='img_details'>
                        <div class='flex button'>
                            <div class=' flex title'>
                                <h1 class="Clonename"></h1>
                                <div class='flex button Clonedate'><i class='fas fa-date'></i></div>
                            </div>
                        </div>
                        <div class='div_content'>
                            <p class="CloneM"></p>
                        </div>
                    </div>
                </div>
                <div class=' flex options title'>
                    <div class='edit flex'>
                        <i class='fas fa-edit Update_item up' data-information=''></i>
                        <p>Edit</p>
                        <div class='toggle_mode' data-id="">
                            <svg xmlns='http://www.w3.org/2000/svg' class='on' height='24' fill='green'
                                viewBox='0 -960 960 960' width='24'>
                                <path
                                    d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z' />
                            </svg>
                            <svg xmlns='http://www.w3.org/2000/svg' class='off' height='24' fill='red'
                                viewBox='0 -960 960 960' width='24'>
                                <path
                                    d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z' />
                            </svg>
                        </div>
                    </div>
                    <div class='edit flex'>
                        <i class='fas fa-trash delete_item dp' data-id=" "></i>
                        <p>Remove</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid_sx tithebook">
            <div class="profile">
                <div class="tithe_list ancc_list">
                    <?php
                    $data = $newDataRequest->viewList($val);
                    if ($data == 'No Records Available') {
                        echo '<h1 class="empty">Records of announcement Data is not available, upload them by clicking on the +new element</h1>';
                    } else
                        if ($data) {
                            $destructure = json_decode($data);
                            foreach ($destructure as $item) {
                                $object = new stdClass();
                                $object->id = $item->Id;
                                $object->title = $item->name;
                                $object->receiver = $item->receiver;
                                $object->date = $item->date;
                                $object->message = $item->message;

                                $objectFile = htmlspecialchars(json_encode($object), ENT_QUOTES);
                                $status = "";
                                if ($item->status == 'active') {
                                    $status = 'active';
                                }

                                if ($item->file == " " || $item->file == "") {
                                    echo "<div class='annc_item'>
                                        <div class='flex button'>
                                            <div class=' flex title'>
                                                <h1>$item->name</h1>
                                                <div class='flex button'><i class='fas fa-date'></i>$item->date </div>
                                            </div>
                                        </div>
                    
                                        <div class='div_content'>
                                            <p> $item->message</p>
                                        </div>
                                        <div class=' flex options title'>
                                            <div class='edit flex'>
                                                <i class='fas fa-edit Update_item' data-id=" . $item->Id . " data-information='" . $objectFile . "'></i>
                                                <p>Edit</p>
                                                <div class='toggle_mode $status' data-id='$item->Id'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' class='on' height='24' fill='green'
                                                        viewBox='0 -960 960 960' width='24'>
                                                        <path
                                                            d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z' />
                                                    </svg>
                                                    <svg xmlns='http://www.w3.org/2000/svg' class='off' height='24' fill='red'
                                                        viewBox='0 -960 960 960' width='24'>
                                                        <path
                                                            d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z' />
                                                    </svg>
                                                </div>
                                            </div>                        
                                            <div class='edit flex'>
                                                <i class='fas fa-trash delete_item' data-id='$item->Id'></i>
                                                <p>Remove</p>
                                            </div>
                                        </div>
                    
                                    </div>";
                                } else {
                                    $path = '../../API/images/annc/' . $item->file . '';
                                    $svg = $svg_path;
                                    if (!file_exists('../../../API/images/annc/' . $item->file . '')) {
                                        $path_img = $svg;
                                    } else {
                                        $path_img = '<img src=' . $path . ' alt="image file" />';
                                    }

                                    echo
                                        "
                            <div class='annc_item'>
                               <div class='flex'>
                               " . $path_img . "
                                <div class='img_details'>
                                    <div class='flex button'>
                                     <div class=' flex title'>
                                         <h1>" . $item->name . "</h1>
                                         <div class='flex button'><i class='fas fa-date'></i>" . $item->date . "</div>
                                     </div>
                                    </div>
                                    <div class='div_content'>
                                     <p>" . $item->message . "</p>
                                    </div>
                                </div>
                              </div> 
                                <div class=' flex options title'>
                                <div class='edit flex'>
                                    <i class='fas fa-edit Update_item' data-id=' . $item->Id . ' data-information='" . $objectFile . "'></i>
                                    <p>Edit</p>
                                     <div class='toggle_mode' data-id=' . $item->Id . '>
                                        <svg xmlns='http://www.w3.org/2000/svg' class='on' height='24' fill='green'
                                            viewBox='0 -960 960 960' width='24'>
                                            <path
                                                d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z' />
                                        </svg>
                                        <svg xmlns='http://www.w3.org/2000/svg' class='off' height='24' fill='red'
                                            viewBox='0 -960 960 960' width='24'>
                                            <path
                                                d='M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z' />
                                        </svg>
                                    </div>
                                </div>                        
                                <div class='edit flex'>
                                    <i class='fas fa-trash delete_item' data-id=' . $item->Id . '></i>
                                    <p>Remove</p>
                                </div>
                                </div>
                            </div>                       
                                ";
                                }

                            }
                        }

                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="info_information event_menu_add"
        style="height:300px; width:500px; padding:10px;text-wrap:wrap;display:grid;place-items:center;">
        <header class="danger"></header>
    </div>

    <div class="event_menu_add form_data">
        <header>Create Notification</header>
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
        <form>
            <div class="container_event">
                <div class="field">
                    <label>Tile</label>
                    <input type="text" name="name" />
                </div>
                <div class="field_e">
                    <label>Enter message</label>
                    <textarea name="message">...</textarea>
                </div>
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

                <div class="field">
                    <label>Send-to</label>
                    <select name="receiver">
                        <option value="all">Every member</option>
                        <?php
                        $data = json_decode($newDataRequest->ministries_viewList());
                        if (is_object($data)) {

                            foreach ($data as $item) {
                                $unique_id = $item->UniqueId;
                                $name = $item->name;
                                $members = $item->members;
                                echo '<option value=' . $unique_id . '>' . $name . ' - ' . $members . '</option>';
                            }

                        } else {
                            echo '<option class="danger">No groups available</option>';
                        }

                        ?>
                    </select>
                </div>
                <div class="cate_view">
                    <div class="field">
                        <label>Schedule Update</label>
                        <input type="date" name="date" />
                    </div>
                    <div class="field" style="display:flex;gap:10px;align-items:center;">
                        <label>Send an email</label>
                        <input type="checkbox" name="email" style="width:20px;" />
                    </div>
                </div>
                <input hidden name="delete_key" type="number" />
                <button>Record message</button>
            </div>
        </form>
    </div>

    <div class="add_event" data-menu="event">
        <i>+</i>
        <p>New</p>
    </div>


    <div class="page_sys">
        <?php
        if (isset($_SESSION['total_pages_annc'])) {
            $total = $_SESSION['total_pages_annc'];
        } else {
            $total = $newDataRequest->anncPages();
            $_SESSION['total_pages_annc'] = $total;
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
                        $num = 2;
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
                            echo '<div>' . $final . '</div>';
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