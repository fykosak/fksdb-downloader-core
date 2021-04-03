<?php

use Fykosak\FKSDBDownloaderCore\FKSDBDownloader;
use Fykosak\FKSDBDownloaderCore\Requests\{Event\ParticipantListRequest, Event\TeamListRequest, EventsListRequest, ExportRequest, OrganizersRequest, SignaturesRequest};

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/pass.php';

$downloader = new FKSDBDownloader(FKSDB_WSDL, FKSDB_USER, FKSDB_PASS);

//$result = $downloader->download(new TeamsListRequest(145));
//$result = $downloader->download(new ParticipantsListRequest(145));
//$result = $downloader->download(new EventListRequest([1, 9]));
//$result = $downloader->download(new ExportRequest('orgs.ex', ['contest' => 'fykos']));
try {
    $result = $downloader->download(new OrganizersRequest(1));
} catch (\Throwable$exception) {
}

//$result = $downloader->download(new SignaturesRequest(1));
header('Content-Type: text/xml');
//var_dump($downloader->client->__getLastRequest());
//echo $downloader->client->__getLastResponse();



echo $result;
