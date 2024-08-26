<?php
include_once('../API/userpage-api/autoloader.php');
$newDataRequest = new viewData();
$year = date('Y');
if (isset($_GET['page'])) {
    $num = $_GET['page'];
} else {
    $num = 1;
}
$unique_id = '1323332734';
?>
<div class="profile_main">
    <header>Tithe Status</header>
    <div class="grid_sx tithebook">
        <div class="profile">
            <div class="flex profile_status">
                <div class=" flex title">
                    <p></p>
                    <div class="flex button"><i class="fas fa-credit-card"></i>pay tithe</div>
                </div>
            </div>
            <div class="month_image">
                <img src="images/download.jpeg" alt="" />
            </div>
            <div class="tithe_list">
                <?php
                $data = json_decode($newDataRequest->Tithe_viewList($unique_id, $num));
                if ($data == "" || $data == 'Error Occurred' || $data == 'No Records Available') {
                    echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                } else {
                    echo '<table>
                    <thead>
                    <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>payment</th>
                    <th>client</th>
                    </tr>
                    </thead>
                    <tbody>';
                    foreach ($data as $item) {
                        $id = $item->id;
                        $name = $item->name;
                        $payment = $item->payment;
                        $date = $item->date;
                        $amount = $item->amount;


                        echo '<tr>
                    <td>' . date($date) . '</td>
                    <td>' . $amount . '</td>
                    <td>' . $payment . '</td>
                    <td>' . $name . '</td>
                </tr>';
                    }
                    echo '</tbody></table>';
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