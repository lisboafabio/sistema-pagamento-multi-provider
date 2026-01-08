<?php

namespace App\Http\Controllers;

use App\Services\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutWebhookController extends Controller
{
    public function __construct(
        private readonly WebhookService $webhookService
    ) {}

    public function handle(Request $request)
    {
        try {
            $this->webhookService->handle($request->toArray());

            return response()->json(['response' => 'ok']);
        } catch (\Exception|\InvalidArgumentException $exception) {
            Log::error('Webhook: '.$exception->getMessage());

            return response()->json(['response' => 'ok']);
        }

    }
}
