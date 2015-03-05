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

/**
 * Log Message Interface
 * 
 * Defines a log message
 */
interface LogMessageInterface
{
    /**
     * Create a new log message
     * 
     * @param string    $level      Level, defined in \Psr\Log\LogLevel
     * @param string    $message    Message
     * @param array     $context    Context
     * 
     * @throws \Psr\Log\InvalidArgumentException If $level is not defined in \Psr\Log\LogLevel
     */
    public function __construct($level, $message, array $context = []);
    
    /**
     * Get level
     * 
     * @return string Level, defined in \Psr\Log\LogLevel
     */
    public function getLevel();
    
    /**
     * Get message
     * 
     * @return string Message
     */
    public function getMessage();
    
    /**
     * Get context
     * 
     * @return mixed[] Context
     */
    public function getContext();
}