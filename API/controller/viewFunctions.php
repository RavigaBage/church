<?php
include ('../Assets&projects/autoloader.php');
include ('user_check.php');
$viewDataClass = new viewData();


function DeleteItem($name, $viewDataClass)
{
    $delete = $viewDataClass->Assets_delete($name);
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
                $acquisition = $data['acquisition'];
                $value = $data['value'];
                $location = $data['location'];
                $about = $data['about'];
                $item = $data['item'];
                $image_name = $data['image']['name'];
                $image_type = $data['image']['type'];
                $image_tmp_file = $data['image']['tmp_name'];

                $result_data = $viewDataClass->Assets_update_data($name, $acquisition, $value, $item, $location, $image_name, $image_type, $image_tmp_name, $about);
                json_encode(["status" => "result", "result" => $result_data]);

            }

        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
}
?>