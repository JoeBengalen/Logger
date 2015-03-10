<?php

namespace JoeBengalen\Logger\Test;

use JoeBengalen\Logger\Message;
use Psr\Log\LogLevel;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    public function testEmergencyLevel()
    {
        $level   = LogLevel::EMERGENCY;
        $mess    = 'Emergency level message.';
        $message = new Message($level, $mess);

        $this->assertEquals($level, $message->getLevel());
        $this->assertEquals($mess, $message->getMessage());
        $this->assertEquals([], $message->getContext());
    }

    public function testAlertLevel()
    {
        $level   = LogLevel::ALERT;
        $mess    = 'Alert level message.';
        $message = new Message($level, $mess);

        $this->assertEquals($level, $message->getLevel());
        $this->assertEquals($mess, $message->getMessage());
        $this->assertEquals([], $message->getContext());
    }

    public function testCriticalLevel()
    {
        $level   = LogLevel::CRITICAL;
        $mess    = 'Critical level message.';
        $message = new Message($level, $mess);

        $this->assertEquals($level, $message->getLevel());
        $this->assertEquals($mess, $message->getMessage());
        $this->assertEquals([], $message->getContext());
    }

    public function testErrorLevel()
    {
        $level   = LogLevel::ERROR;
        $mess    = 'Error level message.';
        $message = new Message($level, $mess);

        $this->assertEquals($level, $message->getLevel());
        $this->assertEquals($mess, $message->getMessage());
        $this->assertEquals([], $message->getContext());
    }

    public function testWarningLevel()
    {
        $level   = LogLevel::WARNING;
        $mess    = 'Warning level message.';
        $message = new Message($level, $mess);

        $this->assertEquals($level, $message->getLevel());
        $this->assertEquals($mess, $message->getMessage());
        $this->assertEquals([], $message->getContext());
    }

    public function testNoticeLevel()
    {
        $level   = LogLevel::NOTICE;
        $mess    = 'Notice level message.';
        $message = new Message($level, $mess);

        $this->assertEquals($level, $message->getLevel());
        $this->assertEquals($mess, $message->getMessage());
        $this->assertEquals([], $message->getContext());
    }

    public function testInfoLevel()
    {
        $level   = LogLevel::INFO;
        $mess    = 'Info level message.';
        $message = new Message($level, $mess);

        $this->assertEquals($level, $message->getLevel());
        $this->assertEquals($mess, $message->getMessage());
        $this->assertEquals([], $message->getContext());
    }

    public function testDebugLevel()
    {
        $level   = LogLevel::DEBUG;
        $mess    = 'Debug level message.';
        $message = new Message($level, $mess);

        $this->assertEquals($level, $message->getLevel());
        $this->assertEquals($mess, $message->getMessage());
        $this->assertEquals([], $message->getContext());
    }

    public function testInvalidLevel()
    {
        $this->setExpectedException('\Psr\Log\InvalidArgumentException');

        $level = 'invalid_level';
        $mess  = 'Invalid level message.';
        new Message($level, $mess);
    }

    public function testContext()
    {
        $level   = LogLevel::DEBUG;
        $mess    = 'Debug level message.';
        $context = [false, true, null, 'string', ['array'], 'key' => 'value'];
        $message = new Message($level, $mess, $context);

        $this->assertEquals($level, $message->getLevel());
        $this->assertEquals($mess, $message->getMessage());
        $this->assertEquals($context, $message->getContext());
    }
}