<?php
class viewData extends fetchData
{

    public function Activity_upload($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance)
    {
        $RecordsResult = $this->Activity_upload_data($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }

    public function Activity_update($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $id)
    {
        $RecordsResult = $this->Activity_update_data($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }


    public function Activity_delete($name)
    {
        $RecordsResult = $this->Activity_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function viewList()
    {
        $RecordsResult = $this->Activity_view();
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }




    public function church_record_upload($category, $record, $details, $admin, $year)
    {
        $RecordsResult = $this->church_record_upload_data($category, $record, $details, $admin, $year);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }

    public function church_record_update($category, $record, $details, $id, $admin, $year)
    {
        $RecordsResult = $this->church_record_update_data($category, $record, $details, $id, $admin, $year);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }


    public function church_record_delete($name)
    {
        $RecordsResult = $this->church_record_delete_data($name);
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
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }


}