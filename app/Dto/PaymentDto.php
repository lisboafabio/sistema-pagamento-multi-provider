<?php

namespace App\Dto;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentProviderEnum;
use App\Enums\PaymentStatusEnum;
use Spatie\LaravelData\Data;

class PaymentDto extends Data
{
    public PaymentProviderEnum $provider;
    public PaymentStatusEnum $status;
    public PaymentMethodEnum $method;
    public int $amount;
}
