<?php
namespace JoeBengalen\Logger;

use JoeBengalen\Logger\LogMessageInterface;

interface CollectionInterface
{
    public function addLogMessage(LogMessageInterface $logMessage);
}