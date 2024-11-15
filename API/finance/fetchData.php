<?php
namespace Finance;
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

    public $month;
    public $year;
    public $Date;

    public function __construct()
    {
        $this->year = date('Y');
        $this->month = date('F');
        $this->Date = date('l j \of F Y h:i:s A');
    }
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

    public function SortObjectData($dateArray, $ObjectArray)
    {

        $returnArray = new \stdClass();
        usort($dateArray, function ($a, $b) {
            return strcmp($a, $b);
        });
        $dateArray = array_reverse($dateArray);
        foreach ($dateArray as $sortedate) {
            foreach ($ObjectArray as $item) {
                $unique_id = rand(time(), 2002);
                $date = strtotime($item->date);
                if ($date == $sortedate) {
                    $returnArray->$unique_id = $item;
                }
            }
        }
        return $returnArray;


    }
    protected function Tithe_Records($unique_id, $Medium_payment, $description, $amount, $Date, $month, $year)
    {
        $input_list = array($Medium_payment, $description, $amount, $Date, $month, $year);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$unique_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $name = $result[0]['Firstname'] . $result[0]['Othername'];
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `unique_id`='$unique_id' AND `month`='$month'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                }
                if ($stmt->rowCount() > 0) {
                    $exportData = json_encode('Duplication detected, data already exists');
                    $resultCheck = false;
                    exit($exportData);
                } else {
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`tiths` (`unique_id`, `month`, `year`, `Medium_payment`, `Date`, `description`, `name`, `amount`)
                    VALUES ('$unique_id','$month','$year','$Medium_payment','$Date','$description','$name','$amount')");

                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encountered a problem';
                        exit(json_encode($Error));
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Tithe Data deleted", $date, "Tithe page dashboard Admin", "User add a tithe data");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }
                        $exportData = 'success';
                    }
                }
            } else {
                exit(json_encode('cannot find user, refresh the page as it might solve the problem'));
            }


            return $exportData;
        }
    }
    protected function Tithe_Records_update_data($unique_id, $Medium_payment, $description, $amount, $Date, $month, $year)
    {
        $resultCheck = true;
        $input_list = array($unique_id, $Medium_payment, $description, $amount, $Date, $month, $year);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=?");
            $stmt->bindParam('1', $unique_id, \PDO::PARAM_INT);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $name = $result[0]['Firstname'] . $result[0]['Othername'];

                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `unique_id`=? AND `month`=? AND `year`=?");
                $stmt->bindParam('1', $unique_id, \PDO::PARAM_INT);
                $stmt->bindParam('2', $month, \PDO::PARAM_STR);
                $stmt->bindParam('3', $year, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                }
                if ($stmt->rowCount() > 0) {
                    $stmt_insert = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`tiths` SET `month`=?,`year`=?,`Medium_payment`=?,`Date`=?,`description`=?,`name`=?,`amount`=? WHERE `unique_id`=? ");
                    $stmt_insert->bindParam('1', $month, \PDO::PARAM_STR);
                    $stmt_insert->bindParam('2', $year, \PDO::PARAM_STR);
                    $stmt_insert->bindParam('3', $Medium_payment, \PDO::PARAM_STR);
                    $stmt_insert->bindParam('4', $Date, \PDO::PARAM_STR);
                    $stmt_insert->bindParam('5', $description, \PDO::PARAM_STR);
                    $stmt_insert->bindParam('6', $name, \PDO::PARAM_STR);
                    $stmt_insert->bindParam('7', $amount, \PDO::PARAM_INT);
                    $stmt_insert->bindParam('8', $unique_id, \PDO::PARAM_INT);

                    if (!$stmt_insert->execute()) {
                        $stmt_insert = null;
                        $Error = 'Fetching data encountered a problem';
                        exit(json_encode($Error));
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Tithe Data update", $date, "Tithe page dashboard Admin", "User Update a tithe data ");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }
                        $exportData = 'Update success';
                    }


                } else {
                    $exportData = 'Unexpected, data cannot be found';
                    $resultCheck = false;
                    exit(json_encode($exportData));
                }

            } else {
                exit(json_encode('User does not exist'));
            }


            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Tithe_delete_data($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`tiths` where `unique_id`=?");
                    $stmt1->bindParam('1', $name, \PDO::PARAM_STR);
                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = 'deleting data encountered a problem';
                        exit($Error);
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Tithe Data deleted", $date, "Tithe page dashboard Admin", "User deleted a tithe data");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }

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

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }

        }
    }

    protected function offertory_Records($name, $type, $amount, $purpose, $date, $month, $year)
    {
        $input_list = array($name, $type, $amount, $purpose, $date, $month, $year);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `date`='$data' AND `amount`='$amount'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = 'Duplication detected, data already exists';
                $resultCheck = false;
            } else {
                $unique_id = rand(time(), 3002);
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`offertory_records` (`unique_id`, `date`,`month`,`year`, `event`, `type`, `amount`, `purpose`)
                VALUES (?, ?,?,?,?,?,?,?)");
                $stmt->bindParam('1', $unique_id, \PDO::PARAM_INT);
                $stmt->bindParam('2', $date, \PDO::PARAM_STR);
                $stmt->bindParam('3', $month, \PDO::PARAM_STR);
                $stmt->bindParam('4', $year, \PDO::PARAM_STR);
                $stmt->bindParam('5', $name, \PDO::PARAM_STR);
                $stmt->bindParam('6', $type, \PDO::PARAM_STR);
                $stmt->bindParam('7', $amount, \PDO::PARAM_INT);
                $stmt->bindParam('8', $purpose, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['unique_id'];
                    $historySet = $this->history_set($namer, "Offertory Data upload", $date, "Offertory page dashboard Admin", "User added an Offertory data");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }

                    $exportData = 'success';
                }
            }

            return $exportData;

        }
    }
    protected function RecordsUpdate($name, $type, $amount, $purpose, $date, $month, $year, $id)
    {
        $input_list = array($name, $type, $amount, $month, $year, $purpose, $date);
        $clean = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'Fetching data encountered a problem';
                $clean = false;
                exit(json_encode($Error));
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `unique_id`='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = 'Data Information cannot be found';
                $resultCheck = false;
            } else {

                $stmt = $this->data_connect()->prepare("UPDATE  `zoeworshipcentre`.`offertory_records` SET `date`=?,`month`=?,`year`=?,`event`=?,`type`=?,`amount`=?,`purpose`=? WHERE `unique_id`=?");
                $stmt->bindParam('1', $date, \PDO::PARAM_STR);
                $stmt->bindParam('2', $month, \PDO::PARAM_STR);
                $stmt->bindParam('3', $year, \PDO::PARAM_STR);
                $stmt->bindParam('4', $name, \PDO::PARAM_STR);
                $stmt->bindParam('5', $type, \PDO::PARAM_STR);
                $stmt->bindParam('6', $amount, \PDO::PARAM_INT);
                $stmt->bindParam('7', $purpose, \PDO::PARAM_STR);
                $stmt->bindParam('8', $id, \PDO::PARAM_INT);

                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['unique_id'];
                    $historySet = $this->history_set($namer, "Offertory Data Updated", $date, "Offertory page dashboard Admin", "User Updated an Offertory data");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }
                    $exportData = 'update success';
                }
            }

            return $exportData;
        }
    }
    protected function Record_delete_data($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`offertory_records` where `unique_id`=?");
                    $stmt1->bindParam('1', $name, \PDO::PARAM_INT);
                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = 'deleting data encountered a problem';
                        exit($Error);
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Offertory Data delete", $date, "Offertory page dashboard Admin", "User deleted an Offertory data");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }

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

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }

        }
    }
    protected function PayList($name, $amount, $medium, $date, $id)
    {
        date('UTC');
        $resultCheck = "";
        $exportData = "";
        $date = date('Y-m-d H:m:s');
        $status = 'active pay';
        $input_list = array($name, $amount, $medium, $date, $id);
        $clean = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'Fetching data encountered a problem';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM  `zoeworshipcentre`.`dues` where `unique_id`='$id' AND `name`='$name' AND `date`='$date'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoedues`.`$name` ( `$id`, `user`, `Amount`, `Date`, `Medium`, `status`, `Record_date`)values (?,?,?,?,?,?,?)");

                $stmt->bindParam('1', $id, \PDO::PARAM_INT);
                $stmt->bindParam('2', $name, \PDO::PARAM_STR);
                $stmt->bindParam('3', $amount, \PDO::PARAM_INT);
                $stmt->bindParam('4', $date, \PDO::PARAM_STR);
                $stmt->bindParam('5', $medium, \PDO::PARAM_STR);
                $stmt->bindParam('6', $status, \PDO::PARAM_INT);
                $stmt->bindParam('7', $date, \PDO::PARAM_STR);

                if (!$stmt->execute()) {

                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else

                    $exportData = 'Data entry was a success Page will refresh to display new data';
                exit($exportData);
            }


        } else {
            $exportData = 'An Error Ocurred, data user cannot be found!';
            $resultCheck = false;
            exit($exportData);
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }

    }
    protected function Dues_Records($name, $department, $amount, $purpose, $due)
    {
        $input_list = array($name, $department, $amount, $purpose, $due);
        $date = date("Y-m-d");
        $status = 'active';
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` where `name`='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                $exportData = 'Duplication detected, data already exists';
            } else {
                $unique_id = rand(time(), 3002);
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`dues` (`unique_id`,`name`, `amount`, `purpose`, `department`, `status`, `due_date`, `date`) VALUES ('$unique_id','$name','$amount','$purpose','$department','$status','$due','$date')");

                $stmt->bindParam('1', $unique_id, \PDO::PARAM_INT);
                $stmt->bindParam('2', $name, \PDO::PARAM_STR);
                $stmt->bindParam('3', $amount, \PDO::PARAM_INT);
                $stmt->bindParam('4', $purpose, \PDO::PARAM_STR);
                $stmt->bindParam('5', $department, \PDO::PARAM_STR);
                $stmt->bindParam('6', $status, \PDO::PARAM_STR);
                $stmt->bindParam('7', $due, \PDO::PARAM_STR);
                $stmt->bindParam('8', $date, \PDO::PARAM_STR);

                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                } else {
                    ///////////////Creating Dues Table
                    $stmt = $this->data_connect()->prepare("
                    CREATE TABLE  `zoedues`.`$name`
                    (`id` INT(255) AUTO_INCREMENT PRIMARY KEY,
                    `$unique_id` INT(255),
                    `user` varchar(255),
                    `Amount` varchar(255),
                    `Date` varchar(255),
                    `Medium` varchar(255),
                    `status` varchar(255),
                    `Record_date` varchar(255)
                    )  ");
                    if ($stmt->execute()) {
                        $exportData = 'Data entry was a success Page will refresh to display new data';
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Dues Data Upload", $date, "Dues page dashboard Admin", "User Uploaded an Dues data");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }
                        $exportData = 'success';
                    } else {
                        $Error = 'An Unexpected error occurred whiles creating pay list column';
                        exit(json_encode($Error));
                    }
                }



            }

            return $exportData;
        }
    }

    protected function Dues_Records_update($name, $department, $amount, $purpose, $due, $id)
    {
        $resultCheck = "";
        $exportData = "";
        $input_list = array($name, $department, $amount, $purpose, $due, $id);
        $clean = true;
        date('UTC');
        $date = date("Y-m-d");
        $status = 'active';
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'Error validating data, check for empty feilds !';
                $clean = false;
                exit(json_encode($Error));
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` where `unique_id`='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = 'An Error Ocurred, data  cannot be found ';
                $resultCheck = false;
                exit(json_encode($exportData));
            } else {
                $clearance_table = false;
                $OldName = $stmt->fetchAll()[0]['name'];
                $TableChange = false;
                $checkTable = $this->data_connect()->prepare("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME ='$name' AND TABLE_SCHEMA = 'zoedues'");
                if (!$checkTable->execute()) {
                    $checkTable = null;
                    $Error = 'Fetching data encountered a- problem';
                    exit(json_encode($Error));
                } else {
                    if ($checkTable->rowCount() > 0) {
                        $TableChange = true;
                        $clearance_table = true;
                    }
                }

                if (!$TableChange) {
                    $checkTable = $this->data_connect()->prepare("RENAME TABLE `zoedues`.`$OldName` TO `zoedues`.`$name` ");
                    if (!$checkTable->execute()) {
                        $checkTable = null;
                        $Error = 'Fetching data encountered- a problem';
                        exit(json_encode($Error));
                    } else {
                        $clearance_table = true;
                    }
                }
                if ($clearance_table) {
                    $stmt = $this->data_connect()->prepare("UPDATE  `zoeworshipcentre`.`dues` SET `name`='$name',`amount`='$amount',`purpose`='$purpose',`department`='$department',`status`='$status',`due_date`='$due',`date`='$date' WHERE `unique_id`='$id'");

                    $stmt->bindParam('1', $name, \PDO::PARAM_STR);
                    $stmt->bindParam('2', $amount, \PDO::PARAM_INT);
                    $stmt->bindParam('3', $purpose, \PDO::PARAM_STR);
                    $stmt->bindParam('4', $department, \PDO::PARAM_STR);
                    $stmt->bindParam('5', $status, \PDO::PARAM_STR);
                    $stmt->bindParam('6', $due, \PDO::PARAM_STR);
                    $stmt->bindParam('7', $date, \PDO::PARAM_STR);
                    $stmt->bindParam('8', $id, \PDO::PARAM_INT);

                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encountered a problem';
                        exit(json_encode($Error));
                    } else {

                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Dues Data Update", $date, "Dues page dashboard Admin", "User Updated an Dues data");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }

                        exit(json_encode('update success'));
                    }
                } else {
                    exit('An unexpected error occurred');
                }
            }
        }
    }
    protected function Dues_delete_data($name)
    {
        $exportData = 0;
        $input_list = array($name);
        $clean = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem!';
                $clean = false;
                exit(json_encode($Error));
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $tableName = $result[0]['name'];
                $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`dues` where `unique_id`=?");
                $stmt1->bindParam('1', $name, \PDO::PARAM_STR);
                if (!$stmt1->execute()) {
                    $stmt1 = null;
                    $Error = 'deleting data encountered a problem';
                    exit(json_encode($Error));
                } else {
                    $stmt1 = $this->data_connect()->prepare("DROP TABLE `zoedues`.`$tableName`");
                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = 'deleting data encountered a problem';
                        exit(json_encode($Error));
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Dues Data deleted", $date, "Dues page dashboard Admin", "User daleted an Dues data");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }
                        $exportData = 'Item Deleted Successfully';
                        exit(json_encode($exportData));
                    }
                }
            } else {
                exit(json_encode('No match for search query'));
            }


        }
    }
    protected function Account_Records($name, $created, $amount)
    {
        $input_list = array($name, $created, $amount);
        $date = date("Y-m-d");
        $status = 'active';
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_system` where `account_name`='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Error fetching data';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = 'Duplication detected, data already exists';
            } else {
                $unique_id = rand(time(), 3002);
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`account_system` (`account_name`, `date_created`, `Total_amount`, `last_modified`) VALUES (?,?,?,?)");

                $stmt->bindParam('1', $name, \PDO::PARAM_STR);
                $stmt->bindParam('2', $created, \PDO::PARAM_INT);
                $stmt->bindParam('3', $amount, \PDO::PARAM_STR);
                $stmt->bindParam('4', $date, \PDO::PARAM_STR);

                if (!$stmt->execute()) {
                    print_r($stmt->errorInfo());
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    ///////////////Creating Dues Table
                    $stmt = $this->data_connect()->prepare("
                    CREATE TABLE  `zoeaccounts`.`$name`
                    (`id` INT(255) AUTO_INCREMENT PRIMARY KEY,
                    `unique_id` INT(255),
                    `description` varchar(255),
                    `date` varchar(255),
                    `category` varchar(255),
                    `percentage` varchar(255),
                    `amount` varchar(255),
                    `balance` varchar(255)
                    )  ");
                    if ($stmt->execute()) {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Account Data Upload", $date, "Account page dashboard Admin", "User Uploaded an Account data");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }
                        $exportData = 'Upload was a success';
                    } else {
                        $Error = 'An Unexpected error occurred whiles creating pay list column';
                        exit($Error);
                    }
                }

            }

            return $exportData;
        }
    }
    protected function Account_update($name, $created, $amount, $id)
    {
        $input_list = array($name, $created, $amount);
        $clean = true;
        date('UTC');
        $date = date("Y-m-d");
        $status = 'active';
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'Fetching data encountered a problem';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_system` where `id`='$id'");
            if (!$stmt->execute()) {
                print_r($stmt->errorInfo());
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = 'An Error Ocurred, data #Kqy' . $id . 'xcre cannot be found ';
                $resultCheck = false;
            } else {
                $stmt = $this->data_connect()->prepare("UPDATE  `zoeworshipcentre`.`account_system` SET `account_name`=?,`date_created`=?,`Total_amount`=?,`last_modified`=? WHERE `id`=?");
                $stmt->bindParam('1', $name, \PDO::PARAM_STR);
                $stmt->bindParam('2', $created, \PDO::PARAM_STR);
                $stmt->bindParam('3', $amount, \PDO::PARAM_STR);
                $stmt->bindParam('4', $date, \PDO::PARAM_STR);
                $stmt->bindParam('5', $id, \PDO::PARAM_STR);

                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['unique_id'];
                    $historySet = $this->history_set($namer, "Account Data Update", $date, "Account page dashboard Admin", "User Updated an Account data");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }

                    exit('Upload was a success');
                }



            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Account_delete_data($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_system` where `account_name` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $DeleteMainAcc = $this->data_connect()->prepare("DROP TABLE `zoeaccounts`.`$name`");
                    if (!$DeleteMainAcc->execute()) {
                        $DeleteMainAcc = null;
                        $Error = 'deleting data encountered a problem';
                        exit(json_encode($Error));
                    } else {
                        $DeleteFromAcc = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`account_system` where `account_name`=?");
                        $DeleteFromAcc->bindParam('1', $name, \PDO::PARAM_STR);
                        if (!$DeleteFromAcc->execute()) {
                            $DeleteFromAcc = null;
                            $Error = 'deleting data encountered a problem';
                            exit($Error);
                        } else {
                            $date = date('Y-m-d H:i:s');
                            $namer = $_SESSION['unique_id'];
                            $historySet = $this->history_set($namer, "Account Data deleted", $date, "Account page dashboard Admin", "User deleted an Account data");
                            if (json_decode($historySet) != 'Success') {
                                $exportData = 'success';
                            }

                            $resultCheck = true;
                            $exportData = 'Item Deleted Successfully';
                        }
                    }
                } else {
                    $stmt = null;
                    $Error = 'deleting data encountered a problem';
                    exit($Error);
                }


            } else {
                exit('No match for search query');
            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }

        }
    }
    protected function Account_user_update($acc_name, $description, $date, $time, $category, $percentage, $amount, $balance, $id)
    {
        $input_list = array($acc_name, $description, $date, $time, $category, $percentage, $amount, $balance, $id);
        $clean = true;
        date('UTC');
        $date = date("Y-m-d");
        $status = 'active';
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'Fetching data encountered a problem';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("UPDATE  `zoeaccounts`.`$acc_name` SET `description`=?,`date`=?,`category`=?, `percentage`=?,`amount`=?,balance=? WHERE `unique_id`=?");

            $stmt->bindParam('1', $description, \PDO::PARAM_STR);
            $stmt->bindParam('2', $date, \PDO::PARAM_STR);
            $stmt->bindParam('3', $category, \PDO::PARAM_STR);
            $stmt->bindParam('4', $percentage, \PDO::PARAM_STR);
            $stmt->bindParam('5', $amount, \PDO::PARAM_STR);
            $stmt->bindParam('6', $balance, \PDO::PARAM_STR);
            $stmt->bindParam('7', $id, \PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            } else {
                $date = date('Y-m-d H:i:s');
                $namer = $_SESSION['unique_id'];
                $historySet = $this->history_set($namer, "Account Data Updated", $date, "Account page dashboard Admin", "User Updated an Account data $acc_name");
                if (json_decode($historySet) != 'Success') {
                    $exportData = 'success';
                }

                $exportData = 'Data entry was a success Page will refresh to display new data';
                exit($exportData);
            }





            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Account_user_delete_data($form_name, $unique_id)
    {
        $exportData = 0;
        $input_list = array($form_name);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeaccounts`.`$form_name` where `unique_id` ='$unique_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeaccounts`.`$form_name` where `unique_id`=?");

                    $stmt1->bindParam('1', $unique_id, \PDO::PARAM_STR);
                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = 'deleting data encountered a problem';
                        exit($Error);
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Account Data deleted", $date, "Account page dashboard Admin", "User deleted an Account data $form_name");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }

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

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }

        }
    }
    protected function Account_user_Records($acc_name, $description, $date, $time, $category, $percentage, $amount, $balance)
    {
        $input_list = array($acc_name, $description, $date, $time, $category, $percentage, $amount, $balance);

        $date = date("Y-m-d");
        $status = 'active';
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
            $unique_id = rand(time(), 3002);
            $stmt = $this->data_connect()->prepare("INSERT INTO `zoeaccounts`.`$acc_name` (`unique_id`,`description`,`date`,`category`,`percentage`,`amount`,`balance`) VALUES (?,?,?,?,?,?,?)");
            $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
            $stmt->bindParam('2', $description, \PDO::PARAM_STR);
            $stmt->bindParam('3', $date, \PDO::PARAM_STR);
            $stmt->bindParam('4', $category, \PDO::PARAM_STR);
            $stmt->bindParam('5', $percentage, \PDO::PARAM_STR);
            $stmt->bindParam('6', $amount, \PDO::PARAM_STR);
            $stmt->bindParam('7', $balance, \PDO::PARAM_STR);


            if (!$stmt->execute()) {
                print_r($stmt->errorInfo());
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            } else {
                $date = date('Y-m-d H:i:s');
                $namer = $_SESSION['unique_id'];
                $historySet = $this->history_set($namer, "Account Data Upload", $date, "Account page dashboard Admin", "User Uploaded an Account data $acc_name");
                if (json_decode($historySet) != 'Success') {
                    $exportData = 'success';
                }

                $exportData = 'Data entry was a success Page will refresh to display new data';
                exit($exportData);

            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Transaction($account, $category, $amount, $status, $authorize, $date)
    {
        $exportData = "";
        $resultCheck = true;
        $input_list = array($account, $category, $amount, $status, $authorize);
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
            $unique_id = rand(time(), 3002);

            $stmt = $this->data_connect()->prepare("SELECT Total_amount from `zoeworshipcentre`.`account_system` where `account_name`='$account'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $Amount = $result[0]['Total_amount'];
                $newAmount = 0;
                if ($category == 'expenses') {
                    $newAmount = intval($Amount) - intval($amount);
                }
                if ($category == 'income') {
                    $newAmount = intval($Amount) + intval($amount);
                }
                if ($newAmount == 0) {
                    $percentage = 0;
                } else {
                    if ($Amount == 0) {
                        $Amount = 1;
                    }

                    $percentage = ((100 * $newAmount) / $Amount) - 100;
                }



                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`transaction_records` (`unique_id`,`account`, `Category`, `Amount`, `Status`, `Authorize`,`Date`) VALUES ('$unique_id','$account','$category','$amount','$status','$authorize','$date')");

                $stmt->bindParam('1', $unique_id, \PDO::PARAM_INT);
                $stmt->bindParam('2', $account, \PDO::PARAM_STR);
                $stmt->bindParam('3', $category, \PDO::PARAM_STR);
                $stmt->bindParam('4', $amount, \PDO::PARAM_INT);
                $stmt->bindParam('5', $status, \PDO::PARAM_STR);
                $stmt->bindParam('6', $authorize, \PDO::PARAM_STR);
                $stmt->bindParam('7', $date, \PDO::PARAM_STR);

                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                } else {
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeaccounts`.`$account`(`unique_id`, `description`, `date`, `category`, `percentage`, `amount`, `balance`) VALUES (?,?,?,?,?,?,?) ");
                    $cate_name = $category . 'record from transaction records';
                    $stmt->bindParam('1', $unique_id, \PDO::PARAM_INT);
                    $stmt->bindParam('2', $cate_name, \PDO::PARAM_STR);
                    $stmt->bindParam('3', $date, \PDO::PARAM_STR);
                    $stmt->bindParam('4', $category, \PDO::PARAM_INT);
                    $stmt->bindParam('5', $percentage, \PDO::PARAM_STR);
                    $stmt->bindParam('6', $amount, \PDO::PARAM_STR);
                    $stmt->bindParam('7', $newAmount, \PDO::PARAM_STR);

                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encountered a problem';
                        exit(json_encode($Error));
                    } else {
                        $stmt = $this->data_connect()->prepare("UPDATE  `zoeworshipcentre`.`account_system` SET`Total_amount`=?,`last_modified`=? WHERE `account_name`=?");
                        $date = date('Ymd');
                        $stmt->bindParam('1', $newAmount, \PDO::PARAM_STR);
                        $stmt->bindParam('2', $date, \PDO::PARAM_STR);
                        $stmt->bindParam('3', $account, \PDO::PARAM_STR);

                        if (!$stmt->execute()) {
                            $stmt = null;
                            $Error = 'Error: encountered a problem while adding data';
                            exit(json_encode($Error));
                        } else {
                            $date = date('Y-m-d H:i:s');
                            $namer = $_SESSION['unique_id'];
                            $historySet = $this->history_set($namer, "Transaction Data Upload", $date, "Transaction page dashboard Admin", "User Uploaded anTransaction data ");
                            if (json_decode($historySet) != 'Success') {
                                $exportData = 'success';
                            }
                            $exportData = 'success';
                        }

                    }
                }
            } else {
                exit(json_encode("Account is invalid"));
            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Transaction_update_data($id, $account, $category, $amount, $status, $authorize, $date)
    {
        $exportData = "";
        $input_list = array($account, $category, $amount, $status, $authorize);
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
            $condition = false;
            $unique_id = rand(time(), 3002);
            $stmt = $this->data_connect()->query("SELECT * FROM `zoeworshipcentre`.`transaction_records` where `unique_id`='$id' limit 1");

            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }

            if ($stmt->rowCount() > 0) {
                $stmt = $this->data_connect()->prepare("SELECT * from `zoeworshipcentre`.`transaction_records` where `unique_id`='$id'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                }
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetchAll();
                    $Account_uploaded_name = $result[0]['account'];
                    $Account_uploaded_category = $result[0]['Category'];
                    $Account_uploaded_amount = $result[0]['Amount'];

                    $stmt = $this->data_connect()->prepare("SELECT Total_amount from `zoeworshipcentre`.`account_system` where `account_name`=?");
                    $stmt->bindParam('1', $account, \PDO::PARAM_STR);
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encountered a problem';
                        exit(json_encode($Error));
                    }
                    if ($stmt->rowCount() > 0) {
                        $result = $stmt->fetchAll();
                        $Amount = $result[0]['Total_amount'];
                        $Percentage = 0;
                        $Original = $Amount;
                        $OriginalMain = $Amount;
                        $Original_r = $Amount;
                        if ($account == $Account_uploaded_name) {
                            if ($Account_uploaded_category == 'expenses') {
                                $Original = intval($Amount) + intval($Account_uploaded_amount);
                            }
                            if ($Account_uploaded_category == 'income') {
                                $Original = intval($Amount) - intval($Account_uploaded_amount);
                            }
                        } else {
                            $stmt = $this->data_connect()->prepare("SELECT Total_amount from `zoeworshipcentre`.`account_system` where `account_name`='$Account_uploaded_name'");
                            if (!$stmt->execute()) {
                                $stmt = null;
                                $Error = 'Fetching data encountered a problem';
                                exit(json_encode($Error));
                            }
                            if ($stmt->rowCount() > 0) {
                                $result = $stmt->fetchAll();
                                $Amount = $result[0]['Total_amount'];
                                $OriginalMain = $Amount - $amount;
                            }
                        }


                        $newAmount = 0;
                        if ($category == 'expenses') {
                            $newAmount = intval($Original) - intval($amount);
                        }
                        if ($category == 'income') {
                            $newAmount = intval($Original) + intval($amount);
                        }
                        if ($newAmount == 0) {
                            $percentage = 0;
                        } else {
                            $Original_r = $Original;
                            if ($Original == 0) {
                                $Original_r = 1;
                            }

                            $percentage = abs(round((100 * $newAmount) / $Original_r) - 100);
                        }

                        if ($account == $Account_uploaded_name) {
                            $stmt = $this->data_connect()->prepare("UPDATE `zoeaccounts`.`$account` SET `description`='$category record from transaction records',`date`='$date',`category`='$category',`percentage`='$percentage',`amount`='$amount',`balance`='$newAmount'  where `unique_id`='$id'");
                            $cate_name = $category . ' record from transaction records';
                            $stmt->bindParam('1', $cate_name, \PDO::PARAM_STR);
                            $stmt->bindParam('2', $date, \PDO::PARAM_STR);
                            $stmt->bindParam('3', $category, \PDO::PARAM_INT);
                            $stmt->bindParam('4', $percentage, \PDO::PARAM_STR);
                            $stmt->bindParam('5', $amount, \PDO::PARAM_STR);
                            $stmt->bindParam('6', $newAmount, \PDO::PARAM_STR);
                            $stmt->bindParam('7', $id, \PDO::PARAM_INT);

                            if (!$stmt->execute()) {
                                $stmt = null;
                                $Error = 'Fetching data encountered a problem';
                                exit(json_encode($Error));
                            } else {
                                $stmt = $this->data_connect()->prepare("UPDATE  `zoeworshipcentre`.`account_system` SET`Total_amount`=?,`last_modified`=? WHERE `account_name`=?");
                                $date = date('Ymd');
                                $stmt->bindParam('1', $newAmount, \PDO::PARAM_STR);
                                $stmt->bindParam('2', $date, \PDO::PARAM_STR);
                                $stmt->bindParam('3', $account, \PDO::PARAM_STR);

                                if (!$stmt->execute()) {
                                    $stmt = null;
                                    $Error = 'Error: encountered a problem while adding data';
                                    exit(json_encode($Error));
                                } else {
                                    $date = date('Y-m-d H:i:s');
                                    $namer = $_SESSION['unique_id'];
                                    $historySet = $this->history_set($namer, "Transaction Data Upload", $date, "Transaction page dashboard Admin", "User Uploaded anTransaction data ");
                                    if (json_decode($historySet) != 'Success') {
                                        $exportData = 'success';
                                    }
                                    $condition = true;
                                }

                            }
                        } else {
                            $stmt = $this->data_connect()->prepare("DELETE FROM `zoeaccounts`.`$Account_uploaded_name` where `unique_id`='$id'");
                            if (!$stmt->execute()) {
                                $stmt = null;
                                $Error = 'Fetching data encountered a problem';
                                exit(json_encode($Error));
                            } else {
                                $stmt = $this->data_connect()->prepare("UPDATE  `zoeworshipcentre`.`account_system` SET `Total_amount`=?,`last_modified`=? WHERE `account_name`=?");

                                $stmt->bindParam('1', $OriginalMain, \PDO::PARAM_STR);
                                $stmt->bindParam('2', $date, \PDO::PARAM_STR);
                                $stmt->bindParam('3', $Account_uploaded_name, \PDO::PARAM_STR);


                                if ($stmt->execute()) {
                                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeaccounts`.`$account`(`unique_id`, `description`, `date`, `category`, `percentage`, `amount`, `balance`) VALUES (?,?,?,?,?,?,?) ");

                                    $cate_name = $category . ' record from transaction records';
                                    $stmt->bindParam('1', $id, \PDO::PARAM_INT);
                                    $stmt->bindParam('2', $cate_name, \PDO::PARAM_STR);
                                    $stmt->bindParam('3', $date, \PDO::PARAM_STR);
                                    $stmt->bindParam('4', $category, \PDO::PARAM_INT);
                                    $stmt->bindParam('5', $percentage, \PDO::PARAM_STR);
                                    $stmt->bindParam('6', $amount, \PDO::PARAM_STR);
                                    $stmt->bindParam('7', $newAmount, \PDO::PARAM_STR);


                                    if (!$stmt->execute()) {
                                        $stmt = null;
                                        $Error = 'Fetching data encountered a problem';
                                        exit(json_encode($Error));
                                    } else {
                                        $stmt = $this->data_connect()->prepare("UPDATE  `zoeworshipcentre`.`account_system` SET`Total_amount`=?,`last_modified`=? WHERE `account_name`=?");
                                        $date = date('Ymd');
                                        $stmt->bindParam('1', $newAmount, \PDO::PARAM_STR);
                                        $stmt->bindParam('2', $date, \PDO::PARAM_STR);
                                        $stmt->bindParam('3', $account, \PDO::PARAM_STR);

                                        if (!$stmt->execute()) {
                                            $stmt = null;
                                            $Error = 'Error: encountered a problem while adding data';
                                            exit(json_encode($Error));
                                        } else {
                                            $date = date('Y-m-d H:i:s');
                                            $namer = $_SESSION['unique_id'];
                                            $historySet = $this->history_set($namer, "Transaction Data Upload", $date, "Transaction page dashboard Admin", "User Uploaded anTransaction data ");
                                            if (json_decode($historySet) != 'Success') {
                                                $exportData = 'success';
                                            }
                                            $condition = true;
                                        }

                                    }
                                } else {
                                    $stmt = null;
                                    $Error = 'Fetching data encountered a problem';
                                    exit(json_encode($Error));
                                }
                            }

                        }
                    } else {
                        exit(json_encode('An error occured whiles processing this data, please refresh the page'));
                    }
                } else {
                    exit(json_encode('An error occured whiles processing this data, please refresh the page'));
                }
            } else {
                exit(json_encode('An error occured whiles processing this data, please refresh the page'));
            }
            if ($condition) {
                $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`transaction_records` SET `account`=?,`Category`=?,`Amount`=?,`Status`=?,`Authorize`=?,`Date`=? WHERE `unique_id` = ?");

                $stmt->bindParam('1', $account, \PDO::PARAM_STR);
                $stmt->bindParam('2', $category, \PDO::PARAM_STR);
                $stmt->bindParam('3', $amount, \PDO::PARAM_STR);
                $stmt->bindParam('4', $status, \PDO::PARAM_STR);
                $stmt->bindParam('5', $authorize, \PDO::PARAM_STR);
                $stmt->bindParam('6', $date, \PDO::PARAM_STR);
                $stmt->bindParam('7', $id, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['unique_id'];
                    $historySet = $this->history_set($namer, "Transaction Data updated", $date, "Transaction page dashboard Admin", "User updated anTransaction data ");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }

                    exit(json_encode('Update success'));

                }
            }


            return $exportData;
        }
    }
    protected function Transaction_delete($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`transaction_records` where `unique_id`=?");
                    $stmt1->bindParam('1', $name, \PDO::PARAM_STR);
                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = 'deleting data encountered a problem';
                        exit(json_encode($Error));
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Transaction Data deleted", $date, "Transaction page dashboard Admin", "User deleted anTransaction data ");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }

                        $resultCheck = true;
                        $exportData = 'Item Deleted Successfully';
                    }
                } else {
                    $stmt = null;
                    $Error = 'deleting data encountered a problem';
                    exit(json_encode($Error));
                }


            } else {
                exit(json_encode('No match for search query'));
            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }

        }
    }
    protected function TransactionListFilter($account, $category, $year, $nk)
    {

        if ($nk == 0) {
            $nk = 1;
        }

        $exportData = false;
        $total_pages = 0;
        $num = 40 * ($nk - 1);
        $stmt_pages = 0;
        if ($category == 'Select' && $account == 'Select') {
            $stmt_pages = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` Where `Date` like '%$year%' ORDER BY `id` DESC");
        } else if ($category != 'Select' && $account == 'Select') {
            $stmt_pages = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` Where `Date` like '%$year%' AND `category` like '%$category%' ORDER BY `id` DESC");
        } else if ($category == 'Select' && $account != 'Select') {
            $stmt_pages = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` Where `Date` like '%$year%' AND `account` like '%$account%' ORDER BY `id` DESC");
        } else {
            $stmt_pages = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` Where `Date` like '%$year%' AND `account` like '%$account%' AND `category`like '%$category%' ORDER BY `id` DESC");
        }



        if ($category == 'Select' && $account == 'Select') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` Where `Date` like '%$year%' ORDER BY `id` DESC limit 40 OFFSET $num");
        } else if ($category != 'Select' && $account == 'Select') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` Where `Date` like '%$year%' AND `category` like '%$category%' ORDER BY `id` DESC limit 40 OFFSET $num");
        } else if ($category == 'Select' && $account != 'Select') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` Where `Date` like '%$year%' AND `account` = '$account' ORDER BY `id` DESC limit 40 OFFSET $num");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` Where `Date` like '%$year%' AND `account` = '$account' AND `category`like '%$category%' ORDER BY `id` DESC limit 40 OFFSET $num");
        }

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encountered a problem');
            exit($Error);
        }
        if ($stmt_pages->execute()) {
            $total_pages = $stmt_pages->rowCount();
        }

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $account = $this->validate($data['account']);
                $amount = $this->validate($data['Amount']);
                $date = $this->validate($data['Date']);
                $id = $this->validate($data['unique_id']);
                $Status = $this->validate($data['Status']);
                $category = $this->validate($data['Category']);
                $Authorize = $this->validate($data['Authorize']);

                $ObjectInfo->account = $account;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->Date = $date;
                $ObjectInfo->category = $category;
                $ObjectInfo->Authorize = $Authorize;
                $ObjectInfo->Status = $Status;
                $ObjectInfo->id = $id;
                $ObjectData = json_encode($ObjectInfo);

                $ExportSend->account = $account;
                $ExportSend->amount = $amount;
                $ExportSend->Date = $date;
                $ExportSend->category = $category;
                $ExportSend->Authorize = $Authorize;
                $ExportSend->Status = $Status;
                $ExportSend->id = $id;
                $ExportSend->obj = $ObjectData;
                $exportname = $id . $amount;
                $ExportSendMain->$exportname = $ExportSend;
            }
            $MainSendPages = new \stdClass();
            $MainSendPages->pages = $total_pages;
            $MainSendPages->result = $ExportSendMain;
            $exportData = $MainSendPages;
        } else {
            $exportData = 'Not Records Available';
        }

        if ($exportData != "") {
            return $exportData;
        } else {
            return false;
        }
    }
    protected function TransactionListExport()
    {
        $exportData = false;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records`");
        if (!$stmt->execute()) {

            $stmt = null;
            $Error = json_encode('Fetching data encountered a problem');
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            $date = date('Y-m-d H:i:s');
            $namer = $_SESSION['unique_id'];
            $historySet = $this->history_set($namer, "Transaction Data Export", $date, "Transaction page dashboard Admin", "User Exported Transaction data ");
            if (json_decode($historySet) != 'Success') {
                $exportData = 'success';
            }
            foreach ($result as $data) {
                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $account = $this->validate($data['account']);
                $amount = $this->validate($data['Amount']);
                $date = $this->validate($data['Date']);
                $id = $this->validate($data['unique_id']);
                $Status = $this->validate($data['Status']);
                $category = $this->validate($data['Category']);
                $Authorize = $this->validate($data['Authorize']);

                $ExportSend->account = $account;
                $ExportSend->amount = $amount;
                $ExportSend->Date = $date;
                $ExportSend->category = $category;
                $ExportSend->Authorize = $Authorize;
                $ExportSend->Status = $Status;
                $ExportSend->id = $id;
                $exportname = rand(time(), 1298);
                $ExportSendMain->$exportname = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'Not Records Available';
        }

        if ($exportData != "") {
            return $exportData;
        } else {
            return false;
        }
    }
    protected function Budget_check_data($name)
    {
        $stmt = $this->data_connect()->query("SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME ='$name' AND TABLE_SCHEMA = 'zoe_budget'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a- problem';
            exit(json_encode($Error));
        } else {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
    protected function Budget_create_data($name)
    {
        $stmt = $this->data_connect()->query("CREATE TABLE  `zoe_budget`.`$name`
                    (`id` INT(255) AUTO_INCREMENT PRIMARY KEY,
                    `category` varchar(255)
                    `unique_id` INT(255),
                    `type` varchar(255),
                    `amount` INT(255),
                    `details` varchar(255),
                    `date` date,
                    `Year` varchar(255),
                    `Month` varchar(255),
                    `Record_by` varchar(255)
                    ) ");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a- problem';
            exit(json_encode($Error));
        } else {
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

    protected function Budget($name, $status, $authorize, $about, $details)
    {
        $exportData = "";
        $input_list = array($name, $status, $authorize, $about, $details);
        $date = date("Y-m-d");
        $status = 'active';
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
            $unique_id = rand(time(), 3002);
            $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`budget` (`Name`, `status`, `Authorize`, `About`, `details`,`Date`) VALUES (?,?,?,?,?,?)");

            $stmt->bindParam('1', $name, \PDO::PARAM_STR);
            $stmt->bindParam('2', $status, \PDO::PARAM_STR);
            $stmt->bindParam('3', $authorize, \PDO::PARAM_STR);
            $stmt->bindParam('4', $about, \PDO::PARAM_INT);
            $stmt->bindParam('5', $details, \PDO::PARAM_STR);
            $stmt->bindParam('6', $date, \PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            } else {
                $date = date('Y-m-d H:i:s');
                $namer = $_SESSION['unique_id'];
                $historySet = $this->history_set($namer, "Budget  Data Upload", $date, "Budget  page dashboard Admin", "User Uploaded a Budget  data ");
                if (json_decode($historySet) != 'Success') {
                    $exportData = 'success';
                }
                exit('Upload was a success');

            }
            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }

    protected function Budget_update($name, $status, $authorize, $about, $details, $id)
    {
        $exportData = "";
        $input_list = array($name, $status, $authorize, $about, $details, $id);
        $date = date("Y-m-d");
        $status = 'active';
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
            $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`budget` SET `Name`=?,`status`=?,`Authorize`=?,`Amount`=?,`details`=?,`Date`=? WHERE Id = ?");
            $stmt->bindParam('1', $name, \PDO::PARAM_STR);
            $stmt->bindParam('2', $status, \PDO::PARAM_STR);
            $stmt->bindParam('3', $authorize, \PDO::PARAM_STR);
            $stmt->bindParam('4', $amount, \PDO::PARAM_STR);
            $stmt->bindParam('5', $details, \PDO::PARAM_STR);
            $stmt->bindParam('6', $date, \PDO::PARAM_STR);
            $stmt->bindParam('7', $id, \PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            } else {
                $date = date('Y-m-d H:i:s');
                $namer = $_SESSION['unique_id'];
                $historySet = $this->history_set($namer, "Budget  Data Update", $date, "Budget  page dashboard Admin", "User Updated a Budget  data ");
                if (json_decode($historySet) != 'Success') {
                    $exportData = 'success';
                }
                exit('Upload was a success');

            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Budget_delete_data($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`budget` where `id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`budget` where `id`=?");
                    $stmt->bindParam('1', $name, \PDO::PARAM_STR);
                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = 'deleting data encountered a problem';
                        exit($Error);
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Budget  Data Update", $date, "Budget  page dashboard Admin", "User Updated a Budget  data ");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }
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

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }

        }
    }

    protected function Add_Budget_user($category, $type, $amount, $details, $date, $year, $month, $recorded_by)
    {

        $database_name = "zoe_" . $year . "_budget";
        $input_list = array($category, $type, $amount, $details, $date, $year, $month, $recorded_by);
        $date = date("Y-m-d");
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
            $unique_id = rand(time(), 3002);
            $stmt = $this->data_connect()->prepare("INSERT INTO `zoe_budget`.$database_name (`category`,`unique_id`, `type`, `amount`, `details`, `date`, `Year`, `month`, `recorded_by`) VALUES ('$category','$unique_id','$type','$amount','$details','$date','$year','$month','$recorded_by')");

            $stmt->bindParam('1', $category, \PDO::PARAM_STR);
            $stmt->bindParam('2', $unique_id, \PDO::PARAM_INT);
            $stmt->bindParam('3', $type, \PDO::PARAM_STR);
            $stmt->bindParam('4', $amount, \PDO::PARAM_INT);
            $stmt->bindParam('5', $details, \PDO::PARAM_STR);
            $stmt->bindParam('6', $date, \PDO::PARAM_STR);
            $stmt->bindParam('7', $year, \PDO::PARAM_STR);
            $stmt->bindParam('8', $month, \PDO::PARAM_STR);
            $stmt->bindParam('9', $recorded_by, \PDO::PARAM_STR);

            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            } else {
                $date = date('Y-m-d H:i:s');
                $namer = $_SESSION['unique_id'];
                $historySet = $this->history_set($namer, "Budget  Data Upload", $date, "Budget  page dashboard Admin", "User Uploaded a Budget  data ");
                if (json_decode($historySet) != 'Success') {
                    $exportData = 'success';
                }
                $exportData = 'success';

            }
            return $exportData;

        } else {
            return 'Unexpected error';
        }
    }
    protected function Budget_user_update($category, $type, $amount, $details, $date, $year, $month, $recorded_by, $id)
    {
        $exportData = "";
        $database_name = "zoe_" . $year . "_budget";
        $input_list = array($category, $type, $amount, $details, $date, $year, $month, $recorded_by);
        $date = date("Y-m-d");
        $status = 'active';
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
            $stmt = $this->data_connect()->prepare("UPDATE `zoe_budget`.$database_name SET `category`=?,`type`=?,`amount`=?,`details`=?,`date`=?,`Year`=?,`month`=?,`recorded_by`=?  WHERE `unique_id` = ?");
            $stmt->bindParam('1', $category, \PDO::PARAM_STR);
            $stmt->bindParam('2', $type, \PDO::PARAM_STR);
            $stmt->bindParam('3', $amount, \PDO::PARAM_STR);
            $stmt->bindParam('4', $details, \PDO::PARAM_STR);
            $stmt->bindParam('5', $date, \PDO::PARAM_STR);
            $stmt->bindParam('6', $year, \PDO::PARAM_STR);
            $stmt->bindParam('7', $month, \PDO::PARAM_STR);
            $stmt->bindParam('8', $recorded_by, \PDO::PARAM_STR);
            $stmt->bindParam('9', $id, \PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;

                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            } else {
                $date = date('Y-m-d H:i:s');
                $namer = $_SESSION['unique_id'];
                $historySet = $this->history_set($namer, "Budget  Data Update", $date, "Budget  page dashboard Admin", "User Updated a Budget  data ");
                if (json_decode($historySet) != 'Success') {
                    $exportData = 'success';
                }
                $exportData = 'Update success';

            }
            return $exportData;

        }
    }

    protected function Budget_delete_user_data($year, $id)
    {
        $exportData = 0;
        $database_name = "zoe_" . $year . "_budget";
        $input_list = array($year);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.$database_name where `unique_id` ='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoe_budget`.$database_name where `unique_id`=?");
                    $stmt1->bindParam('1', $id, \PDO::PARAM_STR);
                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = 'deleting data encountered a problem';
                        exit($Error);
                    } else {

                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Budget  Data delete", $date, "Budget  page dashboard Admin", "User deleted a Budget  data ");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }

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

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }

        }
    }

    protected function Dues_user_update($name, $medium, $amount, $form_name, $user_date, $unique_id)
    {
        $input_list = array($name, $medium, $amount, $form_name, $user_date, $unique_id);
        $clean = true;
        date('UTC');
        $date = date("Y-m-d");
        $status = 'active';
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'Fetching data encountered a problem';
                $clean = false;
                exit(json_encode($Error));
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$form_name` where `user`='$unique_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = 'An Error Ocurred, data cannot be found ';
                $resultCheck = false;
                exit($exportData);
            } else {
                $stmt = $this->data_connect()->prepare("UPDATE  `zoedues`.`$form_name` SET `Amount`='$amount',`Date`='$user_date',`Medium`='$medium',`Record_date`='$date' WHERE `user`='$unique_id'");

                $stmt->bindParam('1', $amount, \PDO::PARAM_INT);
                $stmt->bindParam('2', $user_date, \PDO::PARAM_STR);
                $stmt->bindParam('3', $medium, \PDO::PARAM_STR);
                $stmt->bindParam('4', $date, \PDO::PARAM_STR);
                $stmt->bindParam('5', $unique_id, \PDO::PARAM_STR);

                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['unique_id'];
                    $historySet = $this->history_set($namer, "Dues  Data Update", $date, "Dues  page dashboard Admin", "User Updated a Dues  data ");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }

                    $exportData = 'Data entry was a success';
                    exit(json_encode($exportData));
                }



            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Dues_user_record($Name, $medium, $amount, $user_date, $unique_id)
    {
        $input_list = array($Name, $medium, $amount, $user_date, $unique_id);
        $clean = true;
        date('UTC');
        $date = date("Y-m-d");
        $status = 'active';
        $resultCheck = true;
        $exportData = "";
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'Fetching data encountered a problem';
                $clean = false;
                exit($Error);
            }
        }


        if ($clean) {

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` where `unique_id`='$unique_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $name = $result[0]['name'];
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$name` where `$unique_id`=? AND `Record_date`=? AND `user`=?");

                $stmt->bindParam('1', $unique_id, \PDO::PARAM_INT);
                $stmt->bindParam('2', $user_date, \PDO::PARAM_STR);
                $stmt->bindParam('3', $Name, \PDO::PARAM_STR);

                if (!$stmt->execute()) {

                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                }
                if ($stmt->rowCount() > 0) {
                    $exportData = 'Data Already exist';
                    $resultCheck = false;
                    exit(json_encode($exportData));
                } else {
                    // $userData = $this->Confirm_membership_Records($Name);
                    $stmt = $this->data_connect()->prepare("INSERT INTO  `zoedues`.`$name`( `$unique_id`, `user`, `Amount`, `Date`, `Medium`, `status`, `Record_date`) VALUES (?,?,?,?,?,?,?)");
                    $user_data = 'active pay';
                    $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                    $stmt->bindParam('2', $Name, \PDO::PARAM_STR);
                    $stmt->bindParam('3', $amount, \PDO::PARAM_INT);
                    $stmt->bindParam('4', $user_date, \PDO::PARAM_STR);
                    $stmt->bindParam('5', $medium, \PDO::PARAM_STR);
                    $stmt->bindParam('6', $user_data, \PDO::PARAM_STR);
                    $stmt->bindParam('7', $date, \PDO::PARAM_STR);
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encountered a problem';
                        exit(json_encode($Error));
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Dues  Data Update", $date, "Dues  page dashboard Admin", "User Updated a Dues  data ");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }
                        $exportData = 'Data entry was a success Page will refresh to display new data';
                        exit(json_encode($exportData));
                    }



                }

            } else {
                $exportData = "form is currently not  in session !! " . $unique_id;
                exit(json_encode($exportData));
            }
        }
    }
    protected function Dues_user_delete_data($form_name, $unique_id)
    {
        $exportData = 0;
        $input_list = array($form_name);
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

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$form_name` where `user` ='$unique_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = '-Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoedues`.`$form_name` where `user`=?");
                    $stmt1->bindParam('1', $unique_id, \PDO::PARAM_STR);
                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = 'deleting data encountered a problem';
                        exit($Error);
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Dues  Data delete", $date, "Dues  page dashboard Admin", "User deleted a Dues  data ");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }
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

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }

        }
    }

    protected function membership_Records()
    {
        $exportData = 0;
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users`");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->rowCount();
            $exportData = $result;
        } else {
            $resultCheck = false;
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function Confirm_membership_Records($name)
    {
        $splitName = explode(' ', $name);
        if (count($splitName) > 1) {
            $LastSplit = $splitName[0];
            $FirstSplit = $splitName[1];
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `Othername` like '%?%' AND `Firstname` like '%?%' ");
            $stmt->bindParam('1', $LastSplit, \PDO::PARAM_STR);
            $stmt->bindParam('2', $FirstSplit, \PDO::PARAM_STR);

            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit();
            }
            $id = rand(time(), 1000);
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                return $result[0]['unique_id'];
            } else {
                return $name;
            }
        } else {
            return $name;
        }


    }

    protected function Usernames()
    {
        $exportData = "";
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` ORDER BY `Othername` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ClassMain = new \stdClass();
            foreach ($result as $data) {
                $firstname = $data['Firstname'];
                $Othername = $data['Othername'];
                $unique_id = $data['unique_id'];
                $Class = new \stdClass();
                $Class->name = $firstname . ' ' . $Othername;
                $Class->id = $unique_id;
                $ClassMain->$unique_id = $Class;
            }
            $exportData = $ClassMain;
        } else {
            $resultCheck = false;
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function Transaction_list()
    {
        $exportData = 0;
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` ORDER BY `Date` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $account = $data['account'];
                $category = $data['category'];
                $amount = $data['Amount'];
                $Status = $data['Status'];
                $authorize = $data['authorize'];

                $exportData .= $account;

            }
        } else {
            $resultCheck = false;
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function Accounts_list()
    {
        $exportData = 0;
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_system` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $exportClass = new \stdClass();
            $Array = array();
            foreach ($result as $data) {
                $account = $data['account_name'];
                array_push($Array, $account);
            }
            $id = rand(1002, time());
            $exportClass->$id = $Array;
            $exportData = $exportClass;
        } else {
            $resultCheck = false;
        }

        if ($resultCheck) {
            return json_encode($exportData);
        } else {
            return $resultCheck;
        }
    }
    protected function Accounts_listCard()
    {
        $exportData = "";
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_system` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $id = rand(1123, time());
                $amount = $data['Total_amount'];
                $modified = $data['last_modified'];
                $name = $data['account_name'];
                $ExportSend = new \stdClass();
                $exportname = $id;
                $ExportSend->amount = $amount;
                $ExportSend->modified = $modified;
                $ExportSend->name = $name;

                $ExportSendMain->$exportname = $ExportSend;


            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $resultCheck = false;
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function Budget_data_list()
    {
        $resultCheck = true;
        $exportData = new \stdClass();
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`budget`  ORDER BY `id` DESC");
        if (!$stmt->execute()) {

            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $id = $data['id'];
                $Name = $data['Name'];
                $Date = $data['date'];
                $Object = [$Name, $Date];

                $exportData->Name = $Name;
                $exportData->Date = $Date;
                $exportData->$id = $Object;

            }
        } else {
            exit('No Data found');
        }

        return $exportData;



    }
    protected function Budget_list($year)
    {
        $exportData = new \stdClass();
        $resultCheck = true;
        $income_Class = new \stdClass();
        $Offertory_Class = new \stdClass();
        $tithe_Class = new \stdClass();
        $Ultilities_Class = new \stdClass();
        $Housing_Class = new \stdClass();
        $paycheck_Class = new \stdClass();
        $Others_Class = new \stdClass();
        $Other_income = 0;
        $offertory_income = 0;
        $tithe_income = 0;
        $Expenses_total = 0;

        $Other_income_details = array();
        $offertory_income_details = array();
        $tithe_income_details = array();
        $database_name = "zoe_" . $year . "_budget";



        $Months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        foreach ($Months as $month) {
            $indexData = array_search($month, $Months);
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name`  WHERE `category` like '%income%' AND `month`=$indexData+1 OR `category` like '%deposit%' AND `month`=$indexData+1 ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $Other_income = 0;
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $Other_income += intVal($amount);
                    array_push($Other_income_details, $data['date']);
                }
                $income_Class->$month = array($Other_income, $Other_income_details);
            } else {
                $income_Class->$month = array('0', array('not available'));
            }

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where  `year` = '$year' AND `month`=$indexData+1 ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $offertory_income = 0;
                foreach ($result as $data) {
                    $amount_o = $data['amount'];
                    $offertory_income += $amount_o;
                    array_push($offertory_income_details, $data['date']);
                }
                $Offertory_Class->$month = array($offertory_income, $offertory_income_details);
            } else {
                $Offertory_Class->$month = array("0", array('not available'));
            }
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where  `year` = '$year' AND `month`=$indexData+1 ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $tithe_income = 0;
                foreach ($result as $data) {
                    $amount_t = $data['amount'];
                    $tithe_income += $amount_t;
                    array_push($tithe_income_details, $data['Date']);

                }
                $tithe_Class->$month = array($tithe_income, $tithe_income_details);

            } else {
                $tithe_Class->$month = array("0", array('not available'));
            }

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name`  WHERE `category` like '%expenses%' and `type` like '%ultilities%' and `month`=$indexData+1  ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $Ultility_total = 0;
                $Ultility_total_details = array();
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $Ultility_total += intVal($amount);
                    array_push($Ultility_total_details, $data['date']);
                }
                $Ultilities_Class->$month = array($Ultility_total, $Ultility_total_details);
            } else {
                $Ultilities_Class->$month = array("0", array("not available"));
            }

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name`  WHERE `category` like '%expenses%' and `type` like '%housing%' and `month`=$indexData+1  ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $housing_total = 0;
                $housing_total_details = array();
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $housing_total += intVal($amount);
                    array_push($housing_total_details, $data['date']);
                }
                $Housing_Class->$month = array($housing_total, $housing_total_details);
            } else {
                $Housing_Class->$month = array("0", array("not available"));
            }

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name`  WHERE `category` like '%expenses%' and `type` like '%paycheck%' and `month`=$indexData+1  ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $paycheck_total = 0;
                $paycheck_total_details = array();
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $paycheck_total += intVal($amount);
                    array_push($paycheck_total_details, $data['date']);
                }
                $paycheck_Class->$month = array($paycheck_total, $paycheck_total_details);
            } else {
                $paycheck_Class->$month = array("0", array("not available"));
            }

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name`  WHERE `category` like '%expenses%' and `type` !='housing' and `type` !='ultilities' and `type` !='paycheck' and `month`=$indexData+1  ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $Others_total = 0;
                $Others_total_details = array();
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $Others_total += intVal($amount);
                    array_push($Others_total_details, $data['date']);
                }
                $Others_Class->$month = array($Others_total, $Others_total_details);
            } else {
                $Others_Class->$month = array("0", array("not available"));
            }

        }
        $IncomeMain = new \stdClass();
        $IncomeMain->income = $income_Class;
        $IncomeMain->offertory = $Offertory_Class;
        $IncomeMain->tithe = $tithe_Class;

        $ExpensesMain = new \stdClass();
        $ExpensesMain->Ultilities = $Ultilities_Class;
        $ExpensesMain->Housing = $Housing_Class;
        $ExpensesMain->paycheck = $paycheck_Class;
        $ExpensesMain->Others = $Others_Class;

        $exportData->INCOME = $IncomeMain;
        $exportData->EXPENSES = $ExpensesMain;

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function Budget_Delete($year, $id)
    {
        $exportData = 0;
        $resultCheck = true;
        $database_name = "zoe_" . $year . "_budget";
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name`  WHERE `id`='$id'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoe_budget`.`$database_name`  WHERE `id`=?");
            $stmt->bindParam('1', $id, \PDO::PARAM_STR);
            if (!$stmt1->execute()) {
                $stmt1 = null;
                $Error = 'deleting data encountered a problem';
                exit($Error);
            } else {
                $date = date('Y-m-d H:i:s');
                $namer = $_SESSION['unique_id'];
                $historySet = $this->history_set($namer, "Budget  Data Update", $date, "Budget  page dashboard Admin", "User Updated a Dues  data $database_name");
                if (json_decode($historySet) != 'Success') {
                    $exportData = 'success';
                }

                $resultCheck = true;
                $exportData = 'Item Deleted Successfully';
            }
        }


        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }



    }

    public function Budget_list_category_filter($year, $category)
    {
        $exportData = new \stdClass();
        $resultCheck = true;

        $Other_income = 0;
        $database_name = "zoe_" . $year . "_budget";

        $Months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        foreach ($Months as $month) {
            $indexData = array_search($month, $Months);
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name`  WHERE `type` like '%$category%' AND `month`=$indexData+1 ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                foreach ($result as $data) {
                    $Data = new \stdClass();
                    $category = $data['category'];
                    $type = $data['type'];
                    $details = $data['details'];
                    $date = $data['date'];
                    $year = $data['year'];
                    $month = $data['month'];
                    $recorded_by = $data['recorded_by'];
                    $id = "zoe_id" . $data['id'];

                    $Data->category = $category;
                    $Data->type = $type;
                    $Data->details = $details;
                    $Data->date = $date;
                    $Data->year = $year;
                    $Data->month = $month;
                    $Data->recorded_by = $recorded_by;

                    $exportData->$id = $Data;
                }
            }



        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    public function Budget_list_category()
    {
        $year = date('UTC');
        $year = date('Y');
        $exportData = "";
        $resultCheck = true;

        $Other_income = 0;
        $database_name = "zoe_" . $year . "_budget";
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name` ORDER BY `id` DESC");
        if (!$stmt->execute()) {

            $stmt = null;

            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $Data = new \stdClass();
                $ExportSend = new \stdClass();
                $category = $data['category'];
                $type = $data['type'];
                $details = $data['details'];
                $date = $data['date'];
                $year = $data['Year'];
                $month = $data['month'];
                $recorded_by = $data['recorded_by'];
                $amount = $data['amount'];
                $id = "zoe_id" . $data['id'];
                $unique_id = $data['unique_id'];

                $Data->category = $category;
                $Data->type = $type;
                $Data->details = $details;
                $Data->date = $date;
                $Data->year = $year;
                $Data->month = $month;
                $Data->amount = $amount;
                $Data->recorded_by = $recorded_by;
                $Data->id = $unique_id;
                $ObjExport = json_encode($Data);

                $ExportSend->category = $category;
                $ExportSend->type = $type;
                $ExportSend->details = $details;
                $ExportSend->date = $date;
                $ExportSend->year = $year;
                $ExportSend->month = $month;
                $ExportSend->amount = $amount;
                $ExportSend->recorded_by = $recorded_by;
                $ExportSend->id = $unique_id;
                $ExportSend->obj = $ObjExport;
                $exportname = $id;
                $ExportSendMain->$exportname = $ExportSend;
            }
        } else {
            $ExportSendMain = "No Records Available";
        }
        $exportData = json_encode($ExportSendMain);

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function Budget_list_category_export()
    {
        $year = date('UTC');
        $year = date('Y');
        $exportData = "";
        $resultCheck = true;

        $Other_income = 0;
        $database_name = "zoe_" . $year . "_budget";
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $Data = new \stdClass();
                $ExportSend = new \stdClass();
                $category = $data['category'];
                $type = $data['type'];
                $details = $data['details'];
                $date = $data['date'];
                $year = $data['Year'];
                $month = $data['month'];
                $recorded_by = $data['recorded_by'];
                $amount = $data['amount'];
                $id = "zoe_id" . $data['id'];
                $unique_id = $data['unique_id'];

                $ExportSend->category = $category;
                $ExportSend->type = $type;
                $ExportSend->details = $details;
                $ExportSend->date = $date;
                $ExportSend->year = $year;
                $ExportSend->month = $month;
                $ExportSend->amount = $amount;
                $ExportSend->recorded_by = $recorded_by;
                $ExportSend->id = $unique_id;
                $exportname = rand(time(), $unique_id);
                $ExportSendMain->$exportname = $ExportSend;
            }
        } else {
            exit(json_encode("no record found"));
        }
        $exportData = json_encode($ExportSendMain);

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function Budget_list_category_pages()
    {
        $year = date('UTC');
        $year = date('Y');

        $database_name = "zoe_" . $year . "_budget";
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name` ORDER BY `id` DESC");
        if (!$stmt->execute()) {

            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        return $stmt->rowCount();

    }
    public function Budget_list_categoryFilter($year, $category, $nk)
    {
        $exportData = "";
        $resultCheck = true;

        $Other_income = 0;
        $database_name = "zoe_" . $year . "_budget";
        if ($nk == 0) {
            $nk = 1;
        }
        $num = 40 * ($nk - 1);
        $total_pages = 0;
        $stmt_pages = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name` where `category` like '%$category%' ORDER BY `id` DESC limit 25");
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name` where `category` like '%$category%' ORDER BY `id` DESC limit 40 OFFSET $num");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        $ExportSendMain = new \stdClass();
        if ($stmt->rowCount() > 0) {
            if ($stmt_pages->execute()) {
                $total_pages = $stmt_pages->rowCount();
            }
            $result = $stmt->fetchAll();

            foreach ($result as $data) {
                $Data = new \stdClass();
                $ExportSend = new \stdClass();
                $category = $this->validate($data['category']);
                $type = $this->validate($data['type']);
                $details = $this->validate($data['details']);
                $date = $this->validate($data['date']);
                $year = $this->validate($data['Year']);
                $month = $this->validate($data['month']);
                $recorded_by = $this->validate($data['recorded_by']);
                $amount = $this->validate($data['amount']);
                $id = "zoe_id" . $this->validate($data['id']);
                $unique_id = $this->validate($data['unique_id']);

                $Data->category = $category;
                $Data->type = $type;
                $Data->details = $details;
                $Data->date = $date;
                $Data->year = $year;
                $Data->month = $month;
                $Data->amount = $amount;
                $Data->recorded_by = $recorded_by;
                $Data->id = $unique_id;
                $ObjExport = json_encode($Data);

                $ExportSend->category = $category;
                $ExportSend->type = $type;
                $ExportSend->details = $details;
                $ExportSend->date = $date;
                $ExportSend->year = $year;
                $ExportSend->month = $month;
                $ExportSend->amount = $amount;
                $ExportSend->recorded_by = $recorded_by;
                $ExportSend->id = $unique_id;
                $ExportSend->obj = $ObjExport;
                $exportname = $id;
                $ExportSendMain->$exportname = $ExportSend;
            }
        } else {
            exit(json_encode("no record found"));
        }
        $MainExport = new \stdClass();
        $MainExport->pages = $total_pages;
        $MainExport->result = $ExportSendMain;
        $exportData = json_encode($MainExport);

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function Budget_list_filter($year)
    {
        $exportData = new \stdClass();
        $resultCheck = true;
        $Grand_Other_income = new \stdClass();
        $Grand_offertory_income = new \stdClass();
        $Grand_tithe_income = new \stdClass();
        $Grand_Expenses_total = new \stdClass();

        $Other_income = 0;
        $offertory_income = 0;
        $tithe_income = 0;
        $Expenses_total = 0;

        $database_name = "zoe_" . $year . "_budget";



        $Months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        foreach ($Months as $month) {
            $indexData = array_search($month, $Months);
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name`  WHERE `type` like '%income%' AND `month`=$indexData+1 ORDER BY `id` DESC");
            if (!$stmt->execute()) {

                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $Other_income += intVal($amount);

                }
            }

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where  `year` = '$year' AND `month`='$month' ORDER BY `id` DESC");
            if (!$stmt->execute()) {

                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                foreach ($result as $data) {
                    $amount_o = $data['amount'];
                    $offertory_income += $amount_o;
                }
            }
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where  `year` = '$year' AND `month`='$month' ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                foreach ($result as $data) {
                    $amount_t = $data['amount'];
                    $tithe_income += $amount_t;
                }
            }
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name`  WHERE `type` like '%Expenses%' and `month`=$indexData+1 ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $Expenses_total += intVal($amount);

                }
            }
            $Grand_Other_income->$month = $Other_income;
            $Grand_offertory_income->$month = $offertory_income;
            $Grand_tithe_income->$month = $tithe_income;
            $Grand_Expenses_total->$month = $Expenses_total;

            $Other_income = 0;
            $offertory_income = 0;
            $tithe_income = 0;
            $Expenses_total = 0;

        }
        $exportData->Otherincome = $Grand_Other_income;
        $exportData->Tithe = $Grand_tithe_income;
        $exportData->Expenses = $Grand_Expenses_total;
        $exportData->Offertory = $Grand_offertory_income;

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    public function Pay_list_info_update($id)
    {

        $newDate = date('l j \of F Y h:i:s A');
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` where `unique_id`='$id'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            return $Error;
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $name = $result[0]['name'];

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$name`");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encounted a problem');
                return $Error;
            }
            if ($stmt->rowCount() > 0) {
                $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`dues` set `date`= '$newDate' where `unique_id`='$id'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    return $Error;
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['unique_id'];
                    $historySet = $this->history_set($namer, "Payment List  Data Update", $date, "Payment List  page dashboard Admin", "User Updated a Dues  data $name");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }

                    return json_encode('updated');
                }


            } else {
                return json_encode('Not Records Available');
            }

        } else {
            return json_encode('Not Records Available');
        }
    }

    public function Pay_list_Info($id)
    {
        $exportData = "";
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` where `unique_id`='$id'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $name = $result[0]['name'];

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$name`");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $ExportSendMain = new \stdClass();
                foreach ($result as $data) {
                    $namer = $data['user'];
                    $Medium = $data['Medium'];
                    $Record_date = $data['Record_date'];
                    $amount = $data['Amount'];
                    $id = $data['user'];

                    $ExportSend = new \stdClass();

                    $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$namer'");
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encounted a problem';
                        exit(json_encode($Error));
                    }
                    $Name = $namer;
                    $gender = "Guest";
                    $contact = "Guest";

                    if ($stmt->rowCount() > 0) {
                        $row2 = $stmt->fetchAll();
                        foreach ($row2 as $value) {
                            $Name = $value['Firstname'] . ' ' . $value['Othername'];
                            $gender = $value['gender'];
                            $contact = $value['contact'];
                        }
                    }
                    $ObjectInfo = new \stdClass();
                    $ObjectInfo->Formname = $name;
                    $ObjectInfo->Medium = $Medium;
                    $ObjectInfo->name = $Name;
                    $ObjectInfo->amount = $amount;
                    $ObjectInfo->date = $Record_date;
                    $ObjectInfo->id = $id;
                    $ObjectData = json_encode($ObjectInfo);

                    $ExportSend->amount = $this->validate($amount);
                    $ExportSend->name = $this->validate($Name);
                    $ExportSend->gender = $this->validate($gender);
                    $ExportSend->contact = $this->validate($contact);
                    $ExportSend->medium = $this->validate($Medium);
                    $ExportSend->record_date = $this->validate($Record_date);
                    $ExportSend->UniqueId = $id;
                    $ExportSend->Obj = $ObjectData;
                    $ExportSend->Uname = $name;

                    $exportname = $id . $amount;
                    $ExportSendMain->$exportname = $ExportSend;
                }
                $resultCheck = True;
                $exportData = json_encode($ExportSendMain);

            } else {
                exit(json_encode('Not Records Available'));
            }

        } else {
            exit(json_encode('Not Records Available'));
        }
        return $exportData;

    }

    public function Pay_list_InfoSearch($id, $searchname)
    {
        $exportData = "";
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` where `unique_id`='$id'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $name = $result[0]['name'];

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$name`  ");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $ExportSendMain = new \stdClass();
                foreach ($result as $data) {
                    $namer = $data['user'];
                    $Medium = $data['Medium'];
                    $Record_date = $data['Record_date'];
                    $amount = $data['Amount'];
                    $id = $data['user'];

                    $ExportSend = new \stdClass();

                    $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `Firstname` like '%$searchname%' and `unique_id`='$namer' or `Othername` like '%$searchname%' and `unique_id`='$namer'");
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encounted a problem';
                        exit($Error);
                    }
                    $Name = $namer;
                    $gender = "Guest";
                    $contact = "Guest";

                    if ($stmt->rowCount() > 0) {
                        $row2 = $stmt->fetchAll();
                        foreach ($row2 as $value) {
                            $Name = $value['Firstname'] . '  ' . $value['Othername'];
                            $gender = $value['gender'];
                            $contact = $value['contact'];


                            $ObjectInfo = new \stdClass();
                            $ObjectInfo->Formname = $name;
                            $ObjectInfo->Medium = $Medium;
                            $ObjectInfo->name = $Name;
                            $ObjectInfo->amount = $amount;
                            $ObjectInfo->date = $Record_date;
                            $ObjectInfo->id = $id;
                            $ObjectData = json_encode($ObjectInfo);

                            $ExportSend->amount = $amount;
                            $ExportSend->name = $Name;
                            $ExportSend->gender = $gender;
                            $ExportSend->contact = $contact;
                            $ExportSend->medium = $Medium;
                            $ExportSend->record_date = $Record_date;
                            $ExportSend->UniqueId = $id;
                            $ExportSend->Obj = $ObjectData;
                            $ExportSend->Uname = $name;

                            $exportname = $id . $amount;
                            $ExportSendMain->$exportname = $ExportSend;

                        }
                    }
                }
                $resultCheck = True;
                $exportData = json_encode($ExportSendMain);

            } else {
                exit('Not Records Available');
            }

        } else {
            exit('Not Records Available');
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function list_Info_Dues($num)
    {
        $exportData = '';
        $resultCheck = true;
        if ($num == 0) {
            $num = 1;
        }
        $nk = ($num - 1) * 40;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` ORDER BY `id` DESC limit 40");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` ORDER BY `id` DESC limit 40 OFFSET $nk");
        }

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['name']);
                $amount = $this->validate($data['amount']);
                $date = $this->validate($data['due_date']);
                $date_data = $this->validate($data['date']);
                $id = $this->validate($data['unique_id']);
                $purpose = $this->validate($data['purpose']);
                $department = $this->validate($data['department']);

                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $ObjectInfo->name = $name;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->date = $date;
                $ObjectInfo->purpose = $purpose;
                $ObjectInfo->department = $department;
                $ObjectInfo->id = $id;
                $ObjectData = json_encode($ObjectInfo);

                $ExportSend->amount = $amount;
                $ExportSend->name = $name;
                $ExportSend->date = $date;
                $ExportSend->date_data = $date_data;
                $ExportSend->purpose = $purpose;
                $ExportSend->department = $department;
                $ExportSend->UniqueId = $id;
                $ExportSend->Obj = $ObjectData;
                $exportname = $id . $amount;

                $ExportSendMain->$exportname = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            echo "here";
            $exportData = 'No Records Available';
        }
        return $exportData;
    }
    public function list_Info_Offertory_liveUpdate($num)
    {
        $exportData = '';
        $resultCheck = true;
        if (empty($num)) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records`  ORDER BY `id` DESC limit  1");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `unique_id`='$num' ORDER BY `id` DESC limit  1");
        }
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['event']);
                $amount = $this->validate($data['amount']);
                $date = $this->validate($data['date']);
                $Month = $this->validate($data['month']);
                $purpose = $this->validate($data['purpose']);
                $id = $this->validate($data['unique_id']);
                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $ObjectInfo->name = $name;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->date = $date;
                $ObjectInfo->purpose = $purpose;
                $ObjectInfo->Unique_id = $id;
                $ObjectData = json_encode($ObjectInfo);

                $ExportSend->name = $name;
                $ExportSend->amount = $amount;
                $ExportSend->date = $date;
                $ExportSend->date_data = "ks";
                $ExportSend->purpose = $purpose;
                $ExportSend->department = "church";
                $ExportSend->UniqueId = $id;
                $ExportSend->Month = $Month;
                $ExportSend->Obj = $ObjectData;
                $exportname = $id;
                $ExportSendMain->$exportname = $ExportSend;



            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'Not Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function Transaction_liveUpdate($num)
    {
        $exportData = '';
        $resultCheck = true;
        if (empty($num)) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records`  ORDER BY `id` DESC limit  1");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` where `unique_id`='$num' ORDER BY `id` DESC limit  1");
        }
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $account = $data['account'];
                $amount = $data['Amount'];
                $date = $data['Date'];
                $id = $data['unique_id'];
                $Status = $data['Status'];
                $category = $data['Category'];
                $Authorize = $data['Authorize'];

                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $ObjectInfo->account = $account;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->Date = $date;
                $ObjectInfo->category = $category;
                $ObjectInfo->Authorize = $Authorize;
                $ObjectInfo->Status = $Status;
                $ObjectInfo->id = $id;
                $ObjectData = json_encode($ObjectInfo);

                $ExportSend->account = $account;
                $ExportSend->amount = $amount;
                $ExportSend->Date = $date;
                $ExportSend->category = $category;
                $ExportSend->Authorize = $Authorize;
                $ExportSend->Status = $Status;
                $ExportSend->id = $id;
                $ExportSend->obj = $ObjectData;
                $exportname = $id . $amount;
                $ExportSendMain->$exportname = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            exit(json_encode('Not Records Available'));
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    public function list_Info_Dues_liveUpdate($num)
    {
        $exportData = '';
        $resultCheck = true;
        if (empty($num)) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` ORDER BY `id` DESC limit 1");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` Where `unique_id`='$num' ORDER BY `id` DESC limit 1");
        }

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['name']);
                $amount = $this->validate($data['amount']);
                $date = $this->validate($data['due_date']);
                $date_data = $this->validate($data['date']);
                $id = $this->validate($data['unique_id']);
                $purpose = $this->validate($data['purpose']);
                $department = $this->validate($data['department']);

                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $ObjectInfo->name = $name;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->date = $date;
                $ObjectInfo->purpose = $purpose;
                $ObjectInfo->department = $department;
                $ObjectInfo->id = $id;
                $ObjectData = json_encode($ObjectInfo);

                $ExportSend->amount = $amount;
                $ExportSend->name = $name;
                $ExportSend->date = $date;
                $ExportSend->date_data = $date_data;
                $ExportSend->purpose = $purpose;
                $ExportSend->department = $department;
                $ExportSend->UniqueId = $id;
                $ExportSend->Obj = $ObjectData;
                $exportname = $id . $amount;

                $ExportSendMain->$exportname = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'Not Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function Expenses_liveUpdate($num)
    {
        $exportData = '';
        $year = date('Y');
        $database_name = "zoe_" . $year . "_budget";
        if (empty($num)) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name` ORDER BY `id`  DESC limit 1");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name` where `unique_id`='$num' ORDER BY `id` DESC limit 1");
            ;
        }

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $Data = new \stdClass();
                $ExportSend = new \stdClass();
                $category = $data['category'];
                $type = $data['type'];
                $details = $data['details'];
                $date = $data['date'];
                $year = $data['Year'];
                $month = $data['month'];
                $recorded_by = $data['recorded_by'];
                $amount = $data['amount'];
                $id = "zoe_id" . $data['id'];
                $unique_id = $data['unique_id'];

                $Data->category = $category;
                $Data->type = $type;
                $Data->details = $details;
                $Data->date = $date;
                $Data->year = $year;
                $Data->month = $month;
                $Data->amount = $amount;
                $Data->recorded_by = $recorded_by;
                $Data->id = $unique_id;
                $ObjExport = json_encode($Data);

                $ExportSend->category = $category;
                $ExportSend->type = $type;
                $ExportSend->details = $details;
                $ExportSend->date = $date;
                $ExportSend->year = $year;
                $ExportSend->month = $month;
                $ExportSend->amount = $amount;
                $ExportSend->recorded_by = $recorded_by;
                $ExportSend->id = $unique_id;
                $ExportSend->obj = $ObjExport;
                $exportname = $id;
                $ExportSendMain->$exportname = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            exit(json_encode('No Records Available'));
        }

        return $exportData;
    }
    public function Tithe_liveUpdate($num)
    {
        $exportData = '';
        $year = date('Y');
        if (empty($num)) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` ORDER BY `id`  DESC limit 1");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `unique_id`='$num' ORDER BY `id` DESC limit 1");
        }

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $namer = $data['unique_id'];
                $name = $data['name'];
                $amount = $data['amount'];
                $medium = $data['Medium_payment'];
                $Date = $data['Date'];
                $detais = $data['description'];

                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$namer'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit($Error);
                }
                $Name = '-';
                $gender = "Guest";
                $contact = "Guest";
                $Email = "-";
                if ($stmt->rowCount() > 0) {
                    $row2 = $stmt->fetchAll();
                    foreach ($row2 as $value) {
                        $Name = $value['Firstname'] . '  ' . $value['Othername'];
                        $gender = $value['gender'];
                        $contact = $value['contact'];
                        $Email = $value['email'];
                    }
                }

                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $ObjectInfo->Name = $namer;
                $ObjectInfo->Amount = $amount;
                $ObjectInfo->Date = $Date;
                $ObjectInfo->id = $namer;
                $ObjectInfo->medium = $medium;
                $ObjectInfo->details = $detais;
                $ObjectData = json_encode($ObjectInfo);
                $exportname = $namer;

                $ExportSend->Name = $namer;
                $ExportSend->Amount = $amount;
                $ExportSend->Date = $Date;
                $ExportSend->id = $namer;
                $ExportSend->medium = $medium;
                $ExportSend->details = $detais;
                $ExportSend->gender = $gender;
                $ExportSend->contact = $contact;
                $ExportSend->Email = $Email;
                $ExportSend->Obj = $ObjectData;
                $ExportSendMain->$exportname = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            exit(json_encode('No Records Available'));
        }

        return $exportData;
    }

    public function listSearch_Info_Dues($key, $nk)
    {
        $searchTerm = $this->validate($key);
        $exportData = '';
        $resultCheck = true;
        $num = 40 * ($nk - 1);
        $total_pages = 0;
        $stmt_pages = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` WHERE `name` like '%$searchTerm%' ORDER BY `id` DESC limit 40 ");
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` WHERE `name` like '%$searchTerm%' ORDER BY `id` DESC limit 40 OFFSET $num");
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            if ($stmt_pages->execute()) {
                $total_pages = $stmt_pages->rowCount();
            }
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['name']);
                $amount = $this->validate($data['amount']);
                $date = $this->validate($data['due_date']);
                $date_data = $this->validate($data['date']);
                $id = $this->validate($data['unique_id']);
                $purpose = $this->validate($data['purpose']);
                $department = $this->validate($data['department']);

                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $ObjectInfo->name = $name;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->date = $date;
                $ObjectInfo->purpose = $purpose;
                $ObjectInfo->department = $department;
                $ObjectInfo->id = $id;
                $ObjectData = json_encode($ObjectInfo);

                $ExportSend->amount = $amount;
                $ExportSend->name = $name;
                $ExportSend->date = $date;
                $ExportSend->date_data = $date_data;
                $ExportSend->purpose = $purpose;
                $ExportSend->department = $department;
                $ExportSend->UniqueId = $id;
                $ExportSend->Obj = $ObjectData;
                $exportname = $id . $amount;

                $ExportSendMain->$exportname = $ExportSend;
            }
            $MainExport = new \stdClass();
            $MainExport->pages = $total_pages;
            $MainExport->result = $ExportSendMain;
            $exportData = json_encode($MainExport);
        } else {
            $exportData = 'No Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function listSearch_Info_Offertory($key)
    {
        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `year` = $key ORDER BY `year`,`month` ");
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['event']);
                $amount = $this->validate($data['amount']);
                $date = $this->validate($data['date']);
                $date_data = $this->validate($data['date']);
                $id = $this->validate($data['unique_id']);
                $purpose = $this->validate($data['purpose']);
                $Month = $this->validate($data['month']);
                $department = $this->validate($data['year']);

                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $ObjectInfo->name = $name;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->date = $date;
                $ObjectInfo->purpose = $purpose;
                $ObjectInfo->department = $department;
                $ObjectInfo->id = $id;

                $ObjectData = json_encode($ObjectInfo);

                $ExportSend->amount = $amount;
                $ExportSend->name = $name;
                $ExportSend->date = $date;
                $ExportSend->date_data = $date_data;
                $ExportSend->purpose = $purpose;
                $ExportSend->department = $department;
                $ExportSend->Month = $Month;
                $ExportSend->UniqueId = $id;
                $ExportSend->Obj = $ObjectData;
                $exportname = $id . $amount;

                $ExportSendMain->$exportname = $ExportSend;
            }
            $exportData = $ExportSendMain;
        } else {
            $exportData = 'No Records Available';
        }

        return $exportData;

    }

    protected function Dues_pages()
    {
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }

        if ($stmt->rowCount() > 0) {
            $count = $stmt->rowCount();
            return $count;

        } else {
            return json_encode('Error');
        }

    }
    protected function Offertory_pages()
    {
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }

        if ($stmt->rowCount() > 0) {
            $count = $stmt->rowCount();
            return $count;

        } else {
            return json_encode('Error');
        }

    }

    protected function Transaction_pages()
    {
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $count = $stmt->rowCount();
            return $count;

        } else {
            return 0;
        }

    }
    protected function TransactionListData($num)
    {
        $exportData = false;
        $resultCheck = "";
        if ($num == 0) {
            $num = 1;
        }
        $nk = ($num - 1) * 40;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` ORDER BY `id` DESC limit 40");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` ORDER BY `id` DESC limit 40 OFFSET $nk");
        }
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit(json_encode($Error));
        }

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $account = $data['account'];
                $amount = $data['Amount'];
                $date = $data['Date'];
                $id = $data['unique_id'];
                $Status = $data['Status'];
                $category = $data['Category'];
                $Authorize = $data['Authorize'];

                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $ObjectInfo->account = $account;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->Date = $date;
                $ObjectInfo->category = $category;
                $ObjectInfo->Authorize = $Authorize;
                $ObjectInfo->Status = $Status;
                $ObjectInfo->id = $id;
                $ObjectData = json_encode($ObjectInfo);

                $ExportSend->account = $account;
                $ExportSend->amount = $amount;
                $ExportSend->Date = $date;
                $ExportSend->category = $category;
                $ExportSend->Authorize = $Authorize;
                $ExportSend->Status = $Status;
                $ExportSend->id = $id;
                $ExportSend->obj = $ObjectData;
                $exportname = $id . $amount;
                $ExportSendMain->$exportname = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'No Records Available';
        }


        if ($exportData) {
            return $exportData;
        } else {
            return false;
        }
    }

    protected function AccountListPages()
    {
        $exportData = false;
        $resultCheck = "";
        $total = 0;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_system` ORDER BY `id` DESC ");

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $item) {
                $account = $item['account_name'];

                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeaccounts`.`$account` ORDER BY `id`");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = json_encode('Fetching data encounted a problem');
                    exit($Error);
                }
                $total += $stmt->rowCount();

            }
        }
        $exportData = $total;

        return $exportData;
    }
    protected function AccountListData($num)
    {
        $exportData = new \stdClass();
        $resultCheck = "";
        $dateArray = array();
        $ObjectArray = array();

        $AccountList = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_system` ORDER BY `id`");
        if (!$AccountList->execute()) {
            $AccountList = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        $number = $AccountList->rowCount();

        if ($num == 0) {
            $num = 1;
        }
        $cut_strap = 0;
        if ($num == "1") {
            $TruncNum = abs(ceil((40 / $number)));
            $cut_strap = 0;
        } else {
            $TruncNum = abs(ceil(((40 * $num) / $number)));
            $cut_strap = $TruncNum - abs(ceil((40 / $number)));
        }
        if ($AccountList->rowCount() > 0) {
            $result = $AccountList->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $account = $data['account_name'];

                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeaccounts`.`$account` ORDER BY `id` DESC limit $TruncNum OFFSET $cut_strap");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = json_encode('Fetching data encounted a problem');
                    exit($Error);
                }

                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetchAll();
                    foreach ($result as $data) {
                        $description = $data['description'];
                        $amount = $data['amount'];
                        $balance = $data['balance'];
                        $id = $data['unique_id'];
                        $percentage = $data['percentage'];
                        $category = $data['category'];
                        $date = $data['date'];

                        $ExportSend = new \stdClass();
                        $ExportSend->description = $description;
                        $ExportSend->amount = $amount;
                        $ExportSend->balance = $balance;
                        $ExportSend->percentage = $percentage;
                        $ExportSend->category = $category;
                        $ExportSend->date = $date;
                        $ExportSend->account = $account;
                        $exportname = $id;
                        $ExportSendMain->$exportname = $ExportSend;

                        array_push($dateArray, strtotime($date));
                        array_push($ObjectArray, $ExportSend);

                    }
                    $SortedObj = $this->SortObjectData($dateArray, $ObjectArray);
                    $exportData = $SortedObj;
                }
            }

        }

        if (!count(get_object_vars($exportData)) > 0) {
            $exportData = "No Records Avialable";
        } else {
            $exportData = json_encode($exportData);
        }

        if ($exportData != "") {
            return $exportData;
        } else {
            return false;
        }
    }

    public function list_Info($num)
    {
        $year = date('Y');
        $exportData = '';
        if ($num == 0) {
            $num = 1;
        }
        $nk = ($num - 1) * 40;
        $resultCheck = true;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `year` = $year ORDER BY `year`,`month` limit 40 ");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `year` = $year ORDER BY `year`,`month` limit 40 OFFSET $nk");
        }
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['event']);
                $amount = $this->validate($data['amount']);
                $date = $this->validate($data['date']);
                $Month = $this->validate($data['month']);
                $purpose = $this->validate($data['purpose']);
                $id = $this->validate($data['unique_id']);
                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $ObjectInfo->name = $name;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->date = $date;
                $ObjectInfo->purpose = $purpose;
                $ObjectInfo->id = $id;
                $ObjectData = json_encode($ObjectInfo);

                $ExportSend->name = $name;
                $ExportSend->amount = $amount;
                $ExportSend->date = $date;
                $ExportSend->purpose = $purpose;
                $ExportSend->id = $id;
                $ExportSend->Month = $Month;
                $ExportSend->obj = $ObjectData;
                $exportname = $id;
                $ExportSendMain->$exportname = $ExportSend;

            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'Not Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function list_Info_pages()
    {
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }

        if ($stmt->rowCount() > 0) {
            $count = $stmt->rowCount();
            return $count;

        } else {
            return json_encode('Error');
        }

    }
    protected function list_tithe_pages()
    {
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }

        if ($stmt->rowCount() > 0) {
            $count = $stmt->rowCount();
            return $count;

        } else {
            return json_encode('Error');
        }

    }


    public function list_Info_tithe($num, $year)
    {
        $exportData = '';
        $resultCheck = true;
        $lim = 40 * $num;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `year`='$year' ORDER BY `id` DESC limit 25");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `year`='$year' ORDER BY `id` DESC limit 40 OFFSET $lim");
        }

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $namer = $data['unique_id'];
                $name = $data['name'];
                $amount = $data['amount'];
                $medium = $data['Medium_payment'];
                $Date = $data['Date'];
                $detais = $data['description'];

                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$namer'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit($Error);
                }
                $Name = '-';
                $gender = "Guest";
                $contact = "Guest";
                $Email = "-";
                if ($stmt->rowCount() > 0) {
                    $row2 = $stmt->fetchAll();
                    foreach ($row2 as $value) {
                        $Name = $value['Firstname'] . '  ' . $value['Othername'];
                        $gender = $value['gender'];
                        $contact = $value['contact'];
                        $Email = $value['email'];
                    }
                }

                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $ObjectInfo->Name = $namer;
                $ObjectInfo->Amount = $amount;
                $ObjectInfo->Date = $Date;
                $ObjectInfo->id = $namer;
                $ObjectInfo->medium = $medium;
                $ObjectInfo->details = $detais;
                $ObjectData = json_encode($ObjectInfo);
                $exportname = $namer;

                $ExportSend->Name = $namer;
                $ExportSend->Amount = $amount;
                $ExportSend->Date = $Date;
                $ExportSend->id = $namer;
                $ExportSend->medium = $medium;
                $ExportSend->details = $detais;
                $ExportSend->gender = $gender;
                $ExportSend->contact = $contact;
                $ExportSend->Email = $Email;
                $ExportSend->Obj = $ObjectData;
                $ExportSendMain->$exportname = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $resultCheck = false;
            $exportData = 'Not Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function list_Info_tithe_Export()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` ORDER BY `id` DESC");


        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            $date = date('Y-m-d H:i:s');
            $namer = $_SESSION['unique_id'];
            $historySet = $this->history_set($namer, "Payment List  Data Export", $date, "Payment List  page dashboard Admin", "User Exported tithe  data");
            if (json_decode($historySet) != 'Success') {
                $exportData = 'success';
            }

            foreach ($result as $data) {
                $namer = $data['unique_id'];
                $name = $data['name'];
                $amount = $data['amount'];
                $medium = $data['Medium_payment'];
                $Date = $data['Date'];
                $detais = $data['description'];

                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$namer'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit($Error);
                }
                $Name = '-';
                $gender = "Guest";
                $contact = "Guest";
                $Email = "-";
                $ExportSend = new \stdClass();
                if ($stmt->rowCount() > 0) {
                    $row2 = $stmt->fetchAll();
                    foreach ($row2 as $value) {
                        $Name = $value['Firstname'] . '  ' . $value['Othername'];
                        $gender = $value['gender'];
                        $contact = $value['contact'];
                        $Email = $value['email'];
                    }
                }
                $exportname = $namer;

                $ExportSend->Name = $Name;
                $ExportSend->Amount = $amount;
                $ExportSend->Date = $Date;
                $ExportSend->medium = $medium;
                $ExportSend->details = $detais;
                $ExportSend->gender = $gender;
                $ExportSend->contact = $contact;
                $ExportSend->Email = $Email;
                $ExportSendMain->$exportname = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $resultCheck = false;
            $exportData = 'Not Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function list_search_tithe($name, $nk)
    {
        $exportData = '';
        $resultCheck = true;
        $num = 40 * ($nk - 1);
        $total_pages = 0;
        $stmt_pages = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `name` like '%$name%' ORDER BY `date` DESC limit 25");
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `name` like '%$name%' ORDER BY `date` DESC limit 40 OFFSET $num");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            if ($stmt_pages->execute()) {
                $total_pages = $stmt_pages->rowCount();
            }
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $namer = $data['unique_id'];
                $name = $data['name'];
                $amount = $data['amount'];
                $medium = $data['Medium_payment'];
                $Date = $data['Date'];
                $detais = $data['description'];

                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$namer'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit($Error);
                }
                $Name = '-';
                $gender = "Guest";
                $contact = "Guest";
                $Email = "-";
                if ($stmt->rowCount() > 0) {
                    $row2 = $stmt->fetchAll();
                    foreach ($row2 as $value) {
                        $Name = $value['Firstname'] . '  ' . $value['Othername'];
                        $gender = $value['gender'];
                        $contact = $value['contact'];
                        $Email = $value['email'];
                    }
                }

                $ObjectInfo = new \stdClass();
                $ExportSend = new \stdClass();
                $ObjectInfo->Name = $namer;
                $ObjectInfo->Amount = $amount;
                $ObjectInfo->Date = $Date;
                $ObjectInfo->id = $namer;
                $ObjectInfo->medium = $medium;
                $ObjectInfo->details = $detais;
                $ObjectData = json_encode($ObjectInfo);
                $exportname = $namer;

                $ExportSend->Name = $namer;
                $ExportSend->Amount = $amount;
                $ExportSend->Date = $Date;
                $ExportSend->id = $namer;
                $ExportSend->medium = $medium;
                $ExportSend->details = $detais;
                $ExportSend->gender = $gender;
                $ExportSend->contact = $contact;
                $ExportSend->Email = $Email;
                $ExportSend->Obj = $ObjectData;
                $ExportSendMain->$exportname = $ExportSend;
            }
            $MainExport = new \stdClass();
            $MainExport->pages = $total_pages;
            $MainExport->result = $ExportSendMain;
            $exportData = json_encode($MainExport);
        } else {
            $exportData = 'Not Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function c_calc()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` ORDER BY `date` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();

            foreach ($result as $data) {
                $piece = 0;
                $name = $data['name'];
                echo $name;
                $date = "";
                $id = "";
                $stmt_1 = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$name` ORDER BY `Record_date` DESC");
                if (!$stmt_1->execute()) {
                    print_r($stmt->errorInfo());
                    $stmt_1 = null;
                    $Error = 'Fetching data encounted a problem';
                    exit($Error);
                }
                if ($stmt_1->rowCount() > 0) {
                    $result = $stmt_1->fetchAll();

                    foreach ($result as $data_1) {
                        $amountData_e = $data_1['Amount'];
                        $piece += $amountData_e;
                        $date = $data_1['Record_date'];
                        $id = $data_1['id'];
                    }
                }
                $exportData .= '
                <div class="item">
                <div class="file">
                <img src="../../images/cfile.png" alt="" />
                </div>
                <div class="details">
                    <p>' . $name . '  - Total ' . $piece . '</p>
                    <p>last modified . ' . $date . '</p>
                </div>
                <div class="delete option">
                    <svg xmlns="http://www.w3.org/2000/svg" height="30" viewBox="0 -960 960 960"
                        width="30">
                        <path
                            d="M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z" />
                    </svg>
                    <div class="opt_element">
                        <p data-name="' . $name . '" data-id="' . $id . '">Delete item <i></i></p>
                        <p data-name="' . $name . '" data-id="' . $id . '">Update item <i></i></p>
                    </div>
                </div>
            </div>';
                $piece = 0;
            }
        } else {
            $resultCheck = false;
            $exportData = 'Not Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function ExportDataOff()
    {
        $year = date('Y');
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `year` = '$year'");

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            $date = date('Y-m-d H:i:s');
            $namer = $_SESSION['unique_id'];
            $historySet = $this->history_set($namer, "Offertory  Data Export", $date, "Offertory  page dashboard Admin", "User Exported a Offertory  data");
            if (json_decode($historySet) != 'Success') {
                $exportData = 'success';
            }
            foreach ($result as $data) {
                $name = $this->validate($data['event']);
                $amount = $this->validate($data['amount']);
                $date = $this->validate($data['date']);
                $ExportSend = new \stdClass();
                $ExportSend->name = $name;
                $ExportSend->amount = $amount;
                $ExportSend->date = $date;
                $exportname = rand(time(), 120832);
                $ExportSendMain->$exportname = $ExportSend;

            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'Not Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function ExportDatalist()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();

            $date = date('Y-m-d H:i:s');
            $namer = $_SESSION['unique_id'];
            $historySet = $this->history_set($namer, "Payment List  Data Export", $date, "Payment List  page dashboard Admin", "User Exported a Dues  data");
            if (json_decode($historySet) != 'Success') {
                $exportData = 'success';
            }

            foreach ($result as $data) {
                $name = $this->validate($data['name']);
                $amount = $this->validate($data['amount']);
                $date_data = $this->validate($data['date']);

                $ExportSend = new \stdClass();

                $ExportSend->amount = $amount;
                $ExportSend->name = $name;
                $ExportSend->date = $date_data;
                $exportname = rand(time(), 1209);
                $ExportSendMain->$exportname = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'Not Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
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

    protected function ChartData($year)
    {
        $Error_default = 'Not Enough data for analysis';
        $Error_fetch = 'Fetching data encounted a problem';
        $PreviousData = 0;
        $preyear = $year - 1;
        $pretotal = 1;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `year` = ? ORDER BY `month`");
        $stmt->bindParam('1', $preyear, \PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $stmt = null;
            return $Error_fetch;
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $item) {
                $pretotal += $item['amount'];
            }
        }


        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `year` = ? ORDER BY `month`");
        $stmt->bindParam('1', $year, \PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $stmt = null;

            return $Error_fetch;
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $total = 0;
            $current_iteration = 'false';
            $current_total = 'false';
            $array = array();
            $ExportSend = new \stdClass();
            $clean = false;
            $currentMonth = 0;
            $clean = true;
            foreach ($result as $item) {
                $total += $item['amount'];
                if ($current_iteration == 'false') {
                    $current_iteration = $item['month'];
                }
                if ($current_total == 'false') {
                    $current_total = $item['amount'];
                }
                if ($item['month'] != $currentMonth) {
                    $currentMonth = $item['month'];
                    array_push($array, $item['Date']);
                    array_push($array, $current_total);
                    $ExportSend->$current_iteration = $array;
                    $current_total = 0;
                    $array = array();
                    $clean = true;
                }
                $current_iteration = $item['month'];
                $current_total += $item['amount'];

                $clean = false;



            }
            if (!$clean) {
                $lastData = count($result) - 1;
                array_push($array, $result[$lastData]['Date']);
                array_push($array, $current_total);
                $ExportSend->$current_iteration = $array;
                $current_total = $result[$lastData]['month'];
                $array = array();
                $clean = true;
            }


            if (count(get_object_vars($ExportSend)) > 0) {
                $percentage = $total * 100 / $pretotal;
                $ExportSend->Total = $total;
                $ExportSend->PrevTotal = $pretotal;
                $ExportSend->percent = $percentage;
                return $ExportSend;
            } else {
                return $Error_default;
            }
        } else {
            return $Error_default;
        }

    }
    protected function ChartDataYear($year)
    {
        $Error_default = 'Not Enough data for analysis';
        $Error_fetch = 'Fetching data encounted a problem';
        $MainExport = new \stdClass();
        $year_current = $year;
        $total = 0;
        for ($i = 0; $i < 4; $i++) {
            $year_current = $year - $i;
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `year` = ? ORDER BY `month` ASC");
            $stmt->bindParam('1', $year_current, \PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                return $Error_fetch;
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();

                $current_iteration = 0;
                $quartile = 4;
                $current_total = 0;
                $array = array();
                $clean = false;
                $ExportSend = new \stdClass();
                $result1 = 0;
                $result2 = 0;
                $result3 = 0;

                foreach ($result as $item) {
                    $total += $item['amount'];

                    if ($item['month'] <= 4) {
                        $result1 += $item['amount'];
                    } else if ($item['month'] > 4 && $item['month'] <= 8) {
                        $result2 += $item['amount'];
                    } else if ($item['month'] > 8 && $item['month'] <= 12) {
                        $result3 += $item['amount'];
                    }
                }
                $ExportSend->firstQ = $result1;
                $ExportSend->secondQ = $result2;
                $ExportSend->thirdQ = $result3;
                if (count(get_object_vars($ExportSend)) > 0) {
                    $MainExport->Total = $total;
                    $MainExport->$year_current = $ExportSend;
                } else {
                    return $Error_default;
                }
            }
        }

        if (count(get_object_vars($ExportSend)) > 0) {
            return $MainExport;
        } else {
            return $Error_default;
        }
    }
    protected function ChatRecords($year)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`records` where `year` = '$year' ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjectDataMain = new \stdClass();
            $birth = 0;
            $death = 0;
            $visitor = 0;
            $marriage = 0;
            $water_baptism = 0;
            $fire_baptism = 0;
            $soul = 0;


            foreach ($result as $data) {
                $name = strtolower($data['category']);
                if ($name == 'birth') {
                    $birth += 1;
                } elseif ($name == 'death') {
                    $death += 1;
                } elseif ($name == 'water_baptism') {
                    $water_baptism += 1;
                } elseif ($name == 'fire_baptism') {
                    $fire_baptism += 1;
                } elseif ($name == 'soul') {
                    $soul += 1;
                } elseif ($name == 'visitor') {
                    $visitor += 1;
                } elseif ($name == 'marriage') {
                    $marriage += 1;
                }


            }

            $ObjectDataMain->birth = $birth;
            $ObjectDataMain->death = $death;
            $ObjectDataMain->water_baptism = $water_baptism;
            $ObjectDataMain->fire_baptism = $fire_baptism;
            $ObjectDataMain->soul = $soul;
            $ObjectDataMain->visitor = $visitor;
            $ObjectDataMain->marriage = $marriage;
            $exportData = $ObjectDataMain;
        } else {
            $resultCheck = false;
            $exportData = 'Not Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function ChatVisitors($year)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`records` where `year` = '$year' ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjectDataMain = new \stdClass();

            $currentDay = 'false';
            foreach ($result as $data) {
                $name = strtolower($data['category']);
                if ($name == 'visitor') {
                    $timespam = strtotime($data['date']);
                    $Day = date('w', $timespam);
                    $Month = date('m', $timespam);
                    $NewDay = new \stdClass();
                    $ArrayList = get_object_vars($ObjectDataMain);
                    if (array_key_exists($Month, $ArrayList)) {
                        $Check = get_object_vars($ObjectDataMain->$Month);
                        $MainObj = $ObjectDataMain->$Month;
                        if (array_key_exists($Day, $Check)) {
                            $MainObj->$Day += 1;
                        } else {
                            $MainObj->$Day = 1;
                        }
                    } else {
                        $NewDay = new \stdClass();
                        $NewDay->$Day = 1;
                        $ObjectDataMain->$Month = $NewDay;
                    }

                }

            }
            $exportData = $ObjectDataMain;
        } else {
            $resultCheck = false;
            $exportData = 'Not Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function ChatTithComparism($year)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `year` = '$year' ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjectDataMain = new \stdClass();
            $EcashTotal = 0;
            $EcashAmount = 0;
            $IncashTotal = 0;
            $IncashAmount = 0;
            foreach ($result as $data) {
                $name = strtolower($data['Medium_payment']);
                if ($name == 'e-cash') {
                    $EcashTotal += 1;
                    $EcashAmount += $data['amount'];
                } else {
                    $IncashTotal += 1;
                    $IncashAmount += $data['amount'];
                }
            }
            $Ecashpentage = ($EcashTotal / count($result)) * 100;
            $Incashpentage = ($IncashTotal / count($result)) * 100;
            $ObjectDataMain->Ecash = array($Ecashpentage, $EcashAmount);
            $ObjectDataMain->Incash = array($Incashpentage, $IncashAmount);
            $exportData = $ObjectDataMain;
        } else {
            $resultCheck = false;
            $exportData = 'Not Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function ChatBudget($year)
    {
        $ExportData = new \stdClass();

        $database_name = "zoe_" . $year . "_budget";



        $Months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        foreach ($Months as $month) {
            $Other_income = 0;
            $offertory_income = 0;
            $tithe_income = 0;
            $Expenses_total = 0;

            $indexData = array_search($month, $Months);
            $propertyName = $indexData + 1;
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name`  WHERE `category` like '%income%' AND `month`=$propertyName ORDER BY `id` DESC");
            if (!$stmt->execute()) {

                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                //income
                $result = $stmt->fetchAll();
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $Other_income += intVal($amount);
                }
            }

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where  `year` = '$year' AND `month`=$propertyName ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                //offertory
                $result = $stmt->fetchAll();
                foreach ($result as $data) {
                    $amount_o = $data['amount'];
                    $offertory_income += $amount_o;
                }
            }
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where  `year` = '$year' AND `month`=$propertyName ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                //tith
                $result = $stmt->fetchAll();
                foreach ($result as $data) {
                    $amount_t = $data['amount'];
                    $tithe_income += $amount_t;
                }
            }
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name`  WHERE `category` like '%expenses%' and `month`=$propertyName ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                //expenses
                $result = $stmt->fetchAll();
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $Expenses_total += intVal($amount);
                }
            }
            $Income = $Other_income + $offertory_income + $tithe_income;
            $savings = $Income - $Expenses_total;
            $ExportData->$propertyName = array($Income, $Expenses_total, $savings);
        }

        if (count(get_object_vars($ExportData)) > 0) {
            return $ExportData;
        } else {
            return 'Not Enough Data to perform analysis';
        }
    }
    protected function ChatPartnership($year)
    {

        $exportData = '';
        $totalAmount = 0;
        $local = 0;
        $Notlocal = 0;
        $ExportSendMain = new \stdClass();
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership`");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result_main = $stmt->fetchAll();

            foreach ($result_main as $data) {
                $name = $this->validate($data['Name']);
                $Email = $this->validate($data['Email']);
                $unique_id = $this->validate($data['unique_id']);
                $stmt_record = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `email`='$Email'");
                if (!$stmt_record->execute()) {
                    $stmt_record = null;
                    $Error = 'Cannot Retrieve Data';
                    exit(json_encode($Error));
                }
                if ($stmt_record->rowCount() > 0) {
                    $local += 1;
                } else {
                    $Notlocal += 1;
                }

            }
            $stmt_record = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership_records` where `date` like '%$year%' ORDER BY `id` DESC");
            if (!$stmt_record->execute()) {
                $stmt_record = null;
                $Error = 'Cannot Retrieve Data';
                exit(json_encode($Error));
            }
            if ($stmt_record->rowCount() > 0) {
                $result = $stmt_record->fetchAll();
                foreach ($result as $dfile) {
                    $totalAmount += $dfile['amount'];

                }
            }

            $localpercent = ($local / count($result_main)) * 100;
            $Notlocalpercent = ($Notlocal / count($result_main)) * 100;
            $ExportSendMain->Data = array($totalAmount, $localpercent, $Notlocalpercent);
        }

        if (count(get_object_vars($ExportSendMain)) > 0) {
            return $ExportSendMain;
        } else {
            return 'NoT Enough Data to perform Analysis';
        }


    }
    protected function ChartEventYear($year)
    {
        $Error_default = 'Not Enough data for analysis';
        $Error_fetch = 'Fetching data encounted a problem';
        $MainExport = new \stdClass();
        $year_current = $year;
        $total = 0;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `year` = ? ORDER BY `month` ASC");
        $stmt->bindParam('1', $year_current, \PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $stmt = null;
            return $Error_fetch;
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();

            $current_iteration = 0;
            $Events1 = 0;
            $Events2 = 0;
            $Events3 = 0;
            $quartile = 4;
            $current_total = 0;
            $array = array();
            $clean = false;
            $ExportSend = new \stdClass();
            $result1 = 0;
            $result2 = 0;
            $result3 = 0;

            foreach ($result as $item) {
                $total += $item['amount'];
                if ($item['month'] <= 4) {
                    $result1 += $item['amount'];
                    $Events1 += 1;
                } else if ($item['month'] > 4 && $item['month'] <= 8) {
                    $result2 += $item['amount'];
                    $Events2 += 1;
                } else if ($item['month'] > 8 && $item['month'] <= 12) {
                    $result3 += $item['amount'];
                    $Events3 += 1;
                }
            }
            $ExportSend->firstQ = array($Events1, $result1);
            $ExportSend->secondQ = array($Events2, $result2);
            $ExportSend->thirdQ = array($Events3, $result3);
            if (count(get_object_vars($ExportSend)) > 0) {
                $MainExport->Total = $total;
                $MainExport->$year_current = $ExportSend;
            } else {
                return $Error_default;
            }
        }


        if (count(get_object_vars($ExportSend)) > 0) {
            return $MainExport;
        } else {
            return $Error_default;
        }
    }
    protected function ChartMembership()
    {
        $Error_default = 'Not Enough data for analysis';
        $Error_fetch = 'Fetching data encounted a problem';
        $MainExport = new \stdClass();
        $total = 0;
        $AdultMale = 0;
        $AdultFeMale = 0;
        $ChildrenMale = 0;
        $ChildrenFeMale = 0;
        $Uncategorized = 0;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` ");
        if (!$stmt->execute()) {
            $stmt = null;
            return $Error_fetch;
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $total = count($result);
            foreach ($result as $Member) {
                $gender = strtolower($Member['gender']);
                $Age = strtolower($Member['membership_start']);
                if (!Str_contains($Age, '..')) {
                    $currentYear = date('Y');
                    $Start = strtotime($Age);
                    $StartYear = date('Y', $Start);
                    $Age = $currentYear - $StartYear;
                    if ($Age > 0 && $Age < 18) {
                        if ($gender == 'female') {
                            $ChildrenFeMale += 1;
                        } else {
                            $ChildrenMale += 1;
                        }
                    } else {
                        if ($gender == 'female') {
                            $AdultFeMale += 1;
                        } else {
                            $AdultMale += 1;
                        }
                    }

                } else {
                    $Uncategorized += 1;
                }
            }
            $Data = array($total, $AdultMale, $AdultFeMale, $ChildrenMale, $ChildrenFeMale, $Uncategorized);
            $MainExport->Data = $Data;
        }

        if (count(get_object_vars($MainExport)) > 0) {
            return $MainExport;
        } else {
            return $Error_default;
        }
    }
    protected function ChartOffertoryYear($year)
    {
        $Error_default = 'Not Enough data for analysis';
        $Error_fetch = 'Fetching data encounted a problem';
        $MainExport = new \stdClass();
        $year_current = $year;
        $total = 0;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `year` = ? ORDER BY `month` ASC");
        $stmt->bindParam('1', $year_current, \PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $stmt = null;
            return $Error_fetch;
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();

            $current_iteration = 0;
            $quartile = 4;
            $current_total = 0;
            $array = array();
            $clean = false;
            $ExportSend = new \stdClass();
            $result1 = 0;
            $result2 = 0;
            $result3 = 0;

            foreach ($result as $item) {
                $total += $item['amount'];

                if ($item['month'] <= 4) {
                    $result1 += $item['amount'];
                } else if ($item['month'] > 4 && $item['month'] <= 8) {
                    $result2 += $item['amount'];
                } else if ($item['month'] > 8 && $item['month'] <= 12) {
                    $result3 += $item['amount'];
                }
            }
            $ExportSend->firstQ = $result1;
            $ExportSend->secondQ = $result2;
            $ExportSend->thirdQ = $result3;
            if (count(get_object_vars($ExportSend)) > 0) {
                $MainExport->Total = $total;
                $MainExport->$year_current = $ExportSend;
            } else {
                return $Error_default;
            }
        }


        if (count(get_object_vars($ExportSend)) > 0) {
            return $MainExport;
        } else {
            return $Error_default;
        }
    }
}