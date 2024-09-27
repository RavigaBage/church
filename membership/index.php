<?php
session_start();
date_default_timezone_set('UTC');
include_once('../API/userpage-api/autoloader.php');
$MemberDataClass = new viewData();
$condition = false;
if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];
    $token = $_SESSION['user_token'];
    $known = hash('sha256',$unique_id);
    if((hash_equals($known,$token))){
        if (!isset($_SESSION['entryLog'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $MemberDataClass->DataHistory($unique_id, "user logged in", $date, "user Dashboard homepage", "uawe logged in to his/her dashboard");
            $decode = json_decode($newquest);
            if ($decode == 'Success') {
                $condition = true;
                $unique_id = $_SESSION['unique_id'];
            }
        } else {
            $condition = true;
        }
    }else{
        $condition = false;
    }
}
if ($condition) {

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../icons/css/all.css" />
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <script type="text/javascript">
        (function () {
            // https://dashboard.emailjs.com/admin/account
            emailjs.init({
                publicKey: "RtfFLq0ZUtE5gn-AE",
            });
        })();
    </script> -->

    <title>User profile</title>
</head>

<body>
    <main>
        <aside>
            <div class="logo">
                <img src="" alt="" />
                <h1>ProfileLine UI</h1>
            </div>
            <div class="aside_item">
                <div class="header">
                    <p>Profile</p>
                </div>
                <div class="items_list">
                    <a href="#">
                        <div class="item flex">
                            <div class="cover"><i class="fas fa-user"></i></div>
                            <p>Edit Profile</p>
                        </div>
                    </a>
                    <a href="#notification">
                        <div class="item flex">
                            <i class="fas fa-bell"></i>
                            <p>Notification</p>
                        </div>
                    </a>
                </div>

                <div class="header">
                    <p>Bank</p>
                </div>
                <div class="items_list">
                    <a href="#payment">
                        <div class="item flex">
                            <i class="fas fa-wallet"></i>
                            <p>Payments</p>
                        </div>
                    </a>
                    <a href="#transaction">
                        <div class="item flex">
                            <i class="fas fa-credit-card"></i>
                            <p>Transactions</p>
                        </div>
                    </a>
                    <a href="#tithe">
                        <div class="item flex">
                            <i class="fas fa-scroll"></i>
                            <p>Tithes</p>
                        </div>
                    </a>
                </div>
                <div class="header">
                    <p>secure</p>
                </div>
                <div class="items_list">
                    <a href="#password">
                        <div class="item flex">
                            <i class="fas fa-lock"></i>
                            <p>Passwords</p>
                        </div>
                    </a>
                    <a href="#access">
                        <div class="item flex">
                            <i class="fas fa-key"></i>
                            <p>access</p>
                        </div>
                    </a>
                    <div class="item flex">
                    </div>
                </div>

                <div class="item flex delete">
                </div>
            </div>
        </aside>
        <section class="container">
            <nav>
                <div class="sidemenu_trigger">
                    <svg class="close" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960"
                        width="24">
                        <path
                            d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                    </svg>
                    <svg class="open" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960"
                        width="24">
                        <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                    </svg>
                </div>

                <div class=" flex user_details">
                    <div class="item">
                        <i class="fas fa-bell"></i>
                        <?php
                        $data = json_decode($MemberDataClass->NotificationStatus($unique_id));
                        if ($data == "" || $data == 'Error Occurred' || $data == 'No Records Available') {
                            echo "<header class='danger'>AN ERROR OCCURED CANNOT FIND DATA CONTENTS FOR THIS SESSION</header>";
                        } else {
                            if ($data > 0) {
                                echo '<div class="counter">
                            <p>' . $data . '</p>
                        </div>';
                            }
                        }
                        ?>
                    </div>
                    <div class="item">
                        <img src="../API/Images_folder/users/<?php if (isset($_SESSION['userImage'])) {
                            echo $_SESSION['userImage'];
                        } ?>" alt="" id="cover_profile" />
                    </div>
                </div>
            </nav>
            <div class="profile_main">
                <div class="skeleton">
                    <div class=""></div>
                    <div class=""></div>
                    <div class=""></div>
                </div>
                <div class="profile_container_main"></div>
            </div>
        </section>
    </main>
    <script src="scripts/require.2.3.6.js"></script>
    <script>
        require(['scripts/config'], function () {
            require(['scripts/custome.js'])

        });
    </script>

</body>

</html>
<?php
} else {
 echo'<script>
 location.href = "../pages/error404/general404.html"
 </script>';
}
?>