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


$rd = new \Fire1\AmfLeech\Utils\DumpReader(__DIR__ . '/amf-collection/');
$op = (new \Fire1\AmfLeech\Utils\DumpPacket($rd))->expandAll();


$arrAmf = $op->getArrContainer();

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
echo "<pre>";
/* @var \Fire1\AmfLeech\Utils\AmfContainer $amf */
foreach ($arrAmf as $index => $amf) :
    $amf->read();
    $amf->reload();
    $amf->compile();
    $cli = new \Fire1\AmfLeech\Curl\SendRequest($amf->getEncoded());
    $data = $cli->getReply()->read();
    echo " ---------------------- Index   ==========  <b> {$index} </b> \n \n";


    var_dump($data->getData());
    echo "  \r\n\r\n";
endforeach;

exit;


/* @var \Fire1\AmfLeech\Utils\AmfContainer $request_1 */
$request_1 = $amf[0];
$request_1->reload();
$request_1->compile();

echo "------------------------ AMF BIN 1 ------------------------" . "\n";
//var_dump($request_1->read());

$cli = new \Fire1\AmfLeech\Curl\SendRequest($request_1->getEncoded());

/* @var \Fire1\AmfLeech\Utils\AmfContainer $response */
$response_1 = $cli->getReply();

//$reply = new \Fire1\AmfLeech\Utils\Reply($cli->getReply()->getDecoded());

echo "------------------------ Client ------------------------" . "\n";
$client_id = $response_1->read()->getClient();
var_dump($client_id);
exit;
/* @var \Fire1\AmfLeech\Utils\AmfContainer $request_2 */
$request_2 = $amf[8];
$request_2->read()->setClient($client_id);
$request_2->compile();

echo "------------------------ AMF BIN 2 ------------------------" . "\n";
var_dump($request_2->getEncoded());

$cli = new \Fire1\AmfLeech\Curl\SendRequest($request_2->getEncoded());

$response_2 = $cli->getReply();

echo "------------------------ Login ------------------------" . "\n";

var_dump($response_2->read());


exit;
//if (isset($response->messages[0]->data->_externalizedData->DSId)) {
//    $signature = $response->messages[0]->data->_externalizedData->DSId;
//}
//
//
//$cli = new \Fire1\AmfLeech\Curl\SendRequest($amf[1]->getEncoded());
/* @var \Fire1\AmfLeech\Core\AmfPacket $req_1 */
$req_1 = $amf[1]->getDecoded();
$req_1->messages[0];


echo '<pre>';
var_dump($amf[1]->getDecoded());
//$i = $_get['i'];
//$stream_amf3 = file_get_contents(__dir__ . "/amf-bin/amf{$i}.bin");


//$result = (new fire1\Amfleech\Core\Amfdeserialize)->decode($rd->readindex(3));








echo "<pre>";
/* @var \Fire1\AmfLeech\Utils\AmfContainer $amf */
foreach ($arrAmf as $index => $amf) :
    $amf->read();
    $amf->reload();
    $amf->compile();
    $cli = new \Fire1\AmfLeech\Curl\SendRequest($amf->getEncoded());
    $data = $cli->getReply()->read();
    echo " <b>Index</b> reading ...  <b> {$index} </b> \n \n";
    var_dump($data->getData());

    echo "  \r\n\r\n";

    echo "  \r\n\r\n";
endforeach;
//var_dump($result);