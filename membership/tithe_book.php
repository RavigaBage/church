<?php
session_start();
require '../API/vendor/autoload.php';
$newDataRequest = new UserApi\viewData();
$year = date('Y');
if (isset($_GET['page'])) {
    $num = $_GET['page'];
} else {
    $num = 1;
}
$val = $num;
$unique_id = $_SESSION['unique_id'];
$images = ['bkg_01_january.jpg', 'bkg_02_february.jpg', 'bkg_03_march.jpg', 'bkg_04_april.jpg', 'bkg_05_may.jpg', 'bkg_06_june.jpg', 'bkg_07_july.jpg', 'bkg_08_august.jpg', 'bkg_09_september.jpg', 'bkg_10_october.jpg', 'bkg_11_november.jpg', 'bkg_12_december.jpg'];
$rand = date('m');
$selected_image_session = $images[$rand - 1];
?>
<div class="profile_main">
    <header>Tithe Status <a href="../payment/?tithe" target="_blank"><button>Add tithe</button></header></a>
    <div class="grid_sx tithebook">
        <div class="profile">
            <div class="tithe_list">
                <?php
                $data = json_decode($newDataRequest->Tithe_viewList($unique_id, $num));
                if ($data == "" || $data == 'Error Occurred' || $data == 'No Records Available') {
                    echo "<header class='danger'>You do not have any available data, if you know you should have data, contact the finance official to sort this problem</header>";
                } else {
                    $Old_date = 0;
                    foreach ($data as $item) {

                        $id = $item->id;
                        $name = $item->name;
                        $payment = $item->payment;
                        $date = $item->date;
                        $amount = $item->amount;
                        $month = $item->month;
                        $year = $item->year;

                        if ($year != $Old_date) {
                            $Old_date = $year;
                            echo
                                '<div class="month_image">
                                        <img src="images/' . $selected_image_session . '" alt="" />
                                    </div>
                                    <header>' . $year . '</header>
                                    ';

                        }
                        echo '
                            <div class="flex item">
                            <div class="date">
                            <p>' . $month . '</p>
                            </div>
                            <div class="tithe_content">
                            <p>Tithe on the ' . $date . ' was paid through an/a ' . $payment . ' medium</p>
                            <p> A total of <b>' . $amount . '</b> was recorded on the name ' . $name . '</p>
                            </div>
                            </div>';

                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<div class="page_sys">
    <?php

    if (isset($_SESSION['total_pages_userTithe'])) {
        $total = $_SESSION['total_pages_userTithe'];
    } else {
        $total = $newDataRequest->TithePages($unique_id);
        $_SESSION['total_pages_userTithe'] = $total;
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