<?php
require '../vendor/autoload.php';
$pdh = new Gallery\viewData();
if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'delete_file' && $_GET['submit'] != 'search_file' && $_GET['submit'] != 'export') {
        $Event_name = $_POST['event_name'];
        $Image_name = date('Y');
        $upload_date = $_POST['date'];
        $category = $_POST['category'];

    }
    if ($_GET['submit'] == 'true' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {

            $ImageName = $_FILES['imageFile']['name'];
            $Image_type = $_FILES['imageFile']['type'];
            $Image_tmp_name = $_FILES['imageFile']['tmp_name'];
            $size = $_FILES['imageFile']['size'];

            $resultFetch = $pdh->gallery_upload($Event_name, $Image_name, $upload_date, $category, $ImageName, $Image_type, $Image_tmp_name);
            echo json_encode(["status" => "errors", "message" => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }

    } else if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {


            $resultFetch = $pdh->gallery_export();
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }

    } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $ImageName = $_FILES['imageFile']['name'];
            $Image_type = $_FILES['imageFile']['type'];
            $Image_tmp_name = $_FILES['imageFile']['tmp_name'];
            $unique_id = $_POST['delete_key'];


            $resultFetch = $pdh->gallery_update($Event_name, $Image_name, $upload_date, $category, $ImageName, $Image_type, $Image_tmp_name, $unique_id);
            echo json_encode(["status" => "errors", "message" => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = $data['key'];


            $resultFetch = $pdh->gallery_delete($unique_id);
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'search_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $search = $data['key'];
            $nk = $data['numData'];

            $resultFetch = $pdh->search($search, $nk);
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else {
        $error_message = "Exception: Unauthorized access";
        echo json_encode(["status" => "error", "message" => $error_message]);
    }
}
