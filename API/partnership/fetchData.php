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
    protected function Partnership_upload_data($name, $partnership, $date, $status, $email, $type, $period)
    {
        $input_list = array($name, $partnership, $date, $status, $email, $type, $period);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership` where `name`='$name'");
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
                $unique_id = rand(time(), 1999);

                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`partnership`(`unique_id`, `Name`, `partnership`, `date`, `status`, `Email`, `partnership_type`, `period`)VALUES (?,?,?,?,?,?,?,?)");
                $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
                $stmt->bindParam('2', $name, PDO::PARAM_STR);
                $stmt->bindParam('3', $partnership, PDO::PARAM_STR);
                $stmt->bindParam('4', $date, PDO::PARAM_STR);
                $stmt->bindParam('5', $status, PDO::PARAM_STR);
                $stmt->bindParam('6', $email, PDO::PARAM_STR);
                $stmt->bindParam('7', $type, PDO::PARAM_STR);
                $stmt->bindParam('8', $period, PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = json_encode('Fetching data encountered a problems');
                    exit($Error);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['login_details'];
                    $historySet = $this->history_set($namer, "Partnership  Data Upload", $date, "Partnership  page dashboard Admin", "User Uploaded a data");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }
                    exit(json_encode('Upload was a success'));
                }
            }


        }
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }

    protected function Partnership_update_data($name, $partnership, $date, $status, $email, $type, $period, $unique_id)
    {
        $input_list = array($name, $partnership, $date, $status, $email, $type, $period);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership` where `unique_id`='$unique_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = "Error: invalid User name";
                $resultValidate = false;
                exit($exportData);
            } else {
                if ($stmt->execute()) {
                    $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`partnership` set  `Name`=?,`partnership`=?,`date`=?,`status`=?,`Email`=?,`partnership_type`=?,`period`=? where `unique_id` = ?");
                    $stmt->bindParam('1', $name, PDO::PARAM_STR);
                    $stmt->bindParam('2', $partnership, PDO::PARAM_STR);
                    $stmt->bindParam('3', $date, PDO::PARAM_STR);
                    $stmt->bindParam('4', $status, PDO::PARAM_STR);
                    $stmt->bindParam('5', $email, PDO::PARAM_STR);
                    $stmt->bindParam('6', $type, PDO::PARAM_STR);
                    $stmt->bindParam('7', $period, PDO::PARAM_STR);
                    $stmt->bindParam('8', $unique_id, PDO::PARAM_STR);
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problems');
                        exit($Error);
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['login_details'];
                        $historySet = $this->history_set($namer, "Partnership  Data Updated", $date, "Partnership  page dashboard Admin", "User Updated a data");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }

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
    protected function Partnership_filter_data($option)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership` WHERE  `partnership_type` = ? ORDER BY `id` DESC");
        $option = "Children ministry";
        $stmt->bindParam('1', $option, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['Name']);
                $Partnership = $this->validate($data['partnership']);
                $date = $this->validate($data['date']);
                $Email = $this->validate($data['Email']);
                $Type = $this->validate($data['partnership_type']);
                $Period = $this->validate($data['period']);
                $unique_id = $this->validate($data['unique_id']);
                $status = $this->validate($data['status']);



                $stmt_record = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership_records` where `unique_id`='$unique_id' ORDER BY `id` DESC");

                if (!$stmt_record->execute()) {
                    $stmt_record = null;
                    $Error = 'Fetching user ' . $name . ' partner records  encountered a problem';
                    exit($Error);
                }
                $objectClassRecord = new stdClass();
                if ($stmt_record->rowCount() > 0) {
                    $result = $stmt_record->fetchAll();
                    foreach ($result as $dfile) {
                        $IndRecord = new stdClass();
                        $date = $dfile['date'];
                        $amount = $dfile['amount'];
                        $id = $dfile['id'];
                        $IndRecord->UniqueId = $unique_id;
                        $IndRecord->date = $date;
                        $IndRecord->Amount = $amount;
                        $IndRecord->id = $id;

                        $objectClassRecord->$date = $IndRecord;

                    }
                }

                $ObjectDataIndividual = json_encode($objectClassRecord);

                $objectClass = new stdClass();
                $ExportSend = new stdClass();
                $objectClass->UniqueId = $unique_id;
                $objectClass->name = $name;
                $objectClass->partnership = $Partnership;
                $objectClass->date = $date;
                $objectClass->Email = $Email;
                $objectClass->Type = $Type;
                $objectClass->Period = $Period;
                $objectClass->status = $status;
                $ObjectData = json_encode($objectClass);

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->name = $name;
                $ExportSend->partnership = $Partnership;
                $ExportSend->date = $date;
                $ExportSend->Email = $Email;
                $ExportSend->Type = $Type;
                $ExportSend->Period = $Period;
                $ExportSend->status = $status;
                $ExportSend->Obj = $ObjectData;
                $ExportSend->IObj = $ObjectDataIndividual;
                $ExportSendMain->$unique_id = $ExportSend;

            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $resultCheck = false;
            $exportData = 'No Record available';
        }


        return $exportData;
    }
    protected function Partnership_delete_data($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                /////////////////////drop table
                $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`partnership` where   `unique_id`=?");
                $stmt1->bindParam('1', $name, PDO::PARAM_STR);
                if (!$stmt1->execute()) {
                    $stmt1 = null;
                    $Error = json_encode('deleting data encountered a problem');
                    exit($Error);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['login_details'];
                    $historySet = $this->history_set($namer, "Partnership  Data Upload", $date, "Partnership  page dashboard Admin", "User Uploaded a data");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }

                    $resultCheck = true;
                    $exportData = json_encode('Item Deleted Successfully');
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

    protected function Partnership_filter_dataSearch($name, $nk)
    {
        $exportData = '';
        $resultCheck = true;
        $num = 25 * $nk;
        $total_pages = 0;
        $stmt_pages = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership` WHERE  `Name` like '%$name%' ORDER BY `id` DESC");
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership` WHERE  `Name` like '%$name%' ORDER BY `id` DESC limit 25 OFFSET $num");
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
            $ExportSendMain = new stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['Name']);
                $Partnership = $this->validate($data['partnership']);
                $date = $this->validate($data['date']);
                $Email = $this->validate($data['Email']);
                $Type = $this->validate($data['partnership_type']);
                $Period = $this->validate($data['period']);
                $unique_id = $this->validate($data['unique_id']);
                $status = $this->validate($data['status']);

                $stmt_record = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership_records` where `unique_id`='$unique_id' ORDER BY `id` DESC");

                if (!$stmt_record->execute()) {
                    $stmt_record = null;
                    $Error = 'Fetching user ' . $name . ' partner records  encountered a problem';
                    exit($Error);
                }
                $objectClassRecord = new stdClass();
                if ($stmt_record->rowCount() > 0) {
                    $result = $stmt_record->fetchAll();
                    foreach ($result as $dfile) {
                        $IndRecord = new stdClass();
                        $date = $dfile['date'];
                        $amount = $dfile['amount'];
                        $id = $dfile['id'];
                        $IndRecord->UniqueId = $unique_id;
                        $IndRecord->date = $date;
                        $IndRecord->Amount = $amount;
                        $IndRecord->id = $id;

                        $objectClassRecord->$date = $IndRecord;

                    }
                }

                $ObjectDataIndividual = json_encode($objectClassRecord);

                $objectClass = new stdClass();
                $ExportSend = new stdClass();
                $objectClass->UniqueId = $unique_id;
                $objectClass->name = $name;
                $objectClass->partnership = $Partnership;
                $objectClass->date = $date;
                $objectClass->Email = $Email;
                $objectClass->Type = $Type;
                $objectClass->Period = $Period;
                $objectClass->status = $status;
                $ObjectData = json_encode($objectClass);

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->name = $name;
                $ExportSend->partnership = $Partnership;
                $ExportSend->date = $date;
                $ExportSend->Email = $Email;
                $ExportSend->Type = $Type;
                $ExportSend->Period = $Period;
                $ExportSend->status = $status;
                $ExportSend->Obj = $ObjectData;
                $ExportSend->IObj = $ObjectDataIndividual;
                $ExportSendMain->$unique_id = $ExportSend;

            }
            $MainExport = new stdClass();
            $MainExport->pages = $total_pages;
            $MainExport->result = $ExportSendMain;
            $exportData = json_encode($MainExport);
        } else {
            $resultCheck = false;
            $exportData = 'No Record available';
        }


        return $exportData;
    }
    protected function Partnership_filter_export()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership`  ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['Name']);
                $Partnership = $this->validate($data['partnership']);
                $date = $this->validate($data['date']);
                $Email = $this->validate($data['Email']);
                $Type = $this->validate($data['partnership_type']);
                $Period = $this->validate($data['period']);
                $unique_id = $this->validate($data['unique_id']);
                $status = $this->validate($data['status']);
                $ExportSend = new stdClass();

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->name = $name;
                $ExportSend->partnership = $Partnership;
                $ExportSend->date = $date;
                $ExportSend->Email = $Email;
                $ExportSend->Type = $Type;
                $ExportSend->Period = $Period;
                $ExportSend->status = $status;
                $ExportSendMain->$unique_id = $ExportSend;

            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $resultCheck = false;
            $exportData = 'No Record available';
        }


        return $exportData;
    }

    protected function Partnership_view()
    {

        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership` ORDER BY `id` DESC");

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['Name']);
                $Partnership = $this->validate($data['partnership']);
                $date = $this->validate($data['date']);
                $Email = $this->validate($data['Email']);
                $Type = $this->validate($data['partnership_type']);
                $Period = $this->validate($data['period']);
                $unique_id = $this->validate($data['unique_id']);
                $status = $this->validate($data['status']);

                $stmt_record = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership_records` where `unique_id`='$unique_id' ORDER BY `id` DESC");

                if (!$stmt_record->execute()) {
                    $stmt_record = null;
                    $Error = 'Fetching user ' . $name . ' partner records  encountered a problem';
                    exit($Error);
                }
                $objectClassRecord = new stdClass();
                if ($stmt_record->rowCount() > 0) {
                    $result = $stmt_record->fetchAll();
                    foreach ($result as $dfile) {
                        $IndRecord = new stdClass();
                        $date = $dfile['date'];
                        $amount = $dfile['amount'];
                        $id = $dfile['id'];
                        $IndRecord->UniqueId = $unique_id;
                        $IndRecord->date = $date;
                        $IndRecord->Amount = $amount;
                        $IndRecord->id = $id;

                        $objectClassRecord->$date = $IndRecord;

                    }
                }

                $ObjectDataIndividual = json_encode($objectClassRecord);

                $objectClass = new stdClass();
                $ExportSend = new stdClass();
                $objectClass->UniqueId = $unique_id;
                $objectClass->name = $name;
                $objectClass->partnership = $Partnership;
                $objectClass->date = $date;
                $objectClass->Email = $Email;
                $objectClass->Type = $Type;
                $objectClass->Period = $Period;
                $objectClass->status = $status;
                $ObjectData = json_encode($objectClass);

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->name = $name;
                $ExportSend->partnership = $Partnership;
                $ExportSend->date = $date;
                $ExportSend->Email = $Email;
                $ExportSend->Type = $Type;
                $ExportSend->Period = $Period;
                $ExportSend->status = $status;
                $ExportSend->Obj = $ObjectData;
                $ExportSend->IObj = $ObjectDataIndividual;
                $ExportSendMain->$unique_id = $ExportSend;

            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $resultCheck = false;
            $exportData = 'No Record available';
        }


        return $exportData;

    }

    protected function Partnership_view_individual_record($id)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`partnership_records` where `id` ='$id'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            /////////////////////drop table
            $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`partnership_records` where  `id`=?");
            $stmt1->bindParam('1', $id, PDO::PARAM_STR);
            if (!$stmt1->execute()) {
                $stmt1 = null;
                $Error = json_encode('deleting data encountered a problem');
                exit($Error);
            } else {
                $resultCheck = true;
                $exportData = json_encode('Item Deleted Successfully');
            }
        } else {
            $resultCheck = false;
            $exportData = json_encode('Not Records Available');
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


}