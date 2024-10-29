<?php
require '../vendor/autoload.php';
require 'upload.php';
$pdh = new UserApi\viewData();
$upload_file_system = new UploadData();
if(isset($_GET['upload_submit'])){
    $upload_status = json_decode($upload_file_system->file_registry());
    if(is_object($upload_status)){
        if($upload_status->status == 'success'){
            $Image_name = $upload_status->name;
            $resultFetch = $pdh->Image_upload($_POST['upload_token'], $Image_name);
            echo json_encode($resultFetch);
        }
    }
}

if (isset($_GET['submit'])) {

    if ($_GET['request'] == 'uploadImage' && $_GET['user'] == 'true') {
        $Image_name = $_FILES['file']['name'];
        $Image_type = $_FILES['file']['type'];
        $Image_tmp_name = $_FILES['file']['tmp_name'];
        $size = $_FILES['file']['size'];
        $unique_id = $_POST['key'];
        $resultFetch = $pdh->Image_upload($unique_id, $Image_name, $Image_type, $Image_tmp_name);
        echo json_encode($resultFetch);
    }
    if ($_GET['request'] == 'uploadData' && $_GET['user'] == 'true') {
        $unique_id = $_POST['delete_key'];
        $Name = $_POST['Fname'];
        $OtherName = $_POST['Oname'];
        $contact = $_POST['contact'];
        $Email = $_POST['Email'];
        $About = $_POST['About'];
        $Address = $_POST['location'];
        $unique_id = $_POST['delete_key'];

        $resultFetch = $pdh->personalData_set($unique_id, $Name, $OtherName, $Email, $contact, $About, $Address);
        echo json_encode($resultFetch);
    }

    if ($_GET['request'] == 'uploadData' && $_GET['user'] == 'true') {
        $unique_id = $_POST['delete_key'];
        $Name = $_POST['Fname'];
        $OtherName = $_POST['Oname'];
        $contact = $_POST['contact'];
        $Email = $_POST['Email'];
        $About = $_POST['About'];
        $Address = $_POST['location'];
        $unique_id = $_POST['delete_key'];

        $resultFetch = $pdh->personalData_set($unique_id, $Name, $OtherName, $Email, $contact, $About, $Address);
        echo json_encode($resultFetch);
    }
    if ($_GET['request'] == 'password' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $Email = $data['Email'];
        $id = $data['unique_id'];
        $resultFetch = $pdh->Password_request($Email, $id);
        echo json_encode($resultFetch);
    }

}