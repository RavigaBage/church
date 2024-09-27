<?php
include_once('../../../API/notifications & token & history/autoloader.php');
session_start();
$newDataRequest = new viewData();
$val = 1;
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}
if (isset($_SESSION['Admin_access'])) {
    $login_details = $_SESSION['Admin_access'];
    if (!isset($_SESSION['access_entryLog'])) {
        $date = date('Y-m-d H:i:s');
        $newquest = $newDataRequest->DataHistory($login_details, "Access page selection", $date, "Access page section", "Admin Viewed Access page section");
        $decode = json_decode($newquest);
        if ($decode == 'Success') {
            $condition = true;
            $_SESSION['access_entryLog'] = true;
        }
    } else {
        $condition = true;
    }
} else {
    $condition = false;
}

if ($condition) {
    ?>

    <div class="content_pages">
        <div class="content_page_event">
            <div class="records_table">
                <table>
                    <thead>
                        <tr>
                            <th>event name</th>
                            <th>event action</th>
                            <th>recorded date</th>
                            <th>site naem</th>
                            <th>Status</th>
                        </tr>
                    </thead>


                    <tbody>

                        <?php
                        $data = json_decode($newDataRequest->getHistory($val));
                        if ($data != "" || $data != "Fetching data encountered a problem" || $data != "no data found") {
                            foreach ($data as $item) {
                                $name = $item->name;
                                $event = $item->event;
                                $date = $item->date;
                                $sitename = $item->sitename;
                                $action = $item->action;

                                echo "<tr>
                                <td><div class='details'>
                                <div class='text'>
                                <p>" . $name . "</p>
                                <p>" . $date . "</p>
                                </div>
                                </div></td>
                                <td class='td_action'>" . $action . "</td>
                                <td class='td_action'>" . $sitename . "</td>
                                
                                <td class='td_action'>" . $event . "</td>
                                </tr>";
                            }
                        } else {
                            echo $data;
                        }
                        ?>

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <div class="page_sys">
        <?php
        if (isset($_SESSION['total_pages_history'])) {
            $total = $_SESSION['total_pages_history'];
        } else {
            $total = $newDataRequest->HistoryPages();
            $_SESSION['total_pages_history'] = $total;
        }
        if ($total != 'Error Occurred') {
            ?>
            <header>

                <?php
                $total_raw = $total / 40;
                $total = ceil($total / 40);
                if ($total_raw > 1) {
                    echo 'Pages:';
                    ?>


                    <div class="pages">
                        <?php
                        $loop = $total_raw;
                        $num = 2;
                        $start = 1;
                        $original_1 = $total;
                        if ($total > 6) {
                            $original_1 = 7;
                            if ($num >= 6) {

                                if ($num >= 6 && $num <= ($total - 6)) {
                                    $multiplier = floor($num / 6);
                                    echo $multiplier;
                                    if ($multiplier <= 1) {
                                        $constant = 1;
                                    } else {
                                        $constant = $multiplier + 1;
                                    }
                                    $start = 6 * $constant;
                                    $original_1 = $start + 6;
                                } else {
                                    $start = $total - 6;
                                    $original_1 = $total - 1;
                                }
                            }
                            for ($i = $start; $i < ($original_1); $i++) {
                                $class = "";
                                if ($i == $num) {
                                    $class = 'active';
                                }
                                echo '<div class="' . $class . '">' . $i . '</div>';
                            }
                        } else {
                            for ($i = $start; $i < ($original_1); $i++) {
                                $class = "";
                                if ($i == $num) {
                                    $class = 'active';
                                }
                                echo '<div class="' . $class . '">' . $i . '</div>';
                            }
                        }
                        if ($total_raw > 6) {
                            $final = $total - 1;
                        } else {
                            $final = $total;
                        }
                        if ($loop >= 6 && $original_1 < ($total - 2)) {
                            echo '<span>......</span><div>' . $final . '</div>';
                        } else {
                            echo '<div>' . $final . '</div>';
                        }
                        ?>
                    </div>
                </header>
                <?php
                }
        }
        ?>
    </div>
    <?php
}  else {
    header('Location:../error404/general404.html');
    }
?>