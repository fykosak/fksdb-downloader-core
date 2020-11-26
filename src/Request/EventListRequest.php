<?php

namespace Fykosak\FKSDBDownloaderCore\Request;

class EventListRequest implements IRequest {

    private int $eventTypeId;

    public function __construct(int $eventTypeId) {
        $this->eventTypeId = $eventTypeId;
    }

    public function getParams(): array {
        return [
            'eventList' => '',
            'eventTypeId' => $this->eventTypeId,
        ];
    }

    public function getCacheKey(): string {
        return 'eventList.' . $this->eventTypeId;
    }

    public function getMethod(): string {
        return 'GetEventList';
    }
}
