<?php

use JoeBengalen\Logger\LogMessageInterface;

class InvokableHandler extends JoeBengalen\Logger\Handler\AbstractHandler
{
    public function __invoke(LogMessageInterface $logMessage)
    {
        return $this->interpolate($logMessage->getMessage(), $logMessage->getContext());
    }
}

