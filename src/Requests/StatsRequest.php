<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore\Requests;

class StatsRequest implements Request
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
        return 'GetStats';
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
        return sprintf('task.stats.%s.%s', $this->contestId, $this->year);
    }
}
