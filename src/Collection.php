<?php
/**
 * JoeBengalen Logger library.
 *
 * @author      Martijn Wennink <joebengalen@gmail.com>
 * @copyright   Copyright (c) 2015 Martijn Wennink
 * @license     https://github.com/JoeBengalen/Logger/blob/master/LICENSE.md (MIT License)
 *
 * @version     0.1.0
 */

namespace JoeBengalen\Logger;

use Psr\Log\LogLevel;

/**
 * Message Collection.
 *
 * Collector of MessageInterface instances, which can be retrieved by their log level
 */
class Collection implements CollectionInterface
{
    /**
     * @var \JoeBengalen\Logger\MessageInterface[] List of messages
     */
    protected $messages = [];

    /**
     * Add a message.
     *
     * @param \JoeBengalen\Logger\MessageInterface $message Log message
     */
    public function addMessage(MessageInterface $message)
    {
        $this->messages[] = $message;
    }

    /**
     * Get all messages.
     *
     * @return \JoeBengalen\Logger\MessageInterface[] All messages
     */
    public function getAllMessages()
    {
        return $this->messages;
    }

    /**
     * Get emergency messages.
     *
     * @return \JoeBengalen\Logger\MessageInterface[] All messages with level emergency
     */
    public function getEmergencyMessages()
    {
        return $this->filterMessagesByLevel(LogLevel::EMERGENCY);
    }

    /**
     * Get alert messages.
     *
     * @return \JoeBengalen\Logger\MessageInterface[] All messages with level alert
     */
    public function getAlertMessages()
    {
        return $this->filterMessagesByLevel(LogLevel::ALERT);
    }

    /**
     * Get critical messages.
     *
     * @return \JoeBengalen\Logger\MessageInterface[] All messages with level critical
     */
    public function getCriticalMessages()
    {
        return $this->filterMessagesByLevel(LogLevel::CRITICAL);
    }

    /**
     * Get error messages.
     *
     * @return \JoeBengalen\Logger\MessageInterface[] All messages with level error
     */
    public function getErrorMessages()
    {
        return $this->filterMessagesByLevel(LogLevel::ERROR);
    }

    /**
     * Get warning messages.
     *
     * @return \JoeBengalen\Logger\MessageInterface[] All messages with level warning
     */
    public function getWarningMessages()
    {
        return $this->filterMessagesByLevel(LogLevel::WARNING);
    }

    /**
     * Get notice messages.
     *
     * @return \JoeBengalen\Logger\MessageInterface[] All messages with level notice
     */
    public function getNoticeMessages()
    {
        return $this->filterMessagesByLevel(LogLevel::NOTICE);
    }

    /**
     * Get info messages.
     *
     * @return \JoeBengalen\Logger\MessageInterface[] All messages with level info
     */
    public function getInfoMessages()
    {
        return $this->filterMessagesByLevel(LogLevel::INFO);
    }

    /**
     * Get debug messages.
     *
     * @return \JoeBengalen\Logger\MessageInterface[] All messages with level debug
     */
    public function getDebugMessages()
    {
        return $this->filterMessagesByLevel(LogLevel::DEBUG);
    }

    /**
     * Get messages of a certain level.
     *
     * @param mixed $level Log level defined in \Psr\Log\LogLevel
     *
     * @return \JoeBengalen\Logger\MessageInterface[] All messages with the given level
     */
    protected function filterMessagesByLevel($level)
    {
        return array_values(array_filter($this->messages, function ($message) use ($level) {
            return $message->getLevel() === $level;
        }));
    }
}