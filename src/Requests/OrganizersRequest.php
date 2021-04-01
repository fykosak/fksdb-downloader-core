<?php

namespace Fykosak\FKSDBDownloaderCore\Requests;

class OrganizersRequest implements Request {

    private int $contestId;
    private ?int $year;

    public function __construct(int $contestId, ?int $year = null) {
        $this->contestId = $contestId;
        $this->year = $year;
    }

    public function getMethod(): string {
        return 'GetOrganizers';
    }

    public function getParams(): array {
        if (isset($this->year)) {
            return [
                'contestId' => $this->contestId,
                'year' => $this->year,
            ];
        }
        return [
            'contestId' => $this->contestId,
        ];
    }

    public function getCacheKey(): string {
        return sprintf('signatures.%s-%s', $this->contestId, $this->year ?? 'all');
    }
}
