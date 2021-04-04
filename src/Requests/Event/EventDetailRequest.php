<?php

namespace Fykosak\FKSDBDownloaderCore\Requests\Event;

class EventDetailRequest extends EventRequest {

    public function getParams(): array {
        $params = parent::getParams();
        $params['eventDetail'] = '';
        return $params;
    }

    public function getCacheKey(): string {
        return sprintf('eventDetail.%i', $this->eventId);
    }
}
