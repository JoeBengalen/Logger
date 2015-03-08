<?php
/**
 * JoeBengalen Logger library
 * 
 * @author      Martijn Wennink <joebengalen@gmail.com>
 * @copyright   Copyright (c) 2015 Martijn Wennink
 * @license     https://github.com/JoeBengalen/Logger/blob/master/LICENSE.md (MIT License)
 * @version     0.1.0
 */
namespace JoeBengalen\Logger;

use JoeBengalen\Logger\LogMessageInterface;
use Psr\Log\LogLevel;

/**
 * LogMessage Collection
 * 
 * Collector of LogMessageInterface instances, which can be retrieved by their log level
 */
class Collection implements CollectionInterface
{
    /**
     * @var \JoeBengalen\Logger\LogMessageInterface[] List of log messages 
     */
    protected $logMessages = [];
    
    /**
     * Add a log message
     * 
     * @param \JoeBengalen\Logger\LogMessageInterface $logMessage Log message
     */
    public function addLogMessage(LogMessageInterface $logMessage)
    {
        $this->logMessages[] = $logMessage;
    }
    
    /**
     * Get all log messages
     * 
     * @return \JoeBengalen\Logger\LogMessageInterface[] All log messages
     */
    public function getAllLogMessages()
    {
        return $this->logMessages;
    }
    
    /**
     * Get emergency log messages
     * 
     * @return \JoeBengalen\Logger\LogMessageInterface[] All log messages with level emergency
     */
    public function getEmergencyLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::EMERGENCY);
    }
    
    /**
     * Get alert log messages
     * 
     * @return \JoeBengalen\Logger\LogMessageInterface[] All log messages with level alert
     */
    public function getAlertLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::ALERT);
    }
    
    /**
     * Get critical log messages
     * 
     * @return \JoeBengalen\Logger\LogMessageInterface[] All log messages with level critical
     */
    public function getCriticalLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::CRITICAL);
    }
    
    /**
     * Get error log messages
     * 
     * @return \JoeBengalen\Logger\LogMessageInterface[] All log messages with level error
     */
    public function getErrorLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::ERROR);
    }
    
    /**
     * Get warning log messages
     * 
     * @return \JoeBengalen\Logger\LogMessageInterface[] All log messages with level warning
     */
    public function getWarningLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::WARNING);
    }
    
    /**
     * Get notice log messages
     * 
     * @return \JoeBengalen\Logger\LogMessageInterface[] All log messages with level notice
     */
    public function getNoticeLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::NOTICE);
    }
    
    /**
     * Get info log messages
     * 
     * @return \JoeBengalen\Logger\LogMessageInterface[] All log messages with level info
     */
    public function getInfoLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::INFO);
    }
    
    /**
     * Get debug log messages
     * 
     * @return \JoeBengalen\Logger\LogMessageInterface[] All log messages with level debug
     */
    public function getDebugLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::DEBUG);
    }
    
    /**
     * Get log messages of a certain level
     * 
     * @param mixed $level Log level defined in \Psr\Log\LogLevel
     * 
     * @return \JoeBengalen\Logger\LogMessageInterface[] All log messages with the given level
     */
    protected function filterLogMessagesByLevel($level)
    {
        return array_values(array_filter($this->logMessages, function($logMessage) use ($level) {
            return $logMessage->getLevel() === $level;
        }));
    }
}