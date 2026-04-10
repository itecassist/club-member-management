<?php

namespace App\Domains\Subscriptions\Repositories;

use App\Domains\Subscriptions\Models\Subscription;
use App\Domains\Subscriptions\DTOs\SubscriptionData;

class SubscriptionRepository
{
    public function create(SubscriptionData $data): Subscription
    {
        return Subscription::create($data->toArray());
    }

    public function update(Subscription $model, SubscriptionData $data): Subscription
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Subscription
    {
        return Subscription::find($id);
    }

    public function findOrFail(int $id): Subscription
    {
        return Subscription::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Subscription::paginate($perPage);
    }

    public function delete(Subscription $model): void
    {
        $model->delete();
    }
}