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
    protected function user_upload_data($unique_id, $Image, $Image_type, $Image_tmp_name)
    {
        $exportData = 0;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=?");
        $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit($Error);
        }
        if (!$stmt->rowCount() > 0) {
            $exportData = "User doesn't exist, if you are viewing this and is a verified member of the church, please contact your administrator";
            exit($exportData);
        } else {
            if ($Image == '') {
                $Image = '';
                exit('Image file does not exist, try uploading an image');
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

                            $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`users` SET  `Image` = ? where `unique_id` = ?");
                            $stmt->bindParam('1', $Image, PDO::PARAM_STR);
                            $stmt->bindParam('2', $unique_id, PDO::PARAM_STR);

                            if (!$stmt->execute()) {
                                $stmt = null;
                                $Error = 'Fetching data encountered a problems';
                                exit($Error);
                            } else {
                                $exportData = 'Data entry was a success Page will refresh to display new data';
                                $resultValidate = true;
                            }

                        } else {
                            exit("An error occurred while processing image, try again");
                        }
                    } else {
                        exit("Image file must be of the following extensions only 'jpg','png','jpeg'");
                    }
                } else {
                    exit("Image file must be of the following extensions only 'jpg','png','jpeg'");
                }
            }

        }



        return $exportData;
    }
    protected function user_get_data($unique_id)
    {
        $exportData = 0;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=?");
        $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit($Error);
        }

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjMainList = new stdClass();
            $data = $result[0];
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

            $exportData = $ObjMainList;
        } else {
            $resultCheck = false;
            $exportData = '<header>Not Records Available</header>';
        }

        return $exportData;
    }

    protected function personal_data($unique_id, $Name, $OtherName, $Email, $contact)
    {
        $clean = true;
        $exportData = 0;
        $resultValidate = true;

        $exportData = 0;
        $input_list = array($Name, $Email, $contact);
        $clean = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }

        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=?");
            $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = "Data already exist";
                $resultValidate = false;
                exit($exportData);
            } else {


                $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`users` set `Firstname`=?, `Othername` =?, `email` =?, `contact`=? where `unique_id` = ?");

                $stmt->bindParam('1', $Name, PDO::PARAM_STR);
                $stmt->bindParam('2', $OtherName, PDO::PARAM_STR);
                $stmt->bindParam('3', $Email, PDO::PARAM_STR);
                $stmt->bindParam('4', $contact, PDO::PARAM_STR);
                $stmt->bindParam('5', $unique_id, PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problems';
                    exit($Error);
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
                    $resultValidate = true;
                    exit('Upload was a success');
                }





            }


        }
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }


    protected function location_data($unique_id, $location)
    {
        $clean = true;
        $exportData = 0;
        $resultValidate = true;

        $exportData = 0;
        $input_list = array($location);
        $clean = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }

        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=?");
            $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = "Data already exist";
                $resultValidate = false;
                exit($exportData);
            } else {


                $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`users` set `location` =? where `unique_id` = ?");

                $stmt->bindParam('1', $location, PDO::PARAM_STR);
                $stmt->bindParam('2', $unique_id, PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problems';
                    exit($Error);
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
                    $resultValidate = true;
                    exit('Upload was a success');
                }





            }


        }
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }
    protected function Password_check_data($unique_id, $passkey)
    {
        $clean = true;
        $exportData = 0;
        $resultValidate = true;

        $exportData = 0;
        $clean = true;


        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=?");
            $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = "Data already exist";
                $resultValidate = false;
                exit($exportData);
            } else {
                $result = $stmt->fetchAll();
                $pass_decode = $result[0]['passwords'];
                $verify = password_verify($passkey, $pass_decode);
                if (!$verify) {
                    $Error = 'Invalid password';
                    exit($Error);
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
                    $resultValidate = true;
                    exit('Upload was a success');
                }





            }


        }
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }

    protected function Password_set_data($unique_id, $password)
    {
        $clean = true;
        $exportData = 0;
        $resultValidate = true;

        $exportData = 0;
        $input_list = array($password);
        $clean = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }

        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=?");
            $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = "Data already exist";
                $resultValidate = false;
                exit($exportData);
            } else {
                $passkey = password_hash($password);
                $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`users` set `location` =? where `unique_id` = ?");

                $stmt->bindParam('1', $passkey, PDO::PARAM_STR);
                $stmt->bindParam('2', $unique_id, PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problems';
                    exit($Error);
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
                    $resultValidate = true;
                    exit('Upload was a success');
                }





            }


        }
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }

    protected function About_data($unique_id, $About)
    {
        $clean = true;
        $exportData = 0;
        $resultValidate = true;

        $exportData = 0;
        $input_list = array($About);
        $clean = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }

        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=?");
            $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $exportData = "Data already exist";
                $resultValidate = false;
                exit($exportData);
            } else {


                $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`users` set `About` =? where `unique_id` = ?");

                $stmt->bindParam('1', $About, PDO::PARAM_STR);
                $stmt->bindParam('2', $unique_id, PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problems';
                    exit($Error);
                } else {
                    $exportData = 'Data entry was a success Page will refresh to display new data';
                    $resultValidate = true;
                    exit('Upload was a success');
                }





            }


        }
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }

    protected function ministries_view($unique_id)
    {
        $exportData = '';
        $resultCheck = true;
        $Ministries_list = new stdClass();
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $name = $data['name'];
                $membership = $data['members'];
                $date = $data['Date'];
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zeodepartments`.`$name` where `unique_id` = ?ORDER BY `id` DESC");
                $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit($Error);
                }

                if ($stmt->rowCount() > 0) {
                    $data = $stmt->fetchAll();
                    $position = $data[0]['position'];
                    $Ministries_data = new stdClass();

                    $Ministries_data->name = $name;
                    $Ministries_data->membership = $membership;
                    $Ministries_data->date = $date;
                    $Ministries_data->position = $position;

                    $Ministries_list->$name = $Ministries_list;


                }

            }
            $exportData = $Ministries_list;
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

    protected function notification($unique_id, $username)
    {
        $exportData = '';
        $resultCheck = true;
        $department_list = [];
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $name = $data['name'];
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zeodepartments`.`$name` where `unique_id` = ?ORDER BY `id` DESC");
                $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit($Error);
                }
                if ($stmt->rowCount() > 0) {
                    array_push($department_list, $name);


                }

            }


            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`announcement` ORDER BY `date` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                foreach ($result as $data) {
                    $name = $data['title'];
                    $receiver = $data['Reciever'];
                    $message = $data['message'];
                    $date = $data['date'];
                    $list_id = $data['unique_id'];
                    $item = '';
                    if (in_array($receiver, $department_list)) {
                        $confirm = $this->user_notification_status($name, $unique_id, $list_id, $username);
                        if ($confirm) {
                            $exportData .= $name;
                        }

                    }


                }
            } else {
                $resultCheck = false;
                $exportData = '<header>Not Records Available</header>';
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

    protected function user_notification_status($name, $unique_id, $list_id, $username)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeannouncement`.`$name`");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeannouncement`.`$name` where `unique_id` = ? ORDER BY `date` DESC");
            $stmt->bindParam(1, $unique_id, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {

                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeannouncement`.`$name` (`unique_id`, `Date`, `username`, `$name`) VALUES(?,?,?,?)");
                $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
                $stmt->bindParam('1', $date, PDO::PARAM_STR);
                $stmt->bindParam('1', $username, PDO::PARAM_STR);
                $stmt->bindParam('1', $list_id, PDO::PARAM_STR);

                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit($Error);
                }
                if ($stmt->rowCount() > 0) {
                    $resultCheck = True;
                }
            } else {
                $resultCheck = false;
                $exportData = '<header>Not Records Available</header>';
            }
        }
        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    public function user_list_Info_tithe($unique_id)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `unique_id`='$unique_id' ORDER BY `date` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $exportData .= '
                <ul class="main five">
                <li><input type="checkbox" class="checkbox" value="' . $data['unique_id'] . '" >' . $data['name'] . '</li>
                <li>' . $data['Medium_payment'] . '</li>
                <li>' . $data['amount'] . '</li>
                <li><p>Published</p>-<p>' . $data['Date'] . '</p></li>
                </ul>';

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

}