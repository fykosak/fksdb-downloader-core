<?php

namespace Fykosak\FKSDBDownloaderCore\Request;

class TeamListRequest implements IRequest {

    private int $eventId;

    public function __construct(int $eventId) {
        $this->eventId = $eventId;
    }

    public function getParams(): array {
        return [
            'eventId' => $this->eventId,
            'teamList' => '',
        ];
    }

    public function getCacheKey(): string {
        return 'teamList.' . $this->eventId;
    }

    public function getMethod(): string {
        return 'GetEvent';
    }
}
