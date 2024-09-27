<?php
namespace Login;
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

    protected function IpStatus_check($ip)
    {
        $CurrentTime = date('Y-m-d H:i:s', time());
        $rate_time = 1;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`ip_quota` WHERE `location`='$ip' AND `time` >= NOW() - INTERVAL 1 MINUTE");
        if (!$stmt->execute()) {
            $stmt = null;
            $exportData = 'Fetching data encounted a problem';
            exit('error ocuured');
        }
        if (!$stmt->rowCount() > 0) {
            $stmt = $this->data_connect()->prepare("SELECT COUNT(*) FROM `zoeworshipcentre`.`ip_status` WHERE `location`='$ip' AND `time` >= NOW() - INTERVAL 1 MINUTE");
            if (!$stmt->execute()) {
                $stmt = null;
                exit('error ocuured');
            } else {
                $result = $stmt->fetchAll()[0]['COUNT(*)'];
                if ($result >= 100) {
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`ip_quota`(`location`, `time`) VALUES (?,?)");
                    $stmt->bindParam('1', $ip, \PDO::PARAM_STR);
                    $stmt->bindParam('2', $CurrentTime, \PDO::PARAM_STR);
                    if ($stmt->execute()) {
                        return json_encode('You access to this resource has been blocked, try again after 5 minutes');
                    } else {
                        $stmt = null;
                        exit('error occured');
                    }
                } else {
                    $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`ip_status`(`location`, `rate`, `time`) VALUES (?,?,?)");
                    $stmt->bindParam('1', $ip, \PDO::PARAM_STR);
                    $stmt->bindParam('2', $rate_time, \PDO::PARAM_STR);
                    $stmt->bindParam('3', $CurrentTime, \PDO::PARAM_STR);
                    if (!$stmt->execute()) {
                        $stmt = null;
                        exit('error occured');
                    } else {
                        return json_encode(['status' => "success"]);
                    }

                }
            }
        } else {
            return json_encode(['status' => "You have currently Exhausted your alloted quota, wait a while (6minutes) and try again"]);
        }

    }
    protected function UserLogin($Key, $User)
    {
        $exportData = "";
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`users` where `email` = '$Key'");
        if (!$stmt->execute()) {
            $stmt = null;
            $exportData = 'Fetching data encounted a problem';
            exit();
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            $data = $result[0];
            $password = $data['password'];
            $passCheck = hash('sha256', $User);
            $User = strtolower($User);
            if (hash_equals($passCheck, $password)) {
                $unique_id = $data['unique_id'];
                $Firstname = $data['Firstname'];
                $Othername = $data['Othername'];
                $details = new \stdClass();
                $details->id = $unique_id;
                $details->name = $Firstname . ' ' . $Othername;
                $exportData = $details;
                if ($data['Status'] == 'Admin') {
                    if (!isset($_SESSION['Admin_access'])) {
                        $_SESSION['Admin_access'] = hash('sha256', $unique_id . 'admin');
                    }
                }
                $_SESSION['user_token'] = hash('sha256', $unique_id);
                $_SESSION['unique_id'] = $unique_id;
            } else {
                $exportData = 'Wrong credential';
            }



        } else {
            $exportData = 'Wrong credentials';
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
            }
        }
    }

}