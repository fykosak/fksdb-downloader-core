<?php

namespace Fykosak\FKSDBDownloaderCore\Requests\Event;

use Fykosak\FKSDBDownloaderCore\Requests\Request;

abstract class EventRequest implements Request {

    protected int $eventId;

    public function __construct(int $eventId) {
        $this->eventId = $eventId;
    }

    public function getParams(): array {
        return [
            'eventId' => $this->eventId,
        ];
    }

    final public function getMethod(): string {
        return 'GetEvent';
    }
}
