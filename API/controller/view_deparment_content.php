<?php
include ('../ministriesData & theme/autoloader.php');
include ('user_check.php');
$viewDataClass = new viewData();


$pageData =
    '
    <div class="navigation">
    <div class="item">
        <p>Name <i></i></p>
    </div>
</div>
<div class="slider_menu_main">
    <div class="slider_menu">
        <div class="menu event">
        ' . $viewDataClass->viewList() . '
        </div>
    </div>
</div>
<div class="event_menu_add">
    <header>Records book for ministries</header>
    <div class="container_event">
        <div class="field">
            <label>Select Ministry</label>
            <select>
                <option value="">select</option>
            </select>
        </div>
        <div class="cate_view">
            <div class="field">
                <label>category</label>
                <select>
                    <option value="">select</option>
                </select>
            </div>
            <div class="field">
                <label>record date</label>
                <input type="date" value="">
            </div>
        </div>
        <div class="field_e">
            <label>record description</label>
            <textarea></textarea>
        </div>
        <button>Add record</button>
    </div>
</div>
<div class="add_event" data-menu="event">
    <i>+</i>
    <p>New</p>
</div>

';
echo $pageData;
?>