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
     * @var int
     */
    protected static $storingSize = self::MAX_STORED_OBJECTS;

    /**
     * @param AmfPacket $data
     * @return String
     */
    public function encode( AmfPacket $data )
    {
        return $this->serialize($data);
    }

    /**
     * Sets dynamic Object Stored Size
     * + Fixing issue for bigger objects
     * @param $size
     */
    public static function setOSS( $size = self::MAX_STORED_OBJECTS )
    {
        static::$storingSize = $size;
    }

    /**
     * writeArrayOrObject first determines if the PHP array contains all numeric indexes
     * or a mix of keys.  Then it either writes the array code (0x0A) or the
     * object code (0x03) and then the associated data.
     * @param array $d The php array
     * @throws \Amfphp_Core_Exception
     */
    protected function writeArrayOrObject( $d )
    {
        // referencing is disabled in arrays
        //Because if the array contains only primitive values,
        //Then === will say that the two arrays are strictly equal
        //if they contain the same values, even if they are really distinct
        $count = count($this->Amf0StoredObjects);
        if ($count <= static::$storingSize) {
            $this->Amf0StoredObjects[ $count ] = &$d;
        }

        $numeric = array(); // holder to store the numeric keys
        $string = array(); // holder to store the string keys
//        $len = count($d); // get the total number of entries for the array
        $largestKey = -1;
        foreach ($d as $key => $data) { // loop over each element
            if (is_int($key) && ( $key >= 0 )) { // make sure the keys are numeric
                $numeric[ $key ] = $data; // The key is an index in an array
                $largestKey = max($largestKey, $key);
            } else {
                $string[ $key ] = $data; // The key is a property of an object
            }
        }
        $num_count = count($numeric); // get the number of numeric keys
        $str_count = count($string); // get the number of string keys

        if (( $num_count > 0 && $str_count > 0 ) ||
            ( $num_count > 0 && $largestKey != $num_count - 1 )) { // this is a mixed array
            $this->writeByte(8); // write the mixed array code
            $this->writeLong($num_count); // write  the count of items in the array
            $this->writeObjectFromArray($numeric + $string); // write the numeric and string keys in the mixed array
        } else if ($num_count > 0) { // this is just an array
            $num_count = count($numeric); // get the new count

            $this->writeByte(10); // write  the array code
            $this->writeLong($num_count); // write  the count of items in the array
            for ($i = 0; $i < $num_count; $i++) { // write all of the array elements
                $this->writeData($numeric[ $i ]);
            }
        } else if ($str_count > 0) { // this is an object
            $this->writeByte(3); // this is an  object so write the object code
            $this->writeObjectFromArray($string); // write the object name/value pairs
        } else { //Patch submitted by Jason Justman
            $this->writeByte(10); // make this  an array still
            $this->writeInt(0); //  give it 0 elements
            $this->writeInt(0); //  give it an element pad, this looks like a bug in Flash,
            //but keeps the next alignment proper
        }
    }


}