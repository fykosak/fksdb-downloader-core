<?php

declare(strict_types=1);

use Fykosak\FKSDBDownloaderCore\Downloader;
use Fykosak\FKSDBDownloaderCore\FKSDBDownloader;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/pass.php';

$downloader = new FKSDBDownloader(FKSDB_WSDL, FKSDB_USER, FKSDB_PASS, FKSDB_API);
$newDownloader = new Downloader([
    'fksdb' => [
        'url' => FKSDB_API,
        'username' => FKSDB_USER,
        'password' => FKSDB_PASS,
    ],
]);

return $newDownloader;
