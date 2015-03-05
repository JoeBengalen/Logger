<?php
/**
 * JoeBengalen Logger library
 * 
 * @author      Martijn Wennink <joebengalen@gmail.com>
 * @copyright   Copyright (c) 2015 Martijn Wennink
 * @license     https://github.com/JoeBengalen/Logger/blob/master/LICENSE.md (MIT License)
 * @version     0.1.0
 */
namespace JoeBengalen\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;

/**
 * Logger
 * 
 * Lightweight logger class thats implements the psr3 interface. Handlers should 
 * be registered to this logger. The handlers must do the actual logging task. 
 * This class just passes the log details to each registered handler.
 */
class Logger implements LoggerInterface
{
    /**
     * @const string The package version number
     */
    const VERSION = '0.1.0';
    
    use LoggerTrait;
    
    /**
     * @var callable[] Log handlers 
     */
    protected $handlers = [];
    
    /**
     * @var array Available log levels
     */
    protected $logLevels = [
        LogLevel::DEBUG,
        LogLevel::INFO,
        LogLevel::NOTICE,
        LogLevel::ALERT,
        LogLevel::WARNING,
        LogLevel::ERROR,
        LogLevel::CRITICAL,
        LogLevel::EMERGENCY
    ];

    /**
     * Create a logger instance and register handlers
     * 
     * @param callable[] $handlers (optional) List of callable handlers
     * 
     * @throws \InvalidArgumentException If any handler is not callable
     */
    public function __construct(array $handlers = [])
    {
        // check if each handler is callable
        foreach ($handlers as $handler) {
            if (!is_callable($handler)) {
                throw new \InvalidArgumentException("Handler must be callable");
            }
        }
        
        $this->handlers = $handlers;
    }

    /**
     * Calls each registered handler
     * 
     * @param string    $level      Log level. Must be defined in \Psr\Log\LogLevel.
     * @param string    $message    Message to log
     * @param array     $context    Context values sent along with the message
     * 
     * @throws \Psr\Log\InvalidArgumentException If the $level is not defined in \Psr\Log\LogLevel
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