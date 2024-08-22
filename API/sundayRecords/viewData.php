<?php
class viewData extends fetchData
{

    public function sunday_upload($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $date)
    {
        $RecordsResult = $this->sunday_upload_data($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $date);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }
    public function sunday_update($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $date, $unique_id)
    {
        $RecordsResult = $this->sunday_update_data($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $date, $unique_id);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $RecordsResult;
        } else {
            return $RecordsResult;
        }
    }
    public function sunday_delete($name)
    {
        $RecordsResult = $this->sunday_delete_data($name);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }
    public function View_List($year)
    {
        $RecordsResult = $this->Sunday_view($year);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

    public function searchRecords($date)
    {
        $RecordsResult = $this->RecordsFilter($date);
        if ($RecordsResult == false) {
            $Error = 'Error Occurred';
            return $Error;
        } else {
            return $RecordsResult;
        }
    }

}