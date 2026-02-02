<?php
namespace App\Domains\Subscriptions\Actions;
use App\Domains\Subscriptions\Repositories\SubscriptionRepository;
use App\Domains\Subscriptions\Models\Subscription;

class UpdateSubscription {
    public function __construct(protected SubscriptionRepository $repo) {}
    public function execute(array $data, Subscription $model = null): Subscription {
        $model = $this->repo->update($model, $data);
        return $model;
    }
}