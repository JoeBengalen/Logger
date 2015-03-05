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
     * @var array $options {
     *      @var callable $log.message.factory Alternative LogMessageInterface factory. 
     *          Callable arguments: mixed $level, string $message, array $context
     *          It MUST return an instance of LogMessageInterface.
     * }
     */
    protected $options;
    
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
     * @param callable[]    $handlers (optional)    List of callable handlers
     * @param array         $options (optional)     {
     *      @var callable $log.message.factory Alternative LogMessageInterface factory. 
     *          Callable arguments: mixed $level, string $message, array $context
     *          It MUST return an instance of LogMessageInterface.
     * }
     * 
     * @throws \InvalidArgumentException If any handler is not callable
     */
    public function __construct(array $handlers = [], array $options = [])
    {
        // check if each handler is callable
        foreach ($handlers as $handler) {
            if (!is_callable($handler)) {
                throw new \InvalidArgumentException("Handler must be callable");
            }
        }
        
        $this->handlers = $handlers;
        
        // merge default options with the given options
        $this->options = array_merge([
            // LogMessageInterface factory callable
            'log.message.factory' => function($level, $message, $context) {
                return new LogMessage($level, $message, $context);
            }
        ], $options);
    }

    /**
     * Calls each registered handler
     * 
     * @param mixed     $level      Log level. Must be defined in \Psr\Log\LogLevel.
     * @param string    $message    Message to log
     * @param array     $context    Context values sent along with the message
     * 
     * @throws \Psr\Log\InvalidArgumentException    If the $level is not defined in \Psr\Log\LogLevel
     * @throws \RuntimeException                    If callable option 'log.message.factory' does not return an instance of \JoeBengalen\Logger\LogMessageInterface
     */
    public function log($level, $message, array $context = [])
    {
        // check if the log level is valid
        if (!in_array($level, $this->logLevels)) {
            throw new InvalidArgumentException("Log level '{$level}' is not reconized.");
        }
        
        // create a LogMessageInterface with the registered log.message.factory callable
        $logMessage = call_user_func_array($this->options['log.message.factory'], [$level, $message, $context]);
        
        // check if the factory returned an instance of \JoeBengalen\Logger\LogMessageInterface
        if (!$logMessage instanceof LogMessageInterface) {
            throw new \RuntimeException("Option 'log.message.factory' callable must return an instance of \JoeBengalen\Logger\LogMessageInterface");
        }
        
        // call each handler
        foreach ($this->handlers as $handler) {
            call_user_func($handler, $logMessage);
        }
    }
}