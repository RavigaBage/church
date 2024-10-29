<?php
namespace Membership;
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
            $data = strip_tags($data);
        }
        return $data;
    }
    public function cleanStringData($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    protected function member_upload_data($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $uploaded_file_names)
    {
        $input_list = array($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status);
        $clean = true;
        $exportData = 0;
        $resultValidate = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            $data = $this->cleanStringData($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                return $Error;
            }
        }
        if ($clean) {
            $uploaded_file_name = $uploaded_file_names;
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `Firstname`=? AND  `Othername`=?");
            $stmt->bindParam('1', $Firstname, \PDO::PARAM_STR);
            $stmt->bindParam('2', $Othername, \PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                return $Error;
            }
            if ($stmt->rowCount() > 0) {
                $exportData = "Data already exist";
                $resultValidate = false;
                return $exportData;
            } else {
                if ($stmt->execute()) {
                    $NewMail = strtoupper($Firstname[0]) . '' . strtolower($Othername) . '0';
                    $EmailName = strtoupper($Firstname[0]) . '' . strtolower($Othername);
                    $passwordKey = hash('sha256', $password);
                    $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `email` like '%$EmailName%' ORDER BY `id` DESC limit 1");
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encountered a problem';
                        return $Error;
                    }

                    if ($stmt->rowCount() > 0) {
                        $exportData = "Data already exist";
                        $result = $stmt->fetchAll()[0]['id'];
                        $NewMail .= strval((intval($result) + 1)) . '@zoemember.ch';
                    } else {
                        $NewMail .= '1@zoemember.ch';
                    }
                    $unique_id = rand(time(), 1999);
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`users`(`unique_id`, `Firstname`, `Othername`, `Age`, `Position`, `contact`, `email`, `password`, `image`, `Address`, `Baptism`, `membership_start`, `username`, `gender`, `occupation`, `About`,`status`)VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                    $stmt->bindParam('2', $Firstname, \PDO::PARAM_STR);
                    $stmt->bindParam('3', $Othername, \PDO::PARAM_STR);
                    $stmt->bindParam('4', $Age, \PDO::PARAM_STR);
                    $stmt->bindParam('5', $Position, \PDO::PARAM_STR);
                    $stmt->bindParam('6', $contact, \PDO::PARAM_STR);
                    $stmt->bindParam('7', $NewMail, \PDO::PARAM_STR);
                    $stmt->bindParam('8', $passwordKey, \PDO::PARAM_STR);
                    $stmt->bindParam('9', $uploaded_file_name, \PDO::PARAM_STR);
                    $stmt->bindParam('10', $Address, \PDO::PARAM_STR);
                    $stmt->bindParam('11', $Baptism, \PDO::PARAM_STR);
                    $stmt->bindParam('12', $membership_start, \PDO::PARAM_STR);
                    $stmt->bindParam('13', $username, \PDO::PARAM_STR);
                    $stmt->bindParam('14', $gender, \PDO::PARAM_STR);
                    $stmt->bindParam('15', $occupation, \PDO::PARAM_STR);
                    $stmt->bindParam('16', $About, \PDO::PARAM_STR);
                    $stmt->bindParam('17', $status, \PDO::PARAM_STR);


                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encountered a problems';
                        return $Error;
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Membership  Data Upload", $date, "Membership  page dashboard Admin", "User Uploaded a data");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }

                        $exportData = 'success';
                    }
                } else {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    return $Error;
                }

            }


        }
        return $exportData;
    }
    protected function member_update_data($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $uploaded_file_names, $unique_id)
    {
        $input_list = array($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=? ");
            $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = "error occured: user was not found";
                $resultValidate = false;
                exit($exportData);
            } else {
               
                
                if ($stmt->execute()) {
                    if (empty($uploaded_file_names)) {
                        $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`users` SET `Firstname`=?,`Othername`=?,`Age`=?,`Position`=?,`contact`=?,`email`=?,`Address`=?,`Baptism`=?,`membership_start`=?,`username`=?,`gender`=?,`occupation`=?,`About`=?,`status`=? where `unique_id` = ?");
                    } else {
                        $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`users` SET `Firstname`=?,`Othername`=?,`Age`=?,`Position`=?,`contact`=?,`email`=?,`image`=?,`Address`=?,`Baptism`=?,`membership_start`=?,`username`=?,`gender`=?,`occupation`=?,`About`=?,`status`=? where `unique_id` = ?");
                    }



                    
                    $stmt->bindParam('1', $Firstname, \PDO::PARAM_STR);
                    $stmt->bindParam('2', $Othername, \PDO::PARAM_STR);
                    $stmt->bindParam('3', $Age, \PDO::PARAM_STR);
                    $stmt->bindParam('4', $Position, \PDO::PARAM_STR);
                    $stmt->bindParam('5', $contact, \PDO::PARAM_STR);
                    $stmt->bindParam('6', $email, \PDO::PARAM_STR);
                    if (empty($uploaded_file_names)) {
                        $stmt->bindParam('7', $Address, \PDO::PARAM_STR);
                        $stmt->bindParam('8', $Baptism, \PDO::PARAM_STR);
                        $stmt->bindParam('9', $membership_start, \PDO::PARAM_STR);
                        $stmt->bindParam('10', $username, \PDO::PARAM_STR);
                        $stmt->bindParam('11', $gender, \PDO::PARAM_STR);
                        $stmt->bindParam('12', $occupation, \PDO::PARAM_STR);
                        $stmt->bindParam('13', $About, \PDO::PARAM_STR);
                        $stmt->bindParam('14', $status, \PDO::PARAM_STR);
                        $stmt->bindParam('15', $unique_id, \PDO::PARAM_STR);
                    } else {
                        $stmt->bindParam('7', $uploaded_file_names, \PDO::PARAM_STR);
                        $stmt->bindParam('8', $Address, \PDO::PARAM_STR);
                        $stmt->bindParam('9', $Baptism, \PDO::PARAM_STR);
                        $stmt->bindParam('10', $membership_start, \PDO::PARAM_STR);
                        $stmt->bindParam('11', $username, \PDO::PARAM_STR);
                        $stmt->bindParam('12', $gender, \PDO::PARAM_STR);
                        $stmt->bindParam('13', $occupation, \PDO::PARAM_STR);
                        $stmt->bindParam('14', $About, \PDO::PARAM_STR);
                        $stmt->bindParam('15', $status, \PDO::PARAM_STR);
                        $stmt->bindParam('16', $unique_id, \PDO::PARAM_STR);
                    }


                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problems');
                        exit($Error);
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Membership  Data Update", $date, "Membership  page dashboard Admin", "User Updated a data");
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

            }

        }
        return $exportData;
    }
    protected function member_delete_data($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`users` where `unique_id`=?");
                    $stmt1->bindParam('1', $name, \PDO::PARAM_STR);
                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = json_encode('deleting data encountered a problem');
                        exit($Error);
                    } else {
                        $clearance = false; {
                            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` ");
                            if (!$stmt->execute()) {
                                $stmt = null;
                                $Error = json_encode('Fetching data encountered a problem');
                                exit($Error);
                            }
                            if ($stmt->rowCount() > 0) {
                                $result = $stmt->fetchAll();
                                $name_1 = $result[0]['name'];
                                $stmt = $this->data_connect()->prepare("SELECT * FROM `zeodepartments`.`$name_1` where `unique_id`=?");
                                $stmt->bindParam('1', $name, \PDO::PARAM_STR);
                                if ($stmt->execute()) {
                                    if ($stmt->rowCount() > 0) {
                                        $stmt1 = $this->data_connect()->prepare("DELETE FROM `zeodepartments`.`$name_1` where   `unique_id`=?");
                                        $stmt1->bindParam('1', $name, \PDO::PARAM_STR);
                                        if (!$stmt1->execute()) {
                                            $stmt1 = null;
                                            $Error = json_encode('deleting data encountered a problem');
                                            exit($Error);
                                        } else {
                                            $clearance = true;
                                        }
                                    } else {
                                        $clearance = true;
                                    }
                                } else {
                                    $stmt = null;
                                    $Error = json_encode('deleting data encountered a problem');
                                    exit($Error);
                                }
                            } else {
                                $clearance = true;
                            }
                        }
                        if ($clearance = true) {
                            $date = date('Y-m-d H:i:s');
                            $namer = $_SESSION['unique_id'];
                            $historySet = $this->history_set($namer, "Membership  Data Delete", $date, "Membership  page dashboard Admin", "User Deleted a data");
                            if (json_decode($historySet) != 'Success') {
                                $exportData = 'success';
                            }

                            $resultCheck = true;
                            $exportData = 'Item Deleted Successfully';
                        } else {
                            exit('Error Occurred');
                        }
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
    protected function member_view($num)
    {
        $exportData = '';
        $nk = ($num - 1) * 40;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` ORDER BY `id` DESC limit 40");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` ORDER BY `id` DESC limit 40 OFFSET $nk");
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
                $unique_id = $this->cleanStringData($data['unique_id']);
                $Firstname = $this->cleanStringData($data['Firstname']);
                $Othername = $this->cleanStringData($data['Othername']);
                $Age = $this->cleanStringData($data['Age']);
                $Position = $this->cleanStringData($data['Position']);
                $contact = $this->cleanStringData($data['contact']);
                $email = $this->cleanStringData($data['email']);
                $image = $this->cleanStringData($data['image']);
                $Address = $this->cleanStringData($data['Address']);
                $Baptism = $this->cleanStringData($data['Baptism']);
                $membership_start = $this->cleanStringData($data['membership_start']);
                $username = $this->cleanStringData($data['username']);
                $gender = $this->cleanStringData($data['gender']);
                $occupation = $this->cleanStringData($data['occupation']);
                $About = $this->cleanStringData($data['About']);
                $status = $this->cleanStringData($data['Status']);

                $objectClass = new \stdClass();
                $ExportSend = new \stdClass();
                $objectClass->UniqueId = $unique_id;
                $objectClass->status = $status;
                $objectClass->Oname = $Firstname;
                $objectClass->Fname = $Othername;
                $objectClass->birth = $Age;
                $objectClass->Position = $Position;
                $objectClass->contact = $contact;
                $objectClass->email = $email;
                $objectClass->image = $image;
                $objectClass->location = $Address;
                $objectClass->Baptism = $Baptism;
                $objectClass->membership_start = $membership_start;
                $objectClass->username = $username;
                $objectClass->gender = $gender;
                $objectClass->occupation = $occupation;
                $objectClass->About = $About;
                $ObjectData = json_encode($objectClass);

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->status = $status;
                $ExportSend->Oname = $Firstname;
                $ExportSend->Fname = $Othername;
                $ExportSend->birth = $Age;
                $ExportSend->Position = $Position;
                $ExportSend->contact = $contact;
                $ExportSend->email = $email;
                $ExportSend->image = $image;
                $ExportSend->location = $Address;
                $ExportSend->Baptism = $Baptism;
                $ExportSend->membership_start = $membership_start;
                $ExportSend->username = $username;
                $ExportSend->gender = $gender;
                $ExportSend->occupation = $occupation;
                $ExportSend->About = $About;
                $ExportSend->Obj = $ObjectData;

                $ExportSendMain->$unique_id = json_encode($ExportSend);
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = json_encode('No Record Available');
        }


        return $exportData;

    }

    protected function member_view_position($filter)
    {
        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `Position` like '%$filter%' ORDER BY `id` DESC limit 50");

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSend = new \stdClass();
            foreach ($result as $data) {
                $ExportSendmin = new \stdClass();
                $image = $this->cleanStringData($data['image']);
                $id = rand(time(), 10002);
                $ExportSendmin->image = $image;
                $ExportSend->$id = $ExportSendmin;
            }
            $exportData = json_encode($ExportSend);
        } else {
            $exportData = json_encode('No Record Available');
        }


        return $exportData;
    }

    protected function member_view_pages()
    {
        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` ORDER BY `id` DESC");

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        $exportData = json_encode($stmt->rowCount());

        return $exportData;
    }

    protected function member_view_export()
    {
        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` ORDER BY `id` DESC");
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
            $historySet = $this->history_set($namer, "Membership  Data Export", $date, "Membership  page dashboard Admin", "User Exported a data");
            if (json_decode($historySet) != 'Success') {
                $exportData = 'success';
            }

            foreach ($result as $data) {
                $unique_id = $this->cleanStringData($data['unique_id']);
                $Firstname = $this->cleanStringData($data['Firstname']);
                $Othername = $this->cleanStringData($data['Othername']);
                $Age = $this->cleanStringData($data['Age']);
                $Position = $this->cleanStringData($data['Position']);
                $contact = $this->cleanStringData($data['contact']);
                $email = $this->cleanStringData($data['email']);
                $image = $this->cleanStringData($data['image']);
                $Address = $this->cleanStringData($data['Address']);
                $Baptism = $this->cleanStringData($data['Baptism']);
                $membership_start = $this->cleanStringData($data['membership_start']);
                $username = $this->cleanStringData($data['username']);
                $gender = $this->cleanStringData($data['gender']);
                $occupation = $this->cleanStringData($data['occupation']);
                $About = $this->cleanStringData($data['About']);
                $status = $this->cleanStringData($data['Status']);

                $ExportSend = new \stdClass();

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->status = $status;
                $ExportSend->Oname = $Firstname;
                $ExportSend->Fname = $Othername;
                $ExportSend->birth = $Age;
                $ExportSend->Position = $Position;
                $ExportSend->contact = $contact;
                $ExportSend->email = $email;
                $ExportSend->image = $image;
                $ExportSend->location = $Address;
                $ExportSend->Baptism = $Baptism;
                $ExportSend->membership_start = $membership_start;
                $ExportSend->username = $username;
                $ExportSend->gender = $gender;
                $ExportSend->occupation = $occupation;
                $ExportSend->About = $About;

                $ExportSendMain->$unique_id = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $resultCheck = false;
            $exportData = json_encode('No Record Available');
        }

        return $exportData;
    }
    protected function search_data($name, $nk)
    {
        $exportData = '';
        $num = 25 * $nk;
        $total_pages = 0;
        $stmt_pages = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` WHERE `Firstname` like ? OR `Othername` like ? ORDER BY `id` DESC");
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` WHERE `Firstname` like ? OR `Othername` like ? ORDER BY `id` DESC limit 25 OFFSET $num");
        $name = '%' . $name . '%';
        $stmt->bindParam('1', $name, \PDO::PARAM_STR);
        $stmt->bindParam('2', $name, \PDO::PARAM_STR);

        $stmt_pages->bindParam('1', $name, \PDO::PARAM_STR);
        $stmt_pages->bindParam('2', $name, \PDO::PARAM_STR);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            if ($stmt_pages->execute()) {
                $total_pages = $stmt_pages->rowCount();
            }
            $ExportSendMain = new \stdClass();
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $unique_id = $this->cleanStringData($data['unique_id']);
                $Firstname = $this->cleanStringData($data['Firstname']);
                $Othername = $this->cleanStringData($data['Othername']);
                $Age = $this->cleanStringData($data['Age']);
                $Position = $this->cleanStringData($data['Position']);
                $contact = $this->cleanStringData($data['contact']);
                $email = $this->cleanStringData($data['email']);
                $image = $this->cleanStringData($data['image']);
                $Address = $this->cleanStringData($data['Address']);
                $Baptism = $this->cleanStringData($data['Baptism']);
                $membership_start = $this->cleanStringData($data['membership_start']);
                $username = $this->cleanStringData($data['username']);
                $gender = $this->cleanStringData($data['gender']);
                $occupation = $this->cleanStringData($data['occupation']);
                $About = $this->cleanStringData($data['About']);
                $status = $this->cleanStringData($data['Status']);

                $objectClass = new \stdClass();
                $ExportSend = new \stdClass();
                $objectClass->UniqueId = $unique_id;
                $objectClass->status = $status;
                $objectClass->Oname = $Firstname;
                $objectClass->Fname = $Othername;
                $objectClass->birth = $Age;
                $objectClass->Position = $Position;
                $objectClass->contact = $contact;
                $objectClass->email = $email;
                $objectClass->image = $image;
                $objectClass->location = $Address;
                $objectClass->Baptism = $Baptism;
                $objectClass->membership_start = $membership_start;
                $objectClass->username = $username;
                $objectClass->gender = $gender;
                $objectClass->occupation = $occupation;
                $objectClass->About = $About;
                $ObjectData = json_encode($objectClass);

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->status = $status;
                $ExportSend->Oname = $Firstname;
                $ExportSend->Fname = $Othername;
                $ExportSend->birth = $Age;
                $ExportSend->Position = $Position;
                $ExportSend->contact = $contact;
                $ExportSend->email = $email;
                $ExportSend->image = $image;
                $ExportSend->location = $Address;
                $ExportSend->Baptism = $Baptism;
                $ExportSend->membership_start = $membership_start;
                $ExportSend->username = $username;
                $ExportSend->gender = $gender;
                $ExportSend->occupation = $occupation;
                $ExportSend->About = $About;
                $ExportSend->Obj = $ObjectData;

                $ExportSendMain->$unique_id = $ExportSend;
            }
            $MainExport = new \stdClass();
            $MainExport->pages = $total_pages;
            $MainExport->result = $ExportSendMain;
            $exportData = $MainExport;
        } else {
            $exportData = 'No Record Available';
        }

        return $exportData;
    }
    protected function liveUpdate_data($num)
    {
        $exportData = '';
        if (empty($num)) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` ORDER BY `id` DESC limit 1");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`='$num' ORDER BY `id` DESC limit 1");
        }
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjMainList = new \stdClass();
            foreach ($result as $data) {
                $objectClass = new \stdClass();
                $objectClass1 = new \stdClass();
                $unique_id = $this->cleanStringData($data['unique_id']);
                $Firstname = $this->cleanStringData($data['Firstname']);
                $Othername = $this->cleanStringData($data['Othername']);
                $Age = $this->cleanStringData($data['Age']);
                $Position = $this->cleanStringData($data['Position']);
                $contact = $this->cleanStringData($data['contact']);
                $email = $this->cleanStringData($data['email']);
                $image = $this->cleanStringData($data['image']);
                $Address = $this->cleanStringData($data['Address']);
                $Baptism = $this->cleanStringData($data['Baptism']);
                $membership_start = $this->cleanStringData($data['membership_start']);
                $username = $this->cleanStringData($data['username']);
                $gender = $this->cleanStringData($data['gender']);
                $occupation = $this->cleanStringData($data['occupation']);
                $About = $this->cleanStringData($data['About']);
                $status = $this->cleanStringData($data['Status']);

                $objectClass1->UniqueId = $unique_id;
                $objectClass1->Fname = $Firstname;
                $objectClass->status = $status;
                $objectClass1->Oname = $Othername;
                $objectClass1->birth = $Age;
                $objectClass1->Position = $Position;
                $objectClass1->contact = $contact;
                $objectClass1->email = $email;
                $objectClass1->image = $image;
                $objectClass1->location = $Address;
                $objectClass1->Baptism = $Baptism;
                $objectClass1->membership_start = $membership_start;
                $objectClass1->username = $username;
                $objectClass1->gender = $gender;
                $objectClass1->occupation = $occupation;
                $objectClass1->About = $About;
                $ObjectData = json_encode($objectClass1);


                $objectClass->UniqueId = $unique_id;
                $objectClass->Firstname = $Firstname;
                $objectClass->Othername = $Othername;
                $objectClass->Age = $Age;
                $objectClass->Position = $Position;
                $objectClass->contact = $contact;
                $objectClass->email = $email;
                $objectClass->image = $image;
                $objectClass->Address = $Address;
                $objectClass->Baptism = $Baptism;
                $objectClass->membership_start = $membership_start;
                $objectClass->username = $username;
                $objectClass->gender = $gender;
                $objectClass->occupation = $occupation;
                $objectClass->About = $About;
                $objectClass->Obj = $ObjectData;
                $ObjMainList->$unique_id = $objectClass;

            }
            $exportData = json_encode($ObjMainList);
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
                $Username = $this->cleanStringData($data[0]['Firstname']) . $this->cleanStringData($data[0]['Othername']);
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