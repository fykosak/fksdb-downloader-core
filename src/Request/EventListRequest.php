<?php

namespace Fykosak\FKSDBDownloaderCore\Request;

class EventListRequest implements IRequest {

    private array $eventTypeIds;

    public function __construct(array $eventTypeIds) {
        $this->eventTypeIds = $eventTypeIds;
    }

    public function getParams(): array {
        return [
            'eventList' => '',
            'eventTypeId' => $this->eventTypeIds,
        ];
    }

    public function getCacheKey(): string {
        return 'eventList.' . join('-', $this->eventTypeIds);
    }

    public function getMethod(): string {
        return 'GetEventsList';
    }
}
