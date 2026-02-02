<?php
namespace App\Http\Controllers\Subscriptions;

use App\Domains\Subscriptions\Repositories\SubscriptionRepository;
use App\Domains\Subscriptions\Actions\CreateSubscription;
use App\Domains\Subscriptions\Actions\UpdateSubscription;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;

class SubscriptionController {
    public function __construct(
        protected SubscriptionRepository $repo,
        protected CreateSubscription $create,
        protected UpdateSubscription $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreSubscriptionRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateSubscriptionRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}