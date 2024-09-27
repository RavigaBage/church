<?php
$year = date('Y');
$date = date('l j \of F Y h:i:s A');
class DBH
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';

    protected function data_connect()
    {
        try {
            $dsm = 'mysql:host=' . $this->host;
            $pdo = new PDO($dsm, $this->user, $this->password);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            print "Error! " . $e->getMessage();
            die();
        }
    }
}
class fetchData extends DBH
{
    public function validate($data)
    {
        if (empty($data)) {
            $data = 'test pass failed';
        } else {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
        }
        return $data;
    }
    protected function Activity_upload_data($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance)
    {
        $input_list = array($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance);

        $clean = true;
        $exportData = 0;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {

            $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`sunday_records`(`opening prayer`, `praises`, `scripture reading`, `scripture`, `opening_Hymn`, `Hymn_new`, `Hymn_title`, `worship`, `testimonies`, `song_thanksgving_offering`, `sermon_prayer`, `sermon_from`, `scripture_preacher`, `peacher_duration`, `alter_call`, `tithe_offering`, `special_appeal`, `welcome_visitors`, `Announcement`, `closing_prayer`, `Benediction`, `MC`, `Total_attendance`, `date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bindParam('1', $opening_prayer, PDO::PARAM_STR);
            $stmt->bindParam('2', $praises, PDO::PARAM_STR);
            $stmt->bindParam('3', $scripture_reading, PDO::PARAM_STR);
            $stmt->bindParam('4', $scripture, PDO::PARAM_STR);
            $stmt->bindParam('5', $opening_Hymn, PDO::PARAM_STR);
            $stmt->bindParam('6', $Hymn_new, PDO::PARAM_STR);
            $stmt->bindParam('7', $Hymn_title, PDO::PARAM_STR);
            $stmt->bindParam('8', $worship, PDO::PARAM_STR);
            $stmt->bindParam('9', $testimonies, PDO::PARAM_STR);
            $stmt->bindParam('10', $song_thanksgving_offering, PDO::PARAM_STR);
            $stmt->bindParam('11', $sermon_prayer, PDO::PARAM_STR);
            $stmt->bindParam('12', $sermon_from, PDO::PARAM_STR);
            $stmt->bindParam('13', $scripture_preacher, PDO::PARAM_STR);
            $stmt->bindParam('14', $peacher_duration, PDO::PARAM_STR);
            $stmt->bindParam('15', $alter_call, PDO::PARAM_STR);
            $stmt->bindParam('16', $tithe_offering, PDO::PARAM_STR);
            $stmt->bindParam('17', $special_appeal, PDO::PARAM_STR);
            $stmt->bindParam('18', $welcome_visitors, PDO::PARAM_STR);
            $stmt->bindParam('19', $Announcement, PDO::PARAM_STR);
            $stmt->bindParam('20', $closing_prayer, PDO::PARAM_STR);
            $stmt->bindParam('21', $Benediction, PDO::PARAM_STR);
            $stmt->bindParam('22', $MC, PDO::PARAM_STR);
            $stmt->bindParam('23', $Total_attendance, PDO::PARAM_STR);
            $stmt->bindParam('24', $date, PDO::PARAM_STR);
            if (!$stmt->execute()) {

                print_r($stmt->errorInfo());

                $stmt = null;
                $Error = 'Fetching data encountered a problems';
                exit($Error);
            } else {
                $exportData = 'Upload was a success';
            }
        }
        return $exportData;
    }

    protected function Activity_update_data($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $id)
    {
        $input_list = array($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance);
        $clean = true;
        $exportData = 0;
        $resultValidate = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`sunday_records` set `opening prayer`=?,`praises`=?,`scripture reading`=?,`scripture`=?,`opening_Hymn`=?,`Hymn_new`=?,`Hymn_title`=?,`worship`=?,`testimonies`=?,`song_thanksgving_offering`=?,`sermon_prayer`=?,`sermon_from`=?,`scripture_preacher`=?,`peacher_duration`=?,`alter_call`=?,`tithe_offering`=?,`special_appeal`=?,`welcome_visitors`=?,`Announcement`=?,`closing_prayer`=?,`Benediction`=?,`MC`=?,`Total_attendance`=?,`date`=?] WHERE id=?");

            $stmt->bindParam('1', $opening_prayer, PDO::PARAM_STR);
            $stmt->bindParam('2', $praises, PDO::PARAM_STR);
            $stmt->bindParam('3', $scripture_reading, PDO::PARAM_STR);
            $stmt->bindParam('4', $scripture, PDO::PARAM_STR);
            $stmt->bindParam('5', $opening_Hymn, PDO::PARAM_STR);
            $stmt->bindParam('6', $Hymn_new, PDO::PARAM_STR);
            $stmt->bindParam('7', $Hymn_title, PDO::PARAM_STR);
            $stmt->bindParam('8', $worship, PDO::PARAM_STR);
            $stmt->bindParam('9', $testimonies, PDO::PARAM_STR);
            $stmt->bindParam('10', $song_thanksgving_offering, PDO::PARAM_STR);
            $stmt->bindParam('11', $sermon_prayer, PDO::PARAM_STR);
            $stmt->bindParam('12', $sermon_from, PDO::PARAM_STR);
            $stmt->bindParam('13', $scripture_preacher, PDO::PARAM_STR);
            $stmt->bindParam('14', $peacher_duration, PDO::PARAM_STR);
            $stmt->bindParam('15', $alter_call, PDO::PARAM_STR);
            $stmt->bindParam('16', $tithe_offering, PDO::PARAM_STR);
            $stmt->bindParam('17', $special_appeal, PDO::PARAM_STR);
            $stmt->bindParam('18', $welcome_visitors, PDO::PARAM_STR);
            $stmt->bindParam('19', $Announcement, PDO::PARAM_STR);
            $stmt->bindParam('20', $closing_prayer, PDO::PARAM_STR);
            $stmt->bindParam('21', $Benediction, PDO::PARAM_STR);
            $stmt->bindParam('22', $MC, PDO::PARAM_STR);
            $stmt->bindParam('23', $Total_attendance, PDO::PARAM_STR);
            $stmt->bindParam('24', $date, PDO::PARAM_STR);
            $stmt->bindParam('25', $id, PDO::PARAM_STR);

            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problems';
                exit($Error);
            } else {
                $exportData = 'Upload was a success';
            }

        }
        return $exportData;
    }


    protected function Activity_delete_data($name)
    {
        $exportData = 0;
        $input_list = array($name);
        $clean = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`sunday_records` where `id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`sunday_records` where `id`=?");
                    $stmt->bindParam('1', $name, PDO::PARAM_STR);
                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = 'deleting data encountered a problem';
                        exit($Error);
                    } else {
                        $exportData = 'Item Deleted Successfully';
                    }
                } else {
                    $stmt = null;
                    $Error = 'deleting data encountered a problem';
                    exit($Error);
                }


            } else {
                exit('No match for search query');
            }

