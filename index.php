<?php

use JoeBengalen\Logger;
use JoeBengalen\Logger\MessageInterface;
use JoeBengalen\Logger\Message;
use Psr\Log\LogLevel;

error_reporting(-1);
ini_set('display_errors', 1);

// Set default timezone
date_default_timezone_set('Europe/Amsterdam');

require_once 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$logFile = __DIR__ . DIRECTORY_SEPARATOR . 'default.log';
$sqliteFile = __DIR__ . DIRECTORY_SEPARATOR . 'logging.sqlite';

$logger = (new Logger\Logger())
        //->option('collection.factory', null)
        ->option('message.factory', function ($level, $message, $context) {
            return new Message($level, $message, $context);
        })
        ->handler(new Logger\Handler\FileHandler($logFile))  
        ->handler(function (MessageInterface $message) {
            if ($message->getLevel() == LogLevel::DEBUG) {
                echo "Debugging: {$message->getMessage()}\n";
            }
        });

$logger->debug('Some debug information ...');
$logger->info("User '{username}' created.", array('username' => 'JoeBengalen', 'extra' => true));
$logger->critical("Unexpected Exception occurred.", ['exception' => new \Exception('Something went horribly wrong :(')]);

var_dump($logger->getCollection());


