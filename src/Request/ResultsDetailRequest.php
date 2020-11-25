<?php

namespace Fykosak\FKSDBDownloaderCore\Request;

class ResultsDetailRequest extends Request {
    public function __construct(int $contest, int $year, int $series) {
        parent::__construct(
            sprintf('result.detail.%s.%s.%s', $contest, $year, $series),
            'GetResults', [
            'contest' => $contest,
            'year' => $year,
            'detail' => $series,
        ]);
    }
}
