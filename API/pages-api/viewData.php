<?php
namespace ChurchApi;

use ChurchApi\fetchData;
class viewData extends fetchData
{
    public function call_action_viewList()
    {
        $RecordsResult = $this->call_action_view();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function eventData()
    {
        $RecordsResult = $this->NextEvent_home_view();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function announcement_viewList()
    {
        $RecordsResult = $this->announcement_view();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function project_viewList()
    {
        $RecordsResult = $this->project_view();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }


    public function gallery_viewList()
    {
        $RecordsResult = $this->gallery_view();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function gallery_home_viewList()
    {
        $RecordsResult = $this->gallery_home_view();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function church_record_viewList()
    {
        $RecordsResult = $this->church_record_view();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function calender_data($year)
    {
        $RecordsResult = $this->calender_view($year);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }


}