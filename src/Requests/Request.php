<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore\Requests;

interface Request
{

    public function getMethod(): string;

    public function getParams(): array;

    public function getCacheKey(): string;
}
