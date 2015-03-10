# Logger
[![Build Status](https://travis-ci.org/JoeBengalen/JBLogger.svg?branch=develop)](https://travis-ci.org/JoeBengalen/JBLogger)

Lightweight [psr-3](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-3-logger-interface.md) logger library.

## Getting started

### Installation

It is recommended to install the package with composer:
```
require: {
    "joebengalen/logger": "*"
}
```

### Usage

```php
use JoeBengalen\Logger\Logger;
use JoeBengalen\Logger\Handler;

// basic instantiation of the logger
$logger = new Logger([
    // callable handlers
]);

// basic usage
$logger->emergency('emergency message');    // System is unusable
$logger->alert('alert message');            // Action must be taken immediately (Example: Entire website down, database unavailable, etc. This should trigger the SMS alerts and wake you up.)
$logger->critical('critical message');      // Critical conditions (Example: Application component unavailable, unexpected exception.)
$logger->error('error message');            // Runtime errors that do not require immediate action but should typically be logged and monitored.
$logger->warning('warning message');        // Exceptional occurrences that are not errors (Example: Use of deprecated APIs, poor use of an API, undesirable things that are not necessarily wrong.)
$logger->notice('notice message');          // Normal but significant events.
$logger->info('info message');              // Interesting events (Example: User logs in, SQL logs.)
$logger->debug('debug message');            // Detailed debug information.
```

#### Context

Along with a log message also a second argument can be passed. This *context* is an array which could contain anything.

The ```$context``` can be used to replace placeholders in the log message.
```php
$logger->info('User {username} created.', ['username' => 'John Doe']);
// -> User John Doe created.
```

The context has a special key *exception* which could be used to pass an ```\Exception```. The handler can recognize the ```\Exception``` and act upon it.
```php
$logger->critical("Unexpected Exception occurred.", ['exception' => new \Exception('Something went horribly wrong :(')]);
```

Aside from the named functionality the context array can be used to pass any data that may be useful for the log message.

### Handlers

Handers are callables registered to the logger. It is up to the user which handler(s) to register. **Note** that there is no default handler. So if none is registered nothing happens. The registered handlers will be called in the order they are given.

#### Shipped handlers
All shipped handlers process *every* log message. There if no filter based on the log level.

##### FileHandler
The ```FileHandler``` is given a file in its initialization and logs all messages into that file.

```php
$logger = new Logger([
    new Handler\FileHandler('default.log')
]);
```

##### DatabaseHandler
The ```DatabaseHandler``` is given ```\PDO``` instance in its initialization and logs all messages into a table.

```php
$logger = new Logger([
    new Handler\DatabaseHander(new \PDO(...));
]);
```

#### Custom handlers

A handler is, simply put, a callable, which is given an instance of ```JoeBengalen\Logger\LogMessageInterface```.
```php
function (\JoeBengalen\Logger\LogMessageInterface $logMessage) { }
```

All shipped handlers are invokable objects, but a handler could as well be an anonymous function, a static class method or any other valid [callable](http://php.net/manual/en/language.types.callable.php).

```php
use JoeBengalen\Logger\LogMessageInterface;
use Psr\Log\LogLevel;

$logger = new Logger([
    
    // anonymous function
    function (LogMessageInterface $logMessage) {
        if ($logMessage->getLevel() === LogLevel::EMERGENCY) {
            // send an email
        }
    },

    // static class method
    ['ClassName', 'staticMethod'] // declared somewhere else
]);
```

**Note** that it is up to the handler to handle the _context_ array properly. (For example, replacing placeholders in the message and recognizing an ```\Exception```)

#### Custom LogMessageInterface factory
The factory to create a LogMessageInterface instance is another callable, registered as $option ```log.message.factory```. This factory is given three arguments. The ```$level```, ```$message``` and ```array $context``` and should return an instance that implements the ```JoeBengalen\Logger\LogMessageInterface```. Apart from that the factory is completely free to return any object (as long as it implements the right interface) it wants and format the given arguments as it pleases.

By default an instance of ```LogMessage``` is returned.

```php
use JoeBengalen\Logger\Logger;
use JoeBengalen\Logger\LogMessage;

$logger = new Logger([
    // handlers
], [

    // LogMessageInterface factory
    'log.message.factory' => function($level, $message, $context) {
        return new LogMessage($level, $message, $context);
    }

]);
```
