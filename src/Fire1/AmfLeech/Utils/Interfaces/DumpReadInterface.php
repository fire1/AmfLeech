<?php

/**
 * Created by PhpStorm.
 * Author: Angel Zaprianov <me@fire1.eu>
 * Date: 3/21/16
 * Time: 10:34 AM
 */

namespace Fire1\AmfLeech\Utils\Interfaces;

use Fire1\AmfLeech\Core\Interfaces\AmfStreamInterface;
use Symfony\Component\Finder\Finder;


/**
 * Interface DumpReadInterface
 */
interface DumpReadInterface extends AmfStreamInterface
{

    /**
     * @return $this|Finder
     */
    public function getFinder();

    /** Returns array file list
     *
     * @return array
     */
    public function getList();


    /** Gets AMF dump content from given file index
     *
     * @param int $index
     *
     * @return string
     */
    public function readIndex($index = 0);
}