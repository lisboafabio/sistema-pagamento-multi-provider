<?php

namespace App\Strategies;

use App\Dto\PaymentDto;
use App\Enums\PaymentStatusEnum;
use App\Interfaces\PaymentProviderInterface;
use App\Models\Payment;

class AbstractStrategyTemplate implements PaymentProviderInterface
{

    public function createPayment(PaymentDto $paymentDto): Payment
    {
        $paymentDto->status = PaymentStatusEnum::CREATED;
        return Payment::create($paymentDto->toArray());
    }
}
