<?php
namespace KrscPhotoDb\Import;

/**
 * This file is part of Krsc-Photo-Db.
 *
 * Class implementing Chain-of-responsibility pattern in order to transform image metadata to sql queries.
 *
 * @category KrscPhotoDb\Import
 * @copyright Copyright (c) 2020 Krzysztof Ruszczyński
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL
 * @author Krzysztof Ruszczyński <https://www.ruszczynski.eu>
 * @version 1.0.0, 2020-03-29
 */
class ImportRunner
{
    /**
     * @var string directory to be processed for data
     */
    protected $_sDirectoryToProcess;

    /**
     * @var string name of file, where sql queries will be stored
     */
    protected $_sOutputFile = null;

    /**
     * Setter for directory to be processed for data.
     *
     * @param string $sDirectoryToProcess directory to be processed for data
     *
     * @return $this
     */
    public function setDirectoryToProcess($sDirectoryToProcess)
    {
        $this->_sDirectoryToProcess = $sDirectoryToProcess;

        return $this;
    }

    /**
     * Setter for name of file, where sql queries will be stored.
     *
     * @param string $sOutputFile name of file, where sql queries will be stored (can be null - printed to output)
     *
     * @return $this
     */
    public function setOutputFile($sOutputFile = null)
    {
        $this->_sOutputFile = $sOutputFile;

        return $this;
    }

    public function run()
    {
        $oHandler = (new FilesHandler())->setData($this->_sDirectoryToProcess);
        $oHandler
            ->appendNext(new ExifHandler())
            ->appendNext(new GpsHandler())
            ->appendNext(new ValuesHandler())
            ->appendNext(new SqlHandler())
            ->appendNext(
                (new DataHandler())->setOutputFile($this->_sOutputFile)
            )
        ;

        $oHandler->process();
    }
}
