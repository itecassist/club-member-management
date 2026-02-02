<?php

namespace App\Domains\Products\Repositories;

use App\Domains\Products\Models\Product;

class ProductRepository
{
    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $model, array $data): Product
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Product::paginate($perPage);
    }
}