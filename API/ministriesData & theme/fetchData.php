<?php
namespace Ministry;
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
    protected function ministries_upload_data($name, $members, $manager, $about, $status, $date)
    {
        $input_list = array($name, $members, $manager, $about, $status, $date);
        $clean = true;
        $exportData = 0;
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
                    $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                    $stmt->bindParam('2', $name, \PDO::PARAM_STR);
                    $stmt->bindParam('3', $members, \PDO::PARAM_STR);
                    $stmt->bindParam('4', $manager, \PDO::PARAM_STR);
                    $stmt->bindParam('5', $about, \PDO::PARAM_STR);
                    $stmt->bindParam('6', $status, \PDO::PARAM_STR);
                    $stmt->bindParam('7', $date, \PDO::PARAM_STR);

                    if (!$stmt->execute()) {



                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problems');
                        exit($Error);
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['login_details'];
                        $historySet = $this->history_set($namer, "Ministries  Data Upload", $date, "Ministries  page dashboard Admin", "User Uploaded a data");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }

                        $exportData = 'success';
                    }
                } else {
                    $stmt = null;
                    $Error = json_encode('Fetching data encountered a problem');
                    exit($Error);
                }
            }
        }

        return $exportData;
    }

    protected function ministries_update_data($name, $members, $manager, $about, $status, $date, $unique_id)
    {
        $input_list = array($name, $members, $manager, $about, $status, $date);
        $clean = true;
        $exportData = 0;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = json_encode('validating data encountered a problem, All fields are required !');
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` where `unique_id`='$unique_id'");
            if (!$stmt->execute()) {


                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = "Error: invalid ministry name";
                exit($exportData);
            } else {
                $result = $stmt->fetchAll();
                $Oldname = $result[0]['name'];
                $clearance = true;
                if ($Oldname != $name) {
                    $clearance = false;
                }
                if (!$clearance) {
                    $stmt_table = $this->data_connect()->prepare("RENAME TABLE `zeodepartments`.`$Oldname` TO `zeodepartments`.`$name`");
                    if (!$stmt_table->execute()) {
                        $stmt_table = null;
                        $Error = json_encode('Fetching data encountered w a problem');
                        exit($Error);
                    } else {
                        $clearance = true;
                    }
                }
                if ($clearance) {
                    if ($stmt->execute()) {

                        $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`department` set `name`=?, `members` =?, `manager` =?, `About`=?, `status`=?, `Date` = ? where `unique_id` = ?");
                        $stmt->bindParam('1', $name, \PDO::PARAM_STR);
                        $stmt->bindParam('2', $members, \PDO::PARAM_STR);
                        $stmt->bindParam('3', $manager, \PDO::PARAM_STR);
                        $stmt->bindParam('4', $about, \PDO::PARAM_STR);
                        $stmt->bindParam('5', $status, \PDO::PARAM_STR);
                        $stmt->bindParam('6', $date, \PDO::PARAM_STR);
                        $stmt->bindParam('7', $unique_id, \PDO::PARAM_STR);
                        if (!$stmt->execute()) {
                            $stmt = null;
                            $Error = json_encode('Fetching data encountered a problems');
                            exit($Error);
                        } else {
                            $date = date('Y-m-d H:i:s');
                            $namer = $_SESSION['login_details'];
                            $historySet = $this->history_set($namer, "Ministries  Data Update", $date, "Ministries  page dashboard Admin", "User Updated a data");
                            if (json_decode($historySet) != 'Success') {
                                $exportData = 'success';
                            }
                            $exportData = 'Update success';
                        }
                    } else {
                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problem');
                        exit($Error);
                    }
                } else {
                    exit(json_encode('Unexpected error'));
                }
            }
        }
        return $exportData;
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
                    $stmt1->bindParam('1', $name, \PDO::PARAM_STR);

                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = json_encode('deleting data encountered a problem');
                        exit($Error);
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['login_details'];
                        $historySet = $this->history_set($namer, "Ministries  Data Delete", $date, "Ministries  page dashboard Admin", "User Deleted a data");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }

                        $exportData = 'Item Deleted Successfully';
                    }
                } else {
                    $stmt = null;
                    $Error = json_encode('deleting data encountered a problem');
                    exit($Error);
                }


            } else {
                exit('No match for search query');
            }
            return $exportData;

        }
    }
    protected function ministries_view()
    {
        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
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

                $objectClass = new \stdClass();
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
            $exportData = 'No Records Available';
        }

        return $exportData;
    }
    protected function department_list()
    {
        $exportData = 0;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department`");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encountered a problem');
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjectClass = new \stdClass();
            foreach ($result as $data) {
                $unique_id = rand(time(), 1092);
                $Name = $data['name'];
                $ObjectClass->$unique_id = $Name;
            }
            $exportData = json_encode($ObjectClass);
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
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`history`(`unique_id`, `name`, `event`, `Date`, `sitename`, `action`) VALUES (?,?,?,?,?,?)");

                $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                $stmt->bindParam('2', $Username, \PDO::PARAM_STR);
                $stmt->bindParam('3', $event, \PDO::PARAM_STR);
                $stmt->bindParam('4', $Date, \PDO::PARAM_STR);
                $stmt->bindParam('5', $sitename, \PDO::PARAM_STR);
                $stmt->bindParam('6', $action, \PDO::PARAM_STR);

                if (!$stmt->execute()) {

                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit(json_encode($Error));
                } else {
                    return json_encode('Success');
                }
            }
        }
    }
    protected function ministry_members($reciever)
    {
        $Oldname = "";
        $exportData = 0;
        $list = new \stdClass();
        if ($reciever == 'all') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users`");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $result = $stmt->fetchAll();
                    foreach ($result as $item) {
                        $uniqueId = $item['unique_id'];
                        $email = $item['email'];
                        $list->$uniqueId = $email;
                    }

                } else {
                    $stmt = null;
                    $Error = json_encode('fetching data encountered a problem');
                    exit($Error);
                }
            } else {
                $Error = json_encode('fetching data encountered a problem');
                exit($Error);
            }
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` where `unique_id`='$reciever'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = "Error: invalid ministry name";
                exit($exportData);
            } else {
                $result = $stmt->fetchAll();
                $Oldname = strtolower($result[0]['name']);
                $stmt_table = $this->data_connect()->prepare("SELECT * FROM `zeodepartments`.`$Oldname`");
                if (!$stmt_table->execute()) {
                    $stmt_table = null;
                    $Error = json_encode('Fetching data encountered w a problem');
                    exit($Error);
                }
                if ($stmt_table->rowCount() > 0) {
                    $result = $stmt_table->fetchAll();
                    foreach ($result as $item) {
                        $uniqueId = $item['unique_id'];
                        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id` ='$uniqueId'");
                        if (!$stmt->execute()) {
                            $stmt = null;
                            $Error = json_encode('Fetching data encountered a problem');
                            exit($Error);
                        }
                        if ($stmt->rowCount() > 0) {
                            if ($stmt->execute()) {
                                $result = $stmt->fetchAll();
                                $email = $result[0]['email'];
                                $list->$uniqueId = $email;
                            } else {
                                $stmt = null;
                                $Error = json_encode('fetching data encountered a problem');
                                exit($Error);
                            }
                        } else {
                            exit(json_encode('User does not exist'));
                        }
                    }
                }
            }
        }
        $exportData = $list;
        if (count(get_object_vars($list)) < 1) {
            exit(json_encode('We did not find any current user assigned to the ' . $Oldname . ' to send email to. try adding data to the ministries section'));
        } else {
            return $exportData;
        }

    }
    protected function ministry_member_view()
    {
        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` ORDER BY `Othername` DESC ");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $unique_id = $data['unique_id'];
                $Firstname = $data['Firstname'];
                $Othername = $data['Othername'];
                $image = $data['image'];
                $ExportSend = new \stdClass();

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->Oname = $Firstname;
                $ExportSend->Fname = $Othername;
                $ExportSendMain->$unique_id = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $resultCheck = false;
            $exportData = json_encode('No Record Available');
        }

        return $exportData;

    }
    protected function AddDepartmentMembers_view($unique_id, $Dp_Key)
    {
        $input_list = array($Dp_Key);
        $clean = true;
        $exportData = 0;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = json_encode('validating data encountered a problem, All fields are required !');
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            foreach ($unique_id as $name) {
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$name'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = json_encode('Fetching data encountered a problem');
                    exit($Error);
                }
                if (!$stmt->rowCount() > 0) {
                    $exportData = json_encode("An error Occured");
                    exit($exportData);
                } else {
                    $stmtResult = $stmt->fetchAll();
                    $position = $stmtResult[0]['Position'];
                    $Firstname = $stmtResult[0]['Firstname'];
                    $Othername = $stmtResult[0]['Othername'];
                    $username = $Firstname . ' ' . $Othername;
                    $date = date('YMD');
                    $stmtCheck = $this->data_connect()->prepare("SELECT * FROM `zeodepartments`.`$Dp_Key` where `unique_id`='$name'");
                    if (!$stmtCheck->execute()) {
                        $stmtCheck = null;
                        $Error = json_encode('Fetching data encountered a problem');
                        exit($Error);
                    }
                    if (!$stmtCheck->rowCount() > 0) {
                        $stmt = $this->data_connect()->prepare("INSERT INTO `zeodepartments`.`$Dp_Key` (`unique_id`, `username`, `position`, `date`) values (?,?,?,?)");
                        $stmt->bindParam('1', $name, \PDO::PARAM_STR);
                        $stmt->bindParam('2', $username, \PDO::PARAM_STR);
                        $stmt->bindParam('3', $position, \PDO::PARAM_STR);
                        $stmt->bindParam('4', $date, \PDO::PARAM_STR);
                        if ($stmt->execute()) {
                            $date = date('Y-m-d H:i:s');
                            $namer = $_SESSION['login_details'];
                            $historySet = $this->history_set($namer, "Ministries  Data Upload", $date, "Ministries  page dashboard Admin", "User Uploaded a data");
                            if (json_decode($historySet) != 'Success') {
                                $exportData = 'success';
                            }
                            $exportData = 'success';

                        } else {

                            $stmt = null;
                            $Error = json_encode('Fetching data encountered a problem');
                            exit($Error);
                        }
                    } else {
                        $exportData = 'success';
                    }
                }
            }
        }

        return $exportData;
    }
    protected function RemoveDepartmentMembers_view($unique_id, $Dp_Key)
    {
        $input_list = array($Dp_Key);
        $clean = true;
        $exportData = 0;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = json_encode('validating data encountered a problem, All fields are required !');
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            foreach ($unique_id as $name) {
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$name'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = json_encode('Fetching data encountered a problem');
                    exit($Error);
                }
                if (!$stmt->rowCount() > 0) {
                    $exportData = json_encode("An error Occured as");
                    exit($exportData);
                } else {
                    $stmtResult = $stmt->fetchAll();
                    $position = $stmtResult[0]['Position'];
                    $Firstname = $stmtResult[0]['Firstname'];
                    $Othername = $stmtResult[0]['Othername'];
                    $username = $Firstname . ' ' . $Othername;
                    $date = date('YMD');
                    $stmtCheck = $this->data_connect()->prepare("SELECT * FROM `zeodepartments`.`$Dp_Key` where `unique_id`='$name'");
                    if (!$stmtCheck->execute()) {
                        $stmtCheck = null;
                        $Error = json_encode('Fetching data encountered a problem');
                        exit($Error);
                    }
                    if ($stmtCheck->rowCount() > 0) {
                        $stmt = $this->data_connect()->prepare("DELETE  FROM `zeodepartments`.`$Dp_Key` where `unique_id`='$name'");
                        if ($stmt->execute()) {
                            $date = date('Y-m-d H:i:s');
                            $namer = $_SESSION['login_details'];
                            $historySet = $this->history_set($namer, "Ministries  Data Upload", $date, "Ministries  page dashboard Admin", "User Uploaded a data");
                            if (json_decode($historySet) != 'Success') {
                                $exportData = 'success';
                            }
                            $exportData = 'success';

                        } else {

                            $stmt = null;
                            $Error = json_encode('Fetching data encountered a problem');
                            exit($Error);
                        }
                    } else {
                        $exportData = 'No record of user';
                    }
                }
            }
        }

        return $exportData;
    }
    protected function DepartmentMembers_view($name)
    {
        $input_list = array($name);
        $clean = true;
        $exportData = 0;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = json_encode('validating data encountered a problem, All fields are required !');
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt_table = $this->data_connect()->prepare("SELECT * FROM `zeodepartments`.`$name`");
            if (!$stmt_table->execute()) {
                print_r($stmt_table->fetchAll());
                $stmt_table = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt_table->rowCount() > 0) {
                $result = $stmt_table->fetchAll();
                $exportData = new \stdClass();
                foreach ($result as $item) {
                    $list = new \stdClass();
                    $uniqueId = $item['unique_id'];
                    $position = $item['position'];
                    $username = $item['username'];
                    $list->id = $uniqueId;
                    $list->position = $position;
                    $list->username = $username;
                    $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id` ='$uniqueId'");
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problem');
                        exit($Error);
                    }
                    if ($stmt->rowCount() > 0) {
                        if ($stmt->execute()) {
                            $result = $stmt->fetchAll();
                            $image = $result[0]['image'];
                            $list->image = $image;
                        } else {
                            $stmt = null;
                            $Error = json_encode('fetching data encountered a problem');
                            exit($Error);
                        }
                    } else {
                        exit(json_encode('User does not exist'));
                    }
                    $exportData->$uniqueId = $list;
                }

            } else {
                $exportData = 'Ministry data is not available';
            }
        }

        return $exportData;
    }
}
