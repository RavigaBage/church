<?php
date_default_timezone_set('UTC');

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
    protected function Tithe_Records($unique_id, $Medium_payment, $description, $name, $amount, $Date, $month, $year)
    {

        $input_list = array($unique_id, $Medium_payment, $description, $name, $amount, $Date, $month, $year);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$unique_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $name = $result[0]['Firstname'] . $result[0]['Othername'];
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `unique_id`='$unique_id' AND `month`='$month'");
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
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`tiths` (`unique_id`, `month`, `year`, `Medium_payment`, `Date`, `description`, `name`, `amount`)
                    VALUES ('$unique_id','$month,'$year','$Medium_payment','$Date','$description','$name','$amount')");

                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encountered a problem';
                        exit($Error);
                    } else {
                        $exportData = 'Data entry was a success Page will refresh to display new data';
                        exit('Upload was a success');
                    }



                }
            } else {
                exit('User does not exist');
            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Tithe_Records_update($unique_id, $Medium_payment, $description, $date_uploaded, $name, $amount, $Date, $month, $year)
    {

        $input_list = array($unique_id, $Medium_payment, $description, $date_uploaded, $name, $amount, $Date, $month, $year);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$unique_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $name = $result[0]['Firstname'] . $result[0]['Othername'];

                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `unique_id`='$unique_id' AND `month`='$month'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                }
                if ($stmt->rowCount() > 0) {

                    $unique_id = rand(time(), 3002);
                    $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`tiths` SET `month`='$month',`year`='$month',`Medium_payment`='$Medium_payment',`Date`=$Date,`description`='$description',`name`='$name',`amount`='$amount' WHERE `unique_id`='$unique_id' ");

                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encountered a problem';
                        exit($Error);
                    } else {
                        $exportData = 'Data entry was a success Page will refresh to display new data';
                        exit('Upload was a success');
                    }


                } else {
                    $exportData = 'Unexpected, data cannot be found !!';
                    $resultCheck = false;
                }

            } else {
                exit('User does not exist');
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
                exit($Error);
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
                VALUES ('$unique_id', '$date','$month','$year','$name', '$type', '$amount', '$purpose')");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
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
    protected function RecordsUpdate($name, $type, $amount, $month, $year, $purpose, $date, $id)
    {
        $input_list = array($name, $type, $amount, $month, $year, $purpose, $date);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `unique_id`='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = 'An Error Ocurred, data #Kqy' . $id . 'xcre cannot be found ';
                $resultCheck = false;
            } else {
                $stmt = $this->data_connect()->prepare("UPDATE  `zoeworshipcentre`.`offertory_records` SET `date`='$date',`month`='$month',`year`='$year',`event`='$name',
                `type`='$type',`amount`='$amount',`purpose`='$purpose' WHERE `unique_id`='$id'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM  `zoeworshipcentre`.`dues` where `unique_id`='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                foreach ($result as $row) {
                    $row_name = $row['name'];
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoedues`.`$row_name` ( `$id`, `user`, `Amount`, `Date`, `Medium`, `status`, `Record_date`)
                    values ('$id','$name','$amount','$date','$medium','$status','$date')");
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encountered a problem';
                        exit($Error);
                    } else {
                        $exportData = 'Data entry was a success Page will refresh to display new data';
                        exit('Upload was a success');
                    }

                }
            } else {
                $exportData = 'An Error Ocurred, data #rghy' . $id . 'tre cannot be found!';
                $resultCheck = false;


            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
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
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` where `name`='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = 'Duplication detected, data already exists';
                $resultCheck = $exportData;
            } else {
                $unique_id = rand(time(), 3002);
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`dues` (`unique_id`,`name`, `amount`, `purpose`, `department`, `status`, `due_date`, `date`) VALUES ('$unique_id','$name','$amount','$purpose','$department','$status','$due','$date')");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    ///////////////Creating Dues Table
                    $stmt = $this->data_connect()->prepare("
                    CREATE TABLE  `zoedues`.`$name`
                    (`id` INT(255) AUTO_INCREMENT PRIMARY KEY,
                    `$unique_id` INT(255),
                    `user` INT(255),
                    `Amount` varchar(255),
                    `Date` varchar(255),
                    `Medium` varchar(255),
                    `status` varchar(255),
                    `Record_date` varchar(255)
                    )  ");
                    if ($stmt->execute()) {
                        $exportData = 'Data entry was a success Page will refresh to display new data';
                        exit('Upload was a success');
                    } else {
                        $Error = 'An Unexpected error occurred whiles creating pay list column';
                        exit($Error);
                    }
                }



            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Dues_Records_update($name, $department, $amount, $purpose, $due, $id)
    {
        $input_list = array($name, $department, $amount, $purpose, $due, $id);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` where `unique_id`='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = 'An Error Ocurred, data #Kqy' . $id . 'xcre cannot be found ';
                $resultCheck = false;
            } else {
                $stmt = $this->data_connect()->prepare("UPDATE  `zoeworshipcentre`.`dues` SET `name`='$name',`amount`='$amount',`purpose`='$purpose',`department`='$department',`status`='$status',`due_date`='$due',`date`='$date' WHERE `unique_id`='$id'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
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

    protected function Dues_delete_data($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`dues` where `unique_id`=?");
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

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_system` where `name`='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = 'Duplication detected, data already exists';
                $resultCheck = $exportData;
            } else {
                $unique_id = rand(time(), 3002);
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`account_system` (`account_name`, `date_created`, `Total_amount`, `last_modified`) VALUES ('$name','$created','$amount','$date')");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    ///////////////Creating Dues Table
                    $stmt = $this->data_connect()->prepare("
                    CREATE TABLE  `zoeaccounts`.`$name`
                    (`id` INT(255) AUTO_INCREMENT PRIMARY KEY,
                    `unique_id` INT(255),
                    `description` INT(255),
                    `date` varchar(255),
                    `time` varchar(255),
                    `category` varchar(255),
                    `percentage` varchar(255),
                    `amount` varchar(255),
                    `balance` varchar(255)
                    )  ");
                    if ($stmt->execute()) {
                        $exportData = 'Data entry was a success Page will refresh to display new data';
                        exit('Upload was a success');
                    } else {
                        $Error = 'An Unexpected error occurred whiles creating pay list column';
                        exit($Error);
                    }
                }



            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_systems` where `id`='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = 'An Error Ocurred, data #Kqy' . $id . 'xcre cannot be found ';
                $resultCheck = false;
            } else {
                $stmt = $this->data_connect()->prepare("UPDATE  `zoeworshipcentre`.`account_systems` SET `account_name`=?,`date_created`=?,`Total_amount`=?,`last_modified`=? WHERE `id`='$id'");
                $stmt->bindParam('1', $name, PDO::PARAM_STR);
                $stmt->bindParam('2', $created, PDO::PARAM_STR);
                $stmt->bindParam('3', $amount, PDO::PARAM_STR);
                $stmt->bindParam('4', $id, PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_system` where `id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`account_system` where `id`=?");
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
            $stmt = $this->data_connect()->prepare("UPDATE  `zoeaccounts`.`$acc_name` SET `description`='$description',`date`='$date',`time`='$time',`category`='$category', `percentage`='$percentage',`amount`='$amount',balance='$balance' WHERE `unique_id`='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            } else {
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
                    $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
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
            $stmt = $this->data_connect()->prepare("INSERT INTO `zoeaccounts`.`$acc_name` (`unique_id`,`description`,`date`,`time`,`category`,`percentage`,`amount`,`balance`) VALUES ('$unique_id'','$description',' $date',' $time',' $category',' $percentage',' $amount',' $balance')");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            } else {

                $exportData = 'Data entry was a success Page will refresh to display new data';
                exit('Upload was a success');

            }





            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }


    protected function Transaction($account, $category, $amount, $status, $authorize)
    {
        $exportData = "";
        $input_list = array($account, $category, $amount, $status, $authorize);
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
            $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`transaction_records` (`account`, `Category`, `Amount`, `Status`, `Authorize`,`Date`) VALUES ('$account','$category','$amount','$status','$authorize','$date')");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            } else {
                $exportData = 'Data entry was a success Page will refresh to display new data';
                exit('Upload was a success');

            }





            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Transaction_update($id, $account, $category, $amount, $status, $authorize)
    {
        $exportData = "";
        $input_list = array($account, $category, $amount, $status, $authorize);
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
            $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`transaction_records` SET `account`=?,`Category`=?,`Amount`=?,`Status`=?,`Authorize`=?,`Date`=? WHERE Id = ?");

            $stmt->bindParam('1', $account, PDO::PARAM_STR);
            $stmt->bindParam('2', $category, PDO::PARAM_STR);
            $stmt->bindParam('3', $amount, PDO::PARAM_STR);
            $stmt->bindParam('4', $status, PDO::PARAM_STR);
            $stmt->bindParam('5', $authorize, PDO::PARAM_STR);
            $stmt->bindParam('6', $date, PDO::PARAM_STR);
            $stmt->bindParam('7', $id, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            } else {
                $exportData = 'Data entry was a success Page will refresh to display new data';
                exit('Upload was a success');

            }





            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
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
            $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`budget` (`Name`, `status`, `Authorize`, `About`, `details`,`Date`) VALUES ('$name','$status','$authorize','$about','$details',$date)");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            } else {
                $exportData = 'Data entry was a success Page will refresh to display new data';
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
            $stmt->bindParam('1', $name, PDO::PARAM_STR);
            $stmt->bindParam('2', $status, PDO::PARAM_STR);
            $stmt->bindParam('3', $authorize, PDO::PARAM_STR);
            $stmt->bindParam('4', $amount, PDO::PARAM_STR);
            $stmt->bindParam('5', $details, PDO::PARAM_STR);
            $stmt->bindParam('6', $date, PDO::PARAM_STR);
            $stmt->bindParam('7', $id, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            } else {
                $exportData = 'Data entry was a success Page will refresh to display new data';
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

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }

        }
    }
    protected function Budget_user($name, $category, $type, $amount, $details, $date, $year, $month, $recorded_by)
    {
        $exportData = "";
        $input_list = array($name, $category, $type, $amount, $details, $date, $year, $month, $recorded_by);
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
            $stmt = $this->data_connect()->prepare("INSERT INTO `zoe_budget`.`$name` (`category`, `type`, `amount`, `details`, `date`, `Year`, `month`, `recorded_by`) VALUES ('$category','$type','$amount','$details','$date','$year','$month','$recorded_by')");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            } else {
                $exportData = 'Data entry was a success Page will refresh to display new data';
                exit('Upload was a success');

            }





            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Budget_user_update($name, $category, $type, $amount, $details, $date, $year, $month, $recorded_by, $id)
    {
        $exportData = "";
        $input_list = array($name, $category, $type, $amount, $details, $date, $year, $month, $recorded_by);
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
            $stmt = $this->data_connect()->prepare("UPDATE `zoe_budget`.`$name` SET `category`=?,`type`=?,`amount`=?,`details`=?,`date`=?,`Year`=?,`month`=?,`recorded_by`=? WHERE WHERE Id = ?");
            $stmt->bindParam('1', $category, PDO::PARAM_STR);
            $stmt->bindParam('2', $type, PDO::PARAM_STR);
            $stmt->bindParam('3', $amount, PDO::PARAM_STR);
            $stmt->bindParam('4', $details, PDO::PARAM_STR);
            $stmt->bindParam('5', $date, PDO::PARAM_STR);
            $stmt->bindParam('6', $year, PDO::PARAM_STR);
            $stmt->bindParam('7', $month, PDO::PARAM_STR);
            $stmt->bindParam('8', $recorded_by, PDO::PARAM_STR);
            $stmt->bindParam('9', $id, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            } else {
                $exportData = 'Data entry was a success Page will refresh to display new data';
                exit('Upload was a success');

            }





            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }

    protected function Budget_delete_user_data($form_name, $id)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$form_name` where `id` ='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoe_budget`.`$form_name` where `id`=?");
                    $stmt->bindParam('1', $id, PDO::PARAM_STR);
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

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }

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
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` where `id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`transaction_records` where `id`=?");
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

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }

        }
    }


    protected function Dues_user_update($name, $medium, $amount, $form_name, $user_date, $id, $unique_id)
    {
        $input_list = array($name, $medium, $amount, $form_name, $user_date, $id, $unique_id);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$form_name` where `$id`='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = 'An Error Ocurred, data #Kqy' . $id . 'xcre cannot be found ';
                $resultCheck = false;
            } else {
                $stmt = $this->data_connect()->prepare("UPDATE  `zoedues`.`$form_name` SET `Amount`='$amount',`Date`='$user_date',`Medium`='$medium',`Record_date`='$date' WHERE `user`='$unique_id'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
                    exit($exportData);
                }



            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Dues_user_record($name, $medium, $amount, $form_name, $user_date, $id, $unique_id)
    {
        $input_list = array($name, $medium, $amount, $form_name, $user_date, $id, $unique_id);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$form_name` where `$id`='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = 'An Error Ocurred, data #Kqy' . $id . 'xcre cannot be found ';
                $resultCheck = false;
            } else {
                $stmt = $this->data_connect()->prepare("INSERT INTO  `zoedues`.`$form_name`( `$unique_id`, `user`, `Amount`, `Date`, `Medium`, `status`, `Record_date`) VALUES ('$unique_id','$name','$amount','$user_date','$medium','active','$date')");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
                    exit($exportData);
                }



            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
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
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoedues`.`$form_name` where `user`=?");
                    $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
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
    protected function Usernames()
    {
        $exportData = 0;
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` ORDER BY `Othername` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $firstname = $data['Firstname'];
                $Othername = $data['Othername'];
                $unique_id = $data['unique_id'];
                $exportData .= '<option value="' . $unique_id . '">' . $firstname . ' ' . $Othername . '</option> ';

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
    protected function Budget_data_list()
    {
        $exportData = 0;
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcenter`.`budget`  ORDER BY `id` DESC");
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



    }
    protected function Budget_list($name, $year)
    {
        $exportData = 0;
        $resultCheck = true;
        $Grand_Other_income = 0;
        $Grand_offertory_income = 0;
        $Grand_tithe_income = 0;
        $Grand_Expenses_total = 0;

        $Other_income = 0;
        $offertory_income = 0;
        $tithe_income = 0;
        $Expenses_total = 0;

        $Months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        foreach ($Months as $month) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$name` where `type` = 'income' AND `year` = '$year' AND `month`='$month' ORDER BY `id` DESC");
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$name` where `type` = 'expenses' AND `year` = '$year' AND `month`='$month' ORDER BY `id` DESC");
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

            $Grand_Other_income += $Other_income;
            $Grand_offertory_income += $offertory_income;
            $Grand_tithe_income += $tithe_income;
            $Grand_Expenses_total += $Expenses_total;

            $Other_income = 0;
            $offertory_income = 0;
            $tithe_income = 0;
            $Expenses_total = 0;
        }
        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function Expenses_list($name, $year)
    {
        $exportData = 0;
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$name`  AND `year` = '$year' ORDER BY `id` DESC");
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


        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }



    }

    protected function Expenses_Delete($name, $id)
    {
        $exportData = 0;
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$name`  Where `id` = '$id' ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoe_budget`.`$name` where `id`=?");
            $stmt->bindParam('1', $name, PDO::PARAM_STR);
            if (!$stmt1->execute()) {
                $stmt1 = null;
                $Error = 'deleting data encountered a problem';
                exit($Error);
            } else {
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


    public function Expenses_list_filter($name, $year, $month)
    {
        $exportData = 0;
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$name`  AND `year` = '$year' AND `month` ='$month' ORDER BY `id` DESC");
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

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }

    }

    public function Pay_list_Info($id)
    {
        $exportData = 0;
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

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$name`");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = ' 
            <table>
            <thead>
                <tr>
                    <th>
                        <h1>N_.</h1>
                    </th>
                    <th>
                        <h1>NAME</h1>
                    </th>
                    <th>
                        <h1>AMOUNT</h1>
                    </th>
                    <th>
                        <h1>MEDIUM</h1>
                    </th>
                    <th>
                        <h1>DATE</h1>
                    </th>
                    <th>
                        <h1>OPTIONS</h1>
                    </th>
                </tr>
            </thead>
            <tbody>';
                $result = $stmt->fetchAll();
                foreach ($result as $data) {
                    $namer = $data['user'];

                    $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$namer'");
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encounted a problem';
                        exit($Error);
                    }
                    if ($stmt->rowCount() > 0) {
                        $row2 = $stmt->fetchAll();
                        foreach ($row2 as $value) {
                            $Name = $value['Firstname'] . '  ' . $value['Othername'];
                            $image = $value['image'];
                            $rand_id = rand(1322, 12023);
                            $exportData .= ' 
                    <tr>
                        <td>
                        </td>
                        <td>
                            <div class="image">
                                <img src="php/users/' . $image . '" alt="user" />
                            </div>
                            <input type="text" name="name" class="data-' . $rand_id . '" value="' . $Name . '" />
                        </td>
                        <td>
                            <input type="text"  name="amount" class="amount data-' . $rand_id . '" value="' . $data['Amount'] . '" />
                        </td>
                        <td>
                        <input type="hidden" name="formName" class="data-' . $rand_id . '" value="' . $name . '" />    
                        <input type="hidden" name="formId" class="data-' . $rand_id . '" value="' . $id . '" />
                        <input type="hidden" name="unique_id" class="data-' . $rand_id . '" value="' . $namer . '" /> 
                            <input type="text" name="medium"  class="data-' . $rand_id . '" value="' . $data['Medium'] . '" />
                        </td>
                        <td>
                            <input type="text" name="date" class="data-' . $rand_id . '" value="' . $data['Date'] . '" />
                        </td>
                        <td>
                        <button name="formName" value="' . $rand_id . '" class="userUpdateBtn" onclick="UserUpdate(this)"><span class="showresult"></span>Update</button>
                        </td>
                    </tr>
                ';
                        }

                    }

                }
                $exportData .= '</tbody>
                </table>';
            }

        } else {
            $resultCheck = false;
            $exportData = '<p>No Results Founds</p>';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function list_Info()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` ORDER BY `date` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $name = $data['name'];
                $amount = $data['amount'];
                $date = $data['date'];
                $id = $data['unique_id'];

                $exportData .= '
                <div class="item">
                <div class="file">
                <img src="../../images/cfile.png" alt="" />
                </div>
                <div class="details">
                    <p>' . $name . '  - Total ' . $amount . '</p>
                    <p>last modified . ' . $date . '</p>
                </div>
                <div class="delete option">
                    <svg xmlns="http://www.w3.org/2000/svg" height="30" viewBox="0 -960 960 960"
                        width="30">
                        <path
                            d="M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z" />
                    </svg>
                    <div class="opt_element">
                        <p data-id="' . $id . '">Delete item <i></i></p>
                        <p data-id="' . $id . '">Update item <i></i></p>
                    </div>
                </div>
            </div>';

            }
        } else {
            $resultCheck = false;
            $exportData = '<header>Not Records Available</header>';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function list_Info_tithe()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` ORDER BY `date` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $exportData .= '
                <ul class="main five">
                <li><input type="checkbox" class="checkbox" value="' . $data['unique_id'] . '" >' . $data['name'] . '</li>
                <li>' . $data['Medium_payment'] . '</li>
                <li>' . $data['amount'] . '</li>
                <li><p>Published</p>-<p>' . $data['Date'] . '</p></li>
                </ul>';

            }
        } else {
            $resultCheck = false;
            $exportData = '<header>Not Records Available</header>';
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
                $date = "";
                $id = "";
                $stmt_1 = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$name` ORDER BY `Record_date` DESC");
                if (!$stmt_1->execute()) {
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
            $exportData = '<header>Not Records Available</header>';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
}