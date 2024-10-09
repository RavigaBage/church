<?php
namespace UserApi;
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
    protected function user_upload_data($unique_id, $Image, $Image_type, $Image_tmp_name)
    {
        $exportData = 0;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=?");
        $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        if (!$stmt->rowCount() > 0) {
            $exportData = "User doesn't exist, if you are viewing this and is a verified member of the church, please contact your administrator";
            exit(json_encode($exportData));
        } else {
            if ($Image == '') {
                $Image = '';
                exit(json_encode('Image file does not exist, try uploading an image'));
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
                            $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`users` SET  `image` = ? where `unique_id` = ?");
                            $stmt->bindParam('1', $filename4, \PDO::PARAM_STR);
                            $stmt->bindParam('2', $unique_id, \PDO::PARAM_STR);
                            if (!$stmt->execute()) {
                                $stmt = null;
                                $Error = json_encode('Fetching data encountered a problems');
                                exit($Error);
                            } else {
                                exit(json_encode('success'));

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

        }
    }
    protected function user_get_data($unique_id)
    {
        $exportData = 0;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=?");
        $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit($Error);
        }

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjMainList = new \stdClass();
            $data = $result[0];
            $objectClass = new \stdClass();
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

            $exportData = json_encode($ObjMainList);
        } else {
            $resultCheck = false;
            $exportData = '<header>Not Records Available</header>';
        }

        return $exportData;
    }

    protected function personal_data($unique_id, $Name, $OtherName, $Email, $contact, $About, $Address)
    {
        $clean = true;
        $exportData = 0;
        $resultValidate = true;

        $exportData = 0;
        $input_list = array($Name, $Email, $contact, $About, $Address);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=?");
            $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = "Data does not exist. Check in your with your admin, your account might have been deleted";
                exit(json_encode($exportData));
            } else {
                $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`users` set `Firstname`=?, `Othername` =?, `email` =?, `contact`=?,`About`=?,`Address`=? where `unique_id` = ?");

                $stmt->bindParam('1', $Name, \PDO::PARAM_STR);
                $stmt->bindParam('2', $OtherName, \PDO::PARAM_STR);
                $stmt->bindParam('3', $Email, \PDO::PARAM_STR);
                $stmt->bindParam('4', $contact, \PDO::PARAM_STR);
                $stmt->bindParam('5', $About, \PDO::PARAM_STR);
                $stmt->bindParam('6', $Address, \PDO::PARAM_STR);
                $stmt->bindParam('7', $unique_id, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    print_r($stmt->errorInfo());
                    $stmt = null;
                    $Error = 'Fetching data encountered a problems';
                    exit(json_encode($Error));
                } else {
                    exit(json_encode('success'));
                }
            }


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
            $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
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

                $stmt->bindParam('1', $location, \PDO::PARAM_STR);
                $stmt->bindParam('2', $unique_id, \PDO::PARAM_STR);
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
            $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
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
            $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
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

                $stmt->bindParam('1', $passkey, \PDO::PARAM_STR);
                $stmt->bindParam('2', $unique_id, \PDO::PARAM_STR);
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
    protected function password_request_set($Email, $id)
    {
        $clean = true;
        $exportData = 0;
        $condition = true;
        $clean = true;

        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`password_reset` where `token`=?");
            $stmt->bindParam('1', $id, \PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $resultMail = $stmt->fetchAll()[0]['tokenValid'];
                if ($resultMail) {
                    $fulldaya = 3 * 60 * 60;
                    $SetTime = time() - date($resultMail);
                    if ($fulldaya >= $SetTime) {
                        $exportData = 'You requested for a password, please check your mail';
                        $condition = false;
                    } else {
                        $condition = true;
                    }
                }

            }
            if ($condition) {
                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`password_reset` (`token`, `tokenRequest`, `tokenValid`, `email`) VALUES (?,?,?,?)");
                $Token = hash('sha256', $id);
                $validaTime = time();
                $stmt->bindParam('1', $id, \PDO::PARAM_STR);
                $stmt->bindParam('2', $Token, \PDO::PARAM_STR);
                $stmt->bindParam('3', $validaTime, \PDO::PARAM_STR);
                $stmt->bindParam('4', $Email, \PDO::PARAM_STR);

                if (!$stmt->execute()) {
                    print_r($stmt->errorInfo());
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                } else {
                    $exportData = 'You request has been approved please check your email';

                }
            }
        }
        return $exportData;
    }
    protected function password_fetch_id($token)
    {
        $clean = true;
        $exportData = 0;
        $condition = true;
        $clean = true;

        if ($clean) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`password_reset` where `tokenRequest`=?");
            $stmt->bindParam('1', $token, \PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $resultId = $stmt->fetchAll()[0]['token'];
                $exportData = $resultId;
            }
        }
        return $exportData;
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
            $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
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

                $stmt->bindParam('1', $About, \PDO::PARAM_STR);
                $stmt->bindParam('2', $unique_id, \PDO::PARAM_STR);
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
        $Ministries_list = new \stdClass();
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

                $stmt = $this->data_connect()->prepare("SELECT * FROM `zeodepartments`.`$name` where `unique_id` = ? ORDER BY `id` DESC");
                $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit($Error);
                }
                if ($stmt->rowCount() > 0) {
                    $data = $stmt->fetchAll();
                    $position = $data[0]['position'];
                    $Ministries_data = new \stdClass();

                    $Ministries_data->name = $name;
                    $Ministries_data->membership = $membership;
                    $Ministries_data->date = $date;
                    $Ministries_data->position = $position;

                    $Ministries_list->$unique_id = $Ministries_data;
                }

            }
            if ($Ministries_list == new \stdClass()) {
                $exportData = 'No Records Available';
            } else {
                $exportData = json_encode($Ministries_list);
            }


        } else {
            $resultCheck = false;
            $exportData = 'No Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function notification_pages()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        $exportData = $stmt->rowCount() > 0;

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function notification($unique_id, $num)
    {
        $exportData = '';
        $resultCheck = true;
        $nk = $num - 1 * 40;
        $department_list = [];
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $name = $data['name'];
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zeodepartments`.`$name` where `unique_id` = ?ORDER BY `id` DESC");
                $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit($Error);
                }
                if ($stmt->rowCount() > 0) {
                    array_push($department_list, $name);
                }
            }
            if ($num == '1') {
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`announcement` ORDER BY `date` DESC limit 40 ");
            } else {
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`announcement` ORDER BY `date` DESC limit 40 OFFSET $nk");
            }
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $ExportMain = new \stdClass();
                foreach ($result as $data) {
                    $name = $data['title'];
                    $receiver = $data['Reciever'];
                    $message = $data['message'];
                    $date = $data['date'];
                    $fileName = $data['file'];
                    $Id = $data['unique_id'];
                    $ExportMainSend = new \stdClass();
                    if (in_array($receiver, $department_list) || $receiver == 'all') {
                        $ExportMainSend->title = $name;
                        $ExportMainSend->message = $message;
                        $ExportMainSend->date = $date;
                        $ExportMainSend->file = $fileName;
                        $unique_id = time() . $Id;
                        $ExportMain->$unique_id = $ExportMainSend;
                    }
                }
                $exportData = json_encode($ExportMain);
            } else {
                $resultCheck = false;
                $exportData = 'No Records Available';
            }

        } else {
            $resultCheck = false;
            $exportData = 'No Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function notification_status($unique_id)
    {
        $exportData = '';
        $resultCheck = true;
        $department_list = [];
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $name = $data['name'];
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zeodepartments`.`$name` where `unique_id` = ?ORDER BY `id` DESC");
                $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
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
                    $reciever = $data['Reciever'];
                    $count = 0;

                    if (in_array($reciever, $department_list) || $reciever == 'All asssembly') {
                        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeannouncement`.`$name`");
                        if (!$stmt->execute()) {
                            $stmt = null;
                            $Error = 'Fetching data encounted a problem';
                            exit($Error);
                        }
                        if ($stmt->rowCount() > 0) {
                            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeannouncement`.`$name` where `unique_id` = ? ORDER BY `date` DESC");
                            $stmt->bindParam(1, $unique_id, \PDO::PARAM_STR);
                            if (!$stmt->execute()) {
                                $stmt = null;
                                $Error = 'Fetching data encounted a problem';
                                exit($Error);
                            }

                            if (!$stmt->rowCount() > 0) {
                                $count++;
                            }

                        } else {
                            $count++;
                        }
                    }
                    if (!$count > 0) {
                        $count = "0";
                    }
                    $exportData = json_encode($count);
                }
            } else {
                $resultCheck = false;
                $exportData = 'No Records Available';
            }

        } else {
            $resultCheck = false;
            $exportData = 'No Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }


    protected function user_notification_status($unique_id)
    {
        $exportData = '';
        $date = date('Y-m-d H:i:s');
        $department_list = [];
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $name = $data['name'];
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zeodepartments`.`$name` where `unique_id` = ?ORDER BY `id` DESC");
                $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit(json_encode($Error));
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
            $username = "";
            $stmt_r = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=?");
            $stmt_r->bindParam('1', $unique_id, \PDO::PARAM_STR);
            if (!$stmt_r->execute()) {
                $stmt_r = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt_r->rowCount() > 0) {
                $result = $stmt_r->fetchAll();
                $data = $result[0];
                $Firstname = $data['Firstname'];
                $Othername = $data['Othername'];
                $username = $Firstname . $Othername;
            }
            if ($username != "") {
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetchAll();
                    foreach ($result as $data) {
                        $name = $data['title'];
                        $reciever = $data['Reciever'];
                        if (in_array($reciever, $department_list) || $reciever == 'All asssembly') {

                            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeannouncement`.`$name`");
                            if (!$stmt->execute()) {
                                $stmt = null;
                                $Error = 'Fetching data encounted a problem';
                                exit($Error);
                            }
                            if ($stmt->rowCount() > 0) {

                                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeannouncement`.`$name` where `unique_id` = ? ORDER BY `date` DESC");
                                $stmt->bindParam(1, $unique_id, \PDO::PARAM_STR);
                                if (!$stmt->execute()) {
                                    $stmt = null;
                                    $Error = 'Fetching data encounted a problem';
                                    exit($Error);
                                }

                                if (!$stmt->rowCount() > 0) {
                                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeannouncement`.`$name` (`unique_id`, `Date`, `username`, `$reciever`) VALUES(?,?,?,?)");
                                    $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                                    $stmt->bindParam('2', $date, \PDO::PARAM_STR);
                                    $stmt->bindParam('3', $username, \PDO::PARAM_STR);
                                    $stmt->bindParam('4', $username, \PDO::PARAM_STR);

                                    if (!$stmt->execute()) {
                                        $stmt = null;
                                        $Error = 'Fetching data encounted a problem';
                                        exit(json_encode($Error));
                                    } else {
                                        $exportData = 'success';
                                    }
                                } else {
                                    $exportData = 'success';

                                }

                            } else {
                                $stmt = $this->data_connect()->prepare("INSERT INTO `zoeannouncement`.`$name` (`unique_id`, `Date`, `username`, `$reciever`) VALUES(?,?,?,?)");
                                $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                                $stmt->bindParam('2', $date, \PDO::PARAM_STR);
                                $stmt->bindParam('3', $username, \PDO::PARAM_STR);
                                $stmt->bindParam('4', $username, \PDO::PARAM_STR);

                                if (!$stmt->execute()) {
                                    $stmt = null;
                                    $Error = 'Fetching data encounted a problem';
                                    exit(json_encode($Error));
                                } else {
                                    $exportData = 'success';
                                }
                            }
                        } else {
                            $exportData = 'success';
                        }
                    }
                } else {
                    $exportData = 'No Records Available';
                }
            } else {
                exit('User not found');
            }

        } else {
            $exportData = 'No Records Available';
        }
        return json_encode($exportData);

    }
    public function user_list_Info_tithe($unique_id, $num)
    {
        $numer = 40 * $num;
        $exportData = '';
        if ($num == 1) {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `unique_id`='$unique_id' ORDER BY `date` DESC");
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `unique_id`='$unique_id' ORDER BY `date` DESC limit 40 OFFSET $numer");
        }
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportMain = new \stdClass();
            foreach ($result as $data) {
                $id = $data['unique_id'];
                $name = $data['name'];
                $payment = $data['Medium_payment'];
                $amount = $data['amount'];
                $date = $data['Date'];
                $month = $data['month'];
                $year = $data['year'];
                $ExportSend = new \stdClass();
                $ExportSend->id = $id;
                $ExportSend->name = $name;
                $ExportSend->payment = $payment;
                $ExportSend->date = $date;
                $ExportSend->month = $month;
                $ExportSend->year = $year;
                $ExportSend->amount = $amount;
                $Name = $id . $date;

                $ExportMain->$Name = $ExportSend;
            }
            $exportData = json_encode($ExportMain);
        } else {
            $exportData = json_encode('No Records Available');
        }
        return $exportData;
    }

    public function user_list_Info_tithe_pages($unique_id)
    {

        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`tiths` where `unique_id`='$unique_id' ORDER BY `date` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }

        return $stmt->rowCount();

    }
    // public function transactionList_pages()
    // {
    //     $exportData = '';
    //     $resultCheck = true;
    //     $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` ORDER BY `id` DESC");
    //     if (!$stmt->execute()) {
    //         $stmt = null;
    //         $Error = 'Fetching data encounted a problem';
    //         exit($Error);
    //     }
    //     $exportData = $stmt->rowCount() > 0;

    //     if ($resultCheck) {
    //         return $exportData;
    //     } else {
    //         return $resultCheck;
    //     }
    // }
    protected function transactionList($unique_id, $num)
    {
        $exportData = '';
        $resultCheck = true;
        $department_list = [];
        $nk = $num - 1 * 40;
        if ($num == '1') {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` ORDER BY `id` DESC limit 40");

        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`department` ORDER BY `id` DESC limit 40 OFFSET $nk");

        }
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
                $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit($Error);
                }
                if ($stmt->rowCount() > 0) {
                    array_push($department_list, $name);
                }
            }
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` ORDER BY `date` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $ExportMain = new \stdClass();

                foreach ($result as $data) {
                    $name = $data['name'];
                    $amount = $data['amount'];
                    $department = $data['department'];
                    $date = $data['date'];
                    $Id = $data['unique_id'];
                    $ExportMainSend = new \stdClass();
                    if (in_array($department, $department_list) || $department == 'All users') {
                        $paidAmount = 0;
                        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoedues`.`$name` where `user`='$unique_id' ORDER BY `date` DESC");
                        if (!$stmt->execute()) {
                            $stmt = null;
                            $Error = 'Fetching data encounted a problem';
                            exit($Error);
                        }

                        if ($stmt->rowCount() > 0) {

                            $result = $stmt->fetchAll();
                            $paidAmount = $result[0]['Amount'];
                        }
                        $ExportMainSend->name = $name;
                        $ExportMainSend->amount = $amount;
                        $ExportMainSend->date = $date;
                        $ExportMainSend->department = $department;
                        $ExportMainSend->status = $paidAmount;
                        $unique_idR = time() . $Id;
                        $ExportMain->$unique_idR = $ExportMainSend;
                    }
                }
                $exportData = json_encode($ExportMain);
            } else {
                $resultCheck = false;
                $exportData = 'No Records Available';
            }

        } else {
            $resultCheck = false;
            $exportData = 'No Records Available';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function transactionList_pages()
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
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zeodepartments`.`$name` where `unique_id` = ? ORDER BY `id` DESC");
                $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted i a problem';
                    exit($Error);
                }
                if ($stmt->rowCount() > 0) {
                    array_push($department_list, $name);
                }
            }
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` ORDER BY `date` DESC");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit($Error);
            } else {
                return $stmt->rowCount();
            }


        }
    }
    protected function paymentList($unique_id)
    {
        $exportData = '';
        $resultCheck = true;
        $department_list = [];
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`payment_log` where `user_id`='$unique_id' ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportMain = new \stdClass();
            foreach ($result as $data) {
                $webpage = $data['webpage'];
                $gateway = $data['gateway'];
                $status = $data['status'];
                $date = $data['date'];
                $time = $data['time'];
                $amount = $data['amount'];
                $idD = $data['transaction_id'];

                $newExport = new \stdClass();
                $newExport->webpage = $webpage;
                $newExport->gateway = $gateway;
                $newExport->status = $status;
                $newExport->date = $date;
                $newExport->time = $time;
                $newExport->amount = $amount;

                $ExportMain->$idD = $newExport;
            }

            $exportData = json_encode($ExportMain);

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
    protected function password_update($unique_id, $passkey)
    {
        $input_list = [$unique_id, $passkey];
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `unique_id`=? ");
            $stmt->bindParam('1', $unique_id, \PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if (!$stmt->rowCount() > 0) {
                $exportData = "error";
                $resultValidate = false;
                exit($exportData);
            } else {
                $passwordKey = hash('sha256', $passkey);
                $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`users` SET `password`=? where `unique_id` = ?");
                $stmt->bindParam('1', $passwordKey, \PDO::PARAM_STR);
                $stmt->bindParam('2', $unique_id, \PDO::PARAM_STR);
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = json_encode('Encoding data encountered a problems');
                    exit($Error);
                } else {
                    $exportData = 'Update success';
                }


            }

        }
        return $exportData;
    }

}