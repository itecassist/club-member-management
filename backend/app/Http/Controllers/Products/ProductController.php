<?php

namespace App\Http\Controllers\Products;

use App\Domains\Products\Actions\CreateProduct;
use App\Domains\Products\Actions\DeleteProduct;
use App\Domains\Products\Actions\UpdateProduct;
use App\Domains\Products\DTOs\ProductData;
use App\Domains\Products\Repositories\ProductRepository;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\JsonResponse;

class ProductController
{
    public function __construct(
        protected ProductRepository $repo,
        protected CreateProduct $create,
        protected UpdateProduct $update,
        protected DeleteProduct $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreProductRequest $r): JsonResponse
    {
        $model = $this->create->execute(ProductData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateProductRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            ProductData::fromArray($r->validated()),
            $this->repo->findOrFail($id)
        );
        return response()->json($model);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->delete->execute($this->repo->findOrFail($id));
        return response()->json(null, 204);
    }
}