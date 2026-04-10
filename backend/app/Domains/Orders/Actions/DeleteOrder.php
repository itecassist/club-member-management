<?php

namespace App\Domains\Orders\Actions;

use App\Domains\Orders\Repositories\OrderRepository;
use App\Domains\Orders\Models\Order;

class DeleteOrder
{
    public function __construct(protected OrderRepository $repo) {}

    public function execute(Order $model): void
    {
        $this->repo->delete($model);
    }
}