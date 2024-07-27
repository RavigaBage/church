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


    if ($_GET['submit'] == 'true' || $_GET['submit'] == 'upload' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'annc') {
        try {
            $file_name = $_FILES['file']['name'];
            $Image_type = $_FILES['file']['type'];
            $Image_tmp_name = $_FILES['file']['tmp_name'];
            $name = $_POST['name'];
            $receiver = $_POST['receiver'];
            $message = $_POST['message'];
            $date = $_POST['date'];
            $viewDataClass = new viewData();
            if($_GET['submit'] == 'true'){
                $result_data = $viewDataClass->annc_upload($name, $receiver, $message, $date, $file_name, $Image_type, $Image_tmp_name);
            }else if($_GET['submit'] == 'upload'){
                $pass = $_POST['delete_key'];
                $result_data = $viewDataClass->annc_update($name, $receiver, $message, $date, $file_name, $Image_type, $Image_tmp_name,$pass);
            }
            echo json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
    if ($_GET['submit'] == 'status' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'annc') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $pass = $data['key_Data'];
            $Id = $data['IdData'];
            $viewDataClass = new viewData();
            $result_data = $viewDataClass->annc_status($pass,$Id);
            echo json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
    if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'annc') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $pass = $data['key'];
            $viewDataClass = new viewData();
            $result_data = $viewDataClass-> ass_delete($pass);
            echo json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }


}