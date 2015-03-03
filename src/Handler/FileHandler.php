<?php

namespace JoeBengalen\Logger\Handler;

/**
 * Log handler to log to a file
 */
class FileHandler extends AbstractHandler
{
    protected $file;
    protected $options;

    public function __construct($logFile, array $options = [])
    {
        $this->file = $logFile;
        
        $this->options = array_merge([
            'datetime.format' => 'Y-m-d h:m:s',
        ], $options);
    }

    public function __invoke($level, $message, array $context = [])
    {
        file_put_contents($this->file, $this->format($level, $message, $context), FILE_APPEND);
    }

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