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
* Project: AmfLib
*
* Date: 3/12/2016
* Time: 15:01
*
* @author Angel Zaprianov <me@fire1.eu>
*/


include "bootstrap.php";

$parser = new Fire1\AmfLib\Serializer();
//
//$handle_file = fopen(__DIR__ . '/amf-bin/amf.bin', 'rb');
//$stream_amf3 = stream_get_contents($handle_file);
//fclose($handle_file);



$stream_amf3 = file_get_contents(__DIR__ . '/amf-bin/amf3.bin');

//$input = new \ZendAmf\Parser\InputStream($stream_amf3);
//$decode = new \ZendAmf\Parser\Amf3\Deserializer($input);


$deserializer = new \Amfphp_Core_Amf_Deserializer();
$deserialized = $deserializer->deserialize(array(),array(),$stream_amf3);

echo "<pre>";

var_dump($deserialized);