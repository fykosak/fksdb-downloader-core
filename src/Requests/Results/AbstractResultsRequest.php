<?php

namespace Fykosak\FKSDBDownloaderCore\Requests\Results;

use Fykosak\FKSDBDownloaderCore\Requests\IRequest;

abstract class AbstractResultsRequest implements IRequest {

    protected int $contestId;
    protected int $year;

    public function __construct(int $contestId, int $year) {
        $this->contestId = $contestId;
        $this->year = $year;
    }

    public function getParams(): array {
        return [
            'contest' => $this->contestId,
            'year' => $this->year,
        ];
    }

    final public function getMethod(): string {
        return 'GetResults';
    }
}
