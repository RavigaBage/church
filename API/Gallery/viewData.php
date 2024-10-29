<?php
namespace Gallery;

use Gallery\fetchData;
class viewData extends fetchData
{

    public function gallery_upload($Event_name, $uploaded_file_names ,$upload_date, $category)
    {
        $RecordsResult = $this->gallery_upload_data($Event_name, $uploaded_file_names ,$upload_date, $category);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }

    public function gallery_update($Event_name, $uploaded_file_names, $upload_date, $category, $unique_id)
    {
        $RecordsResult = $this->gallery_update_data($Event_name, $uploaded_file_names, $upload_date, $category, $unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }
    public function gallery_delete($name)
    {
        $RecordsResult = $this->gallery_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function viewList($num)
    {
        $RecordsResult = $this->gallery_view($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function liveUpdate($key, $limit)
    {
        $RecordsResult = $this->liveUpdateData($key, $limit);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function viewpages()
    {
        $RecordsResult = $this->gallery_view_pages();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function gallery_export()
    {
        $RecordsResult = $this->gallery_view_export();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function gallery_view_sort_view()
    {
        $RecordsResult = $this->gallery_view_sort();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }

    }
    public function gallery_view_images_list($count, $filter)
    {
        $RecordsResult = $this->gallery_view_images($count, $filter);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }

    }

    public function gallery_view_sort_eventData($name)
    {
        $RecordsResult = $this->gallery_view_sort_event($name);
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