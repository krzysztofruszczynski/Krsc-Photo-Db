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

    public function setDirectoryToProcess($sDirectoryToProcess)
    {
        $this->_sDirectoryToProcess = $sDirectoryToProcess;
    }

    public function run()
    {
        $oHandler = new FilesHandler();
        $oHandler
            ->setData($this->_sDirectoryToProcess)
            ->appendNext(new ExifHandler())
            ->appendNext(new GpsHandler())
            ->appendNext(new ValuesHandler())
            ->appendNext(new SqlHandler())
        ;

        $oHandler->process();
    }
}
