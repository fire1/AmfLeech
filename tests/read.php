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


include "bootstrap.php";

error_reporting(E_ALL);


$rd = new \Fire1\AmfLeech\Utils\DumpReader(__DIR__ . '/amf-bin/');
$op = (new \Fire1\AmfLeech\Utils\DumpPacket($rd))->expandAll();


$amf = $op->getArrContainer();

\Fire1\AmfLeech\Curl\SendRequest::$referer = "https://www.klingelmedianet.de/client/ISY3Suite_frontend.swf";
\Fire1\AmfLeech\Curl\SendRequest::$endpoint = "https://www.klingelmedianet.de/client/messagebroker/amf/";


//echo "<pre>";
///* @var \Fire1\AmfLeech\Utils\AmfContainer $amf */
//foreach ($container as $index => $amf):
//
//
//    echo "------------------------------------- {$index} -------------------------------------\n";
//    print_r((new \Fire1\AmfLeech\Core\AmfDeserialize())->decode($cli->getResponse()));
//endforeach;
//exit;

$signature = null;
//$cli = new \Fire1\AmfLeech\Curl\SendRequest($amf[0]->getEncoded());
//$response = $cli->getReply()->getDecoded();
//if (isset($response->messages[0]->data->_externalizedData->DSId)) {
//    $signature = $response->messages[0]->data->_externalizedData->DSId;
//}
//
//
//$cli = new \Fire1\AmfLeech\Curl\SendRequest($amf[1]->getEncoded());
/* @var \Fire1\AmfLeech\Core\AmfPacket $req_1 */
$req_1 = $amf[1]->getDecoded();
$req_1->messages[0]


echo '<pre>';
var_dump($amf[1]->getDecoded());
//$i = $_get['i'];
//$stream_amf3 = file_get_contents(__dir__ . "/amf-bin/amf{$i}.bin");


//$result = (new fire1\Amfleech\Core\Amfdeserialize)->decode($rd->readindex(3));


//var_dump($result);