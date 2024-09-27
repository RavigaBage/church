<?php
session_start();
include_once('../API/userpage-api/autoloader.php');
$newDataRequest = new viewData();
$year = date('Y');
if (isset($_GET['page'])) {
    $num = $_GET['page'];
} else {
    $num = 1;
}
$unique_id = $_SESSION['unique_id'];
?>
<div class="profile_main">
    <header>Tithe Status <button>Add tithe</button></header>
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
                                        <img src="images/download.jpeg" alt="" />
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
    $total = $newDataRequest->TithePages($unique_id);
    if ($total != 'Error Occurred') {
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