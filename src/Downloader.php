<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore;

use Fykosak\FKSDBDownloaderCore\Requests\Request;

class Downloader
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @throws DownloaderException
     */
    public function download(string $app, Request $request): array
    {
        $config = $this->config[$app];
        $options = [
            'http' => [
                'header' => "Content-type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Basic " . base64_encode($config['username'] . ':' . $config['password']),
                'method' => 'GET',
                'content' => json_encode($request->getParams()),
            ],
        ];
        $context = stream_context_create($options);

        $result = file_get_contents(
            $this->config[$app]['url'] . $request->getMethod(),
            false,
            $context
        );
        if ($result === false) {
            restore_error_handler();
            throw new DownloaderException(error_get_last()['message']);
        }
        return json_decode($result, true);
    }
}
