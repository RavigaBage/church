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
    <header>Transaction Status</header>
    <div class="grid_sx tithebook">
        <div class="profile">
            <div class="flex profile_status">
                <div class=" flex title">
                    <p></p>
                    <div class="flex button"><i class="fas fa-credit-card"></i>Transaction Records</div>
                </div>
            </div>

            <div class="tithe_list">
                <?php
                $data = json_decode($newDataRequest->paymentList_view($unique_id));
                if ($data == "" || $data == 'Error Occurred' || $data == 'No Records Available') {
                    echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                } else {
                    echo '<table>
                    <thead>
                    <tr>
                    <th>Webpage</th>
                    <th>Gateway</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>';

                    foreach ($data as $item) {
                        $webpage = $item->webpage;
                        $gateway = $item->gateway;
                        $status = $item->status;
                        $date = $item->date;
                        $time = $item->time;
                        $amount = $item->amount;

                        echo '<tr>
                    <td>
                        <h1>' . $webpage . '</h1>
                    </td>
                    <td>
                        <p>' . $gateway . '</p>
                    </td>
                    <td>
                        <p>' . $status . '</p>
                    </td>
                    <td>
                        <p>' . $date . '</p>
                    </td>
                    <td>
                        <p>' . $time . '</p>
                    </td>
                    <td>
                        <p>' . $amount . '</p>
                    </td>
                    
                </tr><tr>
                    <td>
                        <h1>' . $webpage . '</h1>
                    </td>
                    <td>
                        <p>' . $gateway . '</p>
                    </td>
                    <td>
                        <p>' . $status . '</p>
                    </td>
                    <td>
                        <p>' . $date . '</p>
                    </td>
                    <td>
                        <p>' . $time . '</p>
                    </td>
                    <td>
                        <p>' . $amount . '</p>
                    </td>
                    
                </tr>';

                    }
                    echo '</tbody></table>';
                }
                ?>

            </div>
        </div>

    </div>
</div>