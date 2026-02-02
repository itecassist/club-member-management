<?php

namespace App\Domains\Subscriptions\Repositories;

use App\Domains\Subscriptions\Models\Subscription;

class SubscriptionRepository
{
    public function create(array $data): Subscription
    {
        return Subscription::create($data);
    }

    public function update(Subscription $model, array $data): Subscription
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Subscription
    {
        return Subscription::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Subscription::paginate($perPage);
    }
}