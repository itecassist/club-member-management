<?php

namespace App\Domains\Auth\Repositories;

use App\Domains\Auth\Models\Permission;

class PermissionRepository
{
    public function create(array $data): Permission
    {
        return Permission::create($data);
    }

    public function update(Permission $model, array $data): Permission
    {
        $model->update($data);
        return $model;
    }

    public function find(int $id): ?Permission
    {
        return Permission::find($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Permission::paginate($perPage);
    }
}