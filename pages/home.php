<?php
session_start();
$login_details = '1323332734';
include('../API/membership/autoloader.php');
$viewDataClass = new viewData();
$condition = false;
if ($login_details) {
    $_SESSION['login_details'] = $login_details;
    if (!isset($_SESSION['entryLog'])) {
        $date = date('Y-m-d H:i:s');
        $newquest = $viewDataClass->DataHistory($login_details, "Admin logged in", $date, "Dashboard homepage", "Admin logged in to dashboard");
        $decode = json_decode($newquest);
        if ($decode == 'Success') {
            $condition = true;
            $_SESSION['entryLog'] = true;
        }
    } else {
        $condition = true;
    }
}
if ($condition) {
    ?>
    <div class="content menu_home page active" data-page="homepage">
        <div class="visual_session">
            <div class="graph_container">
                <!-------------------containing a church performance data-->
                <div id="chart"></div>
            </div>
            <div class="table_container">
                <div class=""></div>
                <header>Records</header>
                <div class="records_table">
                    <!-------------------containing a slider to view update,upcoming and milestone-->
                    <div class="slick">
                        <img src="images/bg (2).jpeg" alt="" />
                        <div class="data">
                            <h1>ZOMBIE LOOOM DAY PROJECT</h1>
                            <strong>Progress: <i class="fas fa-arrow-up"></i><span>1.23%</span> more
                                than
                                last modified</strong>
                            <strong>Project value: <i class="fas fa-wallet"></i><b>$3200</b></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="user_session">
            <div class="date_session">
                <!-------------------containing membership chart and data-->
                <div id="chart_2">
                    <img src="img/globe.jpg" alt="" />
                </div>
            </div>
            <div class="recent_data">
                <div class="recent_records">
                    <!-------------------containing a preview of conplaints, project history,requests,quest,violations-->
                    <header>Church data</header>
                    <div class="records_recent">
                        <div class="record_qs">

                            <p><i class="fas fa-check"></i> CHURCH VISITS</p>
                            <a>check it out ?</a>
                        </div>
                        <div class="record_qs uncheck">

                            <p>PROJECTS</p>
                            <a> <i class="fas fa-check"></i> 75% complete</a>
                        </div>
                        <div class="record_qs">
                            <p>ASSETS</p>
                            <a><i class="fas fa-check"></i> <span>23</span> Complete</a>
                        </div>

                        <div class="record_qs">
                            <p>Active User</p>
                            <a><i class="fas fa-check"></i> <span>123</span></a>
                        </div>

                        <div class="record_qs">
                            <p>Last modified </p>
                            <a>12.03.2024</a>
                        </div>
                        <div class="record_qs">
                            <p>Security issues </p>
                            <a>all clean</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    echo "<header>Sorry an Unexpected error occurred fetching this page</header>";
}
?>