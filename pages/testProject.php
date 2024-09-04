<?php
require '../API/vendor/autoload.php';
$newDataRequest = new AssetProject\viewData();

$data = $newDataRequest->project_showcase();
$projects = $newDataRequest->Project_viewListFilterComplete();
if ($data != "Fetching data encounted a problem" || $data != "No records available'" || $data != "Error Occurred") {
    $decoded = json_decode($data);
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../icons/css/all.css" />
        <link rel="stylesheet" href="projects.css" />
        <title>Zoe projects page</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            .hero_page {
                width: 100%;
                height: 99.5vh;
                position: relative;
                overflow-x: hidden;
                background-position: center right;
                background-repeat: no-repeat;
                background-size: cover;
            }

            .container {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 100%;
                height: 100%;
                background: transparent;
            }

            .container .slide .item {
                width: 200px;
                height: 300px;
                position: absolute;
                top: 50%;
                transform: translate(0, -50%);
                background-position: 50% 50%;
                background-size: cover;
                display: inline-block;
                transition: 0.5s;
                box-shadow: 0px 0px 4px 0px #ddd;
            }

            .slide .item:nth-child(1),
            .slide .item:nth-child(2) {
                top: 0;
                left: 0;
                transform: translate(0, 0);
                width: 100%;
                height: 100%;
            }


            .slide .item:nth-child(3) {
                left: 50%;
            }

            .slide .item:nth-child(4) {
                left: calc(50% + 220px);
            }

            .slide .item:nth-child(5) {
                left: calc(50% + 440px);
            }

            /* here n = 0, 1, 2, 3,... */
            .slide .item:nth-child(n + 6) {
                left: calc(50% + 660px);
                opacity: 0;
            }



            .item .content {
                position: absolute;
                top: 50%;
                left: 100px;
                width: 300px;
                text-align: left;
                color: #eee;
                transform: translate(0, -50%);
                display: none;
            }


            .slide .item:nth-child(2) .content {
                display: block;
            }


            .content .name {
                font-size: 40px;
                text-transform: uppercase;
                font-weight: bold;
                opacity: 0;
                animation: animate 1s ease-in-out 1 forwards;
            }

            .content .des {
                margin-top: 10px;
                margin-bottom: 20px;
                opacity: 0;
                animation: animate 1s ease-in-out 0.3s 1 forwards;
            }

            .content button {
                padding: 10px 20px;
                border: none;
                cursor: pointer;
                opacity: 0;
                animation: animate 1s ease-in-out 0.6s 1 forwards;
            }


            @keyframes animate {
                from {
                    opacity: 0;
                    transform: translate(0, 100px);
                    filter: blur(33px);
                }

                to {
                    opacity: 1;
                    transform: translate(0);
                    filter: blur(0);
                }
            }



            .button {
                width: 100%;
                text-align: center;
                position: absolute;
                bottom: 20px;
            }

            .button button {
                width: 40px;
                height: 35px;
                border-radius: 8px;
                border: none;
                cursor: pointer;
                margin: 0 5px;
                border: 1px solid #000;
                transition: 0.3s;
            }

            .button button:hover {
                background: #ababab;
                color: #fff;
            }

            @media screen and (max-width:800px) {
                .container {
                    width: 100%;
                }

                .item .content {
                    left: 10px;
                }
            }

            @media screen and (max-width:500px) {
                .content .name {
                    font-size: 25px;
                }
            }

            .button {
                bottom: 40px;
            }
        </style>
    </head>

    <body>
        <main>
            <div class="hero_page">
                <div class="container">

                    <div class="slide">
                        <?php
                        foreach ($decoded as $item) {
                            $id = $item->id;
                            $name = $item->name;
                            $Start = $item->Start;
                            $End_date = $item->End_date;
                            $description = $item->description;
                            $Status = $item->Status;
                            $Image = $item->Image;
                            $target = $item->target;
                            $current = $item->current;

                            if (strlen($description) > 72) {
                                $description = substr($description, 0, 72) . '....';
                            }

                            echo ' <div class="item" style="background-image: url("../API/Images_folder/' . $Image . '");">
                            <div class="content">
                                <div class="name">' . $name . '</div>
                                <div class="des">' . $description . '</div>
                            </div>
                        </div>';

                        }
                        ?>
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
            <div class="About">
                <div class="title">
                    <h1>What You Will Discover Here</h1>
                </div>
                <div class="details">
                    <div class="col">
                        <div class="header">
                            <h1>About</h1>
                        </div>
                        <p>Discover a community dedicated to uplifting, supporting, and inspiring individuals through faith,
                            service, and unity. Join us as we grow together</p>
                    </div>
                    <div class="col">
                        <div class="header">
                            <h1>Our Projects</h1>
                        </div>
                        <p>Explore our latest projects aimed at enhancing lives and fostering growth. From community
                            outreach to infrastructural development, we're making a difference.</p>
                        </p>
                    </div>
                    <div class="col">
                        <div class="header">
                            <h1>Get Support</h1>
                        </div>
                        <p>Need assistance? We're here to help! Whether you're seeking spiritual guidance, financial
                            aid, or just someone to talk to, our doors are always open.</p>
                    </div>

                </div>
                <div class="About project_display">
                    <div class="title">
                        <h1>Completed projects</h1>
                    </div>
                    <div class="detail_project">
                        <?php
                        if ($projects != "Fetching data encounted a problem" || $projects != "No records available'" || $projects != "Error Occurred") {
                            $decoded = json_decode($projects);

                            foreach ($decoded as $item) {
                                $id = $item->id;
                                $name = $item->name;

                                echo '<div class="col" id="' . $id . '">
                            <img src="../API/Images_folder/' . $Image . '" alt="" />
                            <h1>' . $name . '</h1>
                        </div>';
                            }
                        }

                        ?>

                    </div>
                </div>
                <div class="About">
                    <div class="title">
                        <h1>Current project</h1>
                    </div>
                    <div class="current_space">
                        <div class="model">
                            <model-viewer id="reveal" loading="eager" camera-controls touch-action="pan-y" auto-rotate
                                class="model-viewer" src="../models/office/office.glb" shadow-intensity="1"
                                alt="A 3D model of a globe">
                            </model-viewer>
                        </div>

                    </div>
                    <div class="detail_project current">
                        <div class="col">
                            <img src="images/p3.jpg" alt="" />
                        </div>
                        <div class="col">
                            <img src="images/p1.jpg" alt="" />
                        </div>
                        <div class="col">
                            <img src="images/p1.jpg" alt="" />
                        </div>
                        <div class="col">
                            <img src="images/p1.jpg" alt="" />
                        </div>
                        <div class="col">
                            <img src="images/p1.jpg" alt="" />
                        </div>
                        <div class="col">
                            <img src="images/p1.jpg" alt="" />
                        </div>
                    </div>
                    <div class="About">
                        <div class="title">
                            <h1>Project Advantage</h1>
                        </div>
                        <div class="details">
                            <div class="col">
                                <div class="header">
                                    <h1>Safety</h1>
                                </div>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestiae fugit sed fugiat
                                    aliquid
                                    laborum voluptatum reprehenderit, quibusdam accusantium quae nisi labore commodi
                                    pariatur
                                    hic,
                                    modi accusamus esse dolorem quod nostrum.</p>
                            </div>
                            <div class="col">
                                <div class="header">
                                    <h1>location</h1>
                                </div>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestiae fugit sed fugiat
                                    aliquid
                                    laborum voluptatum reprehenderit, quibusdam accusantium quae nisi labore commodi
                                    pariatur
                                    hic,
                                    modi accusamus esse dolorem quod nostrum.</p>
                            </div>
                            <div class="col">
                                <div class="header">
                                    <h1>Cost</h1>
                                </div>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestiae fugit sed fugiat
                                    aliquid
                                    laborum voluptatum reprehenderit, quibusdam accusantium quae nisi labore commodi
                                    pariatur
                                    hic,
                                    modi accusamus esse dolorem quod nostrum.</p>
                            </div>
                            <div class="col">
                                <div class="header">
                                    <h1>Users</h1>
                                </div>
                                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Molestiae fugit sed fugiat
                                    aliquid
                                    laborum voluptatum reprehenderit, quibusdam accusantium quae nisi labore commodi
                                    pariatur
                                    hic,
                                    modi accusamus esse dolorem quod nostrum.</p>
                            </div>
                        </div>
                    </div>
                    <div class="About Help">
                        <img src="images/p2.jpg" alt="" />
                        <div class="text_details">
                            <div class="title_text">
                                <h1>You can support this projects</h1>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit perspiciatis facilis
                                tempore?
                                Voluptatem quidem odio, repellendus odit, saepe accusantium sed facere repudiandae harum
                                reiciendis ut eum qui iusto, repellat velit error non in dolorem laboriosam autem excepturi.
                                Expedita cum laboriosam animi facilis nisi veritatis cumque harum delectus omnis, sed
                                aliquam
                                voluptatibus! Neque velit quos ducimus assumenda? Quae corrupti temporibus, ratione eligendi
                                quidem dolorem hic dolor dignissimos quis eveniet. Animi, debitis sunt quos blanditiis, ut
                                dolores fugiat, iure eos rerum dolorum hic?</p>
                            <button>Support</button>
                        </div>
                    </div>
                </div>
        </main>
        <script>
            let next = document.querySelector('.next')
            let prev = document.querySelector('.prev')

            next.addEventListener('click', function () {
                let items = document.querySelectorAll('.item')
                document.querySelector('.slide').appendChild(items[0])
            })

            prev.addEventListener('click', function () {
                let items = document.querySelectorAll('.item')
                document.querySelector('.slide').prepend(items[items.length - 1])
            })
        </script>
    </body>

    </html>
    <?php
} else {
    echo "<header>We did not find enough data to display for you. Please revisit again. 
    hopefully data will be available for your consumption</header>";
}
?>