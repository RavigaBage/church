<?php
namespace Calender;
global $passwordKey;
$dir = 'http://localhost/database/church/API/22cca3e2e75275b0753f62f2e6ee9bcf95562423e7455fc0ae9fa73e41226dba';
$dotenv = \Dotenv\Dotenv::createImmutable($dir);
$dotenv->safeLoad();
$passwordKey = $_ENV['database_passkey'];
class DBH
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = "";

    protected function data_connect()
    {
        global $passwordKey;
        try {
            $dsm = 'mysql:host=' . $this->host;
            $pdo = new \PDO($dsm, $this->user, $passwordKey);
            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            return $pdo;
        } catch (\PDOException $e) {
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
    public function calender_time_clean($start, $end)
    {
        $exploadData = explode('(', $start);
        $exploadDataE = explode('(', $end);
        $finalReturnStart = "";
        $finalReturnEnd = "";

        if (count($exploadData) > 0) {
            $startReturn1 = $exploadData[0];
            if (strpos($startReturn1, 'am')) {
                $exploadData = explode('am', $startReturn1);
                $finalReturnStart = $exploadData[0] . ' ' . 'am';
            }
            if (strpos($startReturn1, 'pm')) {
                $exploadData = explode('pm', $startReturn1);
                $finalReturnStart = $exploadData[0] . ' ' . 'pm';
            }

        }

        if (count($exploadDataE) > 0) {
            $startReturn1 = $exploadDataE[0];
            if (strpos($startReturn1, 'am')) {
                $exploadDataE = explode('am', $startReturn1);
                $finalReturnEnd = $exploadDataE[0] . ' ' . 'am';
            }
            if (strpos($startReturn1, 'pm')) {
                $exploadDataE = explode('pm', $startReturn1);
                $finalReturnEnd = $exploadDataE[0] . ' ' . 'pm';
            }

        }

        return [$finalReturnStart, $finalReturnEnd];

    }
    protected function calender_upload_data($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status, $file_name, $Image_type, $Image_tmp_name)
    {
        $cleanData = $this->calender_time_clean($start_time, $end_time);
        if (count($cleanData) == 2) {
            $start_time = $cleanData[0];
            $end_time = $cleanData[1];

            $input_list = array($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status);
            $clean = true;
            $exportData = 0;
            $resultValidate = true;
            foreach ($input_list as $input) {
                $data = $this->validate($input);
                if ($data == 'test pass failed') {
                    $Error = 'validating data encountered a problem, All fields are required !';
                    $clean = false;
                    exit(json_encode($Error));
                }
            }
            if ($clean) {
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` where `EventName`='$EventName' AND `Year` = '$Year' AND `Month` = '$Month' AND `Day` = '$Day' AND `start_time` = '$start_time'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                }
                if ($stmt->rowCount() > 0) {
                    $Error = "Data name already exist";
                    $resultValidate = false;
                    exit(json_encode($Error));
                } else {

                    if ($file_name == '') {
                        $file_name = '';
                    } else {
                        $explodes = explode('.', $file_name);
                        $explode_end = end($explodes);
                        $Extensions = array('jpg', 'png', 'jpeg');
                        if (in_array($explode_end, $Extensions)) {
                            $types = ["image/jpg", "image/png", "image/jpeg"];
                            if (in_array($Image_type, $types)) {
                                $filename4 = time() . $file_name;
                                $target4 = "../images/calenda/$filename4";
                                if (move_uploaded_file($Image_tmp_name, $target4)) {
                                    $unique_id = rand(time(), 3002);
                                    $file_name = $target4;
                                } else {
                                    exit(json_encode("An error occurred while processing image, try again"));
                                }
                            } else {
                                exit(json_encode("Image file must be of the following extensions only 'jpg','png','jpeg'"));
                            }
                        } else {
                            exit(json_encode("Image file must be of the following extensions only 'jpg','png','jpeg'"));
                        }
                    }

                    $unique_id = rand(time(), 1999);
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`calender`(`unique_id`, `EventName`, `Year`, `Month`, `Day`, `start_time`, `end_time`, `Venue`, `Theme`, `About`, `Image`, `Department`, `Status`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                    $stmt->bindParam('2', $EventName, \PDO::PARAM_STR);
                    $stmt->bindParam('3', $Year, \PDO::PARAM_STR);
                    $stmt->bindParam('4', $Month, \PDO::PARAM_STR);
                    $stmt->bindParam('5', $Day, \PDO::PARAM_STR);
                    $stmt->bindParam('6', $start_time, \PDO::PARAM_STR);
                    $stmt->bindParam('7', $end_time, \PDO::PARAM_STR);
                    $stmt->bindParam('8', $Venue, \PDO::PARAM_STR);
                    $stmt->bindParam('9', $Theme, \PDO::PARAM_STR);
                    $stmt->bindParam('10', $About, \PDO::PARAM_STR);
                    $stmt->bindParam('11', $file_name, \PDO::PARAM_STR);
                    $stmt->bindParam('12', $Department, \PDO::PARAM_STR);
                    $stmt->bindParam('13', $Status, \PDO::PARAM_STR);
                    if (!$stmt->execute()) {

                        $stmt = null;
                        $Error = 'Fetching data encountered a problems';
                        exit(json_encode($Error));
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['login_details'];
                        $historySet = $this->history_set($namer, "Calender  Data Upload", $date, "Calender  page dashboard Admin", "User Uploaded a data");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }
                        $exportData = 'success';
                        $resultValidate = true;
                    }

                }


            }
        } else {
            exit('invalid data sent');
        }
        return json_encode($exportData);
    }

    protected function calender_update_data($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status, $file_name, $Image_type, $Image_tmp_name, $unique_id)
    {
        $input_list = array($EventName, $Year, $Month, $Day, $start_time, $end_time, $Venue, $Theme, $About, $Department, $Status, $unique_id);
        $clean = true;
        $exportData = 0;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit(json_encode($Error));
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` where `EventName`='$EventName' AND `Year` = '$Year' AND `Month` = '$Month' AND `Day` = '$Day' AND `start_time` = '$start_time' AND `end_time`='$end_time'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() < 0) {
                $exportData = "Data name does not already exist";
                $resultValidate = true;
            } else {

                if ($file_name == '') {
                    $file_name = '';
                } else {
                    $explodes = explode('.', $file_name);
                    $explode_end = end($explodes);
                    $Extensions = array('jpg', 'png', 'jpeg');
                    if (in_array($explode_end, $Extensions)) {
                        $types = ["image/jpg", "image/png", "image/jpeg"];
                        if (in_array($Image_type, $types)) {
                            $filename4 = time() . $file_name;
                            $target4 = "../images/calenda/$filename4";
                            if (move_uploaded_file($Image_tmp_name, $target4)) {
                                $file_name = $filename4;
                            } else {
                                exit(json_encode("An error occurred while processing image, try again"));
                            }
                        } else {
                            exit(json_encode("Image file must be of the following extensions only 'jpg','png','jpeg'"));
                        }
                    } else {
                        exit(json_encode("Image file must be of the following extensions only 'jpg','png','jpeg'"));
                    }
                }
                $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`calender` SET `EventName`=?,`Year`=?,`Month`=?,`Day`=?,`start_time`=?,`end_time`=?,`Venue`=?,`Theme`=?,`About`=?,`Image`=?,`Department`=?,`Status`=? WHERE `unique_id`=?");
                $stmt->bindParam('1', $EventName, \PDO::PARAM_STR);
                $stmt->bindParam('2', $Year, \PDO::PARAM_STR);
                $stmt->bindParam('3', $Month, \PDO::PARAM_STR);
                $stmt->bindParam('4', $Day, \PDO::PARAM_STR);
                $stmt->bindParam('5', $start_time, \PDO::PARAM_STR);
                $stmt->bindParam('6', $end_time, \PDO::PARAM_STR);
                $stmt->bindParam('7', $Venue, \PDO::PARAM_STR);
                $stmt->bindParam('8', $Theme, \PDO::PARAM_STR);
                $stmt->bindParam('9', $About, \PDO::PARAM_STR);
                $stmt->bindParam('10', $file_name, \PDO::PARAM_STR);
                $stmt->bindParam('11', $Department, \PDO::PARAM_STR);
                $stmt->bindParam('12', $Status, \PDO::PARAM_STR);
                $stmt->bindParam('13', $unique_id, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problems';
                    exit(json_encode($Error));
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['login_details'];
                    $historySet = $this->history_set($namer, "Calender  Data Update", $date, "Calender  page dashboard Admin", "User Updated a data");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }

                    $exportData = "Update was a success";
                    $resultValidate = true;
                }
            }
        }
        return $exportData;

    }

    protected function calender_delete_data($name)
    {
        $exportData = 0;
        $input_list = array($name);
        $clean = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit(json_encode($Error));
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`calender` where   `unique_id`=?");
                $stmt1->bindParam('1', $name, \PDO::PARAM_STR);
                if (!$stmt1->execute()) {
                    $stmt1 = null;
                    $Error = 'deleting data encountered a problem';
                    exit(json_encode($Error));
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['login_details'];
                    $historySet = $this->history_set($namer, "Calender Data delete", $date, "Calender page dashboard Admin", "User deleted a data");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }
                    $exportData = 'success';
                }
            } else {
                exit(json_encode('Data has already been deleted. if data is still in display, refresh
                the page to incorporate changes'));
            }
            return json_encode($exportData);

        }
    }
    protected function calender_view($year)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` WHERE `Year` like '%$year%' ORDER BY `start_time` DESC");

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $MainClass = new \stdClass();
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $tmpClass = new \stdClass();
                $name = $data['EventName'];
                $year = $data['Year'];
                $Month = $data['Month'];
                $Day = $data['Day'];
                $start = $data['start_time'];
                $end = $data['end_time'];
                $venue = $data['Venue'];
                $theme = $data['Theme'];
                $about = $data['About'];
                $image = $data['Image'];
                $department = $data['Department'];
                $status = $data['Status'];
                $unique_id = $data['unique_id'];

                $tmpClass->name = $name;
                $tmpClass->Year = $year;
                $tmpClass->Month = $Month;
                $tmpClass->Day = $Day;
                $tmpClass->start = $start;
                $tmpClass->end = $end;
                $tmpClass->venue = $venue;
                $tmpClass->theme = $theme;
                $tmpClass->about = $about;
                $tmpClass->image = $image;
                $tmpClass->department = $department;
                $tmpClass->status = $status;
                $tmpClass->unique_id = $unique_id;
                $MainClass->$unique_id = $tmpClass;

            }

            $exportData = json_encode($MainClass);
        } else {
            $resultCheck = false;
            $exportData = 'No Records Available';
        }


        return $exportData;

    }

    protected function calender_view_filter($year, $Month, $day)
    {
        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` WHERE `Year` like '%$year%' AND `Month` like '%$Month%' AND `Day` like '%$day%' ORDER BY `start_time` DESC");

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $MainClass = new \stdClass();
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $tmpClass = new \stdClass();
                $name = $data['EventName'];
                $year = $data['Year'];
                $Month = $data['Month'];
                $Day = $data['Day'];
                $start = $data['start_time'];
                $end = $data['end_time'];
                $venue = $data['Venue'];
                $theme = $data['Theme'];
                $about = $data['About'];
                $image = $data['Image'];
                $department = $data['Department'];
                $status = $data['Status'];
                $unique_id = $data['unique_id'];

                $tmpClass->name = $name;
                $tmpClass->Year = $year;
                $tmpClass->Month = $Month;
                $tmpClass->Day = $Day;
                $tmpClass->start = $start;
                $tmpClass->end = $end;
                $tmpClass->venue = $venue;
                $tmpClass->theme = $theme;
                $tmpClass->about = $about;
                $tmpClass->image = $image;
                $tmpClass->department = $department;
                $tmpClass->status = $status;
                $tmpClass->unique_id = $unique_id;
                $MainClass->$unique_id = $tmpClass;

            }

            $exportData = json_encode($MainClass);
        } else {
            $exportData = 'No Records Available';
        }
        return $exportData;

    }

    protected function calender_view_marker($year)
    {
        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` WHERE `Year` like '%$year%'  ORDER BY `start_time` DESC");

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $MainClass = new \stdClass();
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $tmpClass = new \stdClass();
                $year = $data['Year'];
                $Month = $data['Month'];
                $Day = $data['Day'];
                $unique_id = $data['unique_id'];
                $tmpClass->Year = $year;
                $tmpClass->Month = $Month;
                $tmpClass->Day = $Day;
                $tmpClass->unique_id = $unique_id;
                $MainClass->$unique_id = $tmpClass;

            }

            $exportData = json_encode($MainClass);
        } else {
            $exportData = 'No Records Available';
        }
        return $exportData;

    }

    protected function history_set($name, $event, $Date, $sitename, $action)
    {
        $unique_id = rand(time(), 1002);
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$name' ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        } else {
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
                $Username = $data[0]['Firstname'] . $data[0]['Othername'];
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`history`(`unique_id`, `name`, `event`, `Date`, `sitename`, `action`) VALUES ('$unique_id','$Username','$event','$Date','$sitename','$action')");
                if (!$stmt->execute()) {
                    print_r($stmt->errorInfo());
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit(json_encode($Error));
                } else {

                    return json_encode('Success');
                }
            }
        }
    }

}