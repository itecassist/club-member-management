<?php
namespace App\Domains\Orders\Actions;
use App\Domains\Orders\Repositories\OrderRepository;
use App\Domains\Orders\Models\Order;

class UpdateOrder {
    public function __construct(protected OrderRepository $repo) {}
    public function execute(array $data, Order $model = null): Order {
        $model = $this->repo->update($model, $data);
        return $model;
    }
}