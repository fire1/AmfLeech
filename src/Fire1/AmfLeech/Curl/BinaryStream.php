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
* Date: 3/16/2016
* Time: 12:30
*
* @author Angel Zaprianov <me@fire1.eu>
*/

namespace Fire1\AmfLeech\Curl;


use Fire1\AmfLeech\Curl\Interfaces\BinaryStreamInterface;

/** Contains binary content
 * Class BinaryStream
 *
 * @package Fire1\AmfLeech\Curl
 */
class BinaryStream implements BinaryStreamInterface
{
    /**
     * @type null
     */
    protected $_stream_container = null;
    /**
     * @type int
     */
    protected $_stream_length = 0;

    /**
     * @param $data
     */
    public function __construct($data)
    {
        $this->_stream_container = $data;
        $this->_stream_length = strlen($data);
    }

    /** Gets Length
     *
     * @return int
     */
    public function getLength()
    {
        return $this->_stream_length;
    }

    /** Gets stream data
     *
     * @return string
     */
    public function getStream()
    {
        return $this->_stream_container;
    }
}