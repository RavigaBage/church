<?php
session_start();
require '../../API/vendor/autoload.php';
$viewDataClass = new notification\viewData();
$condition = false;
if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];
    $token = $_SESSION['Admin_access'];
    $known = hash('sha256', $unique_id . 'admin');
    if ((hash_equals($known, $token))) {
        if (!isset($_SESSION['Access_Log'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $viewDataClass->DataHistory($unique_id, "Admin permit was used to logged in", $date, "Dashboard Access", "Admin permit was used logged in to dashboard");
            $decode = json_decode($newquest);
            if ($decode == 'Success') {
                $_SESSION['Access_Log'] = true;
                $condition = true;
            }
        } else {
            $condition = true;
        }
    } else {
        $condition = false;
    }
}
if ($condition) {
    ?>
    <div class="filter_wrapper relative" style="height:0px;">
    </div>


    <div class="Access">

        <div class="header_slider">
            <img src="../../images/security.gif" alt="" />
        </div>
        <div class="access_token">
            <header>Generate an Access token to allow individual users access to the admin page, a
                limited
                number of times</header>
            <div class="timer_set">
                <div class="hour">00H</div>
                <div class="min">00m</div>
                <div class="second">00s</div>
            </div>
            <div class="token">

                <div class="tokenData flex" style="align-items:center;justify-content:center;flex-direction:column;">
                    <h1 style="width: 100%;">
                        <?php
                        $item = json_decode($viewDataClass->getoken());
                        echo "<input hidden id='value_data_set' value='" . $item . "'/>";
                        if ($item == 'empty') { { {
                                    echo 'Z O E -';
                                }
                            }
                        } else if ($item == 'Fetching data encounted a problem') { { {
                                    echo "error ocurred";
                                }
                            }
                        } else if ($item == 'expired') { { {
                                    echo "<p>Generate a new code. The old one has reached it limit</p>";
                                }
                            }
                        } else { { {
                                    echo "Code has Already been assigned";
                                }
                            }
                        }
                        ?>
                    </h1>
                    <div class="data" style="display:flex;gap:10px;">
                        <div class="data_main"></div>
                        <div class="copyt"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#000">
                                <path
                                    d="M360-240q-33 0-56.5-23.5T280-320v-480q0-33 23.5-56.5T360-880h360q33 0 56.5 23.5T800-800v480q0 33-23.5 56.5T720-240H360Zm0-80h360v-480H360v480ZM200-80q-33 0-56.5-23.5T120-160v-560h80v560h440v80H200Zm160-240v-480 480Z" />
                            </svg></div>
                    </div>
                </div>
                <?php
                if ($item == 'empty' || $item == 'expired') { { {
                            echo '<button>Generate and Assign token</button>';
                        }
                    }
                }
                ?>

            </div>
        </div>
    </div>
    <?php
} else {
    echo "<header>Sorry, you are currently disconnected from the admin privilege, please contact your administrator</header>";
}
?>