<?php

use JoeBengalen\JBLogger\LogMessageInterface;

class InvokableHandler extends JoeBengalen\JBLogger\Handler\AbstractHandler
{
    public function __invoke(LogMessageInterface $logMessage)
    {
        return $this->interpolate($logMessage->getMessage(), $logMessage->getContext());
    }
}

