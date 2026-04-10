<?php

namespace App\Domains\Tenancy\Repositories;

use App\Domains\Tenancy\Models\Organisation;
use App\Domains\Tenancy\DTOs\OrganisationData;

class OrganisationRepository
{
    public function create(OrganisationData $data): Organisation
    {
        return Organisation::create($data->toArray());
    }

    public function update(Organisation $model, OrganisationData $data): Organisation
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Organisation
    {
        return Organisation::find($id);
    }

    public function findOrFail(int $id): Organisation
    {
        return Organisation::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Organisation::paginate($perPage);
    }

    public function delete(Organisation $model): void
    {
        $model->delete();
    }
}