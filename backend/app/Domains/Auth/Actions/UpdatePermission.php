<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Repositories\PermissionRepository;
use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\DTOs\PermissionData;

class UpdatePermission
{
    public function __construct(protected PermissionRepository $repo) {}

    public function execute(PermissionData $data, Permission $model): Permission
    {
        return $this->repo->update($model, $data);
    }
}