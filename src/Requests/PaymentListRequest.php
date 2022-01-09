<?php

declare(strict_types=1);

namespace Fykosak\FKSDBDownloaderCore\Requests;

class PaymentListRequest implements Request
{
    private int $eventId;

    public function __construct(int $eventId)
    {
        $this->eventId = $eventId;
    }

    public function getMethod(): string
    {
        return 'GetPaymentList';
    }

    public function getParams(): array
    {
        return ['event_id' => $this->eventId];
    }

    public function getCacheKey(): string
    {
        return sprintf('payment-list-%s', $this->eventId);
    }
}
