<?php
/**
 * Created by PhpStorm.
 * Author: Angel Zaprianov <me@fire1.eu>
 * Date: 3/21/16
 * Time: 10:41 AM
 */

namespace Fire1\AmfLeech\Utils;


use Fire1\AmfLeech\Core\AmfStream;
use Fire1\AmfLeech\Core\AmfPacket;
use Fire1\AmfLeech\Core\AmfSerialize;
use Fire1\AmfLeech\Core\AmfDeserialize;
use Fire1\AmfLeech\Utils\Interfaces\AmfContainerInterface;

/**
 * Class AmfContainer
 * @package Fire1\AmfLeech\Utils
 */
class AmfContainer extends AmfStream implements AmfContainerInterface
{

    /**
     * @type AmfStream
     */
    protected $_raw;
    /**
     * @type AmfPacket
     */
    protected $_obj;

    /**
     * Backdoor for AMF stream
     * @param string $value
     * @throws \Fire1\AmfLeech\Core\Exceptions\AmfException
     */
    public function __construct($value = null)
    {
        if (is_null($value))
            return;

        $parser = new AmfDeserialize;
        $this->_raw = $value;
        $this->_obj = $parser->decode($value);

        parent::__construct($value);
    }


    /**
     * @param AmfStream $data
     */
    public function setEncoded(AmfStream $data)
    {
        $parser = new AmfDeserialize;
        $this->_raw = $data;
        $this->_obj = $parser->decode($data->getStream());
    }

    /** Reloads AMF data
     * @return AmfContainer
     */
    public function reload()
    {
        $this->setEncoded($this->getDecoded());

        return $this;
    }

    /**
     * @param AmfPacket $data
     */
    public function setDecoded(AmfPacket $data)
    {
        $parser = new AmfSerialize;
        $this->_obj = $data;
        $this->_raw = $parser->encode($data);
    }

    /**
     * @return mixed
     */
    public function getEncoded()
    {
        return new AmfStream($this->_raw);
    }

    /**
     * @return mixed
     */
    public function getDecoded()
    {
        return $this->_obj;
    }

}