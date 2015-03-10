<?php
namespace JoeBengalen\Logger\Test\Handler;

use JoeBengalen\Logger\Message;
use Psr\Log\LogLevel;

class AbstractHanderTest extends \PHPUnit_Framework_TestCase
{
    public function testInterpolate()
    {        
        $message = new Message(LogLevel::INFO, 'log {replace}', ['replace' => 'message']);
        
        $expected = 'log message';
        
        $result = call_user_func(new InvokableHandler(), $message);
        
        $this->assertEquals($expected, $result);
    }
}