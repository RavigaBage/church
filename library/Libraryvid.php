<?php
if (isset($_GET['vid_id']) && !empty($_GET['vid_id']) && isset($_GET['dir'])) {
    require '../API/vendor/autoload.php';
    $newDataRequest = new ChurchApi\viewData();
    $dir = $_GET['dir'];
    $stringpass = 'libraryhome.php' . date('Y');
    $hash = hash('sha256', $stringpass);
    $vid_id = $_GET['vid_id'];
    if (hash_equals($dir, hash('sha256', $stringpass))) {
        $data = $newDataRequest->library_viewList_vid($vid_id);

        if ($data != 'No Records available' && $data != "Fetching data encountered an error" && $data != 'Error Occurred') {
            $data = json_decode($data);
            $currentVal = $data->$vid_id;
            if ($currentVal) {
                ?>
                <!DOCTYPE html>
                <html>

                <head>
                    <meta charset="UTF-8">
                    <title>Sermons</title>
                    <link rel="stylesheet" href="index.css" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <script src="js/newplayer.js" defer></script>
                </head>

                <body>
                    <div class="container">
                        <div class="right">
                            <div class="playlist-header">
                                <div class="playlist-content">
                                    <div class="playlist-cover">
                                        <img src="../API/images_folder/library/covers/<?php echo $currentVal->Image; ?>" alt="">
                                    </div>
                                    <div class="playlist-info">
                                        <div class="playlist-title"><?php echo $currentVal->name; ?></div>
                                        <div class="playlist-author">Author - <?php echo $currentVal->Author; ?></div>
                                        <div class="playlist-description"><?php echo $currentVal->category; ?></div>
                                        <div class="playlist-description">Uploaded - <?php echo $currentVal->Date; ?></div>
                                    </div>
                                </div>

                            </div>
                            <div class="playlist-songs-container">
                                <div class="playlist-buttons">
                                    <div class="playlist-buttons-left">
                                        <audio controls="false" src="http://<?php echo $currentVal->source; ?>" hidden>
                                        </audio>
                                        <div class="playlist-buttons-resume-pause">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M6 4v16a1 1 0 0 0 1.524 .852l13 -8a1 1 0 0 0 0 -1.704l-13 -8a1 1 0 0 0 -1.524 .852z" />
                                            </svg>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                <path
                                                    d="M9 4h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z" />
                                                <path
                                                    d="M17 4h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z" />
                                            </svg>
                                        </div>
                                        <div class="playlist-buttons-download">
                                            <img src="assets/Download.svg" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="playlist-songs">
                                    <?php
                                    if ($currentVal->series != 'none') {
                                        $series = json_decode($currentVal->series);

                                        foreach ($series as $item) {
                                            $name = $item->name;
                                            $source = $item->source;
                                            $date = $item->Date;

                                            echo '<div class="song-title series_list">
                                        <div class="song-image">
                                            <img src="../API/images_folder/library/covers/' . $currentVal->Image . '" alt="">
                                        </div>
                                        <div class="active">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 55 80" width="30px" height="30px">
                                                <g transform="matrix(1 0 0 -1 0 80)">
                                                    <rect width="10" height="20" rx="3">
                                                        <animate attributeName="height" begin="0s" dur="4.3s"
                                                            values="20;45;57;80;64;32;66;45;64;23;66;13;64;56;34;34;2;23;76;79;20"
                                                            calcMode="linear" repeatCount="indefinite" />
                                                    </rect>
                                                    <rect x="15" width="10" height="80" rx="3">
                                                        <animate attributeName="height" begin="0s" dur="2s"
                                                            values="80;55;33;5;75;23;73;33;12;14;60;80" calcMode="linear"
                                                            repeatCount="indefinite" />
                                                    </rect>
                                                    <rect x="30" width="10" height="50" rx="3">
                                                        <animate attributeName="height" begin="0s" dur="1.4s"
                                                            values="50;34;78;23;56;23;34;76;80;54;21;50" calcMode="linear"
                                                            repeatCount="indefinite" />
                                                    </rect>
                                                    <rect x="45" width="10" height="30" rx="3">
                                                        <animate attributeName="height" begin="0s" dur="2s"
                                                            values="30;45;13;80;56;72;45;76;34;23;67;30" calcMode="linear"
                                                            repeatCount="indefinite" />
                                                    </rect>
                                                </g>
                                            </svg>
                                        </div>
                                        <div class="song-name-album" >
                                            <div class="song-name">' . $name . '</div>
                                            <div class="song-artist">' . $currentVal->Author . ' <div class="song_duration">
                                                    <img src="assets/Duration.svg" alt="duration">
                                                    <p>' . $date . '</p>
                                                    <div class="origin" hidden>' . $source . '</div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>';
                                        }
                                    }
                                    ?>
                                    <?php
                                    $data = $newDataRequest->library_viewList_vid_similar($vid_id);

                                    if ($data != 'No Records available' && $data != "Fetching data encountered an error" && $data != 'Error Occurred') {
                                        $data = json_decode($data);
                                        echo '<header>You may also like</header>';
                                        foreach ($data as $item) {
                                            $unique_id = $item->UniqueId;
                                            $name = $item->name;
                                            $Author = $item->Author;
                                            $date = $item->date;

                                            echo ' <a href="Libraryvid.php?encrypt=local&&01%8&&data_num=zoevideo&&dir=' . $hash . '&&vid_id=' . $unique_id . '" target="_blank"><div class="song-title">
                                        <div class="song-image">
                                            <img src="../API/images_folder/library/covers/' . $item->Image . '" alt="">
                                        </div>
                                        <div class="song-name-album">
                                            <div class="song-name">' . $name . '</div>
                                            <div class="song-artist">' . $Author . '<div class="song_duration">
                                                    <img src="assets/Duration.svg" alt="duration">
                                                    <p>' . $date . '</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div></a>';

                                        }
                                    }

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="footer-player">
                        <div class="footer-player-middle">
                            <div class="footer-player-middle-buttons">
                                <img src="assets/Shuffle.svg" alt="" class="gray-filtered">
                                <img src="assets/Previous.svg" alt="" class="gray-filtered">
                                <div class="pause-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="currentColor">
                                        <path d="M6 4v16a1 1 0 0 0 1.524 .852l13 -8a1 1 0 0 0 0 -1.704l-13 -8a1 1 0 0 0 -1.524 .852z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9 4h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z" />
                                        <path d="M17 4h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z" />
                                    </svg>
                                </div>
                                <img src="assets/Next.svg" alt="" class="gray-filtered">
                                <img src="assets/Repeat.svg" alt="" class="gray-filtered">
                            </div>
                            <div class="footer-player-middle-slider">
                                <div class="player-time current">1:33</div>
                                <div class="player-slider">
                                    <input class="track" type="range" min="1" max="100" value="0">
                                </div>
                                <div class="player-time total">4:34</div>
                            </div>
                        </div>
                    </div>
                </body>

                </html>
                <?php
            }
        }
    }
}

?>