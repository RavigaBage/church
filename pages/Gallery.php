<?php
require '../API/vendor/autoload.php';
$viewDataClass = new Gallery\viewData();
$data = $viewDataClass->gallery_view_sort_view();
if ($data != "Fetching data encounted a problem" || $data != "No records available'" || $data != "Error Occurred") {
    $decoded = json_decode($data);
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="gal.css">
        <link rel="stylesheet" href="../css/aos.css">
        <title>Zoe memories</title>
    </head>

    <body>
        <main>
            <nav>
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
            </nav>

            <div class="line_right">
                <div class="menu_name">
                    <p>Event section</p>
                </div>
                <div class="line"></div>
            </div>

            <div data-aos="zoom-out" class="hero_section">
                <div class="title">
                    <h2>Zoe Memories</h2>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Molestiae quasi sit atque nesciunt non
                        nihil delectus libero necessitatibus corrupti explicabo veniam dignissimos id ullam officia, debitis
                        odio sapiente fugiat dolores necessitatibus corrupti explicabo veniam dignissimos id ullam officia,
                        debitis
                        odio sapiente fugiat dolores.</p>
                </div>
                <div class="nav_ele">
                    <?php
                    foreach ($decoded as $item) {
                        $Event_name = $item->Event_name;
                        echo '<a href="#' . $Event_name . '">
                        <div class="item_list">
                            <p>' . $Event_name . '</p>
                        </div>
                        </a>';
                    }
                    ?>
                </div>
            </div>
            <section id="Event" class="event_section">
                <div class="section_title">
                    <p>Event section</p>
                </div>
                <div class="gallery_layout">
                    <div class="img col1" data-aos="zoom-in-up">
                        <img src="gallery/x1.jpeg" alt="" />
                    </div>
                    <div class="img col1" data-aos="zoom-in-right">
                        <img src="gallery/x2.jpg" alt="" />
                    </div>
                    <div class="img col1" data-aos="zoom-in-left">
                        <img src="gallery/x3.jpg" alt="" />
                    </div>
                    <div class="img col2 main">
                        <div class="grid_complex">
                            <img src="gallery/xxL.jpg" data-aos="zoom-out" alt="" />
                            <img src="gallery/xw.jpg" data-aos="zoom-out-down" alt="" />
                            <img src="gallery/xw2.jpg" data-aos="zoom-out-right" alt="" />
                        </div>
                    </div>
                    <div class="img col2">
                        <img src="gallery/x4.jpg" data-aos="fade-up" alt="" />
                    </div>
                    <div class="img xxl">
                        <img src="gallery/xxL.jpg" data-aos="fade-down" alt="" />
                    </div>
                </div>

                </div>

            </section>
            <?php
            foreach ($decoded as $item) {
                $viewDataClass = new Gallery\viewData();
                $Event_name = $item->Event_name;
                $data = $viewDataClass->gallery_view_sort_eventData($Event_name);
                if ($data != "Fetching data encounted a problem" || $data != "No records available'" || $data != "Error Occurred") {
                    $decoded = json_decode($data);
                    echo '<section id="' . $Event_name . '">
                    <div class="section_title">
                        <p>' . $Event_name . '</p>
                    </div><div class="gallery">';

                    foreach ($decoded as $item) {
                        $Event_name = $item->Event_name;
                        echo '<img data-aos="zoom-in-up" src="../API/Images_folder/gallery/' . $Event_name . '" alt="" />';
                    }
                    echo '</div></section>';
                }
            }
            ?>

        </main>
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
        <script src="../js/aos.js"></script>
        <script>
            AOS.init();
            const toggle = document.querySelector(".menu_toggle");
            const menuDiv = document.querySelector(".nav_ele");
            const LinksA = document.querySelectorAll('.nav_ele a');
            toggle.addEventListener("click", function (e) {
                toggle.classList.toggle("active");
                menuDiv.classList.toggle("active");
            });
            LinksA.forEach(element => {
                element.addEventListener("click", function (e) {
                    toggle.classList.remove("active");
                    menuDiv.classList.remove("active");
                })
            });

            const Elements = document.querySelectorAll("section");
            const Indicator = document.querySelector('.line_right .menu_name p')
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        SectionName = entry.target.getAttribute("id");
                        Indicator.innerText = `${SectionName} section`;

                    }
                });
            });
            Elements.forEach((el) => observer.observe(el));

        </script>
    </body>

    </html>
    <?php
} else {
    echo "<header>We did not find enough data to display for you. Please revisit again. 
    hopefully data will be available for your consumption</header>";
}
?>