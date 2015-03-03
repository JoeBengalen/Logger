<?php

namespace JoeBengalen\Logger\Handler;

interface HandlerInterface
{
    public function log($level, $message, array $context = []);
}