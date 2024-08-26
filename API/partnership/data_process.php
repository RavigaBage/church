<?php
require('autoloader.php');
if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'delete_file' && $_GET['submit'] != 'delete_ini' && $_GET['submit'] != 'filter' && $_GET['submit'] != 'export') {
        $name = $_POST['name'];
        $partnership = $_POST['amount'];
        $email = $_POST['email'];
        $status = $_POST['status'];
        $date = $_POST['date'];
        $type = $_POST['type'];
        $period = $_POST['period'];
    }
    if ($_GET['submit'] == 'upload' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $viewDataClass = new viewData();
            $result_data = $viewDataClass->ministries_upload($name, $partnership, $date, $status, $email, $type, $period)
            ;
            json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $unique_id = $_POST['delete_key'];



            $viewDataClass = new viewData();
            $result_data = $viewDataClass->ministries_update($name, $partnership, $date, $status, $email, $type, $period, $unique_id);
            json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = $data['key'];
            $pdh = new viewData();

            $resultFetch = $pdh->ministries_delete($unique_id);
            echo json_encode(["status" => "success", "message" => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'filter' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $search = $data['key'];
            $nk = $data['numData'];
            $pdh = new viewData();

            $resultFetch = $pdh->ministries_filterSearch($search, $nk);
            echo json_encode(trim($resultFetch));
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $pdh = new viewData();
            $resultFetch = $pdh->partnership_export();
            echo json_encode(trim($resultFetch));
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'delete_ini' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = $data['key'];
            $pdh = new viewData();

            $resultFetch = $pdh->ministries_delete_inidividual($unique_id);
            echo json_encode(["status" => "success", "message" => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }


}