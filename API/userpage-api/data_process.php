<?php
require('autoloader.php');
if (isset($_GET['submit'])) {
    $pdh = new viewData();
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
}