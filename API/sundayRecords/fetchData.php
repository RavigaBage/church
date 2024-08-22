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
    protected function sunday_upload_data($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $date)
    {

        $input_list = array($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $date);
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

            $unique_id = rand(time(), 1999);

            $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`sunday_records`(`unique_id`,`opening_prayer`, `praises`, `scripture_reading`, `scripture`, `opening_Hymn`, `Hymn_new`, `Hymn_title`, `worship`, `testimonies`, `song_thanksgving_offering`, `sermon_prayer`, `sermon_from`, `scripture_preacher`, `peacher_duration`, `alter_call`, `tithe_offering`, `special_appeal`, `welcome_visitors`, `Announcement`, `closing_prayer`, `Benediction`, `MC`, `Total_attendance`, `date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

            $stmt->bindParam('1', $unique_id, PDO::PARAM_STR);
            $stmt->bindParam('2', $opening_prayer, PDO::PARAM_STR);
            $stmt->bindParam('3', $praises, PDO::PARAM_STR);
            $stmt->bindParam('4', $scripture_reading, PDO::PARAM_STR);
            $stmt->bindParam('5', $scripture, PDO::PARAM_STR);
            $stmt->bindParam('6', $opening_Hymn, PDO::PARAM_STR);
            $stmt->bindParam('7', $Hymn_new, PDO::PARAM_STR);
            $stmt->bindParam('8', $Hymn_title, PDO::PARAM_STR);
            $stmt->bindParam('9', $worship, PDO::PARAM_STR);
            $stmt->bindParam('10', $testimonies, PDO::PARAM_STR);
            $stmt->bindParam('11', $song_thanksgving_offering, PDO::PARAM_STR);
            $stmt->bindParam('12', $sermon_prayer, PDO::PARAM_STR);
            $stmt->bindParam('13', $sermon_from, PDO::PARAM_STR);
            $stmt->bindParam('14', $scripture_preacher, PDO::PARAM_STR);
            $stmt->bindParam('15', $peacher_duration, PDO::PARAM_STR);
            $stmt->bindParam('16', $alter_call, PDO::PARAM_STR);
            $stmt->bindParam('17', $tithe_offering, PDO::PARAM_STR);
            $stmt->bindParam('18', $special_appeal, PDO::PARAM_STR);
            $stmt->bindParam('19', $welcome_visitors, PDO::PARAM_STR);
            $stmt->bindParam('20', $Announcement, PDO::PARAM_STR);
            $stmt->bindParam('21', $closing_prayer, PDO::PARAM_STR);
            $stmt->bindParam('22', $Benediction, PDO::PARAM_STR);
            $stmt->bindParam('23', $MC, PDO::PARAM_STR);
            $stmt->bindParam('24', $Total_attendance, PDO::PARAM_STR);
            $stmt->bindParam('25', $date, PDO::PARAM_STR);


            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problems');
                exit($Error);
            } else {
                $exportData = json_encode(["status" => "success", "message" => 'Data entry was a success Page will refresh to display new data', "id" => $unique_id]);
                $resultValidate = true;
                exit($exportData);
            }

        } else {
            $exportData = json_encode('Unknown error, please try again');
            $resultValidate = true;
            exit($exportData);
        }
        if ($resultValidate) {
            return $exportData;
        } else {
            return $resultValidate;
        }
    }

    protected function Sunday_update_data($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $date, $id)
    {
        $input_list = array($opening_prayer, $praises, $scripture_reading, $scripture, $opening_Hymn, $Hymn_new, $Hymn_title, $worship, $testimonies, $song_thanksgving_offering, $sermon_prayer, $sermon_from, $scripture_preacher, $peacher_duration, $alter_call, $tithe_offering, $special_appeal, $welcome_visitors, $Announcement, $closing_prayer, $Benediction, $MC, $Total_attendance, $date, $id);
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`sunday_records` where `unique_id`='$id'");
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
                    $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`sunday_records` set  `opening_prayer`=?,`praises`=?,`scripture_reading`=?,`scripture`=?,`opening_Hymn`=?,`Hymn_new`=?,`Hymn_title`=?,`worship`=?,`testimonies`=?,`song_thanksgving_offering`=?,`sermon_prayer`=?,`sermon_from`=?,`scripture_preacher`=?,`peacher_duration`=?,`alter_call`=?,`tithe_offering`=?,`special_appeal`=?,`welcome_visitors`=?,`Announcement`=?,`closing_prayer`=?,`Benediction`=?,`MC`=?,`Total_attendance`=?,`date`=? where `unique_id` = ?");
                    $stmt->bindParam('1', $opening_prayer, PDO::PARAM_STR);
                    $stmt->bindParam('2', $praises, PDO::PARAM_STR);
                    $stmt->bindParam('3', $scripture_reading, PDO::PARAM_STR);
                    $stmt->bindParam('4', $scripture, PDO::PARAM_STR);
                    $stmt->bindParam('5', $opening_Hymn, PDO::PARAM_STR);
                    $stmt->bindParam('6', $Hymn_new, PDO::PARAM_STR);
                    $stmt->bindParam('7', $Hymn_title, PDO::PARAM_STR);
                    $stmt->bindParam('8', $worship, PDO::PARAM_STR);
                    $stmt->bindParam('9', $testimonies, PDO::PARAM_STR);
                    $stmt->bindParam('10', $song_thanksgving_offering, PDO::PARAM_STR);
                    $stmt->bindParam('11', $sermon_prayer, PDO::PARAM_STR);
                    $stmt->bindParam('12', $sermon_from, PDO::PARAM_STR);
                    $stmt->bindParam('13', $scripture_preacher, PDO::PARAM_STR);
                    $stmt->bindParam('14', $peacher_duration, PDO::PARAM_STR);
                    $stmt->bindParam('15', $alter_call, PDO::PARAM_STR);
                    $stmt->bindParam('16', $tithe_offering, PDO::PARAM_STR);
                    $stmt->bindParam('17', $special_appeal, PDO::PARAM_STR);
                    $stmt->bindParam('18', $welcome_visitors, PDO::PARAM_STR);
                    $stmt->bindParam('19', $Announcement, PDO::PARAM_STR);
                    $stmt->bindParam('20', $closing_prayer, PDO::PARAM_STR);
                    $stmt->bindParam('21', $Benediction, PDO::PARAM_STR);
                    $stmt->bindParam('22', $MC, PDO::PARAM_STR);
                    $stmt->bindParam('23', $Total_attendance, PDO::PARAM_STR);
                    $stmt->bindParam('24', $date, PDO::PARAM_STR);
                    $stmt->bindParam('25', $id, PDO::PARAM_STR);
                    if (!$stmt->execute()) {
                        print_r($stmt->errorInfo());
                        $stmt = null;

                        $Error = json_encode('Fetching data encountered a problems');
                        exit($Error);
                    } else {
                        $exportData = json_encode('Data entry was a success Page will refresh to display new data');
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

    protected function Sunday_delete_data($name)
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
            $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`sunday_records` where `unique_id` ='$name'");
            if (!$stmt->execute()) {
                $stmt = null;
                $Error = json_encode('Fetching data encountered a problem');
                exit($Error);
            }
            if ($stmt->rowCount() > 0) {
                /////////////////////drop table
                $stmt1 = $this->data_connect()->prepare("DELETE FROM `zoeworshipcentre`.`sunday_records` where `unique_id`=?");
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
                exit('No match for search query');
            }

            if ($resultCheck) {
                return $exportData;
            } else {
                return $resultCheck;
            }

        }
    }
    protected function Sunday_view($year)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`sunday_records` where `date` like '%$year%' ORDER BY `id` DESC");

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = json_encode('Fetching data encounted a problem');
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            $exportMain = new stdClass();
            foreach ($result as $data) {
                $id = $data['unique_id'];
                $export_item = new stdClass();
                $export_item->open_prayer = $data['opening_prayer'];
                $export_item->praise = $data['praises'];
                $export_item->scripture_read = $data['scripture_reading'];
                $export_item->scripture = $data['scripture'];
                $export_item->hymn = $data['opening_Hymn'];
                $export_item->hymn_new = $data['Hymn_new'];
                $export_item->hymn_title = $data['Hymn_title'];
                $export_item->worship = $data['worship'];
                $export_item->testimonies = $data['testimonies'];
                $export_item->song_thanksgivning = $data['song_thanksgving_offering'];
                $export_item->sermon_prayer = $data['sermon_prayer'];
                $export_item->sermon_from = $data['sermon_from'];
                $export_item->scipture_preacher = $data['scripture_preacher'];
                $export_item->preacher_duration = $data['peacher_duration'];
                $export_item->alter_call = $data['alter_call'];
                $export_item->tithe_offering = $data['tithe_offering'];
                $export_item->special_appeal = $data['special_appeal'];
                $export_item->welcome_visitors = $data['welcome_visitors'];
                $export_item->annc = $data['Announcement'];
                $export_item->closing_prayer = $data['closing_prayer'];
                $export_item->Benediction = $data['Benediction'];
                $export_item->mc = $data['MC'];
                $export_item->total_attendance = $data['Total_attendance'];
                $export_item->date = $data['date'];
                $export_item->id = $data['unique_id'];
                $exportMain->$id = $export_item;
            }
            $exportData = json_encode($exportMain);
        } else {
            $resultCheck = false;
            $exportData = json_encode('Not Records Available');
        }
        return $exportData;

    }

    protected function RecordsFilter($date)
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`sunday_records` where `date`='$date' ORDER BY `id` DESC");

        if (!$stmt->execute()) {
            $stmt = null;
            $Error = 'Fetching data encounted a problem';
            exit($Error);
        }
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $data) {

                $open_prayer = $data['opening_prayer'];
                $praise = $data['praises'];
                $scripture_read = $data['scripture_reading'];
                $scripture = $data['scripture'];
                $hymn = $data['opening_Hymn'];
                $hymn_new = $data['Hymn_new'];
                $hymn_title = $data['Hymn_title'];
                $worship = $data['worship'];
                $testimonies = $data['testimonies'];
                $song_thanksgivning = $data['song_thanksgving_offering'];
                $sermon_prayer = $data['sermon_prayer'];
                $sermon_from = $data['sermon_from'];
                $scipture_preacher = $data['scripture_preacher'];
                $preacher_duration = $data['peacher_duration'];
                $alter_call = $data['alter_call'];
                $tithe_offering = $data['tithe_offering'];
                $special_appeal = $data['special_appeal'];
                $welcome_visitors = $data['welcome_visitors'];
                $annc = $data['Announcement'];
                $closing_prayer = $data['closing_prayer'];
                $Benediction = $data['Benediction'];
                $mc = $data['MC'];
                $total_attendance = $data['Total_attendance'];
                $date = $data['date'];
                $item = "";
                $id = $data['unique_id'];
                $exportData .= '  
                
                <div class="annc_item">
                <div class="flex button">
                    <div class=" flex title">
                        <h1>Sunday Record ' . $sermon_from . '</h1>
                        <div class="flex button"><i class="fas fa-date"></i>' . $date . '</div>
                    </div>
                </div>

                <div class="div_content">
                    <details>
                    <form form-id=' . $id . '>
                        <div class="Activity_record">
                            <div class="cate_view">
                                <div class="field">
                                    <label>Opening Prayer led By</label>
                                    <input type="text" value=' . $open_prayer . ' placeholder="' . $open_prayer . '" name="opening_prayer" />
                                </div>
                                <div class="field">
                                    <label>Praises By:</label>
                                    <input type="text" name="praises" placeholder="' . $praise . '" value=' . $praise . ' />
                                </div>
                            </div>
                            <header>Scripture reading</header>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Scripture Reading By</label>
                                    <input type="text" name="scripture_reading" placeholder="' . $scripture_read . '" value=' . $scripture_read . ' />
                                </div>
                                <div class="field">
                                    <label>Scripture read:</label>
                                    <input type="text" name="scripture" placeholder="' . $scripture . '" value=' . $scripture . ' />
                                </div>
                            </div>

                            <header>Hymn</header>
                            <div class="cate_view_e">
                                <div class="field">
                                    <label>Opening Hymn No</label>
                                    <input type="text" name="opening_Hymn" placeholder="' . $hymn . '" value=' . $hymn . ' />
                                </div>
                                <div class="field">
                                    <label>New:</label>
                                    <input type="text" name="Hymn_new" placeholder="' . $hymn_new . '" value=' . $hymn_new . ' />
                                </div>
                                <div class="field">
                                    <label>Title:</label>
                                    <input type="text" name="Hymn_title" placeholder="' . $hymn_title . '" value=' . $hymn_title . ' />
                                </div>
                            </div>
                            <div class="field">
                                <label>Call to worship</label>
                                <input type="text" name="worship" placeholder="' . $worship . '" value=' . $worship . ' />
                            </div>
                            <div class="field">
                                <label>Testimonies</label>
                                <input type="text" name="testimonies" value=' . $testimonies . ' placeholder="' . $testimonies . '" />
                            </div>
                            <div class="field">
                                <label>Song Ministration & Thanksgiving Offering:</label>
                                <input type="text" name="song_thanksgving_offering" value=' . $song_thanksgivning . ' placeholder="' . $song_thanksgivning . '" />
                            </div>

                            <header>Sermon</header>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Sermon & Prayer By:</label>
                                    <input type="text" name="sermon_prayer" value=' . $sermon_prayer . ' placeholder="' . $sermon_prayer . '" />
                                </div>
                                <div class="field">
                                    <label>From:</label>
                                    <input type="text" name="sermon_from" value=' . $sermon_from . ' placeholder="' . $sermon_from . '" />
                                </div>
                            </div>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Scripture from preacher:</label>
                                    <input type="text" name="scripture_preacher" value=' . $scipture_preacher . ' placeholder="' . $scipture_preacher . '" />
                                </div>
                                <div class="field">
                                    <label>Time Duratoin for the preacher:</label>
                                    <input type="text" name="peacher_duration" placeholder="' . $preacher_duration . ' value=' . $preacher_duration . '"/>
                                </div>
                            </div>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Alter Call By:</label>
                                    <input type="text" name="alter_call" placeholder="' . $alter_call . '" value=' . $alter_call . ' />
                                </div>
                                <div class="field">
                                    <label>Tithe and Offering</label>
                                    <input type="text" name="tithe_offering" placeholder="' . $tithe_offering . '" value=' . $tithe_offering . ' />
                                </div>
                            </div>
                            <div class="field">
                                <label>Special Appeal</label>
                                <input type="text"  name="special_appeal" placeholder="' . $special_appeal . '" value=' . $special_appeal . ' />
                            </div>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Welcome of visitors</label>
                                    <input type="text" name="welcome_visitors" value=' . $welcome_visitors . ' placeholder="' . $welcome_visitors . '" />
                                </div>
                                <div class="field">
                                    <label>Announcement</label>
                                    <input type="text" name="Announcement" placeholder="' . $annc . '" value=' . $annc . ' />
                                </div>
                            </div>
                            <header>Closing..</header>
                            <div class="field">
                                <label>Closing Prayer</label>
                                <input type="text" name="closing_prayer" value=' . $closing_prayer . ' placeholder="' . $closing_prayer . '" />
                            </div>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Benediction</label>
                                    <input type="text" name="Benediction" value=' . $Benediction . ' placeholder="' . $Benediction . '" />
                                </div>
                                <div class="field">
                                    <label>Mc</label>
                                    <input type="text" name="MC" placeholder="' . $mc . '" value=' . $mc . ' />
                                </div>
                            </div>
                            <div class="field">
                                <label>Total Attendance</label>
                                <input type="text" name="Total_attendance" value=' . $total_attendance . ' placeholder="' . $total_attendance . '" />
                            </div>
                            <div class="field">
                                        <label>Date</label>
                                        <input type="date" name="date" placeholder="" value=' . $date . ' />
                                    </div>
                          <button>Record message</button>
                        </div>
                        </form>
                    </details>
                </div>
                    <div class=" flex options title">
                        <div class="edit flex Update_item">
                            <i class="fas fa-edit Update_item"></i>
                            <p>Edit</p>
                        </div>

                        <div class="edit flex">
                            <i class="fas fa-trash delete_item"></i>
                            <p>Remove</p>
                        </div>
                    </div>
            </div>';

            }
        } else {
            $resultCheck = false;
            $exportData = '<header>Not Records Available</header>';
        }
        return $exportData;

    }


}