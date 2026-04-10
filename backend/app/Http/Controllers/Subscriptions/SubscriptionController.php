<?php

namespace App\Http\Controllers\Subscriptions;

use App\Domains\Subscriptions\Actions\CreateSubscription;
use App\Domains\Subscriptions\Actions\DeleteSubscription;
use App\Domains\Subscriptions\Actions\UpdateSubscription;
use App\Domains\Subscriptions\DTOs\SubscriptionData;
use App\Domains\Subscriptions\Repositories\SubscriptionRepository;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use Illuminate\Http\JsonResponse;

class SubscriptionController
{
    public function __construct(
        protected SubscriptionRepository $repo,
        protected CreateSubscription $create,
        protected UpdateSubscription $update,
        protected DeleteSubscription $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreSubscriptionRequest $r): JsonResponse
    {
        $model = $this->create->execute(SubscriptionData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateSubscriptionRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            SubscriptionData::fromArray($r->validated()),
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