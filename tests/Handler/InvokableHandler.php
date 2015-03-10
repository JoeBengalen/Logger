<?php
namespace JoeBengalen\Logger\Test\Handler;

use JoeBengalen\Logger\MessageInterface;
use JoeBengalen\Logger\Handler\AbstractHandler;

class InvokableHandler extends AbstractHandler
{
    public function __invoke(MessageInterface $message)
    {
        return $this->interpolate($message->getMessage(), $message->getContext());
    }
}

