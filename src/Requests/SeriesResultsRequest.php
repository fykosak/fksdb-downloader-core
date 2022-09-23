<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore\Requests;

class SeriesResultsRequest implements Request
{
    private int $contestId;
    private int $year;
    private int $series;

    public function __construct(int $contestId, int $year, int $series)
    {
        $this->contestId = $contestId;
        $this->year = $year;
        $this->series = $series;
    }

    public function getMethod(): string
    {
        return 'GetSeriesResults';
    }

    public function getParams(): array
    {
        return [
            'contestId' => $this->contestId,
            'year' => $this->year,
            'series' => $this->series,
        ];
    }

    public function getCacheKey(): string
    {
        return sprintf('series.results.%s.%s.%s', $this->contestId, $this->year, $this->series);
    }
}
