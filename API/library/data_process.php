<?php
require '../vendor/autoload.php';
session_start();
$viewDataClass = new Library\viewData();
//libraryCover($_FILES)
if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'upload_ind' && $_GET['submit'] != 'fetchlatest' && $_GET['submit'] != 'delete_file' && $_GET['submit'] != 'delete_ini' && $_GET['submit'] != 'filter' && $_GET['submit'] != 'export') {
        $name = $_POST['name'];
        $author = $_POST['author'];
        $source = $_POST['source'];
        $status = $_POST['status'];
        $date = $_POST['date'];
        $category = $_POST['category'];
    }
    if ($_GET['submit'] == 'fetchlatest' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $num = $data['key'];
            $result_data = $viewDataClass->Library_liveUpdate($num);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'upload_ind' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $name = $_POST['delete_key'];
            $filename = $_POST['filename'];
            $source = $_POST['source'];
            $date = date('Y-m-d');
            $result_data = $viewDataClass->Library_view_individual_record_upload($name, $date, $filename, $source);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else

        if ($_GET['submit'] == 'upload' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $FILES = $_FILES;
                $REQUEST = $_REQUEST;
                $result_data = $viewDataClass->library_upload($name, $author, $date, $status, $source, $category, $FILES, $REQUEST)
                ;
                echo json_encode($result_data);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $FILES = $_FILES;
                $REQUEST = $_REQUEST;
                $unique_id = $_POST['delete_key'];
                $result_data = $viewDataClass->library_update($name, $author, $date, $status, $source, $category, $unique_id, $FILES, $REQUEST);
                echo json_encode($result_data);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $unique_id = $data['key'];


                $resultFetch = $viewDataClass->Library_delete($unique_id);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'filter' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $search = $data['key'];
                $nk = $data['numData'];


                $resultFetch = $viewDataClass->Library_filterSearch($search, $nk);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {

                $resultFetch = $viewDataClass->Library_export();
                echo json_encode(trim($resultFetch));
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else
            if ($_GET['submit'] == 'delete_ini' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
                try {
                    $data = json_decode(file_get_contents("php://input"), true);
                    $unique_id = $data['key'];


                    $resultFetch = $viewDataClass->Library_delete_inidividual($unique_id);
                    echo json_encode($resultFetch);
                } catch (Exception $e) {
                    $error_message = "Exception: " . $e->getMessage();
                    echo json_encode(["status" => "error", "message" => $error_message]);
                }
            }


}