<?php

namespace Fykosak\FKSDBDownloaderCore\Requests\Event;

class PersonScheduleRequest extends EventRequest {

    private array $groupTypes;

    public function __construct(int $eventId, array $groupTypes = []) {
        parent::__construct($eventId);
        $this->groupTypes = $groupTypes;
    }

    public function getParams(): array {
        $params = parent::getParams();
        $params['personSchedule'] = $this->groupTypes;
        return $params;
    }

    public function getCacheKey(): string {
        return sprintf('personSchedule.%s.%s', $this->eventId, count($this->groupTypes) ? join('-', $this->groupTypes) : 'all');
    }
}
