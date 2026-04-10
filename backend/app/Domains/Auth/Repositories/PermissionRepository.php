<?php

namespace App\Domains\Auth\Repositories;

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\DTOs\PermissionData;

class PermissionRepository
{
    public function create(PermissionData $data): Permission
    {
        return Permission::create($data->toArray());
    }

    public function update(Permission $model, PermissionData $data): Permission
    {
        $model->update($data->toArray());
        return $model;
    }

    public function find(int $id): ?Permission
    {
        return Permission::find($id);
    }

    public function findOrFail(int $id): Permission
    {
        return Permission::findOrFail($id);
    }

    public function paginate(int $perPage = 15)
    {
        return Permission::paginate($perPage);
    }

    public function delete(Permission $model): void
    {
        $model->delete();
    }
}