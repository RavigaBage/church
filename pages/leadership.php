<?php
require '../API/vendor/autoload.php';
$viewDataClass = new Membership\viewData();
$data = $viewDataClass->viewList('1');
if ($data != "Fetching data encountered a problem" || $data != "No records available'" || $data != "Error Occurred") {
    $decoded = json_decode($data);

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../icons/css/all.css">
        <link rel="stylesheet" href="../css/intro.css">
        <link rel="stylesheet" href="parallax.css">
        <title>Zoe worship center leadership page</title>
    </head>
    <style>
        body {
            height: fit-content;
        }



        .slider {
            height: auto;
        }



        @media screen and (max-width:1100px) {
            section {
                max-height: 120svh;
            }

            .side_menu:not(.menu_on) .menu_tog .fa-bars {
                display: block;
            }

            .side_menu:not(.menu_on) .menu_tog .fa-times {
                display: none;
            }

            .side_menu.menu_on .menu_tog .fa-bars {
                display: none;
            }

            .side_menu.menu_one .menu_tog .fa-times {
                display: block;
            }
        }

        @media screen and (max-width: 768px) {
            section {
                max-height: 180vh;
            }
        }

        @media screen and (max-width: 425px) {
            section {
                max-height: 200vh;
            }
        }
    </style>

    <body>
        <section class="about_us slide item section">
            <div style="width:99%;display: flex;">
                <div class="side_menu">
                    <div class="menu_tog">
                        <i class="fas fa-bars"></i>
                        <i class="fas fa-times"></i>
                    </div>

                    <ul>
                        <li class="active" data_trigger="list_1">Choir</li>
                        <li data_trigger="list_2">Children ministry</li>
                        <li>Dazzling stars</li>
                        <li>Daughters of zion</li>
                        <li>Deacon and Deaconess</li>
                        <li>Evangelism</li>
                        <li>Protocol and media</li>
                        <li>Sons of zion</li>
                        <li>Welfare</li>
                        <li>Youth ministry</li>
                    </ul>
                </div>
                <div class="slider list">
                    <div class="Slider-item list">

                        <div class="Slider-caption fadeInLeft animated sub" data-animation-in="fadeInLeft"
                            style="opacity: 1" id="list_1">
                            <div class="textColors" style="--font:mario;--size:70px">
                                <h4 class="h4_title">Welcome to the <p><span>Zoe worship centre</span></p>
                                    Leadership
                                </h4>
                            </div>
                            <p class="movies_tip">About us, we are here to serve God and partake in his ministry</p>
                            <div class="team_details">
                                <div class="frame tilt_left">
                                    <img src="../API/Images_folder/users/pexels-chloekalaartist-1043473.jpg" alt="" />
                                    <div class="details_box">
                                        <h1><b></b>K.B Akotia mensah</b></h1>
                                        <p>Holds the position of <b>Apostle</b></p>
                                    </div>
                                </div>
                                <div class="frame tilt_right">
                                    <img src="../API/Images_folder/users/pexels-soldiervip-1468379.jpg" alt="" />
                                    <div class="details_box">
                                        <h1><b></b>Oslo mantey</b></h1>
                                        <p>Holds the position of <b>Elder</b></p>
                                    </div>
                                </div>
                                <div class="frame">
                                    <img src="leader_default/_MG_8896.JPG" alt="" />
                                </div>
                                <div class="frame tilt_left">
                                    <img src="leader_default/_MG_8711.JPG" alt="" />
                                </div>
                            </div>
                        </div>
                        <div class="Slider-caption fadeInLeft animated sub" data-animation-in="fadeInLeft"
                            style="opacity: 1" id="list_2">
                            <div class="textColors" style="--font:mario;--size:70px">
                                <h4 class="h4_title">Children Ministry Leadership</h4>
                            </div>
                            <p class="movies_tip">About us, we are here to serve God and partake in his ministry</p>
                            <div class="team_details">
                                <?php
                                try {
                                    $data = $viewDataClass->PositionList('children');
                                    if ($data != " " || $data != "Fetching data encountered a problem" || $data != "No records available'" || $data != "Error Occurred") {
                                        $decoded = json_decode($data);
                                        $i = 0;
                                        if (is_object($decoded)) {
                                            foreach ($decoded as $item) {
                                                $choose = round($i % 2);
                                                $classes = ['tilt_left', 'tilt_right'];
                                                $chooseClass = $classes[$choose];
                                                echo '<div class="frame ' . $chooseClass . '">
                                                <img src="../API/Images_folder/users/' . $item->image . '" alt="" />
                                            </div>';
                                                $i++;
                                            }
                                        }
                                    } else {
                                        echo '<header>An error Occurred</header>';
                                    }
                                } catch (\Throwable $error) {
                                    throw $error;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="Slider-caption fadeInLeft animated sub" data-animation-in="fadeInLeft"
                            style="opacity: 1" id="list_2">
                            <div class="textColors" style="--font:mario;--size:70px">
                                <h4 class="h4_title">Dazzling stars Ministry Leadership</h4>
                            </div>
                            <p class="movies_tip">About us, we are here to serve God and partake in his ministry</p>
                            <div class="team_details">
                                <?php
                                try {
                                    $data = $viewDataClass->PositionList('Dazzling');
                                    if ($data != " " || $data != "Fetching data encountered a problem" || $data != "No records available'" || $data != "Error Occurred") {
                                        $decoded = json_decode($data);
                                        $i = 0;
                                        if (is_object($decoded)) {
                                            foreach ($decoded as $item) {
                                                $choose = round($i % 2);
                                                $classes = ['tilt_left', 'tilt_right'];
                                                $chooseClass = $classes[$choose];

                                                echo '<div class="frame ' . $chooseClass . '">
                                                <img src="../API/Images_folder/users/' . $item->image . '" alt="" />
                                                </div>';
                                                $i++;
                                            }
                                        } else {
                                            echo '<header>An error Occurred</header>';
                                        }
                                    } else {
                                        echo '<header>An error Occurred</header>';
                                    }
                                } catch (\Throwable $th) {
                                    throw $th;
                                }

                                ?>
                            </div>
                        </div>
                        <div class="Slider-caption fadeInLeft animated sub" data-animation-in="fadeInLeft"
                            style="opacity: 1" id="list_2">
                            <div class="textColors" style="--font:mario;--size:70px">
                                <h4 class="h4_title">Daughters of Zion Leadership</h4>
                            </div>
                            <p class="movies_tip">About us, we are here to serve God and partake in his ministry</p>
                            <div class="team_details">
                                <?php
                                try {
                                    $data = $viewDataClass->PositionList('Daughter');
                                    if ($data != " " || $data != "Fetching data encountered a problem" || $data != "No records available'" || $data != "Error Occurred") {
                                        $decoded = json_decode($data);
                                        $i = 0;
                                        if (is_object($decoded)) {
                                            foreach ($decoded as $item) {
                                                $choose = round($i % 2);
                                                $classes = ['tilt_left', 'tilt_right'];
                                                $chooseClass = $classes[$choose];

                                                echo '<div class="frame ' . $chooseClass . '">
                                            <img src="../API/Images_folder/users/' . $item->image . '" alt="" />
                                            </div>';
                                                $i++;
                                            }
                                        } else {
                                            echo '<header>An error Occurred</header>';
                                        }
                                    } else {
                                        echo '<header>An error Occurred</header>';
                                    }
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="Slider-caption fadeInLeft animated sub" data-animation-in="fadeInLeft"
                            style="opacity: 1" id="list_2">
                            <div class="textColors" style="--font:mario;--size:70px">
                                <h4 class="h4_title">Deacons and Deaconess Leadership</h4>
                            </div>
                            <p class="movies_tip">About us, we are here to serve God and partake in his ministry</p>
                            <div class="team_details">
                                <?php
                                try {
                                    $data = $viewDataClass->PositionList('Deacon');
                                    if ($data != " " || $data != "Fetching data encountered a problem" || $data != "No records available'" || $data != "Error Occurred") {
                                        $decoded = json_decode($data);
                                        $i = 0;
                                        if (is_object($decoded)) {
                                            foreach ($decoded as $item) {
                                                $choose = round($i % 2);
                                                $classes = ['tilt_left', 'tilt_right'];
                                                $chooseClass = $classes[$choose];

                                                echo '<div class="frame ' . $chooseClass . '">
                                                <img src="../API/Images_folder/users/' . $item->image . '" alt="" /
                                                </div>';
                                                $i++;
                                            }
                                        } else {
                                            echo '<header>An error Occurred</header>';
                                        }
                                    } else {
                                        echo '<header>An error Occurred</header>';
                                    }
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="Slider-caption fadeInLeft animated sub" data-animation-in="fadeInLeft"
                            style="opacity: 1" id="list_2">
                            <div class="textColors" style="--font:mario;--size:70px">
                                <h4 class="h4_title">Evangelism Leadership</h4>
                            </div>
                            <p class="movies_tip">About us, we are here to serve God and partake in his ministry</p>
                            <div class="team_details">
                                <?php
                                try {
                                    $data = $viewDataClass->PositionList('Evangelist');
                                    if ($data != " " || $data != "Fetching data encountered a problem" || $data != "No records available'" || $data != "Error Occurred") {
                                        $decoded = json_decode($data);
                                        $i = 0;
                                        if (is_object($decoded)) {
                                            foreach ($decoded as $item) {
                                                $choose = round($i % 2);
                                                $classes = ['tilt_left', 'tilt_right'];
                                                $chooseClass = $classes[$choose];

                                                echo '<div class="frame ' . $chooseClass . '">
                                                <img src="../API/Images_folder/users/' . $item->image . '" alt="" /
                                                </div>';
                                                $i++;
                                            }
                                        } else {
                                            echo '<header>An error Occurred</header>';
                                        }
                                    } else {
                                        echo '<header>An error Occurred</header>';
                                    }
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="Slider-caption fadeInLeft animated sub" data-animation-in="fadeInLeft"
                            style="opacity: 1" id="list_2">
                            <div class="textColors" style="--font:mario;--size:70px">
                                <h4 class="h4_title">Protocol and media Leadership</h4>
                            </div>
                            <p class="movies_tip">About us, we are here to serve God and partake in his ministry</p>
                            <div class="team_details">
                                <?php
                                try {
                                    $data = $viewDataClass->PositionList('protocol');
                                    if ($data != " " || $data != "Fetching data encountered a problem" || $data != "No records available'" || $data != "Error Occurred") {
                                        $decoded = json_decode($data);
                                        $i = 0;
                                        if (is_object($decoded)) {
                                            foreach ($decoded as $item) {
                                                $choose = round($i % 2);
                                                $classes = ['tilt_left', 'tilt_right'];
                                                $chooseClass = $classes[$choose];

                                                echo '<div class="frame ' . $chooseClass . '">
                                                <img src="../API/Images_folder/users/' . $item->image . '" alt="" /
                                                </div>';
                                                $i++;
                                            }
                                        } else {
                                            echo '<header>An error Occurred</header>';
                                        }
                                    } else {
                                        echo '<header>An error Occurred</header>';
                                    }
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="Slider-caption fadeInLeft animated sub" data-animation-in="fadeInLeft"
                            style="opacity: 1" id="list_2">
                            <div class="textColors" style="--font:mario;--size:70px">
                                <h4 class="h4_title">Sons of Zion Leadership</h4>
                            </div>
                            <p class="movies_tip">About us, we are here to serve God and partake in his ministry</p>
                            <div class="team_details">
                                <?php
                                try {
                                    $data = $viewDataClass->PositionList('sons');
                                    if ($data != " " || $data != "Fetching data encountered a problem" || $data != "No records available'" || $data != "Error Occurred") {
                                        $decoded = json_decode($data);
                                        $i = 0;
                                        if (is_object($decoded)) {
                                            foreach ($decoded as $item) {
                                                $choose = round($i % 2);
                                                $classes = ['tilt_left', 'tilt_right'];
                                                $chooseClass = $classes[$choose];

                                                echo '<div class="frame ' . $chooseClass . '">
                                                <img src="../API/Images_folder/users/' . $item->image . '" alt="" /
                                                </div>';
                                                $i++;
                                            }
                                        } else {
                                            echo '<header>An error Occurred</header>';
                                        }
                                    } else {
                                        echo '<header>An error Occurred</header>';
                                    }
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="Slider-caption fadeInLeft animated sub" data-animation-in="fadeInLeft"
                            style="opacity: 1" id="list_2">
                            <div class="textColors" style="--font:mario;--size:70px">
                                <h4 class="h4_title">Welfare Leadership</h4>
                            </div>
                            <p class="movies_tip">About us, we are here to serve God and partake in his ministry</p>
                            <div class="team_details">
                                <?php
                                try {
                                    $data = $viewDataClass->PositionList('welfare');
                                    if ($data != " " || $data != "Fetching data encountered a problem" || $data != "No records available'" || $data != "Error Occurred") {
                                        $decoded = json_decode($data);
                                        $i = 0;
                                        if (is_object($decoded)) {
                                            foreach ($decoded as $item) {
                                                $choose = round($i % 2);
                                                $classes = ['tilt_left', 'tilt_right'];
                                                $chooseClass = $classes[$choose];

                                                echo '<div class="frame ' . $chooseClass . '">
                                                <img src="../API/Images_folder/users/' . $item->image . '" alt="" /
                                                </div>';
                                                $i++;
                                            }
                                        } else {
                                            echo '<header>An error Occurred</header>';
                                        }
                                    } else {
                                        echo '<header>An error Occurred</header>';
                                    }
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                                ?>
                            </div>
                        </div>
                        <div class="Slider-caption fadeInLeft animated sub" data-animation-in="fadeInLeft"
                            style="opacity: 1" id="list_2">
                            <div class="textColors" style="--font:mario;--size:70px">
                                <h4 class="h4_title">Youth Ministry Leadership</h4>
                            </div>
                            <p class="movies_tip">About us, we are here to serve God and partake in his ministry</p>
                            <div class="team_details">
                                <?php
                                try {
                                    $data = $viewDataClass->PositionList('youth');
                                    if ($data != " " || $data != "Fetching data encountered a problem" || $data != "No records available'" || $data != "Error Occurred") {
                                        $decoded = json_decode($data);
                                        $i = 0;
                                        if (is_object($decoded)) {
                                            foreach ($decoded as $item) {
                                                $choose = round($i % 2);
                                                $classes = ['tilt_left', 'tilt_right'];
                                                $chooseClass = $classes[$choose];

                                                echo '<div class="frame ' . $chooseClass . '">
                                            <img src="../API/Images_folder/users/' . $item->image . '" alt="" /
                                            </div>';
                                                $i++;
                                            }
                                        } else {
                                            echo '<header>An error Occurred</header>';
                                        }
                                    } else {
                                        echo '<header>An error Occurred</header>';
                                    }
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <div class="footer_content">
                <div class="images">
                    <div class="grid_complex">
                        <img src="gallery/xxL.jpg" alt="" />
                        <img src="gallery/xw.jpg" alt="" />
                        <img src="gallery/xw2.jpg" alt="" />
                    </div>
                </div>
                <div class="welcome">
                    <h1>Zoe worship centre</h1>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Laboriosam quasi cupiditate eum explicabo
                        maxime magnam accusamus quo nesciunt molestiae voluptates. Asperiores accusamus ad eveniet quasi eum
                        ducimus porro, delectus odio?</p>
                    <div class="social_media">
                        <div class="item"><i class="fab fa-facebook"></i></div>
                        <div class="item"><i class="fab fa-twitter"></i></div>
                        <div class="item"><i class="fab fa-instagram"></i></div>
                        <div class="item"><i class="fab fa-youtube"></i></div>
                    </div>
                </div>
                <div class="welcome">
                    <h1>Quick Links</h1>
                    <ul>
                        <li>Home</li>
                        <li>Ministries</li>
                        <li>Profile</li>
                        <li>library </li>
                        <li>leadership</li>
                        <li>Gallery</li>

                    </ul>
                </div>
                <div class="request">
                    <div class="field">
                        <h1>Sedn a Request</h1>
                        <textarea></textarea>
                    </div>
                    <button>Submit </button>
                </div>
            </div>
        </footer>

        <script defer>
            const leadership_menu_list = [...document.querySelectorAll('.about_us .side_menu ul li')];
            const sideMenuBar = document.querySelector('.about_us .side_menu .menu_tog');
            sideMenuBar.addEventListener('click', function () {
                document.querySelector('.about_us .side_menu').classList.toggle('menu_on');
            })
            leadership_menu_list.forEach(element => {
                element.addEventListener('click', function () {
                    element.classList.add('active')
                    num = leadership_menu_list.indexOf(element);
                    const ParentElement = document.querySelector('.about_us .Slider-item');
                    const ItemElement = document.querySelectorAll('.about_us .Slider-caption');
                    //////////////////calculations
                    const element_h = ItemElement[num].clientHeight;
                    ParentElement.style.setProperty('--transition_value', -1 * element_h * num);
                    leadership_menu_list.forEach(element2 => {
                        if (element != element2) {
                            element2.classList.remove('active');
                        }
                    });

                    document.querySelector('.about_us .side_menu').classList.toggle('menu_on');
                });
            });


        </script>
    </body>

    </html>
    <?php
} else {
    echo "<header>We did not find enough data to display for you. Please revisit again. 
    hopefully data will be available for your consumption</header>";
}
?>