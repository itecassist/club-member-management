<?php

namespace App\Http\Controllers\Members;

use App\Domains\Members\Actions\CreateMember;
use App\Domains\Members\Actions\DeleteMember;
use App\Domains\Members\Actions\UpdateMember;
use App\Domains\Members\DTOs\MemberData;
use App\Domains\Members\Repositories\MemberRepository;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use Illuminate\Http\JsonResponse;

class MemberController
{
    public function __construct(
        protected MemberRepository $repo,
        protected CreateMember $create,
        protected UpdateMember $update,
        protected DeleteMember $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreMemberRequest $r): JsonResponse
    {
        $model = $this->create->execute(MemberData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateMemberRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            MemberData::fromArray($r->validated()),
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
