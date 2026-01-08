<?php

namespace Tests\Feature;

use App\Dto\WebhookDto;
use App\Enums\PaymentStatusEnum;
use App\Events\AuthorizedPaymentEvent;
use App\Events\RefundedPaymentEvent;
use App\Listeners\AuthorizedPaymentListener;
use App\Listeners\CanceledPaymentListener;
use App\Listeners\RefundedPaymentListener;
use App\Models\Payment;
use Database\Seeders\BalanceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class WebhookTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(BalanceSeeder::class);
    }

    public function test_authorized_webhook(): void
    {
        Event::fake();
        $payment = Payment::factory()->statusCreated()->create();

        $payload = [
            'payment_id' => $payment->id,
            'payment_status' => $payment->status->value
        ];

        $webhookDto = WebhookDto::from($payload);

        $this->post('/webhook/v1/checkout', $payload)->assertStatus(200);

        $event = new AuthorizedPaymentEvent($webhookDto);
        event($event);
        $listener = new AuthorizedPaymentListener();
        $listener->handle($event);

        Event::assertDispatched(AuthorizedPaymentEvent::class);

        $this->assertDatabaseHas('balances', [
           'amount' => $payment->amount
        ]);

        $this->assertDatabaseHas('payments', [
            'amount' => PaymentStatusEnum::AUTHORIZED->value
        ]);
    }

    public static function eventsProvider(): array
    {
        return [
            'Refused Event' => [
                '\App\Events\RefusedPaymentEvent',
                '\App\Listeners\RefusedPaymentListener',
                PaymentStatusEnum::REFUSED
            ],
            'Canceled Event' => [
                '\App\Events\CanceledPaymentEvent',
                '\App\Listeners\CanceledPaymentListener',
                PaymentStatusEnum::CANCELED
            ],
            'Refunded Event' => [
                '\App\Events\RefundedPaymentEvent',
                '\App\Listeners\RefundedPaymentListener',
                PaymentStatusEnum::REFUNDED
            ],
        ];
    }

    #[DataProvider('eventsProvider')]
    public function test_payment_events($event, $listener, $enum): void
    {
        Event::fake();
        $payment = Payment::factory()->statusCreated()->create();

        $payload = [
            'payment_id' => $payment->id,
            'payment_status' => $enum->value
        ];

        $webhookDto = WebhookDto::from($payload);

        $this->post('/webhook/v1/checkout', $payload)->assertStatus(200);

        $event = new $event($webhookDto);
        event($event);
        $listener = new $listener();
        $listener->handle($event);

        Event::assertDispatched($event::class);

        $this->assertDatabaseHas('payments', [
            'status' => $enum
        ]);

    }

}
