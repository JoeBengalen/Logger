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

    public function InvokableObjectHandler()
    {
        $expectedResult = 'log message';

        $logger = new Logger\Logger([
            new InvokableObject()
        ]);

        $logger->info($expectedResult);

        $this->expectOutputString($expectedResult);
    }
}