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
namespace JoeBengalen\Logger\Handler;

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
     * @param string    $level      Log level defined in \Psr\Log\LogLevel
     * @param string    $message    Message to log
     * @param mixed[]   $context    Extra information
     */
    public function __invoke($level, $message, array $context = [])
    {
        file_put_contents($this->file, $this->format($level, $message, $context), FILE_APPEND);
    }

    /**
     * Format the message
     * 
     * Adds the datetime, replaces the placeholders in the message and append the 
     * exception (if given) as string to the message.
     * 
     * @param string    $level      Log level defined in \Psr\Log\LogLevel
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