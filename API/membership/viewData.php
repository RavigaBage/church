<?php
class viewData extends fetchData
{

    public function member_upload($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $Image, $Image_type, $Image_tmp_name)
    {
        $RecordsResult = $this->member_upload_data($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $Image, $Image_type, $Image_tmp_name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }

    public function member_update($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $Image_name, $Image_type, $Image_tmp_name, $unique_id)
    {
        $RecordsResult = $this->member_update_data($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $Image_name, $Image_type, $Image_tmp_name, $unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }
    public function member_delete($name)
    {
        $RecordsResult = $this->member_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function viewList($num)
    {
        $RecordsResult = $this->member_view($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function member_export()
    {
        $RecordsResult = $this->member_view_export();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function search($name, $nk)
    {
        $RecordsResult = $this->search_data($name, $nk);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }


}