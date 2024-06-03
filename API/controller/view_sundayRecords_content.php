<?php
include ('../partnership/autoloader.php');
include ('user_check.php');
$viewDataClass = new viewData();

function Pagenation($viewDataClass)
{
    $pagesTotal = $viewDataClass->AssetPages();
    if ($pagesTotal % 2 != 0) {
        $pagesTotal += 1;
    }

    $pagesNumber = round($pagesTotal / 50);
    $pages = '';
    for ($i = 0; $i < intVal($pagesNumber); $i++) {
        $pages .= '<div class="page" data-num="' . $i . '">' . ($i + 1) . '</div>';
    }
    return $pages;
}
$pageData =
    '
    <div class="content_body">
                <div class="profile_main">
                    <header>SUNDAY SERVICE PROGRAMME DATA</header>
                    <div class="grid_sx tithebook">
                        <div class="profile">
                            <div class="tithe_list ancc_list">
                            ' . $viewDataClass->viewList() . '
                            </div>
                        </div>
                    </div>
                </div>
                <div class="event_menu_add active">
                <header>Add to records (2024)</header>
                <div class="flex title">
                    <div class="item">
                        <p><span>23</span> births</p>
                    </div>
                    <div class="item">
                        <p><span>3</span> Deaths</p>
                    </div>
                    <div class="item">
                        <p><span>12</span> water baptism</p>
                    </div>
                    <div class="item">
                        <p><span>11</span> fire baptism</p>
                    </div>
                    <div class="item">
                        <p><span>23</span> births</p>
                    </div>
                </div>
                <div class="container_event">
                    <div class="field">
                        <label>Select category</label>
                        <select>
                            <option>new Birth</option>
                            <option>death</option>
                            <option>water_baptism</option>
                            <option>fire_baptism</option>
                        </select>
                    </div>
                    <div class="field_e">
                        <label>Details</label>
                        <textarea></textarea>
                    </div>
                    <div class="field">
                        <button>submit data</button>
                    </div>

                </div>
            </div>


            <div class="add_event" data-menu="event">
                <i>+</i>
                <p>New</p>
            </div>
    </div>
';
echo $pageData;
?>