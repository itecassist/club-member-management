<?php

namespace App\Http\Controllers\Auth;

use App\Domains\Auth\Actions\CreateRole;
use App\Domains\Auth\Actions\DeleteRole;
use App\Domains\Auth\Actions\UpdateRole;
use App\Domains\Auth\DTOs\RoleData;
use App\Domains\Auth\Repositories\RoleRepository;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\JsonResponse;

class RoleController
{
    public function __construct(
        protected RoleRepository $repo,
        protected CreateRole $create,
        protected UpdateRole $update,
        protected DeleteRole $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreRoleRequest $r): JsonResponse
    {
        $model = $this->create->execute(RoleData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateRoleRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            RoleData::fromArray($r->validated()),
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