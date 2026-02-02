<?php
namespace App\Domains\Products\Actions;
use App\Domains\Products\Repositories\ProductRepository;
use App\Domains\Products\Models\Product;

class UpdateProduct {
    public function __construct(protected ProductRepository $repo) {}
    public function execute(array $data, Product $model = null): Product {
        $model = $this->repo->update($model, $data);
        return $model;
    }
}