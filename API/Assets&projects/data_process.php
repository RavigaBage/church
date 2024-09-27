<?php

require('autoload.php');
$viewDataClass = new AssetProject\viewData;
session_start();
if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'delete_file' && $_GET['user'] == 'true' && $_GET['submit'] != 'fetchlatest') {
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


            $result_data = $viewDataClass->projects_upload($name, $description, $start_date, $end_date, $team, $status, $Image_name, $Image_type, $Image_tmp_name, $target, $current);
            echo json_encode($result_data);
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



            $result_data = $viewDataClass->projects_update($name, $description, $start_date, $end_date, $team, $status, $Image_name, $Image_type, $Image_tmp_name, $target, $current, $unique_id);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = $data['key'];

            $resultFetch = $viewDataClass->projects_delete($unique_id);
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'search' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {

        $data = json_decode(file_get_contents("php://input"), true);
        $name = $data['key'];
        $nk = $data['numData'];

        $resultFetch = $viewDataClass->Project_viewSearchMain($name, $nk);
        echo json_encode($resultFetch);

    } else if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {

        $resultFetch = $viewDataClass->Project_viewExport();
        echo json_encode($resultFetch);

    } else if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'assets') {

        $resultFetch = $viewDataClass->Asset_viewExport();
        echo json_encode($resultFetch);

    } else


        if ($_GET['submit'] == 'true' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $Image_name = $_FILES['imageFile']['name'];
                $Image_type = $_FILES['imageFile']['type'];
                $Image_tmp_name = $_FILES['imageFile']['tmp_name'];
                $size = $_FILES['imageFile']['size'];

                $resultFetch = $viewDataClass->Assets_upload($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $size, $Image_name, $Image_type, $Image_tmp_name, $About);
                echo json_encode($resultFetch);
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

                $resultFetch = $viewDataClass->Assets_update($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $Image_name, $Image_type, $Image_tmp_name, $About, $unique_id);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode($error_message);
            }
        } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $unique_id = $data['key'];

                $resultFetch = $viewDataClass->Assets_delete($unique_id);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'fetchlatest' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $num = $data['key'];

                $resultFetch = $viewDataClass->Assets_liveUpdate($num);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'fetchlatest' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'projects') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $num = $data['key'];

                $resultFetch = $viewDataClass->Projects_liveUpdate($num);
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