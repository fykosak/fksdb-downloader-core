<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore;

use Fykosak\FKSDBDownloaderCore\Requests\Request;

class KeyDownloader extends Downloader
{
    public function __construct(
        string $url,
        private string $apiKey,
    ) {
        parent::__construct($url);
    }

    protected function getOptions(Request $request): array
    {
        return [
            'http' => [
                'header' => "Content-type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "X-API-Key: " . $this->apiKey,
                'method' => 'GET',
                'content' => json_encode($request->getParams()),
            ],
        ];
    }
}
