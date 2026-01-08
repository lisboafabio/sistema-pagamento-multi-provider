<?php

namespace App\Listeners;

use App\Enums\PaymentStatusEnum;
use App\Events\RefusedPaymentEvent;
use App\Models\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class RefusedPaymentListener
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
    public function handle(RefusedPaymentEvent $event): void
    {

        DB::transaction(function () use ($event) {
            $payment = Payment::where('id', $event->webhookDto->id)
                ->lockForUpdate()
                ->first();

            if ($payment->status->isAuthorized()) {
                return;
            }

            $payment->status = PaymentStatusEnum::REFUSED;
            $payment->save();
        });
    }
}
