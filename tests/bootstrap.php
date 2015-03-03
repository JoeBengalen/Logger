<?php

require dirname(__DIR__) . '/vendor/autoload.php';

// loader for some extra file used by soem tests
spl_autoload_register(function ($class) {
    $file = rtrim(dirname(__FILE__), '/') . '/' . $class . '.php';
    if (file_exists($file)) {
        require $file;
    }
});