<?php
include ('../calender/autoloader.php');
include ('user_check.php');
$viewDataClass = new viewData();


function DeleteItem($name, $viewDataClass)
{
    $delete = $viewDataClass->calender_delete($name);
    return $delete;
}
$data = json_decode(file_get_contents("php://input"), true);
if (empty($data)) {
    echo json_encode(["status" => "failed", "result" => "Emty fields"]);
} else {
    if (isset($_GET['delete'])) {
        $id = $data['delete_key'];
        $result_data = DeleteItem($id, $viewDataClass);
        json_encode(["status" => "result", "result" => $result_data]);
    }

    if (isset($_GET['update'])) {
        try {
            $access = true;
            $name = $data['EventName'];
            $year = $data['Year'];
            $Month = $data['Month'];
            $Day = $data['Day'];
            $start = $data['start_time'];
            $end = $data['end_time'];
            $venue = $data['Venue'];
            $theme = $data['Theme'];
            $about = $data['About'];
            $image = $data['Image'];
            $department = $data['Department'];
            $status = $data['Status'];
            $unique_id = $data['unique_id'];
            $result_data = $viewDataClass->calender_update($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Image, $Department, $Status, $unique_id);
            json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
    if (isset($_GET['upload'])) {
        try {
            $name = $data['EventName'];
            $year = $data['Year'];
            $Month = $data['Month'];
            $Day = $data['Day'];
            $start = $data['start_time'];
            $end = $data['end_time'];
            $venue = $data['Venue'];
            $theme = $data['Theme'];
            $about = $data['About'];
            $image = $data['Image'];
            $department = $data['Department'];
            $status = $data['Status'];
            $result_data = $viewDataClass->calender_upload($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Image, $Department, $Status);
            json_encode(["status" => "result", "result" => $result_data]);



        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }


}
?>