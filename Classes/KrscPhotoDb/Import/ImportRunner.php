<?php
namespace KrscPhotoDb\Import;

/**
 * Class implementing Chain-of-responsibility pattern in order to transform image metadata to sql queries.
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
