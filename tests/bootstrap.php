<?php
namespace JoeBengalen\Logger\Test;

require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// loader for some extra file used by soem tests
spl_autoload_register(function ($class) {
    $map = [
        'JoeBengalen\\Logger\\Test\\' => __DIR__ . DIRECTORY_SEPARATOR,
    ];

    foreach ($map as $prefix => $source) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            continue;
        }

        $relativeClass = substr($class, $len);
        $file          = $source . str_replace('\\', '/', $relativeClass) . '.php';

        if (file_exists($file)) {
            require $file;
            break;
        }
    }
});
