<?php
/**
 * Created by PhpStorm.
 * Author: Angel Zaprianov <me@fire1.eu>
 * Date: 3/23/16
 * Time: 8:57 AM
 */

namespace Fire1\AmfLeech\Event;


use Fire1\AmfLeech\Curl\SendRequest;
use Fire1\AmfLeech\Utils\Messaging\Read;

/**
 * Class EventCookie
 * @package Fire1\AmfLeech\Utils
 */
class EventCookie
{
    /**
     * Cookie string for header
     */
    const STR_COOKIE = 'JSESSIONID=';

    /**
     * Defines object explicit string name for error
     */
    const ERROR_EXPLICIT_NAME = "_explicitType";
    /**
     * Defines explicit type value to trigger error
     */
    const ERROR_EXPLICIT_TYPE = "flex.messaging.messages.ErrorMessage";

    /**
     * @param Read $read
     */
    public function __construct(Read $read)
    {

        if ($this->isModeratorExist($read))
            $this->setCookie($read);
    }

    /**
     * @param Read $read
     * @return bool
     */
    protected function isModeratorExist(Read $read)
    {
        return isset($read->getData()->body->mandator) ? true : false;
    }

    /**
     * @param Read $read
     */
    protected function setCookie(Read $read)
    {
        SendRequest::$cookie = self::STR_COOKIE . $read->getData()->body->mandator->sessionId;
    }

}