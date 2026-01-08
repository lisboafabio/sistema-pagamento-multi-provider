<?php

namespace App\Services;

use App\Dto\PaymentDto;
use App\Interfaces\PaymentProviderInterface;
use App\Models\Payment;

class PaymentService
{
    public function create(PaymentProviderInterface $paymentProvider, PaymentDto $paymentDto): Payment
    {
        return $paymentProvider->createPayment($paymentDto);
    }

    public function getById(int $id): Payment|null
    {
        return Payment::where('id', $id)->first();
    }
}
