<?php

namespace Fykosak\FKSDBDownloaderCore\Request;

class ResultsCumulativeRequest extends Request {

    public function __construct(int $contest, int $year, array $series) {
        parent::__construct(sprintf('result.cumm.%s.%s.%s', $contest, $year, implode('', $series)), 'GetResults', [
            'contest' => $contest,
            'year' => $year,
            'cumulatives' => [
                'cumulative' => implode(' ', $series),
            ],
        ]);
    }
}
