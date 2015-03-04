<?php
/**
 * Logger - Lightweight psr3 logger library
 * 
 * @author      Martijn Wennink
 * @copyright   2015 Martijn Wennink
 * @version     0.1.0
 * @package     JoeBengalen\Logger
 *
 * MIT LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
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
 * 
 * @package Logger
 * @author  Martijn Wennink
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
     * @throws \Psr\Log\InvalidArgumentException If any handler is not callable
     */
    public function __construct(array $handlers = [])
    {
        // check if each handler is callable
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