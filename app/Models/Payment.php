<?php

namespace App\Models;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentProviderEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'provider',
        'status',
        'method',
        'amount',
    ];

    protected $casts =
        [
            'provider' => PaymentProviderEnum::class,
            'status' => PaymentStatusEnum::class,
            'method' => PaymentMethodEnum::class,
        ];
}
