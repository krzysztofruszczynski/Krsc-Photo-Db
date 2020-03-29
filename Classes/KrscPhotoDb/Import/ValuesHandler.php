<?php
namespace KrscPhotoDb\Import;

/**
 * This file is part of Krsc-Photo-Db.
 *
 * Class converting some of exif data to decimal values.
 *
 * @category KrscPhotoDb\Import
 * @copyright Copyright (c) 2020 Krzysztof Ruszczyński
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL
 * @author Krzysztof Ruszczyński <https://www.ruszczynski.eu>
 * @version 1.0.0, 2020-03-29
 */
class ValuesHandler extends AbstractHandler
{
    /**
     * @var string[] column names, where values have to be prepared
     */
    protected $_valuesToProcess = array('ExposureTime', 'FNumber', 'FocalLength');

    protected function _processValues($aFileData)
    {
        foreach ($this->_valuesToProcess as $sColumnName) {
            $aFileData[$sColumnName] = GpsHandler::prepareValue($aFileData[$sColumnName]);
        }

        return $aFileData;
    }

    public function process()
    {
        foreach($this->_mData as $sFilePath => $aFileData) {
            $this->_mData[$sFilePath] = $this->_processValues($aFileData);
        }

        if (isset($this->_oNext)) {
            $this->_oNext->setData($this->_mData);
            $this->_oNext->process();
        }
    }
}