            return $exportData;

        }
    }
    protected function Activity_view()
    {
        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`sunday_records` ORDER BY `id` DESC");
        if (!$stmt->execute()) {

            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjectClass = new \stdClass();
            foreach ($result as $data) {
                $open_prayer = $data[`opening prayer`];
                $praise = $data[`praises`];
                $ObjectClass->Open_prayer = $open_prayer;
                $ObjectClass->praise = $praise;
            }
            $exportData = json_encode($ObjectClass);
        } else {
            $resultCheck = false;
            $exportData = 'No Records Available';
        }

        return $exportData;
    }



    protected function church_record_upload_data($category, $record, $details, $admin, $year)
    {

        $input_list = array($category, $record, $details, $admin, $year);
        $clean = true;
        $exportData = 0;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`records`( `category`, `record`, `details`, `date`, `admin`, `year`)VALUES (?,?,?,?,?,?)");
            $stmt->bindParam('1', $category, PDO::PARAM_STR);
            $stmt->bindParam('2', $record, PDO::PARAM_STR);
            $stmt->bindParam('3', $details, PDO::PARAM_STR);
            $stmt->bindParam('4', $date, PDO::PARAM_STR);
            $stmt->bindParam('5', $admin, PDO::PARAM_STR);
            $stmt->bindParam('6', $year, PDO::PARAM_STR);

            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problems';
                exit($Error);
            } else {
                $exportData = 'Upload was a success';
            }

        }
        return $exportData;
    }


    protected function church_record_update_data($category, $record, $details, $id, $admin, $year)
    {
        $input_list = array($category, $record, $details, $id, $admin, $year);
        $clean = true;
        $exportData = 0;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {

            $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`projects` set `category`=?,`record`=?,`details`=?,`date`=?,`admin`=?,`year`=? WHERE 1where `id` = ?");

            $stmt->bindParam('1', $category, PDO::PARAM_STR);
            $stmt->bindParam('2', $record, PDO::PARAM_STR);
            $stmt->bindParam('3', $details, PDO::PARAM_STR);
            $stmt->bindParam('4', $date, PDO::PARAM_STR);
            $stmt->bindParam('5', $admin, PDO::PARAM_STR);
            $stmt->bindParam('6', $year, PDO::PARAM_STR);
            $stmt->bindParam('7', $id, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problems';
                exit($Error);
            } else {
                $exportData = 'Upload was a success';
            }
        }
        return $exportData;
    }


    protected function church_record_delete_data($name)
    {
        $exportData = 0;
        $input_list = array($name);
        $clean = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`records` where `id` =?");
            $stmt->bindParam('1', $name, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`records` where `id`=?");
                    $stmt->bindParam('1', $name, PDO::PARAM_STR);
                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = 'deleting data encountered a problem';
                        exit($Error);
                    } else {
                        $resultCheck = true;
                        $exportData = 'Item Deleted Successfully';
                    }
                } else {
                    $stmt = null;
                    $Error = 'deleting data encountered a problem';
                    exit($Error);
                }


            } else {
                exit('No match for search query');
            }

            return $exportData;

        }
    }

    protected function church_record_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`records` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjectDataMain = new stdClass();
            $list = ['birth', 'death', 'water_baptism', 'fire_baptism'];
            $birth = 0;
            $death = 0;
            $water_baptism = 0;
            $fire_baptism = 0;


            foreach ($result as $data) {
                $name = $data['category'];
                if ($name == 'birth') {
                    $birth += 1;
                } elseif ($name == 'death') {
                    $death += 1;
                } elseif ($name == 'water_baptism') {
                    $water_baptism += 1;
                } elseif ($name == 'fire_baptism') {
                    $fire_baptism += 1;
                }

            }

            $ObjectDataMain->birth = $birth;
            $ObjectDataMain->death = $death;
            $ObjectDataMain->water_baptism = $water_baptism;
            $ObjectDataMain->fire_baptism = $fire_baptism;
            $exportData = $ObjectDataMain;
        } else {
            $resultCheck = false;
            $exportData = 'Not Records Available';
        }
        return $exportData;
    }

}