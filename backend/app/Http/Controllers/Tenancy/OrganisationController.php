<?php

namespace App\Http\Controllers\Tenancy;

use App\Domains\Tenancy\Actions\CreateOrganisation;
use App\Domains\Tenancy\Actions\DeleteOrganisation;
use App\Domains\Tenancy\Actions\UpdateOrganisation;
use App\Domains\Tenancy\DTOs\OrganisationData;
use App\Domains\Tenancy\Repositories\OrganisationRepository;
use App\Http\Requests\StoreOrganisationRequest;
use App\Http\Requests\UpdateOrganisationRequest;
use Illuminate\Http\JsonResponse;

class OrganisationController
{
    public function __construct(
        protected OrganisationRepository $repo,
        protected CreateOrganisation $create,
        protected UpdateOrganisation $update,
        protected DeleteOrganisation $delete,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json($this->repo->paginate());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->repo->findOrFail($id));
    }

    public function store(StoreOrganisationRequest $r): JsonResponse
    {
        $model = $this->create->execute(OrganisationData::fromArray($r->validated()));
        return response()->json($model, 201);
    }

    public function update(UpdateOrganisationRequest $r, int $id): JsonResponse
    {
        $model = $this->update->execute(
            OrganisationData::fromArray($r->validated()),
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