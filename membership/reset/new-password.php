<?php
session_start();
include_once('../../API/userpage-api/autoloader.php');
$newDataRequest = new viewData();
if (isset($_GET['request'])) {
    $token = $_GET['request'];
    $unique_id = $newDataRequest->password_fetch_id_user($token);
    if (intVal($unique_id)) {
        if (hash_equals($token, hash('sha256', $unique_id))) {
            ?>
            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <title>Create a New Password</title>
                <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <link rel="stylesheet" href="style.css">
            </head>

            <body>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 offset-md-4 form">
                            <form action="new-password.php?request=<?php echo $_GET['request']; ?>" method="POST"
                                autocomplete="off">
                                <h2 class="text-center">New Password</h2>
                                <?php
                                if (isset($_POST['change-password'])) {
                                    $passkey = "test1";
                                    $unique_id = '1375845742';
                                    echo $newDataRequest->password_update_request($unique_id, $passkey);
                                }
                                ?>
                                <?php

                                ?>
                                <div class="form-group">
                                    <input class="form-control" type="password" name="password" placeholder="Create new password"
                                        required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="password" name="cpassword" placeholder="Confirm your password"
                                        required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control button" type="submit" name="change-password" value="Change">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </body>

            </html>

            <?php
        } else {
            echo 'invalid';
        }
    } else {
        echo 'invalid';
    }
} else {
    echo 'invalid';
}
?>