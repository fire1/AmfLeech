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
 * Class SessionEvent
 * @package Fire1\AmfLeech\Utils
 */
class SessionEvent
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
     * Defines explicit type values that trigger error
     * @type array
     */
    static $EXPLICIT_CONTAINER = [
        "flex.messaging.messages.ErrorMessage",
        "flex.messaging.messages.AcknowledgeMessage",
    ];

    /**
     * SessionEvent constructor that defines session to the server.
     * @param Read $read
     * @param bool $sessionId
     */
    public function __construct( Read $read, $sessionId = false )
    {
        if ($this->isModeratorErrorMessage($read) && $sessionId !== false)
            $this->setCookie($sessionId);
    }

    /** @deprecated  use $this->isModeratorErrorMessage
     * @param Read $read
     * @return bool
     */
    protected function isModeratorExist( Read $read )
    {
        return isset( $read->getData()->body->mandator ) ? true : false;
    }

    /**
     * Checks read container for error message
     * @param Read $read
     * @return bool
     */
    public function isModeratorErrorMessage( Read $read )
    {
        if (isset( $read->getData()->{self::ERROR_EXPLICIT_NAME} ))
            in_array($read->getData()->{self::ERROR_EXPLICIT_NAME}, static::$EXPLICIT_CONTAINER) ? false : true;
        return false;
    }

    /**
     * Sets cookie session ID
     * @param string $sessionId
     */
    protected function setCookie( $sessionId )
    {
        SendRequest::$cookie = self::STR_COOKIE . $sessionId;
    }

}