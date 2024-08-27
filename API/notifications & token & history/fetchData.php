<?php
session_start();
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
    protected function annc_upload_data($name, $receiver, $message, $date, $file_name, $Image_type, $Image_tmp_name)
    {
        $input_list = array($name, $receiver, $message, $date);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`announcement` where `title`='$name'");
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
                $stmt = $this->data_connect()->prepare("CREATE TABLE `zoeannouncement`.`$name` (
                        `id` INT(255) AUTO_INCREMENT PRIMARY KEY,
                        `unique_id` INT(255) NOT NULL,
                        `Date` varchar(255) NOT NULL,
                        `username` varchar(255) NOT NULL,
                        `$receiver` varchar(255) NOT NULL
                    )");
                if ($stmt->execute()) {
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
                                $target4 = "../images/annc/$filename4";
                                if (move_uploaded_file($Image_tmp_name, $target4)) {
                                    $unique_id = rand(time(), 3002);
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

                    $unique_id = rand(time(), 1999);

                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`announcement`(`unique_id`, `title`, `Reciever`, `message`, `date`, `file`, `status`)
                        VALUES ('$unique_id','$name','$receiver','$message','$date','$file_name','active')");
                    if (!$stmt->execute()) {

                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problem');
                        exit($Error);
                    } else {

                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['login_details'];
                        $historySet = $this->history_set($namer, "Anncouncement Data Upload", $date, "Announcement page dashboard Admin", "User added an announcement data $name");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }
                        $exportData = json_encode('Data entry was a success Page will refresh to display new data');
                        $resultValidate = true;
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

    protected function annc_update_data($name, $receiver, $message, $date, $file_name, $Image_type, $Image_tmp_name, $unique_id)
    {
        $input_list = array($name, $receiver, $message, $date);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`announcement` where `unique_id`='$unique_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = "Data does not exist";
                $resultValidate = false;
                exit($exportData);
            } else {
                $fetchAll = $stmt->fetchAll();
                $title = $fetchAll[0]['title'];

                if ($stmt->execute()) {
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
                                $target4 = "../images/annc/$filename4";
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
                    $stmt = "";

                    $stmt = $this->data_connect()->prepare("RENAME TABLE `zoeannouncement`.`$title` TO `zoeannouncement`.`$name`");
                    if (!$stmt->execute()) {
                        print_r($stmt->errorInfo());
                        $stmt = null;
                        $Error = json_encode('Fetching data encountered w a problem');
                        exit($Error);
                    } else {
                        if ($file_name == "") {
                            $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`announcement` SET    `title`='$name', `Reciever`='$receiver', `message`='$message', `date`='$date',    `status`='active' WHERE `unique_id`='$unique_id'");
                        } else {
                            $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`announcement` SET     `title`='$name', `Reciever`='$receiver', `message`='$message', `date`='$date',     `file`='$file_name', `status`='active' WHERE `unique_id`='$unique_id'");
                        }

                        if (!$stmt->execute()) {
                            $stmt = null;
                            $Error = json_encode('Fetching data encountered a problem');
                            exit($Error);
                        } else {
                            $date = date('Y-m-d H:i:s');
                            $namer = $_SESSION['login_details'];
                            $historySet = $this->history_set($namer, "Anncouncement Data Updated", $date, "Announcement page dashboard Admin", "User Updated an announcement data $name");
                            if (json_decode($historySet) != 'Success') {
                                $exportData = 'success';
                            }
                            $exportData = 'Announcement session has been updated successfully';
                            $resultValidate = true;
                        }
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
    protected function ass_delete_data($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`announcement` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                /////////////////////drop table
                $result = $stmt->fetchAll();

                $name_1 = $result[0]['title'];
                $stmt = $this->data_connect()->prepare("DROP TABLE `zoeannouncement`.`$name_1`");
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`announcement` where    `unique_id`='$name'");

                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = 'deleting data encountered a problem';
                        exit(json_encode($Error));
                    } else {
                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['login_details'];
                        $historySet = $this->history_set($namer, "Anncouncement Data deleted", $date, "Announcement page dashboard Admin", "User deleted an announcement data $name_1");
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
                return json_encode($exportData);
            } else {
                return $resultCheck;
            }

        }
    }

    protected function annc_status_data($key, $id)
    {
        $exportData = 0;
        $input_list = array($id);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`announcement` where `unique_id` ='$id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                /////////////////////drop table
                $status = "";

                if ($key == false) {
                    $status = 'inactive';
                } else {
                    $status = 'active';
                }
                $stmt1 = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`announcement` SET `status`= '$status' where `unique_id`='$id'");
                if (!$stmt1->execute()) {
                    $stmt1 = null;
                    $Error = 'deleting data encountered a problem';
                    exit(json_encode($Error));
                } else {
                    $date = date('Y-m-d H:i:s');
                    $namer = $_SESSION['login_details'];
                    $historySet = $this->history_set($namer, "Anncouncement Data Status change", $date, "Announcement page dashboard Admin", "User changed an announcement data status");
                    if (json_decode($historySet) != 'Success') {
                        $exportData = 'success';
                    }

                    $resultCheck = true;
                    $exportData = 'Item changed Successfully';
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
    protected function annc_search($name, $nk)
    {
        $exportData = '';
        $resultCheck = true;
        $num = 25 * $nk;
        $total_pages = 0;
        $stmt_pages = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`announcement` where `title` like '%$name%' ORDER BY `date` DESC");
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`announcement` where `title` like '%$name%' ORDER BY `date` DESC limit 25 OFFSET $num");
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
            $ObjData = new stdClass();


            $date = date('Y-m-d H:i:s');
            $namer = $_SESSION['login_details'];
            $historySet = $this->history_set($namer, "Anncouncement Data search", $date, "Announcement page dashboard Admin", "User searched for announcement data $name");
            if (json_decode($historySet) != 'Success') {
                $exportData = 'success';
            }

            foreach ($result as $data) {
                $name = $data['title'];
                $receiver = $data['Reciever'];
                $message = $data['message'];
                $date = $data['date'];
                $unique_id = $data['unique_id'];
                $item = rand(time(), 1292);
                $DataName = $unique_id . $item;
                $file = $data['file'];
                $status = $data['status'];

                $DataName = new stdClass();
                $DataName->Id = $unique_id;
                $DataName->name = $name;
                $DataName->receiver = $receiver;
                $DataName->message = $message;
                $DataName->date = $date;
                $DataName->file = $file;
                $DataName->status = $status;

                $ObjData->$item = $DataName;
            }
            $MainExport = new stdClass();
            $MainExport->pages = $total_pages;
            $MainExport->result = $ObjData;
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

    protected function themeStatus($id)
    {
        $exportData = "";
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`theme` where `id`='$id'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $status = $row['status'];
                if ($status == 'active') {
                    $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`theme` SET status = 'unactive' WHERE `id`='$id'");
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encounted a problem';
                        exit($Error);
                    } else {
                        $exportData = 'success';
                    }

                } else {
                    if ($status == 'unactive') {
                        $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`theme` SET status = 'active' WHERE `id`='$id'");
                        if (!$stmt->execute()) {
                            $stmt = null;
                            $Error = 'Fetching data encounted a problem';
                            exit($Error);
                        } else {
                            $date = date('Y-m-d H:i:s');
                            $name = $_SESSION['login_details'];
                            $historySet = $this->history_set($name, "Theme status change", $date, "Appearance page dashboard Admin", "User change the Status of a theme");
                            if (json_decode($historySet) == 'Success') {
                                $exportData = 'success';
                            } else {
                                $exportData = 'success';
                            }
                        }
                    }
                }
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

    protected function annc_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`announcement` ORDER BY `date` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjData = new stdClass();
            foreach ($result as $data) {
                $name = $data['title'];
                $receiver = $data['Reciever'];
                $message = $data['message'];
                $date = $data['date'];
                $unique_id = $data['unique_id'];
                $item = rand(time(), 1292);
                $DataName = $unique_id . $item;
                $file = $data['file'];
                $status = $data['status'];

                $DataName = new stdClass();
                $DataName->Id = $unique_id;
                $DataName->name = $name;
                $DataName->receiver = $receiver;
                $DataName->message = $message;
                $DataName->date = $date;
                $DataName->file = $file;
                $DataName->status = $status;

                $ObjData->$item = $DataName;
            }
            $exportData = json_encode($ObjData);
        } else {
            $exportData = 'No Records Available';
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
            $Error = 'Fetching data encountered a problem';
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
    protected function token($pass, $new, $timer, $date)
    {
        $exportData = "";
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`permission` where `status` like '%Active%'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }
        $unique_id = rand(time(), 1999);
        $str = 'Active';
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            if ($result[0]['duration'] <= $timer) {
                $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`permission` SET `status`='Unactive' WHERE `status`='Active'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = json_encode('Fetching data encounted a problem');
                    exit($Error);
                } else {
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`permission`(`unique_id`, `Code`, `duration`, `date`, `status`) VALUES (?,?,?,?,?)");
                    $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
                    $stmt->bindParam('2', $pass, PDO::PARAM_STR);
                    $stmt->bindParam('3', $new, PDO::PARAM_STR);
                    $stmt->bindParam('4', $date, PDO::PARAM_STR);
                    $stmt->bindParam('5', $str, PDO::PARAM_STR);

                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = json_encode('Fetching data encounted a problem');
                        exit($Error);
                    } else {

                        $date = date('Y-m-d H:i:s');
                        $namer = $_SESSION['login_details'];
                        $historySet = $this->history_set($namer, "Access Data permission", $date, "Access page dashboard Admin", "User granted an access");
                        if (json_decode($historySet) != 'Success') {
                            $exportData = 'success';
                        }

                        $exportData = 'success';
                    }
                }
            }

        } else {
            $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`permission`(`unique_id`, `Code`, `duration`, `date`, `status`) VALUES (?,?,?,?,?)");
            $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
            $stmt->bindParam('2', $pass, PDO::PARAM_STR);
            $stmt->bindParam('3', $new, PDO::PARAM_STR);
            $stmt->bindParam('4', $date, PDO::PARAM_STR);
            $stmt->bindParam('5', $str, PDO::PARAM_STR);

            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encounted a problem');
                exit($Error);
            } else {
                $exportData = "success";
            }
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function tokenCheck()
    {

        $exportData = "";
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`permission` where `status` like '%Active%'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $results = $stmt->fetchAll();
            $seconds = round(microtime(true) * 1000);
            $num = $results[0]['duration'];
            $Cnt = 24 * 60 * 60 * 1000;
            if ($seconds >= ($num + $Cnt)) {
                $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`permission` set `status`='Inactive' where `status`='Active'");
                if ($stmt->execute()) {
                    $exportData = 'expired';
                } else {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit(json_encode($Error));
                }

            } else {
                $exportData = $num;
            }
        } else {
            $exportData = 'empty';

        }

        if ($resultCheck) {
            return json_encode($exportData);
        } else {
            return $resultCheck;
        }
    }

    protected function History($num)
    {
        $exportData = "";
        $resultCheck = true;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`history` ORDER BY `id` DESC limit 50");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`history` ORDER BY `id` DESC limit 50 OFFSET $num");
        }
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new stdClass();

            $date = date('Y-m-d H:i:s');
            $namer = $_SESSION['login_details'];
            $historySet = $this->history_set($namer, "History Data view", $date, "History page dashboard Admin", "User Accessed history data");
            if (json_decode($historySet) != 'Success') {
                $exportData = 'success';
            }

            foreach ($result as $data) {
                $name = $data['name'];
                $event = $data['event'];
                $date = $data['Date'];
                $sitename = $data['sitename'];
                $action = $data['action'];

                $ExportSend = new stdClass();
                $unique_id = rand(1012, time());
                $ExportSend->name = $name;
                $ExportSend->event = $event;
                $ExportSend->date = $date;
                $ExportSend->sitename = $sitename;
                $ExportSend->action = $action;
                $ExportSendMain->$unique_id = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);

        } else {
            exit(json_encode("no data found"));
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function History_pages()
    {
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`history` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }

        if ($stmt->rowCount() > 0) {
            $count = $stmt->rowCount();
            return $count;

        } else {
            return 'Error';
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