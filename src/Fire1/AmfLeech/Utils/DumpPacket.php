<?php
/*
* Copyright (C) 2015 Angel Zaprianov <me@fire1.eu>
*
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
* Project: AmfLeech
*
* Date: 3/18/2016
* Time: 12:23
*
* @author Angel Zaprianov <me@fire1.eu>
*/

namespace Fire1\AmfLeech\Utils;

use Fire1\AmfLeech\Core\AmfDeserialize;
use Fire1\AmfLeech\Utils\Interfaces\DumpReadInterface;

/**
 * Class DumpPacket
 * @package Fire1\AmfLeech\Utils
 */
class DumpPacket
{
    /**
     * @type DumpReadInterface
     */
    protected $dumper;
    /** File array with dumped steps
     * @type array
     */
    protected $steps = array();
    /**
     * @type array
     */
    protected $_collection = array();

    /**
     * @param DumpReadInterface $dumper
     */
    public function __construct(DumpReadInterface $dumper)
    {
        $this->dumper = $dumper;
        $this->steps = $dumper->getList();
    }

    /**
     * @return array
     */
    public function getAllSteps()
    {
        return $this->steps;
    }

    /**
     * @return int
     */
    public function getStepsLength()
    {
        return count($this->steps);
    }

    /**
     * @param $index
     * @return \Fire1\AmfLeech\Core\AmfPacket
     */
    public function getData($index)
    {
        return new AmfContainer($this->dumper->readIndex($index));
    }

    /** Gets Amf container from given array index
     * @param array $list
     * @return DumpPacket
     */
    public function expandArr(array $list = array())
    {
        foreach ($list as $index):
            $this->expandNum($index);
        endforeach;

        return $this;
    }

    /** Gets all containers
     * @return DumpPacket
     */
    public function expandAll()
    {
        foreach ($this->steps as $step => $fileInfo):
            $this->expandNum($step);
        endforeach;

        return $this;
    }

    /** Trigger read
     * @param int $index
     * @return $this
     */
    public function expandNum($index = 0)
    {
        $this->_collection[ $index ] = $this->getData($index);

        return $this;
    }

    /**
     * @return array
     */
    public function getArrContainer()
    {
        return $this->_collection;
    }
}