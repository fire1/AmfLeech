<?php
/**
 * Project amf-leech
 * User: Angel Zaprianov
 * Date: 18.5.2016 г.
 * Time: 12:49 ч.
 */

namespace Tests;


use Fire1\AmfLeech\Utils\VendorDump;

/**
 * Class Mandator
 * @package Tests
 */
class Mandator extends VendorDump
{

    /**
     * @return string
     */
    protected function getDumpFolder()
    {
        return "AmfDumps/mandator/";
    }

    /**
     * @return \Fire1\AmfLeech\Utils\AmfContainer
     */
    public function getMandator()
    {
        return $this->getFilename('amf-mandator');
    }

}