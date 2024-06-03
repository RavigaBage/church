<?php
include ('../notifications%token%history/autoloader.php');
include ('user_check.php');
date_default_timezone_set('UTC');
$year = date('Y');
$date = date('l j \of F Y h:i:s A');

$viewDataClass = new viewData();



$data = json_decode(file_get_contents("php://input"), true);
if (empty($data)) {
    echo json_encode(["status" => "failed", "result" => "Emty fields"]);
} else {
    try {
        $access = true;
        if ($access) {
            $name = $data['name'];
            $event = $data['event'];
            $Date = $date;
            $sitename = $data['sitename'];
            $action = $data['action'];
            $result_data = $viewDataClass->History_data($name, $event, $Date, $sitename, $action);
            echo json_encode(["status" => "result", "result" => $result_data]);

        }

    } catch (Exception $e) {
        $error_message = "Exception: " . $e->getMessage();
        echo json_encode(["status" => "error", "message" => $error_message]);
    }

}
?>