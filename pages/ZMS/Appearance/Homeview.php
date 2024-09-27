<?php
session_start();
include_once('../../../API/notifications & token & history/autoloader.php');
$viewDataClass = new viewData();
$condition = false;
if (isset($_SESSION['login_details'])) {
    $login_details = $_SESSION['login_details'];
    if (!isset($_SESSION['theme_entryLog'])) {
        $date = date('Y-m-d H:i:s');
        $newquest = $viewDataClass->DataHistory($login_details, "Theme selection", $date, "Appearance section", "Admin Viewed Theme section");
        $decode = json_decode($newquest);
        if ($decode == 'Success') {
            $condition = true;
            $_SESSION['theme_entryLog'] = true;
        }
    } else {

        $condition = true;
    }
} else {
    $condition = false;
}

if ($condition) {
    ?>
    <div class="filter_wrapper relative">
    </div>
    <header style="margin-left:30px">THEMES</header>
    <div class="view_cards">
        <div class="card">
            <div class="image">
                <img src="../images/blog-2.jpg" alt="" />
            </div>
            <div class="title_opt">
                <header>Christmas Appearance</header>
                <div class="toggle_mode" data-id="1">
                    <svg xmlns="http://www.w3.org/2000/svg" class='on' height="24" fill="green" viewBox="0 -960 960 960"
                        width="24">
                        <path
                            d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="off" height="24" fill="red" viewBox="0 -960 960 960"
                        width="24">
                        <path
                            d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z" />
                    </svg>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="image">
                <img src="../images/easter/img/dungeon.jpg" alt="" />
            </div>
            <div class="title_opt">
                <header>Easter Appearance</header>

                <div class="toggle_mode" data-id="2">
                    <svg xmlns="http://www.w3.org/2000/svg" class='on' height="24" fill="green" viewBox="0 -960 960 960"
                        width="24">
                        <path
                            d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="off" height="24" fill="red" viewBox="0 -960 960 960"
                        width="24">
                        <path
                            d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z" />
                    </svg>
                </div>

            </div>
        </div>

        <div class="card">
            <div class="image">
                <img src="../images/bg (1).jpg" alt="" />
            </div>
            <div class="title_opt">
                <header>Default Appearance</header>

                <div class="toggle_mode" data-id="3">
                    <svg xmlns="http://www.w3.org/2000/svg" class='on' height="24" fill="green" viewBox="0 -960 960 960"
                        width="24">
                        <path
                            d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm400-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35ZM480-480Z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="off" height="24" fill="red" viewBox="0 -960 960 960"
                        width="24">
                        <path
                            d="M280-240q-100 0-170-70T40-480q0-100 70-170t170-70h400q100 0 170 70t70 170q0 100-70 170t-170 70H280Zm0-80h400q66 0 113-47t47-113q0-66-47-113t-113-47H280q-66 0-113 47t-47 113q0 66 47 113t113 47Zm0-40q50 0 85-35t35-85q0-50-35-85t-85-35q-50 0-85 35t-35 85q0 50 35 85t85 35Zm200-120Z" />
                    </svg>
                </div>

            </div>
        </div>
    </div>
    <div class="dn_message switch_theme">
        <h1>
            You are currently performing a theme switch, by accepting all web designs on this system will,
            be affected to match this design
        </h1>
        <p>Are you sure you want to switch themes</p>
        <div class="btn">
            <div class="btn_confirm" data-confirm="false">No</div>
            <div class="btn_confirm" data-confirm="true">Yes</div>
        </div>
    </div>
    <?php
} else {
    echo "<header>Sorry an Unexpected error occurred fetching this page</header>";
}
?>