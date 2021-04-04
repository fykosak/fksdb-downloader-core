<?php

use Fykosak\FKSDBDownloaderCore\FKSDBDownloader;
use Fykosak\FKSDBDownloaderCore\Requests\Event\ScheduleListRequest;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/pass.php';

$downloader = new FKSDBDownloader(FKSDB_WSDL, FKSDB_USER, FKSDB_PASS);

try {
    $result = $downloader->download(new ScheduleListRequest(145, ['visa']));
} catch (Throwable$exception) {
}

header('Content-Type: text/xml');
//echo $downloader->client->__getLastRequest();
//echo $downloader->client->__getLastResponse();

echo $result;
