<?php
namespace Ministry;
class viewData extends fetchData
{

    public function ministries_upload($name, $members, $manager, $about, $status, $date)
    {
        $RecordsResult = $this->ministries_upload_data($name, $members, $manager, $about, $status, $date);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }

    public function ministries_update($name, $members, $manager, $about, $status, $date, $unique_id)
    {
        $RecordsResult = $this->ministries_update_data($name, $members, $manager, $about, $status, $date, $unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }

    public function Theme($id)
    {
        $RecordsResult = $this->themeStatus($id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function ministries_delete($name)
    {
        $RecordsResult = $this->ministries_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function viewList()
    {
        $RecordsResult = $this->ministries_view();
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
    public function DepartmentMembers($reciever)
    {
        $RecordsResult = $this->ministry_members($reciever);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function DepartmentMembersView()
    {
        $RecordsResult = $this->ministry_member_view();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function AddDepartmentMembers($unique_id, $Dp_Key)
    {
        $RecordsResult = $this->AddDepartmentMembers_view($unique_id, $Dp_Key);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function RemoveDepartmentMembers($unique_id, $Dp_Key)
    {
        $RecordsResult = $this->RemoveDepartmentMembers_view($unique_id, $Dp_Key);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function ViewDepartmentMembers($name)
    {
        $RecordsResult = $this->DepartmentMembers_view($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

}