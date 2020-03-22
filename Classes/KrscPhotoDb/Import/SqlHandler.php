<?php
namespace KrscPhotoDb\Import;

/**
 * Class creating sql queries with photo information.
 */
class SqlHandler extends AbstractHandler
{
    const SQL_TEMPLATE_INSERT_PHOTO = 'INSERT INTO photos (%s) VALUES (%s);';

    public function process()
    {
        foreach ($this->_mData as $sFilePath => $aFileIntoDb) {
            $aColumns = array_keys($aFileIntoDb);
            $sColumnsText = '\''.implode('\', \'', $aColumns).'\'';
            $sValuesText =  '\''.implode('\', \'', $aFileIntoDb).'\'';
            echo sprintf(self::SQL_TEMPLATE_INSERT_PHOTO, $sColumnsText, $sValuesText).PHP_EOL;
        }
    }
}
