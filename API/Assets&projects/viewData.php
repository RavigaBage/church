<?php
class viewData extends fetchData
{

    public function Assets_upload($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $size, $Image_name, $Image_type, $Image_tmp_name, $About)
    {
        $RecordsResult = $this->Assets_upload_data($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $size, $Image_name, $Image_type, $Image_tmp_name, $About);

        return json_encode(strval($RecordsResult));

    }

    public function Assets_update($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $Image, $Image_type, $Image_tmp_name, $About, $unique_id)
    {
        $RecordsResult = $this->Assets_update_data($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $Image, $Image_type, $Image_tmp_name, $About, $unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }


    public function Assets_delete($name)
    {
        $RecordsResult = $this->Assets_delete_data($name);
        return $RecordsResult;

    }
    public function viewList($num)
    {
        $RecordsResult = $this->Assets_view($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function LastModified()
    {
        $RecordsResult = $this->GetLatestUpdate();
        return $RecordsResult;

    }

    public function AssetPages()
    {
        $RecordsResult = $this->Asset_pages();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }





    public function projects_upload($Name, $description, $start_date, $end_date, $team, $status, $Image, $Image_type, $Image_tmp_name, $target, $current)
    {
        $RecordsResult = $this->projects_upload_data($Name, $description, $start_date, $end_date, $team, $status, $Image, $Image_type, $Image_tmp_name, $target, $current);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }

    public function projects_update($Name, $description, $start_date, $end_date, $team, $status, $Image, $Image_type, $Image_tmp_name, $target, $current, $id)
    {
        $RecordsResult = $this->projects_update_data($Name, $description, $start_date, $end_date, $team, $status, $Image, $Image_type, $Image_tmp_name, $target, $current, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }


    public function projects_delete($name)
    {
        $RecordsResult = $this->projects_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Project_viewList($num)
    {
        $RecordsResult = $this->projects_view($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function ProjectsPages()
    {
        $RecordsResult = $this->project_pages();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }


}