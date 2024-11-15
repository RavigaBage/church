<?php

require('autoload.php');
include_once 'upload.php';
$viewDataClass = new AssetProject\viewData;
session_start();
$upload_file_system = new UploadData();

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
        if(dataInstance_bool($data) == 'False'){
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
    return is_bool($data) ? $data : 'False';
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

if(isset($_GET['upload_submit'])){
    $upload_status = json_decode($upload_file_system->file_registry($_GET['APICALL']));
    echo json_encode($upload_status);
}

if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'delete_file' && $_GET['user'] == 'true' && $_GET['submit'] != 'fetchlatest') {
        $Name = DataCleansing('str',$_POST['name']);
        $Acquisition = DataCleansing('str',$_POST['source']);
        $Location = DataCleansing('str',$_POST['location']);
        $Items = DataCleansing('num',$_POST['total']);
        $date = DataCleansing('date',$_POST['date']);
        $status = DataCleansing('str',$_POST['status']);
        $Value = DataCleansing('num',$_POST['value']);
        $About = DataCleansing('str',$_POST['description']);
        $uploaded_file_names = json_decode($_POST['fileNames']);
        if(is_array($uploaded_file_names) && count($uploaded_file_names) > 0){
            $uploaded_file_names = $uploaded_file_names[0];
        }else{
            $uploaded_file_names = "";
        }
        
    }
    if ($_GET['submit'] == 'true' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {
        try {
            $name = DataCleansing('str',$_POST['name']);
            $start_date = DataCleansing('date',$_POST['date']);
            $team = DataCleansing('str',$_POST['team']);
            $status = DataCleansing('str',$_POST['status']);
            if ($status == 'complete') {
                $end_date = "120 20";
            } else {
                $end_date = "";
            }
            $current = DataCleansing('num',$_POST['current']);
            $description = DataCleansing('str',$_POST['description']);
            $target = DataCleansing('num',$_POST['target']);
            $result_data = $viewDataClass->projects_upload($name, $description, $start_date, $end_date, $team, $status, $uploaded_file_names, $target, $current);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {
        try {
            $name = DataCleansing('str',$_POST['name']);
            $start_date = DataCleansing('date',$_POST['date']);
            $team = DataCleansing('str',$_POST['team']);
            $status = DataCleansing('str',$_POST['status']);
            if ($status == 'complete') {
                $end_date = "120 20";
            } else {
                $end_date = "";
            }
            $current = DataCleansing('str',$_POST['current']);
            $description = $_POST['description'];
            $target = DataCleansing('str',$_POST['target']);
            
            $unique_id = DataCleansing('num',$_POST['delete_key']);
            $uploaded_file_names = json_decode($_POST['fileNames']);
            if(is_array($uploaded_file_names) && count($uploaded_file_names) > 0){
                $uploaded_file_names = $uploaded_file_names[0];
            }else{
                $uploaded_file_names = "";
            }
            $result_data = $viewDataClass->projects_update($name, $description, $start_date, $end_date, $team, $status, $uploaded_file_names, $target, $current, $unique_id);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = DataCleansing('num',$data['key']);

            $resultFetch = $viewDataClass->projects_delete($unique_id);
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'search' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {

        $data = json_decode(file_get_contents("php://input"), true);
        $name = DataCleansing('num',$data['key']);
        $nk = DataCleansing('num',$data['numData']);

        $resultFetch = $viewDataClass->Project_viewSearchMain($name, $nk);
        echo json_encode($resultFetch);

    } else if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {

        $resultFetch = $viewDataClass->Project_viewExport();
        echo json_encode($resultFetch);

    } else if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'assets') {

        $resultFetch = $viewDataClass->Asset_viewExport();
        echo json_encode($resultFetch);

    } else


        if ($_GET['submit'] == 'true' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $resultFetch = $viewDataClass->Assets_upload($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $uploaded_file_names, $About);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }

        } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $unique_id = DataCleansing('num',$_POST['delete_key']);
                $resultFetch = $viewDataClass->Assets_update($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $uploaded_file_names, $About, $unique_id);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode($error_message);
            }
        } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $unique_id = DataCleansing('num',$data['key']);

                $resultFetch = $viewDataClass->Assets_delete($unique_id);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'fetchlatest' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $num = DataCleansing('num',$data['key']);

                $resultFetch = $viewDataClass->Assets_liveUpdate($num);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'fetchlatest' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $num = $data['key'];

                $resultFetch = $viewDataClass->Projects_liveUpdate($num);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else {
            if(!isset($_GET['upload_submit'])){
                $error_message = "Exception: Unauthorized access";
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
            
        }




}