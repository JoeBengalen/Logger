<?php
/**
 * JoeBengalen Logger library
 * 
 * @author      Martijn Wennink <joebengalen@gmail.com>
 * @copyright   Copyright (c) 2015 Martijn Wennink
 * @license     https://github.com/JoeBengalen/Logger/blob/master/LICENSE.md (MIT License)
 * @version     0.1.0
 */
namespace JoeBengalen\Logger\Handler;

use \JoeBengalen\Logger\MessageInterface;

/**
 * File logging handler
 * 
 * Logs all log level messages to a specified file.
 */
class FileHandler extends AbstractHandler
{
    /**
     * @var string $file Absolute path of the log file 
     */
    protected $file;

    /**
     * @var array $options {
     *      @var string $datetime.format The datetime format to log in
     * }
     */
    protected $options;

    /**
     * Create a file log handler
     * 
     * @param string    $logFile Absolute path of the log file
     * @param array     $options (optional) {
     *      @var string $datetime.format The datetime format to log in
     * }
     */
    public function __construct($logFile, array $options = [])
    {
        $this->file = $logFile;
        
        $this->options = array_merge([
            'datetime.format' => 'Y-m-d h:m:s',
        ], $options);
    }

    /**
     * Log a message
     * 
     * @param MessageInterface $message MessageInterface instance
     */
    public function __invoke(MessageInterface $message)
    {
        file_put_contents($this->file, $this->format($message->getLevel(), $message->getMessage(), $message->getContext()), FILE_APPEND);
    }

    /**
     * Format the message
     * 
     * Adds the datetime, replaces the placeholders in the message and append the 
     * exception (if given) as string to the message.
     * 
     * @param mixed     $level      Log level defined in \Psr\Log\LogLevel
     * @param string    $message    Message to log
     * @param mixed[]   $context    Extra information
     * 
     * @return string Formatted message
     */
    protected function format($level, $message, array $context = [])
    {
        $interpolatedMessage = $this->interpolate($message, $context);
        $now = new \DateTime('NOW');
        $result = $now->format($this->options['datetime.format']) . ' ' . strtoupper($level) . ": {$interpolatedMessage}";
        
        if (isset($context['exception']) && $context['exception'] instanceof \Exception) {
            $result .= ": " . (string) $context['exception'];
        }
        return $result . PHP_EOL;
    }
}