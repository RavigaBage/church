<?php
session_start();
include_once('../API/userpage-api/autoloader.php');
$newDataRequest = new viewData();
$year = date('Y');
$unique_id = $_SESSION['unique_id'];
$num = 1;

if (isset($_GET['pages'])) {
    $num = $_GET['pages'];
}
$data = json_decode($newDataRequest->NotificationSet($unique_id));
if ($data == "" || $data == 'Error Occurred' || $data == 'No Records Available' || $data == false) {
    echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
} else {
    ?>
    <header>Announcement List</header>
    <div class="grid_sx tithebook">
        <div class="profile">
            <div class="tithe_list ancc_list">
                <?php
                $data = json_decode($newDataRequest->Notification_viewList($unique_id, $num));
                if ($data == "" || $data == 'Error Occurred' || $data == 'No Records Available') {
                    echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                } else {
                    foreach ($data as $item) {
                        $name = $item->title;
                        $message = $item->message;
                        $date = $item->date;
                        $fileName = $item->file;

                        if ($fileName == "" || $fileName == " ") {
                            echo '
                            <div class="annc_item">
                    <div class="flex button">
                        <div class="flex title">
                            <h1>' . $name . '</h1>
                            <div class="flex button"><i class="fas fa-clock"></i><span>' . $date . '</span></div>
                        </div>
                    </div>

                    <div class="div_content">
                        <p>' . $message . '</p>
                    </div>
                </div>';
                        } else {
                            echo ' 
                            <div class="flex annc_item">
                                <img src="../API/images/annc/' . $fileName . '" alt="" />
                                <div class="img_details">
                                    <div class="flex button">
                                        <div class="flex title">
                                            <h1>' . $name . '</h1>
                                            <div class="flex button"><i class="fas fa-clock"></i><span>' . $date . '</span></div>
                                        </div>
                                    </div>
                                    <div class="div_content">
                                        <p>lorem episum' . $message . '</p>
                                    </div>
                                </div>
                            </div>';
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="page_sys">
        <?php
        if (isset($_SESSION['total_user_notification'])) {
            $total = $_SESSION['total_user_notification'];
        } else {
            $total = $newDataRequest->Notification_viewList_pages();
            $_SESSION['total_user_notification'] = $total;
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
}
?>