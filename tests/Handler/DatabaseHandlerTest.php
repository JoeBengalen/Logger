<?php

use JoeBengalen\Logger\Handler\DatabaseHandler;
use Psr\Log\LogLevel;

class PdoMock extends \PDO
{
    public function __construct()
    {
        //parent::__construct($dsn, $username, $passwd, $options);
    }
    
    public function prepare($statement, array $driver_options = [])
    {
        $this->statement = $statement;
        return $this;
    }
    
    public function execute(array $params)
    {
        $this->params = $params;
        return $this;
    }
}

class DatabaseHandlerTest extends PHPUnit_Framework_TestCase
{
    public function testInvoke()
    {
        $handler = new DatabaseHandler(new PdoMock([]));
        //$handler(LogLevel::INFO, 'test message', [1,2,3]);
    }
}
