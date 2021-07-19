<?php

use Fykosak\FKSDBDownloaderCore\FKSDBDownloader;
use Fykosak\FKSDBDownloaderCore\Requests\EventRequest;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/pass.php';

$downloader = new FKSDBDownloader(FKSDB_WSDL, FKSDB_USER, FKSDB_PASS);

try {
    $result = $downloader->download(new EventRequest(145));
} catch (Throwable $exception) {
}

header('Content-Type: text/xml');
//echo $downloader->getClient()->__getLastRequest();
echo $downloader->getClient()->__getLastResponse();

//echo $result;
