<?php
session_start();
require '../../API/vendor/autoload.php';
$FinanceDataClass = new Finance\viewData();
$PartnerDataClass = new Partnership\viewData();
$ProjectsDataClass = new AssetProject\viewData();
$EventDataClass = new Calender\viewData();
$MemberDataClass = new Membership\viewData();
$login_details = '1323332734';
$condition = false;

if ($login_details) {
    $_SESSION['login_details'] = $login_details;

    if (!isset($_SESSION['entryLog'])) {
        $date = date('Y-m-d H:i:s');
        $newquest = $MemberDataClass->DataHistory($login_details, "Admin logged in", $date, "Dashboard homepage", "Admin logged in to dashboard");
        $decode = json_decode($newquest);
        if ($decode == 'Success') {
            $condition = true;
            $_SESSION['entryLog'] = true;
        }
    } else {
        $condition = true;
    }
}
$CheckYearBudget = 'zoe_' . date('Y') . '_budget';
if (!$FinanceDataClass->CheckBudget($CheckYearBudget)) {
    if ($FinanceDataClass->CreateBudget($CheckYearBudget)) {
        $condition = true;
        echo 'Set';
    } else {
        $condition = false;
    }

}
if ($condition) {
    ?>

    <div class="container">
        <div class="grid_container">
            <div class="upper_grid">
                <header class="title">Overview</header>
                <div class="cover">
                    <div class="event_slider">
                        <div class="events" id="sliderMain">
                            <?php
                            $year = date('Y');
                            $data = $EventDataClass->viewList($year);
                            if ($data == "Fetching data encountered a problem" || $data == 'Error Occurred' || $data == 'No Records Available') {
                                echo "error";
                            } else {
                                $data = json_decode($data);
                                foreach ($data as $EventData) {
                                    $About = $EventData->about;
                                    if (strlen($About) > 72) {
                                        $About = substr($About, 0, 72) . '........';
                                    }
                                    $date = $EventData->Year . '-' . $EventData->Month . '-' . $EventData->Day;
                                    $Fdate = new DateTimeImmutable($date);
                                    echo ' <div class="item">
                                <div class="image">
                                    <img src="../../API/images/calenda/' . $EventData->image . '" alt="" />
                                </div>
                                <div class="overlay"></div>
                                <div class="details">
                                    <header>' . $EventData->name . '</header>
                                    <p>' . $About . '</p>
                                    <p>' . $Fdate->format('jS F Y') . '</p>
                                </div>
                            </div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="cover_title">
                            <h1>Upcoming Events</h1>
                        </div>
                    </div>
                    <div hidden id="chartData">
                        <?php
                        function declareName($tableValue)
                        {
                            if ($tableValue == "0" || $tableValue == 0) {
                                $tableValue = "-";
                            }

                        }
                        $Year = date('Y');
                        $dataTithe = $FinanceDataClass->BudgetList($Year);
                        $DecodedData = json_decode($dataTithe);
                        $tithe = $DecodedData->INCOME->tithe;
                        print_r(json_encode($tithe));
                        ?>
                    </div>
                    <div class="tithe_event" id="charts_data"></div>


                    <div class="projects_section">
                        <div class="membership_status">
                            <img src="../../images/security.gif" />

                        </div>
                        <?php
                        $data = $ProjectsDataClass->GetLatestStatus();
                        if ($data == "Fetching data encountered a problem" || $data == 'Error Occurred' || $data == 'No Records Available') {
                            echo "error";
                        } else {
                            $data_New = json_decode($data);
                            $count = 1;
                            $status = 1;
                            foreach ($data_New as $value) {
                                if (strpos($value, 'complete')) {
                                    $status++;
                                }
                                $count++;
                            }
                            ?>
                            <div class="project_status">
                                <div class="coverlay"
                                    style="--percentage:<?php echo (((100 * $status) / $count) / 10 * 36) . 'deg' ?>">
                                    <div class="innerlay">
                                        <h1>
                                            <?php
                                            $num_val = (100 * $status) / $count;
                                            $number_dp = number_format($num_val, 2, '.', ' ') . '%';
                                            echo $number_dp;

                        }
                        ?>
                                    </h1>
                                    <p>projects</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="transactions">
                <header class="title">Transactions</header>
                <div class="container_list">
                    <?php
                    $data = $FinanceDataClass->TransactionList('1');
                    if ($data == "" || $data == 'Error Occurred' || $data == 'Not Records Available') {
                        echo "<header class='danger'>AN ERROR OCCURRED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                    } else {
                        $data_New = json_decode($data);
                        $i = 0;
                        foreach ($data_New as $item) {
                            if ($i < 5) {
                                $account = $item->account;
                                $amount = $item->amount;
                                $date = $item->Date;
                                $category = $item->category;
                                $Authorize = $item->Authorize;
                                $Status = $item->Status;

                                $Fdate = new DateTimeImmutable($date);
                                echo '<div class="item">
                                        <div class="cover_main">
                                            <div class="acc_name">
                                                <div class="logo"><img src="../../images/logos/Capital_Bank_logo.png" alt="logo" /></div>
                                                <h1>' . $account . '</h1>
                                            </div>
                                            <div class="date">
                                                <span>Category</span>
                                                <p>' . $Fdate->format('jS F Y') . '</p>
                                            </div>
                                            <div class="time">
                                                <span>Time</span>
                                                <p>' . $category . '</p>
                                            </div>
                                            <div class="amount">
                                                <span>Amount</span>
                                                <p>Ȼ ' . $amount . '</p>
                                            </div>
                                            <div class="status">
                                                <div class="status_check">
                                                    <p>' . $Status . '</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                $i++;
                            } else {
                                break;
                            }

                        }

                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="wallet">
            <div class="display_wallet">
                <div class="title">
                    <b>Wallet</b>
                </div>
                <div class="content_dash">
                    <div class="main">
                        <div class="card">
                            <div class="header">
                                <img src="../../images/visa.png" alt="card1-1">

                                <img src="../../images/card chip.png" class="right" alt="card-chip">
                            </div>
                            <div class="middle">
                                <?php

                                $data = json_decode($FinanceDataClass->Accounts_list_Card());
                                if ($data != "" || $data != "Fetch data encountered an error") {
                                    $i = 0;
                                    foreach ($data as $item) {
                                        if ($i < 1) {
                                            $amount = number_format(($item->amount), 2, '.', ',');
                                            $modified = $item->modified;
                                            $name = $item->name;
                                            echo ' <span>Active balance</span>
                                <h1>Ȼ ' . $amount . '</h1>';
                                            $i++;
                                            ?>
                                        </div>

                                        <div class="bottom">
                                            <div class="" style="padding:10px;">
                                                <?php
                                                $Fdate = new DateTimeImmutable($modified);
                                                echo '<p style="font-size:15px;">' . $name . '</p>
                                                <p style="font-size:13px;text-transform:lowercase;">' . $Fdate->format('jS F Y') . '</p>';
                                        }
                                    }
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overlay">
                        <b>+</b>
                    </div>
                </div>
            </div>

            <div class="display">
                <div class="header">
                    <b>Partners</b>
                    <b>..</b>
                </div>
                <div class="content_dash">
                    <?php
                    $Year = date('Y');
                    $data = json_decode($PartnerDataClass->HomeFetch($Year));
                    if ($data == "" || $data == 'Error Occurred' || $data == 'Not Records Available') {
                        echo "<p>" . $data . "</p>";
                    } else {
                        echo '<p>The partnership program has generated a total of <b style="color:crimson;"> Ȼ  ' . $data . ' </b> since january ' . $Year . '</p>';
                    }
                    ?>
                </div>
            </div>
            <div class="members">
                <div class="header">
                    <b>membership</b>
                    <b><?php
                    $data = json_decode($MemberDataClass->viewpages());
                    if ($data == "" || $data == 'Error Occurred' || $data == 'Not Records Available') {
                        echo "error";
                    } else {
                        echo $data . "+";
                    }
                    ?></b>
                </div>
                <div class="content_dash">
                    <?php
                    $memberView = $MemberDataClass->viewList(1);
                    if ($memberView == "" || $memberView == 'Error Occurred' || $memberView == 'Not Records Available' || $memberView == 'Fetching data encounted a problem') {
                        echo "<header class='danger'>AN ERROR OCCURRED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                    } else {
                        $memberView_New = json_decode($memberView);
                        $i = 0;
                        foreach ($memberView_New as $item) {
                            $item = json_decode($item);
                            if ($i < 6) {
                                echo '<img src="../../API/images_folder/users/' . $item->image . '" alt="">';
                            }
                            $i++;
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="others">
                <div class="header">
                    <b>Recent</b>
                </div>
                <div class="content_dash">
                    <?php
                    if ($memberView == "" || $memberView == 'Error Occurred' || $memberView == 'Not Records Available') {
                        echo "<header class='danger'>AN ERROR OCCURRED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                    } else {
                        $memberView_New = json_decode($memberView);
                        $i = 0;
                        foreach ($memberView_New as $item) {
                            $item = json_decode($item);
                            if ($i < 2) {
                                echo '
                                  <div class="item">
                        <div class="image">
                            <img src="../../API/images_folder/users/' . $item->image . '" alt="">
                        </div>
                        <div class="details">
                            <p><b>' . $item->Fname . ' ' . $item->Oname . '</b></p>
                            <p>' . $item->occupation . '</p>
                        </div>
                    </div>';
                                $i++;

                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

?>