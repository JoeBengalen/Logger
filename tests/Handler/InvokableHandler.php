<?php
namespace JoeBengalen\Logger\Test\Handler;

use JoeBengalen\Logger\LogMessageInterface;
use JoeBengalen\Logger\Handler\AbstractHandler;

class InvokableHandler extends AbstractHandler
{
    public function __invoke(LogMessageInterface $logMessage)
    {
        return $this->interpolate($logMessage->getMessage(), $logMessage->getContext());
    }
}

