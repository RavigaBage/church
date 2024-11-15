<?php
namespace Library;

use Library\fetchData;

class viewData extends fetchData
{


    public function library_upload($name, $author, $date, $status, $source, $category,$tag, $FILES)
    {
        $RecordsResult = $this->library_upload_data($name, $author, $date, $status, $source, $category,$tag, $FILES);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Library_update($name, $author, $date, $status, $source, $category,$tag, $unique_id, $FILES)
    {
        $RecordsResult = $this->library_update_data($name, $author, $date, $status, $source, $category,$tag, $unique_id, $FILES);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }
    public function Library_delete($name)
    {
        $RecordsResult = $this->Library_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Library_filter($name)
    {
        $RecordsResult = $this->Library_filter_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Library_export()
    {
        $RecordsResult = $this->library_filter_export();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Library_filterSearch($name, $nk)
    {
        $RecordsResult = $this->Library_filter_dataSearch($name, $nk);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Library_delete_inidividual($id)
    {
        $RecordsResult = $this->Library_view_individual_record($id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function viewList($num)
    {
        $RecordsResult = $this->library_view($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Library_liveUpdate($num)
    {
        $RecordsResult = $this->Library_liveUpdate_fetch($num);

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
    public function Library_view_individual_record_upload($name, $date, $filename, $source)
    {
        $RecordsResult = $this->Library_upload_data_ini($name, $date, $filename, $source);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
}