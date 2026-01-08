<?php

namespace App\Interfaces;

use App\Dto\PaymentDto;
use App\Models\Payment;

interface PaymentProviderInterface
{
    public function createPayment(PaymentDto $paymentDto): Payment;
}
