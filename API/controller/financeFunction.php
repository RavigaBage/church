<?php
include ('../Assets&projects/autoloader.php');
include ('user_check.php');
$viewDataClass = new viewData();


function DeleteItem($name, $viewDataClass)
{
    $delete = $viewDataClass->Assets_delete($name);
    return $delete;
}
$data = json_decode(file_get_contents("php://input"), true);
if (empty($data)) {
    echo json_encode(["status" => "failed", "result" => "Emty fields"]);
} else {
    if (isset($_GET['delete_offertory'])) {
        $id = $data['delete_key'];
        $result_data = $viewDataClass->DeleteRecords($id);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['delete_event'])) {
        $id = $data['delete_key'];
        $result_data = $viewDataClass->delete_dues_records($id);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['delete_event_user'])) {
        $id = $data['delete_key'];
        $form_name = $data['form_name'];
        $result_data = $viewDataClass->user_dues_delete($form_name, $id);
    }
    if (isset($_GET['delete_tithe'])) {
        $id = $data['delete_key'];
        $result_data = $viewDataClass->DeleteTithes($id);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['delete_budget'])) {
        $id = $data['delete_key'];
        $result_data = $viewDataClass->BudgetDelete($id);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['delete_budget_user'])) {
        $id = $data['delete_key'];
        $form_name = $data['form_name'];
        $result_data = $viewDataClass->BudgetDeleteList($form_name, $id);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['delete_transaction'])) {
        $id = $data['delete_key'];
        $form_name = $data['form_name'];
        $result_data = $viewDataClass->TransactionDelete($id);
        json_encode(["status" => "result", "result" => $result_data]);
    }

    if (isset($_GET['Expenses_delete'])) {
        $id = $data['delete_key'];
        $form_name = $data['form_name'];
        $result_data = $viewDataClass->ExpensesDelete($name, $id);
        json_encode(["status" => "result", "result" => $result_data]);

    }

    if (isset($_GET['account_delete'])) {
        $id = $data['delete_key'];
        $result_data = $viewDataClass->Account_delete_Records($id);
        json_encode(["status" => "result", "result" => $result_data]);

    }

    if (isset($_GET['account_user_delete'])) {
        $id = $data['delete_key'];
        $form_name = $data['form_name'];
        $result_data = $viewDataClass->Account_user_delete_Records($name, $id);
        json_encode(["status" => "result", "result" => $result_data]);

    }




    if (isset($_GET['update_offertory'])) {
        $id = $data['unique_id'];
        $name = $data['name'];
        $type = $data['type'];
        $amount = $data['amount'];
        $Purpose = $data['purpose'];
        $date = $data['date'];
        $month = $data['month'];
        $year = $data['year'];
        $result_data = $viewDataClass->UpdateRecords($name, $type, $amount, $purpose, $date, $month, $year, $id);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['delete_event'])) {
        $id = $data['unique_id'];
        $name = $data['name'];
        $department = $data['department'];
        $amount = $data['amount'];
        $Purpose = $data['purpose'];
        $due = $data['due'];
        $result_data = $viewDataClass->update_dues_records($name, $department, $amount, $purpose, $due, $id);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['update_event_user'])) {
        $id = $data['id'];
        $form_name = $data['form_name'];
        $id = $data['unique_id'];
        $name = $data['name'];
        $medium = $data['medium'];
        $user_date = $data['amount'];
        $Purpose = $data['purpose'];
        $unique_id = $data['unique_id'];

        $result_data = $viewDataClass->user_dues_update($name, $medium, $amount, $form_name, $user_date, $id, $unique_id);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['update_tithe'])) {
        $unique_id = $data['unique_id'];
        $Medium_payment = $data['Medium_payment'];
        $description = $data['description'];
        $date_uploaded = $data['date_uploaded'];
        $Purpose = $data['purpose'];
        $date = $data['Date'];
        $month = $data['month'];
        $year = $data['year'];
        $name = $data['name'];
        $result_data = $viewDataClass->UpdateTithes($unique_id, $Medium_payment, $description, $date_uploaded, $name, $amount, $Date, $month, $year);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['update_budget'])) {
        $id = $data['id'];
        $status = $data['status'];
        $authorize = $data['authorize'];
        $about = $data['about'];
        $details = $data['details'];
        $result_data = $viewDataClass->Budget_update($name, $status, $authorize, $about, $details, $id);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['update_budget_user'])) {
        $id = $data['id'];
        $name = $data['name'];
        $category = $data['category'];
        $type = $data['type'];
        $amount = $data['amount'];
        $details = $data['details'];
        $form_name = $data['form_name'];
        $date = $data['date'];
        $month = $data['month'];
        $year = $data['year'];
        $recorded_by = $data['recorded_by'];
        $result_data = $viewDataClass->Budget_list_update($name, $category, $type, $amount, $details, $date, $year, $month, $recorded_by, $id);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['update_transaction'])) {
        $id = $data['id'];
        $account = $data['account'];
        $category = $data['category'];
        $amount = $data['amount'];
        $status = $data['status'];
        $authorize = $data['authorize'];
        $result_data = $viewDataClass->Transaction_update($id, $account, $category, $amount, $status, $authorize);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['update_account'])) {
        $id = $data['id'];
        $name = $data['name'];
        $amount = $data['amount'];
        $created = $data['created'];
        $result_data = $viewDataClass->Account_update_Records($name, $created, $amount, $id);
        json_encode(["status" => "result", "result" => $result_data]);
    }

    if (isset($_GET['update_account_user'])) {
        $id = $data['id'];
        $acc_name = $data['acc_name'];
        $description = $data['description'];
        $date = $data['date'];
        $time = $data['time'];
        $category = $data['category'];
        $percentage = $data['percentage'];
        $amount = $data['amount'];
        $balance = $data['balance'];

        $result_data = $viewDataClass->Account_user_records_update($acc_name, $description, $date, $time, $category, $percentage, $amount, $balance, $id);
        json_encode(["status" => "result", "result" => $result_data]);
    }




    if (isset($_GET['upload_offertory'])) {
        $id = $data['unique_id'];
        $name = $data['name'];
        $type = $data['type'];
        $amount = $data['amount'];
        $Purpose = $data['purpose'];
        $date = $data['date'];
        $month = $data['month'];
        $year = $data['year'];
        $result_data = $viewDataClass->OffertoryRecords($name, $type, $amount, $purpose, $date, $month, $year);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['upload_event'])) {
        $name = $data['name'];
        $department = $data['department'];
        $amount = $data['amount'];
        $Purpose = $data['purpose'];
        $due = $data['due'];
        $result_data = $viewDataClass->Record_dues($name, $department, $amount, $purpose, $due);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['upload_event_user'])) {
        $form_name = $data['form_name'];
        $id = $data['unique_id'];
        $name = $data['name'];
        $medium = $data['medium'];
        $user_date = $data['amount'];
        $Purpose = $data['purpose'];
        $unique_id = $data['unique_id'];

        $result_data = $viewDataClass->Payment_List($name, $amount, $medium, $date, $id);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['upload_tithe'])) {
        $unique_id = $data['unique_id'];
        $Medium_payment = $data['Medium_payment'];
        $description = $data['description'];
        $date_uploaded = $data['date_uploaded'];
        $Purpose = $data['purpose'];
        $date = $data['Date'];
        $month = $data['month'];
        $year = $data['year'];
        $name = $data['name'];
        $result_data = $viewDataClass->OffertoryTithe($unique_id, $Medium_payment, $description, $name, $amount, $date, $month, $year);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['upload_budget'])) {
        $id = $data['id'];
        $status = $data['status'];
        $authorize = $data['authorize'];
        $about = $data['about'];
        $details = $data['details'];
        $result_data = $viewDataClass->Budget_upload($name, $status, $authorize, $about, $details);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['upload_budget_user'])) {
        $id = $data['id'];
        $name = $data['name'];
        $category = $data['category'];
        $type = $data['type'];
        $amount = $data['amount'];
        $details = $data['details'];
        $form_name = $data['form_name'];
        $date = $data['date'];
        $month = $data['month'];
        $year = $data['year'];
        $recorded_by = $data['recorded_by'];
        $result_data = $viewDataClass->Budget_list_upload($name, $category, $type, $amount, $details, $date, $year, $month, $recorded_by);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['upload_transaction'])) {
        $id = $data['id'];
        $account = $data['account'];
        $category = $data['category'];
        $amount = $data['amount'];
        $status = $data['status'];
        $authorize = $data['authorize'];
        $result_data = $viewDataClass->Transaction_update($id, $account, $category, $amount, $status, $authorize);
        json_encode(["status" => "result", "result" => $result_data]);
    }
    if (isset($_GET['upload_account'])) {
        $id = $data['id'];
        $name = $data['name'];
        $amount = $data['amount'];
        $created = $data['created'];
        $result_data = $viewDataClass->Account_load_Records($name, $created, $amount);
        json_encode(["status" => "result", "result" => $result_data]);
    }

    if (isset($_GET['upload_account_user'])) {
        $id = $data['id'];
        $acc_name = $data['acc_name'];
        $description = $data['description'];
        $date = $data['date'];
        $time = $data['time'];
        $category = $data['category'];
        $percentage = $data['percentage'];
        $amount = $data['amount'];
        $balance = $data['balance'];

        $result_data = $viewDataClass->Account_user_records($acc_name, $description, $date, $time, $category, $percentage, $amount, $balance);
        json_encode(["status" => "result", "result" => $result_data]);
    }
}
?>