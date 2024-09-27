<?php
require '../vendor/autoload.php';
session_start();
$viewDataClass = new Partnership\viewData();

if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'upload_ind' && $_GET['submit'] != 'fetchlatest' && $_GET['submit'] != 'delete_file' && $_GET['submit'] != 'delete_ini' && $_GET['submit'] != 'filter' && $_GET['submit'] != 'export') {
        $name = $_POST['name'];
        $partnership = $_POST['amount'];
        $email = $_POST['email'];
        $status = $_POST['status'];
        $date = $_POST['date'];
        $type = $_POST['type'];
        $period = $_POST['period'];
    }
    if ($_GET['submit'] == 'fetchlatest' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $num = $data['key'];
            $result_data = $viewDataClass->partnership_liveUpdate($num);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'upload_ind' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $name = $_POST['delete_key'];
            $amount = $_POST['amount'];
            $date = date('Y-m-d');
            $result_data = $viewDataClass->partnership_view_individual_record_upload($name, 'house', $date, $amount);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else
        if ($_GET['submit'] == 'upload' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {

                $result_data = $viewDataClass->ministries_upload($name, $partnership, $date, $status, $email, $type, $period)
                ;
                echo json_encode($result_data);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $unique_id = $_POST['delete_key'];
                $result_data = $viewDataClass->ministries_update($name, $partnership, $date, $status, $email, $type, $period, $unique_id);
                echo json_encode($result_data);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $unique_id = $data['key'];


                $resultFetch = $viewDataClass->ministries_delete($unique_id);
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


                $resultFetch = $viewDataClass->ministries_filterSearch($search, $nk);
                echo json_encode(trim($resultFetch));
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {

                $resultFetch = $viewDataClass->partnership_export();
                echo json_encode(trim($resultFetch));
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'delete_ini' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $unique_id = $data['key'];


                $resultFetch = $viewDataClass->ministries_delete_inidividual($unique_id);
                echo json_encode($resultFetch);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        }


}