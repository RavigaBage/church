<?php
include ('../sundayRecords/autoloader.php');
include ('user_check.php');
$viewDataClass = new viewData();

function DeleteItem($name, $viewDataClass)
{
    $delete = $viewDataClass->sunday_delete($name);
    return $delete;
}
$data = json_decode(file_get_contents("php://input"), true);
if (empty($data)) {
    echo json_encode(["status" => "failed", "result" => "Emty fields"]);
} else {
    if (isset($_GET['delete'])) {
        $id = $data['delete_key'];
        $result_data = DeleteItem($id, $viewDataClass);
        json_encode(["status" => "result", "result" => $result_data]);
    }

    if (isset($_GET['update'])) {
        try {

            $opening_prayer = $data['opening_prayer'];
            $praise = $data['praises'];
            $scripture_reading = $data['scripture_reading'];
            $scripture = $data['scripture'];
            $opening_Hymn = $data['opening_Hymn'];
            $Hymn_new = $data['Hymn_new'];
            $Hymn_title = $data['Hymn_title'];
            $worship = $data['worship'];
            $testimonies = $data['testimonies'];
            $song_thanksgving_offering = $data['song_thanksgving_offering'];
            $sermon_prayer = $data['sermon_prayer'];
            $sermon_from = $data['sermon_from'];
            $scripture_preacher = $data['scripture_preacher'];
            $preacher_duration = $data['peacher_duration'];
            $alter_call = $data['alter_call'];
            $tithe_offering = $data['tithe_offering'];
            $special_appeal = $data['special_appeal'];
            $welcome_visitors = $data['welcome_visitors'];
            $Announcement = $data['Announcement'];
            $closing_prayer = $data['closing_prayer'];
            $Benediction = $data['Benediction'];
            $mc = $data['MC'];
            $total_attendance = $data['Total_attendance'];
            $date = $data['date'];


            $result_data = $viewDataClass->sunday_update($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $date, $id);
            json_encode(["status" => "result", "result" => $result_data]);
        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
    if (isset($_GET['upload'])) {
        try {
            $opening_prayer = $data['opening_prayer'];
            $praise = $data['praises'];
            $scripture_reading = $data['scripture_reading'];
            $scripture = $data['scripture'];
            $opening_Hymn = $data['opening_Hymn'];
            $Hymn_new = $data['Hymn_new'];
            $Hymn_title = $data['Hymn_title'];
            $worship = $data['worship'];
            $testimonies = $data['testimonies'];
            $song_thanksgving_offering = $data['song_thanksgving_offering'];
            $sermon_prayer = $data['sermon_prayer'];
            $sermon_from = $data['sermon_from'];
            $scripture_preacher = $data['scripture_preacher'];
            $preacher_duration = $data['peacher_duration'];
            $alter_call = $data['alter_call'];
            $tithe_offering = $data['tithe_offering'];
            $special_appeal = $data['special_appeal'];
            $welcome_visitors = $data['welcome_visitors'];
            $Announcement = $data['Announcement'];
            $closing_prayer = $data['closing_prayer'];
            $Benediction = $data['Benediction'];
            $mc = $data['MC'];
            $total_attendance = $data['Total_attendance'];
            $date = $data['date'];
            $result_data = $viewDataClass->sunday_upload($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $date);
            json_encode(["status" => "result", "result" => $result_data]);



        } catch (Exception $e) {
            $error_message = "Exception: " . $e->getMessage();
            echo json_encode(["status" => "error", "message" => $error_message]);
        }
    }
}
?>