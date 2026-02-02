<?php

namespace App\Domains\Orders\Repositories;

use App\Domains\Orders\Models\Order;

class OrderRepository
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function update(Order $model, array $data): Order
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Order
    {
        return Order::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Order::paginate($perPage);
    }
}