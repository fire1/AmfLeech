<?php
/**
 * Created by PhpStorm.
 * Author: Angel Zaprianov <me@fire1.eu>
 * Date: 3/21/16
 * Time: 4:47 PM
 */

namespace Fire1\AmfLeech\Utils;

use Fire1\AmfLeech\Core\AmfPacket;

/**
 * Class Reply
 * @package Fire1\AmfLeech\Utils
 */
class Reply
{
    /**
     * @type string
     */
    public static $message_id = null;

    protected $message;

    /**
     * @param AmfPacket $amf
     * @param string  $operation
     */
    public function __construct(AmfPacket $amf, $operation = 'current')
    {
        $this->message = call_user_func($operation, $amf->messages);
    }


    protected function injection()
    {
        if (isset($this->getData()->_externalizedData->DSId))
            self::$message_id = $this->getData()->_externalizedData->DSId;
    }

    public function getData()
    {
        return $this->message->data;
    }
}