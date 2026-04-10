<?php

namespace App\Http\Controllers\Forms;

use App\Domains\Forms\Actions\CreateVirtualForm;
use App\Domains\Forms\Actions\DeleteVirtualForm;
use App\Domains\Forms\Actions\UpdateVirtualForm;
use App\Domains\Forms\DTOs\VirtualFormData;
use App\Domains\Forms\Repositories\VirtualFormRepository;
use App\Http\Requests\StoreVirtualFormRequest;
use App\Http\Requests\UpdateVirtualFormRequest;
use Illuminate\Http\JsonResponse;

class VirtualFormController
{
    public function __construct(
        protected VirtualFormRepository $repo,
        protected CreateVirtualForm $create,
        protected UpdateVirtualForm $update,
        protected DeleteVirtualForm $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreVirtualFormRequest $r): JsonResponse
    {
        $model = $this->create->execute(VirtualFormData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateVirtualFormRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            VirtualFormData::fromArray($r->validated()),
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