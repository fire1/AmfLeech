<?php
/**
 * Created by PhpStorm.
 * Author: Angel Zaprianov <me@fire1.eu>
 * Date: 3/22/16
 * Time: 10:23 AM
 */

namespace Fire1\AmfLeech\Utils\Messaging;


class Read
{
    /**
     * @type mixed
     */
    protected $_container;

    /**
     * @type \stdClass
     */
    protected $message;
    /**
     * @type array
     */
    protected $_dataContainer;
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
    public function __construct($messages, $msg_position = 0, $data_position = 0)
    {

        $this->_container = $messages;
        $this->message = $this->_container->messages[ $msg_position ];
        $this->_dataContainer = $this->message->data;
        $this->data = is_array($this->message->data) ? $this->message->data[ $data_position ] : $this->message->data;

    }

    public function getMsg()
    {
        return $this->message;
    }

    /**
     * @return array|\stdClass
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $value
     */
    public function setId($value)
    {
        $this->data->messageId = $value;
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
     *  Regenerate inner message ID
     * @return Read
     */
    public function generateId()
    {
        $this->setId(Flex::generateRandomId());

        return $this;
    }

}