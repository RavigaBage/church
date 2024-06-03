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
    protected function Assets_upload_data($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $size, $Image, $Image_type, $Image_tmp_name, $About)
    {
        $input_list = array($Name, $Acquisition, $Value, $Items, $Location, $About, $status);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`lastname` where `name`=?");
            $stmt->bindParam('1', $Name, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = json_encode(json_encode("Data already exist"));
                $resultValidate = false;
                exit($exportData);
            } else {

                if ($Image == '') {
                    $Image = '';
                } else {
                    $explodes = explode('.', $Image);
                    $explode_end = end($explodes);
                    $Extensions = array('jpg', 'png', 'jpeg');
                    if (in_array($explode_end, $Extensions)) {
                        $types = ["image/jpg", "image/png", "image/jpeg"];
                        if (in_array($Image_type, $types)) {
                            $filename4 = time() . $Image;
                            $target4 = "../Images_folder/Assets/$filename4";
                            if (move_uploaded_file($Image_tmp_name, $target4)) {
                                $unique_id = rand(time(), 3002);
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

                if ($stmt->execute()) {

                    $unique_id = rand(time(), 1999);
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`lastname`(`unique_id`, `Name`, `Acquisition`, `Value`, `Item`, `Location`, `Image`, `About`,`Date`, `status`)VALUES (?,?,?,?,?,?,?,?,?,?)");
                    $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
                    $stmt->bindParam('2', $Name, PDO::PARAM_STR);
                    $stmt->bindParam('3', $Acquisition, PDO::PARAM_STR);
                    $stmt->bindParam('4', $Value, PDO::PARAM_STR);
                    $stmt->bindParam('5', $Items, PDO::PARAM_STR);
                    $stmt->bindParam('6', $Location, PDO::PARAM_STR);
                    $stmt->bindParam('7', $Image, PDO::PARAM_STR);
                    $stmt->bindParam('8', $About, PDO::PARAM_STR);
                    $stmt->bindParam('9', $date, PDO::PARAM_STR);
                    $stmt->bindParam('10', $status, PDO::PARAM_STR);

                    if (!$stmt->execute()) {
                        print_r($stmt->errorInfo());
                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problems');
                        exit($Error);
                    } else {
                        $exportData = json_encode('Data entry was a success');
                        $resultValidate = true;
                        exit($exportData);
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


    protected function Assets_update_data($Name, $Acquisition, $Value, $Items, $Location, $date, $status, $Image, $Image_type, $Image_tmp_name, $About, $unique_id)
    {
        $input_list = array($Name, $Acquisition, $Value, $Items, $Location, $About);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`lastname` where `unique_id`=?");
            $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = json_encode("Cannot find data");
                $resultValidate = false;
                exit($exportData);
            } else {

                if ($Image == '') {
                    $Image = '';
                } else {
                    $explodes = explode('.', $Image);
                    $explode_end = end($explodes);
                    $Extensions = array('jpg', 'png', 'jpeg');
                    if (in_array($explode_end, $Extensions)) {
                        $types = ["image/jpg", "image/png", "image/jpeg"];
                        if (in_array($Image_type, $types)) {
                            $filename4 = time() . $Image;
                            $target4 = "../Images_folder/Assets/$filename4";
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

                if ($stmt->execute()) {
                    $stmt;
                    if ($Image == '') {
                        $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`lastname` set `Name`=?, `Acquisition` =?, `Value` =?, `Item`=?, `Location`=?,`Date`=?, `status`=?,`About`=? where `unique_id` = ?");
                    } else {
                        $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`lastname` set `Name`=?, `Acquisition` =?, `Value` =?, `Item`=?, `Location`=?,`Date`=?, `status`=?, `Image` = ?,`About`=? where `unique_id` = ?");

                    }


                    $stmt->bindParam('1', $Name, PDO::PARAM_STR);
                    $stmt->bindParam('2', $Acquisition, PDO::PARAM_STR);
                    $stmt->bindParam('3', $Value, PDO::PARAM_STR);
                    $stmt->bindParam('4', $Items, PDO::PARAM_STR);
                    $stmt->bindParam('5', $Location, PDO::PARAM_STR);
                    $stmt->bindParam('6', $date, PDO::PARAM_STR);
                    $stmt->bindParam('7', $status, PDO::PARAM_STR);
                    if ($Image == '') {
                        $stmt->bindParam('8', $About, PDO::PARAM_STR);
                        $stmt->bindParam('9', $unique_id, PDO::PARAM_STR);

                    } else {
                        $stmt->bindParam('8', $Image, PDO::PARAM_STR);
                        $stmt->bindParam('9', $About, PDO::PARAM_STR);
                        $stmt->bindParam('10', $unique_id, PDO::PARAM_STR);

                    }


                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = json_encode('Update completed with errors');
                        exit($Error);
                    } else {
                        $exportData = json_encode('Data entry was a success');
                        $resultValidate = true;
                        exit($exportData);
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


    protected function Assets_delete_data($name)
    {
        $exportData = 0;
        $clean = true;
        if (empty($name)) {
            $clean = false;
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`lastname` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`lastname` where `unique_id`=?");
                    $stmt1->bindParam('1', $name, PDO::PARAM_STR);

                    if (!$stmt1->execute()) {
                        $stmt1 = null;
                        $Error = json_encode('deleting data encountered a problem');
                        exit($Error);
                    } else {
                        $exportData = json_encode('Item Deleted Successfully');
                    }
                } else {
                    $stmt = null;
                    $Error = json_encode('deleting data encountered a problem');
                    exit($Error);
                }


            } else {
                exit(json_encode('No data found !!'));
            }

        }

        return $exportData;
    }
    protected function Assets_view($num)
    {
        $exportData = '';
        $resultCheck = true;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`Lastname` ORDER BY `id` DESC limit 50");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`Lastname` ORDER BY `id` DESC limit 50 OFFSET $num");
        }
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $name = str_replace("'", " ", $data['Name']);
                $Source = str_replace("'", " ", $data['Acquisition']);
                $message = str_replace("'", " ", $data['About']);
                $value = str_replace("'", " ", $data['Value']);
                $Items = str_replace("'", " ", $data['Item']);
                $Location = str_replace("'", " ", $data['Location']);
                $Image = str_replace("'", " ", $data['Image']);
                $unique_id = str_replace("'", " ", $data['unique_id']);
                $date = str_replace("''", "", $data['Date']);
                $status = str_replace("'", " ", $data['status']);


                if (strlen($message > 72)) {
                    $message = str_split($message, 72)[0] + "....";
                }
                $DataObj = new stdClass();
                $DataObj->id = $unique_id;
                $DataObj->name = $name;
                $DataObj->source = $Source;
                $DataObj->location = $Location;
                $DataObj->total = $Items;
                $DataObj->date = $date;
                $DataObj->status = $status;
                $DataObj->value = $value;
                $DataObj->About = $message;
                $ObjectData = json_encode($DataObj);




                $exportData .= "<tr>
                           <td><div class='details'>
                        <div class='img'>
                        <img src='../API/Images_folder/Assets/" . $Image . "' alt='asset file'/>
                        </div>
                        <div class='text'>
                        <p> " . $name . "</p>
                        <p> " . $Items . "</p>
                        </div>
                        
                        </div>
                        </td>
                            <td class='td_action'> " . $Source . " </td>
                            <td class='td_action'> " . $value . " </td>
                            <td class='td_action'>Cote d'voire</td>
                            
                            <td><div class='in_btn'><div></div>Active</div></td>
                            <td class='option'>
                                <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960' width='48'>
                                    <path
                                        d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                </svg>
                                <div class='opt_element'>
                                    <p class='delete_item' data-id=" . $unique_id . ">Delete item <i></i></p>
                                    <p class='Update_item' data-id=" . $unique_id . " data-information='" . $ObjectData . "'>Update item <i></i></p>
                                </div>
                            </td>
                        </tr>";

            }
        } else {
            $resultCheck = false;
            $exportData = json_encode('No records available');
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function Asset_pages()
    {
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`assets` ORDER BY `id` DESC");
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
    protected function project_pages()
    { {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`projects` ORDER BY `id` DESC");
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
    }



    protected function projects_upload_data($Name, $description, $start_date, $end_date, $team, $status, $Image, $Image_type, $Image_tmp_name, $target, $current)
    {
        $input_list = array($Name, $description, $start_date, $team, $status, $target, $current);
        $clean = true;
        $exportData = 0;
        $resultValidate = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = json_encode('validating data encountered a problem, All fields are required !');
                $clean = false;
                exit(json_encode($input));
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`projects` where `Name`=?");
            $stmt->bindParam('1', $Name, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = json_encode("Data already exist");
                $resultValidate = false;
                exit($exportData);
            } else {

                if ($Image == '') {
                    $Image = '';
                } else {
                    $explodes = explode('.', $Image);
                    $explode_end = end($explodes);
                    $Extensions = array('jpg', 'png', 'jpeg');
                    if (in_array($explode_end, $Extensions)) {
                        $types = ["image/jpg", "image/png", "image/jpeg"];
                        if (in_array($Image_type, $types)) {
                            $filename4 = time() . $Image;
                            $target4 = "../Images_folder/$filename4";
                            if (move_uploaded_file($Image_tmp_name, $target4)) {
                                $unique_id = rand(time(), 3002);
                                $Image = $target4;
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

                if ($stmt->execute()) {
                    $unique_id = rand(time(), 1999);
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`projects`(`Name`, `description`, `start_date`, `end_date`, `team`, `status`, `Image`, `target`, `current`)VALUES (?,?,?,?,?,?,?,?,?)");
                    $stmt->bindParam('1', $Name, PDO::PARAM_STR);
                    $stmt->bindParam('2', $description, PDO::PARAM_STR);
                    $stmt->bindParam('3', $start_date, PDO::PARAM_STR);
                    $stmt->bindParam('4', $end_date, PDO::PARAM_STR);
                    $stmt->bindParam('5', $team, PDO::PARAM_STR);
                    $stmt->bindParam('6', $status, PDO::PARAM_STR);
                    $stmt->bindParam('7', $Image, PDO::PARAM_STR);
                    $stmt->bindParam('8', $target, PDO::PARAM_STR);
                    $stmt->bindParam('9', $current, PDO::PARAM_STR);

                    if (!$stmt->execute()) {
                        print_r($stmt->errorInfo());
                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problems');
                        exit($Error);
                    } else {
                        $exportData = json_encode('Data entry was a success');
                        $resultValidate = true;
                        exit($exportData);
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

    protected function projects_update_data($Name, $description, $start_date, $end_date, $team, $status, $Image, $Image_type, $Image_tmp_name, $target, $current, $id)
    {
        $input_list = array($Name, $description, $start_date, $team, $status, $target, $current);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`projects` where `Name`=?");
            $stmt->bindParam('1', $Name, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = json_encode("Data does not exist");
                $resultValidate = false;
                exit($exportData);
            } else {
                if ($Image == '') {
                    $Image = '';
                } else {
                    $explodes = explode('.', $Image);
                    $explode_end = end($explodes);
                    $Extensions = array('jpg', 'png', 'jpeg');
                    if (in_array($explode_end, $Extensions)) {
                        $types = ["image/jpg", "image/png", "image/jpeg"];
                        if (in_array($Image_type, $types)) {
                            $filename4 = time() . $Image;
                            $target4 = "../Images_folder/$filename4";
                            if (move_uploaded_file($Image_tmp_name, $target4)) {
                                $Image = $target4;
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

                if ($stmt->execute()) {
                    $stmt;
                    if ($Image == '') {
                        $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`projects` set `Name`=?, `description` =?, `start_date` =?, `end_date`=?, `team`=?, `status` = ?,`target`=?,`current`=? where `id` = ?");
                    } else {
                        $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`projects` set `Name`=?, `description` =?, `start_date` =?, `end_date`=?, `team`=?, `status` = ?,`Image`=?,`target`=?,`current`=? where `id` = ?");
                    }


                    $stmt->bindParam('1', $Name, PDO::PARAM_STR);
                    $stmt->bindParam('2', $description, PDO::PARAM_STR);
                    $stmt->bindParam('3', $start_date, PDO::PARAM_STR);
                    $stmt->bindParam('4', $end_date, PDO::PARAM_STR);
                    $stmt->bindParam('5', $team, PDO::PARAM_STR);
                    $stmt->bindParam('6', $status, PDO::PARAM_STR);
                    if ($Image == '') {
                        $stmt->bindParam('7', $target, PDO::PARAM_STR);
                        $stmt->bindParam('8', $current, PDO::PARAM_STR);
                        $stmt->bindParam('9', $id, PDO::PARAM_STR);
                    } else {
                        $stmt->bindParam('7', $Image, PDO::PARAM_STR);
                        $stmt->bindParam('8', $target, PDO::PARAM_STR);
                        $stmt->bindParam('9', $current, PDO::PARAM_STR);
                        $stmt->bindParam('10', $id, PDO::PARAM_STR);
                    }

                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problems');
                        exit($Error);
                    } else {
                        $exportData = json_encode('Data entry was a success');
                        $resultValidate = true;
                        exit($exportData);
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


    protected function projects_delete_data($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`projects` where `id` =?");
            $stmt->bindParam('1', $name, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`projects` where `id`=?");
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
    protected function projects_view($num)
    {
        $exportData = '';
        $resultCheck = true;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`projects` ORDER BY `id` DESC limit 50");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`projects` ORDER BY `id` DESC limit 50 OFFSET $num");
        }
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $name = $data['Name'];
                $description = $data['description'];
                $Start = $data['start_date'];
                $End_date = $data['end_date'];
                $Status = $data['status'];
                $Image = $data['Image'];
                $target = $data['target'];
                $current = $data['current'];
                $id = $data['id'];

                $DataObj = new stdClass();
                $DataObj->id = $id;
                $DataObj->name = $name;
                $DataObj->Start = $Start;
                $DataObj->End_date = $End_date;
                $DataObj->description = $description;
                $DataObj->Status = $Status;
                $DataObj->Image = $Image;
                $DataObj->target = $target;
                $DataObj->current = $current;
                $ObjectData = json_encode($DataObj);

                if (strlen($description > 72)) {
                    $description = str_split($description, 72)[0] + "....";
                }

                if ($Status == 'in progress') {
                    $Status = "<div class='in_btn blue'><div></div>In progress</div>";
                } else if ($Status == 'complete') {
                    $Status = "<div class='in_btn'><div></div>Completed</div>";
                } else {
                    $Status = "<div class='out_btn blue'><div></div>hold</div>";
                }

                $exportData .= " <tr>
                               <td><div class='details'>
                            <div class='img'>
                            <img src='Asset/images/" . $Image . "' alt='' />
                            </div>
                            <div class='text'>
                            <p>" . $name . "</p>
                            <p>" . $Start . "</p>
                            </div>
                            
                            </div>
                            </td>
                                <td class='td_action'>" . $current . " / " . $target . "</td>
                                <td class='td_action'>" . $description . "</td>
                                <td class='td_action'>" . $End_date . "</td>                                
                                <td>" . $Status . "</td>
                                <td class='option'>
                                    <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960' width='48'>
                                        <path
                                            d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                                    </svg>
                                    <div class='opt_element'>
                                        <p data-id='" . $id . "' class='delete_item'>Delete item <i></i></p>
                                        <p class='Update_item' data-id='" . $id . "' data-information='" . $ObjectData . "'>Update item <i></i></p>
                                    </div>
                                </td>
                            </tr>";




            }
        } else {
            $resultCheck = false;
            $exportData = json_encode('No records available');
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function GetLatestUpdate()
    {
        $num = $_SESSION['last_modified'];
        $export = '';
        $modified_SQL = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`projects` WHERE `id` > $num ORDER BY `id` ASC limit 1");
        if (!$modified_SQL->execute()) {
            $modified_SQL = null;
            $Error = json_encode('Fetching data encountered a problem');
            exit($Error);
        }
        if ($modified_SQL->rowCount() > 0) {
            $Data = $modified_SQL->fetchAll();
            $lastData = $Data[0]['id'];
            $_SESSION['last_modified'] = $lastData;
            $ObjDataClass = new stdClass();
            $ObjDataClass->id = $lastData;
            if ($num <= $lastData) {
                $subData = new stdClass();
                $name = $Data[0]['Name'];
                $description = $Data[0]['description'];
                $Start = $Data[0]['start_date'];
                $End_date = $Data[0]['end_date'];
                $Status = $Data[0]['status'];
                $Image = $Data[0]['Image'];
                $target = $Data[0]['target'];
                $current = $Data[0]['current'];
                $id = $Data[0]['id'];

                $subData->name = $name;
                $subData->description = $description;
                $subData->start = $Start;
                $subData->End_date = $End_date;
                $subData->Status = $Status;
                $subData->Image = $Image;
                $subData->target = $target;
                $subData->current = $current;
                $subData->id = $id;
                $ObjDataClass->data = $subData;
                $export = $ObjDataClass;
            } else {
                $export = false;
            }

        }

        return $export;
    }

}