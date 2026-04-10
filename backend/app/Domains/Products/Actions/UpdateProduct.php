<?php

namespace App\Domains\Products\Actions;

use App\Domains\Products\Repositories\ProductRepository;
use App\Domains\Products\Models\Product;
use App\Domains\Products\DTOs\ProductData;

class UpdateProduct
{
    public function __construct(protected ProductRepository $repo) {}

    public function execute(ProductData $data, Product $model): Product
    {
        return $this->repo->update($model, $data);
    }
}