<?php

use Fykosak\FKSDBDownloaderCore\FKSDBDownloader;
use Fykosak\FKSDBDownloaderCore\Requests\Request;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/pass.php';

$downloader = new FKSDBDownloader(FKSDB_WSDL, FKSDB_USER, FKSDB_PASS, FKSDB_API);

return function (Request $request, bool $soap = true) use ($downloader): ?string {
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
};
