<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore;

use Fykosak\FKSDBDownloaderCore\Requests\Request;

class BasicDownloader extends Downloader
{
    public function __construct(
        string $url,
        private string $username,
        private string $password
    ) {
        parent::__construct($url);
    }

    protected function getOptions(Request $request): array
    {
        return [
            'http' => [
                'header' => "Content-type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Basic " . base64_encode($this->username . ':' . $this->password),
                'method' => 'GET',
                'content' => json_encode($request->getParams()),
            ],
        ];
    }
}
