<?php
namespace App\Http\Controllers\Orders;

use App\Domains\Orders\Repositories\OrderRepository;
use App\Domains\Orders\Actions\CreateOrder;
use App\Domains\Orders\Actions\UpdateOrder;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController {
    public function __construct(
        protected OrderRepository $repo,
        protected CreateOrder $create,
        protected UpdateOrder $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreOrderRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateOrderRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}