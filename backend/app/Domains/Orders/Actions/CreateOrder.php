<?php

namespace App\Domains\Orders\Actions;

use App\Domains\Orders\Repositories\OrderRepository;
use App\Domains\Orders\Models\Order;
use App\Domains\Orders\DTOs\OrderData;
use App\Domains\Orders\Events\OrderCreated;

class CreateOrder
{
    public function __construct(protected OrderRepository $repo) {}

    public function execute(OrderData $data): Order
    {
        $model = $this->repo->create($data);
        event(new OrderCreated($model->id, $model->organisation_id));
        return $model;
    }
}