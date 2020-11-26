<?php

namespace Fykosak\FKSDBDownloaderCore\Request;

class ResultsCumulativeRequest implements IRequest {

    private int $contest;
    private int $year;
    private array $series;

    public function __construct(int $contest, int $year, array $series) {
        $this->contest = $contest;
        $this->year = $year;
        $this->series = $series;
    }

    public function getCacheKey(): string {
        return sprintf('result.cumm.%s.%s.%s', $this->contest, $this->year, implode('', $this->series));
    }

    public function getParams(): array {
        return [
            'contest' => $this->contest,
            'year' => $this->year,
            'cumulatives' => [
                'cumulative' => implode(' ', $this->series),
            ],
        ];
    }

    public function getMethod(): string {
        return 'GetResults';
    }
}
