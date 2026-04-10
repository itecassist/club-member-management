<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Repositories\PermissionRepository;
use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\DTOs\PermissionData;
use App\Domains\Auth\Events\PermissionCreated;

class CreatePermission
{
    public function __construct(protected PermissionRepository $repo) {}

    public function execute(PermissionData $data): Permission
    {
        $model = $this->repo->create($data);
        event(new PermissionCreated($model->id));
        return $model;
    }
}