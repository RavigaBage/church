<?php
require '../API/vendor/autoload.php';
$newDataRequest = new ChurchApi\viewData();
$year = date('Y');
$BirthNum = 0;
$DeathNum = 0;
$WaterNum = 0;
$FireNum = 0;
$Souls = 0;
$images_array = [];
$CallToAction = "";
$NextUp = "";
$ShowData = "";
$calenderData = "";
$records = $newDataRequest->church_record_viewList();
$gallery = $newDataRequest->gallery_home_viewList();
$annc = $newDataRequest->announcement_viewList();
$Call_to_action = $newDataRequest->call_action_viewList();
$Event = $newDataRequest->eventData();
$Showcast = $newDataRequest->gallery_viewList();
$calender = $newDataRequest->calender_data($year);

if ($records != "Fetching data encounted a problem" || $records != "No records available'" || $records != "Error Occurred") {
    try {
        $decoded_records = json_decode($records);
        $decoded_images = json_decode($gallery);
        $decoded_Call_to_action = json_decode($Call_to_action);
        $decoded_annc = json_decode($annc);
        $decoded_event = json_decode($Event);
        $decoded_showcast = json_decode($Showcast);
        $decoded_calender = json_decode($calender);
        if (is_object($decoded_records)) {
            $item = $decoded_records;
            $BirthNum += intval($item->birth);
            $DeathNum += intval($item->death);
            $WaterNum += intval($item->water_baptism);
            $FireNum += intval($item->fire_baptism);
            $Souls += intval($item->soul);
        }
        if (is_object($decoded_images)) {
            $images_array = $decoded_images->Mountain;
        }
        if (is_object($decoded_Call_to_action)) {
            $CallToAction = $decoded_Call_to_action;
        }
        if (is_object($decoded_event)) {
            $NextUp = $decoded_event;
        }
        if (is_object($decoded_showcast)) {
            $ShowData = $decoded_showcast;
        }
        if (is_object($decoded_calender)) {
            $calenderData = $decoded_calender;
        }

    } catch (\Throwable $th) {
        throw $th;
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="parallax.css">
        <link rel="stylesheet" href="parallaxfooter.css">
        <link rel="stylesheet" href="../icons/css/all.css">
        <title>parallax effect</title>
    </head>

    <body>
        <div class="navigation">

            <div class="nav_logo">
                <header>LOGO</header>
            </div>
            <div class="nav_ele">

                <a href="../library/index.html">
                    <div class="item_list">
                        <p>Library</p>
                    </div>
                </a>
                <a href="Gallery.html">
                    <div class="item_list">
                        <p>Gallery</p>
                    </div>
                </a>
                <a href="projects.html">
                    <div class="item_list">
                        <p>Projects</p>
                    </div>
                </a>
                <a href="partnership/index.html">
                    <div class="item_list">
                        <p>Partnership</p>
                    </div>
                </a>
                <a href="leadership.html">
                    <div class="item_list">
                        <p>Leadership</p>
                    </div>
                </a>

            </div>
        </div>
        <main>
            <div class="menu_toggle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" width="18"
                    viewBox="0 0 448 512"><!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) -->
                    <path
                        d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z" />
                </svg>

                <svg xmlns="http://www.w3.org/2000/svg" fill="#fff" width="18"
                    viewBox="0 0 352 512"><!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) -->
                    <path
                        d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" />
                </svg>
            </div>
            <section id="christmas_theme">
                <div class="container">
                    <img class="moon" src="../images/moon.png" alt="moon" />
                    <h1 class="main">MERRY CHRISTMAS</h1>
                    <img class="mountain" src="../images/mountains.png" alt="mt" />
                    <img class="tree" src="../images/trees.png" alt="tree" />
                    <img class="cloud_1" src="../images/cloud.png" alt="cloud" />
                    <img class="cloud_2" src="../images/cloud.png" alt="cloud" />
                </div>
                <div class="full_page_down">
                    <img src="../images/blog-1.jpg" alt="" />
                    <img src="../images/blog-2.jpg" alt="" />
                    <img src="../images/blog-3.jpg" alt="" />
                    <img src="../images/g-img-1.jpg" alt="" />
                    <img src="../images/g-img-8.jpg" alt="" />
                    <div class="christmas_txt">
                        <img src="../images/home.png" alt="" />
                    </div>
                    <img src="../images/g-img-4.jpg" alt="" />
                    <img src="../images/g-img-5.jpg" alt="" />
                    <img src="../images/g-img-6.jpg" alt="" />
                    <img src="../images/g-img-7.jpg" alt="" />
                    <img src="../images/g-img-9.jpg" alt="" />
                </div>
            </section>
            <section class="web_content">
                <div class="overlay">
                    <div class="content">
                        <div class="text">
                            <h1>THE APOSTOLIC CHURCH - GHANA</h1>
                            <p>Zoe Worship centre - Galalia</p>
                        </div>
                        <div class="motto">
                            <p style="text-align:center">MOTTO 2024 : ZEPHANIAH 3:4B</p>
                            <p>THE LORD THY GOD IN THE MIDST OF THEE IS MIGHTY </p>
                        </div>
                        <div class="slider">
                            <ul class="totally" id="autoWidth3">
                                <li>
                                    <div class="total">
                                        <label>New Souls</label>
                                        <div class="Number one">
                                            <p class="totalMen count" data-target="<?php echo $Souls; ?>">
                                                <?php echo $Souls; ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="total">
                                        <label>Births</label>
                                        <div class="Number two">
                                            <p class="totalWomen count" data-target="<?php echo $BirthNum; ?>">
                                                <?php echo $BirthNum; ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="total">
                                        <label>Death</label>
                                        <div class="Number three">
                                            <p class="totalYouth count" data-target="<?php echo $DeathNum; ?>">
                                                <?php echo $DeathNum; ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="total">
                                        <label>Baptism</label>
                                        <div class="Number four">
                                            <p class="totalKids count" data-target="<?php echo $WaterNum; ?>">
                                                <?php echo $WaterNum; ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="total Kids">
                                        <label>HolySpirit</label>
                                        <div class="Number">
                                            <p class="totalKids count" data-target="<?php echo $FireNum; ?>">
                                                <?php echo $FireNum; ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>

                <div class="service_display">
                    <div class="head">
                        <p>2ND NOVEMBER 2022</p>
                    </div>
                    <div class="text">
                        <div class="info" data-aos='fade-left'>
                            <div class="slider">
                                <?php
                                if (count($images_array) > 0) {
                                    foreach ($images_array as $image) {
                                        echo '<div class="slide" id="slick">
                                        <div><img src="../API/Images_folder/gallery/' . $image . '" alt="" /></div>
                                    </div>';
                                    }

                                }
                                ?>
                            </div>
                        </div>
                        <div class="inner">
                            <h1>SUNDAY SERVICE</h1>

                            <button>Check Gallery</button>
                        </div>
                    </div>
                    <div class="social">
                        <ul>
                            <li><i class="fab fa-facebook"></i> Facebook </li>
                            <li><i class="fas fa-instagram"></i> Instagram </li>
                            <li><i class="fab fa-twitter"></i> Twitter</i></li>
                            <li><i class="fab fa-youtube"></i> Youtube</li>
                        </ul>
                    </div>

                </div>

                <div class="upcoming_header">
                    <h1>Next up on our Schedules</h1>
                    <div class="line"></div>
                </div>

                <div class="workshop">
                    <?php
                    if (is_object($decoded_event)) {
                        echo "<img src='../API/Images/calenda/images/" . $decoded_event->image . "' alt='' />
                    <div class='info'>
                        <h1>" . $decoded_event->Event_name . "</h1>
                        <p>" . $decoded_event->About . ", this event is set to start at " . $decoded_event->Start_time . " and hopefully end at " . $decoded_event->End_time . "</p>
                        
                    </div>";
                    }
                    ?>
                </div>

                <div class="upcoming_header">
                    <h1>DO YOU REMEMBER ?</h1>
                </div>

                <div id="Event" class="event_section">
                    <?php
                    try {
                        if (is_object($ShowData)) {
                            $Data = $ShowData->image;
                            if (is_array($Data)) {
                                echo '<div class="gallery_layout">
                            <div class="img col1">
                                <img src="../API/Images_folder/gallery/' . $Data[0] . '" alt="" />
                            </div>
                            <div class="img col1">
                                <img src="../API/Images_folder/gallery/' . $Data[1] . ' alt="" />
                            </div>
                            <div class="img col2 main">
                                <div class="grid_complex">
                                    <img src="../API/Images_folder/gallery/' . $Data[2] . '" class="xxl" alt="" />
                                    <img src="../API/Images_folder/gallery/' . $Data[3] . ' alt="" />
                                    <img src="../API/Images_folder/gallery/' . $Data[4] . '" alt="" />
                                </div>
                            </div>
                            <div class="img xxl">
                                <img src="../API/Images_folder/gallery/' . $Data[5] . '" alt="" />
                            </div>
                             </div>';
                            }
                        }
                    } catch (\Throwable $th) {
                        throw $th;
                    }

                    ?>

                </div>
                <div class="upcoming_header">
                    <h1>CALENDAR ACTIVITIES</h1>
                    <div class="line"></div>
                </div>
                <div class="data_reminder">
                    <p>We have successfully mapped out the church's calenda for the year, to help you plan your events
                        accordingly. Enjoy !!
                    </p>
                </div>

                <div class="calendaMain">
                    <div class="wrapper">
                        <i class="fas fa-list trigger_set" onclick="indicator(this);"></i>
                        <div class="months" id="months_data"
                            data_calenderData='<?php print_r(json_encode($calenderData)); ?>'>
                            <div class="main">
                                <h1>Months</h1>
                                <ul>
                                    <li class="monthsList" id="jan" onclick="monthSelector(this);" datavalue="0">
                                        January</li>
                                    <li class="monthsList" id="feb" onclick="monthSelector(this);" datavalue="1">
                                        Febuary</li>
                                    <li class="monthsList" id="march" onclick="monthSelector(this);" datavalue="2">
                                        Match</li>
                                    <li class="monthsList" id="apr" onclick="monthSelector(this);" datavalue="3">
                                        April</li>
                                    <li class="monthsList" id="may" onclick="monthSelector(this);" datavalue="4">May
                                    </li>
                                    <li class="monthsList" id="jun" onclick="monthSelector(this);" datavalue="5">
                                        June</li>
                                    <li class="monthsList" id="jul" onclick="monthSelector(this);" datavalue="6">
                                        July</li>
                                    <li class="monthsList" id="Aug" onclick="monthSelector(this);" datavalue="7">
                                        August</li>
                                    <li class="monthsList" id="sep" onclick="monthSelector(this);" datavalue="8">
                                        September</li>
                                    <li class="monthsList" id="oct" onclick="monthSelector(this);" datavalue="9">
                                        October</li>
                                    <li class="monthsList" id="nov" onclick="monthSelector(this);" datavalue="10">
                                        November</li>
                                    <li class="monthsList" id="dec" onclick="monthSelector(this);" datavalue="11">
                                        December</li>
                                </ul>
                            </div>

                        </div>
                        <div class="year">
                            <div class="yearcnt">
                                <i class="fas fa-arrow-down" onclick="Prev(this);"></i>
                                <i class="fas fa-arrow-up" onclick="next(this);"></i>
                                <h1 class="monthName">January</h1>
                                <h1 class="current">2024</h1>
                            </div>
                            <ul>
                                <li>Su</li>
                                <li>Mo</li>
                                <li>Tu</li>
                                <li>We</li>
                                <li>Th</li>
                                <li>Fr</li>
                                <li>Sa</li>
                            </ul>
                            <div class="day" id="daysList">

                            </div>
                        </div>
                        <div class="events" id="eventDataView" style="overflow: auto;">
                            <h1>Event</h1>
                            <div class="eventsDetails">
                                <div class="head">Wednesday,17th 2021</div>
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia ipsa veritatis
                                    dolorem nihil iusto eligendi, distinctio optio reprehenderit commodi possimus
                                    laborum. Ex recusandae dolorem rerum dignissimos, facilis labore enim
                                    voluptates.</p>
                                <div class="image">
                                    <img src="images/bg (2).jpeg" alt="" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="upcoming_header">
                    <h1>Call to action</h1>
                    <div class="line"></div>
                </div>

                <div class="workshop">
                    <img src="images/bg (2).jpeg" alt="" />
                    <?php
                    if (is_object($CallToAction)) {
                        echo "<div class='info'>
                        <h1>" . $CallToAction->name . " contribution</h1>
                        <p>" . $CallToAction->purpose . ", all members are expected to contribute " . $CallToAction->amount . ",
                        contribution due date is expected on " . $CallToAction->date . "</p>
                    </div>";
                    }
                    ?>
                </div>

                <div class="upcoming_header">
                    <h1>CHECK OUT THE LIBRARY</h1>
                    <div class="line"></div>
                </div>
                <div class="slider_custome">
                    <ul>
                        <li>
                            <div class="item">
                                <img src="images/bg (1).jpeg" alt="" />

                                <div class="name">
                                    <p>Inheritance in the kingdom</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <img src="images/bg (1).jpeg" alt="" />

                                <div class="name">
                                    <p>Inheritance in the kingdom</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="item">
                                <img src="images/bg (1).jpeg" alt="" />

                                <div class="name">
                                    <p>Inheritance in the kingdom</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="workshop">
                    <!-- <video controls muted loop>
                        <source src="../Video.mp4" type="video/mp4">
                        </source> -->
                    <?php
                    if (is_object($decoded_annc)) {
                        echo '
                    <img src="../API/images/annc/' . $decoded_annc->file . '" alt="" />
                    <div class="info">
                        <h1>' . $decoded_annc->name . '</h1>
                        <p>' . $decoded_annc->message . '</p>
                    </div>';
                    } else {
                        echo "<header>Announcement data is not yet available</header>";
                    }
                    ?>
                </div>


            </section>
            <div class="send_up">
                <i class="fas fa-arrow-up"></i>
            </div>

        </main>

        <script src="para.js" defer></script>
        <script src="../js/calenda.js"></script>
    </body>

    </html>
    <?php
} else {
    echo "<header>We did not find enough data to display for you. Please revisit again. 
    hopefully data will be available for your consumption</header>";
}
?>