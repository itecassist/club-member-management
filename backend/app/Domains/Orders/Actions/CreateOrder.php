<?php
namespace App\Domains\Orders\Actions;
use App\Domains\Orders\Repositories\OrderRepository;
use App\Domains\Orders\Models\Order;

class CreateOrder {
    public function __construct(protected OrderRepository $repo) {}
    public function execute(array $data, Order $model = null): Order {
        $model = $this->repo->create($data);
        return $model;
    }
}