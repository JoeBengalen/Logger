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

use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;

/**
 * LogMessage
 * 
 * Immutable holder for the log message data
 */
class LogMessage implements LogMessageInterface
{
    /**
     * @var mixed $level Level, defined in \Psr\Log\LogLevel
     */
    protected $level;
    
    /**
     * @var string $message Message
     */
    protected $message;
    
    /**
     * @var mixed[] $context Context
     */
    protected $context;


    /**
     * Create a new log message
     * 
     * @param mixed     $level      Level, defined in \Psr\Log\LogLevel
     * @param string    $message    Message
     * @param array     $context    Context
     * 
     * @throws \Psr\Log\InvalidArgumentException If $level is not defined in \Psr\Log\LogLevel
     */
    public function __construct($level, $message, array $context = [])
    {
        // get valid log levels by reflecting the LogLevel object
        $validLogLevels = (new \ReflectionClass(new LogLevel()))->getConstants();
        
        // check if the log level is valid
        if (!in_array($level, $validLogLevels)) {
            throw new InvalidArgumentException("Log level '{$level}' not reconized.");
        }
        
        $this->level   = $level;
        $this->message = (string) $message;
        $this->context = $context;
    }

    /**
     * Get level
     * 
     * @return mixed Level, defined in \Psr\Log\LogLevel
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Get message
     * 
     * @return string Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get context
     * 
     * @return mixed[] Context
     */
    public function getContext()
    {
        return $this->context;
    }
}