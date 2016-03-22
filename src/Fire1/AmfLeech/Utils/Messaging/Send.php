<?php
/**
 * Created by PhpStorm.
 * Author: Angel Zaprianov <me@fire1.eu>
 * Date: 3/22/16
 * Time: 10:05 AM
 */

namespace Fire1\AmfLeech\Utils\Messaging;


use Fire1\AmfLeech\Utils\AmfContainer;
use Fire1\AmfLeech\Utils\Reply;

class Send
{

    protected $_container;

    public function __construct(AmfContainer $amf)
    {
        $this->_container = $amf->getDecoded();
    }



    /**
     * @return string
     */
    public function getId()
    {
        return Reply::$message_id;
    }


}