<?php
include ('../ministries&theme/autoloader.php');
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
            $values = ['Name', 'Acquisition', 'Value', 'Items', 'Location', 'Image', 'Image_type', 'Image_tmp_name', 'About'];
            foreach ($values as $variable) {
                if (empty($variable)) {
                    $access = false;
                    break;
                } else {
                    $access = true;
                }
            }
            if ($access) {
                $name = $data['name'];
                $members = $data['members'];
                $manager = $data['manager'];
                $about = $data['about'];
                $status = $data['status'];
                $date = $data['date'];
                $result_data = $viewDataClass->ministries_update($name, $members, $manager, $about, $status, $date, $unique_id);
                json_encode(["status" => "result", "result" => $result_data]);

            }

        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }

    if (isset($_GET['upload'])) {
        try {
            $access = true;

            if ($access) {
                $name = $data['name'];
                $members = $data['members'];
                $manager = $data['manager'];
                $about = $data['about'];
                $status = $data['status'];
                $date = $data['date'];
                $dataKey = $data['unique_id'];
                $result_data = $viewDataClass->ministries_upload_data($name, $members, $manager, $about, $status, $date);
                json_encode(["status" => "result", "result" => $result_data]);

            }

        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }

}
?>