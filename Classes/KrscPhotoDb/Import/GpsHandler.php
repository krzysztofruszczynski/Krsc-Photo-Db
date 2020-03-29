<?php
namespace KrscPhotoDb\Import;

/**
 * This file is part of Krsc-Photo-Db.
 *
 * Class converting gps coordinates to decimal values.
 *
 * @category KrscPhotoDb\Import
 * @copyright Copyright (c) 2020 Krzysztof Ruszczyński
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL
 * @author Krzysztof Ruszczyński <https://www.ruszczynski.eu>
 * @version 1.0.0, 2020-03-29
 */
class GpsHandler extends AbstractHandler
{
    public static function prepareValue($sValue)
    {
        if (stripos($sValue, '/')) {
            $aValue = explode('/', $sValue);
            $fReturnValue = $aValue[0] / $aValue[1];
        } else {
            $fReturnValue = floatval($sValue);
        }

        return $fReturnValue;
    }

    protected function _processGpsData($aFileData)
    {
        if (isset($aFileData['GPSLatitude']) && is_array($aFileData['GPSLatitude'])) {
            $aFileData['GPSLatitude'] = self::prepareValue(self::prepareValue($aFileData['GPSLatitude'][0]))
                + self::prepareValue($aFileData['GPSLatitude'][1])/60
                + self::prepareValue($aFileData['GPSLatitude'][2])/3600
            ;
            $aFileData['GPSLongitude'] = self::prepareValue($aFileData['GPSLongitude'][0])
                + self::prepareValue($aFileData['GPSLongitude'][1])/60
                + self::prepareValue($aFileData['GPSLongitude'][2])/3600
            ;
        }
        if (isset($aFileData['GPSAltitude'])) {
            $aFileData['GPSAltitudeRef'] = octdec($aFileData['GPSAltitudeRef']);
            $aFileData['GPSAltitude'] = self::prepareValue($aFileData['GPSAltitude']);
        }

        return $aFileData;
    }

    public function process() {
        foreach($this->_mData as $sFilePath => $aFileData) {
            $this->_mData[$sFilePath] = $this->_processGpsData($aFileData);
        }

        if (isset($this->_oNext)) {
            $this->_oNext->setData($this->_mData);
            $this->_oNext->process();
        }
    }
}
