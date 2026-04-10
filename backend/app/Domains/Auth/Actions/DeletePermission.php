<?php

namespace App\Domains\Auth\Actions;

use App\Domains\Auth\Repositories\PermissionRepository;
use App\Domains\Auth\Models\Permission;

class DeletePermission
{
    public function __construct(protected PermissionRepository $repo) {}

    public function execute(Permission $model): void
    {
        $this->repo->delete($model);
    }
}