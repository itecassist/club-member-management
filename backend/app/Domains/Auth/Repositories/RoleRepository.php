<?php

namespace App\Domains\Auth\Repositories;

use App\Domains\Auth\Models\Role;
use App\Domains\Auth\DTOs\RoleData;

class RoleRepository
{
    public function create(RoleData $data): Role
    {
        return Role::create($data->toArray());
    }

    public function update(Role $model, RoleData $data): Role
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Role
    {
        return Role::find($id);
    }

    public function findOrFail(int $id): Role
    {
        return Role::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Role::paginate($perPage);
    }

    public function delete(Role $model): void
    {
        $model->delete();
    }
}