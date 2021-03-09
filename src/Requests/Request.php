<?php

namespace Fykosak\FKSDBDownloaderCore\Requests;

interface Request {

    public function getMethod(): string;

    public function getParams(): array;

    public function getCacheKey(): string;
}
