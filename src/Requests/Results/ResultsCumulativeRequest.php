<?php

namespace Fykosak\FKSDBDownloaderCore\Requests\Results;

class ResultsCumulativeRequest extends AbstractResultsRequest
{

    private array $series;

    public function __construct(string $contestName, int $year, array $series)
    {
        parent::__construct($contestName, $year);
        $this->series = $series;
    }

    public function getCacheKey(): string
    {
        return sprintf('result.cumulative.%s.%s.%s', $this->contestName, $this->year, implode('', $this->series));
    }

    public function getParams(): array
    {
        $params = parent::getParams();
        $params['cumulatives'] = [
            'cumulative' => implode(' ', $this->series),
        ];
        return $params;
    }
}
