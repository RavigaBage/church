<?php

namespace Gallery;
// session_start();
class DBH
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';

    protected function data_connect()
    {
        try {
            $dsm = 'mysql:host=' . $this->host;
            $pdo = new \PDO($dsm, $this->user, $this->password);
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
    protected function gallery_upload_data($Event_name, $Image_name, $upload_date, $category, $Image, $Image_type, $Image_tmp_name)
    {
        $input_list = array($Event_name, $Image_name, $upload_date, $category);
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
            if (count($Image) == 0) {
                $Image = '';
            } else {
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` WHERE `EventName` = '$Event_name' AND  `name` = '$Image_name' AND  `date_uploaded`='$upload_date' AND  `category` = '$category'");
                if (!$stmt->execute()) {

                    $stmt = null;
                    $Error = json_encode('Fetching data encountered a problems');
                    exit($Error);
                } else {
                    if (!$stmt->rowCount() > 0) {
                        $total = count($Image);
                        for ($i = 0; $i < $total; $i++) {
                            $explodes = explode('.', $Image[$i]);
                            $explode_end = end($explodes);
                            $Extensions = array('jpg', 'png', 'jpeg');
                            if (in_array($explode_end, $Extensions)) {
                                $types = ["image/jpg", "image/png", "image/jpeg"];
                                if (in_array($Image_type[$i], $types)) {
                                    $filename4 = time() . $Image[$i];
                                    $Image_name = $Image_name . $filename4;
                                    $target4 = "../Images_folder/gallery/$Image_name";
                                    if (move_uploaded_file($Image_tmp_name[$i], $target4)) {
                                        $unique_id = rand(time(), 3002);
                                        $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`gallary`(`unique_id`, `EventName`, `name`, `date_uploaded`, `category`)VALUES (?,?,?,?,?)");
                                        $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                                        $stmt->bindParam('2', $Event_name, \PDO::PARAM_STR);
                                        $stmt->bindParam('3', $Image_name, \PDO::PARAM_STR);
                                        $stmt->bindParam('4', $upload_date, \PDO::PARAM_STR);
                                        $stmt->bindParam('5', $category, \PDO::PARAM_STR);
                                        if (!$stmt->execute()) {
                                            print_r($stmt->errorInfo());
                                            $stmt = null;
                                            $Error = json_encode('Fetching data encountered a problems');
                                            exit($Error);
                                        } else {
                                            $date = date('Y-m-d H:i:s');
                                            $namer = $_SESSION['login_details'];
                                            $historySet = $this->history_set($namer, "Gallery  Data Upload", $date, "Gallery  page dashboard Admin", "User Uploaded a data");
                                            if (json_decode($historySet) != 'Success') {
                                                $exportData = 'success';
                                            }

                                            exit(json_encode('Upload was a success-'));
                                        }

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
                    } else {
                        exit(json_encode('Data already exist'));
                    }
                }
            }


        }
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }

    protected function gallery_update_data($Event_name, $Image_name, $upload_date, $category, $Image, $Image_type, $Image_tmp_name, $unique_id)
    {
        $input_list = array($Event_name, $Image_name, $upload_date, $category);
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
            if ($Image == '') {
                $Image = '';
            }
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` WHERE `unique_id` = '$unique_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problems');
                exit($Error);
            } else {
                if ($stmt->rowCount() > 0) {
                    $total = count($Image);
                    if ($total == 0) {
                        for ($i = 0; $i < $total; $i++) {
                            $explodes = explode('.', $Image);
                            $explode_end = end($explodes);
                            $Extensions = array('jpg', 'png', 'jpeg');
                            if (in_array($explode_end, $Extensions)) {
                                $types = ["image/jpg", "image/png", "image/jpeg"];
                                if (in_array($Image_type, $types)) {
                                    $filename4 = time() . $Image;
                                    $Image_name = $Image_name . $filename4;
                                    $target4 = "../Images_folder/users/$Image_name";
                                    if (move_uploaded_file($Image_tmp_name, $target4)) {
                                        $Image = $filename4;
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
                    } else {
                        $total = 1;
                    }
                    $stmt = '';

                    for ($i = 0; $i < $total; $i++) {
                        if (count($Image) == 0) {
                            $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`gallary` SET `EventName`=?,`name`=?,`date_uploaded`=?,`category`=? where `unique_id` = ?");
                            $stmt->bindParam('1', $Event_name, \PDO::PARAM_STR);
                            $stmt->bindParam('2', $Image_name, \PDO::PARAM_STR);
                            $stmt->bindParam('3', $upload_date, \PDO::PARAM_STR);
                            $stmt->bindParam('4', $category, \PDO::PARAM_STR);
                            $stmt->bindParam('5', $unique_id, \PDO::PARAM_STR);
                        } else {
                            $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`gallary` SET `EventName`=?,`date_uploaded`=?,`category`=? where `unique_id` = ?");
                            $stmt->bindParam('1', $Event_name, \PDO::PARAM_STR);
                            $stmt->bindParam('2', $upload_date, \PDO::PARAM_STR);
                            $stmt->bindParam('3', $category, \PDO::PARAM_STR);
                            $stmt->bindParam('4', $unique_id, \PDO::PARAM_STR);
                        }
                        if (!$stmt->execute()) {
                            $stmt = null;
                            $Error = json_encode('Fetching data encountered a problems');
                            exit($Error);
                        } else {
                            $date = date('Y-m-d H:i:s');
                            $namer = $_SESSION['login_details'];
                            $historySet = $this->history_set($namer, "Gallery  Data Update", $date, "Gallery  page dashboard Admin", "User Updated a data");
                            if (json_decode($historySet) != 'Success') {
                                $exportData = 'success';
                            }
                            exit(json_encode('Update was a success'));
                        }
                    }
                } else {
                    exit(json_encode('Data does not exist, perphaps it has been deleted'));
                }
            }


        }
    }


    protected function gallery_delete_data($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {

                $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`gallary` where `unique_id`=?");
                $stmt1->bindParam('1', $name, \PDO::PARAM_STR);
                if (!$stmt1->execute()) {
                    $stmt1 = null;
                    $Error = json_encode('deleting data encountered a problem');
                    exit($Error);
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['login_details'];
                    $historySet = $this->history_set($namer, "Membership  Data Delete", $date, "Membership  page dashboard Admin", "User Deleted a data");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }

                    $resultCheck = true;
                    $exportData = json_encode('Item Deleted Successfully');
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
    protected function gallery_view($num)
    {
        $exportData = '';
        $resultCheck = true;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` ORDER BY `id` DESC limit 50");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` ORDER BY `id` DESC limit 50 OFFSET $num");
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
                $unique_id = $data['unique_id'];
                $Eventname = $data['Eventname'];
                $name = $data['name'];
                $date_uploaded = $data['date_uploaded'];
                $category = $data['category'];

                $objectClass = new \stdClass();
                $ExportSend = new \stdClass();
                $objectClass->UniqueId = $unique_id;
                $objectClass->Eventname = $Eventname;
                $objectClass->name = $name;
                $objectClass->date_uploaded = $date_uploaded;
                $objectClass->category = $category;
                $ObjectData = json_encode($objectClass);
                $ExportSend->UniqueId = $unique_id;
                $ExportSend->Eventname = $Eventname;
                $ExportSend->name = $name;
                $ExportSend->date_uploaded = $date_uploaded;
                $ExportSend->category = $category;
                $ExportSend->Obj = $ObjectData;

                $ExportSendMain->$unique_id = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $resultCheck = false;
            $exportData = json_encode('No Record Available');
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function gallery_view_export()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();

            $date = date('Y-m-d H:i:s');
            $namer = $_SESSION['login_details'];
            $historySet = $this->history_set($namer, "Membership  Data Export", $date, "Membership  page dashboard Admin", "User Exported a data");
            if (json_decode($historySet) != 'Success') {
                $exportData = 'success';
            }

            foreach ($result as $data) {
                $unique_id = $data['unique_id'];
                $Eventname = $data['Eventname'];
                $name = $data['name'];
                $date_uploaded = $data['date_uploaded'];
                $category = $data['category'];

                $objectClass = new \stdClass();
                $ExportSend = new \stdClass();
                $objectClass->UniqueId = $unique_id;
                $objectClass->Eventname = $Eventname;
                $objectClass->name = $name;
                $objectClass->date_uploaded = $date_uploaded;
                $objectClass->category = $category;
                $ObjectData = json_encode($objectClass);
                $ExportSend->UniqueId = $unique_id;
                $ExportSend->Eventname = $Eventname;
                $ExportSend->name = $name;
                $ExportSend->date_uploaded = $date_uploaded;
                $ExportSend->category = $category;
                $ExportSend->Obj = $ObjectData;

                $ExportSendMain->$unique_id = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $resultCheck = false;
            $exportData = json_encode('No Record Available');
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function gallery_view_sort()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` GROUP BY `Eventname` DESC");
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
                $Eventname = $data['Eventname'];
                $ExportSend = new \stdClass();
                $Naming = $unique_id . $Eventname;
                $ExportSend->Event_name = $Eventname;
                $ExportSendMain->$Naming = $ExportSend;
            }

            $exportData = json_encode($ExportSendMain);
        } else {
            $resultCheck = false;
            $exportData = json_encode('No Record Available');
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function gallery_view_sort_event($name)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` where `Eventname` = '$name' GROUP BY `id` DESC");
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
                $Eventname = $data['name'];
                $ExportSend = new \stdClass();
                $Naming = $unique_id . $Eventname;
                $ExportSend->Event_name = $Eventname;
                $ExportSendMain->$Naming = $ExportSend;
            }

            $exportData = json_encode($ExportSendMain);
        } else {
            $resultCheck = false;
            $exportData = json_encode('No Record Available');
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function search_data($name, $nk)
    {
        $exportData = '';
        $resultCheck = true;
        $num = 25 * $nk;
        $total_pages = 0;
        $stmt_pages = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` WHERE `Eventname` = ? like ? OR `category` like ? ORDER BY `id` DESC");
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` WHERE `Eventname` = ? like ? OR `category` like ? ORDER BY `id` DESC limit 25 OFFSET $num");
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
            $result = $stmt->fetchAll();
            $ObjMainList = new \stdClass();
            foreach ($result as $data) {
                $unique_id = $data['unique_id'];
                $Eventname = $data['Eventname'];
                $name = $data['name'];
                $date_uploaded = $data['date_uploaded'];
                $category = $data['category'];

                $objectClass = new \stdClass();
                $ExportSend = new \stdClass();
                $objectClass->UniqueId = $unique_id;
                $objectClass->Eventname = $Eventname;
                $objectClass->name = $name;
                $objectClass->date_uploaded = $date_uploaded;
                $objectClass->category = $category;
                $ObjectData = json_encode($objectClass);
                $ExportSend->UniqueId = $unique_id;
                $ExportSend->Eventname = $Eventname;
                $ExportSend->name = $name;
                $ExportSend->date_uploaded = $date_uploaded;
                $ExportSend->category = $category;
                $ExportSend->Obj = $ObjectData;

                $ExportSendMain->$unique_id = $ExportSend;
            }
            $MainExport = new \stdClass();
            $MainExport->pages = $total_pages;
            $MainExport->result = $ObjMainList;
            $exportData = json_encode($MainExport);
        } else {
            $resultCheck = false;
            $exportData = 'No Record Available';
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