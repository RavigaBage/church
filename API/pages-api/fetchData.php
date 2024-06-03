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
    # print_r($stmt->errorInfo());
    protected function call_action_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` where `department` ='all' ");
        if (!$stmt->execute()) {

            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $last_data = $stmt->rowCount();
            $result = $stmt->fetchAll();
            $Data = $result[$last_data - 1];
            $name = $Data['name'];
            $Amount = $Data['amount'];
            $purpose = $Data['purpose'];
            $due_date = $Data['due_date'];
            $exportData = $name;

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
    protected function announcement_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`announcement` where `status` ='active' ");
        if (!$stmt->execute()) {

            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $last_data = $stmt->rowCount();
            $result = $stmt->fetchAll();
            $Data = $result[$last_data - 1];
            $name = $Data['title'];
            $message = $Data['message'];
            $file = $Data['file'];

            $exportData = $name;

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

    protected function project_view()
    {
        $object_data = new stdClass();
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`projects` where `status` = 'complete' ");
        if (!$stmt->execute()) {

            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        $CompletedList = [];
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $Data) {
                $name = $Data['Name'];
                $description = $Data['description'];
                $file = $Data['Image'];
                array_push($CompletedList, $name);
                $exportData = $name;
            }

        } else {
            $resultCheck = false;
            array_push($CompletedList, '<header>No Records Available</header>');

        }

        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`projects` where `status` = 'current' ");
        if (!$stmt->execute()) {

            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        $Current = [];
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $Data) {
                $name = $Data['Name'];
                $description = $Data['description'];
                $file = $Data['Image'];
                array_push($Current, $name);
            }

        } else {
            $resultCheck = false;
            array_push($Current, '<header>No Records Available</header>');
        }

        $object_data->completed = $CompletedList;
        $object_data->current = $Current;
        $exportData = $object_data;
        return $exportData;
    }
    protected function gallery_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` where `category` like '%Mountain experience%' ORDER BY `id` DESC limit 20");
        $stmt_1 = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` where `category` like '%christmas%' ORDER BY `id` DESC limit 20");
        $stmt_5 = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` where `category` like '%Easter%' ORDER BY `id` DESC limit 20");
        $stmt_2 = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` where `category` like '%missions%' ORDER BY `id` DESC limit 20");
        $stmt_3 = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` where `category` like '%evangelism%' ORDER BY `id` DESC limit 20");
        $stmt_4 = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` where `category` like '%services%' ORDER BY `id` DESC limit 20");
        $dataList = new stdClass();
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        } else {
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $Mountain = [];
                foreach ($result as $row) {
                    $name = $row['name'];
                    array_push($Mountain, $name);
                }
                $dataList->Mountain = $Mountain;
            }
        }

        if (!$stmt_1->execute()) {
            $stmt_1 = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        } else {
            if ($stmt_1->rowCount() > 0) {
                $result = $stmt_1->fetchAll();
                $christmas = [];
                foreach ($result as $row) {
                    $name = $row['name'];
                    array_push($christmas, $name);
                }
                $dataList->christmas = $christmas;
            }
        }
        if (!$stmt_2->execute()) {
            $stmt_2 = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        } else {
            if ($stmt_2->rowCount() > 0) {
                $result = $stmt_2->fetchAll();
                $missions = [];
                foreach ($result as $row) {
                    $name = $row['name'];
                    array_push($missions, $name);
                }
                $dataList->missions = $missions;
            }
        }
        if (!$stmt_3->execute()) {
            $stmt_3 = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        } else {
            if ($stmt_3->rowCount() > 0) {
                $result = $stmt_3->fetchAll();
                $evangelism = [];
                foreach ($result as $row) {
                    $name = $row['name'];
                    array_push($evangelism, $name);
                }
                $dataList->evangelism = $evangelism;
            }
        }
        if (!$stmt_4->execute()) {
            $stmt_4 = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        } else {
            if ($stmt_4->rowCount() > 0) {
                $result = $stmt_4->fetchAll();
                $services = [];
                foreach ($result as $row) {
                    $name = $row['name'];
                    array_push($services, $name);
                }
                $dataList->services = $services;
            }
        }

        if (!$stmt_5->execute()) {
            $stmt_5 = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        } else {
            if ($stmt_5->rowCount() > 0) {
                $result = $stmt_5->fetchAll();
                $easter = [];
                foreach ($result as $row) {
                    $name = $row['name'];
                    array_push($easter, $name);
                }
                $dataList->easter = $easter;
            }
        }

        $exportData = $dataList;

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function gallery_home_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary` where `category` like '%active%' ORDER BY `id` DESC limit 20");
        $dataList = new stdClass();
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        } else {
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $Mountain = [];
                foreach ($result as $row) {
                    $name = $row['name'];
                    array_push($Mountain, $name);
                }
                $dataList->Mountain = $Mountain;
            }
        }



        $exportData = $dataList;

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
}
?>