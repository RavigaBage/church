<?php
require '../API/vendor/autoload.php';
$newDataRequest = new ChurchApi\viewData();
$stringpass = 'libraryhome.php' . date('Y');
$hash = hash('sha256', $stringpass)
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/library_home.css" />
    <link rel="stylesheet" href="css/font.css" />
    <script src="js/nav.js" defer></script>
    <title>Zoe-library</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="main">
                <nav>
                    <div class="navigation">
                        <form action="librarysearch.php" method="POST">
                            <div class="menu">
                                <div class="search">

                                    <input type="text" name="vid_key" placeholder="Word,track or podcast" />
                                    <button class="searchbutton">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path
                                                d="M21.71,20.29,18,16.61A9,9,0,1,0,16.61,18l3.68,3.68a1,1,0,0,0,1.42,0A1,1,0,0,0,21.71,20.29ZM11,18a7,7,0,1,1,7-7A7,7,0,0,1,11,18Z">
                                            </path>
                                        </svg>
                                    </button>

                                </div>
                        </form>
                        <div class="profile">
                            <div class="profile_details">
                                <img src="images/1.jpg" alt="img" />
                            </div>
                        </div>

                    </div>
            </div>
            </nav>
            <section>
                <?php
                $data = $newDataRequest->library_viewList();

                if ($data != 'No Records available' && $data != "Fetching data encountered an error" && $data != 'Error Occurred') {
                    $data = json_decode($data);
                    echo '<div class="title">
                                     <h1>RECENT SERMONS</h1>
                                 </div>
                                 <div class="podcast">';
                    foreach ($data as $item) {
                        $unique_id = $item->UniqueId;
                        $name = $item->name;
                        $Author = $item->Author;
                        $source = $item->source;


                        echo '<a href="Libraryvid.php?encrypt=local&&01%8&&data_num=zoevideo&&dir=' . $hash . '&&vid_id=' . $unique_id . '" target="_blank"><div class="item">
                        <div class="image">
                            <img src="../API/images_folder/library/covers/' . $item->Image . '" alt="item" />
                            <div class="viewers">
                                <p>' . $Author . '</p>
                            </div>
                        </div>

                        <div class="details">
                            <h1>' . $name . '</h1>
                        </div>
                    </div></a>';

                    }
                    echo '</div>';
                }

                ?>
            </section>
            <section>
                <?php
                $data = $newDataRequest->library_viewList();

                if ($data != 'No Records available' && $data != "Fetching data encountered an error" && $data != 'Error Occurred') {
                    $data = json_decode($data);
                    echo '<div class="title">
                                     <h1>Explore our Collection</h1>
                                 </div>
                                 <div class="podcast">';
                    foreach ($data as $item) {
                        $unique_id = $item->UniqueId;
                        $name = $item->name;
                        $Author = $item->Author;
                        $source = $item->source;

                        echo ' <div class="item" id=' . $unique_id . '>
                        <div class="image">
                            <img src="' . $source . '" alt="item" />
                            <div class="viewers">
                                <p>' . $Author . '</p>
                            </div>
                        </div>

                        <div class="details">
                            <h1>' . $name . '</h1>
                        </div>
                    </div>';

                    }
                    echo '</div>';
                }

                ?>
            </section>
            <section>
                <div class="title">
                    <h1>Repentance</h1>
                    <button>More..</button>
                </div>
                <div class="podcast">
                    <div class="item">
                        <div class="image">
                            <img src="images/2.jpg" alt="item" />
                            <div class="viewers">
                                <p>4K views</p>
                            </div>
                        </div>

                        <div class="details">
                            <h1>Mayhem Uprising</h1>
                        </div>
                    </div>
                    <div class="item">
                        <div class="image">
                            <img src="images/1.jpg" alt="item" />
                            <div class="viewers">
                                <p>4.4K views</p>
                            </div>
                        </div>
                        <div class="details">
                            <h1>Insight Jordan peterson</h1>
                        </div>
                    </div>
                    <div class="item">
                        <div class="image">
                            <img src="images/3.jpg" alt="item" />
                            <div class="viewers">
                                <p>4K views</p>
                            </div>
                        </div>
                        <div class="details">
                            <h1>If it aint funny it aint us</h1>
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="title">
                    <h1>FAITH</h1>
                    <button>More..</button>
                </div>
                <div class="podcast">
                    <div class="item">
                        <div class="image">
                            <img src="images/2.jpg" alt="item" />
                            <div class="viewers">
                                <p>4K views</p>
                            </div>
                        </div>

                        <div class="details">
                            <h1>Mayhem Uprising</h1>
                        </div>
                    </div>
                    <div class="item">
                        <div class="image">
                            <img src="images/1.jpg" alt="item" />
                            <div class="viewers">
                                <p>4.4K views</p>
                            </div>
                        </div>
                        <div class="details">
                            <h1>Insight Jordan peterson</h1>
                        </div>
                    </div>
                    <div class="item">
                        <div class="image">
                            <img src="images/3.jpg" alt="item" />
                            <div class="viewers">
                                <p>4K views</p>
                            </div>
                        </div>
                        <div class="details">
                            <h1>If it aint funny it aint us</h1>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        </div>
        </div>
    </main>
</body>

</html>