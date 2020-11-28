<?php

namespace Fykosak\FKSDBDownloaderCore\Requests;

interface IRequest {

    public function getMethod(): string;

    public function getParams(): array;

    public function getCacheKey(): string;
}
