<?php
session_start();
require('autoload.php');
require('upload.php');
$viewDataClass = new Calender\viewData();
$upload_file_system = new UploadData();

function DataCleansing($opt, $data)
{
    if ($opt == 'str') {
        if (dataInstance_string($data) == False) {
            echo json_encode("Data cannot contain illegal characters");
            exit();
        }
    }
    if ($opt == 'num') {
        if (dataInstance_num($data) == False) {
            echo json_encode("Number cannot contain illegal characters");
            exit();
        }
    }
    if ($opt == 'arr') {
        if (dataInstance_array($data) == False) {
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    if ($opt == 'obj') {
        if (dataInstance_object($data) == False) {
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    if ($opt == 'date') {
        if (dataInstance_date($data) == False) {
            echo json_encode("illegal date formate detected");
            exit();
        }
    }

    if ($opt == 'bool') {
        if (dataInstance_bool($data) == 'False') {
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    return $data;
}
function dataInstance_num($data)
{
    return Intval($data) && is_numeric($data) ? $data : False;
}
function dataInstance_string($data)
{
    return is_string($data) && !preg_match('/[!@$%^&*()_+=*~;:><?]/', $data) ? $data : False;
}
function dataInstance_bool($data)
{
    return is_bool($data) ? $data : 'False';
}
function dataInstance_array($data)
{
    return is_array($data) ? $data : False;
}
function dataInstance_object($data)
{
    return is_object($data) ? $data : False;
}
function dataInstance_date($data)
{
    return ((DateTime::createFromFormat('Y-m-d', $data) !== False)) ? $data : False;
}

if (isset($_GET['upload_submit'])) {
    $upload_status = json_decode($upload_file_system->file_registry());
    echo json_encode($upload_status);
    if ($upload_status->status == 'success') {
        echo $upload_status->name;
    }
}

if (isset($_GET['submit'])) {
    if ($_GET['submit'] == 'upload' || $_GET['submit'] == 'update') {
        $EventName = DataCleansing('str', $_POST['EventName']);
        $Venue = DataCleansing('str', $_POST['EventLocation']);
        $Department = DataCleansing('str', $_POST['EventTag']);
        $start_time = $_POST['StartTime'];
        $end_time = $_POST['EndTime'];
        $About = DataCleansing('str', $_POST['EventDescription']);
        $Year = DataCleansing('num', $_POST['year']);
        $Month = DataCleansing('num', $_POST['month']);
        $Day = DataCleansing('num', $_POST['Day']);
        $Theme = DataCleansing('str', $_POST['EventTag']);
        $Status = 'uncompleted';
        $uploaded_file_names = json_decode($_POST['fileNames']);
        if (is_array($uploaded_file_names) && count($uploaded_file_names) > 0) {
            $uploaded_file_names = $uploaded_file_names[0];
        } else {
            $uploaded_file_names = "";
        }
    }
    if ($_GET['submit'] == 'upload' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $result_data = $viewDataClass->calender_upload($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status, $uploaded_file_names);
            echo $result_data;
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'update' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {

            $unique_id = DataCleansing('num', $_POST['delete_key']);
            $result_data = $viewDataClass->calender_update($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status, $uploaded_file_names, $unique_id);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'delete' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = DataCleansing('num', $data['key']);
        $requestResponse = $viewDataClass->calender_delete($id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'filter' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $year = DataCleansing('num', $data['Year']);
        $month = DataCleansing('num', $data['Month']);
        $day = DataCleansing('num', $data['Day']);
        $requestResponse = $viewDataClass->viewList_filter($year, $month, $day);
        echo json_encode($requestResponse);
    }

}