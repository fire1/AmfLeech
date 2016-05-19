<?php
/**
 * Created by PhpStorm.
 * Author: Angel Zaprianov <me@fire1.eu>
 * Date: 3/21/16
 * Time: 10:41 AM
 */

namespace Fire1\AmfLeech\Utils;


use Fire1\AmfLeech\Core\AmfStream;
use Fire1\AmfLeech\Core\AmfPacket;
use Fire1\AmfLeech\Core\AmfSerialize;
use Fire1\AmfLeech\Core\AmfDeserialize;
use Fire1\AmfLeech\Core\Interfaces\AmfStreamInterface;
use Fire1\AmfLeech\Utils\Interfaces\AmfContainerInterface;
use Fire1\AmfLeech\Utils\Messaging\Read;

/**
 * Class AmfContainer
 * @package Fire1\AmfLeech\Utils
 */
class AmfContainer implements AmfContainerInterface, AmfStreamInterface
{
    /**
     * Defines object explicit string name for error
     */
    public static $STRING_EXPLICIT_NAME = "_explicitType";

    /**
     * Defines explicit type values that trigger error
     * @type array
     */
    public static $ERROR_EXPLICIT_CONTAINER = array(
        0 => "flex.messaging.messages.ErrorMessage",
    );

    /**
     * Defines explicit type values for accepted message
     * @type array
     */
    public static $ACCEPT_EXPLICIT_CONTAINER = array(
        1 => "flex.messaging.messages.RemotingMessage",
        2 => "flex.messaging.messages.CommandMessage",
        3 => "flex.messaging.messages.AcknowledgeMessage",
    );

    /**
     * Defines Error message
     */
    const MSQ_TYPE_ERR = 0;
    /**
     * Defines Acknowledge message
     */
    const MSG_TYPE_ACK = 1;
    /**
     * Defines Command message
     */
    const MSG_TYPE_COM = 2;
    /**
     * Defines Remoting message
     */
    const MSG_TYPE_REM = 3;

    /**
     * @type AmfStream
     */
    protected $_raw;
    /**
     * @type AmfPacket
     */
    protected $_obj;

    /**
     * Backdoor for AMF stream
     * @param string $value
     * @throws \Fire1\AmfLeech\Core\Exceptions\AmfException
     */
    public function __construct( $value = null )
    {
        if (is_null($value))
            return;

        $parser = new AmfDeserialize;
        $this->_raw = $value;
        $this->_obj = $parser->decode($value);

    }

    /**
     * @inheritdoc
     */
    public function getPure()
    {
        return new AmfStream($this->_raw);
    }

    /**
     * @param AmfStream $data
     */
    public function setEncoded( AmfStream $data )
    {
        $parser = new AmfDeserialize;
        $this->_raw = $data;
        $this->_obj = $parser->decode($data->getStream());
    }

    /** Reloads AMF data
     * @return AmfContainer
     */
    public function reload()
    {
        $this->read()->generateIds();
        return $this;
    }

    /**
     * @param AmfPacket $data
     */
    public function setDecoded( AmfPacket $data )
    {
        $parser = new AmfSerialize;
        $this->_obj = $data;
        $this->_raw = $parser->encode($this->_obj);
    }

    /** Complied new message
     * @return $this
     */
    /**
     * @param bool|false $new
     * @return AmfContainer
     * @throws \Fire1\AmfLeech\Core\Exceptions\AmfException
     */
    public function compile( $new = false )
    {
        $parser = new AmfSerialize;
        $this->_raw = $parser->encode($this->_obj);
        return $this;
    }

    /**
     * @return AmfStream
     */
    public function getEncoded()
    {
        $this->reload()->compile();
        return new AmfStream($this->_raw);
    }

    /**
     * @return mixed
     */
    public function getDecoded()
    {
        return $this->_obj;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set( $name, $value )
    {
        $this->_obj->{$name} = $value;
    }

    /**
     * @param $name
     * @return object
     */
    public function __get( $name )
    {
        return $this->_obj->{$name};
    }

    /**
     * Gets object with helper methods
     * @param int $data_position
     * @param int $message_position
     * @return Read
     */
    public function read( $data_position = 0, $message_position = 0 )
    {
        return new  Read($this->_obj, $message_position, $data_position);
    }

    /**
     * Checks message is error
     * @return bool
     */
    public function isAccepted()
    {
        in_array($this->read()->getData()->{self::$STRING_EXPLICIT_NAME}, self::$ERROR_EXPLICIT_CONTAINER) ?
            false : true;
    }

    /** Gets message type
     * @return mixed
     */
    public function getMsqType()
    {
        $arrTypeContainer = array_merge(self::$ERROR_EXPLICIT_CONTAINER, self::$ACCEPT_EXPLICIT_CONTAINER);
        return array_search($this->read()->getData()->{self::$STRING_EXPLICIT_NAME}, $arrTypeContainer);
    }

    /**
     * Pass data to SendRequest
     * @return string
     */
    public function getStream()
    {
        return $this->_raw = (new AmfSerialize)->encode($this->_obj);
    }


    /**
     * Pass data to SendRequest
     * @return int
     */
    public function getLength()
    {
        return strlen($this->_raw);
    }
}