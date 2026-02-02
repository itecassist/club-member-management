<?php

namespace App\Domains\Tenancy\Repositories;

use App\Domains\Tenancy\Models\Organisation;

class OrganisationRepository
{
    public function create(array $data): Organisation
    {
        return Organisation::create($data);
    }

    public function update(Organisation $model, array $data): Organisation
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Organisation
    {
        return Organisation::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Organisation::paginate($perPage);
    }
}