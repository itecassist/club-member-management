<?php

namespace App\Domains\Auth\Repositories;

use App\Domains\Auth\Models\Role;

class RoleRepository
{
    public function create(array $data): Role
    {
        return Role::create($data);
    }

    public function update(Role $model, array $data): Role
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Role
    {
        return Role::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Role::paginate($perPage);
    }
}