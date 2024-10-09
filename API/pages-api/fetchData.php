<?php
namespace ChurchApi;

global $passwordKey;
$dir = 'http://localhost/database/church/API/22cca3e2e75275b0753f62f2e6ee9bcf95562423e7455fc0ae9fa73e41226dba';
$dotenv = \Dotenv\Dotenv::createImmutable($dir);
$dotenv->safeLoad();
$passwordKey = $_ENV['database_passkey'];
$year = date('Y');
$date = date('l j \of F Y h:i:s A');
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
    public function CleanString($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
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
                    $name = $this->CleanString($row['name']);
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
                    $name = $this->CleanString($row['name']);
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
                    $name = $this->CleanString($row['name']);
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
    protected function NextEvent_viewList()
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
                $export_min = new \stdClass();
                $time = $this->CleanString($row['start_time']);
                $time_trim = explode(' ', $time);
                $focus = $time_trim[0];
                $unique_id = $this->CleanString($row['unique_id']);
                if ($time_trim[0] == 'pm') {
                    $new = explode(':', $focus);
                    $focusF = intval($new[0]) + 12;
                    $focus = strval($focusF) . ':' . $new[1];
                }
                $checkTime = new \DateTime($focus);
                if ($CurrentTime > $checkTime) {
                    $export_min->image = $this->CleanString($row['Image']);
                    $export_min->About = $this->CleanString($row['About']);
                    $export_min->Start_time = $this->CleanString($row['start_time']);
                    $export_min->End_time = $this->CleanString($row['end_time']);
                    $export_min->Date = $this->CleanString($row['Year']) . '-' . $this->CleanString($row['Month']) . '-' . $this->CleanString($row['Day']);
                    $export_min->Event_name = $this->CleanString($row['EventName']);
                    $exportList->$unique_id = json_encode($export_min);

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
                    $export_min = new \stdClass();
                    $unique_id = $this->CleanString($row['unique_id']);
                    $export_min->image = $this->CleanString($row['Image']);
                    $export_min->About = $this->CleanString($row['About']);
                    $export_min->Date = $this->CleanString($row['Year']) . '-' . $this->CleanString($row['Month']) . '-' . $this->CleanString($row['Day']);
                    $export_min->Start_time = $this->CleanString($row['start_time']);
                    $export_min->End_time = $this->CleanString($row['end_time']);
                    $export_min->Event_name = $this->CleanString($row['EventName']);
                    $exportList->$unique_id = json_encode($export_min);
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
                        $export_min = new \stdClass();
                        $unique_id = $this->CleanString($row['unique_id']);
                        $export_min->image = $this->CleanString($row['Image']);
                        $export_min->About = $this->CleanString($row['About']);
                        $export_min->Date = $this->CleanString($row['Year']) . '-' . $this->CleanString($row['Month']) . '-' . $this->CleanString($row['Day']);
                        $export_min->Start_time = $this->CleanString($row['start_time']);
                        $export_min->End_time = $this->CleanString($row['end_time']);
                        $export_min->Event_name = $this->CleanString($row['EventName']);
                        $exportList->$unique_id = json_encode($export_min);
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
                            $export_min = new \stdClass();
                            $unique_id = $this->CleanString($row['unique_id']);
                            $export_min->image = $this->CleanString($row['Image']);
                            $export_min->About = $this->CleanString($row['About']);
                            $export_min->Date = $this->CleanString($row['Year']) . '-' . $this->CleanString($row['Month']) . '-' . $this->CleanString($row['Day']);
                            $export_min->Start_time = $this->CleanString($row['start_time']);
                            $export_min->End_time = $this->CleanString($row['end_time']);
                            $export_min->Event_name = $this->CleanString($row['EventName']);
                            $exportList->$unique_id = json_encode($export_min);
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
                                $export_min = new \stdClass();
                                $unique_id = $this->CleanString($row['unique_id']);
                                $export_min->image = $this->CleanString($row['Image']);
                                $export_min->About = $this->CleanString($row['About']);
                                $export_min->Date = $this->CleanString($row['Year']) . '-' . $this->CleanString($row['Month']) . '-' . $this->CleanString($row['Day']);
                                $export_min->Start_time = $this->CleanString($row['start_time']);
                                $export_min->End_time = $this->CleanString($row['end_time']);
                                $export_min->Event_name = $this->CleanString($row['EventName']);
                                $exportList->$unique_id = json_encode($export_min);
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
                                    $export_min = new \stdClass();
                                    $unique_id = $this->CleanString($row['unique_id']);
                                    $export_min->image = $this->CleanString($row['Image']);
                                    $export_min->About = $this->CleanString($row['About']);
                                    $export_min->Date = $this->CleanString($row['Year']) . '-' . $this->CleanString($row['Month']) . '-' . $this->CleanString($row['Day']);
                                    $export_min->Start_time = $this->CleanString($row['start_time']);
                                    $export_min->End_time = $this->CleanString($row['end_time']);
                                    $export_min->Event_name = $this->CleanString($row['EventName']);
                                    $exportList->$unique_id = json_encode($export_min);
                                }
                            } else {
                                exit(json_encode('Available Data not found'));
                            }
                        }
                    }

                }

            }
        }

        return $exportList;


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
                $time = $this->CleanString($row['start_time']);
                $time_trim = explode(' ', $time);
                $focus = $time_trim[0];
                if ($time_trim[0] == 'pm') {
                    $new = explode(':', $focus);
                    $focusF = intval($new[0]) + 12;
                    $focus = strval($focusF) . ':' . $new[1];
                }
                $checkTime = new \DateTime($focus);
                if ($CurrentTime > $checkTime) {
                    $exportList->image = $this->CleanString($row['Image']);
                    $exportList->About = $this->CleanString($row['About']);
                    $exportList->Start_time = $this->CleanString($row['start_time']);
                    $exportList->End_time = $this->CleanString($row['end_time']);
                    $exportList->Event_name = $this->CleanString($row['EventName']);
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
                    $exportList->image = $this->CleanString($row['Image']);
                    $exportList->About = $this->CleanString($row['About']);
                    $exportList->Start_time = $this->CleanString($row['start_time']);
                    $exportList->End_time = $this->CleanString($row['end_time']);
                    $exportList->Event_name = $this->CleanString($row['EventName']);
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
                        $exportList->image = $this->CleanString($row['Image']);
                        $exportList->About = $this->CleanString($row['About']);
                        $exportList->Start_time = $this->CleanString($row['start_time']);
                        $exportList->End_time = $this->CleanString($row['end_time']);
                        $exportList->Event_name = $this->CleanString($row['EventName']);
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
                            $exportList->image = $this->CleanString($row['Image']);
                            $exportList->About = $this->CleanString($row['About']);
                            $exportList->Start_time = $this->CleanString($row['start_time']);
                            $exportList->End_time = $this->CleanString($row['end_time']);
                            $exportList->Event_name = $this->CleanString($row['EventName']);
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
                                $exportList->image = $this->CleanString($row['Image']);
                                $exportList->About = $this->CleanString($row['About']);
                                $exportList->Start_time = $this->CleanString($row['start_time']);
                                $exportList->End_time = $this->CleanString($row['end_time']);
                                $exportList->Event_name = $this->CleanString($row['EventName']);
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
                                    $exportList->image = $this->CleanString($row['Image']);
                                    $exportList->About = $this->CleanString($row['About']);
                                    $exportList->Start_time = $this->CleanString($row['start_time']);
                                    $exportList->End_time = $this->CleanString($row['end_time']);
                                    $exportList->Event_name = $this->CleanString($row['EventName']);

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
    protected function library_view()
    {

        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` ORDER BY `id` DESC limit 4");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $ExportSend = new \stdClass();
                $name = $this->validate($data['name']);
                $Author = $this->validate($data['Author']);
                $unique_id = $this->validate($data['unique_id']);
                $source = $this->validate($data['Source']);
                $coverImage = $this->validate($data['cover_img']);

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->name = $name;
                $ExportSend->Author = $Author;
                $ExportSend->Image = $coverImage;
                $ExportSend->source = $source;
                $ExportSendMain->$unique_id = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'No Records available';
        }
        return $exportData;
    }
    protected function library_view_collection()
    {

        $exportData = '';
        $total = 100;
        $totalFiles = $this->data_connect()->prepare("SELECT max(`id`) as total FROM `zoe_library`.`datacollections` ORDER BY `id` ");
        if (!$totalFiles->execute()) {
            $totalFiles = null;
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        if ($totalFiles->rowCount() > 0) {
            $result = $totalFiles->fetchAll();
            $total = $result[0]['total'];

        }
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` ORDER BY `id` DESC limit $total OFFSET 4");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            foreach ($result as $data) {
                $ExportSend = new \stdClass();
                $name = $this->validate($data['name']);
                $Author = $this->validate($data['Author']);
                $unique_id = $this->validate($data['unique_id']);
                $source = $this->validate($data['Source']);
                $coverImage = $this->validate($data['cover_img']);
                $ExportSend->Image = $coverImage;
                $ExportSend->UniqueId = $unique_id;
                $ExportSend->name = $name;
                $ExportSend->Author = $Author;
                $ExportSend->source = $source;
                $ExportSendMain->$unique_id = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'No Records available';
        }
        return $exportData;
    }
    protected function library_vid_fetch($vid_id)
    {

        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` where `unique_id`='$vid_id'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $ExportSendMain = new \stdClass();
            $resultData = $result[0]['unique_id'];
            $seriesActive = 'none';
            $stmtSeries = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`library_records` where `unique_id`='$resultData'");
            if (!$stmtSeries->execute()) {
                $stmtSeries = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmtSeries->rowCount() > 0) {
                $resultD = $stmtSeries->fetchAll();
                $seriesActive = new \stdClass();
                foreach ($resultD as $data) {
                    $seriesActiveMin = new \stdClass();
                    $name = $this->validate($data['filename']);
                    $Date = $this->validate($data['date']);
                    $source = $this->validate($data['source']);
                    $seriesActiveMin->name = $name;
                    $seriesActiveMin->Date = $Date;
                    $seriesActiveMin->source = $source;

                    $unique_id = rand(time(), 1023);

                    $seriesActive->$unique_id = $seriesActiveMin;
                }

            }

            foreach ($result as $data) {
                $ExportSend = new \stdClass();
                $name = $this->validate($data['name']);
                $Author = $this->validate($data['Author']);
                $unique_id = $this->validate($data['unique_id']);
                $Date = $this->validate($data['Date']);
                $source = $this->validate($data['Source']);
                $category = $this->validate($data['category']);
                $coverImg = $this->validate($data['cover_img']);
                $Obj = $seriesActive;
                if ($seriesActive != 'none') {
                    $Obj = json_encode($seriesActive);
                }

                $ExportSend->UniqueId = $unique_id;
                $ExportSend->name = $name;
                $ExportSend->Author = $Author;
                $ExportSend->Date = $Date;
                $ExportSend->source = $source;
                $ExportSend->category = $category;
                $ExportSend->Image = $coverImg;
                $ExportSend->series = $Obj;
                $ExportSendMain->$unique_id = $ExportSend;
            }
            $exportData = json_encode($ExportSendMain);
        } else {
            $exportData = 'No Records available';
        }
        return $exportData;
    }
    protected function library_vid_fetch_similar($vid_id)
    {

        $exportData = '';
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` where `unique_id`='$vid_id'");
        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encountered a problem';
            exit(json_encode($Error));
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $DName = $result[0]['category'];
            $pattern = '/\,/';
            if (preg_match($pattern, $DName)) {
                $explode = explode(',', $DName);
                $DName = $explode[0];
            }


            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` where `category` like '%$DName%' AND `unique_id` !='$vid_id'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $ExportSendMain = new \stdClass();
                foreach ($result as $data) {
                    $ExportSend = new \stdClass();
                    $name = $this->validate($data['name']);
                    $Author = $this->validate($data['Author']);
                    $unique_id = $this->validate($data['unique_id']);
                    $date = $this->validate($data['Date']);
                    $coverImage = $this->validate($data['cover_img']);
                    $ExportSend->Image = $coverImage;
                    $ExportSend->UniqueId = $unique_id;
                    $ExportSend->name = $name;
                    $ExportSend->Author = $Author;
                    $ExportSend->date = $date;
                    $ExportSendMain->$unique_id = $ExportSend;
                }
                $exportData = json_encode($ExportSendMain);
            } else {
                $exportData = 'No Records available';
            }


        } else {
            $exportData = 'No Records available';
        }
        return $exportData;
    }
    protected function library_vid_simple_search($key)
    {
        $exportData = '';
        $pattern = '/\s/';

        if (preg_match($pattern, $key)) {
            $explode = explode(' ', $key);
            $ExportSendMain = new \stdClass();
            foreach ($explode as $item) {
                $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` where `name` like '%$item%' OR category like '%$item%'");
                if (!$stmt->execute()) {
                    $stmt = null;
                    $Error = 'Fetching data encountered a problem';
                    exit(json_encode($Error));
                }
                if ($stmt->rowCount() > 0) {
                    $result = $stmt->fetchAll();
                    foreach ($result as $data) {
                        $ExportSend = new \stdClass();
                        $name = $this->validate($data['name']);
                        $Author = $this->validate($data['Author']);
                        $unique_id = $this->validate($data['unique_id']);
                        $source = $this->validate($data['Source']);
                        $coverImage = $this->validate($data['cover_img']);

                        $ExportSend->Image = $coverImage;
                        $ExportSend->UniqueId = $unique_id;
                        $ExportSend->name = $name;
                        $ExportSend->Author = $Author;
                        $ExportSend->source = $source;
                        $ExportSendMain->$unique_id = $ExportSend;
                    }
                }
            }

            $cond = true;
            foreach ($ExportSendMain as $item) {
                $cond = false;
            }
            if ($cond == false) {
                $exportData = json_encode($ExportSendMain);
            } else {
                $exportData = "No Records available";

            }
        } else {
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoe_library`.`datacollections` where `name` like '%$key%' OR category like '%$key%'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = 'Fetching data encountered a problem';
                exit(json_encode($Error));
            }
            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetchAll();
                $ExportSendMain = new \stdClass();
                foreach ($result as $data) {
                    $ExportSend = new \stdClass();
                    $name = $this->validate($data['name']);
                    $Author = $this->validate($data['Author']);
                    $unique_id = $this->validate($data['unique_id']);
                    $source = $this->validate($data['Source']);
                    $coverImage = $this->validate($data['cover_img']);

                    $ExportSend->Image = $coverImage;
                    $ExportSend->UniqueId = $unique_id;
                    $ExportSend->name = $name;
                    $ExportSend->Author = $Author;
                    $ExportSend->source = $source;
                    $ExportSendMain->$unique_id = $ExportSend;
                }
                $exportData = json_encode($ExportSendMain);
            } else {
                $exportData = "No Records available";
            }
        }
        return $exportData;
    }
}
?>