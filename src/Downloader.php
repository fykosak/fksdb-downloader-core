<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore;

use Fykosak\FKSDBDownloaderCore\Requests\Request;

class Downloader
{
    private array $config;

    private string $url;
    private string $username;
    private string $password;

    public function __construct(string $url, string $username, string $password)
    {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @throws DownloaderException
     */
    public function download(Request $request): array
    {
        $options = [
            'http' => [
                'header' => "Content-type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization: Basic " . base64_encode($this->username . ':' . $this->password),
                'method' => 'GET',
                'content' => json_encode($request->getParams()),
            ],
        ];
        $context = stream_context_create($options);

        $result = file_get_contents(
            $this->url . $request->getMethod(),
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
