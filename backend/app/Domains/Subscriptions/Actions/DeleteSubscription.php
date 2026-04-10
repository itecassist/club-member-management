<?php

namespace App\Domains\Subscriptions\Actions;

use App\Domains\Subscriptions\Repositories\SubscriptionRepository;
use App\Domains\Subscriptions\Models\Subscription;

class DeleteSubscription
{
    public function __construct(protected SubscriptionRepository $repo) {}

    public function execute(Subscription $model): void
    {
        $this->repo->delete($model);
    }
}