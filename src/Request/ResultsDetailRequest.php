<?php

namespace Fykosak\FKSDBDownloaderCore\Request;

class ResultsDetailRequest implements IRequest {

    private int $contest;
    private int $year;
    private int $series;

    public function getMethod(): string {
        return 'GetResults';
    }

    public function getParams(): array {
        return [
            'contest' => $this->contest,
            'year' => $this->year,
            'detail' => $this->series,
        ];
    }

    public function getCacheKey(): string {
        return sprintf('result.detail.%s.%s.%s', $this->contest, $this->year, $this->series);
    }
}
