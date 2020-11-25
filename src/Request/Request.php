<?php

namespace Fykosak\FKSDBDownloaderCore\Request;

abstract class Request implements IRequest {
    public string $cacheKey;
    public string $method;
    public array $params;

    public function __construct(string $cacheKey, string $method, array $params) {
        $this->cacheKey = $cacheKey;
        $this->method = $method;
        $this->params = $params;
    }

    final public function getMethod(): string {
        return $this->method;
    }

    final public function getParams(): array {
        return $this->params;
    }

    final public function getCacheKey(): string {
        return $this->cacheKey;
    }
}
