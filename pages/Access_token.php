<?php
include_once('../API/notifications & token & history/autoloader.php');
$newDataRequest = new viewData();
$condition = false;
if (isset($_SESSION['login_details'])) {
    $login_details = $_SESSION['login_details'];
    if (!isset($_SESSION['access_entryLog'])) {
        $date = date('Y-m-d H:i:s');
        $newquest = $newDataRequest->DataHistory($login_details, "Access page selection", $date, "Access page section", "Admin Viewed Access page section");
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

if ($condition) {
    ?>
    <div class="filter_wrapper relative" style="height:0px;">
    </div>


    <div class="Access">

        <div class="header_slider">
            <img src="../images/security.gif" alt="" />
        </div>
        <div class="access_token">
            <header>Generate an Access token to allow individual users access to the admin page, a
                limited
                number of times</header>
            <div class="timer_set">
                <div class="hour">00H</div>
                <div class="min">00m</div>
                <div class="second">00s</div>
            </div>
            <div class="token">

                <div class="tokenData flex" style="align-items:center;justify-content:center">
                    <h1>
                        <?php
                        $item = json_decode($newDataRequest->getoken());
                        echo "<input hidden id='value_data_set' value=" . $item . " />";
                        if ($item == 'empty') {
                            echo 'Z O E -';
                        } else if ($item == 'Fetching data encounted a problem') {
                            echo "error ocurred";
                        } else if ($item == 'expired') {
                            echo "<p>Generate a new code. The old one has reached it limit</p>";
                        } else {
                            echo "Code has Already been assigned";
                        }
                        ?>
                    </h1>
                    <div class="data"></div>
                </div>
                <?php
                if ($item == 'empty' || $item == 'expired') {
                    echo '<button>Generate and Assign token</button>';
                }
                ?>

            </div>
        </div>
    </div>
    <?php
} else {
    echo "<header>Sorry, you are currently disconnected from the admin privilege, please contact your administrator</header>";
}
?>