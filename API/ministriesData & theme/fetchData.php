<?php
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
    protected function ministries_upload_data($name, $members, $manager, $about, $status, $date)
    {
        $input_list = array($name, $members, $manager, $about, $status, $date);
        $clean = true;
        $exportData = 0;
        $resultValidate = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = json_encode('validating data encountered a problem, All fields are required !');
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` where `name`='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = json_encode("Data name already exist");
                $resultValidate = false;
                exit($exportData);
            } else {
                $stmt = $this->data_connect()->prepare("CREATE TABLE `zeodepartments`.`$name` (
                        `id` INT(255) AUTO_INCREMENT PRIMARY KEY,
                        `unique_id` INT(255) NOT NULL,
                        `username` varchar(255) NOT NULL,
                        `position` varchar(255) NOT NULL,
                        `date` varchar(255) NOT NULL
                    )");
                if ($stmt->execute()) {
                    $unique_id = rand(time(), 1999);

                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`department`(`unique_id`, `name`, `members`, `manager`, `About`, `status`, `Date`)VALUES (?,?,?,?,?,?,?)");
                    $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
                    $stmt->bindParam('2', $name, PDO::PARAM_STR);
                    $stmt->bindParam('3', $members, PDO::PARAM_STR);
                    $stmt->bindParam('4', $manager, PDO::PARAM_STR);
                    $stmt->bindParam('5', $about, PDO::PARAM_STR);
                    $stmt->bindParam('6', $status, PDO::PARAM_STR);
                    $stmt->bindParam('7', $date, PDO::PARAM_STR);

                    if (!$stmt->execute()) {

                        print_r($stmt->errorInfo());

                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problems');
                        exit($Error);
                    } else {
                        $exportData = json_encode('Data entry was a success Page will refresh to display new data');
                        $resultValidate = true;
                        exit(json_encode(json_encode('Upload was a success')));
                    }
                } else {
                    $stmt = null;
                    $Error = json_encode('Fetching data encountered a problem');
                    exit($Error);
                }




            }


        }
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }

    protected function ministries_update_data($name, $members, $manager, $about, $status, $date, $unique_id)
    {
        $input_list = array($name, $members, $manager, $about, $status, $date);
        $clean = true;
        $exportData = 0;
        $resultValidate = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = json_encode('validating data encountered a problem, All fields are required !');
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` where `name`='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = "Error: invalid ministry name";
                $resultValidate = false;
                exit($exportData);
            } else {
                if ($stmt->execute()) {

                    $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`department` set `name`=?, `members` =?, `manager` =?, `About`=?, `status`=?, `Date` = ? where `unique_id` = ?");
                    $stmt->bindParam('1', $name, PDO::PARAM_STR);
                    $stmt->bindParam('2', $members, PDO::PARAM_STR);
                    $stmt->bindParam('3', $manager, PDO::PARAM_STR);
                    $stmt->bindParam('4', $about, PDO::PARAM_STR);
                    $stmt->bindParam('5', $status, PDO::PARAM_STR);
                    $stmt->bindParam('6', $date, PDO::PARAM_STR);
                    $stmt->bindParam('7', $unique_id, PDO::PARAM_STR);
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problems');
                        exit($Error);
                    } else {
                        $exportData = json_encode('Data entry was a success Page will refresh to display new data');
                        $resultValidate = true;
                        exit(json_encode('Upload was a success'));
                    }
                } else {
                    $stmt = null;
                    $Error = json_encode('Fetching data encountered a problem');
                    exit($Error);
                }




            }


        }
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }

    protected function ministries_delete_data($name)
    {
        $exportData = 0;
        $input_list = array($name);
        $clean = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = json_encode('validating data encountered a problem, All fields are required !');
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                /////////////////////drop table
                $result = $stmt->fetchAll();

                $name_1 = $result[0]['name'];
                $stmt = $this->data_connect()->prepare("DROP TABLE `zeodepartments`.`$name_1`");
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`department` where   `unique_id`=?");
                    $stmt1->bindParam('1', $name, PDO::PARAM_STR);

                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = json_encode('deleting data encountered a problem');
                        exit($Error);
                    } else {
                        $resultCheck = true;
                        $exportData = json_encode('Item Deleted Successfully');
                    }
                } else {
                    $stmt = null;
                    $Error = json_encode('deleting data encountered a problem');
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
    protected function ministries_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new stdClass();
            foreach ($result as $data) {
                $name = $data['name'];
                $members = $data['members'];
                $manager = $data['manager'];
                $message = $data['About'];
                $date = $data['Date'];
                $status = $data['status'];
                $unique_id = $data['unique_id'];
                if (strlen($message) > 100) {
                    $message = substr($message, 0, 100) . "....";
                }

                $objectClass = new stdClass();
                $ExportSend = "";
                $objectClass->UniqueId = $unique_id;
                $objectClass->name = $name;
                $objectClass->members = $members;
                $objectClass->about = $message;
                $objectClass->date = $date;
                $objectClass->manager = $manager;
                $objectClass->status = $status;
                $ExportSend = $objectClass;
                $ObjectData = json_encode($objectClass);
                $ExportSend->Obj = $ObjectData;

                $ExportSendMain->$unique_id = $ExportSend;

            }
            $exportData = json_encode($ExportSendMain);
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
    protected function department_list()
    {
        $exportData = 0;
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department`");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encountered a problem');
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $item = '';
            foreach ($result as $data) {
                $Name = $data['name'];
                $item .= '<option>' . $Name . '</option>';
            }
            $exportData = $item;
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
}