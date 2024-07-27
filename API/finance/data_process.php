<?php
require ('autoloader.php');
$pdh = new viewData();

if(isset($_GET['submit'])){
    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'upload'  && $_GET['user'] == 'true') {
        $Account = $_POST['event'];
        $Category = $_POST['category'];
        $Amount = $_POST['amount'];
        $Date = $_POST['date'];
        $Description = $_POST['description'];

        $requestResponse = $pdh->Record_dues($Account, $Category, $Amount, $Description, $Date);

        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'update'  && $_GET['user'] == 'true') {
        $name = $_POST['event'];
        $department = $_POST['category'];
        $amount = $_POST['amount'];
        $due = $_POST['date'];
        $purpose = $_POST['description'];
        $id = $_POST['delete_key'];

        $requestResponse = $pdh->update_dues_records($name, $department, $amount, $purpose, $due, $id);

        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'delete'  && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['key'];

        $requestResponse = $pdh->delete_dues_records($id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'upload'  && $_GET['user'] == 'offertory') {
        $name = $_POST['event'];
        $amount = $_POST['amount'];
        $date = $_POST['Date'];
        $Description = $_POST['description'];
        $splitDate = explode('-',$date);
        $year = $splitDate[0];
        $month = $splitDate[1];
        $requestResponse = $pdh->OffertoryRecords($name, 'offertory', $amount, $Description, $date, $month, $year);
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'update'  && $_GET['user'] == 'offertory') {
        $name = $_POST['event'];
        $amount = $_POST['amount'];
        $date = $_POST['Date'];
        $Description = $_POST['description'];
        $splitDate = explode('-',$date);
        $year = $splitDate[0];
        $month = $splitDate[1];
        $id = $_POST['delete_key'];
        $requestResponse = $pdh->UpdateRecords($name, 'offertory', $amount, $Description, $date, $month, $year, $id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'delete'  && $_GET['user'] == 'offertory') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['key'];

        $requestResponse = $pdh->DeleteRecords($id);
        echo json_encode($requestResponse);
    }


    if ($_GET['APICALL'] == 'event' && $_GET['submit'] == 'upload'  && $_GET['user'] == 'true') {

        $name = $_POST['name'];
        $amount = $_POST['amount'];
        $date = $_POST['Date'];
        $form_name = $_POST['formName'];
        $medium = $_POST['medium'];

        $requestResponse = $pdh->user_dues_record($name, $medium, $amount,$date, $form_name);
        echo json_encode($requestResponse);
    }


    if ($_GET['APICALL'] == 'event' && $_GET['submit'] == 'update'  && $_GET['user'] == 'true') {

        $name = $_POST['name'];
        $amount = $_POST['amount'];
        $date = $_POST['Date'];
        $unique_id = $_POST['delete_key'];
        $form_name = $_POST['formName'];
        $medium = $_POST['medium'];

        $requestResponse = $pdh->user_dues_update($name, $medium, $amount, $form_name, $date, $unique_id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'event' && $_GET['submit'] == 'delete'  && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['key'];
        $name = $data['name'];

        $requestResponse = $pdh->user_dues_delete($name, $id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'transaction' && $_GET['submit'] == 'upload'  && $_GET['user'] == 'true') {

        $account = $_POST['account'];
        $category = $_POST['category'];
        $amount = $_POST['amount'];
        $status = $_POST['status_information'];
        $authorize = $_POST['authorize'];
        $date = $_POST['date'];

        $requestResponse = $pdh->Transaction_upload($account, $category, $amount, $status, $authorize,$date);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'transaction' && $_GET['submit'] == 'update'  && $_GET['user'] == 'true') {
        $account = $_POST['account'];
        $category = $_POST['category'];
        $amount = $_POST['amount'];
        $status = $_POST['status_information'];
        $authorize = $_POST['authorize'];
        $date = $_POST['date'];
        $id = $_POST['delete_key'];

        $requestResponse = $pdh->Transaction_update($id, $account, $category, $amount, $status, $authorize,$date);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'transaction' && $_GET['submit'] == 'delete'  && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['key'];

        $requestResponse = $pdh->TransactionDelete($id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'transaction' && $_GET['submit'] == 'filter'  && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $category = $data['category'];
        $year = $data['year'];
        $account = $data['account'];

        $requestResponse = $pdh->TransactionFilter($account,$category,$year);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'expensis' && $_GET['submit'] == 'upload'  && $_GET['user'] == 'true') {
        
        $type = $_POST['type'];
        $category = $_POST['category'];
        $amount = $_POST['Amount'];
        $details = $_POST['details'];
        $recorded_by = "Admin";
        $date = $_POST['Date'];
        $splitDate = explode('-',$date);
        $year = $splitDate[0];
        $month = $splitDate[1];

        $requestResponse = $pdh->Budget_list_upload($category, $type, $amount, $details, $date, $year, $month, $recorded_by);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'expensis' && $_GET['submit'] == 'update'  && $_GET['user'] == 'true') {
        $type = $_POST['type'];
        $category = $_POST['category'];
        $amount = $_POST['Amount'];
        $details = $_POST['details'];
        $recorded_by = "Admin";
        $date = $_POST['Date'];
        $splitDate = explode('-',$date);
        $year = $splitDate[0];
        $month = $splitDate[1];
        $id = $_POST['delete_key'];

        $requestResponse = $pdh->Budget_list_update($category, $type, $amount, $details, $date, $year, $month, $recorded_by, $id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'expensis' && $_GET['submit'] == 'delete'  && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['key'];
        $date = $data['date'];
        $year = date('Y');

        $requestResponse = $pdh->BudgetDeleteList($year, $id);
        echo json_encode($requestResponse);
    }
    
    if ($_GET['APICALL'] == 'expensis' && $_GET['submit'] == 'filter'  && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $category = $data['category'];
        $year = $data['year'];

        $requestResponse = $pdh->BudgeCategoryListFilter($year, $category);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'tithe' && $_GET['submit'] == 'upload'  && $_GET['user'] == 'true') {
        
        $amount = $_POST['amount'];
        $details = $_POST['details'];
        $recorded_by = "Admin";
        $name = $_POST['Name'];
        $date = $_POST['Date'];
        $Medium_payment = $_POST['medium'];
        $splitDate = explode('-',$date);
        $year = $splitDate[0];
        $month = $splitDate[1];
        $requestResponse = $pdh->OffertoryTithe($name, $Medium_payment, $details, $amount, $date, $month, $year);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'tithe' && $_GET['submit'] == 'update'  && $_GET['user'] == 'true') {
        $amount = $_POST['amount'];
        $details = $_POST['details'];
        $recorded_by = "Admin";
        $name = $_POST['Name'];
        $date = $_POST['Date'];
        $Medium_payment = $_POST['medium'];
        $splitDate = explode('-',$date);
        $year = $splitDate[0];
        $month = $splitDate[1];

        $requestResponse = $pdh->UpdateTithes($name, $Medium_payment, $details, $amount, $date, $month, $year);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'tithe' && $_GET['submit'] == 'delete'  && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['key'];

        $requestResponse = $pdh->DeleteTithes($id);
        echo json_encode($requestResponse);
    }
    





}
// if (isset($_GET['submit'])) {
//     if ($_GET['submit'] != 'delete_file' && $_GET['submit'] != 'search_file') {
//         $Firstname = $_POST['Fname'];
//         $Othername = $_POST['Oname'];
//         $Age = $_POST['birth'];
//         $Position = $_POST['position'];
//         $contact = $_POST['contact'];
//         $email = '...';
//         $password = "zoe-" . $Firstname . $Othername;
//         $Address = $_POST['location'];
//         $Baptism = $_POST['baptism'];
//         $membership_start = "....";
//         $username = "...";
//         $gender = $_POST['gender'];
//         $occupation = $_POST['occupation'];
//         $About = '..';
//         $status = $_POST['status'];
//     }
//     if ($_GET['submit'] == 'true' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
//         try {

//             $Image_name = $_FILES['imageFile']['name'];
//             $Image_type = $_FILES['imageFile']['type'];
//             $Image_tmp_name = $_FILES['imageFile']['tmp_name'];
//             $size = $_FILES['imageFile']['size'];
//             $pdh = new viewData();

//             $resultFetch = $pdh->member_upload($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $Image_name, $Image_type, $Image_tmp_name);
//             echo json_encode(["status" => "errors", "message" => $resultFetch]);
//         } catch (Exception $e) {
//             $error_message = "Exception: " . $e->getMessage();
//             echo json_encode(["status" => "error", "message" => $error_message]);
//         }

//     } else if ($_GET['submit'] == 'update_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
//         try {
//             $Image_name = $_FILES['imageFile']['name'];
//             $Image_type = $_FILES['imageFile']['type'];
//             $Image_tmp_name = $_FILES['imageFile']['tmp_name'];
//             $unique_id = $_POST['delete_key'];
//             $pdh = new viewData();

//             $resultFetch = $pdh->member_update($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $Image_name, $Image_type, $Image_tmp_name, $unique_id);
//             echo json_encode(["status" => "errors", "message" => $resultFetch]);
//         } catch (Exception $e) {
//             $error_message = "Exception: " . $e->getMessage();
//             echo json_encode(["status" => "error", "message" => $error_message]);
//         }
//     } else if ($_GET['submit'] == 'delete_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
//         try {
//             $data = json_decode(file_get_contents("php://input"), true);
//             $unique_id = $data['key'];
//             $pdh = new viewData();

//             $resultFetch = $pdh->member_delete($unique_id);
//             echo json_encode(["status" => "success", "message" => $resultFetch]);
//         } catch (Exception $e) {
//             $error_message = "Exception: " . $e->getMessage();
//             echo json_encode(["status" => "error", "message" => $error_message]);
//         }
//     } else if ($_GET['submit'] == 'search_file' && $_GET['APICALL'] == 'true' && $_GET['user'] == 'true') {
//         try {
//             $data = json_decode(file_get_contents("php://input"), true);
//             $search = $data['key'];
//             $pdh = new viewData();

//             $resultFetch = $pdh->search($search);
//             echo json_encode(["status" => "success", "message" => $resultFetch]);
//         } catch (Exception $e) {
//             $error_message = "Exception: " . $e->getMessage();
//             echo json_encode(["status" => "error", "message" => $error_message]);
//         }
//     } else {
//         $error_message = "Exception: Unauthorized access";
//         echo json_encode(["status" => "error", "message" => $error_message]);
//     }
// }
