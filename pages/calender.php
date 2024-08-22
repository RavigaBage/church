<?php
include_once ('../API/calender/autoloader.php');
$newDataRequest = new viewData();
$year = date('Y');
$data = "";
$data = $newDataRequest->viewList($year);


?>
<input type='hidden' id='calender_data' value='<?php echo $data; ?>' />
<div class="event_menu">
    <div class="menu_date">
        <header>MAY 2024</header>
    </div>
    <div class="menu_type">
        <div class="menu_tab active" id="dayTab">
            <strong>DAY</strong>
        </div>
        <div class="menu_tab" id="WeekTab">
            <strong>WEEK</strong>
        </div>
        <div class="menu_tab" id="MonthTab">
            <strong>MONTH</strong>
        </div>
    </div>
    <div class="add_menu">
        <div class="left_arrow"><i class="fas fa-chevron-left"></i></div>
        <p>weeks</p>
        <div class="right_arrow"><i class="fas fa-chevron-right"></i></div>


    </div>
</div>
<div class="schedule activities_main">
    <div class="category_main">
        <div class="event_category day">
            <div class="view month_view">
                <div class="event_days">
                    <strong>Sun</strong>
                    <strong>Mon</strong>
                    <strong>Tue</strong>
                    <strong>Wed</strong>
                    <strong>Thur</strong>
                    <strong>Fri</strong>
                    <strong>Sat</strong>
                </div>
                <div class="view_main" data-year="2024" data-month="1">

                    <!-- <div class="activity" data-icu=""><span>5</span>
                        <p style="--color:crimson;">Evangelism week</p>
                    </div> -->


                </div>
            </div>

            <div class=" view week_view">
                <div class="schedules week grid_schedule">
                    <div class="schedule_time">
                        <div class="time" style="--textTime:'00';"></div>
                        <div class="time" style="--textTime:'1 am';"></div>
                        <div class="time" style="--textTime:'2 am';"></div>
                        <div class="time" style="--textTime:'3 am';"></div>
                        <div class="time" style="--textTime:'4 am';"></div>
                        <div class="time" style="--textTime:'5 am';"></div>
                        <div class="time" style="--textTime:'6 am';"></div>
                        <div class="time" style="--textTime:'7 am';"></div>
                        <div class="time" style="--textTime:'8 am';"></div>
                        <div class="time" style="--textTime:'9 am';"></div>
                        <div class="time" style="--textTime:'10 am';"></div>
                        <div class="time" style="--textTime:'11 am';"></div>
                        <div class="time" style="--textTime:'12 pm';"></div>
                        <div class="time" style="--textTime:'1 pm';"></div>
                        <div class="time" style="--textTime:'2 pm';"></div>
                        <div class="time" style="--textTime:'3 pm';"></div>
                        <div class="time" style="--textTime:'4 pm';"></div>
                        <div class="time" style="--textTime:'5 pm';"></div>
                        <div class="time" style="--textTime:'6 pm';"></div>
                        <div class="time" style="--textTime:'7 pm';"></div>
                        <div class="time" style="--textTime:'8 pm';"></div>
                        <div class="time" style="--textTime:'9 pm';"></div>
                        <div class="time" style="--textTime:'10 pm';"></div>
                        <div class="time" style="--textTime:'11 pm';"></div>

                    </div>

                    <div class="main_schedule">
                        <div class="grid_lines">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <div class="event_days">

                            <strong data-id="0"><span>24</span>Sun</strong>
                            <strong data-id="1"><span>25</span>Mon</strong>
                            <strong data-id="2"><span>26</span>Tue</strong>
                            <strong data-id="3"><span>27</span>Wed</strong>
                            <strong data-id="4"><span>28</span>Thur</strong>
                            <strong data-id="5"><span>29</span>Fri</strong>
                            <strong data-id="6"><span>30</span>Sat</strong>
                        </div>
                        <div class="grid_space">
                            <div class="gridcell gridrowO">
                                <div class="customize_event dull"><span class="element_main_data"></span></div>

                            </div>
                            <div class="gridcell gridrowT">
                                <div class="customize_event dull"><span class="element_main_data"></span></div>
                            </div>
                            <div class="gridcell gridrowTH">

                                <div class="customize_event dull"><span class="element_main_data"></span></div>

                            </div>
                            <div class="gridcell gridrowF">
                                <div class="customize_event dull"><span class="element_main_data"></span></div>

                            </div>
                            <div class="gridcell gridrowFI">

                                <div class="customize_event dull"><span class="element_main_data"></span></div>

                            </div>
                            <div class="gridcell gridrowS">

                                <div class="customize_event dull"><span class="element_main_data"></span></div>

                            </div>
                            <div class="gridcell gridrowSE">

                                <div class="customize_event dull"><span class="element_main_data"></span></div>

                            </div>
                        </div>
                    </div>



                </div>
            </div>
            <div class="view day_view">
                <div class="day_event">
                    <div class="day_info">
                        <header>22</header>
                        <p>Monday, January 22, 2024</p>
                    </div>
                    <div class="min_calenda" data-year="2024" data-month="1">
                        <div class="calenda_min_data event_days calenderHeader">
                            <div>S</div>
                            <div>M</div>
                            <div>T</div>
                            <div>W</div>
                            <div>T</div>
                            <div>F</div>
                            <div>S</div>
                        </div>
                        <div class="min_data event_days"></div>
                    </div>
                </div>
                <div class="day_details">
                    <div class="events">

                    </div>
                    <div class="schedules">

                    </div>
                </div>

            </div>
        </div>
        <form id="formData">
            <div class="event_menu new_event_menu">
                <div class="navigator">
                    <div class="plus_arrow"><i class="fas fa-plus"></i></div>
                </div>

                <div class="main">
                    <div class="error"></div>
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                            fill="#000">
                            <path
                                d="M480-400q-17 0-28.5-11.5T440-440q0-17 11.5-28.5T480-480q17 0 28.5 11.5T520-440q0 17-11.5 28.5T480-400Zm-160 0q-17 0-28.5-11.5T280-440q0-17 11.5-28.5T320-480q17 0 28.5 11.5T360-440q0 17-11.5 28.5T320-400Zm320 0q-17 0-28.5-11.5T600-440q0-17 11.5-28.5T640-480q17 0 28.5 11.5T680-440q0 17-11.5 28.5T640-400ZM480-240q-17 0-28.5-11.5T440-280q0-17 11.5-28.5T480-320q17 0 28.5 11.5T520-280q0 17-11.5 28.5T480-240Zm-160 0q-17 0-28.5-11.5T280-280q0-17 11.5-28.5T320-320q17 0 28.5 11.5T360-280q0 17-11.5 28.5T320-240Zm320 0q-17 0-28.5-11.5T600-280q0-17 11.5-28.5T640-320q17 0 28.5 11.5T680-280q0 17-11.5 28.5T640-240ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Z" />
                        </svg>
                        <p>Add Event</p>
                    </div>

                    <div class="event">
                        <input type="text" placeholder="new event" name="EventName" />
                    </div>
                    <div class="flex">
                        <i class="fas fa-location"></i>
                        <p>Location</p>
                    </div>
                    <div class="event">
                        <input type="text" placeholder="location" name="EventLocation" />
                    </div>
                    <div class="event">
                        <p><i class="fas fa-tag"></i>Calender tag</p>
                        <div class="function selector">
                            <p class="EventTag">#Tag</p>
                            <div class="svg_wrapper">
                                <svg viewBox="0 0 24 24" width="24px" height="24px" focusable="false" aria-hidden="true"
                                    class="ng-tns-c333432692-11">
                                    <path d="M7 10l5 5 5-5z" class="ng-tns-c333432692-11"></path>
                                </svg>
                            </div>
                            <div class="items_selector tag">
                                <div class="w8UdJc" jsname="rymPhb" role="listbox" tabindex="-1" id="c22">
                                    <div role="option" class="VKy0Ic tag" aria-selected="false">
                                        District</div>
                                    <div role="option" class="VKy0Ic tag" id="c22T001500" aria-selected="true">local
                                    </div>
                                    <div role="option" class="VKy0Ic tag" id="c22T003000" aria-selected="false">Area
                                    </div>
                                    <div role="option" class="VKy0Ic tag" id="c22T004500">funeral</div>
                                    <div role="option" class="VKy0Ic tag" id="c22T010000">Wedding</div>
                                    <div role="option" class="VKy0Ic tag" id="c22T013000">fun-Games
                                    </div>
                                    <div role="option" class="VKy0Ic tag" id="c22T020000">Evangelism
                                    </div>
                                    <div role="option" class="VKy0Ic tag" id="c22T023000">Donation</div>
                                    <div role="option" class="VKy0Ic tag" id="c22T030000">mission</div>

                                </div>



                            </div>
                        </div>
                    </div>
                    <div class="event">
                        <p><i class="fas fa-clock"></i>Start time</p>
                        <div class="function selector">
                            <p class="start_time_p">2:30AM</p>
                            <div class="svg_wrapper" data-origin="start">
                                <svg viewBox="0 0 24 24" width="24px" height="24px" focusable="false" aria-hidden="true"
                                    class="ng-tns-c333432692-11">
                                    <path d="M7 10l5 5 5-5z" class="ng-tns-c333432692-11"></path>
                                </svg>
                            </div>
                            <div class="items_selector">
                                <div class="w8UdJc" jsname="rymPhb" role="listbox" tabindex="-1" id="c22">
                                    <div role="option" class="VKy0Ic" tabindex="1" data-ical="T000000" id="c22T000000"
                                        aria-selected="false"> 12:00am (0 mins)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T001500" id="c22T001500"
                                        aria-selected="true"> 12:15am (15 mins)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T003000" id="c22T003000"
                                        aria-selected="false"> 12:30am (30 mins)
                                    </div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T004500" id="c22T004500">
                                        12:45am (45 mins)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T010000" id="c22T010000">
                                        1:00am (1 hr)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T013000" id="c22T013000">
                                        1:30am (1.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T020000" id="c22T020000">
                                        2:00am (2 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T023000" id="c22T023000">
                                        2:30am (2.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T030000" id="c22T030000">
                                        3:00am (3 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T033000" id="c22T033000">
                                        3:30am (3.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T040000" id="c22T040000">
                                        4:00am (4 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T043000" id="c22T043000">
                                        4:30am (4.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T050000" id="c22T050000">
                                        5:00am (5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T053000" id="c22T053000">
                                        5:30am (5.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T060000" id="c22T060000">
                                        6:00am (6 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T063000" id="c22T063000">
                                        6:30am (6.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T070000" id="c22T070000">
                                        7:00am (7 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T073000" id="c22T073000">
                                        7:30am (7.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T080000" id="c22T080000">
                                        8:00am (8 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T083000" id="c22T083000">
                                        8:30am (8.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T090000" id="c22T090000">
                                        9:00am (9 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T093000" id="c22T093000">
                                        9:30am (9.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T100000" id="c22T100000">
                                        10:00am (10 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T103000" id="c22T103000">
                                        10:30am (10.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T110000" id="c22T110000">
                                        11:00am (11 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T113000" id="c22T113000">
                                        11:30am (11.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T120000" id="c22T120000">
                                        12:00pm (12 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T123000" id="c22T123000">
                                        12:30pm (12.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T130000" id="c22T130000">
                                        1:00pm (13 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T133000" id="c22T133000">
                                        1:30pm (13.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T140000" id="c22T140000">
                                        2:00pm (14 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T143000" id="c22T143000">
                                        2:30pm (14.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T150000" id="c22T150000">
                                        3:00pm (15 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T153000" id="c22T153000">
                                        3:30pm (15.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T160000" id="c22T160000">
                                        4:00pm (16 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T163000" id="c22T163000">
                                        4:30pm (16.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T170000" id="c22T170000">
                                        5:00pm (17 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T173000" id="c22T173000">
                                        5:30pm (17.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T180000" id="c22T180000">
                                        6:00pm (18 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T183000" id="c22T183000">
                                        6:30pm (18.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T190000" id="c22T190000">
                                        7:00pm (19 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T193000" id="c22T193000">
                                        7:30pm (19.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T200000" id="c22T200000">
                                        8:00pm (20 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T203000" id="c22T203000">
                                        8:30pm (20.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T210000" id="c22T210000">
                                        9:00pm (21 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T213000" id="c22T213000">
                                        9:30pm (21.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T220000" id="c22T220000">
                                        10:00pm (22 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T223000" id="c22T223000">
                                        10:30pm (22.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T230000" id="c22T230000">
                                        11:00pm (23 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T233000" id="c22T233000">
                                        11:30pm (23.5 hrs)</div>
                                </div>



                            </div>
                        </div>
                    </div>
                    <div class="event">
                        <p><i class="fas fa-clock"></i>End time</p>
                        <div class="function selector">
                            <p class="End_time_p">2:30AM</p>
                            <div class="svg_wrapper" data-origin="end">
                                <svg viewBox="0 0 24 24" width="24px" height="24px" focusable="false" aria-hidden="true"
                                    class="ng-tns-c333432692-11">
                                    <path d="M7 10l5 5 5-5z" class="ng-tns-c333432692-11"></path>
                                </svg>
                            </div>
                            <div class="items_selector">
                                <div class="w8UdJc" jsname="rymPhb" role="listbox" tabindex="-1" id="c22">
                                    <div role="option" class="VKy0Ic" tabindex="1" data-ical="T000000" id="c22T000000"
                                        aria-selected="false"> 12:00am (0 mins)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T001500" id="c22T001500"
                                        aria-selected="true"> 12:15am (15 mins)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T003000" id="c22T003000"
                                        aria-selected="false"> 12:30am (30 mins)
                                    </div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T004500" id="c22T004500">
                                        12:45am (45 mins)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T010000" id="c22T010000">
                                        1:00am (1 hr)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T013000" id="c22T013000">
                                        1:30am (1.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T020000" id="c22T020000">
                                        2:00am (2 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T023000" id="c22T023000">
                                        2:30am (2.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T030000" id="c22T030000">
                                        3:00am (3 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T033000" id="c22T033000">
                                        3:30am (3.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T040000" id="c22T040000">
                                        4:00am (4 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T043000" id="c22T043000">
                                        4:30am (4.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T050000" id="c22T050000">
                                        5:00am (5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T053000" id="c22T053000">
                                        5:30am (5.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T060000" id="c22T060000">
                                        6:00am (6 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T063000" id="c22T063000">
                                        6:30am (6.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T070000" id="c22T070000">
                                        7:00am (7 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T073000" id="c22T073000">
                                        7:30am (7.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T080000" id="c22T080000">
                                        8:00am (8 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T083000" id="c22T083000">
                                        8:30am (8.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T090000" id="c22T090000">
                                        9:00am (9 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T093000" id="c22T093000">
                                        9:30am (9.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T100000" id="c22T100000">
                                        10:00am (10 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T103000" id="c22T103000">
                                        10:30am (10.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T110000" id="c22T110000">
                                        11:00am (11 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T113000" id="c22T113000">
                                        11:30am (11.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T120000" id="c22T120000">
                                        12:00pm (12 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T123000" id="c22T123000">
                                        12:30pm (12.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T130000" id="c22T130000">
                                        1:00pm (13 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T133000" id="c22T133000">
                                        1:30pm (13.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T140000" id="c22T140000">
                                        2:00pm (14 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T143000" id="c22T143000">
                                        2:30pm (14.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T150000" id="c22T150000">
                                        3:00pm (15 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T153000" id="c22T153000">
                                        3:30pm (15.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T160000" id="c22T160000">
                                        4:00pm (16 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T163000" id="c22T163000">
                                        4:30pm (16.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T170000" id="c22T170000">
                                        5:00pm (17 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T173000" id="c22T173000">
                                        5:30pm (17.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T180000" id="c22T180000">
                                        6:00pm (18 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T183000" id="c22T183000">
                                        6:30pm (18.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T190000" id="c22T190000">
                                        7:00pm (19 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T193000" id="c22T193000">
                                        7:30pm (19.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T200000" id="c22T200000">
                                        8:00pm (20 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T203000" id="c22T203000">
                                        8:30pm (20.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T210000" id="c22T210000">
                                        9:00pm (21 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T213000" id="c22T213000">
                                        9:30pm (21.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T220000" id="c22T220000">
                                        10:00pm (22 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T223000" id="c22T223000">
                                        10:30pm (22.5 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T230000" id="c22T230000">
                                        11:00pm (23 hrs)</div>
                                    <div role="option" class="VKy0Ic" tabindex="-1" data-ical="T233000" id="c22T233000">
                                        11:30pm (23.5 hrs)</div>
                                </div>



                            </div>
                        </div>
                    </div>

                    <div class="event label">
                        <p><i class="fas fa-image"></i> Image or Video</p>

                        <div class="file">
                            <input type="file" name="ImageFile" value />
                        </div>

                    </div>
                    <div class="event label">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                                fill="#000">
                                <path
                                    d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520h200L520-800v200Z" />
                            </svg>
                            <p>Description</p>
                        </div>
                    </div>
                    <div class="details"><textarea name="EventDescription"></textarea></div>
                    <input type="hidden" name="delete_key" />
                </div>
                <div class="sub_option">
                    <div class="flex btn">
                        <button id="save_details">save</button>
                    </div>
                    <div class="flex btn">
                        <button id="Update_details">Update</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <div class="month_selector">
        <div class="year">
            <div class="flex">
                <header>2024</header>
                <svg viewBox="0 0 24 24" width="24px" height="24px" focusable="false" aria-hidden="true"
                    class="year_choose">
                    <path d="M7 10l5 5 5-5z" class="ng-tns-c333432692-11"></path>
                </svg>

                <div class="year_list">
                    <p>2023</p>
                </div>
            </div>

            <div class="icons"></div>
            <button>Submit</button>
        </div>
        <div class="view">
            <div data_id="0">Jan</div>
            <div data_id="1">Feb</div>
            <div data_id="2">Mar</div>
            <div data_id="3">Apr</div>
            <div data_id="4">May</div>
            <div data_id="5">Jun</div>
            <div data_id="6">Jul</div>
            <div data_id="7">Aug</div>
            <div data_id="8">Sep</div>
            <div data_id="9">Oct</div>
            <div data_id="10">Nov</div>
            <div data_id="11">Dec</div>
        </div>
    </div>
</div>