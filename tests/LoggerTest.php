<?php
namespace JoeBengalen\Logger\Test;

use JoeBengalen\Logger;
use JoeBengalen\Logger\MessageInterface;
use JoeBengalen\Logger\CollectionInterface;
use Psr\Log\LogLevel;

function namedFunction(MessageInterface $message) {
    echo $message->getMessage();
}

class DummyHandler
{
    public static function staticEchoMessage(MessageInterface $message)
    {
        echo $message->getMessage();
    }
    
    public static function staticEchoLevelMessage(MessageInterface $message)
    {
        echo "{$message->getLevel()}::{$message->getMessage()}";
    }

    public function echoMessage(MessageInterface $message)
    {
        echo $message->getMessage();
    }
}

class InvokableObject
{
    public function __invoke(MessageInterface $message)
    {
        echo $message->getMessage();
    }
}

class LoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testInitialization()
    {
        $logger = new Logger\Logger();

        $this->assertInstanceOf('\JoeBengalen\Logger\Logger', $logger);
    }

    public function testAnonymousHandler()
    {
        $expectedResult = 'message';

        $logger = new Logger\Logger([
            function (MessageInterface $message) {
                echo $message->getMessage();
            }
        ]);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }

    public function testNamedFunctionHandler()
    {
        $expectedResult = 'message';

        $logger = new Logger\Logger(['\JoeBengalen\Logger\Test\namedFunction']);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }

    public function testStaticMethodHandler()
    {
        $expectedResult = 'message';

        $logger = new Logger\Logger([
            ['\JoeBengalen\Logger\Test\DummyHandler', 'staticEchoMessage']
        ]);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }

    public function testObjectMethodHandler()
    {
        $expectedResult = 'message';

        $logger = new Logger\Logger([
            [new \JoeBengalen\Logger\Test\DummyHandler, 'echoMessage']
        ]);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }

    public function testInvokableObjectHandler()
    {
        $expectedResult = 'message';

        $logger = new Logger\Logger([
            new InvokableObject()
        ]);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }
    
    public function testNonCallableHandlerException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        
        $logger = new Logger\Logger([
            'nonExistingHandler'
        ]);
    }
    
    public function testDefaultCollection()
    {
        $logger = new Logger\Logger();

        $this->assertTrue($logger->getCollection() instanceof CollectionInterface);
    }
    
    public function testCustomCollection()
    {
        $mock = $this->getMock('\JoeBengalen\Logger\CollectionInterface');

        $logger = new Logger\Logger([], [
            'collection.factory' => function() use ($mock) {
                return $mock;
            }
        ]);

        $this->assertEquals($mock, $logger->getCollection());
    }
    
    public function testNoCollection()
    {
        $logger = new Logger\Logger([], [
            'collection.factory' => null
        ]);

        $this->assertNull($logger->getCollection());
    }
    
    public function testNonCallableCollectionFactory()
    {
        $this->setExpectedException('InvalidArgumentException');
                
        $logger = new Logger\Logger([], [
            'collection.factory' => false
        ]);
    }
    
    public function testNonInterfaceReturningCollectionFactory()
    {
        $this->setExpectedException('UnexpectedValueException');
                
        $logger = new Logger\Logger([], [
            'collection.factory' => function () {
                return 'invalid';
            }
        ]);
    }
    
    public function testLogLevelDebug()
    {
        $message = 'message';
        $expectedResult = LogLevel::DEBUG. '::' . $message;

        $logger = new Logger\Logger([
            ['\JoeBengalen\Logger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->debug($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelInfo()
    {
        $message = 'message';
        $expectedResult = LogLevel::INFO. '::' . $message;

        $logger = new Logger\Logger([
            ['\JoeBengalen\Logger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->info($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelNotice()
    {
        $message = 'message';
        $expectedResult = LogLevel::NOTICE. '::' . $message;

        $logger = new Logger\Logger([
            ['\JoeBengalen\Logger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->notice($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelAlert()
    {
        $message = 'message';
        $expectedResult = LogLevel::ALERT. '::' . $message;

        $logger = new Logger\Logger([
            ['\JoeBengalen\Logger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->alert($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelWarning()
    {
        $message = 'message';
        $expectedResult = LogLevel::WARNING. '::' . $message;

        $logger = new Logger\Logger([
            ['\JoeBengalen\Logger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->warning($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelError()
    {
        $message = 'message';
        $expectedResult = LogLevel::ERROR. '::' . $message;

        $logger = new Logger\Logger([
            ['\JoeBengalen\Logger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->error($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelCritical()
    {
        $message = 'message';
        $expectedResult = LogLevel::CRITICAL. '::' . $message;

        $logger = new Logger\Logger([
            ['\JoeBengalen\Logger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->critical($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelEmergency()
    {
        $message = 'message';
        $expectedResult = LogLevel::EMERGENCY. '::' . $message;

        $logger = new Logger\Logger([
            ['\JoeBengalen\Logger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->emergency($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testInvalidLogLevelException()
    {
        $message = 'message';
        
        $logger = new Logger\Logger([
            ['\JoeBengalen\Logger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);
        
        $this->setExpectedException('\Psr\Log\InvalidArgumentException');

        $logger->log('invalid', $message);
    }

    public function testLogCustomMessageFactory()
    {
        $phrase = 'custom_log_message_factory_called';
        
        $logger = new Logger\Logger([], [
            'message.factory' => function () use ($phrase) {
                echo $phrase;
                return $this->getMock('\JoeBengalen\Logger\MessageInterface');
            }
        ]);
        
        // make sure the factory is called
        $logger->debug('debug message');
        
        // check if the original message aquals the one set by the handler
        $this->expectOutputString($phrase);
        
    }

    public function testLogCustomMessageFactoryNonCallable()
    {
        $this->setExpectedException('\InvalidArgumentException');
        
        new Logger\Logger([], [
            'message.factory' => null
        ]);
    }

    public function testLogCustomMessageFactoryNoMessageReturned()
    {
        $this->setExpectedException('\UnexpectedValueException');
        
        $logger = new Logger\Logger([], [
            'message.factory' => function () {
                return null;
            }
        ]);
        
        $logger->debug('debug message');
    }
}