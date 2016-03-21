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
* Time: 12:32
*
* @author Angel Zaprianov <me@fire1.eu>
*/

namespace Fire1\AmfLeech\Core;

/**
 * Class AmfPacket
 *
 * @package Fire1\AmfLeech\Core
 */
class AmfPacket extends \Amfphp_Core_Amf_Packet
{


    /**
     * The constructor function for a new Amf object.
     * All the constructor does is initialize the headers and Messages containers
     *
     * @param null $packet
     */
    public function __construct($packet = null)
    {
        parent::__construct();

        $this->headers = array();
        $this->messages = array();
        $this->amfVersion = \Amfphp_Core_Amf_Constants::AMF3_ENCODING;


        if ($packet instanceof \Amfphp_Core_Amf_Packet)
            $this->setFromParent($packet);
    }

    /**
     * @param \Amfphp_Core_Amf_Packet $parent
     *
     * @return AmfPacket
     */
    public function setFromParent(\Amfphp_Core_Amf_Packet $parent)
    {
        $this->headers = $parent->headers;
        $this->messages = $parent->messages;
        $this->amfVersion = $parent->amfVersion;

        return $this;
    }


}