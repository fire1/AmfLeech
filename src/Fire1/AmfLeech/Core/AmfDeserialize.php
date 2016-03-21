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
use Fire1\AmfLeech\Core\Exceptions\AmfException;

/**
 * Class AmfDeserialize
 * @package Fire1\AmfLeech\Core
 */
class AmfDeserialize extends \Amfphp_Core_Amf_Deserializer
{
    /**
     * @type int
     */
    private $fixController = 0;
    /**
     * Bytes to skip when readAmf3Data try to read
     */
    const MAX_FIX_TRIES = 10;

    /**
     * @param $stream_amf3
     * @return AmfPacket
     */
    public function decode($stream_amf3)
    {
        return (new AmfPacket())->setFromParent($this->deserialize(array(), array(), $stream_amf3));
    }


    /**
     * Read the type byte, then call the corresponding amf3 data reading function
     *      NOTE: This is fix for my server response with type "168"
     * @return array|mixed
     * @throws AmfException
     */
    public function readAmf3Data()
    {
        $type = $this->readByte();
        switch ($type) {
            case 0x00 :
                return new \Amfphp_Core_Amf_Types_Undefined();
            case 0x01 :
                return null; //null
            case 0x02 :
                return false; //boolean false
            case 0x03 :
                return true; //boolean true
            case 0x04 :
                return $this->readAmf3Int();
            case 0x05 :
                return $this->readDouble();
            case 0x06 :
                return $this->readAmf3String();
            case 0x07 :
                return $this->readAmf3XmlDocument();
            case 0x08 :
                return $this->readAmf3Date();
            case 0x09 :
                return $this->readAmf3Array();
            case 0x0A :
                return $this->readAmf3Object();
            case 0x0B :
                return $this->readAmf3Xml();
            case 0x0C :
                return $this->readAmf3ByteArray();
            case 0x0D :
            case 0x0E :
            case 0x0F :
            case 0x10 :
                return $this->readAmf3Vector($type);
            case 0x11 :
                throw new AmfException('Dictionaries not supported, as it is not possible to use an object as array key in PHP ');
            //
            // In case of unknown type
            default:
                if ($this->fixController++ >= self::MAX_FIX_TRIES)
                    throw new AmfException('Undefined Amf3 type encountered: ' . $type);
                //
                // Skip... read next byte
                $this->readByte();

                return $this->readAmf3Data();
                break;

        }
    }
}