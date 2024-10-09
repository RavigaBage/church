<?php
namespace Library;
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
    protected function library_upload_data($name, $author, $date, $status, $source, $category, $FILES, $REQUEST)
    {
        $input_list = array($name, $author, $date, $status, $source, $category);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` where `name`='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = json_encode("Data name already exist");
                exit($exportData);
            } else {
                $unique_id = rand(time(), 1999);
                $date_now = date('Y-m-d');
                $filepath = 'default';
                if ($FILES['upload_cover']['name'] != "") {
                    $filepath = $this->Uploader($FILES, $REQUEST);
                }
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoe_library`.`datacollections`(`unique_id`, `name`, `category`, `Source`, `Author`, `Date`, `Status`,`cover_img`,`last modified`)VALUES (?,?,?,?,?,?,?,?,?)");
                $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                $stmt->bindParam('2', $name, \PDO::PARAM_STR);
                $stmt->bindParam('3', $category, \PDO::PARAM_STR);
                $stmt->bindParam('4', $source, \PDO::PARAM_STR);
                $stmt->bindParam('5', $author, \PDO::PARAM_STR);
                $stmt->bindParam('6', $date, \PDO::PARAM_STR);
                $stmt->bindParam('7', $status, \PDO::PARAM_STR);
                $stmt->bindParam('8', $filepath, \PDO::PARAM_STR);
                $stmt->bindParam('9', $date_now, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = json_encode('Fetching data encountered a problems');
                    exit($Error);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['unique_id'];
                    $historySet = $this->history_set($namer, "library  Data Upload", $date, "library  page dashboard Admin", "User Uploaded a data");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }
                    exit(json_encode('success'));
                }
            }
        } else {
            exit(json_encode('unexpected error'));
        }

    }

    protected function library_update_data($name, $author, $date, $status, $source, $category, $unique_id, $FILES, $REQUEST)
    {
        $input_list = array($name, $author, $date, $status, $source, $category);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` where `unique_id`='$unique_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = "Error: invalid User name";
                exit($exportData);
            } else {
                if ($stmt->execute()) {
                    $date_now = date('Y-m-d');
                    if (empty($FILES['upload_cover']['name'])) {
                        $stmt = $this->data_connect()->prepare("UPDATE `zoe_library`.`datacollections` set `name`=?,`Author`=?,`date`=?,`Status`=?,`Source`=?,`category`=?,`last modified`= ? WHERE `unique_id` = ?");
                        $stmt->bindParam('1', $name, \PDO::PARAM_STR);
                        $stmt->bindParam('2', $author, \PDO::PARAM_STR);
                        $stmt->bindParam('3', $date, \PDO::PARAM_STR);
                        $stmt->bindParam('4', $status, \PDO::PARAM_STR);
                        $stmt->bindParam('5', $source, \PDO::PARAM_STR);
                        $stmt->bindParam('6', $category, \PDO::PARAM_STR);
                        $stmt->bindParam('7', $date_now, \PDO::PARAM_STR);
                        $stmt->bindParam('8', $unique_id, \PDO::PARAM_STR);
                    } else {
                        $filepath = $this->Uploader($FILES, $REQUEST);
                        $stmt = $this->data_connect()->prepare("UPDATE `zoe_library`.`datacollections` set `name`=?,`Author`=?,`date`=?,`Status`=?,`Source`=?,`category`=?,`cover_img`=?,`last modified`= ? WHERE `unique_id` = ?");
                        $stmt->bindParam('1', $name, \PDO::PARAM_STR);
                        $stmt->bindParam('2', $author, \PDO::PARAM_STR);
                        $stmt->bindParam('3', $date, \PDO::PARAM_STR);
                        $stmt->bindParam('4', $status, \PDO::PARAM_STR);
                        $stmt->bindParam('5', $source, \PDO::PARAM_STR);
                        $stmt->bindParam('6', $category, \PDO::PARAM_STR);

                        $stmt->bindParam('7', $filepath, \PDO::PARAM_STR);
                        $stmt->bindParam('8', $date_now, \PDO::PARAM_STR);
                        $stmt->bindParam('9', $unique_id, \PDO::PARAM_STR);
                    }


                    if (!$stmt->execute()) {

                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problems');
                        exit($Error);
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['unique_id'];
                        $historySet = $this->history_set($namer, "Library  Data Updated", $date, "Library  page dashboard Admin", "User Updated a data");
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
    protected function Library_filter_data($option)
    {
        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` WHERE  `category` = ? ORDER BY `id` DESC");
        $stmt->bindParam('1', $option, \PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['name']);
                $author = $this->validate($data['author']);
                $date = $this->validate($data['date']);
                $source = $this->validate($data['Source']);
                $Type = $this->validate($data['category']);
                $Period = $this->validate($data['period']);
                $unique_id = $this->validate($data['unique_id']);
                $status = $this->validate($data['status']);



                $stmt_record = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`partnership_records` where `unique_id`='$unique_id' ORDER BY `id` DESC");

                if (!$stmt_record->execute()) {
                    $stmt_record = null;
                    $Error = 'Fetching user ' . $name . ' partner records  encountered a problem';
                    exit($Error);
                }
                $objectClassRecord = new \stdClass();
                if ($stmt_record->rowCount() > 0) {
                    $result = $stmt_record->fetchAll();
                    foreach ($result as $dfile) {
                        $IndRecord = new \stdClass();
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

                $objectClass = new \stdClass();
                $ExportSend = new \stdClass();
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
            exit(json_encode('No Record available'));
        }


        return $exportData;
    }
    protected function Library_delete_data($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` where `unique_id` ='$name'");
            if (!$stmt->execute()) {

                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                /////////////////////drop table
                $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoe_library`.`datacollections` where  `unique_id`=?");
                $stmt1->bindParam('1', $name, \PDO::PARAM_STR);
                if (!$stmt1->execute()) {

                    $stmt1 = null;
                    $Error = json_encode('deleting data encountered a problem');
                    exit($Error);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['unique_id'];
                    $historySet = $this->history_set($namer, "Library  Data Upload", $date, "Library  page dashboard Admin", "User Uploaded a data");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }
                    $exportData = 'Item Deleted Successfully';
                }
            } else {
                exit(json_encode('No match for search query'));
            }

            return $exportData;

        }
    }
    protected function Library_filter_dataSearch($name, $nk)
    {
        $exportData = '';
        $num = 25 * $nk;
        $total_pages = 0;
        $stmt_pages = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`padatacollectionsWHERE  `Name` like '%$name%' ORDER BY `id` DESC");
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` WHERE  `Name` like '%$name%' ORDER BY `id` DESC limit 25 OFFSET $num");
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
                $name = $this->validate($data['name']);
                $date = $this->validate($data['Date']);
                $category = $this->validate($data['category']);
                $Author = $this->validate($data['Author']);
                $unique_id = $this->validate($data['unique_id']);
                $source = $this->validate($data['Source']);
                $status = $this->validate($data['Status']);
                $stmt_record = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`library_records` where `unique_id`='$unique_id' ORDER BY `id` DESC");

                if (!$stmt_record->execute()) {
                    $stmt_record = null;
                    $Error = 'Fetching user ' . $name . ' partner records  encountered a problem';
                    exit(json_encode($Error));
                }

                $objectClassRecord = new \stdClass();
                if ($stmt_record->rowCount() > 0) {
                    $result = $stmt_record->fetchAll();
                    foreach ($result as $dfile) {
                        $IndRecord = new \stdClass();
                        $date = $dfile['date'];
                        $filename = $dfile['filename'];
                        $id = $dfile['id'];
                        $IndRecord->UniqueId = $unique_id;
                        $IndRecord->date = $date;
                        $IndRecord->filename = $filename;
                        $IndRecord->id = $id;
                        $IdName = $unique_id . $id;
                        $objectClassRecord->$IdName = $IndRecord;

                    }
                }

                $ObjectDataIndividual = json_encode($objectClassRecord);
                $objectClass = new \stdClass();
                $ExportSend = new \stdClass();
                $objectClass->UniqueId = $unique_id;
                $objectClass->name = $name;
                $objectClass->date = $date;
                $objectClass->category = $category;
                $objectClass->Author = $Author;
                $objectClass->status = $status;
                $objectClass->source = $source;
                $ObjectData = json_encode($objectClass);

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->name = $name;
                $ExportSend->date = $date;
                $ExportSend->category = $category;
                $ExportSend->Author = $Author;
                $ExportSend->status = $status;
                $ExportSend->source = $source;
                $ExportSend->Obj = $ObjectData;
                $ExportSend->IObj = $ObjectDataIndividual;
                $ExportSendMain->$unique_id = $ExportSend;
            }
            $MainExport = new \stdClass();
            $MainExport->pages = $total_pages;
            $MainExport->result = $ExportSendMain;
            $exportData = $MainExport;
        } else {
            $exportData = 'No Record available';
        }


        return $exportData;
    }
    protected function library_filter_export()
    {
        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections`  ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['name']);
                $date = $this->validate($data['Date']);
                $category = $this->validate($data['category']);
                $Author = $this->validate($data['Author']);
                $unique_id = $this->validate($data['unique_id']);
                $source = $this->validate($data['Source']);
                $status = $this->validate($data['Status']);
                $stmt_record = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`library_records` where `unique_id`='$unique_id' ORDER BY `id` DESC");

                if (!$stmt_record->execute()) {
                    $stmt_record = null;
                    $Error = 'Fetching user ' . $name . ' partner records  encountered a problem';
                    exit(json_encode($Error));
                }

                $objectClassRecord = new \stdClass();
                if ($stmt_record->rowCount() > 0) {
                    $result = $stmt_record->fetchAll();
                    foreach ($result as $dfile) {
                        $IndRecord = new \stdClass();
                        $date = $dfile['date'];
                        $filename = $dfile['filename'];
                        $source = $dfile['source'];
                        $id = $dfile['id'];
                        $IndRecord->UniqueId = $unique_id;
                        $IndRecord->date = $date;
                        $IndRecord->filename = $filename;
                        $IndRecord->source = $source;
                        $IndRecord->id = $id;
                        $IdName = $unique_id . $id;
                        $objectClassRecord->$IdName = $IndRecord;

                    }
                }

                $ObjectDataIndividual = json_encode($objectClassRecord);
                $objectClass = new \stdClass();
                $ExportSend = new \stdClass();
                $objectClass->UniqueId = $unique_id;
                $objectClass->name = $name;
                $objectClass->date = $date;
                $objectClass->category = $category;
                $objectClass->Author = $Author;
                $objectClass->status = $status;
                $objectClass->source = $source;
                $ObjectData = json_encode($objectClass);

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->name = $name;
                $ExportSend->date = $date;
                $ExportSend->category = $category;
                $ExportSend->Author = $Author;
                $ExportSend->status = $status;
                $ExportSend->source = $source;
                $ExportSend->Obj = $ObjectData;
                $ExportSend->IObj = $ObjectDataIndividual;
                $ExportSendMain->$unique_id = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'No Records available';
        }

        return $exportData;
    }
    protected function library_view($num)
    {

        $exportData = '';
        if ($num == 0) {
            $num = 1;
        }
        $nk = ($num - 1) * 40;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` ORDER BY `id` DESC limit 40");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` ORDER BY `id` DESC limit 40 OFFSET $nk");

        }

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $name = $this->validate($data['name']);
                $date = $this->validate($data['Date']);
                $category = $this->validate($data['category']);
                $Author = $this->validate($data['Author']);
                $unique_id = $this->validate($data['unique_id']);
                $source = $this->validate($data['Source']);
                $status = $this->validate($data['Status']);
                $stmt_record = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`library_records` where `unique_id`='$unique_id' ORDER BY `id` DESC");

                if (!$stmt_record->execute()) {
                    $stmt_record = null;
                    $Error = 'Fetching user ' . $name . ' partner records  encountered a problem';
                    exit(json_encode($Error));
                }

                $objectClassRecord = new \stdClass();
                if ($stmt_record->rowCount() > 0) {
                    $result = $stmt_record->fetchAll();
                    foreach ($result as $dfile) {
                        $IndRecord = new \stdClass();
                        $date = $dfile['date'];
                        $filename = $dfile['filename'];
                        $source = $dfile['source'];
                        $id = $dfile['id'];
                        $IndRecord->UniqueId = $unique_id;
                        $IndRecord->date = $date;
                        $IndRecord->filename = $filename;
                        $IndRecord->source = $source;
                        $IndRecord->id = $id;
                        $IdName = $unique_id . $id;
                        $objectClassRecord->$IdName = $IndRecord;

                    }
                }

                $ObjectDataIndividual = json_encode($objectClassRecord);
                $objectClass = new \stdClass();
                $ExportSend = new \stdClass();
                $objectClass->UniqueId = $unique_id;
                $objectClass->name = $name;
                $objectClass->date = $date;
                $objectClass->category = $category;
                $objectClass->Author = $Author;
                $objectClass->status = $status;
                $objectClass->source = $source;
                $ObjectData = json_encode($objectClass);

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->name = $name;
                $ExportSend->date = $date;
                $ExportSend->category = $category;
                $ExportSend->Author = $Author;
                $ExportSend->status = $status;
                $ExportSend->source = $source;
                $ExportSend->Obj = $ObjectData;
                $ExportSend->IObj = $ObjectDataIndividual;
                $ExportSendMain->$unique_id = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'No Records available';
        }
        return $exportData;
    }
    protected function Library_liveUpdate_fetch($num)
    {

        if (empty($num)) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` ORDER BY `id` DESC limit 1");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` where `unique_id`='$num' ORDER BY `id` DESC limit 1");

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
                $name = $this->validate($data['name']);
                $date = $this->validate($data['Date']);
                $category = $this->validate($data['category']);
                $Author = $this->validate($data['Author']);
                $unique_id = $this->validate($data['unique_id']);
                $source = $this->validate($data['Source']);
                $status = $this->validate($data['Status']);
                $stmt_record = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`library_records` where `unique_id`='$unique_id' ORDER BY `id` DESC");

                if (!$stmt_record->execute()) {
                    $stmt_record = null;
                    $Error = 'Fetching user ' . $name . ' partner records  encountered a problem';
                    exit(json_encode($Error));
                }

                $objectClassRecord = new \stdClass();
                if ($stmt_record->rowCount() > 0) {
                    $result = $stmt_record->fetchAll();
                    foreach ($result as $dfile) {
                        $IndRecord = new \stdClass();
                        $date = $dfile['date'];
                        $filename = $dfile['filename'];
                        $source = $dfile['source'];
                        $id = $dfile['id'];
                        $IndRecord->UniqueId = $unique_id;
                        $IndRecord->date = $date;
                        $IndRecord->filename = $filename;
                        $IndRecord->source = $source;
                        $IndRecord->id = $id;
                        $IdName = $unique_id . $id;
                        $objectClassRecord->$IdName = $IndRecord;

                    }
                }

                $ObjectDataIndividual = json_encode($objectClassRecord);
                $objectClass = new \stdClass();
                $ExportSend = new \stdClass();
                $objectClass->UniqueId = $unique_id;
                $objectClass->name = $name;
                $objectClass->date = $date;
                $objectClass->category = $category;
                $objectClass->Author = $Author;
                $objectClass->status = $status;
                $objectClass->source = $source;
                $ObjectData = json_encode($objectClass);

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->name = $name;
                $ExportSend->date = $date;
                $ExportSend->category = $category;
                $ExportSend->Author = $Author;
                $ExportSend->status = $status;
                $ExportSend->source = $source;
                $ExportSend->Obj = $ObjectData;
                $ExportSend->IObj = $ObjectDataIndividual;
                $ExportSendMain->$unique_id = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'No Records available';
        }

        return $exportData;

    }
    protected function partnerPages()
    {
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` ORDER BY `id` DESC");

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        return $stmt->rowCount();

    }
    protected function Library_view_individual_record($id)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`library_records` where `id` ='$id'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            /////////////////////drop table
            $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoe_library`.`library_records` where  `id`=?");
            $stmt1->bindParam('1', $id, \PDO::PARAM_STR);
            if (!$stmt1->execute()) {
                $stmt1 = null;
                $Error = json_encode('deleting data encountered a problem');
                exit($Error);
            } else {
                $resultCheck = true;
                $exportData = 'Item Deleted Successfully';
            }
        } else {
            $resultCheck = false;
            $exportData = json_encode('Not Records Available');
        }

        return $exportData;
    }
    protected function Library_upload_data_ini($name, $date, $filename, $source)
    {
        $input_list = array($name, $date, $filename, $source);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`library_records` where `date`='$date' AND `filename`='$filename' AND `unique_id`='$name'");
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
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoe_library`.`library_records`( `unique_id`, `filename`,`source`, `date`)VALUES (?,?,?,?)");
                $stmt->bindParam('1', $name, \PDO::PARAM_STR);
                $stmt->bindParam('2', $filename, \PDO::PARAM_STR);
                $stmt->bindParam('3', $source, \PDO::PARAM_STR);
                $stmt->bindParam('4', $date, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = json_encode('Fetching data encountered a problems');
                    exit($Error);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['unique_id'];
                    $historySet = $this->history_set($namer, "Partnership  Data Upload", $date, "Partnership  page dashboard Admin", "User Uploaded a data");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }
                    exit(json_encode('Upload was a success'));
                }
            }


        }
        return $exportData;
    }

    protected function Partnership_view_individual_record_total($date)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`partnership_records` where `date` like'%$date%'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $total = 0;
            foreach ($result as $row) {
                $total += $row['amount'];
            }
            $exportData = $total;
        } else {
            $exportData = 'Not Records Available';
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

                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit(json_encode($Error));
                } else {

                    return json_encode('Success');
                }
            } else {
                exit(json_encode('Error invalid user'));
            }
        }
    }

    protected function Uploader($FILES, $REQUEST)
    {


        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");


        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            exit('The requested page does not exist');
        }


        @set_time_limit(5 * 60);
        $targetDir = '../Images_folder/library/covers/';
        //$targetDir = 'uploads';
        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds


        // Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

        // Get a file name
        if (!isset($REQUEST["user"])) {
            exit('invalid request');
        } elseif (!empty($FILES)) {
            $fileName = $FILES["upload_cover"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        // Chunking might be enabled
        $chunk = isset($REQUEST["chunk"]) ? intval($REQUEST["chunk"]) : 0;
        $chunks = isset($REQUEST["chunks"]) ? intval($REQUEST["chunks"]) : 0;


        // Remove old temp files	
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}.part") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }


        // Open temp file
        if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($FILES)) {
            if ($FILES["upload_cover"]["error"] || !is_uploaded_file($FILES["upload_cover"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($FILES["upload_cover"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        // Check if file has been uploaded
        if (!$chunks || $chunk == $chunks - 1) {
            // Strip the temp .part suffix off 
            if (rename("{$filePath}.part", $filePath)) {

                return $fileName;
            }
            ;
        }

        // Return Success JSON-RPC response
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');

    }

}
