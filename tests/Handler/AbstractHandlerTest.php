<?php

use JoeBengalen\Logger\LogMessage;
use Psr\Log\LogLevel;

class AbstractHanderTest extends PHPUnit_Framework_TestCase
{
    public function testInterpolate()
    {        
        $logMessage = new LogMessage(LogLevel::INFO, 'log {replace}', ['replace' => 'message']);
        
        $expected = 'log message';
        
        $result = call_user_func(new InvokableHandler(), $logMessage);
        
        $this->assertEquals($expected, $result);
    }
}
