<?php

namespace Fykosak\FKSDBDownloaderCore\Requests\Event;

use Fykosak\FKSDBDownloaderCore\Requests\IRequest;

abstract class AbstractEventRequest implements IRequest {

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
