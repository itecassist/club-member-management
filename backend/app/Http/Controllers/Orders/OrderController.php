<?php

namespace App\Http\Controllers\Orders;

use App\Domains\Orders\Actions\CreateOrder;
use App\Domains\Orders\Actions\DeleteOrder;
use App\Domains\Orders\Actions\UpdateOrder;
use App\Domains\Orders\DTOs\OrderData;
use App\Domains\Orders\Repositories\OrderRepository;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Http\JsonResponse;

class OrderController
{
    public function __construct(
        protected OrderRepository $repo,
        protected CreateOrder $create,
        protected UpdateOrder $update,
        protected DeleteOrder $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreOrderRequest $r): JsonResponse
    {
        $model = $this->create->execute(OrderData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateOrderRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            OrderData::fromArray($r->validated()),
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