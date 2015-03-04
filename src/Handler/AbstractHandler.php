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
