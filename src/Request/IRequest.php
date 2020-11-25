<?php

namespace Fykosak\FKSDBDownloaderCore\Request;

interface IRequest {

    public function getMethod(): string;

    public function getParams(): array;

    public function getCacheKey(): string;
}
