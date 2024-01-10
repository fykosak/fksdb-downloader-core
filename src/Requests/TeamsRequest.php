<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore\Requests;

class TeamsRequest implements Request
{
    private int $eventId;

    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    public function getMethod(): string
    {
        return 'events/' . $this->eventId . '/teams';
    }

    public function getParams(): array
    {
        return [
            'eventId' => $this->eventId,
        ];
    }

    public function getCacheKey(): string
    {
        return sprintf('team-list.%d', $this->eventId);
    }
}
