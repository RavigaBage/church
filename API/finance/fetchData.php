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
    protected function Tithe_Records($unique_id, $Medium_payment, $description, $amount, $Date, $month, $year)
    {
        $resultCheck = true;

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
                    $exportData = 'Duplication detected, data already exists';
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
                        $exportData = 'upload was successful';
                    }
                }
            } else {
                exit(json_encode('cannot find user, refresh the page as it might solve the problem'));
            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$unique_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $name = $result[0]['Firstname'] . $result[0]['Othername'];

                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `unique_id`='$unique_id' AND `month`='$month' AND `year`='$year'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                }
                if ($stmt->rowCount() > 0) {
                    $stmt_insert = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`tiths` SET `month`='$month',`year`='$year',`Medium_payment`='$Medium_payment',`Date`=$Date,`description`='$description',`name`='$name',`amount`='$amount' WHERE `unique_id`='$unique_id' ");
                    if (!$stmt_insert->execute()) {
                        $stmt_insert = null;
                        $Error = 'Fetching data encountered a problem';
                        exit(json_encode($Error));
                    } else {

                        $exportData = 'Data entry was a success';
                    }


                } else {
                    $exportData = 'Unexpected, data cannot be found';
                    $resultCheck = false;
                    exit($exportData);
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
                    $stmt1->bindParam('1', $name, PDO::PARAM_STR);
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
                exit(json_encode($Error));
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `date`='$data' AND `amount`='$amount'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
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
                    exit(json_encode($Error));
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
                    exit(json_encode('Upload was a success'));
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
                exit(json_encode($Error));
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where `unique_id`='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
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
                    exit(json_encode($Error));
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
                    exit(json_encode('Upload was a success'));
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
                    $stmt1->bindParam('1', $name, PDO::PARAM_STR);
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

    #to fix
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
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoedues`.`$name` ( `$id`, `user`, `Amount`, `Date`, `Medium`, `status`, `Record_date`)
                    values ('$id','$name','$amount','$date','$medium','$status','$date')");
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
                $resultCheck = $exportData;
            } else {
                $unique_id = rand(time(), 3002);
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`dues` (`unique_id`,`name`, `amount`, `purpose`, `department`, `status`, `due_date`, `date`) VALUES ('$unique_id','$name','$amount','$purpose','$department','$status','$due','$date')");
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
                        exit(json_encode('Upload was a success'));
                    } else {
                        $Error = 'An Unexpected error occurred whiles creating pay list column';
                        exit(json_encode($Error));
                    }
                }



            }
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
                $stmt = $this->data_connect()->prepare("UPDATE  `zoeworshipcentre`.`dues` SET `name`='$name',`amount`='$amount',`purpose`='$purpose',`department`='$department',`status`='$status',`due_date`='$due',`date`='$date' WHERE `unique_id`='$id'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
                    exit(json_encode('Upload was a success'));
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
                $stmt1->bindParam('1', $name, PDO::PARAM_STR);
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
                        $resultCheck = true;
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
                    `category` varchar(255),
                    `percentage` varchar(255),
                    `amount` varchar(255),
                    `balance` varchar(255)
                    )  ");
                    if ($stmt->execute()) {
                        $exportData = 'Data entry was a success Page will refresh to display new data';
                        exit('Upload was a success');
                    } else {
                        print_r($stmt->errorInfo());
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
                $stmt->bindParam('1', $name, PDO::PARAM_STR);
                $stmt->bindParam('2', $created, PDO::PARAM_STR);
                $stmt->bindParam('3', $amount, PDO::PARAM_STR);
                $stmt->bindParam('4', $date, PDO::PARAM_STR);
                $stmt->bindParam('5', $id, PDO::PARAM_STR);

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
    protected function Account_delete_data($name, $id)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_system` where `account_name` ='$name' AND `id`='$id'");
            if (!$stmt->execute()) {
                print_r($stmt->errorInfo());
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`account_system` where `account_name`=? AND  `id`=?");
                    $stmt1->bindParam('1', $name, PDO::PARAM_STR);
                    $stmt1->bindParam('2', $id, PDO::PARAM_STR);

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
            $stmt = $this->data_connect()->prepare("UPDATE  `zoeaccounts`.`$acc_name` SET `description`='$description',`date`='$date',`category`='$category', `percentage`='$percentage',`amount`='$amount',balance='$balance' WHERE `unique_id`='$id'");
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

                    $stmt1->bindParam('1', $unique_id, PDO::PARAM_STR);
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
            $stmt = $this->data_connect()->prepare("INSERT INTO `zoeaccounts`.`$acc_name` (`unique_id`,`description`,`date`,`category`,`percentage`,`amount`,`balance`) VALUES ('$unique_id','$description',' $date',' $category',' $percentage',' $amount',' $balance')");
            if (!$stmt->execute()) {
                print_r($stmt->errorInfo());
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


    protected function Transaction($account, $category, $amount, $status, $authorize,$date)
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
            if($stmt->rowCount() > 0){
                $result = $stmt->fetchAll();
                $Amount = $result[0]['Total_amount'];
                $newAmount = null;
                if($category == 'expenses'){
                    $newAmount = intval($Amount) - intval($amount);
                }
                if($category == 'income'){
                    $newAmount = intval($Amount) + intval($amount);
                }

                $percentage = round((100 * $newAmount) / $Amount) - 100;

                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`transaction_records` (`unique_id`,`account`, `Category`, `Amount`, `Status`, `Authorize`,`Date`) VALUES ('$unique_id','$account','$category','$amount','$status','$authorize','$date')");
                if (!$stmt->execute()) {
                    
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                } else {
                    $unique_id = rand(time(),10023);
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeaccounts`.`$account`(`unique_id`, `description`, `date`, `category`, `percentage`, `amount`, `balance`) VALUES ('$unique_id','$category record from transaction records','$date','$category','$percentage',$amount,$newAmount) ");
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encountered a problem';
                        exit(json_encode($Error));
                    }else{
                    $stmt = $this->data_connect()->prepare("UPDATE  `zoeworshipcentre`.`account_system` SET`Total_amount`=?,`last_modified`=? WHERE `account_name`=?");
                    $date = date('Ymd');
                    $stmt->bindParam('1', $newAmount, PDO::PARAM_STR);
                    $stmt->bindParam('2', $date, PDO::PARAM_STR);
                    $stmt->bindParam('3', $account, PDO::PARAM_STR);

                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Error: encountered a problem while adding data';
                        exit(json_encode($Error));
                    }else{
                        $exportData = 'Upload was a success';
                    }

                    }
                }
            }else{
                exit(json_encode("Account is invalid"));
            }





            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }
        }
    }
    protected function Transaction_update_data($id, $account, $category, $amount, $status, $authorize,$date)
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
            $unique_id = rand(time(), 3002);
            $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`transaction_records` SET `account`=?,`Category`=?,`Amount`=?,`Status`=?,`Authorize`=?,`Date`=? WHERE `unique_id` = ?");

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
                exit(json_encode($Error));
            } else {
                $exportData = 'Data entry was a success Page will refresh to display new data';
                exit(json_encode('Update was a success'));

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
                    $stmt1->bindParam('1', $name, PDO::PARAM_STR);
                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = 'deleting data encountered a problem';
                        exit(json_encode($Error));
                    } else {
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

    protected function TransactionListFilter($account, $category,$year)
    {
        $exportData = false;
        $resultCheck ="";
        if ($category == 'Select' && $account == 'Select') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` Where `Date` like '%$year%' ORDER BY `id` DESC limit 50");
        } else if ($category != 'Select' && $account == 'Select'){
           
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` Where `Date` like '%$year%' AND `category` like '%$category%' ORDER BY `id` DESC limit 50");
        }else if ($category == 'Select' && $account != 'Select'){
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` Where `Date` like '%$year%' AND `account` like '%$account%' ORDER BY `id` DESC limit 50");
        }else{
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` Where `Date` like '%$year%' AND `account` like '%$account%' AND `category`like '%$category%' ORDER BY `id` DESC limit 50");
        }

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $account = $data['account'];
                $amount = $data['Amount'];
                $date = $data['Date'];
                $id = $data['unique_id'];
                $Status = $data['Status'];
                $category = $data['Category'];
                $Authorize = $data['Authorize'];

                $ObjectInfo = new stdClass();
                $ObjectInfo->account = $account;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->Date = $date;
                $ObjectInfo->category = $category;
                $ObjectInfo->Authorize = $Authorize;
                $ObjectInfo->Status = $Status;
                $ObjectInfo->id = $id;
                $ObjectData = json_encode($ObjectInfo);

                if($Status == 'terminated'){
                    $item = "<div class='out_btn'><div></div>".$Status."</div>";
                }else
                if($Status == 'pending'){
                    $item = "<div class='in_btn blue'><div></div>".$Status."</div>";
                }else{
                    $item = "<div class='in_btn'><div></div>".$Status."</div>";
                }

                $exportData .= "<tr>
                        <td><div class='details'>
                       
                        <div class='text'>
                        <p>".$account."</p>
                        <p>".$date."</p>
                        </div>
                        
                        </div></td>
                        <td>".$item."</td>
                        <td>".$Authorize."</td>
                        <td>".$amount."</td>
                        <td>".$category."</td>
                        <td class='option'>
                            <div class='delete option'>
                                    <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                                        width='30'>
                                        <path
                                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                    </svg>
                                    <div class='opt_element'>
                                        <p class='update_item' Update_item='" . $id . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                                        <p class='delete_item' delete_item='" . $id . "' >Delete item <i></i></p>
                                    </div>
                            </div>
                        </td>
                    </tr>";

                
            }
        } else {
            $exportData = 'Not Records Available';
        }

        if($exportData != ""){
            return $exportData;
        }else{
            return false;
        }
    }

    #tofix
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
    #endtoefix
    protected function Add_Budget_user($category, $type, $amount, $details, $date, $year, $month, $recorded_by)   {

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
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            } else {
                $exportData = 'Data entry was a success Page will refresh to display new data';
                exit(json_encode('Upload was a success'));

            }

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
                echo $id;
                print_r($stmt->errorInfo());
                $stmt = null;
               
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            } else {
                exit(json_encode('Upload was a success'));

            }
            
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
                    $stmt1->bindParam('1', $id, PDO::PARAM_STR);
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

    protected function Dues_user_update($name, $medium, $amount, $form_name, $user_date,  $unique_id)
    {
        $input_list = array($name, $medium, $amount, $form_name, $user_date,  $unique_id);
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
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                } else {
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
    protected function Dues_user_record($Name, $medium, $amount, $user_date,  $unique_id)
    {
        $input_list = array($Name, $medium, $amount,$user_date,  $unique_id);
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
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$name` where `$unique_id`='$unique_id' AND `Record_date`='$user_date'");
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
                    $userData = $this->Confirm_membership_Records($Name);
                    $stmt = $this->data_connect()->prepare("INSERT INTO  `zoedues`.`$name`( `$unique_id`, `user`, `Amount`, `Date`, `Medium`, `status`, `Record_date`) VALUES ('$unique_id','$userData','$amount','$user_date','$medium','active pay','$date')");
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encountered a problem';
                        exit(json_error($Error));
                    } else {
                        $exportData = 'Data entry was a success Page will refresh to display new data';
                        exit(json_encode($exportData));
                    }
    
    
    
                }
    
            }else{
                $exportData = "form is currently not  in session !! ".$unique_id;
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
                    $stmt1->bindParam('1', $unique_id, PDO::PARAM_STR);
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
    protected function Confirm_membership_Records($name)
    {
        $splitName = explode(' ',$name);
        $LastSplit = $splitName[0];
        $FirstSplit = $splitName[1];
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `Othername` like '%$LastSplit%' AND `Firstname` like '%$FirstSplit%' ");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit();
        }
        $id = rand(time(),1000);
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            return $result[0]['unique_id'];
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
            foreach ($result as $data) {
                $account = $data['account_name'];
                $exportData .= '<option value='.$account.'>'.$account.'</option>';

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

    protected function Accounts_listCard()
    {
        $exportData = "";
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_system` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $amount = $data['Total_amount'];
                $modified = $data['last_modified'];
                $name = $data['account_name'];
                $exportData .= '<div class="card">
                    <div class="top">
                        <div class="left">
                            <img src="../images/BTC.png" alt="card1-1">
                        </div>
                        <img src="../images/visa.png" class="right" alt="card1-2">
                    </div>
                    <div class="middle">
                        <h1>Ȼ '.$amount.'</h1>
                        <div class="chip">
                            <img src="../images/card chip.png" class="chip" alt="card-chip">
                        </div>
                    </div>
                    <b>'.$name.'</b>
                    <div class="bottom">
                        <div class="right">
                            <div class="card_data">
                                <small>Holder</small>
                                <h5>Church</h5>
                            </div>
                            
                            <div class="cvv">
                                <small>modified</small>
                                <h5>'.$modified.'</h5>
                            </div>
                        </div>
                    </div>
                </div>';

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
        $resultCheck = true;
        $exportData = new stdClass();
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
        $exportData = new stdClass();
        $resultCheck = true;
        $income_Class = new stdClass();
        $Offertory_Class = new stdClass();
        $tithe_Class = new stdClass();
        $Ultilities_Class = new stdClass();
        $Housing_Class = new stdClass();
        $paycheck_Class = new stdClass();
        $Others_Class = new stdClass();
        $Other_income = 0;
        $offertory_income = 0;
        $tithe_income = 0;
        $Expenses_total = 0;

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
                }
                $income_Class->$month = $Other_income;
            }else{
                $income_Class->$month = '0';
            }
            
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` where  `year` = '$year' AND `month`=$indexData+1 ORDER BY `id` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            echo 'offertor'.$month;
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $offertory_income = 0;
                foreach ($result as $data) {
                    $amount_o = $data['amount'];
                    $offertory_income += $amount_o;
                }
                $Offertory_Class->$month = $offertory_income;
            }else{
                $Offertory_Class->$month = "0";
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
                }
                $tithe_Class->$month = $tithe_income;
            }else{
                $tithe_Class->$month = "0";
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
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $Ultility_total += intVal($amount);

                }
                $Ultilities_Class->$month = $Ultility_total;
            }else{
                $Ultilities_Class->$month = "0";
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
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $housing_total += intVal($amount);

                }
                $Housing_Class->$month = $housing_total;
            }else{
                $Housing_Class->$month = "0";
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
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $paycheck_total += intVal($amount);

                }
                $paycheck_Class->$month = $paycheck_total;
            }else{
                $paycheck_Class->$month = "0";
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
                foreach ($result as $data) {
                    $amount = $data['amount'];
                    $Others_total += intVal($amount);
                }
                $Others_Class->$month = $Others_total;
            }else{
                $Others_Class->$month = "0";
            }

        }
        $IncomeMain = new stdClass();
        $IncomeMain->income = $income_Class;
        $IncomeMain->offertory = $Offertory_Class;
        $IncomeMain->tithe = $tithe_Class;

        $ExpensesMain = new stdClass();
        $ExpensesMain->Ultilities =$Ultilities_Class;
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
            $stmt->bindParam('1', $id, PDO::PARAM_STR);
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

    public function Budget_list_category_filter($year, $category)
    {
        $exportData = new stdClass();
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
                    $Data = new stdClass();
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
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $Data = new stdClass();
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

            $export = " <tr class='".$category."'>
                        <td title='".$details."'>
                            <p>hover to view details</p>
                        <td>
                            <p>".$date."</p>
                        </td>
                        <td>
                            <p>".$type."</p>
                        </td>
                        <td>
                            <p>".$recorded_by."</p>
                        </td>
                        </td>
                        <td>".$amount."</td>
                        <td class='delete option'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='30'
                                viewBox='0 -960 960 960' width='48'>
                                <path
                                    d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                            </svg>
                            <div class='opt_element'>
                                <p delete_item='" . $unique_id . "' class='delete_item'>Delete item <i></i></p>
                                <p Update_item='" . $unique_id . "' class='Update_item' class='' data-information='".$ObjExport."'>Update item <i></i></p>
                            </div>
                        </td>
                    </tr>";

                $exportData .=  $export;
            }
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    public function Budget_list_categoryFilter($year,$category)
    {
        $exportData = "";
        $resultCheck = true;

        $Other_income = 0;
        $database_name = "zoe_" . $year . "_budget";
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_budget`.`$database_name` where `type` like '%$category%' ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
           
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $Data = new stdClass();
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

            $export = " <tr class='".$category."'>
                        <td title='".$details."'>
                            <p>hover to view details</p>
                        <td>
                            <p>".$date."</p>
                        </td>
                        <td>
                            <p>".$type."</p>
                        </td>
                        <td>
                            <p>".$recorded_by."</p>
                        </td>
                        </td>
                        <td>".$amount."</td>
                        <td class='delete option'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='30'
                                viewBox='0 -960 960 960' width='48'>
                                <path
                                    d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                            </svg>
                            <div class='opt_element'>
                                <p delete_item='" . $unique_id . "' class='delete_item'>Delete item <i></i></p>
                                <p Update_item='" . $unique_id . "' class='Update_item' class='' data-information='".$ObjExport."'>Update item <i></i></p>
                            </div>
                        </td>
                    </tr>";

                $exportData .=  $export;
            }
        }else{
            $Error = 'No data found with filter list conditions'.$category;
            exit(json_encode($Error));
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }


    public function Budget_list_filter($year)
    {
        $exportData = new stdClass();
        $resultCheck = true;
        $Grand_Other_income = new stdClass();
        $Grand_offertory_income = new stdClass();
        $Grand_tithe_income = new stdClass();
        $Grand_Expenses_total = new stdClass();

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

    public function Pay_list_Info($id)
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

            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$name`");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                foreach ($result as $data) {
                    $namer = $data['user'];
                    $Medium = $data['Medium'];
                    $Record_date = $data['Record_date'];
                    $amount = $data['Amount'];
                    $id = $data['user'];

                    $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$namer'");
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
                        }
                    }
                        
                            
                            $ObjectInfo = new stdClass();
                            $ObjectInfo->Formname = $name;
                            $ObjectInfo->Medium = $Medium;
                            $ObjectInfo->name = $Name;
                            $ObjectInfo->amount = $amount;
                            $ObjectInfo->date = $Record_date;
                            $ObjectInfo->id = $id;
                            $ObjectData = json_encode($ObjectInfo);
                            $amtVal = "<td class='td_action'>".$amount."<div></div></td>";

                            if(isset($_GET['amount'])){
                                if((intval($_GET['amount']) - ($amount)) <= 0){
                                    $amtVal = "<td class='td_action'> 
                                                    <div class='flex '><b>".$amount."</b>
                                                    <svg xmlns='http://www.w3.org/2000/svg' height='24px' class='success'viewBox='0 -960 960 960' width='24px' fill='#5f6368'><path d='M480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q65 0 123 19t107 53l-58 59q-38-24-81-37.5T480-800q-133 0-226.5 93.5T160-480q0 133 93.5 226.5T480-160q32 0 62-6t58-17l60 61q-41 20-86 31t-94 11Zm280-80v-120H640v-80h120v-120h80v120h120v80H840v120h-80ZM424-296 254-466l56-56 114 114 400-401 56 56-456 457Z'/></svg></div></td>
                                                ";
                                }else{
                                    $amtVal = 
                                    "<td class='td_action'>".$amount." (<b class='danger'>- ".(intval($_GET['amount']) - $amount)."</b>)<div></div></td>";
                                }
                            }

                $exportData .= "
                              <tr>
                                    <td></td>
                                    <td class='td_action'>".$Name."</td>
                                    <td class='td_action'>".$gender."</td>
                                    <td class='td_action'>".$contact."</td>
                                    ".$amtVal."
                                    <td class='td_action'>".$Medium."</td>
                                    <td class='td_action'>".$Record_date."</td>
                                    <td class='option'>
                                        <div class='delete option'>
                                            <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                                                width='30'>
                                                <path
                                                    d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                            </svg>
                                            <div class='opt_element'>
                                                <p class='update_item' Update_item='" . $id . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                                                <p class='delete_item' delete_item='" . $id . "' delete_table='".$name."'>Delete item <i></i></p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                   
                      
                ";
                        

                    

                }
              
            }else{
                $exportData = '<caption class="danger">'.$name.' has no data to display, start by adding data to this list<caption';
            }

        } else {
            $resultCheck = "jello";
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
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` ORDER BY `id` DESC limit 50");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` ORDER BY `id` DESC limit 50 OFFSET $num");
        }

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
                $date = $data['due_date'];
                $date_data = $data['date'];
                $id = $data['unique_id'];
                $purpose = $data['purpose'];
                $department = $data['department'];

                $ObjectInfo = new stdClass();
                $ObjectInfo->name = $name;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->date = $date;
                $ObjectInfo->purpose = $purpose;
                $ObjectInfo->department = $department;
                $ObjectInfo->id = $id;
                $ObjectData = json_encode($ObjectInfo);

                $exportData .= "
                
                <div class='item'>
                <div class='file'>
                <img src='../images/cfile.png' alt='' />
                </div>
                <div class='details'>
                <a href='finance/finance_event.php?data_page=$id&&amount=$amount' target='_blank' class='flex'>
                    <p class='item_name' data_item=".$date_data.">" . $name . "  - Total " . $amount . "</p>
                    <p>last modified . " . $date . "</p>
                </a>
                </div>
                <div class='delete option'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                        width='30'>
                        <path
                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                    </svg>
                    <div class='opt_element'>
                        <p Update_item='" . $id . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                        <p delete_item='" . $id . "'>Delete item <i></i></p>
                    </div>
                </div>
            </div>";
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
        $resultCheck ="";
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` ORDER BY `id` DESC limit 50");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`transaction_records` ORDER BY `id` DESC limit 50 OFFSET $num");
        }
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $account = $data['account'];
                $amount = $data['Amount'];
                $date = $data['Date'];
                $id = $data['unique_id'];
                $Status = $data['Status'];
                $category = $data['Category'];
                $Authorize = $data['Authorize'];

                $ObjectInfo = new stdClass();
                $ObjectInfo->account = $account;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->Date = $date;
                $ObjectInfo->category = $category;
                $ObjectInfo->Authorize = $Authorize;
                $ObjectInfo->Status = $Status;
                $ObjectInfo->id = $id;
                $ObjectData = json_encode($ObjectInfo);

                if($Status == 'terminated'){
                    $item = "<div class='out_btn'><div></div>".$Status."</div>";
                }else
                if($Status == 'pending'){
                    $item = "<div class='in_btn blue'><div></div>".$Status."</div>";
                }else{
                    $item = "<div class='in_btn'><div></div>".$Status."</div>";
                }

                $exportData .= "<tr>
                        <td><div class='details'>
                       
                        <div class='text'>
                        <p>".$account."</p>
                        <p>".$date."</p>
                        </div>
                        
                        </div></td>
                        <td>".$item."</td>
                        <td>".$Authorize."</td>
                        <td>".$amount."</td>
                        <td>".$category."</td>
                        <td class='option'>
                            <div class='delete option'>
                                    <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                                        width='30'>
                                        <path
                                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                    </svg>
                                    <div class='opt_element'>
                                        <p class='update_item' Update_item='" . $id . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                                        <p class='delete_item' delete_item='" . $id . "' >Delete item <i></i></p>
                                    </div>
                            </div>
                        </td>
                    </tr>";

                
            }
        } else {
            $exportData = 'Not Records Available';
        }

        if($exportData != ""){
            return $exportData;
        }else{
            return false;
        }
    }

    protected function AccountListData()
    {
        $exportData = false;
        $resultCheck ="";

        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`account_system` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $account = $data['account_name'];

                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeaccounts`.`$account` ORDER BY `id` DESC ");
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
                        
                        
                        if($category == 'expenses'){
                            $item = "<div class='out_btn'><div></div>Out</div>";
                        }else{
                            $item = "<div class='in_btn'><div></div>In</div>";
                        }
        
                        if(intval($percentage) <= 0){
                            $item_2 = "<div class='danger'>".$percentage."%</div>";
                        }else{
                            $item_2 = "<div class='success'>+ ".$percentage."%</div>";
                        }
        
                        $exportData .= "<tr>
                        <td>".$account." ".$description."</td>
                        <td>".$date."</td>
                        <td>".$item."</td>
                        <td>".$item_2."</td>
                        <td>".$amount."</td>
                        <td>".$balance."</td>
                    </tr>";
        
                        
                    }
                } else {
                    $exportData = 'Not Records Available';
                }
            }

        }

        if($exportData != ""){
            return $exportData;
        }else{
            return false;
        }
    }

    public function list_Info($num)
    {

        $year = date('Y');
        $month = 0;
        $exportData = '';
        $resultCheck = true;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` ORDER BY `year`,`month` DESC limit 50 ");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`offertory_records` ORDER BY `year`,`month` DESC limit 50 OFFSET $num");
        }
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $name = $data['event'];
                $amount = $data['amount'];
                $date = $data['date'];
                $year = $data['year'];
                $Month = $data['month'];
                $purpose = $data['purpose'];
                $id = $data['unique_id'];

                $ObjectInfo = new stdClass();
                $ObjectInfo->name = $name;
                $ObjectInfo->amount = $amount;
                $ObjectInfo->date = $date;
                $ObjectInfo->purpose = $purpose;
                $ObjectInfo->id = $id;
                $ObjectData = json_encode($ObjectInfo);

                if($month != intval($Month)){
                    $exportData .=
                    "<div class='item calender'>
                    <img src='../../images/calender/".$Month.".jpg' alt='calender year ".$Month."' />
                    </div>";
                    $month = $Month;
                }

                $exportData .= "
                
                <div class='item'>
                <div class='file'>
                <img src='../images/cfile.png' alt='' />
                </div>
                <div class='details'>
                    <p class='item_name' data_item=".$date.">" . $name . "  - Total " . $amount . "</p>
                    <p>last modified . " . $date . "</p>
                    
                </div>
                <div class='delete option'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                        width='30'>
                        <path
                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                    </svg>
                    <div class='opt_element'>
                        <p Update_item='" . $id . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                        <p delete_item='" . $id . "'>Delete item <i></i></p>
                    </div>
                </div>
            </div>
            ";

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

    public function list_Info_tithe($num)
    {
        $exportData = '';
        $resultCheck = true;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` ORDER BY `id` DESC limit 50");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` ORDER BY `id` DESC limit 50 OFFSET $num");
        }

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
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

                    $ObjectInfo = new stdClass();
                    $ObjectInfo->Name = $namer;
                    $ObjectInfo->Amount = $amount;
                    $ObjectInfo->Date = $Date;
                    $ObjectInfo->id = $namer;
                    $ObjectInfo->medium= $medium;
                    $ObjectInfo->details = $detais;
                    $ObjectData = json_encode($ObjectInfo);
    

                $exportData .= "
                        <tr>
                        <td>
                            <div class='details'>
                                <div class='text'>
                                    <p>".$Email."</p>
                                    <p>".$Date."</p>
                                </div>

                            </div>
                        </td>

                        <td>
                            <p>".$gender."</p>
                        </td>
                        <td>".$contact."</td>
                        <td>".$amount."</td>

                        <td>".$medium."</td>
                        <td class='delete option'>
                         
                    <svg xmlns='http://www.w3.org/2000/svg' height='30' viewBox='0 -960 960 960'
                        width='30'>
                        <path
                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                    </svg>
                    <div class='opt_element'>
                        <p Update_item='" . $namer . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                        <p delete_item='" . $namer . "'>Delete item <i></i></p>
                    </div>
                </td>

                    </tr>";

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

    public function list_search_tithe($name)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `name` like '%$name%' ORDER BY `date` DESC");
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
            $exportData = '<header>Not Records Available</header>';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
}