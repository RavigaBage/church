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
    public function Account_delete_Records($name)
    {
        $RecordsResult = $this->Account_delete_data($name);
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

    public function Account_user_records($acc_name, $description, $date, $time, $category, $percentage, $amount, $balance)
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
    public function OffertoryTithe($unique_id, $Medium_payment, $description, $name, $amount, $date, $month, $year)
    {
        $RecordsResult = $this->Tithe_Records($unique_id, $Medium_payment, $description, $name, $amount, $date, $month, $year);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function UpdateTithes($unique_id, $Medium_payment, $description, $date_uploaded, $name, $amount, $Date, $month, $year)
    {
        $RecordsResult = $this->Tithe_Records_update($unique_id, $Medium_payment, $description, $date_uploaded, $name, $amount, $Date, $month, $year);
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

    public function user_dues_update($name, $medium, $amount, $form_name, $user_date, $id, $unique_id)
    {
        $RecordsResult = $this->Dues_user_update($name, $medium, $amount, $form_name, $user_date, $id, $unique_id);
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
    public function Transaction_upload($account, $category, $amount, $status, $authorize)
    {
        $RecordsResult = $this->Tansaction($account, $category, $amount, $status, $authorize);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Transaction_update($id, $account, $category, $amount, $status, $authorize)
    {
        $RecordsResult = $this->Transaction_update($id, $account, $category, $amount, $status, $authorize);
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


    public function Budget_list_upload($name, $category, $type, $amount, $details, $date, $year, $month, $recorded_by)
    {
        $RecordsResult = $this->Budget_user($name, $category, $type, $amount, $details, $date, $year, $month, $recorded_by);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Budget_list_update($name, $category, $type, $amount, $details, $date, $year, $month, $recorded_by, $id)
    {
        $RecordsResult = $this->Budget_user_update($name, $category, $type, $amount, $details, $date, $year, $month, $recorded_by, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function BudgetDeleteList($form_name, $id)
    {
        $RecordsResult = $this->Budget_delete_user_data($form_name, $id);
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
    public function BudgetList($name, $year)
    {
        $RecordsResult = $this->Budget_list($name, $year);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function ExpensesList($name, $year)
    {
        $RecordsResult = $this->Expenses_list($name, $year);
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
        ;
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }

    }
    public function ListData()
    {
        $RecordsResult = $this->list_Info();
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

}