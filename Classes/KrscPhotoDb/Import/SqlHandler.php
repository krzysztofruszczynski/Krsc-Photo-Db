<?php
namespace KrscPhotoDb\Import;

/**
 * This file is part of Krsc-Photo-Db.
 *
 * Class creating sql queries with photo information.
 *
 * @category KrscPhotoDb\Import
 * @copyright Copyright (c) 2020 Krzysztof Ruszczyński
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL
 * @author Krzysztof Ruszczyński <https://www.ruszczynski.eu>
 * @version 1.0.0, 2020-03-29
 */
class SqlHandler extends AbstractHandler
{
    const SQL_TEMPLATE_INSERT_PHOTO = 'INSERT INTO photos_exif (%s) VALUES (%s);';

    /**
     * @var string[] created sql queries
     */
    protected $_aSqlQueries = array();

    protected function _processFileData()
    {
        foreach ($this->_mData as $sFilePath => $aFileIntoDb) {
            $aColumns = array_keys($aFileIntoDb);
            $sColumnsText = implode(', ', $aColumns);
            array_walk($aFileIntoDb, function(&$value, &$key) {
                $value = is_numeric($value) ? $value : '\''.$value.'\'';
            });
            $sValuesText = implode(', ', $aFileIntoDb);
            $this->_aSqlQueries[] = sprintf(self::SQL_TEMPLATE_INSERT_PHOTO, $sColumnsText, $sValuesText);
        }
    }

    public function process()
    {
        $this->_processFileData();

        if (isset($this->_oNext)) {
            $this->_oNext->setData($this->_aSqlQueries);
            $this->_oNext->process();
        }
    }
}
