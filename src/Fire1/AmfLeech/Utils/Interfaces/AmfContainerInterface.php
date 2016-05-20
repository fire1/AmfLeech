<?php
/**
 * Created by PhpStorm.
 * Author: Angel Zaprianov <me@fire1.eu>
 * Date: 3/21/16
 * Time: 10:42 AM
 */

namespace Fire1\AmfLeech\Utils\Interfaces;


use Fire1\AmfLeech\Core\AmfPacket;
use Fire1\AmfLeech\Core\AmfStream;
use Fire1\AmfLeech\Utils\AmfContainer;

/**
 * Interface AmfContainerInterface
 * @package Fire1\AmfLeech\Utils\Interfaces
 */
interface AmfContainerInterface
{
    /**
     * Reloads AMF data
     * @return AmfContainer
     */
    public function reload();

    /**
     * Sets AMF from binary encoded stream
     * @param AmfStream $data
     * @return void
     */
    public function setEncoded( AmfStream $data );

    /**
     * Sets AMF from object stream
     * @param AmfPacket $data
     * @return void
     */
    public function setDecoded( AmfPacket $data );

    /**
     * Gets pure content of AMF dump file.
     * If is set param $dumpedChannelId method will replace given Id with $chanel
     * @param null $dumpedChannelId
     * @return AmfStream
     */
    public function getPure( $dumpedChannelId = null );

    /**
     * Gets reloaded then encoded AMF dump
     * @return AmfStream
     */
    public function getEncoded();

    /**
     * Gets decoded AMF object from AMF dump
     * @return mixed
     */
    public function getDecoded();

    /** Refresh message
     * @return void
     */
    public function compile();

    /**
     * @param string $name
     * @param mixed  $value
     * @return void
     */
    public function __set( $name, $value );

    /** Gets data from AMF object
     * @param string $name
     * @return mixed
     */
    public function __get( $name );

}