<?php
/**
 * @author Ioannis Botis
 * @date 5/1/2017
 * @version: cron.tar.php 10:45 pm
 * @since 5/1/2017
 */

require_once('settings.php');

use Backup\Tar;
use Backup\IncrementalBackup;

$tar = new Tar($path_to_backup, $path_to_save);

echo "Version: " . $tar->getVersion() . "\n";

$backupClass = new IncrementalBackup ($tar);

if ($backupClass->isChanged()) {
    // back me up.
    echo 'Back up initiated' . "\n";
    $backupClass->createBackup();
} else {
    echo 'No need to backup.' . "\n";
}