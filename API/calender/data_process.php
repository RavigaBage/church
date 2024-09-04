<?php
require('autoload.php');
$viewDataClass = new Calender\viewData();
if (isset($_GET['submit'])) {

    if ($_GET['submit'] == 'upload' || $_GET['submit'] == 'update') {
        $EventName = $_POST['EventName'];
        $Venue = $_POST['EventLocation'];
        $Department = $_POST['EventTag'];
        $start_time = $_POST['StartTime'];
        $end_time = $_POST['EndTime'];
        $file_name = $_FILES['ImageFile']['name'];
        $Image_type = $_FILES['ImageFile']['type'];
        $Image_tmp_name = $_FILES['ImageFile']['tmp_name'];
        $About = $_POST['EventDescription'];
        $Year = $_POST['year'];
        $Month = $_POST['month'];
        $Day = $_POST['Day'];
        $Theme = $_POST['EventTag'];
        $Status = 'uncompleted';
    }
    if ($_GET['submit'] == 'upload' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $result_data = $viewDataClass->calender_upload($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status, $file_name, $Image_type, $Image_tmp_name);
            ;
            echo $result_data;
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'update' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $unique_id = $_POST['delete_key'];
            $result_data = $viewDataClass->calender_update($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status, $file_name, $Image_type, $Image_tmp_name, $unique_id);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'delete' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['key'];
        $requestResponse = $viewDataClass->calender_delete($id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'filter' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $year = $data['Year'];
        $month = $data['Month'];
        $day = $data['Day'];
        $requestResponse = $viewDataClass->viewList_filter($year, $month, $day);
        echo json_encode($requestResponse);
    }

}