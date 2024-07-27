<?php
class viewData extends fetchData
{

    public function annc_upload($name, $receiver, $message, $date, $file_name, $Image_type, $Image_tmp_name)
    {
        $RecordsResult = $this->annc_upload_data($name, $receiver, $message, $date, $file_name, $Image_type, $Image_tmp_name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }

    public function annc_update($name, $receiver, $message, $date, $file_name, $Image_type, $Image_tmp_name,$id)
    {
        $RecordsResult = $this->annc_update_data($name, $receiver, $message, $date, $file_name, $Image_type, $Image_tmp_name,$id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function ass_delete($name)
    {
        $RecordsResult = $this->ass_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }   
    public function annc_status($name,$id)
    {
        $RecordsResult = $this->annc_status_data($name,$id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    } 
    
    public function Theme($id)
    {
        $RecordsResult = $this->themeStatus($id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }

    public function viewList()
    {
        $RecordsResult = $this->annc_view();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function getdepartment_name()
    {
        $RecordsResult = $this->department_list();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function getHistory($num)
    {
        $RecordsResult = $this->History($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function HistoryPages()
    {
        $RecordsResult = $this->History_pages();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function setToken($pass, $new, $timer, $date)
    {
        $RecordsResult = $this->token($pass, $new, $timer, $date);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function getoken()
    {
        $RecordsResult = $this->tokenCheck();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function History_data($name, $event, $Date, $sitename, $action)
    {
        $RecordsResult = $this->history_set($name, $event, $Date, $sitename, $action);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }


}