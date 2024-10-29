<?php
require '../vendor/autoload.php';
$viewDataClass = new notification\ViewData;
session_start();

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


    if ($_GET['submit'] == 'settoken' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $pass = $data['code'];
            $new = $data['duration'];
            $date = date('Y-m-d H:i:s');


            $result_data = $viewDataClass->setToken($pass, $new, $new, $date);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }



    if ($_GET['submit'] == 'theme' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $pass = DataCleansing('num',$data['key']);


            $result_data = $viewDataClass->Theme($pass);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }


    if ($_GET['submit'] == 'update' || $_GET['submit'] == 'true' || $_GET['submit'] == 'upload' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'annc') {
        try {
            $file_name = $_FILES['file']['name'];
            $Image_type = $_FILES['file']['type'];
            $Image_tmp_name = $_FILES['file']['tmp_name'];
            $name = DataCleansing('str',$_POST['name']);
            $receiver = DataCleansing('str',$_POST['receiver']);
            $message = DataCleansing('str',$_POST['message']);
            $date = DataCleansing('date',$_POST['date']);

            if ($_GET['submit'] == 'true') {
                $result_data = $viewDataClass->annc_upload($name, $receiver, $message, $date, $file_name, $Image_type, $Image_tmp_name);
            } else if ($_GET['submit'] == 'update') {
                $pass = DataCleansing('num',$_POST['delete_key']);
                $result_data = $viewDataClass->annc_update($name, $receiver, $message, $date, $file_name, $Image_type, $Image_tmp_name, $pass);
            }
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }


    if ($_GET['submit'] == 'status' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'annc') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $pass = DataCleansing('bool',$data['key_Data']);
            $Id = DataCleansing('num',$data['IdData']);

            $result_data = $viewDataClass->annc_status($pass, $Id);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
    if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'annc') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $pass = DataCleansing('num',$data['key']);

            $result_data = $viewDataClass->ass_delete($pass);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }

    if ($_GET['submit'] == 'fetchlatest' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'annc') {

        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $num = $data['key'];

            $result_data = $viewDataClass->annc_liveUpdate($num);

            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }

    if ($_GET['submit'] == 'search' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'annc') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $name = DataCleansing('num',$data['key']);
            $nk = DataCleansing('num',$data['numData']);

            $result_data = $viewDataClass->annc_SearchRequest($name, $nk);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }


}