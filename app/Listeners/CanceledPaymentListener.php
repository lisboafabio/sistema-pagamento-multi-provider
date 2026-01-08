<?php

namespace App\Listeners;

use App\Enums\PaymentStatusEnum;
use App\Events\CanceledPaymentEvent;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class CanceledPaymentListener
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
    public function handle(CanceledPaymentEvent $event): void
    {

        DB::transaction(function () use ($event) {
            $payment = Payment::where('id', $event->webhookDto->id)
                ->lockForUpdate()
                ->first();

            if ($payment->status->isAuthorized()) {
                return;
            }

            $payment->status = PaymentStatusEnum::CANCELED;
            $payment->save();
        });
    }
}
