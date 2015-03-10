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

/**
 * Message Interface.
 *
 * Defines a message collection
 */
interface CollectionInterface
{
    /**
     * Add a message.
     *
     * @param \JoeBengalen\Logger\MessageInterface $message MessageInterface instance
     */
    public function addMessage(MessageInterface $message);
}