<?php

namespace App\Dto;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentProviderEnum;
use App\Enums\PaymentStatusEnum;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class WebhookDto extends Data
{
    #[MapInputName('payment_id')]
    public int $id;
    #[MapInputName('payment_status')]
    public PaymentStatusEnum $status;
}
