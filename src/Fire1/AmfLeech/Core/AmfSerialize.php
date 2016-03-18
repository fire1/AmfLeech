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
* Time: 12:20
*
* @author Angel Zaprianov <me@fire1.eu>
*/

namespace Fire1\AmfLeech\Core;

/**
 * Class AmfSerialize
 * @package Fire1\AmfLeech\Core
 */
class AmfSerialize extends \Amfphp_Core_Amf_Serializer
{

    /**
     * @param AmfPacket $data
     * @return String
     */
    public function encode(AmfPacket $data)
    {
        return $this->serialize($data);
    }

}