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
    protected function member_upload_data($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $Image, $Image_type, $Image_tmp_name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `Firstname`=? AND  `Othername`=?");
            $stmt->bindParam('1', $Firstname, PDO::PARAM_STR);
            $stmt->bindParam('2', $Othername, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                print_r($stmt->errorInfo());
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = "Data already exist";
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
                            $target4 = "../Images_folder/users/$filename4";
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
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`users`(`unique_id`, `Firstname`, `Othername`, `Age`, `Position`, `contact`, `email`, `password`, `image`, `Address`, `Baptism`, `membership_start`, `username`, `gender`, `occupation`, `About`,`status`)VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
                    $stmt->bindParam('2', $Firstname, PDO::PARAM_STR);
                    $stmt->bindParam('3', $Othername, PDO::PARAM_STR);
                    $stmt->bindParam('4', $Age, PDO::PARAM_STR);
                    $stmt->bindParam('5', $Position, PDO::PARAM_STR);
                    $stmt->bindParam('6', $contact, PDO::PARAM_STR);
                    $stmt->bindParam('7', $email, PDO::PARAM_STR);
                    $stmt->bindParam('8', $password, PDO::PARAM_STR);
                    $stmt->bindParam('9', $Image, PDO::PARAM_STR);
                    $stmt->bindParam('10', $Address, PDO::PARAM_STR);
                    $stmt->bindParam('11', $Baptism, PDO::PARAM_STR);
                    $stmt->bindParam('12', $membership_start, PDO::PARAM_STR);
                    $stmt->bindParam('13', $username, PDO::PARAM_STR);
                    $stmt->bindParam('14', $gender, PDO::PARAM_STR);
                    $stmt->bindParam('15', $occupation, PDO::PARAM_STR);
                    $stmt->bindParam('16', $About, PDO::PARAM_STR);
                    $stmt->bindParam('17', $status, PDO::PARAM_STR);


                    if (!$stmt->execute()) {

                        print_r($stmt->errorInfo());

                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problems');
                        exit($Error);
                    } else {
                        $exportData = 'Data entry was a success Page will refresh to display new data';
                        $resultValidate = true;
                        exit(json_encode('Upload was a success-'));
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

    protected function member_update_data($Firstname, $Othername, $Age, $Position, $contact, $email, $password, $Address, $Baptism, $membership_start, $username, $gender, $occupation, $About, $status, $Image, $Image_type, $Image_tmp_name, $unique_id)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `Firstname`=? AND `Othername`=?");
            $stmt->bindParam('1', $Firstname, PDO::PARAM_STR);
            $stmt->bindParam('2', $Othername, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = "Data already exist";
                $resultValidate = false;
                exit($exportData);
            } else {

                if ($Image == '') {
                    $Image = '';
                    $pass = false;
                } else {
                    $explodes = explode('.', $Image);
                    $explode_end = end($explodes);
                    $Extensions = array('jpg', 'png', 'jpeg');
                    if (in_array($explode_end, $Extensions)) {
                        $types = ["image/jpg", "image/png", "image/jpeg"];
                        if (in_array($Image_type, $types)) {
                            $filename4 = time() . $Image;
                            $target4 = "../Images_folder/users/$filename4";
                            if (move_uploaded_file($Image_tmp_name, $target4)) {
                                $Image = $filename4;
                                $pass = true;
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
                        $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`users` SET `Firstname`=?,`Othername`=?,`Age`=?,`Position`=?,`contact`=?,`email`=?,`password`=?,`Address`=?,`Baptism`=?,`membership_start`=?,`username`=?,`gender`=?,`occupation`=?,`About`=?,`status`=? where `unique_id` = ?");
                    } else {
                        $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`users` SET `Firstname`=?,`Othername`=?,`Age`=?,`Position`=?,`contact`=?,`email`=?,`password`=?,`image`=?,`Address`=?,`Baptism`=?,`membership_start`=?,`username`=?,`gender`=?,`occupation`=?,`About`=?,`status`=? where `unique_id` = ?");
                    }



                    $stmt->bindParam('1', $Firstname, PDO::PARAM_STR);
                    $stmt->bindParam('2', $Othername, PDO::PARAM_STR);
                    $stmt->bindParam('3', $Age, PDO::PARAM_STR);
                    $stmt->bindParam('4', $Position, PDO::PARAM_STR);
                    $stmt->bindParam('5', $contact, PDO::PARAM_STR);
                    $stmt->bindParam('6', $email, PDO::PARAM_STR);
                    $stmt->bindParam('7', $password, PDO::PARAM_STR);
                    if ($Image == '') {
                        $stmt->bindParam('8', $Address, PDO::PARAM_STR);
                        $stmt->bindParam('9', $Baptism, PDO::PARAM_STR);
                        $stmt->bindParam('10', $membership_start, PDO::PARAM_STR);
                        $stmt->bindParam('11', $username, PDO::PARAM_STR);
                        $stmt->bindParam('12', $gender, PDO::PARAM_STR);
                        $stmt->bindParam('13', $occupation, PDO::PARAM_STR);
                        $stmt->bindParam('14', $About, PDO::PARAM_STR);
                        $stmt->bindParam('15', $status, PDO::PARAM_STR);
                        $stmt->bindParam('16', $unique_id, PDO::PARAM_STR);
                    } else {
                        $stmt->bindParam('8', $image, PDO::PARAM_STR);
                        $stmt->bindParam('9', $Address, PDO::PARAM_STR);
                        $stmt->bindParam('10', $Baptism, PDO::PARAM_STR);
                        $stmt->bindParam('11', $membership_start, PDO::PARAM_STR);
                        $stmt->bindParam('12', $username, PDO::PARAM_STR);
                        $stmt->bindParam('13', $gender, PDO::PARAM_STR);
                        $stmt->bindParam('14', $occupation, PDO::PARAM_STR);
                        $stmt->bindParam('15', $About, PDO::PARAM_STR);
                        $stmt->bindParam('16', $status, PDO::PARAM_STR);
                        $stmt->bindParam('17', $unique_id, PDO::PARAM_STR);
                    }


                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = json_encode('Fetching data encountered a problems');
                        exit($Error);
                    } else {
                        $exportData = 'Data entry was a success Page will refresh to display new data';
                        $resultValidate = true;
                        exit(json_encode('Upload was a success--'));
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
    protected function member_view($num)
    {
        $exportData = '';
        $resultCheck = true;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` ORDER BY `id` DESC limit 50");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` ORDER BY `id` DESC limit 50 OFFSET $num");
        }

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $unique_id = $data['unique_id'];
                $Firstname = $data['Firstname'];
                $Othername = $data['Othername'];
                $Age = $data['Age'];
                $Position = $data['Position'];
                $contact = $data['contact'];
                $email = $data['email'];
                $image = $data['image'];
                $Address = $data['Address'];
                $Baptism = $data['Baptism'];
                $membership_start = $data['membership_start'];
                $username = $data['username'];
                $gender = $data['gender'];
                $occupation = $data['occupation'];
                $About = $data['About'];
                $status = $data['Status'];

                $objectClass = new stdClass();
                $objectClass->UniqueId = $unique_id;
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
                if ($status == 'active') {
                    $status = '<div class="in_btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="green"><path d="M200-120v-680h360l16 80h224v400H520l-16-80H280v280h-80Zm300-440Zm86 160h134v-240H510l-16-80H280v240h290l16 80Z"/></svg>
                    active</div>';
                } else {
                    $status = '<div class="out_btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="red"><path d="M200-120v-680h360l16 80h224v400H520l-16-80H280v280h-80Zm300-440Zm86 160h134v-240H510l-16-80H280v240h290l16 80Z"/></svg>
                    Inactive</div>';
                }
                $exportData .=
                    "<tr>
                <td><div class='details'>
<div class='img'>
<img src='../API/Images_folder/users/" . $image . "' alt='' />
</div>
<div class='text'>
<p>" . $email . "</p>
<p>" . $Firstname ."  ". $Othername . "</p>
</div>

</div></td>
                <td class='td_action'><div class='table_center'><p>" . $Age . "</p></div></td>
                <td class='td_action'><div class='table_center'><p>" . $gender . "</p></div></td>
                <td class='td_action'><div class='table_center'><p>" . $Address . "</p></div></td>
                <td class='td_action'><div class='table_center'><p>" . $Baptism . "</p></div></td>
                <td class='td_action'><div class='table_center'><p>" . $occupation . "</p></div></td>
                
                <td><div class='table_center'><p>" . $status . "</p></div></td>

                <td class='option' style='width:100%;display:grid;place-items:center;'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='48' viewBox='0 -960 960 960'
                        width='48'>
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

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function search_data($name)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` WHERE `Firstname` like ? OR `Othername` like ? ORDER BY `id` DESC");
        $name = '%' . $name . '%';
        $stmt->bindParam('1', $name, PDO::PARAM_STR);
        $stmt->bindParam('2', $name, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjMainList = new stdClass();
            foreach ($result as $data) {
                $objectClass = new stdClass();

                $unique_id = $data['unique_id'];
                $Firstname = $data['Firstname'];
                $Othername = $data['Othername'];
                $Age = $data['Age'];
                $Position = $data['Position'];
                $contact = $data['contact'];
                $email = $data['email'];
                $image = $data['image'];
                $Address = $data['Address'];
                $Baptism = $data['Baptism'];
                $membership_start = $data['membership_start'];
                $username = $data['username'];
                $gender = $data['gender'];
                $occupation = $data['occupation'];
                $About = $data['About'];


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

                $ObjMainList->$unique_id = $objectClass;




            }
            $exportData = $ObjMainList;
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