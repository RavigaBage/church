<?php
include_once 'home/viewData.php';
$name = $_POST['name'];
$details = $_POST['textField'];
$contact = $_POST['contact'];
$category = $_POST['category'];
//////////////////EXPLODING TEXT

date_default_timezone_set('UTC');
$date = date('YFlj  h:i');

$newClass = new viewData();
echo $newClass->complaints_event($name, $contact, $category, $details, $date);