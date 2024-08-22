<?php
include_once ('../../API/finance/autoloader.php');
$newDataRequest = new viewData();
if (isset($_GET['data_page'])) {
    $num = $_GET['data_page'];
} else {
    $num = 1;
}
?>

<div class="filter_wrapper relative">
    <div style="height:40px;width:100%" class="flex">
        <div class="direction flex">
            <p>Dashboard</p>
            <span> - </span>
            <p>membership</p>
            <span> - </span>
            <p>filter(20years)</p>
        </div>
        <div class="options flex opt_left">
            <div class="item_opt flex">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#5f6368">
                    <path
                        d="M720-80q-50 0-85-35t-35-85q0-7 1-14.5t3-13.5L322-392q-17 15-38 23.5t-44 8.5q-50 0-85-35t-35-85q0-50 35-85t85-35q23 0 44 8.5t38 23.5l282-164q-2-6-3-13.5t-1-14.5q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35q-23 0-44-8.5T638-672L356-508q2 6 3 13.5t1 14.5q0 7-1 14.5t-3 13.5l282 164q17-15 38-23.5t44-8.5q50 0 85 35t35 85q0 50-35 85t-85 35Zm0-640q17 0 28.5-11.5T760-760q0-17-11.5-28.5T720-800q-17 0-28.5 11.5T680-760q0 17 11.5 28.5T720-720ZM240-440q17 0 28.5-11.5T280-480q0-17-11.5-28.5T240-520q-17 0-28.5 11.5T200-480q0 17 11.5 28.5T240-440Zm480 280q17 0 28.5-11.5T760-200q0-17-11.5-28.5T720-240q-17 0-28.5 11.5T680-200q0 17 11.5 28.5T720-160Zm0-600ZM240-480Zm480 280Z" />
                </svg>
                <p>Share</p>
            </div>
            <div class="item_opt flex">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#5f6368">
                    <path
                        d="M640-640v-120H320v120h-80v-200h480v200h-80Zm-480 80h640-640Zm560 100q17 0 28.5-11.5T760-500q0-17-11.5-28.5T720-540q-17 0-28.5 11.5T680-500q0 17 11.5 28.5T720-460Zm-80 260v-160H320v160h320Zm80 80H240v-160H80v-240q0-51 35-85.5t85-34.5h560q51 0 85.5 34.5T880-520v240H720v160Zm80-240v-160q0-17-11.5-28.5T760-560H200q-17 0-28.5 11.5T160-520v160h80v-80h480v80h80Z" />
                </svg>
                <p>Print</p>
            </div>

            <div class="item_opt flex">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                    fill="#5f6368">
                    <path
                        d="M480-320 280-520l56-58 104 104v-326h80v326l104-104 56 58-200 200ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z" />
                </svg>
                <p>Export</p>
            </div>
        </div>
    </div>
</div>

