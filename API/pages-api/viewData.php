<?php
namespace ChurchApi;

use ChurchApi\fetchData;
class viewData extends fetchData
{
    public function Category_view()
    {
        $RecordsResult = $this->library_view_category();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
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
    public function EventList()
    {
        $RecordsResult = $this->NextEvent_viewList();
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

    public function theme_viewList()
    {
        $RecordsResult = $this->theme_home_view();
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
    public function library_viewList()
    {
        $RecordsResult = $this->library_view();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function library_viewList_collection()
    {
        $RecordsResult = $this->library_view_collection();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function library_viewList_vid($vid_id)
    {
        $RecordsResult = $this->library_vid_fetch($vid_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function library_viewList_vid_similar($vid_id)
    {
        $RecordsResult = $this->library_vid_fetch_similar($vid_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function library_vid_search($key)
    {
        $RecordsResult = $this->library_vid_simple_search($key);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function notification_set($site, $title)
    {
        $RecordsResult = $this->set_Notification($site, $title);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }

    }





}