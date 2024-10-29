<?php
require '../API/vendor/autoload.php';
session_start();
$viewDataClass = new Gallery\viewData();
$condition = false;

if (isset($_SESSION['unique_id'])) {
    $login_details = $_SESSION['unique_id'];
    if (!isset($_SESSION['gallery_entryLog'])) {
        $date = date('Y-m-d H:i:s');
        $newquest = $viewDataClass->DataHistory($login_details, "Gallery selection", $date, "Gallery section", "Admin Viewed Gallery section");
        $decode = json_decode($newquest);
        if ($decode == 'Success') {
            $condition = true;
            $_SESSION['gallery_entryLog'] = true;
        }
    } else {
        $condition = true;
    }
} else {
    $condition = false;
}
$condition = true;
if ($condition) {
    $count = 0;
    if (!isset($_SESSION['loadCounter'])) {
        $_SESSION['loadCounter'] = 0;
    }
    $count = $_SESSION['loadCounter'];
    $filter = 'null';
    if (isset($_GET['filter_var'])) {
        $filter = $_GET['filter_var'];
    }
    $data = $viewDataClass->gallery_view_sort_view($count, $filter);
    if ($data != "Fetching data encounted a problem" || $data != "No records available'" || $data != "Error Occurred") {
        // if (empty($_SESSION['gallery_csrf'])) {
        //     $_SESSION['gallery_csrf'] = bin2hex(random_bytes(32));
        // }
        $decoded = json_decode($data);

        ?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="gal.css">
            <link rel="stylesheet" href="css/izmir.min.css">
            <link rel="stylesheet" href="../css/aos.css">
            <title>Zoe memories</title>
        </head>

        <body>
            <main>

                <div class="hero_page">
                    <div class="container">
                        <div class="slide">
                            <div class="item" style="background-image: url(images/gal/bg6.jpg);">
                                <div class="content">
                                    <div class="name">Events</div>
                                    <div class="des">Check out our event Albums</div>
                                </div>
                            </div>
                            <div class="item" style="background-image: url(images/gal/bg1.jpg);">
                                <div class="content">
                                    <div class="name">Evangelism</div>
                                    <div class="des">Discover some of the outreach events we had as a church</div>
                                </div>
                            </div>
                            <div class="item" style="background-image: url(images/gal/bg5.jpg);">
                                <div class="content">
                                    <div class="name">Sunday School</div>
                                    <div class="des">Discover some of the exquisite images of the children ministry</div>
                                </div>
                            </div>
                            <div class="item" style="background-image: url(images/gal/bg4.jpg);">
                                <div class="content">
                                    <div class="name">Events</div>
                                    <div class="des">Check out our event Albums</div>

                                </div>
                            </div>
                            <div class="item" style="background-image: url(images/gal/bg3.jpg);">
                                <div class="content">
                                    <div class="name">Events</div>
                                    <div class="des">Check out our event Albums</div>

                                </div>
                            </div>
                            <div class="item" style="background-image: url(images/gal/bg2.jpg);">
                                <div class="content">
                                    <div class="name">Events</div>
                                    <div class="des">Check out our event Albums</div>
                                </div>
                            </div>

                        </div>

                        <div class="button">
                            <button class="prev"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M9.586 4l-6.586 6.586a2 2 0 0 0 0 2.828l6.586 6.586a2 2 0 0 0 2.18 .434l.145 -.068a2 2 0 0 0 1.089 -1.78v-2.586h7a2 2 0 0 0 2 -2v-4l-.005 -.15a2 2 0 0 0 -1.995 -1.85l-7 -.001v-2.585a2 2 0 0 0 -3.414 -1.414z" />
                                </svg>

                            </button>
                            <button class="next"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M12.089 3.634a2 2 0 0 0 -1.089 1.78l-.001 2.586h-6.999a2 2 0 0 0 -2 2v4l.005 .15a2 2 0 0 0 1.995 1.85l6.999 -.001l.001 2.587a2 2 0 0 0 3.414 1.414l6.586 -6.586a2 2 0 0 0 0 -2.828l-6.586 -6.586a2 2 0 0 0 -2.18 -.434l-.145 .068z" />
                                </svg></button>
                        </div>
                    </div>
                </div>
                <div class="filter_page">
                    <input hidden id="loadCounter" data-filter="<?php echo $filter; ?>" value="0" />
                    <div class="intro">
                        <h1 class="hello">
                            Zoe Gallery
                        </h1>
                        <form>
                            <div class="filter_icon"></div>
                            <select>
                                <?php
                                foreach ($decoded as $item) {
                                    $Event_name = $item->Event_name;
                                    echo '<option>' . $Event_name . '</option>';
                                }
                                ?>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="grid_content">
                    <ul class="image_class">
                        <li class="card">
                            <figure class="c4-izmir c4-border-cc-3 c4-image-rotate-right swiper-slide card">
                                <img data-src="../API/images_folder/users/pexels-soldiervip-1468379.jpg" alt="" />
                                <figcaption>
                                    <div class="details">
                                        <p>Romano conto</p>
                                        <div class="download">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M10 2l-.15 .005a2 2 0 0 0 -1.85 1.995v6.999l-2.586 .001a2 2 0 0 0 -1.414 3.414l6.586 6.586a2 2 0 0 0 2.828 0l6.586 -6.586a2 2 0 0 0 .434 -2.18l-.068 -.145a2 2 0 0 0 -1.78 -1.089l-2.586 -.001v-6.999a2 2 0 0 0 -2 -2h-4z" />
                                            </svg>

                                        </div>
                                    </div>
                                </figcaption>
                            </figure>
                        </li>
                        <li class="card"><img data-src="../API/images_folder/users/pexels-stefanstefancik-91227.jpg" alt="" />
                        </li>
                        <li class="card"><img data-src="../API/images_folder/users/pexels-stefanstefancik-91227.jpg" alt="" />
                        </li>
                        <li class="card"><img data-src="../API/images_folder/users/pexels-creationhill-1681010.jpg" alt="" />
                        </li>
                        <li class="card"><img data-src="../API/images_folder/users/pexels-khalidgarcia-1144170.jpg" alt="" />
                        </li>
                        <li class="card"><img data-src="../API/images_folder/users/pexels-creationhill-1681010.jpg" alt="" />
                        </li>
                        <li class="card"><img data-src="../API/images_folder/users/pexels-bertellifotografia-573299.jpg"
                                alt="" />
                        </li>
                    </ul>

                </div>
                <div class="loader">
                <div class="loader_wrapper">
                    <div class="load-3">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                </div>
                </div>
                <div class="viewer">
                    <div class="viewer_element">
                        <div class="details">
                            <p>Previewing image</p>
                            <div class="download main">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M10 2l-.15 .005a2 2 0 0 0 -1.85 1.995v6.999l-2.586 .001a2 2 0 0 0 -1.414 3.414l6.586 6.586a2 2 0 0 0 2.828 0l6.586 -6.586a2 2 0 0 0 .434 -2.18l-.068 -.145a2 2 0 0 0 -1.78 -1.089l-2.586 -.001v-6.999a2 2 0 0 0 -2 -2h-4z" />
                                </svg>
                            </div>
                            <div class="times">
                                X
                            </div>
                        </div>
                        <img src="../API/images_folder/users/pexels-soldiervip-1468379.jpg" alt="" />
                    </div>
                </div>
            </main>
            <script src="../js/aos.js"></script>
            <script>
                AOS.init();
                let denial_of_service = false;
                const LoadCounter = document.querySelector('#loadCounter');
                const ImageClassLoader = document.querySelector('.image_class');
                let next = document.querySelector(' .next');
                let prev = document.querySelector('.prev');
                let exitView = document.querySelector('.viewer .times');
                let Viewer = document.querySelector('.viewer');
                let Cards = document.querySelectorAll('.download');
                var Elements = document.querySelectorAll("li img");
                var formSelector = document.querySelector('form select');
                const BodyElement = document.documentElement;
                const Bodyloader = document.querySelector('.loader');
                let DownloadBtn = document.querySelector('.download.main');
                DownloadBtn.addEventListener('click', function () {
                    Image = Viewer.querySelector('img');
                    Anchor = document.createElement('a');
                    Anchor.setAttribute('href', Image.src);
                    Anchor.setAttribute('download', Image.src);
                    Anchor.click();

                    Anchor.delete();
                })
                formSelector.addEventListener('change', function (e) {
                    location.href = 'gallery.php?filter_var=' + formSelector.value;
                })

                window.addEventListener('scroll', async function (e) {
                    console.log(window.scrollY + window.innerHeight, window.scrollY, window.innerHeight, BodyElement.scrollHeight);
                    if ((window.scrollY + window.innerHeight) == BodyElement.scrollHeight) {
                        APIDOCS = "../API/Gallery/data_process.php?APICALL=true&&user=true&&submit=load";
                        //make request
                        try {
                            if(!denial_of_service){
                                Bodyloader.classList.add('active');
                            bodyData = {
                                num: LoadCounter.value,
                                filter: LoadCounter.getAttribute('data-filter')
                            }
                            var fetchRequest = await fetch(APIDOCS, {
                                method: "POST",
                                body: JSON.stringify(bodyData),
                                headers: {
                                    "Content-type": "application/JSON"
                                }
                            });
                            if (fetchRequest.status == 200) {
                                var Response = await fetchRequest.json();
                                if (typeof Response == 'object') {
                                    for (const key in Response) {
                                        const element = Response[key];
                                        template =
                                            `<li class="card"><figure class="c4-izmir c4-border-cc-3 c4-image-rotate-right swiper-slide card">
                                            <img  data-src="../API/Images_folder/gallery/${element['name']}" alt="" />
                                            <figcaption>
                                                <div class="details">
                                                        <p>${element['Event_name']}</p>
                                                        <div class="download">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                            fill="currentColor">
                                                            <path
                                                                d="M10 2l-.15 .005a2 2 0 0 0 -1.85 1.995v6.999l-2.586 .001a2 2 0 0 0 -1.414 3.414l6.586 6.586a2 2 0 0 0 2.828 0l6.586 -6.586a2 2 0 0 0 .434 -2.18l-.068 -.145a2 2 0 0 0 -1.78 -1.089l-2.586 -.001v-6.999a2 2 0 0 0 -2 -2h-4z" />
                                                        </svg>

                                                    </div>
                                                </div>
                                            </figcaption>
                                        </figure></li>`;
                                        ImageClassLoader.innerHTML += template;
                                        Cards = document.querySelectorAll('.card .details .download');

                                    }
                                    Elements = document.querySelectorAll("li img");
                                    Elements.forEach((el) => observer.observe(el));

                                    LoadCounter.value = parseInt(LoadCounter.value) + 1;
                                    console.log(LoadCounter.value);
                                } else {
                                    denial_of_service = true;
                                    console.log(Response);
                                }


                            }
                            Bodyloader.classList.remove('active');
                            }
                           

                        } catch (error) {
                            console.log(error);
                        }
                    }
                })

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            if (!entry.target.hasAttribute('src') && entry.target.hasAttribute('data-src') && !entry.target.classList.contains('srcLoad')) {
                                SectionName = entry.target.getAttribute("data-src");
                                entry.target.setAttribute('src', SectionName);
                                entry.target.classList.add('srcLoad');
                                console.log('here');

                            }

                        }
                    });
                });
                Elements.forEach((el) => observer.observe(el));

                exitView.addEventListener('click', function () {
                    Viewer.classList.remove('active');
                });
                window.addEventListener('click', function (e) {
                    target = e.target;
                    Cards.forEach(element => {
                        if (element == target || element.contains(target)) {
                            ParentElement = element.parentElement.parentElement.parentElement;
                            console.log()
                            Viewer.querySelector('img').setAttribute('src', ParentElement.querySelector('img').getAttribute('src'));
                            Viewer.classList.add('active');
                        }
                    });
                })

                next.addEventListener('click', function () {
                    let items = document.querySelectorAll('.item');
                    document.querySelector('.slide').appendChild(items[0]);
                });
                prev.addEventListener('click', function () {
                    let items = document.querySelectorAll('.item');
                    document.querySelector('.slide').prepend(items[items.length - 1]);
                });

            </script>
        </body>

        </html>
        <?php

    } else {
        echo "<header>We did not find enough data to display for you. Please revisit again. 
    hopefully data will be available for your consumption</header>";
    }
} else {
    echo 'Sorry you do not have access to this page';
}
?>