<?php
/**
 * Created by PhpStorm.
 * Author: Angel Zaprianov <me@fire1.eu>
 * Date: 3/22/16
 * Time: 10:23 AM
 */

namespace Fire1\AmfLeech\Utils\Messaging;

/**
 * Class Read
 * @package Fire1\AmfLeech\Utils\Messaging
 */
class Read
{

    public static $clintId = null;
    /** External static configuration
     * @type bool
     */
    public static $change_msg_id = true;
    /**
     * @type \stdClass
     */
    protected $data;
    /**
     * @type \stdClass
     */
    protected $header;

    /**
     * @param     $messages
     * @param int $msg_position
     * @param int $data_position
     */
    public function __construct(&$messages, $msg_position = 0, $data_position = 0)
    {

        $message = $messages->messages[ $msg_position ];
        $this->data = is_array($message->data) ? $message->data[ $data_position ] : $message->data;

        !self::$change_msg_id ?: $this->generateId();

        $this->listenClient();
    }

    protected function listenClient()
    {
        $client = $this->getClient();
        if (is_null(self::$clintId) && !empty($client))
            self::$clintId = $client;

        if (!is_null(self::$clintId))
            $this->setClient(self::$clintId);
    }


    /**
     * @return array|\stdClass
     */
    public function getData()
    {
        return $this->data;
    }

    /** Gets client ID
     * @return string
     */
    public function getClient()
    {
        return $this->data->clientId;
    }

    /** Sets Client ID
     * @param $value
     */
    public function setClient($value)
    {
        $this->data->clientId = $value;
    }

    /**
     * @param $value
     */
    public function setMsgId($value)
    {
        $this->data->messageId = $value;
    }

    /** Gets message ID
     * @return string
     */
    public function getMsgId()
    {
        return $this->getData()->messageId;
    }

    /**
     * @return string|null
     */
    public function getId()
    {
        switch (true):
            case  isset($this->getData()->_externalizedData->DSId):
                return $this->getData()->_externalizedData->DSId;

            case isset($this->getData()->messageId):
                return $this->getData()->messageId;

            default:
                return null;

        endswitch;
    }

    /**
     * Gets Body object from AMF message
     * @param int $index
     * @return object|null
     */
    public function getBody($index = 0)
    {
        switch (true):
            case is_array($this->getData()->body) && $index > 0:
                return $this->getData()->body[ $index ];
            case is_array($this->getData()->body) && $index == 0:
                return current($this->getData()->body);
            case is_object($this->getData()->body):
                return $this->getData()->body;
            default:
                return null;
        endswitch;
    }

    /**
     * @param $name
     */
    public function __get($name)
    {
        return $this->getBody()->{$name};
    }

    /**
     * @param $name
     * @param $value
     * @return mixed
     */
    public function __set($name, $value)
    {
        return $this->getBody()->{$name} = $value;
    }

    /**
     *  Regenerate inner message ID
     * @return Read
     */
    public function generateId()
    {
        $this->setMsgId(Flex::generateRandomId());

        return $this;
    }

}