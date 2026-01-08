<?php

namespace App\Listeners;

use App\Enums\PaymentStatusEnum;
use App\Events\AuthorizedPaymentEvent;
use App\Models\Balance;
use App\Models\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class AuthorizedPaymentListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AuthorizedPaymentEvent $event): void
    {
        DB::transaction(function () use ($event) {
            $payment = Payment::where('id', $event->webhookDto->id)
                ->lockForUpdate()
                ->first();
            $payment->status = PaymentStatusEnum::AUTHORIZED;
            $payment->save();

            $balance = Balance::where('id', 1)
                ->lockForUpdate()
                ->first();

            $balance->amount += $payment->amount;
            $balance->save();
        });

    }
}
