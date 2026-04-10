<?php

namespace App\Domains\Orders\Actions;

use App\Domains\Orders\Repositories\OrderRepository;
use App\Domains\Orders\Models\Order;
use App\Domains\Orders\DTOs\OrderData;

class UpdateOrder
{
    public function __construct(protected OrderRepository $repo) {}

    public function execute(OrderData $data, Order $model): Order
    {
        return $this->repo->update($model, $data);
    }
}