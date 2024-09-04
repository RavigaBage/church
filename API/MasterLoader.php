<?php

$loaders = [require 'finance/autoload.php'];

spl_autoload_register(function ($class) use ($loaders) {
    foreach ($loaders as $autoloader) {

        $autoloader($class);
    }
});