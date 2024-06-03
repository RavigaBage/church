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
                    $exportData = 'Data entry was a success Page will refresh to display new data';
                    $resultValidate = true;
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
                        $exportData = 'Data entry was a success Page will refresh to display new data';
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
            foreach ($result as $data) {
                $name = $data['Name'];
                $Partnership = $data['partnership'];
                $date = $data['date'];
                $Email = $data['Email'];
                $Type = $data['partnership_type'];
                $Period = $data['period'];
                $unique_id = $data['unique_id'];
                $status = $data['status'];

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
                $objectClass->UniqueId = $unique_id;
                $objectClass->name = $name;
                $objectClass->partnership = $Partnership;
                $objectClass->date = $date;
                $objectClass->Email = $Email;
                $objectClass->Type = $Type;
                $objectClass->Period = $Period;
                $objectClass->status = $status;
                $ObjectData = json_encode($objectClass);

                if ($data['status'] == 'active') {
                    $item = "<div class='in_btn btn_record'>
                    <div></div>Active
                </div>";
                } else {
                    $item = "<div class='out_btn btn_record'>
                    <div></div>Inactive
                </div>";
                }

                $exportData .= "
                <tr>
                            <td>
                                <div class='details'>
                                    
                                    <div class='text'>
                                        <p>" . $name . "</p>
                                        <p>" . $date . "</p>
                                    </div>

                                </div>
                            </td>
                            <td class='td_action'><p>" . $Email . "</p></td>
                            <td class='td_action'><p>" . $Type . "</p></td>
                            <td class='td_action'><p>" . $Period . "</p></td>

                            <td data-information='" . $ObjectDataIndividual . "'>" . $item . "</td>
                            <td class='option'>
                                <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960' width='48'>
                                    <path
                                        d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                </svg>
                                <div class='opt_element'>
                                <p data-id=" . $unique_id . " class='delete_item'>Delete item <i></i></p>
                                <p class='Update_item' data-id=" . $unique_id . " data-information='" . $ObjectData . "'>Update item <i></i></p>
                                </div>
                            </td>
                        </tr>";

            }
        } else {
            $resultCheck = false;
            $exportData = '<header>Not Records Available</header>';
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
            foreach ($result as $data) {
                $name = $data['Name'];
                $Partnership = $data['partnership'];
                $date = $data['date'];
                $Email = $data['Email'];
                $Type = $data['partnership_type'];
                $Period = $data['period'];
                $unique_id = $data['unique_id'];
                $status = $data['status'];

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
                $objectClass->UniqueId = $unique_id;
                $objectClass->name = $name;
                $objectClass->partnership = $Partnership;
                $objectClass->date = $date;
                $objectClass->Email = $Email;
                $objectClass->Type = $Type;
                $objectClass->Period = $Period;
                $objectClass->status = $status;
                $ObjectData = json_encode($objectClass);

                if ($data['status'] == 'active') {
                    $item = "<div class='in_btn btn_record'>
                    <div></div>Active
                </div>";
                } else {
                    $item = "<div class='out_btn btn_record'>
                    <div></div>Inactive
                </div>";
                }

                $exportData .= "
                <tr>
                            <td>
                                <div class='details'>
                                    
                                    <div class='text'>
                                        <p>" . $name . "</p>
                                        <p>" . $date . "</p>
                                    </div>

                                </div>
                            </td>
                            <td class='td_action'><p>" . $Email . "</p></td>
                            <td class='td_action'><p>" . $Type . "</p></td>
                            <td class='td_action'><p>" . $Period . "</p></td>

                            <td data-information='" . $ObjectDataIndividual . "'>" . $item . "</td>
                            <td class='option'>
                                <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960' width='48'>
                                    <path
                                        d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                </svg>
                                <div class='opt_element'>
                                <p data-id=" . $unique_id . " class='delete_item'>Delete item <i></i></p>
                                <p class='Update_item' data-id=" . $unique_id . " data-information='" . $ObjectData . "'>Update item <i></i></p>
                                </div>
                            </td>
                        </tr>";

            }
        } else {
            $resultCheck = false;
            $exportData = '<header>Not Records Available</header>';
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

}