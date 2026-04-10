<?php

namespace App\Domains\Products\Actions;

use App\Domains\Products\Repositories\ProductRepository;
use App\Domains\Products\Models\Product;

class DeleteProduct
{
    public function __construct(protected ProductRepository $repo) {}

    public function execute(Product $model): void
    {
        $this->repo->delete($model);
    }
}