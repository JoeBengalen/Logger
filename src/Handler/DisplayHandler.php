<?php

namespace JoeBengalen\Logger\Handler;

/**
 * Log handler to log to the screen
 */
class DisplayHandler extends AbstractHandler
{
    protected $options;

    public function __construct(array $options = [])
    {
        $this->options = array_merge([
            'datetime.format' => 'Y-m-d h:m:s',
            'dump'            => true
        ], $options);
    }

    public function log($level, $message, array $context = [])
    {
        $interpolatedMessage = $this->interpolate($message, $context);
        $now                 = new \DateTime('NOW');
        echo $now->format($this->options['datetime.format']) . ' ' . strtoupper($level) . ": {$interpolatedMessage}";
        if (isset($context['exception']) && $context['exception'] instanceof \Exception) {
            echo " " . $context['exception'];
            unset($context['exception']);
        }

        if ($this->options['dump']) {
            var_dump($context);
        }
    }
}