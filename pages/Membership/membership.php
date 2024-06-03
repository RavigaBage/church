<?php
include ('../../API/membership/autoloader.php');
$viewDataClass = new viewData();
$val = 1;
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}
?>
<div class="filter_wrapper">
    <header>Membership data</header>
    <div style="height:40px;" class="flex">
        <div class="filter">
            <i class="fas fa-filter"></i>
            <p>Filter</p>
        </div>
        <div class="ux_search_bar">
            <button id="searchBtn"><i class="fas fa-search" aria-hidden></i></button>
            <input type="search_data" type="search" id="searchInput" name="search" placeholder="...search here" />
        </div>
    </div>
</div>



<div class="content_pages">
    <div class="content_page_event">
        <div class="membership_table">
            <table>
                <thead>
                    <tr>
                        <th>username</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Location</th>
                        <th>Baptism</th>
                        <th>Occupation</th>
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
                                    <p>20/03/2024</p>
                                </div>

                            </div>
                        </td>
                        <td class="td_action">23</td>
                        <td class="td_action">Female</td>

                        <td class="td_action">24 st Kasoa, Accra</td>
                        <td class="td_action">Water,Fire</td>
                        <td class="td_action">Farmer</td>

                        <td>
                            <div class="in_btn">
                                <div></div>Inactive
                            </div>
                        </td>
                        <td class="option">
                            <svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 -960 960 960" width="48">
                                <path
                                    d="M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z" />
                            </svg>
                            <div class="opt_element">
                                <p>Delete item <i></i></p>
                                <p class="Update_item"
                                    data-information='{"id":2,"Oname":"FDBbank","Fname":"","birth":"122","occupation":"","gender":"","contact":"Aug,12,2023","nationality":"more","location":"more","baptism":"more","status":"(+234)-220 2323 123","position":"more"}'>
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
                                    <p>20/03/2024</p>
                                </div>

                            </div>
                        </td>
                        <td class="td_action">23</td>
                        <td class="td_action">Female</td>

                        <td class="td_action">24 st Kasoa, Accra</td>
                        <td class="td_action">Water,Fire</td>
                        <td class="td_action">plummer </td>

                        <td>
                            <div class="out_btn">
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
                                <p class="update_item">Update item <i></i></p>
                            </div>
                        </td>

                    </tr>
                    <?php
                    print_r($viewDataClass->viewList($val));
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>
<div class="add_event" data-menu="event">
    <i>+</i>
    <p>New</p>
</div>
<div class="event_menu_add">
    <form>
        <header>Membership form</header>
        <p class="error_information"></p>
        <div class="container_event">
            <div class="cate_view">
                <div class="field">
                    <label>First name</label>
                    <input name="Fname" type="text" placeholder="" required />
                </div>
                <div class="field">
                    <label>Other name</label>
                    <input name="Oname" type="text" placeholder="" required />
                </div>

            </div>

            <div class="cate_view_e">
                <div class="field">
                    <label>Birth</label>
                    <input name="birth" type="date" placeholder="" required />
                </div>
                <div class="field">
                    <label>Gender</label>
                    <input name="gender" type="text" placeholder="" required />
                </div>
                <div class="field">
                    <label>contact</label>
                    <input name="contact" type="text" placeholder="" required />
                </div>
            </div>
            <div class="cate_view">
                <div class="field">
                    <label>Occupation</label>
                    <input name="occupation" type="text" placeholder="" required />
                </div>
                <div class="field">
                    <label>Location (city,town and street)</label>
                    <input name="location" type="text" placeholder="" required />
                </div>
            </div>
            <div class="field">
                <label>Status</label>
                <select name="status" required>
                    <option value="Public">Select the status of this user</option>
                    <option>Active</option>
                    <option>Inconsistency</option>
                    <option>Other reasons</option>
                </select>
            </div>
            <div class="cate_view">
                <div class="field">
                    <label>Baptism(specify both if available ..eg water & fire)</label>
                    <input name="baptism" type="text" placeholder="" required />
                </div>
                <div class="field">
                    <label>Position</label>
                    <input name="position" type="text" placeholder="" required />
                </div>
            </div>
            <div class="field">
                <label>Profile Image</label>
                <input name="imageFile" type="file" />
            </div>
            <input name="delete_key" type="text" value="" hidden />
            <button>create Activity</button>
        </div>
    </form>

</div>