<?php
namespace JoeBengalen\Logger\Test\Handler;

use JoeBengalen\Logger\Handler\CollectionHandler;
use Psr\Log\LogLevel;

class CollectionHandlerTest extends \PHPUnit_Framework_TestCase
{
    protected $collectionHandler;
    
    protected function getMessageInstance($level = null)
    {
        $mock = $this->getMock('\JoeBengalen\Logger\MessageInterface');
        $mock->method('getLevel')->willReturn($level);
        return $mock;
    }

    public function setUp()
    {
        $this->collectionHandler = new CollectionHandler();
    }

    public function testInvokingHandler()
    {
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance()]);
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
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::EMERGENCY)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::INFO)]);

        $result = count($this->collectionHandler->getAllMessages());

        $this->assertEquals(2, $result);
    }

    public function testGetEmergencyMessages()
    {
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::EMERGENCY)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::INFO)]);

        $result = count($this->collectionHandler->getEmergencyMessages());

        $this->assertEquals(1, $result);
    }

    public function testGeAlertMessages()
    {
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ALERT)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ALERT)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ALERT)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::INFO)]);

        $result = count($this->collectionHandler->getAlertMessages());

        $this->assertEquals(3, $result);
    }

    public function testGetCriticalMessages()
    {
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ALERT)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::CRITICAL)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::CRITICAL)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::CRITICAL)]);

        $result = count($this->collectionHandler->getCriticalMessages());

        $this->assertEquals(3, $result);
    }

    public function testGetErrorMessages()
    {
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ERROR)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ALERT)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ERROR)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::INFO)]);

        $result = count($this->collectionHandler->getErrorMessages());

        $this->assertEquals(2, $result);
    }

    public function testGetWarningMessages()
    {
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::WARNING)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ALERT)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ALERT)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ALERT)]);

        $result = count($this->collectionHandler->getWarningMessages());

        $this->assertEquals(1, $result);
    }

    public function testGetNoticeMessages()
    {
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::NOTICE)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ALERT)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ERROR)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::NOTICE)]);

        $result = count($this->collectionHandler->getNoticeMessages());

        $this->assertEquals(2, $result);
    }

    public function testGetInfoMessages()
    {
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ALERT)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ALERT)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::ALERT)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::INFO)]);

        $result = count($this->collectionHandler->getInfoMessages());

        $this->assertEquals(1, $result);
    }

    public function testGetDebugMessages()
    {
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::DEBUG)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::DEBUG)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::DEBUG)]);
        call_user_func_array($this->collectionHandler, [$this->getMessageInstance(LogLevel::INFO)]);

        $result = count($this->collectionHandler->getDebugMessages());

        $this->assertEquals(3, $result);
    }
}