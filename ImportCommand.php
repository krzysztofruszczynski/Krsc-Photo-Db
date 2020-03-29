<?php
/**
 * This file is part of Krsc-Photo-Db.
 *
 * Command for importing data from files.
 *
 * @category KrscPhotoDb
 * @copyright Copyright (c) 2020 Krzysztof Ruszczyński
 * @license https://www.gnu.org/licenses/gpl-3.0.html GPL
 * @author Krzysztof Ruszczyński <https://www.ruszczynski.eu>
 * @version 1.0.0, 2020-03-29
 */

$sSourcePath = 'Classes'.DIRECTORY_SEPARATOR.'KrscPhotoDb'.DIRECTORY_SEPARATOR.'Import'.DIRECTORY_SEPARATOR;

require_once $sSourcePath.'AbstractHandler.php';
require_once $sSourcePath.'DataHandler.php';
require_once $sSourcePath.'ExifHandler.php';
require_once $sSourcePath.'FilesHandler.php';
require_once $sSourcePath.'GpsHandler.php';
require_once $sSourcePath.'ImportRunner.php';
require_once $sSourcePath.'SqlHandler.php';
require_once $sSourcePath.'ValuesHandler.php';

use KrscPhotoDb\Import\ImportRunner;

echo 'Krsc-Photo-Db'.PHP_EOL;
echo 'Copyright (c) 2020 Krzysztof Ruszczyński'.PHP_EOL;
echo 'See more at: https://github.com/krzysztofruszczynski/Krsc-Photo-Db'.PHP_EOL;

if (isset($argv[1])) {
    $oImporRunner = new ImportRunner();
    $oImporRunner->setDirectoryToProcess($argv[1]);

    if (isset($argv[2]) && !empty($argv[2])) {
        $oImporRunner->setOutputFile($argv[2]);
    }

    $oImporRunner->run();
    echo PHP_EOL;

    if (isset($argv[2])) {
        echo 'Sql queries saved to: '.$argv[2].PHP_EOL;
    }
} else {
    echo 'Please provide directory.'.PHP_EOL;
    echo 'Usage: php ImportCommand.php (directory with images) (optional filename to save sql data)'.PHP_EOL;
    echo 'Example: php ImportCommand.php /my/directory/with/photos sql_file.sql'.PHP_EOL;
    echo 'Without filename to save sql data, sql queries are printed to output.'.PHP_EOL;
}
