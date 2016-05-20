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
use Fire1\AmfLeech\Curl\SendRequest;
use Fire1\AmfLeech\Utils\Interfaces\AmfContainerInterface;
use Fire1\AmfLeech\Utils\Messaging\Read;

/**
 * Class AmfContainer
 * @package Fire1\AmfLeech\Utils
 */
class AmfContainer implements AmfContainerInterface, AmfStreamInterface
{
    /**
     * @type bool
     */
    public static $enableIdReloads = true;


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
    public function getPure( $dumpedChannelId = null )
    {
        return is_null($dumpedChannelId) ?
            new AmfStream($this->_raw) : new AmfStream(str_replace($dumpedChannelId, SendRequest::$chanel, $this->_raw));
    }

    /**
     * Fill AMF container
     * @param AmfStream $data
     * @return $this
     */
    public function setEncoded( AmfStream $data )
    {
        $parser = new AmfDeserialize;
        $this->_raw = $data;
        $this->_obj = $parser->decode($data->getStream());
        return $this;
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
     * Fill AMF container
     * @param AmfPacket $data
     * @return $this
     */
    public function setDecoded( AmfPacket $data )
    {
        $parser = new AmfSerialize;
        $this->_obj = $data;
        $this->_raw = $parser->encode($this->_obj);
        return $this;
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
        if ((bool)static::$enableIdReloads) {
            $this->reload();
        }
        $this->compile();
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