<?php
include ('../finance/autoloader.php');
include ('user_check.php');
$viewDataClass = new viewData();


$pageData =
    '
    <div class="navigation">
    <div class="item">
        <p>Name <i class="fas fa-arrow-down"></i></p>
    </div>
    <div class="list">
        <div class="item">
            <p><i class="fas fa-"></i>Year </p>
        </div>
        <div class="item">
            <p><i class="fas fa-edit"></i>Date modified </p>
        </div>
        <div class="item">
            <p><i class="fas fa-clock"></i>Date created </p>
        </div>
        <div class="item">
            <p><i class="fas fa-arrow-up"></i>Ascending </p>
        </div>
        <div class="item">
            <p><i class="fas fa-arrow-down"></i>Descending </p>
        </div>
    </div>
</div>
<div class="slider_menu_main">
                    <div class="slider_menu">
                        <div class="menu event active">
                            <header>ContributionList</header>
                            ' . $viewDataClass->ContributionList() . '
                        </div>
                        <div class="menu account">
                          ' . $viewDataClass->ListData() . '
                        </div>
                    </div>
</div>
<div class="event_menu_add ">
                    <header>New Activity</header>
                    <div class="container_event">
                        <div class="field">
                            <label>Activity Name</label>
                            <input type="text" placeholder="" />
                        </div>
                        <div class="cate_view">
                            <div class="field">
                                <label>Allotment</label>
                                <input type="number" placeholder="" />
                            </div>
                            <div class="field">
                                <label>Activity date</label>
                                <input type="date" placeholder="" />
                            </div>
                        </div>
                        <div class="field_e">
                            <label>Activity description</label>
                            <textarea></textarea>
                        </div>
                        <button>create Activity</button>
                    </div>
</div>
<div class="event_menu_add main">
                    <header>New Activity</header>
                    <div class="container_event">
                        <div class="cate_view">
                            <div class="field">
                                <label>Account</label>
                                <select>
                                    <option>Select Account</option>
                                </select>
                            </div>
                            <div class="field">
                                <label>category</label>
                                <input type="text" placeholder="" />
                            </div>
                        </div>
                        <div class="cate_view">
                            <div class="field">
                                <label>Amount</label>
                                <input type="text" placeholder="" />
                            </div>
                            <div class="field">
                                <label>Activity date</label>
                                <input type="date" placeholder="" />
                            </div>
                        </div>
                        <div class="field_e">
                            <label>Activity description</label>
                            <textarea></textarea>
                        </div>
                        <button>create Activity</button>
                    </div>
</div>
<div class="add_event" data-menu="event">
                    <i>+</i>
                    <p>New</p>
</div>
';
echo $pageData;
?>