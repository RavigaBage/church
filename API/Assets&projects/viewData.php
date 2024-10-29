<?php
namespace AssetProject;
use AssetProject\fetchData;
class viewData extends fetchData
{

    public function Assets_upload($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $uploaded_file_names, $About)
    {
        $RecordsResult = $this->Assets_upload_data($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $uploaded_file_names, $About);


        return $RecordsResult;


    }

    public function Assets_update($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $uploaded_file_names, $About, $unique_id)
    {
        $RecordsResult = $this->Assets_update_data($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $uploaded_file_names, $About, $unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }
    public function Projects_liveUpdate($num)
    {
        $RecordsResult = $this->projects_viewLiveUpdate($num);
        return $RecordsResult;

    }

    public function Assets_liveUpdate($num)
    {
        $RecordsResult = $this->AviewLiveUpdate($num);
        return $RecordsResult;

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

    public function Asset_viewExport()
    {
        $RecordsResult = $this->Assets_view_export();
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





    public function projects_upload($Name, $description, $start_date, $end_date, $team, $status, $uploaded_file_names, $target, $current)
    {
        $RecordsResult = $this->projects_upload_data($Name, $description, $start_date, $end_date, $team, $status, $uploaded_file_names, $target, $current);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }

    public function projects_update($Name, $description, $start_date, $end_date, $team, $status, $uploaded_file_names, $target, $current, $id)
    {
        $RecordsResult = $this->projects_update_data($Name, $description, $start_date, $end_date, $team, $status, $uploaded_file_names, $target, $current, $id);
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
    public function viewListFilter($num)
    {
        $RecordsResult = $this->AviewFilter($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function project_showcase()
    {
        $RecordsResult = $this->projects_viewShowcase();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Project_viewListFilter($num)
    {
        $RecordsResult = $this->projects_viewFilter($num);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Project_viewListFilterComplete()
    {
        $RecordsResult = $this->projects_viewFilterComplete();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Project_viewListFilterProgress()
    {
        $RecordsResult = $this->projects_viewFilterProgress();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function Project_viewListFilterCurrent()
    {
        $RecordsResult = $this->projects_viewFilterCurrent();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }



    public function Project_viewSearchMain($name, $nk)
    {
        $RecordsResult = $this->projects_viewSearch($name, $nk);

        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function Project_viewExport()
    {
        $RecordsResult = $this->projects_viewExportData();

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
    public function GetLatestStatus()
    {
        $RecordsResult = $this->GetLatest();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

}