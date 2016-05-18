<?php
/**
 * Created by PhpStorm.
 * User: Angel Zaprianov
 * Date: 11.5.2016 г.
 * Time: 12:30 ч.
 */

namespace Fire1\AmfLeech\Utils\Messaging;

use Fire1\AmfLeech\Curl\SendRequest;


/**
 * Class Head
 * @package Fire1\AmfLeech\Utils\Messaging
 */
class Head
{
    public
        /**
         * @type int
         */
        $DSMessagingVersion = 1,
        /**
         * @type string
         */
        $DSId = "";

    /**
     * Head constructor. Defines communication chanel.
     * @use SessionEvent
     * @param null $dsi
     * @param int  $version
     */
    public function __construct( $dsi = null, $version = 1 )
    {
        if (!is_null($dsi)) {
            $this->setHeadersId($dsi);
        } else
            $this->DSId = SendRequest::$chanel;


        $this->DSMessagingVersion = $version;

    }

    /**
     * @param      $dsi
     * @param bool $force
     */
    public function setHeadersId( $dsi, $force = false )
    {
        if ($force || empty(  SendRequest::$chanel ))
            SendRequest::$chanel = $this->DSId = $dsi;
    }

    /**
     * @param int $ver
     */
    public function setHeadersVersion( $ver = 1 )
    {
        $this->DSMessagingVersion = $ver;
    }


    /**
     * @return string
     */
    public function getHeadersId()
    {
        return $this->DSId;
    }

    /**
     * @return int
     */
    public function getHeadersVersion()
    {
        return $this->DSMessagingVersion;
    }
}