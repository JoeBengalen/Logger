<?php
namespace JoeBengalen\Logger\Test;

use JoeBengalen\Logger\Collection;
use Psr\Log\LogLevel;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    protected function getLogMessageInstance($level = null)
    {
        $mock = $this->getMock('\JoeBengalen\Logger\LogMessageInterface');
        $mock->method('getLevel')->willReturn($level);
        return $mock;
    }

    public function setUp()
    {
        $this->collection = new Collection();
    }

    public function testAddLogMessage()
    {
        $this->collection->addLogMessage($this->getLogMessageInstance());
    }
   /* TODO : Look how to solve this, code below raises an error in travis!
    public function testAddInvalidLogMessageInterface()
    {
        $this->setExpectedException('PHPUnit_Framework_Error'); // thrown if a PHP error occurs
        $this->collection->addLogMessage('invalid');
    }
    */
    public function testGetAllLogMessages()
    {
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::EMERGENCY));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::INFO));

        $result = count($this->collection->getAllLogMessages());

        $this->assertEquals(2, $result);
    }

    public function testGetEmergencyLogMessages()
    {
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::EMERGENCY));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::INFO));

        $result = count($this->collection->getEmergencyLogMessages());

        $this->assertEquals(1, $result);
    }

    public function testGeAlertLogMessages()
    {
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ALERT));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ALERT));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ALERT));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::INFO));

        $result = count($this->collection->getAlertLogMessages());

        $this->assertEquals(3, $result);
    }

    public function testGetCriticalLogMessages()
    {
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ALERT));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::CRITICAL));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::CRITICAL));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::CRITICAL));

        $result = count($this->collection->getCriticalLogMessages());

        $this->assertEquals(3, $result);
    }

    public function testGetErrorLogMessages()
    {
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ERROR));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ALERT));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ERROR));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::INFO));

        $result = count($this->collection->getErrorLogMessages());

        $this->assertEquals(2, $result);
    }

    public function testGetWarningLogMessages()
    {
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::WARNING));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ALERT));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ALERT));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ALERT));

        $result = count($this->collection->getWarningLogMessages());

        $this->assertEquals(1, $result);
    }

    public function testGetNoticeLogMessages()
    {
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::NOTICE));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ALERT));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ERROR));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::NOTICE));

        $result = count($this->collection->getNoticeLogMessages());

        $this->assertEquals(2, $result);
    }

    public function testGetInfoLogMessages()
    {
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ALERT));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ALERT));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::ALERT));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::INFO));

        $result = count($this->collection->getInfoLogMessages());

        $this->assertEquals(1, $result);
    }

    public function testGetDebugLogMessages()
    {
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::DEBUG));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::DEBUG));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::DEBUG));
        $this->collection->addLogMessage($this->getLogMessageInstance(LogLevel::INFO));

        $result = count($this->collection->getDebugLogMessages());

        $this->assertEquals(3, $result);
    }
}