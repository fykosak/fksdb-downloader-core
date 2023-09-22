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
echo $newDownloader->download('fksdb', 'GetOrganizers', ['contest_id' => 1, 'year' => 37]);
return $newDownloader;
/*
return function (Request $request, bool $soap = true) use ($new): ?string {
    try {
        if ($soap) {
            header('Content-Type: text/xml');
            return $downloader->download($request);
        } else {
            header('Content-Type: text/json');
            return $downloader->downloadJSON($request);
        }
    } catch (Throwable $exception) {
        var_dump($exception);
    }
    return null;
};*/
