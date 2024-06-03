<?php
require ('autoloader.php');
if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'delete_file' && $_GET['user'] == 'true') {
        $Name = $_POST['name'];
        $Acquisition = $_POST['source'];
        $Location = $_POST['location'];
        $Items = $_POST['total'];
        $date = $_POST['date'];
        $status = $_POST['status'];
        $Value = $_POST['value'];
        $About = $_POST['description'];
    }
    if ($_GET['submit'] == 'true' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {
        try {
            $name = $_POST['name'];
            $start_date = $_POST['date'];
            $team = $_POST['team'];
            $status = $_POST['status'];
            if ($status == 'complete') {
                $end_date = "120 20";
            } else {
                $end_date = "";
            }
            $current = $_POST['current'];
            $description = $_POST['description'];
            $target = $_POST['target'];
            $Image_name = $_FILES['imageFile']['name'];
            $Image_type = $_FILES['imageFile']['type'];
            $Image_tmp_name = $_FILES['imageFile']['tmp_name'];


            $viewDataClass = new viewData();
            $result_data = $viewDataClass->projects_upload($name, $description, $start_date, $end_date, $team, $status, $Image_name, $Image_type, $Image_tmp_name, $target, $current);
            json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {
        try {
            $name = $_POST['name'];
            $start_date = $_POST['date'];
            $team = $_POST['team'];
            $status = $_POST['status'];
            if ($status == 'complete') {
                $end_date = "120 20";
            } else {
                $end_date = "";
            }
            $current = $_POST['current'];
            $description = $_POST['description'];
            $target = $_POST['target'];
            $Image_name = $_FILES['imageFile']['name'];
            $Image_type = $_FILES['imageFile']['type'];
            $Image_tmp_name = $_FILES['imageFile']['tmp_name'];
            $unique_id = $_POST['delete_key'];



            $viewDataClass = new viewData();
            $result_data = $viewDataClass->projects_update($name, $description, $start_date, $end_date, $team, $status, $Image_name, $Image_type, $Image_tmp_name, $target, $current, $unique_id);
            json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = $data['key'];
            $pdh = new viewData();

            $resultFetch = $pdh->projects_delete($unique_id);
            echo json_encode(["status" => "success", "message" => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }

    if ($_GET['submit'] == 'true' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $Image_name = $_FILES['imageFile']['name'];
            $Image_type = $_FILES['imageFile']['type'];
            $Image_tmp_name = $_FILES['imageFile']['tmp_name'];
            $size = $_FILES['imageFile']['size'];
            $pdh = new viewData();

            $resultFetch = $pdh->Assets_upload($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $size, $Image_name, $Image_type, $Image_tmp_name, $About);
            echo json_encode(["status" => "errors", "message" => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }

    } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $Image_name = $_FILES['imageFile']['name'];
            $Image_type = $_FILES['imageFile']['type'];
            $Image_tmp_name = $_FILES['imageFile']['tmp_name'];
            $unique_id = $_POST['delete_key'];
            $pdh = new viewData();

            $resultFetch = $pdh->Assets_update($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $Image_name, $Image_type, $Image_tmp_name, $About, $unique_id);
            echo json_encode(["status" => "errors", "message" => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = $data['key'];
            $pdh = new viewData();

            $resultFetch = $pdh->Assets_delete($unique_id);
            echo json_encode(["status" => "success", "message" => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else {
        $error_message = "Exception: Unauthorized access";
        echo json_encode(["status" => "error", "message" => $error_message]);
    }
}