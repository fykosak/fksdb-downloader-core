<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore\Requests;

class EventRequest implements Request
{

    protected int $eventId;

    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    public function getCacheKey(): string
    {
        return sprintf('eventDetail.%s', $this->eventId);
    }

    public function getParams(): array
    {
        return [
            'eventId' => $this->eventId,
        ];
    }

    final public function getMethod(): string
    {
        return 'GetEvent';
    }
}
