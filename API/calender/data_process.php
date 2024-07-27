<?php
require ('autoloader.php');
if (isset($_GET['submit'])) {

    if ($_GET['submit'] == 'upload' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
           
            $EventName  = $_POST['EventName'];
            $Venue  = $_POST['EventLocation'];
            $Department  = $_POST['EventTag'];
            $start_time  = $_POST['StartTime'];
            $end_time  = $_POST['EndTime'];
            $file_name = $_FILES['ImageFile']['name'];
            $Image_type = $_FILES['ImageFile']['type'];
            $Image_tmp_name = $_FILES['ImageFile']['tmp_name'];
            $About  = $_POST['EventDescription'];
            $Year  = $_POST['year'];
            $Month  = $_POST['month'];
            $Day  = $_POST['Day'];
            $Theme = $_POST['EventTag'];
            $Status = 'uncompleted';

            $viewDataClass = new viewData();
            $result_data = $viewDataClass->calender_upload($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status,$file_name, $Image_type, $Image_tmp_name);
            ;
            echo json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }


}