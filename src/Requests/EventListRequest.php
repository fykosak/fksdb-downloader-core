<?php

namespace Fykosak\FKSDBDownloaderCore\Requests;

class EventListRequest implements IRequest {

    private array $eventTypeIds;

    public function __construct(array $eventTypeIds) {
        $this->eventTypeIds = $eventTypeIds;
    }

    public function getParams(): array {
        return [
            'eventTypeIds' => $this->eventTypeIds,
        ];
    }

    public function getCacheKey(): string {
        return sprintf('eventList.%s', join('-', $this->eventTypeIds));
    }

    public function getMethod(): string {
        return 'GetEventsList';
    }
}
