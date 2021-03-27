<?php

use Fykosak\FKSDBDownloaderCore\FKSDBDownloader;
use Fykosak\FKSDBDownloaderCore\Requests\{
    Event\ParticipantsListRequest,
    Event\TeamsListRequest,
    EventListRequest,
    ExportRequest
};

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/pass.php';

$downloader = new FKSDBDownloader(FKSDB_WSDL, FKSDB_USER, FKSDB_PASS);

//$result = $downloader->download(new TeamsListRequest(145));
//$result = $downloader->download(new ParticipantsListRequest(145));
//$result = $downloader->download(new EventListRequest([1, 9]));
$result = $downloader->download(new ExportRequest('orgs.ex', ['contest' => 'fykos']));

header('Content-Type: text/xml');
echo $result;
