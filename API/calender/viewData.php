<?php
class viewData extends fetchData
{

    public function calender_upload($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status, $file_name, $Image_type, $Image_tmp_name)
    {
        $RecordsResult = $this->calender_upload_data($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status, $file_name, $Image_type, $Image_tmp_name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }

    public function calender_update($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status, $file_name, $Image_type, $Image_tmp_name, $unique_id)
    {
        $RecordsResult = $this->calender_update_data($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status, $file_name, $Image_type, $Image_tmp_name, $unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }


    public function calender_delete($name)
    {
        $RecordsResult = $this->calender_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }


    public function viewList($year)
    {
        $RecordsResult = $this->calender_view($year);
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