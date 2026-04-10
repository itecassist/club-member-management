<?php

namespace App\Domains\Subscriptions\Actions;

use App\Domains\Subscriptions\Repositories\SubscriptionRepository;
use App\Domains\Subscriptions\Models\Subscription;
use App\Domains\Subscriptions\DTOs\SubscriptionData;

class UpdateSubscription
{
    public function __construct(protected SubscriptionRepository $repo) {}

    public function execute(SubscriptionData $data, Subscription $model): Subscription
    {
        return $this->repo->update($model, $data);
    }
}