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

/**
 * Abstract log handler
 * 
 * Provides basic functionality which can be used by chil handlers.
 */
abstract class AbstractHandler 
{
    /**
     * Replaces placeholders in message with context values
     * 
     * @param string $message The msaage with some placeholders
     * @param array $context The replacements with named keys
     * 
     * @return string The interpolated message
     */
    protected function interpolate($message, array $context = [])
    {
        // build a replacement array with braces around the context keys
        $replace = [];
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }

        // interpolate replacement values into the message and return
        return strtr($message, $replace);
    }
    
    /**
     * Log a message
     * 
     * @param string    $level      Log level defined in \Psr\Log\LogLevel
     * @param string    $message    Message to log
     * @param mixed[]   $context    Extra information
     */
    abstract public function __invoke($level, $message, array $context = []);
}
