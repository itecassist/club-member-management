<?php

namespace App\Http\Controllers\Groups;

use App\Domains\Groups\Actions\CreateGroup;
use App\Domains\Groups\Actions\DeleteGroup;
use App\Domains\Groups\Actions\UpdateGroup;
use App\Domains\Groups\DTOs\GroupData;
use App\Domains\Groups\Repositories\GroupRepository;
use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use Illuminate\Http\JsonResponse;

class GroupController
{
    public function __construct(
        protected GroupRepository $repo,
        protected CreateGroup $create,
        protected UpdateGroup $update,
        protected DeleteGroup $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreGroupRequest $r): JsonResponse
    {
        $model = $this->create->execute(GroupData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateGroupRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            GroupData::fromArray($r->validated()),
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