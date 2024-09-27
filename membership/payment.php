<?php
$image = 0;
session_start();
include_once('../API/userpage-api/autoloader.php');
$newDataRequest = new viewData();
$num = 1;
if (isset($_GET['pages'])) {
    $numPages = $_GET['pages'];
}
if (isset($_SESSION['userImage'])) {
    $image = $_SESSION['userImage'];
} else {
    $image = "";
}
$year = date('Y');
$unique_id = $_SESSION['unique_id'];
?>
<div class="profile_main">
    <header>Payment Status</header>
    <div class="grid_sx">
        <div class="profile">
            <div class="flex profile_status">
                <div class="cover">
                    <img src="../API/Images_folder/users/<?php echo $image; ?>" alt="" id="cover_profile" />
                </div>
                <?php
                $data = json_decode($newDataRequest->transactionList_view($unique_id, $num));
                if ($data == "" || $data == 'Error Occurred' || $data == 'No Records Available') {
                    echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                } else {
                    ?>
                    <div class="details personal_details">
                        <div class="personal_details_info">
                            <div class=" flex title">
                                <p>Details</p>
                            </div>
                            <div class="info">
                                <?php
                                $totalVal = 0;
                                $paid = 0;
                                $part = 0;
                                foreach ($data as $item) {
                                    $amount = $item->amount;
                                    $paidAmount = $item->status;


                                    if ($paidAmount >= $amount) {
                                        $paid += 1;
                                    } else {
                                        if ($paidAmount > 0) {
                                            $part += 1;
                                        }

                                    }
                                    $totalVal += 1;
                                }
                                ?>

                                <div class="feild">
                                    <label>Dues</label>
                                    <p><span><?php echo $paid; ?></span> / <?php echo $totalVal; ?></p>
                                </div>

                                <div class="feild">
                                    <label>Dues details</label>
                                    <p><span> part payment <?php echo $part; ?></span></p>
                                </div>
                                <div class="feild">
                                    <label>Dues details</label>
                                    <p><span>full payment <?php echo $paid; ?></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="payment_list">
                    <?php
                    foreach ($data as $item) {
                        $name = $item->name;
                        $amount = $item->amount;
                        $date = $item->date;
                        $department = $item->department;
                        $paidAmount = $item->status;

                        if ($paidAmount >= $amount) {
                            echo '<div class="item">
                    <div class="item_name">
                        <h1>' . $name . '</h1>
                    </div>
                    <div class="item_year">
                        <p>' . $name . ' was uploaded on the ' . $date . ', total contribution for each individual is </p>
                        <p>' . $amount . '</p>
                    </div>
                    <p class="unchecked "><i class="fas fa-check"></i>Completed</p>

                </div>';
                        } else {
                            echo '<div class="item">
                    <div class="item_name">
                        <h1>' . $name . '</h1>
                    </div>
                     <div class="item_year">
                        <p>' . $name . ' was uploaded on the ' . $date . ', total contribution for each individual is <b>' . $amount . '</b>, you have currently recorded <b>' . $paidAmount . '</b> as payment, you have
                        ' . ($amount - $paidAmount) . ' to pay </p>
                        <p>Total amount - <b>' . $amount . '</b>. Paid amount- <b>' . $paidAmount . '</b></p>
                    </div>
                   <button>Pay</button>

                </div>';
                        }

                    }
                    ?>

                </div>


                <div class="page_sys">
                    <?php
                    if (isset($_SESSION['total_user_payment'])) {
                        $total = $_SESSION['total_user_payment'];
                    } else {
                        $total = $newDataRequest->transactionList_view_pages();
                        $_SESSION['total_user_payment'] = $total;
                    }
                    if ($total != 'Error Occurred') {
                        if (is_numeric($total)) {
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
                    }
                    ?>
                </div>
            </div>
            <div class="status">
                <header>Payment Statistics</header>
                <div class="gauge" style="--percent:<?php echo 36 * ((100 * $paid / $totalVal) / 10) ?>deg">
                    <div class="details">
                        <p><?php echo number_format(((100 * $paid / $totalVal) / 10) * 10, 1) ?>%</p>
                    </div>

                </div>
                <div class="checklist">
                    <div class="flex item">
                        <i class="fas fa-check"></i>
                        <p>total dues</p>
                        <p><?php echo number_format(((100 * $paid / $totalVal) / 10) * 10, 1) ?></p>
                    </div>
                    <div class="flex item uncheck welfare">
                        <button>Add welfare</button>
                    </div>

                </div>
            </div>
            <?php
                }
                ?>
    </div>
</div>