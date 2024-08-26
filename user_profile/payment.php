<?php
$image = 0;
session_start();
if (isset($_SESSION['userImage'])) {
    $image = $_SESSION['userImage'];
} else {
    $image = "";
}

include_once('../API/userpage-api/autoloader.php');
$newDataRequest = new viewData();
$year = date('Y');
$unique_id = '1323332734';
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
                $data = json_decode($newDataRequest->transactionList_view($unique_id));
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

                                    if ($amount >= $paidAmount) {
                                        $paid += 1;
                                    } else {
                                        $part += 1;
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
                                    <p><span> Full payment <?php echo $totalVal; ?></span></p>
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

                        if ($amount >= $paidAmount) {
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
                        <p>' . $name . ' was uploaded on the ' . $date . ', total contribution for each individual is </p>
                        <p>' . $amount . '</p>
                    </div>
                   <button>Pay</button>

                </div>';
                        }

                    }
                    ?>

                </div>
            </div>
            <div class="status">
                <header>Payment Statistics</header>
                <div class="gauge" style="--percent:<?php echo 36 * ($totalVal / $paid * 10) ?>deg">
                    <div class="details">
                        <p><?php echo ($totalVal / $paid * 10) * 10 ?>%</p>
                    </div>

                </div>
                <div class="checklist">
                    <div class="flex item">
                        <i class="fas fa-check"></i>
                        <p>total dues</p>
                        <p><?php echo ($totalVal / $paid * 10) * 10 ?></p>
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