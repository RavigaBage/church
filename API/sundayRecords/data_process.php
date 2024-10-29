<?php
session_start();
require '../vendor/autoload.php';
$pdh = new Records\ViewData;

if (isset($_GET['submit'])) {
    if ($_GET['APICALL'] != 'record' && $_GET['submit'] != 'delete' && $_GET['submit'] != 'delete_ini' && $_GET['submit'] != 'filter' && $_GET['submit'] != 'export') {
        $opening_prayer = $_POST['opening_prayer'];
        $praises = $_POST['praises'];
        $scripture_reading = $_POST['scripture_reading'];
        $scripture = $_POST['scripture'];
        $Opening_Hymn = $_POST['opening_Hymn'];
        $Hymn_new = $_POST['Hymn_new'];
        $Hymn_title = $_POST['Hymn_title'];
        $worship = $_POST['worship'];
        $testimonies = $_POST['testimonies'];
        $song_thanksgving_offering = $_POST['song_thanksgving_offering'];
        $sermon_prayer = $_POST['sermon_prayer'];
        $sermon_from = $_POST['sermon_from'];
        $scripture_preacher = $_POST['scripture_preacher'];
        $peacher_duration = $_POST['peacher_duration'];
        $alter_call = $_POST['alter_call'];
        $tithe_offering = $_POST['tithe_offering'];
        $special_appeal = $_POST['special_appeal'];
        $welcome_visitors = $_POST['welcome_visitors'];
        $Announcement = $_POST['Announcement'];
        $closing_prayer = $_POST['closing_prayer'];
        $Benediction = $_POST['Benediction'];
        $MC = $_POST['MC'];
        $total_attendance = $_POST['Total_attendance'];
        $date = $_POST['date'];
    }
    if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {

            $result_data = $pdh->sunday_export();
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else
        if ($_GET['submit'] == 'upload' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $result_data = $pdh->sunday_upload($opening_prayer, $praises, $scripture_reading, $scripture, $Opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $total_attendance, $date);
                echo json_encode(["status" => "success", "message" => $result_data]);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'update' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $unique_id = $_POST['delete_key'];

                $result_data = $pdh->sunday_update($opening_prayer, $praises, $scripture_reading, $scripture, $Opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $total_attendance, $date, $unique_id);
                echo json_encode(["status" => "success", "message" => $result_data]);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'delete' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $unique_id = $data['key'];
                $resultFetch = $pdh->sunday_delete($unique_id);
                echo json_encode(["status" => "success", "message" => $resultFetch]);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'filter' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $unique_id = $data['key'];
                $resultFetch = $pdh->ministries_filter($unique_id);
                echo json_encode(["status" => "success", "message" => trim($resultFetch)]);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        } else if ($_GET['submit'] == 'delete_ini' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
            try {
                $data = json_decode(file_get_contents("php://input"), true);
                $unique_id = $data['key'];
                $resultFetch = $pdh->ministries_delete_inidividual($unique_id);
                echo json_encode(["status" => "success", "message" => $resultFetch]);
            } catch (Exception $e) {
                $error_message = "Exception: " . $e->getMessage();
                echo json_encode(["status" => "error", "message" => $error_message]);
            }
        }
    if ($_GET['submit'] == 'upload' && $_GET['APICALL'] == 'record' && $_GET['user'] == 'true') {
        try {

            $category = $_POST['category'];
            $details = $_POST['details'];
            $year = $_POST['year'];
            $result_data = $pdh->church_record_upload($category, $category, $details, $year);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
    if ($_GET['submit'] == 'update' && $_GET['APICALL'] == 'record' && $_GET['user'] == 'true') {
        try {
            $category = $_POST['category'];
            $details = $_POST['details'];
            $year = $_POST['year'];
            $id = $_POST['delete_key'];
            $result_data = $pdh->church_record_update($category, $category, $details, $id, $year);
            echo json_encode($result_data);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
    if ($_GET['submit'] == 'delete' && $_GET['APICALL'] == 'record' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = $data['key'];
            $resultFetch = $pdh->church_record_delete($unique_id);
            echo json_encode(["status" => "success", "message" => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
    if ($_GET['submit'] == 'export' && $_GET['APICALL'] == 'record' && $_GET['user'] == 'true') {
        try {
            $resultFetch = $pdh->church_record_export();
            echo json_encode($resultFetch);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }


}