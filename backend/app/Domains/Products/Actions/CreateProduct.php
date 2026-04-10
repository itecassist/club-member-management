<?php

namespace App\Domains\Products\Actions;

use App\Domains\Products\Repositories\ProductRepository;
use App\Domains\Products\Models\Product;
use App\Domains\Products\DTOs\ProductData;
use App\Domains\Products\Events\ProductCreated;

class CreateProduct
{
    public function __construct(protected ProductRepository $repo) {}

    public function execute(ProductData $data): Product
    {
        $model = $this->repo->create($data);
        event(new ProductCreated($model->id, $model->organisation_id));
        return $model;
    }
}