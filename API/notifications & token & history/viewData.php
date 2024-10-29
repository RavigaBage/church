<?php
namespace notification;
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

    public function annc_update($name, $receiver, $message, $date, $file_name, $Image_type, $Image_tmp_name, $id)
    {
        $RecordsResult = $this->annc_update_data($name, $receiver, $message, $date, $file_name, $Image_type, $Image_tmp_name, $id);
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
    public function annc_status($name, $id)
    {
        $RecordsResult = $this->annc_status_data($name, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function annc_liveUpdate($num)
    {
        $RecordsResult = $this->annc_liveUpdate_data($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function annc_SearchRequest($name, $nk)
    {
        $RecordsResult = $this->annc_search($name, $nk);
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

    public function viewList($num)
    {
        $RecordsResult = $this->annc_view($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function anncPages()
    {
        $RecordsResult = $this->annc_pages();
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
    public function ministries_viewList()
    {
        $RecordsResult = $this->ministries_view();
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

    public function DataHistory($name, $event, $Date, $sitename, $action)
    {
        $RecordsResult = $this->history_set($name, $event, $Date, $sitename, $action);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Status_Notification()
    {
        $RecordsResult = $this->Get_Notification();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Reset_Notification($site)
    {
        $RecordsResult = $this->Set_Notification($site);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }





}