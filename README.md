# Logger
[![Build Status](https://secure.travis-ci.org/JoeBengalen/Logger.png)](http://travis-ci.org/JoeBengalen/Logger)

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
$logger->debug('debug message');
$logger->info('info message');
$logger->notice('notice message');
$logger->alert('alert message');
$logger->warning('warning message');
$logger->error('error message');
$logger->critical('critical message');
$logger->emergency('emergency message');
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

##### ErrorLogHandler
The ```ErrorLogHandler``` makes use of PHPs default ```error_log``` function. This way it acts the same as the default error reporting would do.

```php
$logger = new Logger([
    new Handler\ErrorLogHandler()
]);
```

##### FileHandler
The ```FileHandler``` is given a file in its initialization and logs all messages into that file.

```php
$logger = new Logger([
    new Handler\FileHandler('default.log')
]);
```

##### DisplayHandler
Do you want to view the log message on the screeen, then use can use the ```DisplayHandler``` which puts the logs message to the screen.

```php
$logger = new Logger([
    new Handler\DisplayHandler()
]);
```

#### Custom handlers

A handler is, simply put, a callable, which is given three arguments, following the PSR-3 Logging Interface.
```php
function ($level, $message, array $context) { }
```

The ```$level``` is a log level defined in ```Psr\Log\LogLevel```, the ```$message``` is a string containing the log message and ```$context``` is an array which can contain anything. It is up to the handler to decide, based on the log level, whether to do its task or not. For example, a mail handler may only send an email if an emergency occurs.

All shipped handlers are invokable objects, but a handler could as well be an anonymous function, a static class method or any other valid [callable](http://php.net/manual/en/language.types.callable.php).

```php
use Psr\Log\LogLevel;

$logger = new Logger([
    
    // anonymous function
    function ($level, $message, array $context) {
        if ($level === LogLevel::EMERGENCY) {
            // send an email
        }
    },

    // static class method
    ['ClassName', 'staticMethod'] // declared somewhere else
]);
```

**Note** that it is up to the handler to handle the ```$context``` array properly. (For example, replacing placeholders in the message and recognizing an ```\Exception```)
