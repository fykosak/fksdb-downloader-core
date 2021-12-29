<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore\Requests\Results;

use Fykosak\FKSDBDownloaderCore\Requests\Request;

abstract class AbstractResultsRequest implements Request
{
    protected string $contestName;
    protected int $year;

    public function __construct(string $contestName, int $year)
    {
        $this->contestName = $contestName;
        $this->year = $year;
    }

    public function getParams(): array
    {
        return [
            'contest' => $this->contestName,
            'year' => $this->year,
        ];
    }

    final public function getMethod(): string
    {
        return 'GetResults';
    }
}
