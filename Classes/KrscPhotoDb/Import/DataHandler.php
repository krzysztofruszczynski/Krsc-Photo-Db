<?php
namespace KrscPhotoDb\Import;

/**
 * This file is part of Krsc-Photo-Db.
 *
 * Class for sending generated sql data.
 *
 * @category KrscPhotoDb\Import
 * @copyright Copyright (c) 2020 Krzysztof Ruszczyński
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL
 * @author Krzysztof Ruszczyński <https://www.ruszczynski.eu>
 * @version 1.0.0, 2020-03-29
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
