<?php
/**
 * This file "VendorAbstract.php"
 *  is part of the "Tomato" project.
 * Author: Angel Zaprianov <me@fire1.eu>
 * Date: 3/24/16
 * Time: 3:25 PM
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Fire1\AmfLeech\Utils;


use Fire1\AmfLeech\Utils\Exceptions\DumpReadException;

/**
 * Class VendorAbstract
 * @package Tomato\Klingel\DumpRepos
 */
abstract class VendorDump
{
    /** Gets dump folder with AMF dumped files
     * @return string
     */
    abstract protected function getDumpFolder();

    /**
     * @type array|AmfContainer
     */
    protected $repository;
    /**
     * @type DumpReader
     */
    protected $dumpReader;
    /**
     * @type DumpPacket
     */
    protected $dumpPacket;


    /**
     * VendorDumpAbstract constructor.
     * Sets $this->repository var into parent class with array collection of AmfContainer.
     *          Additional vars like  $this->dumpReader & $this->dumpPacket also can be used from parent class.
     *          This class also sets base information in SendRequest class
     * @throws DumpReadException
     */
    public function __construct()
    {
        //
        // Collect files and read them
        $this->dumpPacket = (new DumpPacket($this->dumpReader = new DumpReader($this->getDumpFolder())))->expandAll();

        //
        // Content collection of dump packet
        $repository = $this->dumpPacket->getArrContainer();

        if (empty( $repository ) || !is_array($repository))
            throw new DumpReadException(sprintf("User Repository is empty! Given path %s seems to be empty. ", $this->getDumpFolder()));
        $this->repository = $repository;

    }

    /**
     * Gets AmfContainer for exact filename
     *      Method supports suffix  [Optional suffix to omit from the base name returned.]
     *      Default suffix is set to be ".bin" extension.
     * @param string $name
     * @param string $suffix
     * @return AmfContainer|void
     */
    public function getFilename( $name, $suffix = ".bin" )
    {
        /* @var \SplFileInfo $fileInfo */
        foreach ($this->dumpReader->getList() as $index => $fileInfo):
            if ($fileInfo->getBasename($suffix) != $name)
                continue;

            return $this->repository[ $index ];
        endforeach;
        return null;
    }

}