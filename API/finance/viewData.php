<?php
class viewData extends fetchData
{
    public function Account_load_Records($name, $created, $amount)
    {
        $RecordsResult = $this->Account_Records($name, $created, $amount);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Account_update_Records($name, $created, $amount, $id)
    {
        $RecordsResult = $this->Account_update($name, $created, $amount, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Account_delete_Records($name, $id)
    {
        $RecordsResult = $this->Account_delete_data($name, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Account_user_delete_Records($form_name, $unique_id)
    {
        $RecordsResult = $this->Account_user_delete_data($form_name, $unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Account_user_upload_records($acc_name, $description, $date, $time, $category, $percentage, $amount, $balance)
    {
        $RecordsResult = $this->Account_user_Records($acc_name, $description, $date, $time, $category, $percentage, $amount, $balance);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Account_user_records_update($acc_name, $description, $date, $time, $category, $percentage, $amount, $balance, $id)
    {
        $RecordsResult = $this->Account_user_update($acc_name, $description, $date, $time, $category, $percentage, $amount, $balance, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }


    public function OffertoryRecords($name, $type, $amount, $purpose, $date, $month, $year)
    {
        $RecordsResult = $this->offertory_Records($name, $type, $amount, $purpose, $date, $month, $year);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function UpdateRecords($name, $type, $amount, $purpose, $date, $month, $year, $id)
    {
        $RecordsResult = $this->RecordsUpdate($name, $type, $amount, $purpose, $date, $month, $year, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function DeleteRecords($name)
    {
        $RecordsResult = $this->Record_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function OffertoryTithe($unique_id, $Medium_payment, $description, $amount, $date, $month, $year)
    {
        $RecordsResult = $this->Tithe_Records($unique_id, $Medium_payment, $description, $amount, $date, $month, $year);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return json_encode($Error);
        } else {
            return json_encode($RecordsResult);
        }
    }
    public function UpdateTithes($unique_id, $Medium_payment, $description, $amount, $Date, $month, $year)
    {
        $RecordsResult = $this->Tithe_Records_update_data($unique_id, $Medium_payment, $description, $amount, $Date, $month, $year);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function DeleteTithes($name)
    {
        $RecordsResult = $this->Tithe_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Payment_List($name, $amount, $medium, $date, $id)
    {
        $RecordsResult = $this->PayList($name, $amount, $medium, $date, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Record_dues($name, $department, $amount, $purpose, $due)
    {
        $RecordsResult = $this->Dues_Records($name, $department, $amount, $purpose, $due);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function update_dues_records($name, $department, $amount, $purpose, $due, $id)
    {
        $RecordsResult = $this->Dues_Records_update($name, $department, $amount, $purpose, $due, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function delete_dues_records($name)
    {
        $RecordsResult = $this->Dues_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function user_dues_record($name, $medium, $amount,  $user_date, $unique_id)
    {
        $RecordsResult = $this->Dues_user_record($name, $medium, $amount,  $user_date, $unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function user_dues_update($name, $medium, $amount, $form_name, $user_date,  $unique_id)
    {
        $RecordsResult = $this->Dues_user_update($name, $medium, $amount, $form_name, $user_date,  $unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function user_dues_delete($form_name, $unique_id)
    {
        $RecordsResult = $this->Dues_user_delete_data($form_name, $unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Transaction_upload($account, $category, $amount, $status, $authorize,$date)
    {
        $RecordsResult = $this->Transaction($account, $category, $amount, $status, $authorize,$date);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Transaction_update($id, $account, $category, $amount, $status, $authorize,$date)
    {
        $RecordsResult = $this->Transaction_update_data($id, $account, $category, $amount, $status, $authorize,$date);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function TransactionDelete($name)
    {
        $RecordsResult = $this->Transaction_delete($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function TransactionFilter($account,$category,$year)
    {
        $RecordsResult = $this-> TransactionListFilter($account, $category,$year);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

   
    #to fix
    public function Budget_upload($name, $status, $authorize, $about, $details)
    {
        $RecordsResult = $this->Budget($name, $status, $authorize, $about, $details);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Budget_update($name, $status, $authorize, $about, $details, $id)
    {
        $RecordsResult = $this->Budget_update($name, $status, $authorize, $about, $details, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function BudgetDelete($name)
    {
        $RecordsResult = $this->Budget_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    #end_to_fix
    public function Budget_list_upload($category, $type, $amount, $details, $date, $year, $month, $recorded_by)
    {
        $RecordsResult = $this->Add_Budget_user($category, $type, $amount, $details, $date, $year, $month, $recorded_by);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Budget_list_update($category, $type, $amount, $details, $date, $year, $month, $recorded_by, $id)
    {
        $RecordsResult = $this->Budget_user_update($category, $type, $amount, $details, $date, $year, $month, $recorded_by, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function BudgetDeleteList($year, $id)
    {
        $RecordsResult = $this->Budget_delete_user_data($year, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Records_membership()
    {
        $RecordsResult = $this->membership_Records();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }


    public function BudgetDataList()
    {
        $RecordsResult = $this->Budget_data_list();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function BudgetList($year)
    {
        $RecordsResult = $this->Budget_list($year);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return json_encode($RecordsResult);
        }
    }

    public function BudgeCategoryList()
    {
        $RecordsResult = $this->Budget_list_category();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return "$RecordsResult";
        }
    }

    public function BudgeCategoryListFilter($year, $category)
    {
        $RecordsResult = $this->Budget_list_categoryFilter($year,$category);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return "$RecordsResult";
        }
    }
    

    

    #to fix
    public function ExpensesList($year)
    {
        $RecordsResult = $this->Expenses_list($year);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function ExpensesListFilter($name, $year, $month)
    {
        $RecordsResult = $this->Expenses_list_filter($name, $year, $month);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    
    public function ExpensesDelete($name, $id)
    {
        $RecordsResult = $this->Expenses_Delete($name, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function TransactionList($num)
    {
        $RecordsResult = $this->TransactionListData($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Records_usernames()
    {
        $RecordsResult = $this->Usernames();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Dues_pay_list($id)
    {
        $RecordsResult = $this->Pay_list_Info($id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }

    }
    
    public function ListDataDues($num)
    {
        $RecordsResult = $this->list_Info_Dues($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function DuesPages(){
        $RecordsResult = $this->Dues_pages();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Trans_Pages(){
        $RecordsResult = $this->Transaction_pages();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function ListData($num)
    {
        $RecordsResult = $this->list_Info($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function TitheData($num)
    {
        $RecordsResult = $this->list_Info_tithe($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function TitheSearch($name)
    {
        $RecordsResult = $this->list_search_tithe($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function ContributionList()
    {
        $RecordsResult = $this->c_calc();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Accounts_list_view(){
        $RecordsResult = $this->Accounts_list();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Accounts_list_Data(){
        $RecordsResult = $this->AccountListData();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }



    public function Accounts_list_Card(){
        $RecordsResult = $this->Accounts_listCard();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    
    

}