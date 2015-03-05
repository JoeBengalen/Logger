<?php

use JoeBengalen\Logger;
use Psr\Log\LogLevel;

function namedFunction($level, $message, array $context)
{
    echo $message;
}

class DummyHandler
{
    public static function staticEchoMessage($level, $message, array $context)
    {
        echo $message;
    }
    
    public static function staticEchoLevelMessage($level, $message, array $context)
    {
        echo "$level::$message";
    }

    public function echoMessage($level, $message, array $context)
    {
        echo $message;
    }
}

class InvokableObject
{
    public function __invoke($level, $message, array $context)
    {
        echo $message;
    }
}

class LoggerTest extends PHPUnit_Framework_TestCase
{
    public function testInitialization()
    {
        $logger = new Logger\Logger();

        $this->assertInstanceOf('JoeBengalen\Logger\Logger', $logger);
    }

    public function testAnonymousHandler()
    {
        $expectedResult = 'log message';

        $logger = new Logger\Logger([
            function ($level, $message, array $context) {
                echo $message;
            }
        ]);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }

    public function testNamedFunctionHandler()
    {
        $expectedResult = 'log message';

        $logger = new Logger\Logger(['namedFunction']);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }

    public function testStaticMethodHandler()
    {
        $expectedResult = 'log message';

        $logger = new Logger\Logger([
            ['\DummyHandler', 'staticEchoMessage']
        ]);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }

    public function testObjectMethodHandler()
    {
        $expectedResult = 'log message';

        $logger = new Logger\Logger([
            [new DummyHandler, 'echoMessage']
        ]);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }

    public function testInvokableObjectHandler()
    {
        $expectedResult = 'log message';

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
    
    public function testLogLevelDebug()
    {
        $message = 'log message';
        $expectedResult = LogLevel::DEBUG. '::' . $message;

        $logger = new Logger\Logger([
            ['\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->debug($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelInfo()
    {
        $message = 'log message';
        $expectedResult = LogLevel::INFO. '::' . $message;

        $logger = new Logger\Logger([
            ['\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->info($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelNotice()
    {
        $message = 'log message';
        $expectedResult = LogLevel::NOTICE. '::' . $message;

        $logger = new Logger\Logger([
            ['\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->notice($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelAlert()
    {
        $message = 'log message';
        $expectedResult = LogLevel::ALERT. '::' . $message;

        $logger = new Logger\Logger([
            ['\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->alert($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelWarning()
    {
        $message = 'log message';
        $expectedResult = LogLevel::WARNING. '::' . $message;

        $logger = new Logger\Logger([
            ['\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->warning($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelError()
    {
        $message = 'log message';
        $expectedResult = LogLevel::ERROR. '::' . $message;

        $logger = new Logger\Logger([
            ['\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->error($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelCritical()
    {
        $message = 'log message';
        $expectedResult = LogLevel::CRITICAL. '::' . $message;

        $logger = new Logger\Logger([
            ['\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->critical($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testLogLevelEmergency()
    {
        $message = 'log message';
        $expectedResult = LogLevel::EMERGENCY. '::' . $message;

        $logger = new Logger\Logger([
            ['\DummyHandler', 'staticEchoLevelMessage']
        ]);

        $logger->emergency($message);

        $this->expectOutputString($expectedResult);
    }
    
    public function testInvalidLogLevelException()
    {
        $message = 'log message';
        
        $logger = new Logger\Logger([
            ['\DummyHandler', 'staticEchoLevelMessage']
        ]);
        
        $this->setExpectedException('\Psr\Log\InvalidArgumentException');

        $logger->log('invalid', $message);
    }
}