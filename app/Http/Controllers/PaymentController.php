<?php

namespace App\Http\Controllers;

use App\Dto\PaymentDto;
use App\Http\Factories\PaymentProviderFactory;
use App\Http\Requests\PaymentRequest;
use App\Services\PaymentService;

class PaymentController extends Controller
{

    public function __construct(
        readonly private PaymentService $paymentService,
    )
    {
    }

    public function store(PaymentRequest $request)
    {
        try {
            $paymentDto = PaymentDto::from($request->validated());

            $paymentProvider = PaymentProviderFactory::handle($paymentDto->provider->value);

            $service = $this->paymentService->create($paymentProvider, $paymentDto);

            return response()->json($service->makeHidden([
                'updated_at',
                'created_at',
            ])->toArray(), 201);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function getById(int $id)
    {
        $service = $this->paymentService->getById($id);

        return response()->json($service?->toArray(), 200);
    }
}
