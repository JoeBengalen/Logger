<?php
namespace JoeBengalen\JBLogger\Test;

use JoeBengalen\JBLogger;
use JoeBengalen\JBLogger\LogMessageInterface;
use JoeBengalen\JBLogger\CollectionInterface;
use Psr\Log\LogLevel;

function namedFunction(LogMessageInterface $logMessage) {
    echo $logMessage->getMessage();
}

class DummyHandler
{
    public static function staticEchoMessage(LogMessageInterface $logMessage)
    {
        echo $logMessage->getMessage();
    }
    
    public static function staticEchoLevelMessage(LogMessageInterface $logMessage)
    {
        echo "{$logMessage->getLevel()}::{$logMessage->getMessage()}";
    }

    public function echoMessage(LogMessageInterface $logMessage)
    {
        echo $logMessage->getMessage();
    }
}

class InvokableObject
{
    public function __invoke(LogMessageInterface $logMessage)
    {
        echo $logMessage->getMessage();
    }
}

class LoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testInitialization()
    {
        $logger = new JBLogger\Logger();

        $this->assertInstanceOf('\JoeBengalen\JBLogger\Logger', $logger);
    }

    public function testAnonymousHandler()
    {
        $expectedResult = 'log message';

        $logger = new JBLogger\Logger([
            function (LogMessageInterface $logMessage) {
                echo $logMessage->getMessage();
            }
        ]);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }

    public function testNamedFunctionHandler()
    {
        $expectedResult = 'log message';

        $logger = new JBLogger\Logger(['\JoeBengalen\JBLogger\Test\namedFunction']);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }

    public function testStaticMethodHandler()
    {
        $expectedResult = 'log message';

        $logger = new JBLogger\Logger([
            ['\JoeBengalen\JBLogger\Test\DummyHandler', 'staticEchoMessage']
        ]);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }

    public function testObjectMethodHandler()
    {
        $expectedResult = 'log message';

        $logger = new JBLogger\Logger([
            [new \JoeBengalen\JBLogger\Test\DummyHandler, 'echoMessage']
        ]);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }

    public function testInvokableObjectHandler()
    {
        $expectedResult = 'log message';

        $logger = new JBLogger\Logger([
            new InvokableObject()
        ]);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }
    
    public function testNonCallableHandlerException()
    {
        $this->setExpectedException('\InvalidArgumentException');
        
        $logger = new JBLogger\Logger([
            'nonExistingHandler'
        ]);
    }
    
    public function testDefaultCollection()
    {
        $logger = new JBLogger\Logger();

        $this->assertTrue($logger->getCollection() instanceof CollectionInterface);
    }
    
    public function testCustomCollection()
    {
        $mock = $this->getMock('\JoeBengalen\JBLogger\CollectionInterface');

        $logger = new JBLogger\Logger([], [
            'collection.factory' => function() use ($mock) {
                return $mock;
            }
        ]);

        $this->assertEquals($mock, $logger->getCollection());
    }
    
    public function testNoCollection()
    {
        $logger = new JBLogger\Logger([], [
            'collection.factory' => null
        ]);

        $this->assertNull($logger->getCollection());
    }
    
    public function testNonCallableCollectionFactory()
    {
        $this->setExpectedException('InvalidArgumentException');
                
        $logger = new JBLogger\Logger([], [
            'collection.factory' => false
        ]);
    }
    
    public function testNonInterfaceReturningCollectionFactory()
    {
        $this->setExpectedException('RuntimeException');
                
        $logger = new JBLogger\Logger([], [
            'collection.factory' => function () {
                return 'invalid';
            }
        ]);
    }
    
    public function testLogLevelDebug()
    {
        $message = 'log message';
        $expectedResult = LogLevel::DEBUG. '::' . $message;

        $logger = new JBLogger\Logger([
            ['\JoeBengalen\JBLogger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->debug($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelInfo()
    {
        $message = 'log message';
        $expectedResult = LogLevel::INFO. '::' . $message;

        $logger = new JBLogger\Logger([
            ['\JoeBengalen\JBLogger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->info($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelNotice()
    {
        $message = 'log message';
        $expectedResult = LogLevel::NOTICE. '::' . $message;

        $logger = new JBLogger\Logger([
            ['\JoeBengalen\JBLogger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->notice($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelAlert()
    {
        $message = 'log message';
        $expectedResult = LogLevel::ALERT. '::' . $message;

        $logger = new JBLogger\Logger([
            ['\JoeBengalen\JBLogger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->alert($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelWarning()
    {
        $message = 'log message';
        $expectedResult = LogLevel::WARNING. '::' . $message;

        $logger = new JBLogger\Logger([
            ['\JoeBengalen\JBLogger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->warning($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelError()
    {
        $message = 'log message';
        $expectedResult = LogLevel::ERROR. '::' . $message;

        $logger = new JBLogger\Logger([
            ['\JoeBengalen\JBLogger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->error($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelCritical()
    {
        $message = 'log message';
        $expectedResult = LogLevel::CRITICAL. '::' . $message;

        $logger = new JBLogger\Logger([
            ['\JoeBengalen\JBLogger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->critical($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelEmergency()
    {
        $message = 'log message';
        $expectedResult = LogLevel::EMERGENCY. '::' . $message;

        $logger = new JBLogger\Logger([
            ['\JoeBengalen\JBLogger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->emergency($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testInvalidLogLevelException()
    {
        $message = 'log message';
        
        $logger = new JBLogger\Logger([
            ['\JoeBengalen\JBLogger\Test\DummyHandler', 'staticEchoLevelMessage']
        ]);
        
        $this->setExpectedException('\Psr\Log\InvalidArgumentException');

        $logger->log('invalid', $message);
    }

    public function testLogCustomLogMessageFactory()
    {
        $phrase = 'custom_log_message_factory_called';
        
        $logger = new JBLogger\Logger([], [
            'log.message.factory' => function () use ($phrase) {
                echo $phrase;
                return $this->getMock('\JoeBengalen\JBLogger\LogMessageInterface');
            }
        ]);
        
        // make sure the factory is called
        $logger->debug('debug message');
        
        // check if the original logMessage aquals the one set by the handler
        $this->expectOutputString($phrase);
        
    }

    public function testLogCustomLogMessageFactoryNonCallable()
    {
        $this->setExpectedException('\InvalidArgumentException');
        
        new JBLogger\Logger([], [
            'log.message.factory' => null
        ]);
    }

    public function testLogCustomLogMessageFactoryNoLogMessageReturned()
    {
        $this->setExpectedException('\RuntimeException');
        
        $logger = new JBLogger\Logger([], [
            'log.message.factory' => function () {
                return null;
            }
        ]);
        
        $logger->debug('debug message');
    }
}