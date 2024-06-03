<?php
require ('autoloader.php');
if (isset($_GET['submit'])) {

    if ($_GET['submit'] == 'settoken' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $pass = $data['code'];
            $new = $data['duration'];
            $date = date('Y-m-d H:i:s');

            $viewDataClass = new viewData();
            $result_data = $viewDataClass->setToken($pass, $new, $new, $date)
            ;
            echo json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }

    if ($_GET['submit'] == 'theme' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $pass = $data['key'];

            $viewDataClass = new viewData();
            $result_data = $viewDataClass->Theme($pass);
            echo json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }

}