<?php
require('file:///C:/wamp64new/www/database/Church/API/vendor/autoload.php');
$dotenv = \Dotenv\Dotenv::createImmutable($dir);
$dotenv->safeLoad();
echo $dir;
$passwordKey = $_ENV['database_passkey'];
?>