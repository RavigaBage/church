<?php
namespace Partnership;

use Partnership\fetchData;

class viewData extends fetchData
{

    public function ministries_upload($name, $partnership, $date, $status, $email, $type, $period)
    {
        $RecordsResult = $this->Partnership_upload_data($name, $partnership, $date, $status, $email, $type, $period);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function ministries_update($name, $partnership, $date, $status, $email, $type, $period, $unique_id)
    {
        $RecordsResult = $this->Partnership_update_data($name, $partnership, $date, $status, $email, $type, $period, $unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }
    public function ministries_delete($name)
    {
        $RecordsResult = $this->Partnership_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function ministries_filter($name)
    {
        $RecordsResult = $this->Partnership_filter_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function partnership_export()
    {
        $RecordsResult = $this->Partnership_filter_export();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function ministries_filterSearch($name, $nk)
    {
        $RecordsResult = $this->Partnership_filter_dataSearch($name, $nk);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function ministries_delete_inidividual($id)
    {
        $RecordsResult = $this->Partnership_view_individual_record($id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function viewList($num)
    {
        $RecordsResult = $this->Partnership_view($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function partnership_liveUpdate($num)
    {
        $RecordsResult = $this->Partnership_liveUpdate_fetch($num);

        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {

            return $RecordsResult;
        }
    }
    public function partner_pages()
    {
        $RecordsResult = $this->partnerPages();
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

    public function HomeFetch($date)
    {
        $RecordsResult = $this->Partnership_view_individual_record_total($date);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }

    }
    public function partnership_view_individual_record_upload($name, $partnership, $date, $amount)
    {
        $RecordsResult = $this->Partnership_upload_data_ini($name, $partnership, $date, $amount);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
}