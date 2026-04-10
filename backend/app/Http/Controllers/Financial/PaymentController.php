<?php

namespace App\Http\Controllers\Financial;

use App\Domains\Financial\Actions\CreatePayment;
use App\Domains\Financial\Actions\DeletePayment;
use App\Domains\Financial\Actions\UpdatePayment;
use App\Domains\Financial\DTOs\PaymentData;
use App\Domains\Financial\Repositories\PaymentRepository;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use Illuminate\Http\JsonResponse;

class PaymentController
{
    public function __construct(
        protected PaymentRepository $repo,
        protected CreatePayment $create,
        protected UpdatePayment $update,
        protected DeletePayment $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StorePaymentRequest $r): JsonResponse
    {
        $model = $this->create->execute(PaymentData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdatePaymentRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            PaymentData::fromArray($r->validated()),
            $this->repo->findOrFail($id)
        );
        return response()->json($model);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->delete->execute($this->repo->findOrFail($id));
        return response()->json(null, 204);
    }
}