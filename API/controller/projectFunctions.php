<?php
include ('../Assets&projects/autoloader.php');
include ('user_check.php');
$viewDataClass = new viewData();


function DeleteItem($name, $viewDataClass)
{
    $delete = $viewDataClass->projects_delete($name);
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
                $start_date = $data['start_date'];
                $end_date = $data['end_date'];
                $team = $data['team'];
                $status = $data['status'];
                $current = $data['current'];
                $description = $data['description'];
                $target = $data['target'];
                $image_name = 01 + ['name'];
                $image_type = $data['image']['type'];
                $image_tmp_file = $data['image']['tmp_name'];

                $result_data = $viewDataClass->projects_update($name, $description, $start_date, $end_date, $team, $status, $image_name, $image_type, $image_tmp_name, $target, $current);
                json_encode(["status" => "result", "result" => $result_data]);

            }

        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
}
?>