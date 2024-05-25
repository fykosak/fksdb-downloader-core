<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore\Requests;

class SeriesResultsRequest implements Request
{
    private int $contestId;
    private int $year;

    public function __construct(int $contestId, int $year)
    {
        $this->contestId = $contestId;
        $this->year = $year;
    }

    public function getMethod(): string
    {
        return sprintf('contests/%d/years/%d/results', $this->contestId, $this->year);
    }

    public function getParams(): array
    {
        return [
            'contestId' => $this->contestId,
            'year' => $this->year,
        ];
    }

    public function getCacheKey(): string
    {
        return sprintf('series.results.%s.%s', $this->contestId, $this->year);
    }
}
