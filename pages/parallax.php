<?php
session_start();
if (isset($_SESSION['unique_id'])) {

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
            <link rel="preload" as="style" href="../library/js/swiper/package/swiper-bundle.css" />

            <link rel="stylesheet" href="parallax.css">
            <link rel="stylesheet" href="parallaxfooter.css">
            <?php
            if ($data_theme != "Fetching data encountered a problem" || $data_theme != "No records available'" || $data_theme != "Error Occurred") {
                if ($data_theme == 'easter') {
                    echo "<link rel='stylesheet' href='easter.css'>";
                }
            }
            ?>
            <link rel="stylesheet" href="../icons/css/all.css">
            <link rel="stylesheet" href="../library/js/swiper/package/swiper-bundle.css" />
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
        if ($data_theme != "Fetching data_theme encounted a problem" || $data_theme != "No records available'" || $data_theme != "Error Occurred") {
            echo $data_theme;
        }
        ?>">
            <div class="navigation">

                <div class="nav_logo">
                    <header>LOGO</header>
                </div>
                <div class="nav_ele">

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
                    <a href="testProject.php">
                        <div class="item_list">
                            <p>Projects</p>
                        </div>
                    </a>

                    <a href="partnership/index.html">
                        <div class="item_list">
                            <p>Partnership</p>
                        </div>
                    </a>
                    <a href="leadership.php">
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
                            <div class="text">
                                <h1>THE APOSTOLIC CHURCH - GHANA</h1>
                                <p>Zoe Worship centre - Galelia</p>

                                <div class="motto">
                                    <?php
                                    if ($data_theme != 'christmas_theme') {
                                        echo '<p>(2024) THE LORD THY GOD IN THE MIDST <br> OF THEE IS MIGHTY </p>';
                                    }
                                    ?>
                                </div>
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
                                                </p>
                                            </div>
                                            <label>Births</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="total">

                                            <div class="Number three">
                                                <p class="totalYouth count" data-target="<?php { {
                                                    echo $DeathNum;
                                                }
                                            } ?>">
                                                    <?php { {
                                                        echo $DeathNum;
                                                    }
                                                } ?>
                                                </p>
                                            </div>
                                            <label>Death</label>
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
                                                </p>
                                            </div>
                                            <label>Baptism</label>
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
                                <div class="swiper-wrapper">
                                    <?php
                                    $data = json_decode($gallery);
                                    if ($data != 'Error occured' || $data != 'fetching encounterd an error' || $data != 'no records available') {
                                        foreach ($data as $file) {
                                            foreach ($file as $img) { { {
                                                        echo ' <div class="swiper-slide card">
                                            <img loading="lazy" data-src="../API/images_folder
                                            /gallery/' . $img . '" alt="user" />
                                            </div>';
                                                    }
                                                }
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
                    <div class="workshop">
                        <?php
                        if (is_object($decoded_event)) { { {
                                    echo "<img data-src='../API/Images/calenda/images/" . $decoded_event->image . "' alt='' />
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
                        <div class="testimonials__grid">
                            <div class="swiper_class">
                                <div class="swiper-wrapper">
                                    <?php
                                    $decode_event_dir = json_encode($EventList);

                                    if (is_object($EventList)) {
                                        foreach ($EventList as $item) {
                                            $item = json_decode($item);
                                            $date = date($item->Date);

                                            $formateDate = new DateTimeImmutable($date);
                                            echo '<div class="swiper-slide card event">
                                                <div class="image">
                                                    <img loading="lazy" data-src="../API/Images/calenda/' . $item->image . '" alt="user" />
                                                    <div class="details_date">' . $formateDate->format('jS F Y') . '</div>
                                                </div>
                                                <div class="details_name">' . $item->Event_name . '</div>
                                            </div>';
                                        }
                                    } else {
                                    }
                                    ?>


                                    <div class="swiper-slide card event">
                                        <div class="image">
                                            <img loading="lazy" data-src="../API/images_folder
                                            /users/pexels-steven-arenas-14151-620074.jpg" alt="user" />
                                            <div class="details_date">13th Nov 2024</div>
                                        </div>
                                        <div class="details_name">Gallery show Service</div>
                                    </div>

                                    <div class="swiper-slide card event">
                                        <div class="image">
                                            <img loading="lazy" data-src="../API/images_folder
                                            /users/pexels-steven-arenas-14151-620074.jpg" alt="user" />
                                            <div class="details_date">13th Nov 2024</div>
                                        </div>
                                        <div class="details_name">Gallery show Service</div>
                                    </div>
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
                                            echo '<div class="gallery_layout">
                                <img data-src="../API/Images_folder/gallery/' . $Data[0] . '" alt="" />
                            
                                <img data-src="../API/Images_folder/gallery/' . $Data[1] . ' alt="" />
                            
                                    <img data-src="../API/Images_folder/gallery/' . $Data[2] . '" class="xxl" alt="" />
                                    <img data-src="../API/Images_folder/gallery/' . $Data[3] . ' alt="" />
                                    <img data-src="../API/Images_folder/gallery/' . $Data[4] . '" alt="" />
                              
                                <img data-src="../API/Images_folder/gallery/' . $Data[5] . '" alt="" />
                           
                             </div>';
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
                                <h1>Event</h1>
                                <div class="eventsDetails">
                                    <div class="head">Wednesday,17th 2021</div>
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

                    <div class="workshop">
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

                    <div class="section__container">
                        <div class="testimonials__grid">
                            <div class="swiper_class">
                                <div class="swiper-wrapper">
                                    <?php
                                    $data = $newDataRequest->library_viewList();

                                    if ($data != 'No Records available' && $data != "Fetching data encountered an error" && $data != 'Error Occurred') {
                                        $data = json_decode($data);
                                        foreach ($data as $item) {
                                            $unique_id = $item->UniqueId;
                                            $name = $item->name;
                                            $Author = $item->Author;
                                            $source = $item->source;
                                            echo '<a href="../library/Libraryvid.php?encrypt=local&&01%8&&data_num=zoevideo&&dir=' . $hash . '&&vid_id=' . $unique_id . '" target="_blank">
                                           
                                        <div class="image">
                                            <img loading="lazy" data-src="../API/images_folder/library/covers/' . $item->Image . '" alt="user" />
                                            <div class="details_date">' . $Author . '</div>
                                        </div>
                                        <div class="details_name">' . $name . '</div>
                                    </div></a>';

                                        }
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="workshop">
                        <?php
                        if (is_object($decoded_annc)) { { {
                                    echo '
                            <img data-src="../API/images/annc/' . $decoded_annc->file . '" alt="" />
                            <div class="info">
                                <h1>' . $decoded_annc->name . '</h1>
                                <p>' . $decoded_annc->message . '</p>
                            </div>';
                                }
                            }
                        } else { { {
                                    echo "<header>Announcement data is not yet available</header>";
                                }
                            }
                        }
                        ?>
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
                        <i class="fas fa-users"></i>
                    </div>
                </a>

                <div class="send_up">
                    <i class="fas fa-arrow-up"></i>
                </div>

            </main>
            <footer>
                <div class="container">
                    <div class="brand">
                        <header>ZOE WORSHIP CENTRE</header>
                        <ul>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <div class="links">
                        <ul>
                            <li>Home</li>
                            <li>Projects</li>
                            <li>Partnership</li>
                            <li>leaders</li>
                            <li>library</li>
                        </ul>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis optio soluta sunt
                            corrupti
                            necessitatibus, reprehenderit aperiam sint, labore, voluptate aliquid earum. Sapiente quos
                            quam
                            ducimus asperiores nam voluptas iste perferendis?</p>
                    </div>
                    <div class="contact">
                        <div class="field">
                            <h2>Contact</h2>
                            <ul>
                                <li><span>Email :</span></li>
                                <li>zoeworshipcentrechurch@gmail.com</li>
                                <li><span>WhatsApp :</span></li>
                                <li>(+233) - 553 838 464</li>
                                <li><span>Caller :</span></li>
                                <li>(+001) - 5534 838 4649</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                if ($data_theme == 'christmas_theme') { { {
                            echo '<img data-src="../images/gift5.png" alt="gift1" />';
                        }
                    }
                }
                ?>
            </footer>
            <script src="../library/js/swiper/package/swiper-bundle.min.js"></script>

            <script>
                const toggle = document.querySelector(".menu_toggle");
                var sendUp = document.querySelector(".send_up");

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
                });
                var rootElement = document.documentElement;
                sendUp.addEventListener("click", function () {
                    rootElement.scrollTo({
                        top: 0,
                        behavior: "smooth",
                    });
                });

                // var swiper = new Swiper(".swiper_class", {
                //     effect: "coverflow",
                //     grabCursor: true,
                //     centeredSlides: true,
                //     slidesPerView: "auto",
                //     pagnation: {
                //         el: '.swiper-pagination',
                //     },
                //     coverflowEffect: {
                //         rotate: 0,
                //         stretch: 0,
                //         depth: 100,
                //         modifier: 2,
                //         slideShadows: true,
                //     },
                //     loop: true,
                //     autoplay: {
                //         delay: 2000,
                //         disableOnInteraction: false,
                //     },
                // });
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
} else {
    header("Location: ../login/?userlogin");
}
?>