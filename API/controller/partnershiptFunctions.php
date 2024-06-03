<?php
include ('../partnership/autoloader.php');
include ('user_check.php');
$viewDataClass = new viewData();


function DeleteItem($name, $viewDataClass)
{
    $delete = $viewDataClass->ministries_delete($name);
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
            $name = $data['name'];
            $partnership = $data['partnership'];
            $date = $data['date'];
            $email = $data['email'];
            $status = $data['status'];
            $type = $data['type'];
            $period = $data['period'];
            $unique_id = $data['unique_id'];
            $result_data = $viewDataClass->ministries_update($name, $partnership, $date, $status, $email, $type, $period, $unique_id);
            json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
    if (isset($_GET['upload'])) {
        try {
            $access = true;
            $name = $data['name'];
            $partnership = $data['partnership'];
            $date = $data['date'];
            $email = $data['email'];
            $status = $data['status'];
            $type = $data['type'];
            $period = $data['period'];
            $result_data = $viewDataClass->ministries_upload($name, $partnership, $date, $status, $email, $type, $period);
            json_encode(["status" => "result", "result" => $result_data]);



        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }


    if (isset($_GET['view_individual'])) {
        try {
            $name = $data['id'];
            $result_data = $viewDataClass->view_individual_record($id);
            json_encode(["status" => "result", "result" => $result_data]);



        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }

}
?>