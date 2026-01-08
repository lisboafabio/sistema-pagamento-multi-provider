<?php

namespace App\Services;

use App\Dto\WebhookDto;
use App\Enums\PaymentStatusEnum;
use App\Events\AuthorizedPaymentEvent;
use App\Models\Payment;

class WebhookService
{
    public function handle(array $payload): void
    {
        $this->validatePayload($payload);
        match ($payload['status']) {
            'approved' => dispatch(new AuthorizedPaymentEvent(WebhookDto::from($payload))),

        };
    }

    private function validatePayload(array $payload): void
    {
        if (! isset($payload['payment_id']) || ! isset($payload['payment_status'])) {
            throw new \InvalidArgumentException('Invalid payload');
        }

        if (! PaymentStatusEnum::tryFrom($payload['payment_status'])) {
            throw new \InvalidArgumentException('Invalid payment status');
        }

        if (! Payment::where('id', $payload['payment_id'])->exists()) {
            throw new \InvalidArgumentException('Invalid payment id');
        }
    }
}
