<?php
namespace KrscPhotoDb\Import;

/**
 * Class creating sql queries with photo information.
 */
class SqlHandler extends AbstractHandler
{
    const SQL_TEMPLATE_INSERT_PHOTO = 'INSERT INTO photos (%s) VALUES (%s);';

    /**
     * @var string[] created sql queries
     */
    protected $_aSqlQueries = array();

    protected function _processFileData()
    {
        foreach ($this->_mData as $sFilePath => $aFileIntoDb) {
            $aColumns = array_keys($aFileIntoDb);
            $sColumnsText = '\''.implode('\', \'', $aColumns).'\'';
            $sValuesText =  '\''.implode('\', \'', $aFileIntoDb).'\'';
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
