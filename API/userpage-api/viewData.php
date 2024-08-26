<?php
class viewData extends fetchData
{

    public function Image_upload($unique_id, $Image, $Image_type, $Image_tmp_name)
    {
        $RecordsResult = $this->user_upload_data($unique_id, $Image, $Image_type, $Image_tmp_name);
        return $RecordsResult;
    }

    public function Tithe_viewList($unique_id, $num)
    {
        $RecordsResult = $this->user_list_Info_tithe($unique_id, $num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Notification_viewList($unique_id)
    {
        $RecordsResult = $this->notification($unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function transactionList_view($unique_id)
    {
        $RecordsResult = $this->transactionList($unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }

    }
    public function paymentList_view($unique_id)
    {
        $RecordsResult = $this->paymentList($unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }

    }
    public function ministries_viewList($unique_id)
    {
        $RecordsResult = $this->ministries_view($unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Bio_viewList($unique_id, $About)
    {
        $RecordsResult = $this->About_data($unique_id, $About);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function pass_set($unique_id, $password)
    {
        $RecordsResult = $this->Password_set_data($unique_id, $password);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function pass_check($unique_id, $passkey)
    {
        $RecordsResult = $this->Password_check_data($unique_id, $passkey);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function location_set($unique_id, $location)
    {
        $RecordsResult = $this->location_data($unique_id, $location);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function personalData_set($unique_id, $Name, $OtherName, $Email, $contact, $About, $Address)
    {
        $RecordsResult = $this->personal_data($unique_id, $Name, $OtherName, $Email, $contact, $About, $Address);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function getPersonalData($unique_id)
    {
        $RecordsResult = $this->user_get_data($unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }


    }
    public function TithePages($unique_id)
    {
        $RecordsResult = $this->user_list_Info_tithe_pages($unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

}