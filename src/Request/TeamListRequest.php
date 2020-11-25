<?php

namespace Fykosak\FKSDBDownloaderCore\Request;

class TeamListRequest extends Request {
    public function __construct(int $eventId) {
        parent::__construct('teamList.' . $eventId, 'GetEvent', [
            'teamList' => '',
            'eventId' => $eventId,
        ]);
    }
}
