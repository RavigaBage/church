<?php
session_start();
$_SESSION['last_modified'] = 0;
include ('Assets&projects/autoloader.php');

$newData = new viewData();
// $data = $newData->LastModified();
print_r($_SESSION['last_modified']);