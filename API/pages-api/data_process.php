<?php
require '../vendor/autoload.php';
$pdh = new ChurchApi\viewData;

if ($_GET['notification']) {
    $data = file_get_contents("php://input");
    $sitename = $data['sitename'];
    $title = $date['title'];
    $resultFetch = $pdh->notification_set($sitename, $title);
    echo json_encode(["status" => "success", "message" => $resultFetch]);

}
