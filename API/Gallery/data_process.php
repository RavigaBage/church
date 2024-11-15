<?php
session_start();
require '../vendor/autoload.php';
require 'upload.php';
$upload_file_system = new UploadData();
$pdh = new Gallery\viewData();

function DataCleansing($opt, $data)
{
    if ($opt == 'str') {
        if (dataInstance_string($data) == False) {
            echo json_encode("Data cannot contain illegal characters");
            exit();
        }
    }
    if ($opt == 'num') {
        if (dataInstance_num($data) == 'False') {
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
    return is_numeric($data) ? "num" : 'False';
}
function dataInstance_string($data)
{
    return is_string($data) && !preg_match('/[!@$%^&*()+=*~;:><?]/', $data) ? $data : False;
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
    if ($upload_status->status == 'success') {
        echo $upload_status->name;
    }
}
if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'upload' && $_GET['submit'] != 'load' && $_GET['submit'] != 'fetchLatest' && $_GET['submit'] != 'delete_file' && $_GET['submit'] != 'search_file' && $_GET['submit'] != 'export') {
        $Event_name = DataCleansing('str', $_POST['event_name']);
        $Image_name = date('Y');
        $upload_date = DataCleansing('date', $_POST['date']);
        $category = DataCleansing('str', $_POST['category']);

    }
    if ($_GET['submit'] == 'load' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $num = DataCleansing('num', $data['num']);
            $filter = DataCleansing('str', $data['filter']);
            $resultFetch = $pdh->gallery_view_images_list($num, $filter);
            echo $resultFetch;
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode($error_message);
        }

    } else
        if ($_GET['submit'] == 'true' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {

                $uploaded_file_names = json_decode($_POST['fileNames']);
                $resultFetch = $pdh->gallery_upload($Event_name, $uploaded_file_names, $upload_date, $category);
                echo json_encode($resultFetch);

            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode($error_message);
            }

        } else if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {


                $resultFetch = $pdh->gallery_export();
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode($error_message);
            }

        } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {

                $uploaded_file_names = json_decode($_POST['fileNames']);
                if (is_array($uploaded_file_names) && count($uploaded_file_names) > 0) {
                    $uploaded_file_names = $uploaded_file_names[0];
                } else {
                    $uploaded_file_names = "";
                }
                $unique_id = DataCleansing('num', $_POST['delete_key']);
                $resultFetch = $pdh->gallery_update($Event_name, $uploaded_file_names, $upload_date, $category, $unique_id);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode($error_message);
            }
        } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $unique_id = DataCleansing('num', $data['key']);


                $resultFetch = $pdh->gallery_delete($unique_id);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode($error_message);
            }
        } else if ($_GET['submit'] == 'search_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $search = DataCleansing('num', $data['key']);
                $nk = DataCleansing('num', $data['numData']);

                $resultFetch = $pdh->search($search, $nk);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode($error_message);
            }
        } else if ($_GET['submit'] == 'fetchLatest' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $search = $data['key'];
                $limit = $data['limit'];

                $resultFetch = $pdh->liveUpdate($search, $limit);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode($error_message);
            }
        } else {
            $error_message = "Exception: Unauthorized access";
            echo json_encode($error_message);
        }
}
