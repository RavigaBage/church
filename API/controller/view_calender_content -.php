<?php
include ('../calender/autoloader.php');
include ('user_check.php');
$viewDataClass = new viewData();


$pageData = $viewDataClass->viewList('2023');
print_r(json_encode($pageData));