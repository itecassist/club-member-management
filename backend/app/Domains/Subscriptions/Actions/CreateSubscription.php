<?php

namespace App\Domains\Subscriptions\Actions;

use App\Domains\Subscriptions\Repositories\SubscriptionRepository;
use App\Domains\Subscriptions\Models\Subscription;
use App\Domains\Subscriptions\DTOs\SubscriptionData;
use App\Domains\Subscriptions\Events\SubscriptionCreated;

class CreateSubscription
{
    public function __construct(protected SubscriptionRepository $repo) {}

    public function execute(SubscriptionData $data): Subscription
    {
        $model = $this->repo->create($data);
        event(new SubscriptionCreated($model->id, $model->organisation_id));
        return $model;
    }
}