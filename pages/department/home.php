<?php
include ('../../API/ministriesData & theme/autoloader.php');
$viewDataClass = new viewData();
$val = 1;
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}
?>

<div class="navigation">
    <div class="item">
        <p>Name <i></i></p>
    </div>
</div>

<div class="menu event">
    <?php
    print_r($viewDataClass->viewList());
    ?>
</div>


<div class="event_menu_add">
    <form>
        <header>Records book for ministries</header>
        <p class="error_information" style="color:crimson;text-align:center;"></p>
        <div class="container_event">
            <div class="field">
                <label>Name</label>
                <input name="name" required placeholder="Add name" />
            </div>
            <div class="cate_view">
                <div class="field">
                    <label>manager</label>
                    <input name="manager" required type="text" value="">
                </div>
                <div class="field">
                    <label>total participants</label>
                    <input name="members" required type="text" value="">
                </div>
            </div>
            <div class="field">
                <label>status</label>
                <select name="status" required>
                    <option>select</option>
                    <option>active</option>
                    <option>inactive</option>
                    <option>in progress</option>
                </select>
            </div>

            <div class="field">
                <label>record date</label>
                <input name="date" type="date" required value="">
            </div>

            <div class="field_e">
                <label>record description</label>
                <textarea name="about" required></textarea>
            </div>
            <input name="delete_key" type="text" hidden />
            <button>Add record</button>
    </form>
</div>
</div>

<div class="add_event" data-menu="event">
    <i>+</i>
    <p>New</p>
</div>