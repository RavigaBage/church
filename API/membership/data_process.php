<?php
require('autoload.php');
include_once 'upload.php';
session_start();
$pdh = new Membership\viewData();
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
    if ($_GET['submit'] != 'fetchlatest' && $_GET['submit'] != 'delete_file' && $_GET['submit'] != 'search_file' && $_GET['submit'] != 'export') {
        $Firstname = DataCleansing('str', $_POST['Fname']);
        $Othername = DataCleansing('str', $_POST['Oname']);
        $Age = DataCleansing('date', $_POST['birth']);
        $Position = DataCleansing('str', $_POST['position']);
        $contact = DataCleansing('str', $_POST['contact']);
        $email = strtoupper($Firstname[0]) . '' . strtolower($Othername) . '01@zoemember.ch';
        $password = strtolower("zoe-" . $Firstname[0] . $Othername);
        $Address = DataCleansing('str', $_POST['location']);
        $Baptism = DataCleansing('str', $_POST['baptism']);
        $membership_start = "....";
        $username = "...";
        $gender = DataCleansing('str', $_POST['gender']);
        $occupation = DataCleansing('str', $_POST['occupation']);
        $About = '..';
        $status = DataCleansing('str', $_POST['status']);
        $uploaded_file_names = json_decode($_POST['fileNames']);
        if (is_array($uploaded_file_names) && count($uploaded_file_names) > 0) {
            $uploaded_file_names = $uploaded_file_names[0];
        } else {
            $uploaded_file_names = "";
        }
        if (!empty($uploaded_file_name)) {
            if (!is_dir('../images_folder/users/' . $uploaded_file_names)) {
                exit(json_encode('File could not be uploaded'));
            }
        }


    }
    if ($_GET['submit'] == 'true' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $resultFetch = $pdh->member_upload($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $uploaded_file_names);
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }

    } else if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $resultFetch = $pdh->member_export();
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }

    } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {

            $unique_id = DataCleansing('num', $_POST['delete_key']);
            $resultFetch = $pdh->member_update($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $uploaded_file_names, $unique_id);
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = DataCleansing('num', $data['key']);


            $resultFetch = $pdh->member_delete($unique_id);
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
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
            echo json_encode(["status" => "error", "message" => $error_message]);
        }

    } else if ($_GET['submit'] == 'fetchlatest' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $num = $data['key'];

            $resultFetch = $pdh->liveUpdate($num);
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
} else {
    if (!isset($_GET['upload_submit'])) {
        $error_message = "Exception: Unauthorized access";
        echo json_encode(["status" => "error", "message" => $error_message]);
    }

}

