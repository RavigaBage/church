<?php
include_once('../API/userpage-api/autoloader.php');
session_start();
$newDataRequest = new viewData();
$unique_id = "1375845742";
$passkey = "test1";

echo $newDataRequest->password_update_request($unique_id, $passkey);

?>