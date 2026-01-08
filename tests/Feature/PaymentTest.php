<?php

namespace Tests\Feature;

use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentProviderEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public static function successPaymentProvider()
    {
        return [
            'CheckoutA data' => [
                [
                    'provider' => PaymentProviderEnum::CHECKOUT_B->value,
                    'method' => PaymentMethodEnum::CREDIT_CARD->value,
                    'amount' => 100_00,
                ],
                PaymentStatusEnum::CREATED->value,
            ],
            'CheckoutB data' => [
                [
                    'provider' => PaymentProviderEnum::CHECKOUT_A->value,
                    'method' => PaymentMethodEnum::PIX->value,
                    'amount' => 100_00,
                ],
                PaymentStatusEnum::CREATED->value,
            ],
        ];
    }

    public static function failPaymentProvider()
    {
        return [
            [
                [
                    'provider' => fake()->word(),
                    'method' => PaymentMethodEnum::CREDIT_CARD->value,
                    'amount' => 100_00,
                ],
            ],
            [
                [
                    'provider' => PaymentProviderEnum::CHECKOUT_A->value,
                    'method' => fake()->word(),
                    'amount' => 100_00,
                ],
            ],
            [
                [
                    'provider' => PaymentProviderEnum::CHECKOUT_A->value,
                    'method' => PaymentMethodEnum::PIX->value,
                    'amount' => null,
                ],
            ],
        ];
    }

    #[DataProvider('successPaymentProvider')]
    public function test_store_payment($paymentData, $expectedStatus): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/api/payment', $paymentData)
            ->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'provider',
                'status',
                'method',
                'amount',
            ])
            ->assertJsonFragment(['status' => $expectedStatus]);
    }

    #[DataProvider('failPaymentProvider')]
    public function test_fail_payment($paymentData): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/api/payment', $paymentData)
            ->assertStatus(302);
    }
}
