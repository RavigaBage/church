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
            <link rel="stylesheet" href="../css/aos.css">
            <title>Zoe memories</title>
        </head>

        <body>
            <main>

                <div class="hero_page">
                    <div class="container">

                        <div class="slide">
                            <div class="item" style="background-image: url(images/p1.jpg);">
                                <div class="content">
                                    <div class="name">' . $name . '</div>
                                    <div class="des">' . $description . '</div>
                                </div>
                            </div>
                            <div class="item" style="background-image: url(images/p1.jpg);">
                                <div class="content">
                                    <div class="name">Switzerland</div>
                                    <div class="des">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, eum!</div>
                                    <button>See More</button>
                                </div>
                            </div>
                            <div class="item" style="background-image: url(images/p2.jpg);">
                                <div class="content">
                                    <div class="name">Finland</div>
                                    <div class="des">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, eum!</div>
                                    <button>See More</button>
                                </div>
                            </div>
                            <div class="item" style="background-image: url(images/p3.jpg);">
                                <div class="content">
                                    <div class="name">Iceland</div>
                                    <div class="des">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, eum!</div>
                                    <button>See More</button>
                                </div>
                            </div>
                            <div class="item" style="background-image: url(images/p2.jpg);">
                                <div class="content">
                                    <div class="name">Australia</div>
                                    <div class="des">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, eum!</div>
                                    <button>See More</button>
                                </div>
                            </div>
                            <div class="item" style="background-image: url(images/p1.jpg);">
                                <div class="content">
                                    <div class="name">Netherland</div>
                                    <div class="des">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, eum!</div>
                                    <button>See More</button>
                                </div>
                            </div>
                            <div class="item" style="background-image: url(images/p3.jpg);">
                                <div class="content">
                                    <div class="name">Ireland</div>
                                    <div class="des">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ab, eum!</div>
                                    <button>See More</button>
                                </div>
                            </div>

                        </div>

                        <div class="button">
                            <button class="prev"><i class="fa-solid fa-arrow-left"></i></button>
                            <button class="next"><i class="fa-solid fa-arrow-right"></i></button>
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
                            <img src="../API/images_folder/users/pexels-soldiervip-1468379.jpg" alt="" />
                            <div class="details">
                                <p>Romano conto</p>
                                <div class="download">
                                    |^
                                </div>
                            </div>
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
                    loading.....
                </div>
                <div class="viewer">
                    <div class="details">
                        <p>Sunday service post 123</p>
                        <div class="download">
                            |v
                        </div>
                        <div class="times">
                            X
                        </div>
                    </div>
                    <img src="../API/images_folder/users/pexels-soldiervip-1468379.jpg" alt="" />

                </div>
            </main>
            <script src="../js/aos.js"></script>
            <script>
                AOS.init();
                const LoadCounter = document.querySelector('#loadCounter');
                const ImageClassLoader = document.querySelector('.image_class');
                let next = document.querySelector(' .next');
                let prev = document.querySelector('.prev');
                let exitView = document.querySelector('.viewer .times');
                let Viewer = document.querySelector('.viewer');
                let Cards = document.querySelectorAll('.card .details .download');
                var Elements = document.querySelectorAll("li img");
                var formSelector = document.querySelector('form select');
                const BodyElement = document.documentElement;
                const Bodyloader = document.querySelector('.loader');
                formSelector.addEventListener('change', function (e) {
                    location.href = 'gallery.php?filter_var=' + formSelector.value;
                })

                window.addEventListener('scroll', async function (e) {
                    if ((window.scrollY + window.innerHeight) == BodyElement.scrollHeight) {
                        APIDOCS = "../API/Gallery/data_process.php?APICALL=true&&user=true&&submit=load";

                        //make request
                        try {
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
                                        template = `<li class="card">
                                                                                                                                                                        <img  data-src="../API/Images_folder/gallery/${element['name']}" alt="" />
                                                                                                                                                                        <div class="details">
                                                                                                                                                                            <p>${element['Event_name']}</p>
                                                                                                                                                                            <div class="download">
                                                                                                                                                                                |^
                                                                                                                                                                            </div>
                                                                                                                                                                        </div>
                                                                                                                                                                    </li>`
                                            ;
                                        ImageClassLoader.innerHTML += template;
                                        Cards = document.querySelectorAll('.card .details .download');

                                    }
                                    Elements = document.querySelectorAll("li img");
                                    Elements.forEach((el) => observer.observe(el));

                                    LoadCounter.value = parseInt(LoadCounter.value) + 1;
                                    console.log(LoadCounter.value);
                                } else {
                                    console.log(Response);
                                }


                            }
                            Bodyloader.classList.add('active');

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
                        if (element == target) {
                            ParentElement = element.parentElement.parentElement;
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