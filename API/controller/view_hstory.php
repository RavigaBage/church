<?php
include ('../\notifications & token & history/autoloader.php');
include ('user_check.php');
$viewDataClass = new viewData();

function Pagenation($viewDataClass)
{
    $pagesTotal = $viewDataClass->HistoryPages();
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
    '<div class="content_pages">
    <div class="content_page_event">
        <div class="records_table">
            <table>
                <thead>
                    <tr>
                        <th>event name</th>
                        <th>event action</th>
                        <th>site name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                ' . $viewDataClass->getHistory('1') . '
                </tbody>

            </table>
        </div>
        <div class="page_sys">
        <header>Pages:<div class="pages">' . Pagenation($viewDataClass) . '</div>
        </header>
    </div>

    </div>
</div>
';
echo $pageData;
?>