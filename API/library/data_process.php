<?php
require '../vendor/autoload.php';
include_once 'upload.php';
session_start();
$viewDataClass = new Library\viewData();
$upload_file_system = new UploadData();
function DataCleansing($opt, $data)
{
    if ($opt == 'str') {
        if (dataInstance_string($data) == False) {
            echo json_encode("Data cannot contain illegal characters");
            exit();
        }
    }
    if ($opt == 'num') {
        if (dataInstance_num($data) == False) {
            echo json_encode("Number cannot contain illegal characters");
            exit();
        }
    }
    if ($opt == 'arr') {
        if (dataInstance_array($data) == False) {
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    if ($opt == 'obj') {
        if (dataInstance_object($data) == False) {
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    if ($opt == 'date') {
        if (dataInstance_date($data) == False) {
            echo json_encode("illegal date formate detected");
            exit();
        }
    }

    if ($opt == 'bool') {
        if (dataInstance_bool($data) == 'False') {
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    return $data;
}
function dataInstance_num($data)
{
    return Intval($data) && is_numeric($data) ? $data : False;
}
function dataInstance_string($data)
{
    return is_string($data) && !preg_match('/[!@$%^&*()_+=*~;:><?]/', $data) ? $data : False;
}
function dataInstance_bool($data)
{
    return is_bool($data) ? $data : 'False';
}
function dataInstance_array($data)
{
    return is_array($data) ? $data : False;
}
function dataInstance_object($data)
{
    return is_object($data) ? $data : False;
}
function dataInstance_date($data)
{
    return ((DateTime::createFromFormat('Y-m-d', $data) !== False)) ? $data : False;
}

if (isset($_GET['upload_submit'])) {
    $upload_status = json_decode($upload_file_system->file_registry());
    echo json_encode($upload_status);
}

if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'upload_ind' && $_GET['submit'] != 'fetchlatest' && $_GET['submit'] != 'delete_file' && $_GET['submit'] != 'delete_ini' && $_GET['submit'] != 'filter' && $_GET['submit'] != 'export') {
        $name = DataCleansing('str', $_POST['name']);
        $author = DataCleansing('str', $_POST['author']);
        $source = $_POST['source'];
        $status = DataCleansing('str', $_POST['status']);
        $date = DataCleansing('date', $_POST['date']);
        $category = DataCleansing('str', $_POST['category']);
        $tag = DataCleansing('str', $_POST['tag']);
        $uploaded_file_names = json_decode($_POST['fileNames']);
        if (is_array($uploaded_file_names) && count($uploaded_file_names) > 0) {
            $uploaded_file_names = $uploaded_file_names[0];
        } else {
            $uploaded_file_names = "";
        }
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
            $name = DataCleansing('num', $_POST['delete_key']);
            $filename = DataCleansing('str', $_POST['filename']);
            $source = DataCleansing('str', $_POST['source']);
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
                $FILES = $uploaded_file_names;
                $result_data = $viewDataClass->library_upload($name, $author, $date, $status, $source, $category,$tag, $FILES)
                ;
                echo json_encode($result_data);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $FILES = $uploaded_file_names;
                $unique_id = DataCleansing('str', $_POST['delete_key']);
                $result_data = $viewDataClass->library_update($name, $author, $date, $status, $source, $category,$tag, $unique_id, $FILES);
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
                $search = DataCleansing('num', $data['key']);
                $nk = DataCleansing('num', $data['numData']);


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
                    $unique_id = DataCleansing('num', $data['key']);


                    $resultFetch = $viewDataClass->Library_delete_inidividual($unique_id);
                    echo json_encode($resultFetch);
                } catch (Exception $e) {
                    $error_message = "Exception: " . $e->getMessage();
                    echo json_encode(["status" => "error", "message" => $error_message]);
                }
            }


}