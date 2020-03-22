<?php
namespace KrscPhotoDb\Import;

// increased in order to recursively search inside directories:
ini_set('xdebug.max_nesting_level', 1000);

/**
 * Class searching recursively for images inside given directory.
 */
class FilesHandler extends AbstractHandler
{
    /**
     * @var string[] graphic files, which will be processed for exif data
     */
    protected $_aFilesToProcess = array();

    /**
     * @var string[] graphic extensions, which are taken to read exif data
     */
    protected $_aGraphicExtensions = array('jpg');

    /**
     * @var stringp[] name of directories, which are not entered (like in linux pointing to current or prevoius directory)
     */
    protected $_aIgnoreDirectoryNames = array('.', '..');

    protected function _getInitialDirectory()
    {
        return $this->_mData;
    }

    protected function _processDirectoryContent($sDirectory)
    {
        $sDirectory .= (substr($sDirectory, -1) === DIRECTORY_SEPARATOR) ? '' : DIRECTORY_SEPARATOR;
        $aDirectoryContent = scandir($sDirectory);

        foreach ($aDirectoryContent as $sItemName) {
            if (is_dir($sDirectory.$sItemName)) {
                if (!in_array($sItemName, $this->_aIgnoreDirectoryNames)) {
                    $this->_processDirectoryContent($sDirectory.$sItemName);
                }
            } else {
                if (in_array(strtolower(explode('.', $sItemName)[1]), $this->_aGraphicExtensions)) {
                    $this->_aFilesToProcess[] = $sDirectory.$sItemName;
                }
            }
        }
    }

    public function process()
    {
        $sDirectory = $this->_getInitialDirectory();
        $this->_processDirectoryContent($sDirectory);

        if (isset($this->_oNext) && !empty($this->_aFilesToProcess)) {
            $this->_oNext->setData($this->_aFilesToProcess);
            $this->_oNext->process();
        }
    }
}
