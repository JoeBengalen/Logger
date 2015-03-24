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
        call_user_func($this->collectionHandler, $this->getMessageInstance());
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
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::EMERGENCY));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::INFO));

        $messages = $this->collectionHandler->getAllMessages();

        $this->assertCount(2, $messages);
    }

    public function testGetEmergencyMessages()
    {
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::EMERGENCY));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::INFO));

        $messages = $this->collectionHandler->getEmergencyMessages();

        $this->assertCount(1, $messages);
    }

    public function testGeAlertMessages()
    {
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ALERT));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ALERT));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ALERT));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::INFO));

        $messages = $this->collectionHandler->getAlertMessages();

        $this->assertCount(3, $messages);
    }

    public function testGetCriticalMessages()
    {
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ALERT));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::CRITICAL));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::CRITICAL));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::CRITICAL));

        $messages = $this->collectionHandler->getCriticalMessages();

        $this->assertCount(3, $messages);
    }

    public function testGetErrorMessages()
    {
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ERROR));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ALERT));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ERROR));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::INFO));

        $messages = $this->collectionHandler->getErrorMessages();

        $this->assertCount(2, $messages);
    }

    public function testGetWarningMessages()
    {
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::WARNING));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ALERT));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ALERT));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ALERT));

        $messages = $this->collectionHandler->getWarningMessages();

        $this->assertCount(1, $messages);
    }

    public function testGetNoticeMessages()
    {
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::NOTICE));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ALERT));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ERROR));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::NOTICE));

        $messages = $this->collectionHandler->getNoticeMessages();

        $this->assertCount(2, $messages);
    }

    public function testGetInfoMessages()
    {
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ALERT));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ALERT));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::ALERT));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::INFO));

        $messages = $this->collectionHandler->getInfoMessages();

        $this->assertCount(1, $messages);
    }

    public function testGetDebugMessages()
    {
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::DEBUG));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::DEBUG));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::DEBUG));
        call_user_func($this->collectionHandler, $this->getMessageInstance(LogLevel::INFO));

        $messages = $this->collectionHandler->getDebugMessages();

        $this->assertCount(3, $messages);
    }
}