<?php

namespace App\Domains\Products\Repositories;

use App\Domains\Products\Models\Product;
use App\Domains\Products\DTOs\ProductData;

class ProductRepository
{
    public function create(ProductData $data): Product
    {
        return Product::create($data->toArray());
    }

    public function update(Product $model, ProductData $data): Product
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    public function findOrFail(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Product::paginate($perPage);
    }

    public function delete(Product $model): void
    {
        $model->delete();
    }
}