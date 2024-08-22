<?php
include_once('../../API/notifications & token & history/autoloader.php');
$newDataRequest = new viewData();
$val = 1;
if (isset($_GET['page'])) {
    $val = $_GET['page'];
}

?>

<div class="content_pages">
    <div class="content_page_event">
        <div class="records_table">
            <table>
                <thead>
                    <tr>
                        <th>event name</th>
                        <th>event action</th>
                        <th>recorded date</th>
                        <th>site naem</th>
                        <th>Status</th>
                    </tr>
                </thead>


                <tbody>

                    <?php
                    $data = json_decode($newDataRequest->getHistory($val));
                    if ($data != "" || $data != "Fetching data encountered a problem" || $data != "no data found") {
                        foreach ($data as $item) {
                            $name = $item->name;
                            $event = $item->event;
                            $date = $item->date;
                            $sitename = $item->sitename;
                            $action = $item->action;

                            echo "<tr>
                                <td><div class='details'>
                                <div class='text'>
                                <p>" . $name . "</p>
                                <p>" . $date . "</p>
                                </div>
                                </div></td>
                                <td class='td_action'>" . $action . "</td>
                                <td class='td_action'>" . $sitename . "</td>
                                
                                <td class='td_action'>" . $event . "</td>
                                </tr>";
                        }
                    } else {
                        echo $data;
                    }
                    ?>

                </tbody>

            </table>
        </div>
    </div>
</div>

<div class="page_sys">

    <header>
        <?php
        $total = $newDataRequest->HistoryPages();
        if ((round($total / 6)) > 1) {
            echo 'Pages:';
        }
        ?>
        <div class="pages">
            <?php
            $loop = 0;
            if ((round($total / 6)) > 1) {
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