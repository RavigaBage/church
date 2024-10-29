<?php
session_start();
date_default_timezone_set('UTC');
require '../../API/vendor/autoload.php';
$MemberDataClass = new Membership\viewData();
$condition = false;
if (isset($_SESSION['unique_id'])) {
    $unique_id = $_SESSION['unique_id'];
    $token = $_SESSION['Admin_access'];
    $known = hash('sha256', $unique_id . 'admin');
    if ((hash_equals($known, $token))) {
        if (!isset($_SESSION['entryLog'])) {
            $date = date('Y-m-d H:i:s');
            $newquest = $MemberDataClass->DataHistory($unique_id, "Admin permit was used to logged in", $date, "Dashboard homepage", "Admin permit was used logged in to dashboard");
            $decode = json_decode($newquest);
            if ($decode == 'Success') {
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
    $Notification = new notification\viewData();
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="preload" href="../../icons/css/all.css" as="style" />
        <link rel="preload" href="css/dash.css" as="style" />
        <link rel="preload" href="css/membership.css" as="style" />
        <link rel="preload" href="css/dashstyle.css" as="style" />
        <link rel="preload" href="css/slick.css" as="style" />
        <link rel="preload" href="css/slick-theme.css" as="style" />
        <link rel="preload" href="scripts/apexcharts-bundle/dist/apexcharts.js" as="script" />

        <link rel="stylesheet" href="../../icons/css/all.css" />
        <link rel="stylesheet" href="css/dash.css">
        <link rel="stylesheet" href="css/membership.css" />
        <link rel="stylesheet" href="css/dashstyle.css" />
        <link rel="stylesheet" href="css/slick.css" />
        <link rel="stylesheet" href="css/slick-theme.css" />
        <link rel="stylesheet" href="../error404/styles.css" />
        <script type="text/javascript" src="scripts/apexcharts-bundle/dist/apexcharts.js"></script>
        <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <script type="text/javascript">
        (function () {
            // https://dashboard.emailjs.com/admin/account
            emailjs.init({
                publicKey: "RtfFLq0ZUtE5gn-AE",
            });
        })();
    </script> -->
        <title>Zoe worship centre Admin Dashboard</title>
    </head>

    <body>
        <main class="scroll_overflow">
            <div class="loader_progress">
                <div class="progress"></div>
            </div>
            <aside class="sidebar" id="sidebar">
                <div class="sidebar_main">

                    <ul class="main">
                        <header class="main_text flex">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#5f6368">
                                <path
                                    d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z" />
                            </svg>
                            Dashboard
                        </header>
                        <header class="pre_text">Profile</header>
                        <a href="#">
                            <li data-menu="homepage">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64px" height="64px">
                                    <linearGradient id="GgB4DrbdisjPOMNxvlzLta" x1="48" x2="48" y1="41.583" y2="50.252"
                                        gradientUnits="userSpaceOnUse" spreadMethod="reflect">
                                        <stop offset="0" stop-color="#6dc7ff" />
                                        <stop offset="1" stop-color="#e6abff" />
                                    </linearGradient>
                                    <path fill="url(#GgB4DrbdisjPOMNxvlzLta)"
                                        d="M50,42h-4c-0.552,0-1,0.448-1,1v7h6v-7C51,42.448,50.552,42,50,42z" />
                                    <linearGradient id="GgB4DrbdisjPOMNxvlzLtb" x1="26" x2="26" y1="11.833" y2="52.17"
                                        gradientUnits="userSpaceOnUse" spreadMethod="reflect">
                                        <stop offset="0" stop-color="#1a6dff" />
                                        <stop offset="1" stop-color="#c822ff" />
                                    </linearGradient>
                                    <path fill="url(#GgB4DrbdisjPOMNxvlzLtb)" d="M25 41H27V45H25z" />
                                    <linearGradient id="GgB4DrbdisjPOMNxvlzLtc" x1="25" x2="25" y1="11.833" y2="52.17"
                                        gradientUnits="userSpaceOnUse" spreadMethod="reflect">
                                        <stop offset="0" stop-color="#1a6dff" />
                                        <stop offset="1" stop-color="#c822ff" />
                                    </linearGradient>
                                    <path fill="url(#GgB4DrbdisjPOMNxvlzLtc)" d="M19 30H31V32H19z" />
                                    <linearGradient id="GgB4DrbdisjPOMNxvlzLtd" x1="32" x2="32" y1="11.833" y2="52.17"
                                        gradientUnits="userSpaceOnUse" spreadMethod="reflect">
                                        <stop offset="0" stop-color="#1a6dff" />
                                        <stop offset="1" stop-color="#c822ff" />
                                    </linearGradient>
                                    <path fill="url(#GgB4DrbdisjPOMNxvlzLtd)"
                                        d="M56,32v-2c0-1.103-0.897-2-2-2H42v-2c1.103,0,2-0.897,2-2v-2c0-1.103-0.897-2-2-2h-0.382 l-3.447-6.895C37.829,12.424,37.144,12,36.381,12H13.619c-0.763,0-1.448,0.424-1.791,1.106L8.382,20H8c-1.103,0-2,0.897-2,2v2 c0,1.103,0.897,2,2,2v24c0,1.103,0.897,2,2,2h9h12h9h2h12c1.103,0,2-0.897,2-2V38c1.103,0,2-0.897,2-2v-2C58,32.897,57.103,32,56,32 z M54,30v2H42v-2H54z M13.619,14h22.762l3.001,6H10.618L13.619,14z M8,22h34v2H8V22z M40,26v6v4v2v4h-4v2h4v2h-9v-9 c0-1.654-1.346-3-3-3h-6c-1.654,0-3,1.346-3,3v9h-9v-2h4v-2h-4V26H40z M10,50v-2h9v2H10z M21,50V37c0-0.552,0.448-1,1-1h6 c0.552,0,1,0.448,1,1v13H21z M31,50v-2h9v2H31z M54,50H42V38h12V50z M56,36H42v-2h14V36z" />
                                </svg>
                                <p>Homepage</p>
                            </li>
                        </a>
                        <a href="#Appearance">
                            <li data-menu="appearance">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">

                                    <path fill="url(#GgB4DrbdisjPOMNxvlzLtd)"
                                        d="m656-120-56-56 63-64-63-63 56-57 64 64 63-64 57 57-64 63 64 64-57 56-63-63-64 63Zm-416-80q17 0 28.5-11.5T280-240q0-17-11.5-28.5T240-280q-17 0-28.5 11.5T200-240q0 17 11.5 28.5T240-200Zm0 80q-50 0-85-35t-35-85q0-50 35-85t85-35q37 0 67.5 20.5T352-284q39-11 63.5-43t24.5-73v-160q0-83 58.5-141.5T640-760h46l-63-63 57-57 160 160-160 160-57-56 63-64h-46q-50 0-85 35t-35 85v160q0 73-47 128.5T354-203q-12 37-43.5 60T240-120Zm-64-480-56-56 63-64-63-63 56-57 64 64 63-64 57 57-64 63 64 64-57 56-63-63-64 63Z" />
                                </svg>
                                <p>Appearance</p>
                            </li>
                        </a>
                        <a href="#Gallery">
                            <li data-menu="Gallery">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">

                                    <path fill="url(#GgB4DrbdisjPOMNxvlzLtd)"
                                        d="m656-120-56-56 63-64-63-63 56-57 64 64 63-64 57 57-64 63 64 64-57 56-63-63-64 63Zm-416-80q17 0 28.5-11.5T280-240q0-17-11.5-28.5T240-280q-17 0-28.5 11.5T200-240q0 17 11.5 28.5T240-200Zm0 80q-50 0-85-35t-35-85q0-50 35-85t85-35q37 0 67.5 20.5T352-284q39-11 63.5-43t24.5-73v-160q0-83 58.5-141.5T640-760h46l-63-63 57-57 160 160-160 160-57-56 63-64h-46q-50 0-85 35t-35 85v160q0 73-47 128.5T354-203q-12 37-43.5 60T240-120Zm-64-480-56-56 63-64-63-63 56-57 64 64 63-64 57 57-64 63 64 64-57 56-63-63-64 63Z" />
                                </svg>
                                <p>Gallery</p>
                            </li>
                        </a>

                        <header class="pre_text">Security</header>

                        <?php
                        if (!isset($_SESSION['Admin_permit'])) {
                            echo '<a href="#Access_token">
                            <li data-menu="generate_id">

                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                                    <path
                                        d="M160-80q-33 0-56.5-23.5T80-160v-440q0-33 23.5-56.5T160-680h200v-120q0-33 23.5-56.5T440-880h80q33 0 56.5 23.5T600-800v120h200q33 0 56.5 23.5T880-600v440q0 33-23.5 56.5T800-80H160Zm0-80h640v-440H600q0 33-23.5 56.5T520-520h-80q-33 0-56.5-23.5T360-600H160v440Zm80-80h240v-18q0-17-9.5-31.5T444-312q-20-9-40.5-13.5T360-330q-23 0-43.5 4.5T276-312q-17 8-26.5 22.5T240-258v18Zm320-60h160v-60H560v60Zm-200-60q25 0 42.5-17.5T420-420q0-25-17.5-42.5T360-480q-25 0-42.5 17.5T300-420q0 25 17.5 42.5T360-360Zm200-60h160v-60H560v60ZM440-600h80v-200h-80v200Zm40 220Z" />
                                </svg>
                                <p>Access token</p>
                            </li>
                        </a>';
                        }
                        ?>

                        <li data-menu="projects" class="expand">
                            <div class="page_expand">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">

                                    <path fill="#02c723f6"
                                        d="m105-233-65-47 200-320 120 140 160-260 109 163q-23 1-43.5 5.5T545-539l-22-33-152 247-121-141-145 233ZM863-40 738-165q-20 14-44.5 21t-50.5 7q-75 0-127.5-52.5T463-317q0-75 52.5-127.5T643-497q75 0 127.5 52.5T823-317q0 26-7 50.5T795-221L920-97l-57 57ZM643-217q42 0 71-29t29-71q0-42-29-71t-71-29q-42 0-71 29t-29 71q0 42 29 71t71 29Zm89-320q-19-8-39.5-13t-42.5-6l205-324 65 47-188 296Z" />
                                </svg>
                                <p>Finance</p>
                            </div>
                            <div class="tabs">
                                <a href="#Finance">
                                    <div class="item">
                                        <div></div>
                                        <p>Finance page</p>
                                    </div>
                                </a>
                                <div class="item home_event_itenary active"
                                    title="Event section contains all event and contribution records ">
                                    <div></div>
                                    <p>Events</p>
                                </div>
                                <div class="item offertory_itenary">
                                    <div></div>
                                    <p>Offertory</p>
                                </div>
                                <a href="#Transaction">
                                    <div class="item">
                                        <div></div>
                                        <p>Transactions</p>
                                    </div>
                                </a>
                                <a href="#Budget">
                                    <div class="item">
                                        <div></div>
                                        <p>Budget</p>
                                    </div>
                                </a>
                                <a href="#Expenses">
                                    <div class="item">
                                        <div></div>
                                        <p>Expenses</p>
                                    </div>
                                </a>

                                <a href="#Tithe">
                                    <div class="item">
                                        <div></div>
                                        <p>Tithe</p>
                                    </div>
                                </a>

                                <a href="#FinanceAccount">
                                    <div class="item">
                                        <div></div>
                                        <p>Account</p>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <a href="#records">
                            <li data-menu="records">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">


                                    <path fill="#ffc318f6"
                                        d="M560-320h80v-80h80v-80h-80v-80h-80v80h-80v80h80v80ZM160-160q-33 0-56.5-23.5T80-240v-480q0-33 23.5-56.5T160-800h240l80 80h320q33 0 56.5 23.5T880-640v400q0 33-23.5 56.5T800-160H160Z" />
                                </svg>
                                <p>Records</p>
                            </li>
                        </a>

                        <?php

                        if (!isset($_SESSION['Admin_permit'])) {
                            echo '<a href="#History">
                            <li data-menu="projects">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                    <path
                                        d="M480-120q-138 0-240.5-91.5T122-440h82q14 104 92.5 172T480-200q117 0 198.5-81.5T760-480q0-117-81.5-198.5T480-760q-69 0-129 32t-101 88h110v80H120v-240h80v94q51-64 124.5-99T480-840q75 0 140.5 28.5t114 77q48.5 48.5 77 114T840-480q0 75-28.5 140.5t-77 114q-48.5 48.5-114 77T480-120Zm112-192L440-464v-216h80v184l128 128-56 56Z" />
                                </svg>
                                <p>History</p>
                            </li>
                        </a>';
                        }
                        ?>
                        <a href="#Library">
                            <li data-menu="interns">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                    fill="#e8eaed">
                                    <path fill="url(#GgB4DrbdisjPOMNxvlzLtd)"
                                        d="M400-400h160v-80H400v80Zm0-120h320v-80H400v80Zm0-120h320v-80H400v80Zm-80 400q-33 0-56.5-23.5T240-320v-480q0-33 23.5-56.5T320-880h480q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H320ZM160-80q-33 0-56.5-23.5T80-160v-560h80v560h560v80H160Z" />
                                </svg>
                                <p>Library</p>
                            </li>
                        </a>
                        <a href="#Partnership">
                            <li data-menu="partnership">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                    <linearGradient id="Gwwel" x1="32" x2="32" y1="11.833" y2="52.17"
                                        gradientUnits="userSpaceOnUse" spreadMethod="reflect">
                                        <stop offset="0" stop-color="#09a5b5f6" />
                                        <stop offset="1" stop-color="#105bb9f6" />
                                    </linearGradient>
                                    <path fill="url(#Gwwel)"
                                        d="M484-120q-17 0-28.5-11.5T444-160q0-7 3-14.5t9-13.5l185-185-29-29-184 185q-6 6-13 9t-15 3q-17 0-28.5-11.5T360-245q0-10 3-16.5t8-11.5l185-185-28-28-185 184q-6 6-13 9t-16 3q-16 0-28-12t-12-28q0-8 3-15t9-13l185-185-29-28-184 185q-5 5-12 8t-17 3q-17 0-28.5-11.5T189-415q0-8 3-15t9-13l223-223 150 151q11 11 26 17.5t30 6.5q32 0 56-22.5t24-57.5q0-14-5-29t-18-28L508-807q17-16 38-24.5t42-8.5q26 0 48 8.5t40 26.5l169 170q18 18 26.5 40t8.5 51q0 20-9 40.5T845-466L512-132q-8 8-14 10t-14 2ZM141-440l-26-26q-17-16-26-38t-9-46q0-26 10-48t25-37l169-170q16-16 38-25.5t43-9.5q27 0 48 7.5t41 27.5l205 205q6 6 9 13t3 15q0 16-12 28t-28 12q-9 0-15-2.5t-13-9.5L423-722 141-440Z" />
                                </svg>
                                <p>Partnership</p>
                            </li>
                        </a>
                        <header class="pre_text">records</header>
                        <a href="#calender">
                            <li data-menu="calender">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                    <path fill="#dded02"
                                        d="M480-400q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Z" />
                                </svg>
                                <p>Calender</p>
                            </li>
                        </a>

                        <a href="#Announcement">
                            <li data-menu="Announcement">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                    <path fill="#ed143d"
                                        d="M280-400q17 0 28.5-11.5T320-440q0-17-11.5-28.5T280-480q-17 0-28.5 11.5T240-440q0 17 11.5 28.5T280-400Zm0-160q17 0 28.5-11.5T320-600q0-17-11.5-28.5T280-640q-17 0-28.5 11.5T240-600q0 17 11.5 28.5T280-560Zm80 160h360v-80H360v80Zm0-160h360v-80H360v80Zm-40 440v-80H160q-33 0-56.5-23.5T80-280v-480q0-33 23.5-56.5T160-840h640q33 0 56.5 23.5T880-760v480q0 33-23.5 56.5T800-200H640v80H320Z" />
                                </svg>
                                <p>Announcement </p>
                            </li>
                        </a>


                        <a href="#Membership">
                            <li data-menu="membership">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">

                                    <path
                                        d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113Z" />
                                </svg>
                                <p>Membership</p>
                            </li>
                        </a>

                        <a href="#Assets">
                            <li data-menu="Assets">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                    <path fill="#00f16cf6"
                                        d="M160-720v-80h640v80H160Zm0 560v-240h-40v-80l40-200h640l40 200v80h-40v240h-80v-240H560v240H160Zm80-80h240v-160H240v160Z" />
                                </svg>
                                <p>Assets</p>
                            </li>
                        </a>
                        <a href="#projects">
                            <li data-menu="projects">

                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                                    <path fill="crimson"
                                        d="M438-226 296-368l58-58 84 84 168-168 58 58-226 226ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Z" />
                                </svg>
                                <p>Projects</p>
                            </li>
                        </a>
                        <a href="#Department">
                            <li data-menu="department">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                                    <path fill="#b10dcff6"
                                        d="M666-440 440-666l226-226 226 226-226 226Zm-546-80v-320h320v320H120Zm400 400v-320h320v320H520Zm-400 0v-320h320v320H120Z" />
                                    />
                                </svg>
                                <p>Departments</p>
                            </li>
                        </a>
                        <header class="pre_text">Logs</header>

                        <li data-menu="Log" id="LogOut">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                                <path fill="#b10dcff6"
                                    d="M666-440 440-666l226-226 226 226-226 226Zm-546-80v-320h320v320H120Zm400 400v-320h320v320H520Zm-400 0v-320h320v320H120Z" />
                                />
                            </svg>
                            <p>Log Out</p>
                        </li>
                    </ul>
                </div>
            </aside>
            <section style="position:relative">
                <nav>
                    <!-- <div class="logo_section">
                    <div class="sidemenu_trigger">
                        <svg class="open" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960"
                            width="24">
                            <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                        </svg>

                        <svg class="close" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960"
                            width="24">
                            <path
                                d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z" />
                        </svg>
                    </div>
                </div> -->
                    <div class="navigation_content">

                        <div class="ux_search_bar">
                            <input type="search_data" type="search" id="searchInput" name="search"
                                placeholder="...search here" />
                            <button id="searchBtn"><i class="fas fa-search" aria-hidden></i></button>
                        </div>

                        <header>
                            <h1 class="greeting"> WELCOME <span> </span></h1>
                        </header>
                        <div class="nav_profile_link">

                            <div class="date_view">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                    fill="#5f6368">
                                    <path
                                        d="M200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Zm280 240q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240Z" />
                                </svg>
                                <p class="get_current_date">
                                    <?php
                                    $date = date("Y-m-d");
                                    $date_f = new DateTimeImmutable($date);
                                    echo $date_f->format('jS F Y');
                                    ?>
                                </p>
                            </div>
                            <div class="date_view search">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                    fill="#5f6368">
                                    <path
                                        d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                                </svg>
                            </div>

                            <div class="icon_notify">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                    fill="#5f6368">
                                    <path
                                        d="M160-200v-80h80v-280q0-83 50-147.5T420-792v-28q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v28q80 20 130 84.5T720-560v280h80v80H160Zm320-300Zm0 420q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM320-280h320v-280q0-66-47-113t-113-47q-66 0-113 47t-47 113v280Z" />
                                </svg>

                                <?php
                                $data = $Notification->Status_Notification();

                                $data = json_decode($data);
                                if (is_object($data)) {
                                    $count = count(get_object_vars($data));
                                    if ($count > 0) {
                                        echo '<div class="counter"><p>' . $count . '</p></div>';
                                    }
                                }

                                ?>

                                <div class="notification_list">
                                    <?php

                                    if (is_object($data)) {

                                        foreach ($data as $item) {
                                            $name = $item->name;
                                            $date = $item->date;
                                            $title = $item->title;

                                            echo '<a href="#Partnership"><div class="item">
                                            <h1>' . $name . '</h1>
                                            <p>' . $date . '</p>
                                        </div></a>';
                                        }

                                    } else {
                                        echo '<p>No new notification</p>';
                                    }
                                    ?>
                                </div>
                            </div>

                            <div class="nav_profile">
                                <img src="../../images/blog-1.jpg" alt="profile" />
                            </div>
                        </div>
                    </div>
                </nav>
                <div class="content_body">
                    <div class="skeleton_loader list">
                        <div class="div_sample">
                            <div class="main"></div>
                            <div class="min"></div>
                        </div>
                        <div class="div_sample">
                            <div class="main"></div>
                            <div class="min"></div>
                        </div>
                        <div class="div_sample">
                            <div class="main"></div>
                            <div class="min"></div>
                        </div>
                        <div class="div_sample">
                            <div class="main"></div>
                            <div class="min"></div>
                        </div>
                        <div class="div_sample">
                            <div class="main"></div>
                            <div class="min"></div>
                        </div>
                    </div>
                    <div class="skeleton_loader table ">
                        <table>
                            <thead>
                                <tr>
                                    <th>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="div_sample">
                                            <div class="main"></div>
                                            <div class="min"></div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                    <div class="content_main ">

                    </div>
                    <div class="dn_message">
                        <h1>
                            By accepting you wil permanently delete this record from the church's database.
                        </h1>
                        <p>Are you sure you want to delete this record</p>
                        <div class="btn">
                            <div class="btn_confirm" data-confirm="false">No</div>
                            <div class="btn_confirm" data-confirm="true">Yes</div>
                        </div>
                    </div>
                </div>
                <div class="error_require">
                    <p>Something went wrong, please refresh your page</p>
                </div>
                <div class="data_upload_platform">
                    <input type="file" id="batch_file" hidden/>
                    <div class="loader_wrapper">
                        <div class="load-3">
                            <div class="line"></div>
                            <div class="line"></div>
                            <div class="line"></div>
                        </div>
                        <div class="text">
                            <p style="color:crimson"></p>
                        </div>
                    </div>
                    <div class="data_list">
                        <header>900 rows of data has been detected, click on the upload to begin</header>
                        <div class="container_data">
                            <div class="upload">Date upload a success</div>
                            <div class="error">Data upload encountered an error</div>
                        </div>
                        <button>create Activity</button>
                    </div>
                </div>
            </section>

        </main>
        <script>
            window.addEventListener('error', function (e) {
                document.querySelector('.error_require').classList.add('active');
            })
        </script>
        <script src="scripts/require.2.3.6.js"></script>
        <script>
            require(['scripts/config'], function () {
                require(['scripts/custome.js'])
            });


        </script>
    </body>

    </html>
    <?php
    //set all notification reset for partnership

} else {
    header('Location:../../login/?admin');
}

?>