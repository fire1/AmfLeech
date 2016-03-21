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
 *
 * @package Fire1\AmfLeech\Utils\Interfaces
 */
interface AmfContainerInterface
{
    /** Reloads AMF data
     * @return AmfContainer
     */
    public function reload();
    /**
     * @param AmfStream $data
     *
     * @return void
     */
    public function setEncoded(AmfStream $data);

    /**
     * @param AmfPacket $data
     *
     * @return void
     */
    public function setDecoded(AmfPacket $data);

    /**
     * @return mixed
     */
    public function getEncoded();

    /**
     * @return mixed
     */
    public function getDecoded();

}