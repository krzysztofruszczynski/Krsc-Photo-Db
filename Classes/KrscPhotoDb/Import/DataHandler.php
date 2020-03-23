<?php
namespace KrscPhotoDb\Import;

/**
 * Class for sending generated sql data.
 */
class DataHandler extends AbstractHandler
{
    /**
     * @var string name of file, where sql queries will be stored
     */
    protected $_sOutputFile = null;

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

    public function process()
    {
        if (is_null($this->_sOutputFile)) {
            echo implode(PHP_EOL, $this->_mData);
        } else {
            file_put_contents($this->_sOutputFile, implode(PHP_EOL, $this->_mData));
        }
    }
}
