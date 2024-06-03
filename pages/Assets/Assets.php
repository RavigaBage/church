<?php
include_once ('../../API/Assets&projects/autoloader.php');
$newDataRequest = new viewData();
$val = 1;
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}

?>
<div class="assets_page">
    <div class="content_pages">
        <div class="content_page_event">
            <div class="records_table">
                <table>
                    <thead>
                        <tr>
                            <th>item name</th>
                            <th>source</th>
                            <th>location</th>
                            <th>worth($)</th>
                            <th>Status</th>
                            <th>...</th>
                        </tr>
                    </thead>


                    <tbody>
                        <tr>
                            <td>
                                <div class="details">
                                    <div class="img">
                                        <img src="../images/blog-3.jpg" alt="" />
                                    </div>
                                    <div class="text">
                                        <p>Camiel@gmail.com</p>
                                        <p>20.feb.2024</p>
                                    </div>

                                </div>
                            </td>
                            <td class="td_action">23</td>
                            <td class="td_action">Female</td>
                            <td class="td_action">Cote d`voire</td>

                            <td>
                                <div class="in_btn">
                                    <div></div>Active
                                </div>
                            </td>
                            <td class="option">
                                <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48">
                                    <path
                                        d="M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z" />
                                </svg>
                                <div class="opt_element">
                                    <p class="delete_item">Delete item <i></i></p>
                                    <p class="Update_item"
                                        data-information='{"id":"2","name":"tarry sunday","source":"122","location":"Aug,12,2023","total":"","date":"","status":""}'>
                                        Update item <i></i></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="details">
                                    <div class="img">
                                        <img src="../images/blog-3.jpg" alt="" />
                                    </div>
                                    <div class="text">
                                        <p>Camiel@gmail.com</p>
                                        <p>22.Mar.2024</p>
                                    </div>

                                </div>
                            </td>
                            <td class="td_action">23</td>
                            <td class="td_action">Female</td>
                            <td class="td_action">Cote d`voire</td>

                            <td>
                                <div class="out_btn">
                                    <div></div>in-active
                                </div>
                            </td>
                            <td class="option">
                                <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48">
                                    <path
                                        d="M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z" />
                                </svg>
                                <div class="opt_element">
                                    <p class="delete_item">Delete item <i></i></p>
                                    <p class="update_item">Update item <i></i></p>
                                </div>
                            </td>

                        </tr>
                        <?php
                        print_r($newDataRequest->viewList($val))
                            ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    <div class="event_menu_add">
        <form encryption="multipart/form">
            <header>Assets form</header>
            <div class="container_event">
                <p style="color:crimson;font-size:18px;text-align:center" class="error_information"></p>
                <div class="cate_view_e">
                    <div class="field">
                        <label>Assets name</label>
                        <input name="name" type="text" placeholder="" value="" required />
                    </div>

                    <div class="field">
                        <label>Source</label>
                        <input name="source" type="text" placeholder="" value="" required />
                    </div>

                    <div class="field">
                        <label class="input_date">Date</label>
                        <input name="date" type="date" placeholder="" value="" required />
                    </div>
                </div>
                <div class="cate_view_e">
                    <div class="field">
                        <label>Total number</label>
                        <input name="total" type="number" placeholder="" value="" required />
                    </div>
                    <div class="field">
                        <label>Current location</label>
                        <input name="location" type="text" placeholder="" value="" required />
                    </div>
                    <div class="field">
                        <label>value</label>
                        <input name="value" type="text" placeholder="" value="" required />
                    </div>
                </div>

                <div class="cate_view">
                    <div class="field">
                        <label>Select file</label>
                        <input name="imageFile" type="file" value="" />
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
                </div>
                <div class="field_e">
                    <label>Description</label>
                    <textarea name="description">..description this valuable...</textarea>
                </div>

                <input name="delete_key" type="text" value="" hidden />
                <button>Record Asset</button>
            </div>
        </form>
    </div>

    <div class="add_event" data-menu="event">
        <i>+</i>
        <p>New</p>
    </div>
</div>

<div class="page_sys">
    <?php
    $total = $newDataRequest->ProjectsPages();
    ?>
    <header>
        <?php
        if (($total / 6) > 1) {
            echo 'Pages:';
        }
        ?>
        <div class="pages">
            <?php
            $total = $newDataRequest->AssetPages();
            $loop = 0;
            if (($total / 6) > 1) {
                if (($total / 6) > 6) {
                    $loop = 6;
                } else {
                    $loop = ($total / 6);
                }
                for ($i = 0; $i < $loop; $i++) {
                    $class = "";
                    if ($i == $val - 1) {
                        $class = 'active';
                    }
                    echo '<div class="' . $class . '">' . ($i + 1) . '</div>';
                }
                if ($loop == 6) {
                    echo '<span>......</span><div>' . $total . '</div>';
                }
            }
            ?>
        </div>
    </header>
</div>