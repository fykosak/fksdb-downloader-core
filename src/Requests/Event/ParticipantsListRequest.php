<?php

namespace Fykosak\FKSDBDownloaderCore\Requests\Event;

class ParticipantsListRequest extends AbstractEventRequest {

    private array $statuses;

    public function __construct(int $eventId, array $statuses = []) {
        parent::__construct($eventId);
        $this->statuses = $statuses;
    }

    public function getParams(): array {
        $params = parent::getParams();
        $params['participantsList'] = $this->statuses;
        return $params;
    }

    public function getCacheKey(): string {
        return sprintf('participantsList.%s.%s', $this->eventId, count($this->statuses) ? ('.' . join('-', $this->statuses)) : 'all');
    }
}
