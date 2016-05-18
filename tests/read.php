<?php
/*
* copyright (c) 2015 angel zaprianov <me@fire1.eu>
*
* this program is free software: you can redistribute it and/or modify
* it under the terms of the gnu general public license as published by
* the free software foundation, either version 3 of the license, or
* (at your option) any later version.
*
* this program is distributed in the hope that it will be useful,
* but without any warranty; without even the implied warranty of
* merchantability or fitness for a particular purpose.  see the
* gnu general public license for more details.
*
* you should have received a copy of the gnu general public license
* along with this program.  if not, see <http://www.gnu.org/licenses/>.
* project: amflib
*
* date: 3/12/2016
* time: 15:01
*
* @author angel zaprianov <me@fire1.eu>
*/

use \Fire1\AmfLeech\Curl\SendRequest;
use \Fire1\AmfLeech\Utils;

include "bootstrap.php";

error_reporting(E_ALL);

//
// Load dumped files
$rd = new Utils\DumpReader(__DIR__ . '/AmfDumps/mandator/');
$op = (new Utils\DumpPacket($rd))->expandAll();

//
// Gets container array with amf dumps
$arrAmf = $op->getArrContainer();

//
// Configure Client request sender
SendRequest::$referer = "your-server.test/client";
SendRequest::$endpoint = "[your-server.test/message/broker/amf]";




echo "<div style='width: 1020px;margin: auto;'> <pre>";

//
// Loop array container and trigger requests to the server
foreach ($arrAmf as $index => $amf) :
    /* @var \Fire1\AmfLeech\Utils\AmfContainer $amf */
    if ($amf instanceof \Fire1\AmfLeech\Core\Interfaces\AmfStreamInterface) {
        echo "<div style='clear: both;display: block'>";

        //
        // Read request from server
        echo "<div style='padding:15px;width: 465px;display: inline-block;float: left;background: #c2face'> <h2> Request <b> {$index} </b> </h2>\n \n";
        var_dump($amf->read());
        echo '</div>';

        // Send request to  server
        $cli = (new SendRequest($amf->getEncoded()))->getReply();

        //
        // Read response from server
        echo " <div style='padding:15px;width:465px;display: inline-block;float: left;background: #faa29f;margin-left: 5px'> <h2> Response <b> {$index} </b> </h2> \n \n";

        var_dump($cli->read(), 'cookie:' . SendRequest::$cookie);


        echo " </div> </div><div style='clear: both;display: block'></div> \n\r\n";
    } else continue;
endforeach;

echo( "</pre> <hr /><h3>Ending! </h3> \n </div>" );
