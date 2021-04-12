<?php

namespace Fykosak\FKSDBDownloaderCore\Requests\Results;

class ResultsDetailRequest extends AbstractResultsRequest {

    private int $series;

    public function __construct(string $contestName, int $year, int $series) {
        parent::__construct($contestName, $year);
        $this->series = $series;
    }

    public function getParams(): array {
        $params = parent::getParams();
        $params['detail'] = $this->series;
        return $params;
    }

    public function getCacheKey(): string {
        return sprintf('result.detail.%s.%s.%s', $this->contestName, $this->year, $this->series);
    }
}
