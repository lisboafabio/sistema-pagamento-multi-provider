<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case CREATED = 'created';
    case AUTHORIZED = 'authorized';
    case REFUSED = 'refused';
    case CANCELED = 'canceled';
    case REFUNDED = 'refunded';

    public function isAuthorized(): bool
    {
        return $this == self::AUTHORIZED;
    }
}
