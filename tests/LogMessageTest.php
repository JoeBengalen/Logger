<?php

use JoeBengalen\Logger\LogMessage;
use Psr\Log\LogLevel;

class LogMessageTest extends PHPUnit_Framework_TestCase
{
    public function testEmergencyLevel()
    {
        $level      = LogLevel::EMERGENCY;
        $message    = 'Emergency level message.';
        $logMessage = new LogMessage($level, $message);

        $this->assertEquals($level, $logMessage->getLevel());
        $this->assertEquals($message, $logMessage->getMessage());
        $this->assertEquals([], $logMessage->getContext());
    }
    
    public function testAlertLevel()
    {
        $level      = LogLevel::ALERT;
        $message    = 'Alert level message.';
        $logMessage = new LogMessage($level, $message);

        $this->assertEquals($level, $logMessage->getLevel());
        $this->assertEquals($message, $logMessage->getMessage());
        $this->assertEquals([], $logMessage->getContext());
    }
    
    public function testCriticalLevel()
    {
        $level      = LogLevel::CRITICAL;
        $message    = 'Critical level message.';
        $logMessage = new LogMessage($level, $message);

        $this->assertEquals($level, $logMessage->getLevel());
        $this->assertEquals($message, $logMessage->getMessage());
        $this->assertEquals([], $logMessage->getContext());
    }
    
    public function testErrorLevel()
    {
        $level      = LogLevel::ERROR;
        $message    = 'Error level message.';
        $logMessage = new LogMessage($level, $message);

        $this->assertEquals($level, $logMessage->getLevel());
        $this->assertEquals($message, $logMessage->getMessage());
        $this->assertEquals([], $logMessage->getContext());
    }
    
    public function testWarningLevel()
    {
        $level      = LogLevel::WARNING;
        $message    = 'Warning level message.';
        $logMessage = new LogMessage($level, $message);

        $this->assertEquals($level, $logMessage->getLevel());
        $this->assertEquals($message, $logMessage->getMessage());
        $this->assertEquals([], $logMessage->getContext());
    }
    
    public function testNoticeLevel()
    {
        $level      = LogLevel::NOTICE;
        $message    = 'Notice level message.';
        $logMessage = new LogMessage($level, $message);

        $this->assertEquals($level, $logMessage->getLevel());
        $this->assertEquals($message, $logMessage->getMessage());
        $this->assertEquals([], $logMessage->getContext());
    }
    
    public function testInfoLevel()
    {
        $level      = LogLevel::INFO;
        $message    = 'Info level message.';
        $logMessage = new LogMessage($level, $message);

        $this->assertEquals($level, $logMessage->getLevel());
        $this->assertEquals($message, $logMessage->getMessage());
        $this->assertEquals([], $logMessage->getContext());
    }
    
    public function testDebugLevel()
    {
        $level      = LogLevel::DEBUG;
        $message    = 'Debug level message.';
        $logMessage = new LogMessage($level, $message);

        $this->assertEquals($level, $logMessage->getLevel());
        $this->assertEquals($message, $logMessage->getMessage());
        $this->assertEquals([], $logMessage->getContext());
    }
    
    public function testInvalidLevel()
    {
        $this->setExpectedException('\Psr\Log\InvalidArgumentException');
        
        $level      = 'invalid_level';
        $message    = 'Invalid level message.';
        $logMessage = new LogMessage($level, $message);
    }
    
    public function testContext()
    {
        $level      = LogLevel::DEBUG;
        $message    = 'Debug level message.';
        $context    = [false, true, null, 'string', ['array'], 'key' => 'value'];
        $logMessage = new LogMessage($level, $message, $context);

        $this->assertEquals($level, $logMessage->getLevel());
        $this->assertEquals($message, $logMessage->getMessage());
        $this->assertEquals($context, $logMessage->getContext());
    }
}