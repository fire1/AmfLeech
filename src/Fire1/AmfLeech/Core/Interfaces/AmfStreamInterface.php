<?php
/**
 * Created by PhpStorm.
 * Author: Angel Zaprianov <me@fire1.eu>
 * Date: 3/21/16
 * Time: 11:07 AM
 */

namespace Fire1\AmfLeech\Core\Interfaces;

/**
 * Interface AmfStreamInterface
 *
 * @package Fire1\AmfLeech\Core
 */
interface AmfStreamInterface
{

    /**
     * @return string
     */
    public function getStream();


    /**
     * @return int
     */
    public function getLength();

}