<?php

namespace App\Domains\Orders\Repositories;

use App\Domains\Orders\Models\Order;
use App\Domains\Orders\DTOs\OrderData;

class OrderRepository
{
    public function create(OrderData $data): Order
    {
        return Order::create($data->toArray());
    }

    public function update(Order $model, OrderData $data): Order
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Order
    {
        return Order::find($id);
    }

    public function findOrFail(int $id): Order
    {
        return Order::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Order::paginate($perPage);
    }

    public function delete(Order $model): void
    {
        $model->delete();
    }
}