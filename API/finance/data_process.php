<?php
require '../vendor/autoload.php';
session_start();
$pdh = new Finance\ViewData;


function DataCleansing($opt,$data){
    if($opt == 'str'){
        if(dataInstance_string($data) == False){
            echo json_encode("Data cannot contain illegal characters");
            exit();
        }
    }
    if($opt == 'num'){
        if(dataInstance_num($data) == False){
            echo json_encode("Number cannot contain illegal characters");
            exit();
        }
    }
    if($opt == 'arr'){
        if(dataInstance_array($data) == False){
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    if($opt == 'obj'){
        if(dataInstance_object($data) == False){
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    if($opt == 'date'){
        if(dataInstance_date($data) == False){
            echo json_encode("illegal date formate detected");
            exit();
        }
    }

    if($opt == 'bool'){
        if(dataInstance_bool($data) == False){
            echo json_encode("An error occurred please try again");
            exit();
        }
    }
    return $data;
}
function dataInstance_num($data){
    return Intval($data) && is_numeric($data) ? $data : False;
}
function dataInstance_string($data){
    return is_string($data) && !preg_match('/[!@$%^&*()_+=*~;:><?]/',$data) ? $data : False;
}
function dataInstance_bool($data){
    return is_bool($data) ? $data : False;
}
function dataInstance_array($data){
    return is_array($data) ? $data : False;
}
function dataInstance_object($data){
    return is_object($data) ? $data : False;
}
function dataInstance_date($data){
     return ((DateTime::createFromFormat('Y-m-d',$data) !== False))? $data: False;
}


if (isset($_GET['submit']) && !isset($_GET['confirm_name'])) {
    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'upload' && $_GET['user'] == 'true') {
        $Account = DataCleansing('str',$_POST['event']);
        $Category = DataCleansing('str',$_POST['category']);
        $Amount = DataCleansing('num',$_POST['amount']);
        $Date = DataCleansing('date',$_POST['date']);
        $Description = DataCleansing('date',$_POST['description']);

        $requestResponse = $pdh->Record_dues($Account, $Category, $Amount, $Description, $Date);

        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'update' && $_GET['user'] == 'true') {
        $name = DataCleansing('str',$_POST['event']);
        $department = DataCleansing('str',$_POST['category']);
        $amount = DataCleansing('num',$_POST['amount']);
        $due = DataCleansing('date',$_POST['date']);
        $purpose = DataCleansing('date',$_POST['description']);
        $id = $_POST['delete_key'];

        $requestResponse = $pdh->update_dues_records($name, $department, $amount, $purpose, $due, $id);

        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'delete' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = DataCleansing('num',$data['key']);

        $requestResponse = $pdh->delete_dues_records($id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'upload' && $_GET['user'] == 'offertory') {
        $name = DataCleansing('str',$_POST['event']);
        $amount = DataCleansing('num',$_POST['amount']);
        $date = DataCleansing('date',$_POST['Date']);
        $Description = DataCleansing('date',$_POST['description']);
        $splitDate = explode('-', $date);
        $year = $splitDate[0];
        $month = $splitDate[1];
        $requestResponse = $pdh->OffertoryRecords($name, 'offertory', $amount, $Description, $date, $month, $year);
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'update' && $_GET['user'] == 'offertory') {
        $name = DataCleansing('str',$_POST['event']);
        $amount = DataCleansing('num',$_POST['amount']);
        $date = DataCleansing('date',$_POST['Date']);
        $purpose = DataCleansing('date',$_POST['description']);
        $splitDate = explode('-', $date);
        $year = $splitDate[0];
        $month = $splitDate[1];
        $id = $_POST['delete_key'];
        $requestResponse = $pdh->UpdateRecords($name, 'offertory', $amount, $purpose, $date, $month, $year, $id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'delete' && $_GET['user'] == 'offertory') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = DataCleansing('num',$data['key']);

        $requestResponse = $pdh->DeleteRecords($id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'fetchlatest' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $num = $data['key'];
        $requestResponse = $pdh->ListDataDuesLiveUpdate($num);
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'filter' && $_GET['user'] == 'offertory') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = DataCleansing('num',$data['year']);
        $requestResponse = $pdh->ListOffertorySearch($id);
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'fetchlatest' && $_GET['user'] == 'offertory') {
        $data = json_decode(file_get_contents("php://input"), true);
        $num = $data['key'];
        $requestResponse = $pdh->ListOffertoryLiveUpdate($num);
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'search' && $_GET['user'] == 'event') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = DataCleansing('num',$data['id']);
        $name = DataCleansing('str',$data['search']);
        $requestResponse = $pdh->Dues_pay_list_search($id, $name);
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'export_dues' && $_GET['user'] == 'event') {
        $data = json_decode(file_get_contents("php://input"), true);
        $num = DataCleansing('num',$data['num']);
        $requestResponse = $pdh->Dues_pay_list($num);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'export' && $_GET['user'] == 'offertory') {
        $requestResponse = $pdh->ExportOffertory();
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'export' && $_GET['user'] == 'event') {
        $requestResponse = $pdh->ExportOffertory();
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'export' && $_GET['user'] == 'true') {
        $requestResponse = $pdh->ExportList();
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'true' && $_GET['submit'] == 'search' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = DataCleansing('num',$data['key']);
        $nk = DataCleansing('num',$data['numData']);
        $requestResponse = $pdh->ListDataDuesSearch($id, $nk);
        echo json_encode($requestResponse);
    }


    if ($_GET['APICALL'] == 'event' && $_GET['submit'] == 'upload' && $_GET['user'] == 'true') {

        $name = DataCleansing('str',$_POST['name']);
        $amount = DataCleansing('num',$_POST['amount']);
        $date = DataCleansing('date',$_POST['Date']);
        $form_name = DataCleansing('num',$_POST['formName']);
        $medium = DataCleansing('str',$_POST['medium']);

        $requestResponse = $pdh->user_dues_record($name, $medium, $amount, $date, $form_name);
        echo json_encode($requestResponse);
    }


    if ($_GET['APICALL'] == 'event' && $_GET['submit'] == 'update' && $_GET['user'] == 'true') {

        $name = DataCleansing('str',$_POST['name']);
        $amount = DataCleansing('num',$_POST['amount']);
        $date = DataCleansing('date',$_POST['Date']);
        $unique_id = DataCleansing('num',$_POST['delete_key']);
        $form_name = DataCleansing('num',$_POST['formName']);
        $medium = DataCleansing('str',$_POST['medium']);

        $requestResponse = $pdh->user_dues_update($name, $medium, $amount, $form_name, $date, $unique_id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'event' && $_GET['submit'] == 'delete' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = DataCleansing('num',$data['key']);
        $name = DataCleansing('str',$data['name']);

        $requestResponse = $pdh->user_dues_delete($name, $id);
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'transaction' && $_GET['submit'] == 'export' && $_GET['user'] == 'true') {
        $requestResponse = $pdh->TransactionExport();
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'expenses' && $_GET['submit'] == 'export' && $_GET['user'] == 'true') {
        $requestResponse = $pdh->BudgeCategoryListExport();
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'Tithe' && $_GET['submit'] == 'export' && $_GET['user'] == 'true') {
        $requestResponse = $pdh->ExportTithe();
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'transaction' && $_GET['submit'] == 'upload' && $_GET['user'] == 'true') {
        $account = DataCleansing('str',$_POST['account']);
        $category = DataCleansing('str',$_POST['category']);
        $amount = DataCleansing('num',$_POST['amount']);
        $status = DataCleansing('str',$_POST['status_information']);
        $authorize = DataCleansing('str',$_POST['authorize']);
        $date = DataCleansing('date',$_POST['date']);

        $requestResponse = $pdh->Transaction_upload($account, $category, $amount, $status, $authorize, $date);
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'transaction' && $_GET['submit'] == 'update' && $_GET['user'] == 'true') {
        $account = $_POST['account'];
        $category = DataCleansing('str',$_POST['category']);
        $amount = DataCleansing('num',$_POST['amount']);
        $status = DataCleansing('str',$_POST['status_information']);
        $authorize = DataCleansing('str',$_POST['authorize']);
        $date = DataCleansing('date',$_POST['date']);
        $id = DataCleansing('num',$_POST['delete_key']);

        $requestResponse = $pdh->Transaction_update($id, $account, $category, $amount, $status, $authorize, $date);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'transaction' && $_GET['submit'] == 'delete' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['key'];

        $requestResponse = $pdh->TransactionDelete($id);
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'transaction' && $_GET['submit'] == 'fetchlatest' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $num = $data['key'];
        $requestResponse = $pdh->TransactionLiveUpdate($num);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'transaction' && $_GET['submit'] == 'filter' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $category = DataCleansing('str',$data['category']);
        $year = DataCleansing('num',$data['year']);
        $account = DataCleansing('str',$data['account']);
        $nk = DataCleansing('num',$data['numData']);

        $requestResponse = $pdh->TransactionFilter($account, $category, $year, $nk);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'expensis' && $_GET['submit'] == 'upload' && $_GET['user'] == 'true') {
        try{
        $type = $_POST['type'];
        $category = DataCleansing('str',$_POST['category']);
        $amount = DataCleansing('num',$_POST['Amount']);
        $details = DataCleansing('str',$_POST['details']);
        $recorded_by = "Admin";
        $date = DataCleansing('date',$_POST['Date']);
        $splitDate = explode('-', $date);
        $year = $splitDate[0];
        $month = $splitDate[1];

        $requestResponse = $pdh->Budget_list_upload($category, $type, $amount, $details, $date, $year, $month, $recorded_by);
        echo json_encode($requestResponse);
        }catch(\throwable $error){
            echo $error;
        }
    }

    if ($_GET['APICALL'] == 'expensis' && $_GET['submit'] == 'update' && $_GET['user'] == 'true') {
        
        try{
            $type = $_POST['type'];
            $category = DataCleansing('str',$_POST['category']);
            $amount = DataCleansing('num',$_POST['Amount']);
            $details = DataCleansing('str',$_POST['details']);
            $recorded_by = "Admin";
            $date = DataCleansing('date',$_POST['Date']);
            $splitDate = explode('-', $date);
            $year = $splitDate[0];
            $month = $splitDate[1];
            $id = $_POST['delete_key'];
    
            $requestResponse = $pdh->Budget_list_update($category, $type, $amount, $details, $date, $year, $month, $recorded_by, $id);
            echo json_encode($requestResponse);
        }catch(\Throwable $error){
            echo $error;
        }
        
    }

    if ($_GET['APICALL'] == 'expensis' && $_GET['submit'] == 'delete' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = DataCleansing('str',$data['key']);
        $year = date('Y');

        $requestResponse = $pdh->BudgetDeleteList($year, $id);
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'expensis' && $_GET['submit'] == 'fetchlatest' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $num = $data['key'];
        $requestResponse = $pdh->ExpensesLiveUpdate($num);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'expensis' && $_GET['submit'] == 'filter' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $category = DataCleansing('str',$data['category']);
        $year = DataCleansing('num',$data['year']);
        $nk = DataCleansing('num',$data['numData']);

        $requestResponse = $pdh->BudgeCategoryListFilter($year, $category, $nk);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'expensis' && $_GET['submit'] == 'search' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $name = DataCleansing('num',$data['key']);
        $nk = DataCleansing('num',$data['numData']);

        $requestResponse = $pdh->TitheSearch($name, $nk);
        echo json_encode($requestResponse);
    }


    if ($_GET['APICALL'] == 'tithe' && $_GET['submit'] == 'upload' && $_GET['user'] == 'true') {
        $amount = DataCleansing('num',$_POST['amount']);
        $details = DataCleansing('str',$_POST['details']);
        $recorded_by = "Admin";
        $name = DataCleansing('str',$_POST['Name']);
        $date = DataCleansing('date',$_POST['Date']);
        $Medium_payment = DataCleansing('str',$_POST['medium']);
        $splitDate = explode('-', $date);
        $year = $splitDate[0];
        $month = $splitDate[1];
        $requestResponse = $pdh->OffertoryTithe($name, $Medium_payment, $details, $amount, $date, $month, $year);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'tithe' && $_GET['submit'] == 'update' && $_GET['user'] == 'true') {
        $amount = DataCleansing('num',$_POST['amount']);
        $details = DataCleansing('str',$_POST['details']);
        $recorded_by = "Admin";
        $name = DataCleansing('str',$_POST['Name']);
        $date = DataCleansing('date',$_POST['Date']);
        $Medium_payment = DataCleansing('str',$_POST['medium']);
        $splitDate = explode('-', $date);
        $year = $splitDate[0];
        $month = $splitDate[1];

        $requestResponse = $pdh->UpdateTithes($name, $Medium_payment, $details, $amount, $date, $month, $year);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'tithe' && $_GET['submit'] == 'delete' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = DataCleansing('num',$data['key']);

        $requestResponse = $pdh->DeleteTithes($id);
        echo json_encode($requestResponse);
    }

    if ($_GET['APICALL'] == 'tithe' && $_GET['submit'] == 'fetchlatest' && $_GET['user'] == 'true') {
        $data = json_decode(file_get_contents("php://input"), true);
        $num = $data['key'];
        $requestResponse = $pdh->TitheLiveUpdate($num);
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'account' && $_GET['submit'] == 'true' && $_GET['user'] == 'true') {
        $name = $_POST['account'];
        $created = DataCleansing('date',$_POST['date']);
        $amount = DataCleansing('num',$_POST['amount']);
        $requestResponse = $pdh->Account_load_Records($name, $created, $amount);
        echo json_encode($requestResponse);
    }
    if ($_GET['APICALL'] == 'account' && $_GET['submit'] == 'delete' && $_GET['user'] == 'true') {
        $name = json_decode(file_get_contents("php://input"), true)['account'];
        $requestResponse = $pdh->Account_delete_Records($name);
        echo json_encode($requestResponse);
    }
    if($_GET['APICALL']=='analysis' && $_GET['submit'] == 'fetch' && $_GET['user'] == 'Admin'){
        $year = json_decode(file_get_contents("php://input"), true)['account'];
        $requestResponse = $pdh-> ChartAnalysis($year);
        echo json_encode($requestResponse);
    }


}else if($_GET['confirm_name']){
    $data = json_decode(file_get_contents('php://input'),true);
    echo json_encode($pdh->Confirm_name($data['name']));
}
