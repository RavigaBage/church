<?php
include ('../../API/partnership/autoloader.php');
$viewDataClass = new viewData();
$val = 1;
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}
?>

<div class="filter flex ">
    <div class="exportFiles filter_content">
        <i class="fas fa-sort"></i>
        <p>Filter</p>
        <div class="filter_content_space">
            <div class="item_passage" filter_value="ministries">
                <p>ministries</p>
            </div>
            <div class="item_passage" filter_value="ministries">
                <p>mission</p>
            </div>
            <div class="item_passage" filter_value="ministries">
                <p>mission</p>
            </div>
            <div class="item_passage" filter_value="ministries">
                <p>mission</p>
            </div>
        </div>
    </div>
    <div class="exportFiles export_content">
        <i class="fas fa-export"></i>
        <p>Export</p>
    </div>
</div>
<div class="assets_page">
    <div class="content_pages">
        <div class="content_page_event">
            <div class="records_table">
                <table>
                    <thead>
                        <tr>
                            <th>Full name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>period</th>
                            <th>Status</th>
                            <th>...</th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php
                        print_r($viewDataClass->viewList());
                        ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <div class="event_menu_add main">
        <form>
            <header>Partnership form</header>
            <p class="error_information"></p>
            <div class="container_event">
                <div class="cate_view">
                    <div class="field">
                        <label>User name</label>
                        <input name="name" type="text" placeholder="" />
                    </div>
                    <div class="field">
                        <label>Amount</label>
                        <input name="amount" type="number" placeholder="" />
                    </div>
                </div>
                <div class="field">
                    <label>Email</label>
                    <input name="email" type="email" placeholder="" />
                </div>

                <div class="cate_view">
                    <div class="field">
                        <label>Partnership type</label>
                        <select name="type">
                            <option>Select a category</option>
                            <option>Church Building</option>
                            <option>Mission support</option>
                            <option>Children ministry</option>
                        </select>
                    </div>
                    <div class="field">
                        <label>Partnership period</label>
                        <input name="period" type="text" placeholder="" />
                    </div>


                </div>
                <div class="field">
                    <label>Partnership date</label>
                    <input name="date" type="date" placeholder="" />
                </div>

                <div class="field">
                    <label>Status</label>
                    <select name="status">
                        <option value="Public">Select the status of this user</option>
                        <option>Active</option>
                        <option>Inconsistency</option>
                        <option>Other reasons</option>
                    </select>
                </div>
                <input name="delete_key" type="text" hidden />
                <button>Record Asset</button>
            </div>
        </form>
    </div>

    <div class="event_menu_add series_version">
        <header>Individual Partner Records</header>
        <div class="container_event">]
            <div class="menu event">

            </div>
        </div>
    </div>


    <div class="add_event" data-menu="event">
        <i>+</i>
        <p>New</p>
    </div>
</div>