<?php
/**
 * JoeBengalen Logger library
 * 
 * @author      Martijn Wennink <joebengalen@gmail.com>
 * @copyright   Copyright (c) 2015 Martijn Wennink
 * @license     https://github.com/JoeBengalen/JBLogger/blob/master/LICENSE.md (MIT License)
 * @version     0.1.0
 */
namespace JoeBengalen\JBLogger;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

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
     *          Callable MUST return an instance of LogMessageInterface.
     *      @var callable|null $collection.factory Alternative CollectionInterface factory. 
     *          Callable MUST return an instance of CollectionInterface.
     *          Null means no collection will be used.
     * }
     */
    protected $options;

    /**
     * @var callable[] Log handlers 
     */
    protected $handlers = [];
    
    /**
     * @var \JoeBengalen\JBLogger\CollectionInterface $collection Log message collector 
     */
    protected $collection;

    /**
     * Create a logger instance and register handlers
     * 
     * @param callable[]    $handlers (optional)    List of callable handlers
     * @param array         $options (optional)     {
     *      @var callable $log.message.factory Alternative LogMessageInterface factory. 
     *          Callable arguments: mixed $level, string $message, array $context
     *          Callable MUST return an instance of LogMessageInterface.
     *      @var callable|null $collection.factory Alternative CollectionInterface factory. 
     *          Callable MUST return an instance of CollectionInterface.
     *          Null means no collection will be used.
     * }
     * 
     * @throws \InvalidArgumentException If any handler is not callable
     * @throws \InvalidArgumentException If option log.message.factory is not a callable
     * @throws \InvalidArgumentException If option collection.factory is not a callable or null
     * @throws \RuntimeException         If callable option collection.factory does not return an instance of \JoeBengalen\JBLogger\CollectionInterface
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
            },
            
            // CollectionInterface factory callable
            'collection.factory' => function() {
                return new Collection();
            }
        ], $options);
        
        // check if option log.message.factory is a callable
        if (!is_callable($this->options['log.message.factory'])) {
            throw new \InvalidArgumentException("Option 'log.message.factory' must contain a callable");
        }
        
        // try to initialize the collection if the collection.factory is not null
        if (!is_null($this->options['collection.factory'])) {
            // check if option collection.factory is a callable
            if (!is_callable($this->options['collection.factory'])) {
                throw new \InvalidArgumentException("Option 'collection.factory' must contain a callable or be null");
            }
            
            // call the collection.factory
            $collection = call_user_func($this->options['collection.factory']);
            
            // check if the factory returned an instance of \JoeBengalen\JBLogger\CollectionInterface
            if (!$collection instanceof CollectionInterface) {
                throw new \RuntimeException("Option 'log.message.factory' callable must return an instance of \JoeBengalen\JBLogger\CollectionInterface");
            }
            
            $this->collection = $collection;
        }
    }

    /**
     * Calls each registered handler
     * 
     * @param mixed     $level      Log level. Must be defined in \Psr\Log\LogLevel.
     * @param string    $message    Message to log
     * @param array     $context    Context values sent along with the message
     * 
     * @throws \Psr\Log\InvalidArgumentException    If the $level is not defined in \Psr\Log\LogLevel
     * @throws \RuntimeException                    If callable option 'log.message.factory' does not return an instance of \JoeBengalen\JBLogger\LogMessageInterface
     */
    public function log($level, $message, array $context = [])
    {
        // create a LogMessageInterface instance with the registered log.message.factory callable
        $logMessage = call_user_func_array($this->options['log.message.factory'], [$level, $message, $context]);
        
        // check if the factory returned an instance of \JoeBengalen\JBLogger\LogMessageInterface
        if (!$logMessage instanceof LogMessageInterface) {
            throw new \RuntimeException("Option 'log.message.factory' callable must return an instance of \JoeBengalen\JBLogger\LogMessageInterface");
        }
        
        // add log message to collection if collection is set
        if (!is_null($this->collection)) {
            $this->collection->addLogMessage($logMessage);
        }
        
        // call each handler
        foreach ($this->handlers as $handler) {
            call_user_func($handler, $logMessage);
        }
    }
    
    /**
     * Get the log message collection
     * 
     * @return \JoeBengalen\JBLogger\CollectionInterface|null $collection Log message collection or null if not used
     */
    public function getCollection()
    {
        return $this->collection;
    }
}