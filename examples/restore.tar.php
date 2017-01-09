<?php
/**
 * @author Ioannis Botis
 * @date 9/1/2017
 * @version: restore.tar.php 8:46 pm
 * @since 9/1/2017
 */

require_once('settings.php');

use Backup\Tar;
use Backup\IncrementalBackup;

$tar = new Tar($path_to_backup, $path_to_save);

echo "Version: " . $tar->getVersion() . "\n";

$backupClass = new IncrementalBackup ($tar);

$backups = $backupClass->getAllBackups();

echo 'Backup #, time ' . "\n";
$d = new \DateTime();

$i = 1;
foreach ($backups as $time) {
    $d->setTimestamp($time);
    echo $i++ . '. ' . $d->format(\DateTime::W3C) . "\n";
}

echo "Please select version to restore. Type int to continue: ";
$handle = fopen("php://stdin", "r");
$backup_to_restore = intval(fgets($handle));

if (!in_array($backup_to_restore, range(1, $i - 1))) {
    echo 'invalid backup selected.';
    exit;
}

// Restore last backup to this directory.
if ($backupClass->restoreTo($backups[$backup_to_restore - 1], $path_to_restore)) {
    echo 'Directory restored.' . "\n";
} else {
    echo 'Could not restore to directory.' . "\n";
}
