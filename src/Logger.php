<?php

namespace JoeBengalen\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;

class Logger implements LoggerInterface
{
    use LoggerTrait;
    
    protected $handlers = [];
    
    protected $logLevels = [
        LogLevel::DEBUG,
        LogLevel::INFO,
        LogLevel::NOTICE,
        LogLevel::ALERT,
        LogLevel::WARNING,
        LogLevel::ERROR,
        LogLevel::EMERGENCY,
        LogLevel::CRITICAL
    ];

    /**
     * Create a logger instance and register handlers
     * 
     * @param callable[] $handlers (optional) List of callable handlers
     * 
     * @throws InvalidArgumentException If any handler is not callable
     */
    public function __construct(array $handlers = [])
    {
        foreach ($handlers as $handler) {
            if (!is_callable($handler)) {
                throw new InvalidArgumentException("Handler must be callable");
            }
        }
        $this->handlers = $handlers;
    }

    /**
     * Calls each registered handler
     * 
     * @param string $level The log level. Must be a Psr\Log\LogLevel.
     * @param string $message The message to log
     * @param array $context Context values sent along with the message
     * 
     * @throws InvalidArgumentException If the $level is not a Psr\Log\LogLevel
     */
    public function log($level, $message, array $context = [])
    {
        // check if the log level is valid
        if (!in_array($level, $this->logLevels)) {
            throw new InvalidArgumentException("Log level '{$level}' is not reconized.");
        }

        // call each handler
        foreach ($this->handlers as $handler) {
            call_user_func_array($handler, [$level, $message, $context]);
        }
    }
}