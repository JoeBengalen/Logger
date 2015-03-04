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
 * Database log handler
 * 
 * Database log handler thats uses a \PDO instance. All log levels will be logged.
 */
class PdoHandler extends AbstractHandler
{
    /**
     * @var \PDO Connection instance
     */
    protected $pdo;
    
    /**
     * @var array $options {
     *      @var string $table              Table name
     *      @var string $column.datetime    Datetime column name
     *      @var string $column.level       Level column name
     *      @var string $column.message     Message column name
     *      @var string $column.context     Context column name
     * }
     */
    protected $options;

    /**
     * Create PDO log handler
     * 
     * This handler logs the message to a database
     * 
     * @param \PDO  $pdo        \PDO instance
     * @param array $options (optional) {
     *      @var string $table              Table name
     *      @var string $column.datetime    Datetime column name
     *      @var string $column.level       Level column name
     *      @var string $column.message     Message column name
     *      @var string $column.context     Context column name
     * }
     */
    public function __construct(\PDO $pdo, array $options = [])
    {
        $this->pdo = $pdo;

        $this->options = array_merge([
            'table'           => 'logs',
            'column.datetime' => 'datetime',
            'column.level'    => 'level',
            'column.message'  => 'message',
            'column.context'  => 'context'
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
        $sql = "INSERT INTO {$this->options['table']} ({$this->options['column.datetime']}, {$this->options['column.level']}, {$this->options['column.message']}, {$this->options['column.context']}) VALUES (NOW(), ?, ?, ?)";
        $sth = $this->pdo->prepare($sql);

        $interpolatedMessage = $this->interpolate($message, $context);

        if (isset($context['exception']) && $context['exception'] instanceof \Exception) {
            $interpolatedMessage .= " " . (string) $context['exception'];
            unset($context['exception']);
        }

        $sth->execute([
            $level,
            $interpolatedMessage,
            json_encode($context)
        ]);
    }
}