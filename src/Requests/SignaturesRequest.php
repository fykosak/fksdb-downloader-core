<?php

namespace Fykosak\FKSDBDownloaderCore\Requests;

class SignaturesRequest implements Request
{

    private int $contestId;

    public function __construct(int $contestId)
    {
        $this->contestId = $contestId;
    }

    public function getMethod(): string
    {
        return 'GetSignatures';
    }

    public function getParams(): array
    {
        return [
            'contestId' => $this->contestId,
        ];
    }

    public function getCacheKey(): string
    {
        return sprintf('signatures.%s', $this->contestId);
    }
}
