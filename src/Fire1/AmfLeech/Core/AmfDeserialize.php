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
* Time: 12:22
*
* @author Angel Zaprianov <me@fire1.eu>
*/

namespace Fire1\AmfLeech\Core;

/**
 * Class AmfDeserialize
 * @package Fire1\AmfLeech\Core
 */
class AmfDeserialize extends \Amfphp_Core_Amf_Deserializer
{
    /**
     * Shortcut function
     * @param $stream_amf3
     * @return \Amfphp_Core_Amf_Packet
     */
    public function decode($stream_amf3)
    {
        return $this->deserialize(array(), array(), $stream_amf3);
    }
}