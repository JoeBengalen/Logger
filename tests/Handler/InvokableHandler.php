<?php
namespace JoeBengalen\JBLogger\Test\Handler;

use JoeBengalen\JBLogger\LogMessageInterface;
use JoeBengalen\JBLogger\Handler\AbstractHandler;

class InvokableHandler extends AbstractHandler
{
    public function __invoke(LogMessageInterface $logMessage)
    {
        return $this->interpolate($logMessage->getMessage(), $logMessage->getContext());
    }
}

