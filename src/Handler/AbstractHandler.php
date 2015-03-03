<?php

namespace JoeBengalen\Logger\Handler;

abstract class AbstractHandler 
{
    /**
     * Interpolates context values into the message placeholders.
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
    
    abstract public function __invoke($level, $message, array $context = []);
}
