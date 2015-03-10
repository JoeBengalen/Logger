<?php
namespace JoeBengalen\Logger\Test;

use JoeBengalen\Logger\Collection;
use Psr\Log\LogLevel;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    protected function getMessageInstance($level = null)
    {
        $mock = $this->getMock('\JoeBengalen\Logger\MessageInterface');
        $mock->method('getLevel')->willReturn($level);
        return $mock;
    }

    public function setUp()
    {
        $this->collection = new Collection();
    }

    public function testAddMessage()
    {
        $this->collection->addMessage($this->getMessageInstance());
    }
   /* TODO : Look how to solve this, code below raises an error in travis!
    public function testAddInvalidMessageInterface()
    {
        $this->setExpectedException('PHPUnit_Framework_Error'); // thrown if a PHP error occurs
        $this->collection->addMessage('invalid');
    }
    */
    public function testGetAllMessages()
    {
        $this->collection->addMessage($this->getMessageInstance(LogLevel::EMERGENCY));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::INFO));

        $result = count($this->collection->getAllMessages());

        $this->assertEquals(2, $result);
    }

    public function testGetEmergencyMessages()
    {
        $this->collection->addMessage($this->getMessageInstance(LogLevel::EMERGENCY));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::INFO));

        $result = count($this->collection->getEmergencyMessages());

        $this->assertEquals(1, $result);
    }

    public function testGeAlertMessages()
    {
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ALERT));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ALERT));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ALERT));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::INFO));

        $result = count($this->collection->getAlertMessages());

        $this->assertEquals(3, $result);
    }

    public function testGetCriticalMessages()
    {
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ALERT));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::CRITICAL));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::CRITICAL));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::CRITICAL));

        $result = count($this->collection->getCriticalMessages());

        $this->assertEquals(3, $result);
    }

    public function testGetErrorMessages()
    {
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ERROR));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ALERT));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ERROR));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::INFO));

        $result = count($this->collection->getErrorMessages());

        $this->assertEquals(2, $result);
    }

    public function testGetWarningMessages()
    {
        $this->collection->addMessage($this->getMessageInstance(LogLevel::WARNING));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ALERT));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ALERT));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ALERT));

        $result = count($this->collection->getWarningMessages());

        $this->assertEquals(1, $result);
    }

    public function testGetNoticeMessages()
    {
        $this->collection->addMessage($this->getMessageInstance(LogLevel::NOTICE));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ALERT));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ERROR));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::NOTICE));

        $result = count($this->collection->getNoticeMessages());

        $this->assertEquals(2, $result);
    }

    public function testGetInfoMessages()
    {
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ALERT));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ALERT));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::ALERT));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::INFO));

        $result = count($this->collection->getInfoMessages());

        $this->assertEquals(1, $result);
    }

    public function testGetDebugMessages()
    {
        $this->collection->addMessage($this->getMessageInstance(LogLevel::DEBUG));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::DEBUG));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::DEBUG));
        $this->collection->addMessage($this->getMessageInstance(LogLevel::INFO));

        $result = count($this->collection->getDebugMessages());

        $this->assertEquals(3, $result);
    }
}