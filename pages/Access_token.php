<?php
include_once ('../API/notifications & token & history/autoloader.php');
$newDataRequest = new viewData();

?>

<div class="Access">

    <div class="header_slider">
    </div>
    <div class="access_token">
        <header>Generate an Access token to allow individual users access to the admin page, a
            limited
            number of times</header>
        <div class="timer_set">
            <div class="hour">13H</div>
            <div class="min">24m</div>
            <div class="second">24s</div>
        </div>
        <div class="token">

            <div class="tokenData flex">
                <h1>
                    <?php
                    $item = $newDataRequest->getoken();
                    if ($item == 'empty') {
                        echo 'Z O E-';
                    } else if ($item == 'Fetching data encounted a problem') {
                        echo "error ocurred";
                    } else {
                        echo "Code has Already been assigned";
                        echo "<input hidden id='value_data_set' value=" . $item . " />";
                    }
                    ?>
                </h1>
                <div class="data"></div>
            </div>
            <button>Generate and Assign token</button>
        </div>
    </div>
</div>