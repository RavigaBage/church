<?php
session_start();

require '../API/vendor/autoload.php';
$newDataRequest = new ChurchApi\viewData();

$year = date('Y');
$BirthNum = 0;
$DeathNum = 0;
$WaterNum = 0;
$FireNum = 0;
$Souls = 0;
$visitors = 0;
$marriage = 0;
$images_array = [];
$CallToAction = "";
$NextUp = "";
$ShowData = "";
$calenderData = "";


$records = $newDataRequest->church_record_viewList();

$gallery = $newDataRequest->gallery_home_viewList();

$annc = $newDataRequest->announcement_viewList();
$Call_to_action = $newDataRequest->call_action_viewList();
$EventList = $newDataRequest->EventList();
$Event_dir = $newDataRequest->eventData();
$Showcast = $newDataRequest->gallery_viewList();
$calender = $newDataRequest->calender_data($year);
$theme = $newDataRequest->theme_viewList();
$stringpass = 'libraryhome.php' . date('Y');
$hash = hash('sha256', $stringpass);
$data_theme = json_decode($theme);


if ($records != "Fetching data encounted a problem" || $records != "No records available'" || $records != "Error Occurred") {
    try {
        $decoded_records = json_decode($records);
        $decoded_images = json_decode($gallery);
        $decoded_Call_to_action = json_decode($Call_to_action);
        $decoded_annc = json_decode($annc);
        $decoded_event = json_decode($Event_dir);
        $decoded_showcast = json_decode($Showcast);
        $decoded_calender = json_decode($calender);
        if (is_object($decoded_records)) {
            $item = $decoded_records;
            $BirthNum += intval($item->birth);
            $DeathNum += intval($item->death);
            $WaterNum += intval($item->water_baptism);
            $FireNum += intval($item->fire_baptism);
            $Souls += intval($item->soul);
            $visitors += intval($item->visitor);
            $marriage += intval($item->marriage);
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
        <link rel="preload" href="parallax.css" as="style">
        <link rel="preload" href="parallaxfooter.css" as="style">
        <link rel="preload" href="../icons/css/all.css" as="style">
        <link rel="preload" href="css/izmir.min.css" as="style">
        <link rel="stylesheet" href="css/izmir.min.css">
        <link rel="stylesheet" href="parallax.css">
        <link rel="stylesheet" href="parallaxfooter.css">
        <link rel="stylesheet" href="../css/aos.css">

        <?php
        if ($data_theme != "Fetching data encountered a problem" || $data_theme != "No records available'" || $data_theme != "Error Occurred") {
            if ($data_theme == 'easter') {
                echo "<link rel='stylesheet' href='easter.css'>";
            }
        }
        ?>
        <link rel="stylesheet" href="../icons/css/all.css">
        <link rel="stylesheet" href="css/slick.css" />
        <link rel="stylesheet" href="css/slick-theme.css" />
        <script src="../js/jquery-3.4.1.min.js"></script>
        <script src="../js/calenda.js" defer></script>

        <?php
        if ($data_theme != "Fetching data_theme encounted a problem" || $data_theme != "No records available'" || $data_theme != "Error Occurred") {
            if ($data_theme == 'christmas_theme') {
                echo '<script src="para.js" defer></script>';
            }
        }
        ?>
        <title>Zoe worship centre</title>
    </head>

    <body class="<?php
    if (is_object($data_theme)) {
        echo $data_theme;
    }
    ?>">
        <div class="navigation">

            <div class="nav_logo">
                <img alt="logo icon" src="../icons/logo.jpg" alt="" />
            </div>
            <div class="nav_ele">
                <a href="Donation/about.html">
                    <div class="item_list">
                        <p>Donate</p>
                    </div>
                </a>
                <a href="../library/library.php">
                    <div class="item_list">
                        <p>Library</p>
                    </div>
                </a>
                <a href="Gallery.php">
                    <div class="item_list">
                        <p>Gallery</p>
                    </div>
                </a>

                <a href="partnership/index.html">
                    <div class="item_list">
                        <p>Partnership</p>
                    </div>
                </a>
                <a href="missions/">
                    <div class="item_list">
                        <p>Missions</p>
                    </div>
                </a>

            </div>
        </div>
        <main>
            <div class="menu_toggle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="18"
                    viewBox="0 0 448 512"><!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) -->
                    <path
                        d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z" />
                </svg>

                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="18"
                    viewBox="0 0 352 512"><!-- Font Awesome Free 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) -->
                    <path
                        d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z" />
                </svg>
            </div>
            <section id="christmas_theme">
                <div class="container">
                    <img class="moon" data-src="../images/moon.png" alt="moon" />
                    <h1 class="main">MERRY CHRISTMAS</h1>
                    <img class="mountain" data-src="../images/mountains.png" alt="mt" />
                    <img class="tree" data-src="../images/trees.png" alt="tree" />
                    <img class="cloud_1" data-src="../images/cloud.png" alt="cloud" />
                    <img class="cloud_2" data-src="../images/cloud.png" alt="cloud" />
                </div>
                <div class="full_page_down">
                    <img data-src="../images/home.png" alt="" />
                </div>
            </section>
            <section class="web_content">
                <div class="overlay">
                    <div class="content">
                        <div class="text main">
                            <h1 data-aos="fade-right" data-aos-delay="150" data-aos-duration="900">
                                THE APOSTOLIC CHURCH -
                                GHANA</h1>
                            <p data-aos="fade-right" data-aos-delay="250" data-aos-duration="900">Zoe Worship centre -
                                Galelea</p>
                        </div>
                        <div class="motto">
                            <?php
                            if ($data_theme != 'christmas_theme') {
                                echo '
                                    <p data-aos="fade-right" data-aos-delay="450"  data-aos-duration="900"> TAKE HEED TO THE DOCTRINE AND CONTINUE IN THEM, FOR IN DOING THIS, YOU WILL SAVE BOTH YOURSELF AND THOSE YOU HEAR </p>';
                            }
                            ?>
                        </div>
                        <div class="slider">
                            <ul class="totally" id="autoWidth3">
                                <li>
                                    <div class="total">

                                        <div class="Number one">
                                            <p class="totalMen count" data-target="<?php { {
                                                echo $Souls;
                                            }
                                        } ?>">
                                                <?php { {
                                                    echo $Souls;
                                                }
                                            } ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="#159abf">
                                                    <path d="M12 2a5 5 0 1 1 -5 5l.005 -.217a5 5 0 0 1 4.995 -4.783z" />
                                                    <path
                                                        d="M14 14a5 5 0 0 1 5 5v1a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-1a5 5 0 0 1 5 -5h4z" />
                                                </svg>

                                            </p>
                                        </div>
                                        <label>New Souls</label>
                                    </div>
                                </li>

                                <li>
                                    <div class="total">

                                        <div class="Number two">
                                            <p class="totalWomen count" data-target="<?php { {
                                                echo $BirthNum;
                                            }
                                        } ?>">
                                                <?php { {
                                                    echo $BirthNum;
                                                }
                                            } ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="teal">
                                                    <path
                                                        d="M12 19a1 1 0 0 1 .993 .883l.007 .117v1a1 1 0 0 1 -1.993 .117l-.007 -.117v-1a1 1 0 0 1 1 -1z" />
                                                    <path
                                                        d="M18.313 16.91l.094 .083l.7 .7a1 1 0 0 1 -1.32 1.497l-.094 -.083l-.7 -.7a1 1 0 0 1 1.218 -1.567l.102 .07z" />
                                                    <path
                                                        d="M7.007 16.993a1 1 0 0 1 .083 1.32l-.083 .094l-.7 .7a1 1 0 0 1 -1.497 -1.32l.083 -.094l.7 -.7a1 1 0 0 1 1.414 0z" />
                                                    <path
                                                        d="M4 11a1 1 0 0 1 .117 1.993l-.117 .007h-1a1 1 0 0 1 -.117 -1.993l.117 -.007h1z" />
                                                    <path
                                                        d="M21 11a1 1 0 0 1 .117 1.993l-.117 .007h-1a1 1 0 0 1 -.117 -1.993l.117 -.007h1z" />
                                                    <path
                                                        d="M6.213 4.81l.094 .083l.7 .7a1 1 0 0 1 -1.32 1.497l-.094 -.083l-.7 -.7a1 1 0 0 1 1.217 -1.567l.102 .07z" />
                                                    <path
                                                        d="M19.107 4.893a1 1 0 0 1 .083 1.32l-.083 .094l-.7 .7a1 1 0 0 1 -1.497 -1.32l.083 -.094l.7 -.7a1 1 0 0 1 1.414 0z" />
                                                    <path
                                                        d="M12 2a1 1 0 0 1 .993 .883l.007 .117v1a1 1 0 0 1 -1.993 .117l-.007 -.117v-1a1 1 0 0 1 1 -1z" />
                                                    <path
                                                        d="M12 7a5 5 0 1 1 -4.995 5.217l-.005 -.217l.005 -.217a5 5 0 0 1 4.995 -4.783z" />
                                                </svg>

                                            </p>
                                        </div>
                                        <label>Births</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="total">
                                        <div class="Number four">
                                            <p class="totalKids count" data-target="<?php { {
                                                echo $WaterNum + $FireNum;
                                            }
                                        } ?>">
                                                <?php { {
                                                    echo $WaterNum + $FireNum;
                                                }
                                            } ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="gold">
                                                    <path
                                                        d="M13.553 2.106c-4.174 2.086 -6.553 5.358 -6.553 8.894a5 5 0 0 0 10 0c0 -1.047 -.188 -1.808 -.606 -2.705l-.169 -.345l-.33 -.647c-.621 -1.24 -.895 -2.338 -.895 -4.303a1 1 0 0 0 -1.447 -.894z" />
                                                </svg>
                                            </p>
                                        </div>
                                        <label>Baptism</label>
                                    </div>
                                </li>

                                <li>
                                    <div class="total">
                                        <div class="Number four">
                                            <p class="totalKids count" data-target="<?php { {
                                                echo $visitors;
                                            }
                                        } ?>">
                                                <?php { {
                                                    echo $visitors;
                                                }
                                            } ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="gold">
                                                    <path
                                                        d="M13.553 2.106c-4.174 2.086 -6.553 5.358 -6.553 8.894a5 5 0 0 0 10 0c0 -1.047 -.188 -1.808 -.606 -2.705l-.169 -.345l-.33 -.647c-.621 -1.24 -.895 -2.338 -.895 -4.303a1 1 0 0 0 -1.447 -.894z" />
                                                </svg>
                                            </p>
                                        </div>
                                        <label>visitors</label>
                                    </div>
                                </li>
                                <li>
                                    <div class="total">
                                        <div class="Number four">
                                            <p class="totalKids count" data-target="<?php { {
                                                echo $marriage;
                                            }
                                        } ?>">
                                                <?php { {
                                                    echo $marriage;
                                                }
                                            } ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="gold">
                                                    <path
                                                        d="M13.553 2.106c-4.174 2.086 -6.553 5.358 -6.553 8.894a5 5 0 0 0 10 0c0 -1.047 -.188 -1.808 -.606 -2.705l-.169 -.345l-.33 -.647c-.621 -1.24 -.895 -2.338 -.895 -4.303a1 1 0 0 0 -1.447 -.894z" />
                                                </svg>
                                            </p>
                                        </div>
                                        <label>marriages</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="section__container">
                    <div class="header">
                        <H2>Recent Activities</H2>
                    </div>

                    <div class="testimonials__grid">
                        <div class="swiper_class">
                            <div class="swiper-wrapper recentSlider" id="recent_activities">
                                <?php
                                $data = json_decode($gallery);
                                if (is_object($data)) {

                                    foreach ($data->Mountain as $img) { {
                                            echo ' <figure class="c4-izmir c4-border-cc-3 c4-image-rotate-right swiper-slide card" >
                                            <img loading="lazy" data-src="../API/images_folder/gallery/' . $img . '" alt="user" />
                                            </figure>';
                                        }


                                    }
                                }
                                ?>
                            </div>
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
                    <div class="line">
                        <?php
                        if ($data_theme == 'christmas_theme') { { {
                                    echo '<img data-src="../images/gift1.png" alt="gift1" />';
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="workshop" data-aos="fade-left" data-aos-duration="500">
                    <?php
                    if (is_object($decoded_event)) { { {
                                echo "<img data-src='../API/Images/calenda/" . $decoded_event->image . "' alt='' />
                         <div class='info'>
                        <h1>" . $decoded_event->Event_name . "</h1>
                        <p>" . $decoded_event->About . ", this event is set to start at " . $decoded_event->Start_time . " and hopefully end at " . $decoded_event->End_time . "</p>
                        
                         </div>";
                            }
                        }
                    }
                    ?>
                </div>
                <div class="section__container">
                    <div class="header">
                        <H1>Upcoming Events</H1>
                    </div>
                    <div class="testimonials__grid">
                        <div class="swiper_class">
                            <div class="swiper-wrapper recentSlider">
                                <?php
                                $decode_event_dir = json_encode($EventList);

                                if (is_object($EventList)) {
                                    foreach ($EventList as $item) {
                                        $item = json_decode($item);
                                        $date = date($item->Date);

                                        $formateDate = new DateTimeImmutable($date);
                                        echo '<figure class="c4-izmir c4-border-corners-2 c4-image-zoom-out swiper-slide card event" data-aos="fade-up" data-aos-duration="500">
                                                
                                                    <img loading="lazy" data-src="../API/Images/calenda/' . $item->image . '" alt="user" />
                                                <figcaption class="details_name">
                                                <p>' . $formateDate->format('jS F Y') . '</p>
                                                <h1>' . $item->Event_name . '</h1>
                                                </figcaption>
                                            </figure>';
                                    }
                                } else {
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="upcoming_header">
                    <h1>DO YOU REMEMBER ?</h1>
                </div>

                <div id="Event" class="event_section">
                    <?php
                    try {
                        if (is_object($ShowData)) {
                            $Data = $ShowData->image;
                            if (is_array($Data)) { { {
                                        echo '<div class="gallery_layout">';
                                        foreach ($Data as $image) {
                                            echo '<img data-src="../API/Images_folder/gallery/' . $image . '" alt="" />';
                                        }
                                        echo '</div>';
                                    }
                                }
                            }
                        }
                    } catch (\Throwable $th) {
                        throw $th;
                    }

                    ?>

                </div>
                <div class="upcoming_header">
                    <h1>CALENDAR ACTIVITIES</h1>
                    <div class="line">
                        <?php
                        if ($data_theme == 'christmas_theme') { { {
                                    echo '<img data-src="../images/gift2.png" alt="gift1" />';
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="data_reminder">
                    <p>We have successfully mapped out the church's calenda for the year, to help you plan your events
                        accordingly. Enjoy !!
                    </p>
                </div>

                <div class="calendaMain">
                    <div class="wrapper">
                        <i class="fas fa-list trigger_set" onclick="indicator(this);"></i>
                        <div class="months" id="months_data" data_calenderData='<?php { {
                            print_r(json_encode($calenderData));
                        }
                    } ?>'>
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

                            <div class="content">
                                <h1>Event</h1>
                                <div class="eventsDetails">
                                    <div class="head">Date:: Wednesday,17th 2021</div>
                                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Officia ipsa veritatis
                                        dolorem nihil iusto eligendi, distinctio optio reprehenderit commodi possimus
                                        laborum. Ex recusandae dolorem rerum dignissimos, facilis labore enim
                                        voluptates.</p>
                                    <div class="image">
                                        <img data-src="images/bg (2).jpeg" alt="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="upcoming_header">
                    <h1>Call to action</h1>
                    <div class="line">
                        <?php
                        if ($data_theme == 'christmas_theme') { { {
                                    echo '<img data-src="../images/gift3.png" alt="gift1" />';
                                }
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="workshop" data-aos="fade-right" data-aos-duration="800">
                    <img data-src="images/bg (2).jpeg" alt="" />
                    <?php
                    if (is_object($CallToAction)) { { {
                                echo "<div class='info'>
                        <h1>" . $CallToAction->name . " contribution</h1>
                        <p>" . $CallToAction->purpose . ", all members are expected to contribute " . $CallToAction->amount . ",
                        contribution due date is expected on " . $CallToAction->date . "</p>
                    </div>";
                            }
                        }
                    }
                    ?>
                </div>

                <div class="upcoming_header">
                    <h1>SERMONS</h1>
                    <div class="line">
                        <?php
                        if ($data_theme == 'christmas_theme') { { {
                                    echo '<img data-src="../images/gift4.png" alt="gift1" />';
                                }
                            }
                        }
                        ?>

                    </div>
                </div>

                <div class="section__container" style="display:block;">
                    <div class="testimonials__grid">
                        <div class="swiper_class">
                            <div class="swiper-wrapper recentSlider_main">
                                <?php
                                $data = $newDataRequest->library_viewList();

                                if (is_object(json_decode($data))) {
                                    $data = json_decode($data);
                                    foreach ($data as $item) {
                                        $unique_id = $item->UniqueId;
                                        $name = $item->name;
                                        $Author = $item->Author;
                                        $source = $item->source;
                                        echo '
                                           <div class="swiper-slide card event">
                                           <a href="../library/Libraryvid.php?encrypt=local&&01%8&&data_num=zoevideo&&dir=' . $hash . '&&vid_id=' . $unique_id . '" target="_blank" data-aos="fade-up" data-aos-duration="1000">
                                        <div class="image">
                                            <img loading="lazy" data-src="../API/images_folder/library/covers/' . $item->Image . '" alt="user" />
                                            <div class="details_date"><p>' . $Author . '</p><div class="details_name"><h1>' . $name . '</h1></div></div>
                                        </div></a>
                                        
                                    </div>';

                                    }
                                }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="announcement">
                    <img src="images/annc.png" alt="announcement image" />
                </div>
                <?php
                $keys = [];
                $newKeys = [];
                if (is_object($decoded_annc)) {
                    $keys = get_object_vars($decoded_annc);
                    if (count($keys) > 0) {
                        $newKeys = array_keys($keys);
                    }
                }

                ?>
                <div class="annc_honmo">

                    <div class="left_pan">
                        <div class="grid_annc cl">
                            <div class="shape_annc">
                                <div class="text_num">
                                    <h1>
                                        <?php
                                        $Object_data = json_decode($decoded_annc->{$newKeys[4]});
                                        echo $Object_data->name;
                                        ?>
                                    </h1>
                                    <div class="inner_div_annc">
                                        <p><?php echo $Object_data->message; ?></p>
                                        <?php
                                        if (!empty($Object_data->file)) {
                                            echo '<div class="options" style="display:flex;gap:10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                            <path d="M7 11l5 5l5 -5" />
                                            <path d="M12 4l0 12" />
                                        </svg>
                                        <a href="../API/images/annc/' . $Object_data->file . '" target="_blank" download><p>Download File</p></a>
                                    </div>';
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="indicator">
                                <div class="indicator_min">
                                    <div class="indicator_orig">
                                        <h1>01</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pointer">
                            <div class="s_contain">
                                <div class="pock top">
                                    <div class="inner"></div>
                                </div>
                                <div class="stick"></div>
                                <div class="pock bottom">
                                    <div class="inner"></div>
                                </div>
                            </div>

                        </div>
                        <div class="grid_annc cl">
                            <div class="shape_annc">
                                <div class="text_num">
                                    <h1>
                                        <?php
                                        $Object_data = json_decode($decoded_annc->{$newKeys[3]});
                                        echo $Object_data->name;
                                        ?>
                                    </h1>
                                    <div class="inner_div_annc">
                                        <p><?php echo $Object_data->message; ?></p>
                                    </div>

                                    <?php
                                    if (!empty($Object_data->file)) {
                                        echo '<div class="options" style="display:flex;gap:10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                            <path d="M7 11l5 5l5 -5" />
                                            <path d="M12 4l0 12" />
                                        </svg>
                                        <a href="../API/images/annc/' . $Object_data->file . '" target="_blank" download><p>Download File</p></a>
                                    </div>';
                                    }

                                    ?>
                                </div>
                            </div>
                            <div class="indicator">
                                <div class="indicator_min">
                                    <div class="indicator_orig">
                                        <h1>03</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pointer">
                            <div class="s_contain">
                                <div class="pock top">
                                    <div class="inner"></div>
                                </div>
                                <div class="stick"></div>
                                <div class="pock bottom">
                                    <div class="inner"></div>
                                </div>
                            </div>

                        </div>
                        <div class="grid_annc cl">
                            <div class="shape_annc">
                                <div class="text_num">
                                    <h1>
                                        <?php
                                        $Object_data = json_decode($decoded_annc->{$newKeys[2]});
                                        echo $Object_data->name;
                                        ?>
                                    </h1>
                                    <div class="inner_div_annc">
                                        <p><?php echo $Object_data->message; ?></p>
                                    </div>

                                    <?php
                                    if (!empty($Object_data->file)) {
                                        echo '<div class="options" style="display:flex;gap:10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                            <path d="M7 11l5 5l5 -5" />
                                            <path d="M12 4l0 12" />
                                        </svg>
                                        <a href="../API/images/annc/' . $Object_data->file . '" target="_blank" download><p>Download File</p></a>
                                    </div>';
                                    }

                                    ?>
                                </div>
                            </div>
                            <div class="indicator">
                                <div class="indicator_min">
                                    <div class="indicator_orig">
                                        <h1>02</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right_pan">
                        <div class="grid_annc">

                            <div class="indicator">
                                <div class="indicator_min">
                                    <div class="indicator_orig">
                                        <h1>04</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="shape_annc">
                                <div class="text_num">
                                    <h1>
                                        <?php
                                        $Object_data = json_decode($decoded_annc->{$newKeys[1]});
                                        echo $Object_data->name;
                                        ?>
                                    </h1>
                                    <div class="inner_div_annc">
                                        <p><?php echo $Object_data->message; ?></p>
                                    </div>

                                    <?php
                                    if (!empty($Object_data->file)) {
                                        echo '<div class="options" style="display:flex;gap:10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                            <path d="M7 11l5 5l5 -5" />
                                            <path d="M12 4l0 12" />
                                        </svg>
                                        <a href="../API/images/annc/' . $Object_data->file . '" target="_blank" download><p>Download File</p></a>
                                    </div>';
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="pointer">
                            <div class="s_contain">
                                <div class="pock top">
                                    <div class="inner"></div>
                                </div>
                                <div class="stick"></div>
                                <div class="pock bottom">
                                    <div class="inner"></div>
                                </div>
                            </div>

                        </div>
                        <div class="grid_annc">
                            <div class="indicator">
                                <div class="indicator_min">
                                    <div class="indicator_orig">
                                        <h1>05</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="shape_annc">
                                <div class="text_num">
                                    <h1>
                                        <?php
                                        $Object_data = json_decode($decoded_annc->{$newKeys[0]});
                                        echo $Object_data->name;
                                        ?>
                                    </h1>
                                    <div class="inner_div_annc">
                                        <p><?php echo $Object_data->message; ?></p>
                                    </div>

                                    <?php
                                    if (!empty($Object_data->file)) {
                                        echo '<div class="options" style="display:flex;gap:10px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" />
                                            <path d="M7 11l5 5l5 -5" />
                                            <path d="M12 4l0 12" />
                                        </svg>
                                        <a href="../API/images/annc/' . $Object_data->file . '" target="_blank" download><p>Download File</p></a>
                                    </div>';
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section id="easter">
                <div class="wrapper">
                    <img data-src="images/easter/leaf.png" alt="leave img" class="leafimg" />

                    <div class="content">

                        <div class="main-header">
                            <div class="layers">
                                <div class="layer-header">
                                    <div class="title">EASTER CELEBRATION</div>
                                    <div class="subtitle">HAPPY EASTER !!</div>
                                </div>
                                <div class="layer base"></div>
                                <div class="layer middle"></div>
                                <div class="layer front"></div>
                            </div>

                        </div>

                        <div class="article">
                            <div>
                                <h2 class="header">
                                    Death could not hold him, Our lord God Jesus christ has risen
                                </h2>

                            </div>
                        </div>


                    </div>
                </div>
            </section>
            <a href="../login/?userlogin">
                <div class="user_icon">
                    <i class="fas fa-user"></i>
                </div>
            </a>

            <div class="send_up">
                <i class="fas fa-arrow-up"></i>
            </div>

        </main>
        <footer>
            <div class="footer-container">
                <div class="sec aboutus">
                    <h2>About Us</h2>
                    <p>Zoe worship centre is a welcoming community of faith dedicated to loving God and loving
                        others.
                        We invite you to join us as we explore God's Word, experience His presence and serve our
                        community.</p>
                    <ul class="sci">
                        <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
                <div class="sec quicklinks">
                    <h2>Quick Links</h2>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="Gallery.php">Gallery</a></li>
                        <li><a href="testProjects.php">projects</a></li>
                        <li><a href="missions/">missions</a></li>
                        <li><a href="partnership/">partnerships</a></li>
                        <li><a href="../library/library.php">library</a></li>

                    </ul>
                </div>
                <div class="sec contactBx">
                    <h2>Contact Info</h2>
                    <ul class="info">
                        <li>
                            <span><i class='bx bxs-map'></i></span>
                            <span>location Galalea street <br> Kasoa <br> Gh</span>
                        </li>
                        <li>
                            <span><i class='bx bx-envelope'></i></span>
                            <p><a href="mailto:zoe@gmail.com">Zoe@gmail.com</a></p>
                        </li>
                    </ul>
                </div>
            </div>
        </footer>
        <script src="css/slick.min.js" defer></script>
        <script src="../js/aos.js"></script>
        <script>
            $(document).ready(function () {

                Sliders = document.querySelector('.recentSlider_main');
                $(Sliders).slick({
                    slidesToShow: 4,
                    slidesToScroll: 1,
                    autoplay: true,
                    arrows: false,

                })
                Slider_event = document.querySelector('#recent_activities');
                settings = {
                    slidesToShow: 4,
                    slidesToScroll: 2,
                    autoplay: true,
                    arrows: false,
                    dots: false,
                    pauseOnHover: true,
                    mobileFirst: true,
                    responsive: [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }
                    }, {
                        breakpoint: 520,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }


                    }]

                }
                $(Slider_event).slick(settings);

                AOS.init();
                const toggle = document.querySelector(".menu_toggle");
                const sendUp = document.querySelector(".send_up");
                const navigation = document.querySelector('.navigation');
                const menuDiv = document.querySelector(".navigation");
                toggle.addEventListener("click", function (e) {
                    toggle.classList.toggle("active");
                    menuDiv.classList.toggle("active");
                });
                document.addEventListener("scroll", function () {
                    if (window.scrollY > 100) {
                        sendUp.classList.add("active");
                    } else {
                        sendUp.classList.remove("active");
                    }
                    if (window.scrollY > 600) {
                        navigation.classList.add('bg_illust');
                        toggle.classList.add('bg_illust');
                    } else {
                        navigation.classList.remove('bg_illust');
                        toggle.classList.remove('bg_illust');
                    }
                });
                var rootElement = document.documentElement;
                sendUp.addEventListener("click", function () {
                    rootElement.scrollTo({
                        top: 0,
                        behavior: "smooth",
                    });
                });
                const images = document.querySelectorAll('img');
                const preloadImage = (img) => {
                    const src = img.getAttribute('data-src');
                    if (!src) return;
                    img.src = src;
                };

                const imgObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) return;
                        preloadImage(entry.target);
                        observer.unobserve(entry.target);
                    });
                });

                images.forEach(image => {
                    imgObserver.observe(image);
                });
            })
        </script>
        <?php
        if ($data_theme != "Fetching data encountered a problem" || $data_theme != "No records available'" || $data_theme != "Error Occurred") {
            if ($data_theme == 'easter') {
                echo '<script>
            window.addEventListener("scroll", e => {
                console.log(this.scrollY);
                if (this.scrollY > 650) {
                    document.documentElement.style.setProperty("--scrollTop", `${this.scrollY - 650}px`)
                } else {
                    document.documentElement.style.setProperty("--scrollTop", `0px`)
                }
            });

        </script>';
            }
        }
        ?>
    </body>

    </html>
    <?php
} else { { {
            echo "<header>We did not find enough data to display for you. Please revisit again. 
    hopefully data will be available for your consumption</header>";
        }
    }
}

?>