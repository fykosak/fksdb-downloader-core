<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore\Requests;

class ParticipantsRequest implements Request
{
    private int $eventId;

    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    public function getMethod(): string
    {
        return 'events/' . $this->eventId . '/participants';
    }

    public function getParams(): array
    {
        return [
            'eventId' => $this->eventId,
        ];
    }

    public function getCacheKey(): string
    {
        return sprintf('participant-list.%d', $this->eventId);
    }
}