<div class="content_pages">
    <div class="content_page_event">

        <div class="add_event">
            <i>+</i>
            <p>New</p>
        </div>


        <div class="transaction_search_menu flex">
            <div class="filter_option">
                <p>Category</p>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                    <path d="M400-240v-80h160v80H400ZM240-440v-80h480v80H240ZM120-640v-80h720v80H120Z" />
                </svg>
                <select class='select' name="catfilter">
                    <option value="expenses">Expenses</option>
                    <option value="income">Income</option>
                    <option value="saving">deposit</option>
                </select>
            </div>
            <div class="filter_option">
                <p>Year</p>
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px">
                    <path d="M400-240v-80h160v80H400ZM240-440v-80h480v80H240ZM120-640v-80h720v80H120Z" />
                </svg>

                <select class='select' name="yearfilter">
                    <option>2024</option>
                    <option>2023</option>
                </select>
            </div>
            <button class="List_filter">Filter</button>
        </div>

        <div class="records_table ">
            <table>
                <thead>
                    <tr>
                        <th>Detail</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Record</th>
                        <th>Amount</th>
                        <th>...</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = json_decode($newDataRequest->BudgeCategoryList());

                    foreach ($data as $item) {
                        $category = $item->category;
                        $type = $item->type;
                        $details = $item->details;
                        $date = $item->date;
                        $year = $item->year;
                        $month = $item->month;
                        $amount = $item->amount;
                        $recorded_by = $item->recorded_by;
                        $unique_id = $item->id;
                        $ObjExport = $item->obj;

                        echo " <tr class='" . $category . "'>
                        <td title='" . $details . "'>
                            <p>hover to view details</p>
                        <td>
                            <p>" . $date . "</p>
                        </td>
                        <td>
                            <p>" . $type . "</p>
                        </td>
                        <td>
                            <p>" . $recorded_by . "</p>
                        </td>
                        </td>
                        <td>" . $amount . "</td>
                        <td class='delete option'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='30'
                                viewBox='0 -960 960 960' width='48'>
                                <path
                                    d='M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z' />
                            </svg>
                            <div class='opt_element'>
                                <p delete_item='" . $unique_id . "' class='delete_item'>Delete item <i></i></p>
                                <p Update_item='" . $unique_id . "' class='Update_item' class='' data-information='" . $ObjExport . "'>Update item <i></i></p>
                            </div>
                        </td>
                    </tr>";
                    }

                    ?>
                    <tr class="income">
                        <td title="Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui
                                                dolorem blanditiis eos.">
                            <p>hover to view details</p>
                        <td>
                            <p>24 Aug</p>
                        </td>
                        <td>
                            <p>Housing</p>
                        </td>
                        <td>
                            <p>Income</p>
                        </td>
                        </td>
                        <td>$998.38</td>
                        <td class="option">
                            <svg xmlns="http://www.w3.org/2000/svg" height="30" viewBox="0 -960 960 960" width="48">
                                <path
                                    d="M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z" />
                            </svg>
                            <div class="opt_element">
                                <p class="delete_item">Delete item <i></i></p>
                                <p class="Update_item" class=""
                                    data-information='{"id":2,"Category":"FDBbank","Type":"","Amount":"122","Date":"Aug,12,2023","Details":"more"}'>
                                    Update item <i></i></p>
                            </div>
                        </td>



                    </tr>
                    <tr class="expenses">
                        <td title="Lorem ipsum dolor sit, amet consectetur adipisicing elit. Corrupti
                                                nostrum fugiat in.">
                            <p>hover to view details</p>
                        </td>

                        <td>
                            <p>24 Aug</p>
                        </td>
                        <td>
                            <p>salary</p>
                        </td>
                        <td>
                            <p>Income</p>
                        </td>
                        <td>$938</td>

                        <td class="option">
                            <svg xmlns="http://www.w3.org/2000/svg" height="30" viewBox="0 -960 960 960" width="48">
                                <path
                                    d="M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z" />
                            </svg>
                            <div class="opt_element">
                                <p class="delete_item">Delete item <i></i></p>
                                <p class="update_item">Update item <i></i></p>
                            </div>
                        </td>

                    </tr>
                    <tr class="record">
                        <td>
                            <p>Income</p>
                        </td>
                        <td>
                            <p>24 Aug</p>
                        </td>
                        <td>Clothing</td>
                        <td>221</td>
                        <td>$998.38</td>

                        <td class="option">
                            <svg xmlns="http://www.w3.org/2000/svg" height="30" viewBox="0 -960 960 960" width="48">
                                <path
                                    d="M479.858-160Q460-160 446-174.142q-14-14.141-14-34Q432-228 446.142-242q14.141-14 34-14Q500-256 514-241.858q14 14.141 14 34Q528-188 513.858-174q-14.141 14-34 14Zm0-272Q460-432 446-446.142q-14-14.141-14-34Q432-500 446.142-514q14.141-14 34-14Q500-528 514-513.858q14 14.141 14 34Q528-460 513.858-446q-14.141 14-34 14Zm0-272Q460-704 446-718.142q-14-14.141-14-34Q432-772 446.142-786q14.141-14 34-14Q500-800 514-785.858q14 14.141 14 34Q528-732 513.858-718q-14.141 14-34 14Z" />
                            </svg>
                            <div class="opt_element">
                                <p class="delete_item">Delete item <i></i></p>
                                <p class="update_item">Update item <i></i></p>
                            </div>
                        </td>

                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>
</div>
<div class="event_menu_add">
    <form>
        <header>New Activity</header>
        <h1 class="loader"></h1>
        <div class="container_event">
            <div class="field">
                <label>Select category</label>
                <select name="category">
                    <option value="expenses">Expenses</option>
                    <option value="income">Income</option>
                    <option value="saving">deposit</option>
                </select>
            </div>
            <div class="field">
                <label>Type</label>
                <select name="type">
                    <option>Select</option>
                    <option value="housing">housing</option>
                    <option value="ultilities">ultiliy(electricity,water,gas,internet)</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="transportation">transportation</option>
                    <option value="gasoline">gasoline</option>
                    <option value="insurance">insurance</option>
                    <option value="food">food and groceries</option>
                    <option value="clothings">clothings</option>
                    <option value="investment">Investment</option>
                    <option value="bonds">Bonds</option>
                    <option value="paycheck">paychecks</option>
                    <option value="gifts">Gifts</option>
                    <option value="expenses">donation</option>

                    <option value="income">food and drinks</option>
                </select>
            </div>
            <div class="field">
                <label>Amount</label>
                <input name="Amount" type="Amount" placeholder="" />
            </div>
            <div class="field_e">
                <label>Details</label>
                <textarea name="details"></textarea>
            </div>
            <div class="field">
                <label>Activity Date</label>
                <input name="Date" type="date" placeholder="" required />
            </div>

            <button>create Activity</button>
            <input hidden name="delete_key" />
        </div>
    </form>

</div>