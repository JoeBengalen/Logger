<?php
namespace JoeBengalen\Logger;

use JoeBengalen\Logger\LogMessageInterface;
use Psr\Log\LogLevel;

class Collection
{
    /**
     * @var eBengalen\Logger\LogMessageInterface[] List of log messages 
     */
    protected $logMessages = [];
    
    public function addLogMessage(LogMessageInterface $logMessage)
    {
        $this->logMessages[] = $logMessage;
    }
    
    public function getAllLogMessages()
    {
        return $this->logMessages;
    }
    
    public function getEmergencyLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::EMERGENCY);
    }
    
    public function getAlertLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::ALERT);
    }
    
    public function getCriticalLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::CRITICAL);
    }
    
    public function getErrorLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::ERROR);
    }
    
    public function getWarningLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::WARNING);
    }
    
    public function getNoticeLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::NOTICE);
    }
    
    public function getInfoLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::INFO);
    }
    
    public function getDebugLogMessages()
    {
        return $this->filterLogMessagesByLevel(LogLevel::DEBUG);
    }
    
    protected function filterLogMessagesByLevel($level)
    {
        return array_filter($this->logMessages, function($logMessage) use ($level) {
            return $logMessage->getLevel() === $level;
        });
    }
}