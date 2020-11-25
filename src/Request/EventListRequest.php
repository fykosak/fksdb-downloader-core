<?php

namespace Fykosak\FKSDBDownloaderCore\Request;

class EventListRequest extends Request {
    public function __construct(int $eventTypeId) {
        parent::__construct('eventList', 'GetEvent', [
            'eventList' => '',
            'eventTypeId' => $eventTypeId,
        ]);
    }
}
