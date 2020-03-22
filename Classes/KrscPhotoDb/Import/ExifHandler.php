<?php
namespace KrscPhotoDb\Import;

/**
 * Class extracting exif data from files.
 */
class ExifHandler extends AbstractHandler
{
    /**
     * @var array array('filepath'=>array with file data)
     */
    protected $_aFilesData = array();

    /**
     *
     * @var array exif parameter to be collected
     */
    protected $_aParametersToCollect = array('FileName', 'FileSize', 'MimeType', 'Model', 'Artist', 'ExposureTime', 'FNumber',
        'ISOSpeedRatings', 'DateTimeOriginal', 'Flash', 'FocalLength', 'UserComment', 'ExifImageWidth', 'ExifImageLength', 'GPSLatitudeRef', 'GPSLatitude',
        'GPSLongitudeRef', 'GPSLongitude', 'GPSAltitudeRef', 'GPSAltitude');

    protected function _processFile($sFilePath)
    {
        $aExifData = exif_read_data($sFilePath);
        $aFlippedParametersToCollect = array_flip($this->_aParametersToCollect);

        $this->_aFilesData[$sFilePath] = array_intersect_key($aExifData, $aFlippedParametersToCollect);
    }

    public function process()
    {
        foreach($this->_mData as $sFilePath) {
            $this->_processFile($sFilePath);
        }

        if (isset($this->_oNext)) {
            $this->_oNext->setData($this->_aFilesData);
            $this->_oNext->process();
        }
    }
}
