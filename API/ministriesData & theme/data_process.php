<?php
require('autoloader.php');
session_start();
if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'delete_file' && $_GET['submit'] != 'list' && $_GET['submit'] != 'dpList') {
        $name = $_POST['name'];
        $manager = $_POST['manager'];
        $members = $_POST['members'];
        $status = $_POST['status'];
        $date = $_POST['date'];
        $about = $_POST['about'];
    }
    if ($_GET['submit'] == 'true' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $viewDataClass = new viewData();
            $result_data = $viewDataClass->ministries_upload($name, $members, $manager, $about, $status, $date);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $unique_id = $_POST['delete_key'];
            $viewDataClass = new viewData();
            $result_data = $viewDataClass->ministries_update($name, $members, $manager, $about, $status, $date, $unique_id);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = $data['key'];
            $pdh = new viewData();

            $resultFetch = $pdh->ministries_delete($unique_id);
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }else if($_GET['submit'] == 'list' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true'){
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = $data['key'];
            $pdh = new viewData();
            $resultFetch = $pdh-> DepartmentMembers($unique_id);
            echo json_encode(['status'=>'success','data'=>$resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
       
    }else if($_GET['submit'] == 'dpList' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true'){
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_ids = $data['Keys'];
            $Dp_Key = $data['DpKey'];
            $pdh = new viewData();
            $resultFetch = $pdh->AddDepartmentMembers($unique_ids,$Dp_Key);
            echo json_encode(['status'=>'success','data'=>$resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }else if($_GET['submit'] == 'dpList' && $_GET['APICALL'] == 'delete' && $_GET['user'] == 'true'){
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_ids = $data['Keys'];
            $Dp_Key = $data['DpKey'];
            $pdh = new viewData();
            $resultFetch = $pdh->RemoveDepartmentMembers($unique_ids,$Dp_Key);
            echo json_encode(['status'=>'success','data'=>$resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }else if($_GET['submit'] == 'dpList' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'view'){
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $name = $data['DpKey'];
            $pdh = new viewData();
            $resultFetch = $pdh->ViewDepartmentMembers($name);
            echo json_encode(['status'=>'success','data'=>$resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }


}