<?php

namespace App\Http\Controllers\Auth;

use App\Domains\Auth\Actions\CreatePermission;
use App\Domains\Auth\Actions\DeletePermission;
use App\Domains\Auth\Actions\UpdatePermission;
use App\Domains\Auth\DTOs\PermissionData;
use App\Domains\Auth\Repositories\PermissionRepository;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use Illuminate\Http\JsonResponse;

class PermissionController
{
    public function __construct(
        protected PermissionRepository $repo,
        protected CreatePermission $create,
        protected UpdatePermission $update,
        protected DeletePermission $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StorePermissionRequest $r): JsonResponse
    {
        $model = $this->create->execute(PermissionData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdatePermissionRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            PermissionData::fromArray($r->validated()),
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