<?php

namespace JoeBengalen\Logger\Handler;

/**
 * Log handler to log to PHPs error_log
 */
class ErrorLogHandler extends AbstractHandler
{
    public function log($level, $message, array $context = array())
    {
        error_log($this->format($level, $message, $context));
        if (isset($context['exception']) && $context['exception'] instanceof \Exception) {
            error_log($context['exception']);
        }
    }
    
    protected function format($level, $message, array $context = [])
    {
        $interpolatedMessage = $this->interpolate($message, $context);
        return strtoupper($level) . ": $interpolatedMessage";
    }
}
