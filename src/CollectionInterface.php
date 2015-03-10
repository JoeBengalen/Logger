<?php
/**
 * JoeBengalen Logger library
 * 
 * @author      Martijn Wennink <joebengalen@gmail.com>
 * @copyright   Copyright (c) 2015 Martijn Wennink
 * @license     https://github.com/JoeBengalen/JBLogger/blob/master/LICENSE.md (MIT License)
 * @version     0.1.0
 */
namespace JoeBengalen\JBLogger;

use JoeBengalen\JBLogger\LogMessageInterface;

/**
 * Log Message Interface
 * 
 * Defines a log message collection
 */
interface CollectionInterface
{
    /**
     * Add a log message
     * 
     * @param \JoeBengalen\JBLogger\LogMessageInterface $logMessage LogMessageInterface instance
     */
    public function addLogMessage(LogMessageInterface $logMessage);
}