<?php
namespace App\Http\Controllers\Products;

use App\Domains\Products\Repositories\ProductRepository;
use App\Domains\Products\Actions\CreateProduct;
use App\Domains\Products\Actions\UpdateProduct;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController {
    public function __construct(
        protected ProductRepository $repo,
        protected CreateProduct $create,
        protected UpdateProduct $update
    ) {}
    public function index()
    {
        return response()->json($this->repo->paginate());
    }
    public function store(StoreProductRequest $r) {
        return $this->create->execute($r->validated());
    }

    public function update(UpdateProductRequest $r, $id) {
        return $this->update->execute($r->validated(), $this->repo->find($id));
    }
}