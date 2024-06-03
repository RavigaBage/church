<?php
require ('autoloader.php');
if (isset($_GET['submit'])) {
    if ($_GET['submit'] != 'delete_file' && $_GET['submit'] != 'search_file') {
        $Firstname = $_POST['Fname'];
        $Othername = $_POST['Oname'];
        $Age = $_POST['birth'];
        $Position = $_POST['position'];
        $contact = $_POST['contact'];
        $email = '...';
        $password = "zoe-" . $Firstname . $Othername;
        $Address = $_POST['location'];
        $Baptism = $_POST['baptism'];
        $membership_start = "....";
        $username = "...";
        $gender = $_POST['gender'];
        $occupation = $_POST['occupation'];
        $About = '..';
        $status = $_POST['status'];
    }
    if ($_GET['submit'] == 'true' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {

            $Image_name = $_FILES['imageFile']['name'];
            $Image_type = $_FILES['imageFile']['type'];
            $Image_tmp_name = $_FILES['imageFile']['tmp_name'];
            $size = $_FILES['imageFile']['size'];
            $pdh = new viewData();

            $resultFetch = $pdh->member_upload($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $Image_name, $Image_type, $Image_tmp_name);
            echo json_encode(["status" => "errors", "message" => $resultFetch]);
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
            $pdh = new viewData();

            $resultFetch = $pdh->member_update($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $Image_name, $Image_type, $Image_tmp_name, $unique_id);
            echo json_encode(["status" => "errors", "message" => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $unique_id = $data['key'];
            $pdh = new viewData();

            $resultFetch = $pdh->member_delete($unique_id);
            echo json_encode(["status" => "success", "message" => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else if ($_GET['submit'] == 'search_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
            $search = $data['key'];
            $pdh = new viewData();

            $resultFetch = $pdh->search($search);
            echo json_encode(["status" => "success", "message" => $resultFetch]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    } else {
        $error_message = "Exception: Unauthorized access";
        echo json_encode(["status" => "error", "message" => $error_message]);
    }
}
