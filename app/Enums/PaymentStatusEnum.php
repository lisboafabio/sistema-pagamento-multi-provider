<?php

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case CREATED = 'created';
    case PENDING = 'pending';
    case AUTHORIZED = 'authorized';
    case REFUSED = 'refused';
    case CANCELED = 'canceled';
    case REFUNDED = 'refunded';
}
