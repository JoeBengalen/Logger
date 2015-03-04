<?php

class InvokableHandler extends JoeBengalen\Logger\Handler\AbstractHandler
{
    public function __invoke($level, $message, array $context = [])
    {
        return [$level, $this->interpolate($message, $context), $context];
    }
}

