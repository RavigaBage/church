<?php
date_default_timezone_set('UTC');
$year = date('Y');
$date = date('l j \of F Y h:i:s A');
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
    protected function Activity_upload_data($user_id, $file, $file_type, $title, $description, $duration, $genre, $tags, $created_at, $updated_at, $file_id)
    {

        $input_list = array($user_id, $file, $file_type, $title, $description, $duration, $genre, $tags, $created_at, $updated_at, $file_id);

        $clean = true;
        $exportData = 0;
        $resultValidate = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {

            $stmt = $this->data_connect()->prepare("INSERT INTO `AudioLibrary`.`content`(`user_id`, `file`, `file_type`, `title`, `description`, `duration`, `genre`, `tags`, `created_at`, `updated_at`, `file_id`) VALUES (?,?,?,?,?,?,?,?,?,?,?)");


            $stmt->bindParam('1', $user_id, PDO::PARAM_STR);
            $stmt->bindParam('2', $file, PDO::PARAM_STR);
            $stmt->bindParam('3', $file_type, PDO::PARAM_STR);
            $stmt->bindParam('4', $title, PDO::PARAM_STR);
            $stmt->bindParam('5', $description, PDO::PARAM_STR);
            $stmt->bindParam('6', $duration, PDO::PARAM_STR);
            $stmt->bindParam('7', $genre, PDO::PARAM_STR);
            $stmt->bindParam('8', $tags, PDO::PARAM_STR);
            $stmt->bindParam('9', $created_at, PDO::PARAM_STR);
            $stmt->bindParam('10', $updated_at, PDO::PARAM_STR);
            $stmt->bindParam('11', $file_id, PDO::PARAM_STR);


            if (!$stmt->execute()) {

                print_r($stmt->errorInfo());

                $stmt = null;
                $Error = 'Fetching data encountered a problems';
                exit($Error);
            } else {
                $exportData = 'Data entry was a success Page will refresh to display new data';
                $resultValidate = true;
                exit('Upload was a success');
            }
        }
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }

    protected function Activity_update_data($user_id, $file, $file_type, $title, $description, $duration, $genre, $tags, $created_at, $updated_at, $file_id)
    {

        $input_list = array($user_id, $file, $file_type, $title, $description, $duration, $genre, $tags, $created_at, $updated_at, $file_id);
        $clean = true;
        $exportData = 0;
        $resultValidate = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {
            $stmt = $this->data_connect()->prepare("UPDATE `audiolibrary`.`content` set `user_id`=?,`file`=?,`file_type`=?,`title`=?,`description`=?,`duration`=?,`genre`=?,`tags`=?,`created_at`=?,`updated_at`=?,`file_id`=? WHERE 1 WHERE id=?");

            $stmt->bindParam('11', $user_id, PDO::PARAM_STR);
            $stmt->bindParam('1', $file, PDO::PARAM_STR);
            $stmt->bindParam('2', $file_type, PDO::PARAM_STR);
            $stmt->bindParam('3', $title, PDO::PARAM_STR);
            $stmt->bindParam('4', $description, PDO::PARAM_STR);
            $stmt->bindParam('5', $duration, PDO::PARAM_STR);
            $stmt->bindParam('6', $genre, PDO::PARAM_STR);
            $stmt->bindParam('7', $tags, PDO::PARAM_STR);
            $stmt->bindParam('8', $created_at, PDO::PARAM_STR);
            $stmt->bindParam('9', $updated_at, PDO::PARAM_STR);
            $stmt->bindParam('10', $file_id, PDO::PARAM_STR);

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
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }


    protected function Activity_delete_data($name)
    {
        $exportData = 0;
        $input_list = array($name);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `audioLibrary`.`content` where `id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`sunday_records` where `id`=?");
                    $stmt->bindParam('1', $name, PDO::PARAM_STR);
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
    protected function Activity_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `audioLibrary`.`content` ORDER BY `id` DESC");
        if (!$stmt->execute()) {

            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            print_r($stmt->errorInfo());
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $title = $data[`title`];


                $item = '<li onclick="status(this)" data-value="' . $title . '"><i class="fas fa-toggle-off"></i></li>';

                $exportData .= '
                <ul class="main six">
                                    <li><input type="checkbox" value=""/>' . $item . '</li>
                                    
                                </ul>';

            }
        } else {
            $resultCheck = false;
            $exportData = '<header>Not Records Available</header>';
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $exportData;
        }
    }



    protected function church_record_upload_data($category, $record, $details, $admin, $year)
    {

        $input_list = array($category, $record, $details, $admin, $year);
        $clean = true;
        $exportData = 0;
        $resultValidate = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {


            $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`records`( `category`, `record`, `details`, `date`, `admin`, `year`)VALUES (?,?,?,?,?,?)");
            $stmt->bindParam('1', $category, PDO::PARAM_STR);
            $stmt->bindParam('2', $record, PDO::PARAM_STR);
            $stmt->bindParam('3', $details, PDO::PARAM_STR);
            $stmt->bindParam('4', $date, PDO::PARAM_STR);
            $stmt->bindParam('5', $admin, PDO::PARAM_STR);
            $stmt->bindParam('6', $year, PDO::PARAM_STR);

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
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }


    protected function church_record_update_data($category, $record, $details, $id, $admin, $year)
    {
        $input_list = array($category, $record, $details, $id, $admin, $year);
        $clean = true;
        $exportData = 0;
        $resultValidate = true;
        foreach ($input_list as $input) {
            $data = $this->validate($input);
            if ($data == 'test pass failed') {
                $Error = 'validating data encountered a problem, All fields are required !';
                $clean = false;
                exit($Error);
            }
        }
        if ($clean) {

            $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`projects` set `category`=?,`record`=?,`details`=?,`date`=?,`admin`=?,`year`=? WHERE 1where `id` = ?");

            $stmt->bindParam('1', $category, PDO::PARAM_STR);
            $stmt->bindParam('2', $record, PDO::PARAM_STR);
            $stmt->bindParam('3', $details, PDO::PARAM_STR);
            $stmt->bindParam('4', $date, PDO::PARAM_STR);
            $stmt->bindParam('5', $admin, PDO::PARAM_STR);
            $stmt->bindParam('6', $year, PDO::PARAM_STR);
            $stmt->bindParam('7', $id, PDO::PARAM_STR);
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
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }


    protected function church_record_delete_data($name)
    {
        $exportData = 0;
        $input_list = array($name);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`records` where `id` =?");
            $stmt->bindParam('1', $name, PDO::PARAM_STR);
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                if ($stmt->execute()) {
                    $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`records` where `id`=?");
                    $stmt->bindParam('1', $name, PDO::PARAM_STR);
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

    protected function church_record_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`records` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjectDataMain = new stdClass();
            $list = ['birth', 'death', 'water_baptism', 'fire_baptism'];
            $birth = 0;
            $death = 0;
            $water_baptism = 0;
            $fire_baptism = 0;


            foreach ($result as $data) {
                $name = $data['category'];
                if ($name == 'birth') {
                    $birth += 1;
                } elseif ($name == 'death') {
                    $death += 1;
                } elseif ($name == 'water_baptism') {
                    $water_baptism += 1;
                } elseif ($name == 'fire_baptism') {
                    $fire_baptism += 1;
                }


            }

            $ObjectDataMain->birth = $birth;
            $ObjectDataMain->death = $death;
            $ObjectDataMain->water_baptism = $water_baptism;
            $ObjectDataMain->fire_baptism = $fire_baptism;
            $exportData = $ObjectDataMain;
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