<?php
include_once('../API/userpage-api/autoloader.php');
$newDataRequest = new viewData();
$year = date('Y');
$unique_id = '1323332734';
?>
<header>Announcement List</header>
<div class="grid_sx tithebook">
    <div class="profile">
        <div class="tithe_list ancc_list">
            <?php
            $data = json_decode($newDataRequest->Notification_viewList($unique_id));
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