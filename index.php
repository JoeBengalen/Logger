<?php

use JoeBengalen\Logger;
use JoeBengalen\Logger\MessageInterface;
use Psr\Log\LogLevel;

error_reporting(-1);
ini_set('display_errors', 1);

// Set default timezone
date_default_timezone_set('Europe/Amsterdam');

require_once 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$logFile = __DIR__ . DIRECTORY_SEPARATOR . 'default.log';
$sqliteFile = __DIR__ . DIRECTORY_SEPARATOR . 'logging.sqlite';

$collection = new Logger\Handler\CollectionHandler();

$logger = new Logger\Logger([
    $collection,
    new Logger\Handler\FileHandler($logFile),    
    //new Logger\Handler\DatabaseHandler(new PDO("sqlite:{$sqliteFile}", null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION])),
    
    // custom handler only showing debug messages
    function (MessageInterface $message) {
        if ($message->getLevel() == LogLevel::DEBUG) {
            echo "Debugging: {$message->getMessage()}\n";
        }
    }
]);

$logger->debug('Some debug information ...');
$logger->info("User '{username}' created.", array('username' => 'JoeBengalen', 'extra' => true));
$logger->critical("Unexpected Exception occurred.", ['exception' => new \Exception('Something went horribly wrong :(')]);

var_dump($collection->getAllMessages());


