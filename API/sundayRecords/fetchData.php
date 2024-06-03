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

            $stmt = $this->data_connect()->prepare("INSERT INTO `zoeworshipcentre`.`sunday_records`(`unique_id`,`opening prayer`, `praises`, `scripture reading`, `scripture`, `opening_Hymn`, `Hymn_new`, `Hymn_title`, `worship`, `testimonies`, `song_thanksgving_offering`, `sermon_prayer`, `sermon_from`, `scripture_preacher`, `peacher_duration`, `alter_call`, `tithe_offering`, `special_appeal`, `welcome_visitors`, `Announcement`, `closing_prayer`, `Benediction`, `MC`, `Total_attendance`, `date`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

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
                    $stmt = $this->data_connect()->prepare("UPDATE `zoeworshipcentre`.`sunday_records` set  `opening prayer`=?,`praises`=?,`scripture reading`=?,`scripture`=?,`opening_Hymn`=?,`Hymn_new`=?,`Hymn_title`=?,`worship`=?,`testimonies`=?,`song_thanksgving_offering`=?,`sermon_prayer`=?,`sermon_from`=?,`scripture_preacher`=?,`peacher_duration`=?,`alter_call`=?,`tithe_offering`=?,`special_appeal`=?,`welcome_visitors`=?,`Announcement`=?,`closing_prayer`=?,`Benediction`=?,`MC`=?,`Total_attendance`=?,`date`=? where `unique_id` = ?");
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
    protected function Sunday_view()
    {
        $exportData = '';
        $resultCheck = true;
        $stmt = $this->data_connect()->prepare("SELECT * FROM `zoeworshipcentre`.`sunday_records` ORDER BY `id` DESC");

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
                $id = $data['id'];
                $exportData .= '  
                
                <div class="annc_item">
                <div class="flex button">
                    <div class=" flex title">
                        <h1>Sunday Record no.- ' . $id . '</h1>
                        <div class="flex button"><i class="fas fa-date"></i>' . $date . '</div>
                    </div>
                </div>

                <div class="div_content">
                    <details>
                        <div class="Activity_record">
                            <div class="cate_view">
                                <div class="field">
                                    <label>Opening Prayer led By</label>
                                    <input type="text" placeholder="' . $open_prayer . '" />
                                </div>
                                <div class="field">
                                    <label>Praises By:</label>
                                    <input type="text" placeholder="' . $praise . '" />
                                </div>
                            </div>
                            <header>Scripture reading</header>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Scripture Reading By</label>
                                    <input type="text" placeholder="' . $scripture_read . '" />
                                </div>
                                <div class="field">
                                    <label>Scripture read:</label>
                                    <input type="text" placeholder="' . $scripture . '" />
                                </div>
                            </div>

                            <header>Hymn</header>
                            <div class="cate_view_e">
                                <div class="field">
                                    <label>Opening Hymn No</label>
                                    <input type="text" placeholder="' . $hymn . '" />
                                </div>
                                <div class="field">
                                    <label>New:</label>
                                    <input type="text" placeholder="' . $hymn_new . '" />
                                </div>
                                <div class="field">
                                    <label>Title:</label>
                                    <input type="text" placeholder="' . $hymn_title . '" />
                                </div>
                            </div>
                            <div class="field">
                                <label>Call to worship</label>
                                <input type="text" placeholder="' . $worship . '" />
                            </div>
                            <div class="field">
                                <label>Testimonies</label>
                                <input type="text" placeholder="' . $testimonies . '" />
                            </div>
                            <div class="field">
                                <label>Song Ministration & Thanksgiving Offering:</label>
                                <input type="text" placeholder="' . $song_thanksgivning . '" />
                            </div>

                            <header>Sermon</header>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Sermon & Prayer By:</label>
                                    <input type="text" placeholder="' . $sermon_prayer . '" />
                                </div>
                                <div class="field">
                                    <label>From:</label>
                                    <input type="text" placeholder="' . $sermon_from . '" />
                                </div>
                            </div>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Scripture from preacher:</label>
                                    <input type="text" placeholder="' . $scipture_preacher . '" />
                                </div>
                                <div class="field">
                                    <label>Time Duratoin for the preacher:</label>
                                    <input type="text" placeholder="' . $preacher_duration . '" />
                                </div>
                            </div>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Alter Call By:</label>
                                    <input type="text" placeholder="' . $alter_call . '" />
                                </div>
                                <div class="field">
                                    <label>Tithe and Offering</label>
                                    <input type="text" placeholder="' . $tithe_offering . '" />
                                </div>
                            </div>
                            <div class="field">
                                <label>Special Appeal</label>
                                <input type="text" placeholder="' . $special_appeal . '" />
                            </div>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Welcome of visitors</label>
                                    <input type="text" placeholder="' . $welcome_visitors . '" />
                                </div>
                                <div class="field">
                                    <label>Announcement</label>
                                    <input type="text" placeholder="' . $annc . '" />
                                </div>
                            </div>
                            <header>Closing..</header>
                            <div class="field">
                                <label>Closing Prayer</label>
                                <input type="text" placeholder="' . $closing_prayer . '" />
                            </div>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Benediction</label>
                                    <input type="text" placeholder="' . $Benediction . '" />
                                </div>
                                <div class="field">
                                    <label>Mc</label>
                                    <input type="text" placeholder="' . $mc . '" />
                                </div>
                            </div>
                            <div class="field">
                                <label>Total Attendance</label>
                                <input type="text" placeholder="' . $total_attendance . '" />
                            </div>
<button>Record message</button>
                        </div>
                    </details>
                </div>
                <div class=" flex options title">
                    <div class="edit flex">
                        <i class="fas fa-edit"></i>
                        <p>Edit</p>
                    </div>


                    <div class="edit flex">
                        <i class="fas fa-trash"></i>
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
                $id = $data['id'];
                $exportData .= '                  
                <div class="annc_item">
                <div class="flex button">
                    <div class=" flex title">
                        <h1>Sunday Record no.- ' . $id . '</h1>
                        <div class="flex button"><i class="fas fa-date"></i>' . $date . '</div>
                    </div>
                </div>

                <div class="div_content">
                    <details>
                        <div class="Activity_record">
                            <div class="cate_view">
                                <div class="field">
                                    <label>Opening Prayer led By</label>
                                    <input type="text" placeholder="' . $open_prayer . '" />
                                </div>
                                <div class="field">
                                    <label>Praises By:</label>
                                    <input type="text" placeholder="' . $praise . '" />
                                </div>
                            </div>
                            <header>Scripture reading</header>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Scripture Reading By</label>
                                    <input type="text" placeholder="' . $scripture_read . '" />
                                </div>
                                <div class="field">
                                    <label>Scripture read:</label>
                                    <input type="text" placeholder="' . $scripture . '" />
                                </div>
                            </div>

                            <header>Hymn</header>
                            <div class="cate_view_e">
                                <div class="field">
                                    <label>Opening Hymn No</label>
                                    <input type="text" placeholder="' . $hymn . '" />
                                </div>
                                <div class="field">
                                    <label>New:</label>
                                    <input type="text" placeholder="' . $hymn_new . '" />
                                </div>
                                <div class="field">
                                    <label>Title:</label>
                                    <input type="text" placeholder="' . $hymn_title . '" />
                                </div>
                            </div>
                            <div class="field">
                                <label>Call to worship</label>
                                <input type="text" placeholder="' . $worship . '" />
                            </div>
                            <div class="field">
                                <label>Testimonies</label>
                                <input type="text" placeholder="' . $testimonies . '" />
                            </div>
                            <div class="field">
                                <label>Song Ministration & Thanksgiving Offering:</label>
                                <input type="text" placeholder="' . $song_thanksgivning . '" />
                            </div>

                            <header>Sermon</header>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Sermon & Prayer By:</label>
                                    <input type="text" placeholder="' . $sermon_prayer . '" />
                                </div>
                                <div class="field">
                                    <label>From:</label>
                                    <input type="text" placeholder="' . $sermon_from . '" />
                                </div>
                            </div>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Scripture from preacher:</label>
                                    <input type="text" placeholder="' . $scipture_preacher . '" />
                                </div>
                                <div class="field">
                                    <label>Time Duratoin for the preacher:</label>
                                    <input type="text" placeholder="' . $preacher_duration . '" />
                                </div>
                            </div>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Alter Call By:</label>
                                    <input type="text" placeholder="' . $alter_call . '" />
                                </div>
                                <div class="field">
                                    <label>Tithe and Offering</label>
                                    <input type="text" placeholder="' . $tithe_offering . '" />
                                </div>
                            </div>
                            <div class="field">
                                <label>Special Appeal</label>
                                <input type="text" placeholder="' . $special_appeal . '" />
                            </div>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Welcome of visitors</label>
                                    <input type="text" placeholder="' . $welcome_visitors . '" />
                                </div>
                                <div class="field">
                                    <label>Announcement</label>
                                    <input type="text" placeholder="' . $annc . '" />
                                </div>
                            </div>
                            <header>Closing..</header>
                            <div class="field">
                                <label>Closing Prayer</label>
                                <input type="text" placeholder="' . $closing_prayer . '" />
                            </div>
                            <div class="cate_view">
                                <div class="field">
                                    <label>Benediction</label>
                                    <input type="text" placeholder="' . $Benediction . '" />
                                </div>
                                <div class="field">
                                    <label>Mc</label>
                                    <input type="text" placeholder="' . $mc . '" />
                                </div>
                            </div>
                            <div class="field">
                                <label>Total Attendance</label>
                                <input type="text" placeholder="' . $total_attendance . '" />
                            </div>
<button>Record message</button>
                        </div>
                    </details>
                </div>
                <div class=" flex options title">
                    <div class="edit flex">
                        <i class="fas fa-edit"></i>
                        <p>Edit</p>
                    </div>


                    <div class="edit flex">
                        <i class="fas fa-trash"></i>
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