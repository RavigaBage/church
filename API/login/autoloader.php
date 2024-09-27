<?php
spl_autoload_register('myAutoload');
function myAutoload($class)
{
    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $ext = '.php';
    include_once $class . $ext;
}