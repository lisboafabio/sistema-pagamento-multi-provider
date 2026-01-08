<?php

namespace Database\Factories;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentProviderEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function statusCreated(): self {
        return $this->state(function (array $attributes) {
            return [
                'provider' => PaymentProviderEnum::CHECKOUT_A,
                'status' => PaymentStatusEnum::CREATED,
                'method' => PaymentMethodEnum::CREDIT_CARD,
                'amount' => 1000_00
            ];
        });
    }
}
