<?php

namespace App\Listeners;

use App\Enums\PaymentStatusEnum;
use App\Events\RefundedPaymentEvent;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class RefundedPaymentListener
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
    public function handle(RefundedPaymentEvent $event): void
    {

        DB::transaction(function () use ($event) {
            $payment = Payment::where('id', $event->webhookDto->id)
                ->lockForUpdate()
                ->first();

            if ($payment->status->isAuthorized()) {
                return;
            }

            $payment->status = PaymentStatusEnum::REFUNDED;
            $payment->save();
        });
    }
}
