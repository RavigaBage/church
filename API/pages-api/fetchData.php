<?php
namespace ChurchApi;
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
    protected function church_record_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`records` ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ObjectDataMain = new \stdClass();
            $list = ['birth', 'death', 'water_baptism', 'fire_baptism', 'soul'];
            $birth = 0;
            $death = 0;
            $water_baptism = 0;
            $fire_baptism = 0;
            $soul = 0;


            foreach ($result as $data) {
                $name = strtolower($data['category']);
                if ($name == 'birth') {
                    $birth += 1;
                } elseif ($name == 'death') {
                    $death += 1;
                } elseif ($name == 'water_baptism') {
                    $water_baptism += 1;
                } elseif ($name == 'fire_baptism') {
                    $fire_baptism += 1;
                } elseif ($name == 'soul') {
                    $soul += 1;
                }


            }

            $ObjectDataMain->birth = $birth;
            $ObjectDataMain->death = $death;
            $ObjectDataMain->water_baptism = $water_baptism;
            $ObjectDataMain->fire_baptism = $fire_baptism;
            $ObjectDataMain->soul = $soul;
            $exportData = json_encode($ObjectDataMain);
        } else {
            $resultCheck = false;
            $exportData = json_encode('<header>Not Records Available</header>');
        }

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }
    protected function calender_view($year)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` WHERE `Year` like '%$year%' ORDER BY `start_time` DESC");

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $MainClass = new \stdClass();
            $result = $stmt->fetchAll();
            foreach ($result as $data) {
                $tmpClass = new \stdClass();
                $name = $data['EventName'];
                $year = $data['Year'];
                $Month = $data['Month'];
                $Day = $data['Day'];
                $start = $data['start_time'];
                $end = $data['end_time'];
                $venue = $data['Venue'];
                $theme = $data['Theme'];
                $about = $data['About'];
                $image = $data['Image'];
                $department = $data['Department'];
                $status = $data['Status'];
                $unique_id = $data['unique_id'];

                $tmpClass->name = $name;
                $tmpClass->Year = $year;
                $tmpClass->Month = $Month;
                $tmpClass->Day = $Day;
                $tmpClass->start = $start;
                $tmpClass->end = $end;
                $tmpClass->venue = $venue;
                $tmpClass->theme = $theme;
                $tmpClass->about = $about;
                $tmpClass->image = $image;
                $tmpClass->department = $department;
                $tmpClass->status = $status;
                $tmpClass->unique_id = $unique_id;
                $MainClass->$unique_id = $tmpClass;

            }

            $exportData = json_encode($MainClass);
        } else {
            $resultCheck = false;
            $exportData = json_encode('Not Records Available');
        }


        return $exportData;

    }
    protected function call_action_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`dues` where `department` ='all'  OR   `department` = 'All users' ORDER BY `id` DESC");
        if (!$stmt->execute()) {
            print_r($stmt->errorInfo());
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $List = new \stdClass();
            $last_data = $stmt->rowCount();
            $result = $stmt->fetchAll();
            $Data = $result[$last_data - 1];
            $name = $Data['name'];
            $Amount = $Data['amount'];
            $purpose = $Data['purpose'];
            $due_date = $Data['due_date'];
            $List->name = $name;
            $List->amount = $Amount;
            $List->purpose = $purpose;
            $List->date = $due_date;

            $exportData = json_encode($List);

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
    protected function announcement_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`announcement` where `status` ='active' ");
        if (!$stmt->execute()) {

            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $List = new \stdClass();
            $last_data = $stmt->rowCount();
            $result = $stmt->fetchAll();
            $Data = $result[$last_data - 1];
            $name = $Data['title'];
            $message = $Data['message'];
            $file = $Data['file'];

            $List->name = $name;
            $List->message = $message;
            $List->file = $file;

            $exportData = json_encode($List);

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

    protected function project_view()
    {
        $object_data = new \stdClass();
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
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`gallary`  ORDER BY RAND()limit 6");
        $dataList = new \stdClass();
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
                $dataList->image = $Mountain;
            }
        }
        $exportData = json_encode($dataList);

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function theme_home_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`theme` where `status`='active' limit 1");
        $dataList = "";
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        } else {
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                foreach ($result as $row) {
                    $name = $row['name'];
                    $dataList = $name;
                }
            } else {
                exit(json_encode('No Available records'));
            }
        }



        $exportData = json_encode($dataList);

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
        $dataList = new \stdClass();
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        } else {
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $Mountain = [];
                foreach ($result as $row) {
                    $name = $row['name'];
                    array_push($Mountain, $name);
                }
                $dataList->Mountain = $Mountain;
            } else {
                exit(json_encode('No Available records'));
            }
        }



        $exportData = json_encode($dataList);

        if ($resultCheck) {
            return $exportData;
        } else {
            return $resultCheck;
        }
    }

    protected function NextEvent_home_view()
    {
        $CurrentTime = new \DateTime();
        $CurrentYear = date('Y');
        $CurrentMonth = date('m');
        $CurrentDay = date('d');
        $exportList = new \stdClass();
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` where `Year` ='$CurrentYear' AND `Month`='$CurrentMonth' and `Day` ='$CurrentDay' ORDER BY `id` DESC limit 20");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit(json_encode($Error));
        }

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                $time = $row['start_time'];
                $time_trim = explode(' ', $time);
                $focus = $time_trim[0];
                if ($time_trim[0] == 'pm') {
                    $new = explode(':', $focus);
                    $focusF = intval($new[0]) + 12;
                    $focus = strval($focusF) . ':' . $new[1];
                }
                $checkTime = new \DateTime($focus);
                if ($CurrentTime > $checkTime) {
                    $exportList->image = $row['Image'];
                    $exportList->About = $row['About'];
                    $exportList->Start_time = $row['start_time'];
                    $exportList->End_time = $row['end_time'];
                    $exportList->Event_name = $row['EventName'];
                    break;
                }
            }
        } else {
            //condition 2
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` where `Year` ='$CurrentYear' AND `Month`='$CurrentMonth' and `Day` > '$CurrentDay' ORDER BY `id` DESC limit 20");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encounted a problem';
                exit(json_encode($Error));
            }

            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                foreach ($result as $row) {
                    $exportList->image = $row['Image'];
                    $exportList->About = $row['About'];
                    $exportList->Start_time = $row['start_time'];
                    $exportList->End_time = $row['end_time'];
                    $exportList->Event_name = $row['EventName'];
                    break;
                }
            } else {
                //condition 3
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` where `Year` ='$CurrentYear' AND `Month` >'$CurrentMonth' and `Day` <= '$CurrentDay' ORDER BY `Month` ASC");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encounted a problem';
                    exit(json_encode($Error));
                }

                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetchAll();
                    foreach ($result as $row) {
                        $exportList->image = $row['Image'];
                        $exportList->About = $row['About'];
                        $exportList->Start_time = $row['start_time'];
                        $exportList->End_time = $row['end_time'];
                        $exportList->Event_name = $row['EventName'];
                        break;
                    }
                } else {

                    $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` where `Year`='$CurrentYear' AND `Month`>$CurrentMonth ORDER BY `Month` ASC");
                    if (!$stmt->execute()) {
                        $stmt = null;
                        $Error = 'Fetching data encounted a problem';
                        exit(json_encode($Error));
                    }

                    if ($stmt->rowCount() > 0) {
                        $result = $stmt->fetchAll();
                        foreach ($result as $row) {
                            $exportList->image = $row['Image'];
                            $exportList->About = $row['About'];
                            $exportList->Start_time = $row['start_time'];
                            $exportList->End_time = $row['end_time'];
                            $exportList->Event_name = $row['EventName'];
                            break;
                        }
                    } else {
                        //condition 4
                        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` where `Year` > '$CurrentYear'  ORDER BY `Month` ASC");
                        if (!$stmt->execute()) {
                            $stmt = null;
                            $Error = 'Fetching data encounted a problem';
                            exit(json_encode($Error));
                        }

                        if ($stmt->rowCount() > 0) {
                            $result = $stmt->fetchAll();
                            foreach ($result as $row) {
                                $exportList->image = $row['Image'];
                                $exportList->About = $row['About'];
                                $exportList->Start_time = $row['start_time'];
                                $exportList->End_time = $row['end_time'];
                                $exportList->Event_name = $row['EventName'];
                                break;
                            }
                        } else {
                            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`calender` where `Year` = '$CurrentYear' AND `Month` > '$CurrentMonth'  ORDER BY `Month` ASC");
                            if (!$stmt->execute()) {
                                $stmt = null;
                                $Error = 'Fetching data encounted a problem';
                                exit(json_encode($Error));
                            }

                            if ($stmt->rowCount() > 0) {
                                $result = $stmt->fetchAll();

                                foreach ($result as $row) {
                                    $exportList->image = $row['Image'];
                                    $exportList->About = $row['About'];
                                    $exportList->Start_time = $row['start_time'];
                                    $exportList->End_time = $row['end_time'];
                                    $exportList->Event_name = $row['EventName'];

                                    break;
                                }
                            } else {
                                exit(json_encode('Available Data not found'));
                            }
                        }
                    }

                }

            }
        }

        return json_encode($exportList);


    }
}
?>