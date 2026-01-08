<?php

namespace App\Enums;

enum PaymentMethodEnum: string
{
    case PIX = 'pix';
    case CREDIT_CARD = 'credit_card';
    case PAYMENT_SLIP = 'payment_slip';
}
