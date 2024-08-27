<?php
class viewData extends fetchData
{

    public function ministries_upload($name, $partnership, $date, $status, $email, $type, $period)
    {
        $RecordsResult = $this->Partnership_upload_data($name, $partnership, $date, $status, $email, $type, $period);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
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
    public function viewList()
    {
        $RecordsResult = $this->Partnership_view();
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
}