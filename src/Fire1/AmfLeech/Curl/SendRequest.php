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
* Time: 19:24
*
* @author Angel Zaprianov <me@fire1.eu>
*/

namespace Fire1\AmfLeech\Curl;

use Fire1\AmfLeech\Core\Interfaces\AmfStreamInterface;
use Fire1\AmfLeech\Curl\Exceptions\RequestException;
use Fire1\AmfLeech\Curl\Interfaces\BinaryStreamInterface;
use Fire1\AmfLeech\Utils\AmfContainer;

/**
 * Class SendRequest
 * @package Fire1\AmfLeech\Curl
 */
class SendRequest
{
    /** Default header parameters
     * @type array
     */
    protected $_header = array(
        "POST /engine/ HTTP/1.1",
        "User-Agent: Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.10) Gecko/2009042523 Ubuntu/9.04 (fire1) Firefox/3.0.10",
        "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        "Accept-Language: de, en-gb;q=0.9, en;q=0.8",
        "Accept-Encoding: gzip",
        "Accept-Charset: UTF-8,utf-8;q=0.7,*;q=0.7",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "Connection: keep",
        "Content-Type: application/x-amf",
    );
    /**
     * @type string
     */
    private $reply = null;

    /**
     * @type null|string
     */
    public static $referer = null;

    /**
     * @type null|string
     */
    public static $cookie = null;

    /**
     * @type null|string
     */
    public static $chanel = null;

    /**
     * @type null|string
     */
    public static $endpoint = null;

    /** cURL session
     * @var
     */
    protected $_curl_handler;

    /** AMF binary content
     * @type BinaryStreamInterface
     */
    protected $_container;

    /**
     * @type null|string
     */
    private $address = null;
    /**
     * @type null|string
     */
    private $domain = null;

    /**
     * @param AmfStreamInterface $stream   AMF Binary string to send
     * @param null|string        $endpoint URL address of AMF gateway
     * @param null|string        $cookie   Cookie if is created
     */
    function __construct( AmfStreamInterface $stream, $endpoint = null, $cookie = null )
    {
        $this->_container = $stream;

        is_null($cookie) ?: self::$cookie = $cookie;
        is_null($endpoint) ?: self::$endpoint = $endpoint;

        $this->resolveAdditionalRequestInformation();
    }

    /** Remove header element from given index
     * @param $index
     */
    public function unsetHeaderIndex( $index )
    {
        unset( $this->_header[ $index ] );
    }

    /** Sets additional header value
     * @param array|string $value
     */
    public function setHeader( $value )
    {
        if (is_array($value)) {
            array_merge_recursive($this->_header, $value);
        } else {
            $this->_header[] = $value;
        }
    }

    /**
     * @throws RequestException
     */
    protected function resolveAdditionalRequestInformation()
    {
        if (is_null(self::$endpoint))
            throw new RequestException("Please set your \"endpoint\" URL address!");

        $url_parts = parse_url(self::$endpoint);

        $this->domain = $url_parts[ 'host' ];
        $this->address = $url_parts[ 'scheme' ] . '://' . $url_parts[ 'host' ];


    }

    /** Gets generated header information
     * @return array
     */
    public function getHeaderDynamicData()
    {
        return array(
            "Referer: " . !empty( self::$referer ) ? self::$referer : $this->address . '/backdoor.swf',
            "Cookie: " . $this->getCookie(),
            "Host: " . $this->domain,
            "Content-Length: " . $this->_container->getLength(),
            "Expect:" // Fixes unexpected body
        );
    }

    /**
     * Creates communication cookie
     * @return string
     * @throws RequestException
     */
    protected function requestCookie()
    {
        $arrMatch = array();
        $ch = curl_init(self::$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        preg_match('/^Set-Cookie: (.*?);/m', curl_exec($ch), $arrMatch);

        if (isset( $arrMatch[ 1 ] )) {
            return $arrMatch[ 1 ];
        }
        throw new RequestException(sprintf("Cannot manage to create cookie in given URL %s !", self::$endpoint));
    }

    /** Returns cookie string from server
     * @return null|string
     */
    public function getCookie()
    {
        return empty(self::$cookie) ? self::$cookie = $this->requestCookie() : self::$cookie;
    }

    /** Gets
     * @return array
     */
    public function getHead()
    {
        return array_merge_recursive($this->_header, $this->getHeaderDynamicData());
    }

    /**
     * POST the CURL and enjoy the outcome :)
     * @return mixed
     */
    private function __curl()
    {
        $this->_curl_handler = curl_init(self::$endpoint);

        curl_setopt_array($this->_curl_handler, array(
            CURLOPT_HEADER         => false,
            CURLOPT_POSTFIELDS     => $this->_container->getStream(),
            CURLOPT_HTTPHEADER     => $this->getHead(),
            CURLOPT_POST           => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_RETURNTRANSFER => true,
            //
            // Skip SSL verification
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
        ));

        $content = curl_exec($this->_curl_handler);
        curl_close($this->_curl_handler);

        return $content;
    }


    /**
     * @return mixed
     */
    public function getResponse()
    {
        return is_null($this->reply) ? $this->reply = $this->__curl() : $this->reply;
    }

    public function execute()
    {
        $this->getResponse();
    }

    /**
     * @return AmfContainer
     */
    public function getReply()
    {
        return new AmfContainer($this->getResponse());
    }

    /**
     * @param callable $callback
     */
    public function exe( callable $callback )
    {
        return $callback($this->getResponse());
    }

    /**
     * @return mixed
     */
    public function getResponseInfo()
    {
        return curl_getinfo($this->_curl_handler);
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return curl_error($this->_curl_handler);
    }

    /**
     * @return int
     */
    public function getErrorNumber()
    {
        return curl_errno($this->_curl_handler);
    }
}