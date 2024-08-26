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
    <header>Functions and ministries</header>
    <div class="grid_sx">
        <div class="profile">
            <div class="flex profile_status">
                <div class="cover">
                    <img src="../API/Images_folder/users/<?php echo $image; ?>" alt="" id="cover_profile" />
                </div>
            </div>
            <div class="personal_details">
                <?php
                $data = json_decode($newDataRequest->ministries_viewList($unique_id));
                if ($data == "" || $data == 'Error Occurred' || $data == 'No Records Available') {
                    echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                } else {

                    foreach ($data as $item) {
                        $name = $item->name;
                        $membership = $item->membership;
                        $date = $item->date;
                        $position = $item->position;


                        echo '<div class="personal_details_info">
                    <div class=" flex title">
                        <p>' . $name . '</p>
                        <div class="flex button"><i class="fas fa-calenda"></i>2024, 04, 16</div>
                    </div>
                    <div class="info">
                        <div class="feild">
                            <label>Initiation</label>
                            <p>' . $date . '</p>
                        </div>
                        <div class="feild">
                            <label>Position</label>
                            <p>' . $position . '</p>
                        </div>
                        <div class="feild">
                            <label>Membership</label>
                            <p>' . $membership . '</p>
                        </div>
                    </div>
                </div>';
                    }
                }
                ?>
            </div>
        </div>
        <div class="status">
            <header>
                Access Page Information
                <p>This page, list the various departments / ministries you belong to, including your influence or
                    position in the ministr.
                </p>
            </header>
        </div>
    </div>
</div>