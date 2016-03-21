<?php
/**
 * Created by PhpStorm.
 * Author: Angel Zaprianov <me@fire1.eu>
 * Date: 3/21/16
 * Time: 10:59 AM
 */

namespace Fire1\AmfLeech\Core;

use Fire1\AmfLeech\Core\Exceptions\AmfException;
use Fire1\AmfLeech\Core\Interfaces\AmfStreamInterface;

/**
 * Interface AmfStream
 * @package Fire1\AmfLeech\Core
 */
class AmfStream implements AmfStreamInterface
{
    /** Raw AMF string
     * @type string
     */
    protected $amf;

    /**
     * @param $value
     * @throws AmfException
     */
    public function __construct($value)
    {

        if (!is_string($value))
            throw new AmfException('Given value in AmfStream is not string');

        $this->amf = $value;
    }

    /**
     * @return string
     */
    public function getStream()
    {
        return $this->amf;
    }


    /**
     * @return int
     */
    public function getLength()
    {
        return strlen($this->amf);
    }

}