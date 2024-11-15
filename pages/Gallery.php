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
    if (is_object(json_decode($data))) {
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
            <script src="../js/jquery-3.4.1.min.js"></script>
            <title>Zoe memories</title>
        </head>

        <body>
            <main>

                <div class="hero_page">
                    <div class="container">
                        <div class="panel"
                            style="background-image: url(../images/gallery_default/straw-transport-7948338_640.jpg);">
                            <h1>Missionary</h1>
                        </div>
                        <div class="panel" style="background-image: url(../images/gallery_default/evan.jpg);">
                            <h1>Evangelism</h1>
                        </div>
                        <div class="panel  active" style="background-image: url(../images/gallery_default/happy.jpg);">
                            <h1>Happy times</h1>
                        </div>
                        <div class="panel" style="background-image: url(../images/gallery_default/sad.jpg);">
                            <h1>Sad moments</h1>
                        </div>
                        <div class="panel" style="background-image: url(../images/gallery_default/fello.jpg);">
                            <h1>Fellowship</h1>
                        </div>
                    </div>
                </div>
                <div class="filter_page">
                    <input hidden id="loadCounter" data-filter="<?php echo $filter; ?>" value=0 />
                    <div class="intro">
                        <h1 class="hello">
                            Zoe Gallery
                        </h1>
                        <form>
                            <div class="filter_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="currentColor">
                                    <path
                                        d="M8.813 11.612c.457 -.38 .918 -.38 1.386 .011l.108 .098l4.986 4.986l.094 .083a1 1 0 0 0 1.403 -1.403l-.083 -.094l-1.292 -1.293l.292 -.293l.106 -.095c.457 -.38 .918 -.38 1.386 .011l.108 .098l4.674 4.675a4 4 0 0 1 -3.775 3.599l-.206 .005h-12a4 4 0 0 1 -3.98 -3.603l6.687 -6.69l.106 -.095zm9.187 -9.612a4 4 0 0 1 3.995 3.8l.005 .2v9.585l-3.293 -3.292l-.15 -.137c-1.256 -1.095 -2.85 -1.097 -4.096 -.017l-.154 .14l-.307 .306l-2.293 -2.292l-.15 -.137c-1.256 -1.095 -2.85 -1.097 -4.096 -.017l-.154 .14l-5.307 5.306v-9.585a4 4 0 0 1 3.8 -3.995l.2 -.005h12zm-2.99 5l-.127 .007a1 1 0 0 0 0 1.986l.117 .007l.127 -.007a1 1 0 0 0 0 -1.986l-.117 -.007z" />
                                </svg>

                            </div>
                            <select value=<?php if ($filter != 'null') {
                                echo $filter;
                            } ?>>
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
                    <div class="grid_content_box">
                        <ul class="image_class"></ul>
                    </div>
                    <div class="grid_content_box">
                        <ul class="image_class"></ul>
                    </div>
                    <div class="grid_content_box">
                        <ul class="image_class"></ul>
                    </div>
                    <div class="grid_content_box">
                        <ul class="image_class"></ul>
                    </div>

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
                $(document).ready(function () {
                    AOS.init();
                    Color_ranges = ['#523b23', '#261e16', '#0083B0']
                    let denial_of_service = false;
                    const LoadCounter = document.querySelector('#loadCounter');
                    const ImageClassLoader = document.querySelector('.image_class');
                    let exitView = document.querySelector('.viewer .times');
                    let Viewer = document.querySelector('.viewer');
                    let Cards = document.querySelectorAll('.download');
                    var Elements = document.querySelectorAll("figure");
                    var formSelector = document.querySelector('form select');
                    const BodyElement = document.documentElement;
                    const Bodyloader = document.querySelector('.loader');
                    let DownloadBtn = document.querySelector('.download.main');
                    const HomeData = <?php print_r($data); ?>;
                    renderHomeImages(HomeData)
                    function renderHomeImages(Obj) {
                        console.log(Obj)
                        const Containers = document.querySelectorAll('.grid_content_box');
                        counter = 0;
                        if (typeof Obj == 'object') {
                            ObjectData = Obj;
                            ObjectKeys = Object.keys(ObjectData);
                            shuffedData = ShuffleKeys(ObjectKeys);
                            shuffedData.forEach(element => {
                                Images = Obj[element];
                                radmi = ShuffleKeys(Color_ranges)[0];
                                Containers[counter].querySelector('ul').innerHTML +=
                                    `<li class="card">
                                        <figure class="c4-izmir c4-border-cc-3 c4-image-rotate-right swiper-slide card" style="--secondary-color:${radmi}; --primary-color:${radmi}">
                                                            <img data-src="../API/Images_folder/gallery/${Images['name']}" alt="" />
                                                            <figcaption >
                                                                <div class="details">
                                                                        <p>${Images['Event_name']}</p>
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
                                counter++;
                                if (counter > 3) {
                                    counter = 0;
                                }

                            });
                        }
                    }
                    function ShuffleKeys(array) {
                        returnArray = [];
                        for (let i = array.length - 1; i >= 0; i--) {
                            const picker = Math.floor(Math.random() * (i + 1));
                            picked = [array[i]]
                            returnArray.push(array[picker])
                        }

                        return returnArray;
                    }
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
                        if ((Math.ceil(window.scrollY + window.innerHeight)) == BodyElement.scrollHeight) {
                            APIDOCS = "../API/Gallery/data_process.php?APICALL=true&&user=true&&submit=load";
                            //make request
                            try {
                                if (!denial_of_service) {
                                    Bodyloader.classList.add('active');
                                    bodyData = {
                                        num: parseInt(LoadCounter.value),
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
                                            renderHomeImages(Response)
                                            Cards = document.querySelectorAll('.card .details .download');
                                            Elements = document.querySelectorAll("li img");
                                            Elements.forEach((el) => observer.observe(el));

                                            LoadCounter.value = parseInt(LoadCounter.value) + 1;
                                        } else {
                                            denial_of_service = true;
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
                                console.log(entry.target);
                                entryImage = entry.target;
                                if (entryImage) {
                                    if (!entryImage.hasAttribute('src') && entryImage.hasAttribute('data-src') && !entryImage.classList.contains('srcLoad')) {
                                        SectionName = entryImage.getAttribute("data-src");
                                        entryImage.setAttribute('src', SectionName);
                                        entryImage.classList.add('srcLoad');
                                    }
                                }


                            }
                        });
                    });

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
                    Elements.forEach((el) => observer.observe(el));

                    const panels = document.querySelectorAll(".panel");

                    panels.forEach((panel) => {
                        panel.addEventListener("click", () => {
                            removeActiveClasses();
                            panel.classList.add("active");
                        });
                    });

                    function removeActiveClasses() {
                        panels.forEach((panel) => {
                            panel.classList.remove("active");
                        })
                    }
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