<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore;

use Fykosak\FKSDBDownloaderCore\Requests\Request;

abstract class Downloader
{
    public function __construct(
        protected string $url,
    ) {
    }

    abstract protected function getOptions(Request $request): array;

    public function download(Request $request): array
    {
        $options = $this->getOptions($request);
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
