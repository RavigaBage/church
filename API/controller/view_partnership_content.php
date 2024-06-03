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
    <div class="assets_page">
    <div class="content_pages">
        <div class="content_page_event">
            <div class="records_table">
                <table>
                    <thead>
                        <tr>
                            <th>Partner</th>
                            <th>Partnership type</th>
                            <th>Partnership period</th>
                            <th>Status</th>
                            <th>...</th>
                        </tr>
                    </thead>
                    <tbody>' . $viewDataClass->viewList() . '</tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="event_menu_add">
        <header>Assets form</header>
        <div class="container_event">
            <div class="cate_view">
                <div class="field">
                    <label>Assets name</label>
                    <input type="date" placeholder="" />
                </div>
                <div class="field">
                    <label>Source</label>
                    <input type="date" placeholder="" />
                </div>
            </div>
            <div class="cate_view">
                <div class="field">
                    <label>Date</label>
                    <input type="date" placeholder="" />
                </div>
                <div class="field">
                    <label>Current location</label>
                    <input type="date" placeholder="" />
                </div>
            </div>
            <div class="field">
                <label>Total number</label>
                <input type="number" placeholder="" />
            </div>
            <div class="field">
                <label>Status</label>
                <select>
                    <option value="Public">Select the status of this user</option>
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
            </div>
            <button>Record Asset</button>
        </div>
    </div>

                        <div class="event_menu_add series_version">
                        <header>Individual Partner Records</header>
                        <div class="container_event">
                            <div class="slider_menu_main">
                                <div class="slider_menu">
                                    <div class="menu event">
                                        <div class="item">
                                            <div class="details">
                                                <p>Aunty lucy funeral contribution </p>
                                                <p>data recorded . 25 Mar 24</p>
                                            </div>
                                            
                                        </div>
                                        <div class="item">
                                            <div class="details">
                                                <p>Allocated payment for nehemiah project....</p>
                                                <p>Modified 25 Mar 24</p>
                                            </div>
                                            
                                        </div>
                                        <div class="item">
                                            <div class="details">
                                                <p>Allocated payment for nehemiah project....</p>
                                                <p>You opened . 25 Mar 24</p>
                                            </div>
                                            

                                        </div>
                                    </div>
                                </div>
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