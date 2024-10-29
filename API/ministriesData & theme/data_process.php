<?php
session_start();
require '../vendor/autoload.php';
$pdh = new Ministry\ViewData;

function DataCleansing($opt,$data){
    if($opt == 'str'){
        if(dataInstance_string($data) == False){
            echo json_encode("Data cannot contain illegal characters");
            exit();
        }
    }
    if($opt == 'num'){
        if(dataInstance_num($data) == False){
            echo json_encode("Number cannot contain illegal characters");
            exit();
        }
    }
    if($opt == 'arr'){
        if(dataInstance_array($data) == False){
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    if($opt == 'obj'){
        if(dataInstance_object($data) == False){
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    if($opt == 'date'){
        if(dataInstance_date($data) == False){
            echo json_encode("illegal date formate detected");
            exit();
        }
    }

    if($opt == 'bool'){
        if(dataInstance_bool($data) == False){
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    return $data;
}
function dataInstance_num($data){
    return Intval($data) && is_numeric($data) ? $data : False;
}
function dataInstance_string($data){
    return is_string($data) && !preg_match('/[!@$%^&*()_+=*~;:><?]/',$data) ? $data : False;
}
function dataInstance_bool($data){
    return is_bool($data) ? $data : False;
}
function dataInstance_array($data){
    return is_array($data) ? $data : False;
}
function dataInstance_object($data){
    return is_object($data) ? $data : False;
}
function dataInstance_date($data){
     return ((DateTime::createFromFormat('Y-m-d',$data) !== False))? $data: False;
}

if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'delete_file' && $_GET['submit'] != 'list' && $_GET['submit'] != 'dpList') {
        $name = DataCleansing('str',$_POST['name']);
        $manager = DataCleansing('str',$_POST['manager']);
        $members = DataCleansing('str',$_POST['members']);
        $status = DataCleansing('str',$_POST['status']);
        $date = DataCleansing('date',$_POST['date']);
        $about = DataCleansing('str',$_POST['about']);
    }
    if ($_GET['submit'] == 'true' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {

            $result_data = $pdh->ministries_upload($name, $members, $manager, $about, $status, $date);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $unique_id = DataCleansing('num',$_POST['delete_key']);

            $result_data = $pdh->ministries_update($name, $members, $manager, $about, $status, $date, $unique_id);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = DataCleansing('num',$data['key']);


            $resultFetch = $pdh->ministries_delete($unique_id);
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'list' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = DataCleansing('num',$data['key']);

            $resultFetch = $pdh->DepartmentMembers($unique_id);
            echo json_encode(['status' => 'success', 'data' => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }

    } else if ($_GET['submit'] == 'dpList' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_ids = DataCleansing('num',$data['Keys']);
            $Dp_Key = DataCleansing('num',$data['DpKey']);

            $resultFetch = $pdh->AddDepartmentMembers($unique_ids, $Dp_Key);
            echo json_encode(['status' => 'success', 'data' => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'dpList' && $_GET['APICALL'] == 'delete' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_ids = DataCleansing('num',$data['Keys']);
            $Dp_Key = DataCleansing('num',$data['DpKey']);

            $resultFetch = $pdh->RemoveDepartmentMembers($unique_ids, $Dp_Key);
            echo json_encode(['status' => 'success', 'data' => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'dpList' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'view') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $name = DataCleansing('num',$data['DpKey']);

            $resultFetch = $pdh->ViewDepartmentMembers($name);
            echo json_encode(['status' => 'success', 'data' => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }


}